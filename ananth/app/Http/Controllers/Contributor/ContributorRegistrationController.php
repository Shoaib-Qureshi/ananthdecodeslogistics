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

        if (!$this->razorpayConfigured()) {
            return back()->withErrors([
                'plan' => 'Razorpay payment is not configured yet. Please contact the administrator.',
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
            'currency' => 'USD',
            'status' => 'pending',
        ]);

        $order = $this->createRazorpayOrder($payment);

        if (!$order) {
            $payment->update(['status' => 'failed']);

            return back()->withErrors([
                'plan' => 'Unable to start Razorpay checkout right now. Please try again shortly.',
            ])->withInput();
        }

        $payment = $payment->fresh();

        return view('contributor.checkout', [
            'payment' => $payment,
            'plan' => $plan,
            'checkout' => $this->buildRazorpayCheckoutPayload($payment, $plan, $order),
        ]);
    }

    public function paymentVerify(Request $request)
    {
        $request->validate([
            'payment' => 'required|integer',
            'razorpay_payment_id' => 'required|string|max:255',
            'razorpay_order_id' => 'required|string|max:255',
            'razorpay_signature' => 'required|string|max:255',
        ]);

        $payment = ContributorPayment::findOrFail($request->payment);

        if ($payment->status === 'paid' && $payment->user_id) {
            return redirect()->route('contributor.payment.success', ['payment' => $payment->id]);
        }

        if (!$payment->razorpay_order_id || $payment->razorpay_order_id !== $request->razorpay_order_id) {
            Log::warning('Razorpay order mismatch during contributor payment verification.', [
                'payment_id' => $payment->id,
                'stored_order_id' => $payment->razorpay_order_id,
                'request_order_id' => $request->razorpay_order_id,
            ]);

            return redirect()->route('contributor.payment.cancel', ['payment' => $payment->id])
                ->with('error', 'We could not verify your payment session. Please try again.');
        }

        if (!$this->isValidRazorpayPaymentSignature(
            $payment->razorpay_order_id,
            $request->razorpay_payment_id,
            $request->razorpay_signature,
            (string) config('services.razorpay.secret')
        )) {
            Log::warning('Invalid Razorpay payment signature.', [
                'payment_id' => $payment->id,
                'order_id' => $payment->razorpay_order_id,
                'payment_reference' => $request->razorpay_payment_id,
            ]);

            return redirect()->route('contributor.payment.cancel', ['payment' => $payment->id])
                ->with('error', 'Payment verification failed. If your account was charged, please contact support.');
        }

        $gatewayPayment = $this->fetchRazorpayPayment($request->razorpay_payment_id);

        if (!$gatewayPayment) {
            return redirect()->route('contributor.payment.cancel', ['payment' => $payment->id])
                ->with('error', 'We were unable to confirm your payment with Razorpay. Please contact support if the amount was debited.');
        }

        if (($gatewayPayment['order_id'] ?? null) !== $payment->razorpay_order_id) {
            Log::warning('Fetched Razorpay payment order mismatch.', [
                'payment_id' => $payment->id,
                'stored_order_id' => $payment->razorpay_order_id,
                'gateway_order_id' => $gatewayPayment['order_id'] ?? null,
                'gateway_payment_id' => $gatewayPayment['id'] ?? null,
            ]);

            return redirect()->route('contributor.payment.cancel', ['payment' => $payment->id])
                ->with('error', 'We could not match your payment to this application. Please contact support.');
        }

        if (
            (int) ($gatewayPayment['amount'] ?? 0) !== $this->amountInSubunits($payment->amount) ||
            strtoupper((string) ($gatewayPayment['currency'] ?? '')) !== strtoupper($payment->currency)
        ) {
            Log::warning('Fetched Razorpay payment amount mismatch.', [
                'payment_id' => $payment->id,
                'expected_amount' => $this->amountInSubunits($payment->amount),
                'gateway_amount' => $gatewayPayment['amount'] ?? null,
                'expected_currency' => strtoupper($payment->currency),
                'gateway_currency' => $gatewayPayment['currency'] ?? null,
            ]);

            return redirect()->route('contributor.payment.cancel', ['payment' => $payment->id])
                ->with('error', 'We could not confirm the payment amount for this application. Please contact support.');
        }

        $gatewayPayment = $this->captureRazorpayPaymentIfRequired($gatewayPayment, $payment);

        if (!$gatewayPayment || ($gatewayPayment['status'] ?? null) !== 'captured') {
            return redirect()->route('contributor.payment.cancel', ['payment' => $payment->id])
                ->with('error', 'Your payment is not marked as captured yet. Please contact support if the amount was debited.');
        }

        $payment = $this->finalizePaidContributor($payment, $gatewayPayment, $request->razorpay_signature);

        return redirect()->route('contributor.payment.success', ['payment' => $payment->id]);
    }

    public function paymentSuccess(Request $request)
    {
        $payment = ContributorPayment::find($request->get('payment'));
        abort_if(!$payment || $payment->status !== 'paid', 404);

        return view('contributor.payment-success', [
            'payment' => $payment,
            'plan' => ContributorPlans::get($payment->plan),
        ]);
    }

    public function paymentCancel(Request $request)
    {
        $payment = ContributorPayment::find($request->get('payment'));

        if ($payment && in_array($payment->status, ['pending', 'created'], true)) {
            $payment->update(['status' => 'cancelled']);
        }

        return view('contributor.payment-cancel', [
            'payment' => $payment,
            'plan' => ContributorPlans::get(optional($payment)->plan, ContributorPlans::STARTER),
        ]);
    }

    public function razorpayWebhook(Request $request)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Razorpay-Signature');
        $secret = config('services.razorpay.webhook_secret');

        if (!$secret || !$signature || !$this->isValidRazorpayWebhookSignature($payload, $signature, $secret)) {
            return response()->json(['message' => 'Invalid signature.'], 400);
        }

        $event = json_decode($payload, true);
        if (!is_array($event)) {
            return response()->json(['message' => 'Invalid payload.'], 400);
        }

        $eventName = $event['event'] ?? null;
        $gatewayPayment = $event['payload']['payment']['entity'] ?? [];
        $orderId = $gatewayPayment['order_id'] ?? ($event['payload']['order']['entity']['id'] ?? null);

        if (!$orderId || !in_array($eventName, ['payment.authorized', 'payment.captured', 'order.paid'], true)) {
            return response()->json(['received' => true]);
        }

        $payment = ContributorPayment::where('razorpay_order_id', $orderId)->first();
        if (!$payment) {
            return response()->json(['received' => true]);
        }

        if (($eventName === 'payment.authorized') && !empty($gatewayPayment)) {
            $gatewayPayment = $this->captureRazorpayPaymentIfRequired($gatewayPayment, $payment);
        }

        if (empty($gatewayPayment) && !empty($event['payload']['payment']['entity']['id'])) {
            $gatewayPayment = $this->fetchRazorpayPayment($event['payload']['payment']['entity']['id']);
        }

        if (is_array($gatewayPayment) && ($gatewayPayment['status'] ?? null) === 'captured') {
            $this->finalizePaidContributor($payment, $gatewayPayment);
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

        Password::sendResetLink(['email' => $user->email]);

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

    private function razorpayConfigured(): bool
    {
        return (bool) config('services.razorpay.key') && (bool) config('services.razorpay.secret');
    }

    private function createRazorpayOrder(ContributorPayment $payment): ?array
    {
        $response = Http::withBasicAuth(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        )->post('https://api.razorpay.com/v1/orders', [
            'amount' => $this->amountInSubunits($payment->amount),
            'currency' => strtoupper($payment->currency),
            'receipt' => 'cp_' . $payment->id,
            'notes' => [
                'payment_id' => (string) $payment->id,
                'plan' => $payment->plan,
            ],
        ]);

        if ($response->failed()) {
            Log::error('Razorpay order creation failed.', [
                'payment_id' => $payment->id,
                'response' => $response->body(),
            ]);

            return null;
        }

        $order = $response->json();

        if (empty($order['id'])) {
            Log::error('Razorpay order response missing order id.', [
                'payment_id' => $payment->id,
                'response' => $order,
            ]);

            return null;
        }

        $payment->update([
            'razorpay_order_id' => $order['id'],
            'status' => 'created',
        ]);

        return $order;
    }

    private function buildRazorpayCheckoutPayload(ContributorPayment $payment, array $plan, array $order): array
    {
        return [
            'key' => config('services.razorpay.key'),
            'amount' => (int) ($order['amount'] ?? $this->amountInSubunits($payment->amount)),
            'currency' => strtoupper($order['currency'] ?? $payment->currency),
            'name' => config('services.razorpay.company_name', config('app.name')),
            'description' => ContributorPlans::checkoutName($plan['code']),
            'image' => asset('img/site/ananth-logo.svg'),
            'order_id' => $order['id'] ?? $payment->razorpay_order_id,
            'prefill' => [
                'name' => $payment->name,
                'email' => $payment->email,
            ],
            'notes' => [
                'payment_id' => (string) $payment->id,
                'plan' => $payment->plan,
            ],
            'theme' => [
                'color' => '#3882fa',
            ],
            'retry' => [
                'enabled' => true,
            ],
        ];
    }

    private function fetchRazorpayPayment(string $paymentId): ?array
    {
        if (!$this->razorpayConfigured()) {
            return null;
        }

        $response = Http::withBasicAuth(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        )->get('https://api.razorpay.com/v1/payments/' . $paymentId);

        if ($response->failed()) {
            Log::warning('Unable to fetch Razorpay payment.', [
                'payment_reference' => $paymentId,
                'response' => $response->body(),
            ]);

            return null;
        }

        return $response->json();
    }

    private function captureRazorpayPaymentIfRequired(array $gatewayPayment, ContributorPayment $payment): ?array
    {
        $status = $gatewayPayment['status'] ?? null;

        if ($status === 'captured') {
            return $gatewayPayment;
        }

        if ($status !== 'authorized' || empty($gatewayPayment['id'])) {
            Log::warning('Razorpay payment is not capturable.', [
                'payment_id' => $payment->id,
                'gateway_payment_id' => $gatewayPayment['id'] ?? null,
                'gateway_status' => $status,
            ]);

            return null;
        }

        $capturedPayment = $this->captureRazorpayPayment((string) $gatewayPayment['id'], $payment);

        if ($capturedPayment) {
            return $capturedPayment;
        }

        return $this->fetchRazorpayPayment((string) $gatewayPayment['id']);
    }

    private function captureRazorpayPayment(string $paymentId, ContributorPayment $payment): ?array
    {
        $response = Http::withBasicAuth(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        )->post('https://api.razorpay.com/v1/payments/' . $paymentId . '/capture', [
            'amount' => $this->amountInSubunits($payment->amount),
            'currency' => strtoupper($payment->currency),
        ]);

        if ($response->failed()) {
            Log::warning('Unable to capture Razorpay payment.', [
                'payment_id' => $payment->id,
                'gateway_payment_id' => $paymentId,
                'response' => $response->body(),
            ]);

            return null;
        }

        return $response->json();
    }

    private function finalizePaidContributor(ContributorPayment $payment, array $gatewayPayment, ?string $signature = null): ContributorPayment
    {
        if ($payment->status === 'paid' && $payment->user_id) {
            $updates = [];

            if (!$payment->razorpay_payment_id && !empty($gatewayPayment['id'])) {
                $updates['razorpay_payment_id'] = $gatewayPayment['id'];
            }

            if (!$payment->razorpay_signature && $signature) {
                $updates['razorpay_signature'] = $signature;
            }

            if ($updates) {
                $payment->update($updates);
            }

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
            'razorpay_order_id' => $gatewayPayment['order_id'] ?? $payment->razorpay_order_id,
            'razorpay_payment_id' => $gatewayPayment['id'] ?? $payment->razorpay_payment_id,
            'razorpay_signature' => $signature ?: $payment->razorpay_signature,
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

    private function amountInSubunits(int $amount): int
    {
        return $amount * 100;
    }

    private function isValidRazorpayPaymentSignature(string $orderId, string $paymentId, string $signature, string $secret): bool
    {
        $expected = hash_hmac('sha256', $orderId . '|' . $paymentId, $secret);

        return hash_equals($expected, $signature);
    }

    private function isValidRazorpayWebhookSignature(string $payload, string $signature, string $secret): bool
    {
        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $signature);
    }
}
