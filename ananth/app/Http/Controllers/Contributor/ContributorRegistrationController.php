<?php

namespace App\Http\Controllers\Contributor;

use App\Http\Controllers\Controller;
use App\Mail\ContributorApproved;
use App\Mail\ContributorRejected;
use App\Models\ContributorPayment;
use App\Models\User;
use App\Support\ContributorPlans;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ContributorRegistrationController extends Controller
{
    public function showWriteForUs()
    {
        return view('front.writeForUs', [
            'plans' => ContributorPlans::publicPlans(),
        ]);
    }

    public function showForm(Request $request)
    {
        $requestedPlan = $request->query('plan');
        $defaultPlan = ContributorPlans::normalize($requestedPlan, ContributorPlans::STARTER);

        // Ensure it's a public plan
        if (!in_array($defaultPlan, ContributorPlans::publicPlanCodes(), true)) {
            $defaultPlan = ContributorPlans::STARTER;
        }

        return view('contributor.register', [
            'plans' => ContributorPlans::publicPlans(),
            'defaultPlan' => $defaultPlan,
        ]);
    }

    public function submit(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $existingUser = User::where('email', $value)->first();

                    if ($existingUser && $existingUser->user_role !== 'guest') {
                        $fail('That email is already associated with another account. Please use a different email address.');
                    }
                },
            ],
            'designation' => 'required|string|max:255',
            'intro' => 'required|string|max:1000',
            'reason_for_joining' => 'required|string|max:2000',
            'plan' => ['required', Rule::in(ContributorPlans::publicPlanCodes())],
        ]);

        if (!$this->stripeConfigured()) {
            return back()->withErrors([
                'plan' => 'Stripe payment is not configured yet. Please contact the administrator.',
            ])->withInput();
        }

        $planCode = ContributorPlans::normalize($request->plan, ContributorPlans::STARTER);
        $plan = ContributorPlans::get($planCode, ContributorPlans::STARTER);

        $payment = ContributorPayment::create([
            'name' => $request->name,
            'email' => $request->email,
            'designation' => $request->designation,
            'intro' => $request->intro,
            'reason_for_joining' => $request->reason_for_joining,
            'plan' => $planCode,
            'amount' => $plan['price_usd'],
            'currency' => 'usd',
            'status' => 'pending',
        ]);

        $checkoutUrl = $this->createStripeCheckoutSession($payment);

        if (!$checkoutUrl) {
            $payment->update(['status' => 'failed']);

            return back()->withErrors([
                'plan' => 'Unable to start Stripe checkout right now. Please try again shortly.',
            ])->withInput();
        }

        return redirect()->away($checkoutUrl);
    }

    public function paymentSuccess(Request $request)
    {
        $sessionId = $request->get('session_id');
        abort_if(!$sessionId, 404);

        $session = $this->fetchStripeCheckoutSession($sessionId);
        abort_if(!$session, 404);

        $payment = ContributorPayment::where('stripe_checkout_session_id', $sessionId)->first();
        abort_if(!$payment, 404);

        if (($session['payment_status'] ?? null) === 'paid') {
            $payment = $this->finalizePaidContributor($payment, $session);
        }

        return view('contributor.payment-success', [
            'payment' => $payment,
            'plan' => ContributorPlans::get($payment->plan),
        ]);
    }

    public function paymentCancel(Request $request)
    {
        $payment = ContributorPayment::find($request->get('payment'));

        if ($payment && $payment->status === 'pending') {
            $payment->update(['status' => 'cancelled']);
        }

        return view('contributor.payment-cancel', [
            'payment' => $payment,
            'plan' => ContributorPlans::get(optional($payment)->plan, ContributorPlans::STARTER),
        ]);
    }

    public function stripeWebhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        if (!$secret || !$signature || !$this->isValidStripeSignature($payload, $signature, $secret)) {
            return response()->json(['message' => 'Invalid signature.'], 400);
        }

        $event = json_decode($payload, true);
        if (!is_array($event)) {
            return response()->json(['message' => 'Invalid payload.'], 400);
        }

        if (($event['type'] ?? null) === 'checkout.session.completed') {
            $session = $event['data']['object'] ?? [];
            $sessionId = $session['id'] ?? null;

            if ($sessionId) {
                $payment = ContributorPayment::where('stripe_checkout_session_id', $sessionId)->first();
                if ($payment) {
                    $this->finalizePaidContributor($payment, $session);
                }
            }
        }

        return response()->json(['received' => true]);
    }

    public function approve(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $planCode = ContributorPlans::normalize($user->contributor_plan, ContributorPlans::FREE);

        $user->update([
            'status' => 'approved',
            'contributor_plan' => $planCode,
            'payment_status' => $user->payment_status ?: ($planCode === ContributorPlans::FREE ? 'complimentary' : 'paid'),
        ]);

        $status = Password::sendResetLink(['email' => $user->email]);

        try {
            Mail::to($user->email)->send(new ContributorApproved($user));
        } catch (\Exception $e) {
            //
        }

        return redirect()->back()->with('success', "Contributor {$user->name} approved. Password reset email sent.");
    }

    public function reject(Request $request, $id)
    {
        $request->validate(['rejection_reason' => 'required|string|max:1000']);

        $user = User::findOrFail($id);
        $user->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        try {
            Mail::to($user->email)->send(new ContributorRejected($user));
        } catch (\Exception $e) {
            //
        }

        return redirect()->back()->with('success', "Contributor {$user->name} rejected.");
    }

    private function stripeConfigured(): bool
    {
        return (bool) config('services.stripe.secret');
    }

    private function createStripeCheckoutSession(ContributorPayment $payment): ?string
    {
        $plan = ContributorPlans::get($payment->plan, ContributorPlans::STARTER);

        $response = Http::withToken(config('services.stripe.secret'))
            ->asForm()
            ->post('https://api.stripe.com/v1/checkout/sessions', [
                'mode' => 'payment',
                'success_url' => route('contributor.payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('contributor.payment.cancel') . '?payment=' . $payment->id,
                'customer_email' => $payment->email,
                'metadata[payment_id]' => $payment->id,
                'payment_method_types[0]' => 'card',
                'line_items[0][price_data][currency]' => $payment->currency,
                'line_items[0][price_data][unit_amount]' => $payment->amount * 100,
                'line_items[0][price_data][product_data][name]' => ContributorPlans::stripeName($plan['code']),
                'line_items[0][price_data][product_data][description]' => ContributorPlans::stripeDescription($plan['code']),
                'line_items[0][quantity]' => 1,
            ]);

        if ($response->failed()) {
            Log::error('Stripe checkout session creation failed.', [
                'payment_id' => $payment->id,
                'response' => $response->body(),
            ]);

            return null;
        }

        $session = $response->json();
        $payment->update([
            'stripe_checkout_session_id' => $session['id'] ?? null,
            'status' => 'created',
        ]);

        return $session['url'] ?? null;
    }

    private function fetchStripeCheckoutSession(string $sessionId): ?array
    {
        if (!$this->stripeConfigured()) {
            return null;
        }

        $response = Http::withToken(config('services.stripe.secret'))
            ->get('https://api.stripe.com/v1/checkout/sessions/' . $sessionId);

        if ($response->failed()) {
            Log::warning('Unable to fetch Stripe checkout session.', [
                'session_id' => $sessionId,
                'response' => $response->body(),
            ]);

            return null;
        }

        return $response->json();
    }

    private function finalizePaidContributor(ContributorPayment $payment, array $session): ContributorPayment
    {
        if ($payment->status === 'paid' && $payment->user_id) {
            return $payment->fresh();
        }

        $planCode = ContributorPlans::normalize($payment->plan, ContributorPlans::STARTER);
        $payment->plan = $planCode;

        $user = $payment->user_id ? User::find($payment->user_id) : User::where('email', $payment->email)->first();

        if (!$user) {
            $user = User::create([
                'name' => $payment->name,
                'email' => $payment->email,
                'username' => $this->generateUniqueUsername(Str::slug($payment->name)),
                'password' => bcrypt(Str::random(32)),
                'user_role' => 'guest',
                'status' => 'approved',
                'contributor_plan' => $planCode,
                'payment_status' => 'paid',
                'stripe_customer_id' => $session['customer'] ?? null,
                'activated_at' => now(),
                'designation' => $payment->designation,
                'intro' => $payment->intro,
                'reason_for_joining' => $payment->reason_for_joining,
            ]);
        } else {
            $user->update([
                'status' => 'approved',
                'contributor_plan' => $planCode,
                'payment_status' => 'paid',
                'stripe_customer_id' => $session['customer'] ?? $user->stripe_customer_id,
                'activated_at' => now(),
                'designation' => $payment->designation ?: $user->designation,
                'intro' => $payment->intro ?: $user->intro,
                'reason_for_joining' => $payment->reason_for_joining ?: $user->reason_for_joining,
            ]);
        }

        $payment->update([
            'user_id' => $user->id,
            'plan' => $planCode,
            'status' => 'paid',
            'stripe_payment_intent_id' => $session['payment_intent'] ?? $payment->stripe_payment_intent_id,
            'stripe_customer_id' => $session['customer'] ?? $payment->stripe_customer_id,
            'activated_at' => now(),
        ]);

        $this->sendContributorAccessEmails($user);

        return $payment->fresh();
    }

    private function sendContributorAccessEmails(User $user): void
    {
        try {
            Password::sendResetLink(['email' => $user->email]);
            Mail::to($user->email)->send(new ContributorApproved($user));
        } catch (\Throwable $exception) {
            Log::warning('Failed sending contributor access email.', [
                'user_id' => $user->id,
                'error' => $exception->getMessage(),
            ]);
        }
    }

    private function generateUniqueUsername(string $baseUsername): string
    {
        $username = $baseUsername ?: 'contributor';
        $counter = 1;

        while (User::where('username', $username)->exists()) {
            $username = ($baseUsername ?: 'contributor') . $counter;
            $counter++;
        }

        return $username;
    }

    private function isValidStripeSignature(string $payload, string $signatureHeader, string $secret): bool
    {
        $parts = [];
        foreach (explode(',', $signatureHeader) as $segment) {
            [$key, $value] = array_pad(explode('=', $segment, 2), 2, null);
            if ($key && $value) {
                $parts[trim($key)][] = trim($value);
            }
        }

        $timestamp = $parts['t'][0] ?? null;
        $signatures = $parts['v1'] ?? [];

        if (!$timestamp || empty($signatures)) {
            return false;
        }

        $signedPayload = $timestamp . '.' . $payload;
        $expected = hash_hmac('sha256', $signedPayload, $secret);

        foreach ($signatures as $signature) {
            if (hash_equals($expected, $signature)) {
                return true;
            }
        }

        return false;
    }
}
