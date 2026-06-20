<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\EventRegistrationAdminNotification;
use App\Mail\EventRegistrationReceived;
use App\Mail\EventSponsorBankTransferDetails;
use App\Mail\EventSponsorPaymentAdminNotification;
use App\Models\Event;
use App\Models\EventRegistration;
use App\Models\EventSponsorPackage;
use App\Models\EventSponsorPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class EventController extends Controller
{
    public function conference()
    {
        $event = $this->event();
        return view('events.conference', $this->viewData($event) + [
            'pastEvents'     => Event::past()->filter(fn($e) => $e->id !== $event->id)->values(),
            'upcomingEvents' => Event::upcoming()->filter(fn($e) => $e->id !== $event->id)->values(),
        ]);
    }

    public function whyWho()
    {
        $event = $this->event();
        return view('events.why-who', $this->viewData($event));
    }

    public function sponsorship()
    {
        $event = $this->event();
        return view('events.sponsorship', $this->viewData($event) + [
            'packages' => $event->sponsorPackages()->where('visible', true)->get(),
            'currency' => $event->activeCurrency(),
        ]);
    }

    public function faq()
    {
        $event = $this->event();
        return view('events.faq', $this->viewData($event) + [
            'faqs' => $event->faqs()->where('visible', true)->get(),
        ]);
    }

    public function register()
    {
        $event = $this->event();
        return view('events.register', $this->viewData($event));
    }

    public function submitRegistration(Request $request)
    {
        $event = $this->event();
        $validated = $request->validate([
            'inquiry_type' => ['required', Rule::in(array_keys($event->interestOptionMap()))],
            'name' => 'required|string|max:160',
            'email' => 'required|email|max:180',
            'phone' => 'nullable|string|max:40',
            'phone_country_code' => 'nullable|string|max:8',
            'company' => 'nullable|string|max:180',
            'designation' => 'nullable|string|max:180',
            'message' => 'nullable|string|max:2500',
            'consent' => 'accepted',
        ]);

        $validated['phone'] = $this->normalizedPhone($validated['phone'] ?? null, $validated['phone_country_code'] ?? null);
        unset($validated['phone_country_code']);

        $registration = EventRegistration::create($validated + [
            'event_id' => $event->id,
            'consent' => true,
        ]);

        $this->sendMail($registration->email, new EventRegistrationReceived($registration));
        $this->sendMail(config('mail.admin_email', 'jana.ananthakrishnan@gmail.com'), new EventRegistrationAdminNotification($registration));

        return back()->with('success', 'Thanks. Your LogiSphere interest has been received.');
    }

    public function sponsorCheckout(EventSponsorPackage $package)
    {
        $event = $this->event();
        abort_if($package->event_id !== $event->id || !$package->visible, 404);

        return view('events.sponsor-checkout', $this->viewData($event) + [
            'package' => $package,
            'currency' => $event->activeCurrency(),
            'totals' => $this->totals($event, $package),
        ]);
    }

    public function startSponsorCheckout(Request $request, EventSponsorPackage $package)
    {
        $event = $this->event();
        abort_if($package->event_id !== $event->id || !$package->visible, 404);

        $validated = $request->validate([
            'company' => 'required|string|max:180',
            'contact_name' => 'required|string|max:160',
            'email' => 'required|email|max:180',
            'phone' => 'nullable|string|max:40',
            'phone_country_code' => 'nullable|string|max:8',
            'billing_address' => 'nullable|string|max:2000',
            'gst_number' => 'nullable|string|max:80',
        ]);

        $totals = $this->totals($event, $package);
        if ($totals['total'] <= 0) {
            return back()->withErrors(['payment' => 'This sponsor package does not have a payable amount in ' . $totals['currency'] . '. Please update the package price in admin.'])->withInput();
        }

        $validated['phone'] = $this->normalizedPhone($validated['phone'] ?? null, $validated['phone_country_code'] ?? null);
        unset($validated['phone_country_code']);

        $payment = EventSponsorPayment::create($validated + [
            'event_id' => $event->id,
            'sponsor_package_id' => $package->id,
            'currency' => $totals['currency'],
            'base_amount' => $totals['base'],
            'tax_amount' => $totals['tax'],
            'total_amount' => $totals['total'],
            'tax_percentage' => $totals['tax_percentage'],
            'tax_label' => $event->tax_label ?: 'GST',
            'status' => 'awaiting_transfer',
        ]);

        $payment = $payment->fresh(['event', 'package']);
        $this->sendMail($payment->email, new EventSponsorBankTransferDetails($payment));
        $this->sendMail(config('mail.admin_email', 'jana.ananthakrishnan@gmail.com'), new EventSponsorPaymentAdminNotification($payment));

        return redirect()->route('events.sponsor.success', ['payment' => $payment->id]);
    }

    public function sponsorSuccess(Request $request)
    {
        $payment = EventSponsorPayment::with('package')->findOrFail($request->payment);
        abort_if($payment->status === 'cancelled', 404);
        return view('events.sponsor-success', $this->viewData($payment->event) + [
            'payment' => $payment,
            'bank' => $this->bankDetails(),
        ]);
    }

    public function sponsorCancel(Request $request)
    {
        $payment = EventSponsorPayment::with('package', 'event')->find($request->payment);
        if ($payment && in_array($payment->status, ['pending', 'created'], true)) {
            $payment->update(['status' => 'cancelled']);
        }
        return view('events.sponsor-cancel', [
            'event' => $payment?->event ?? $this->event(),
            'payment' => $payment,
        ]);
    }

    private function event(): Event
    {
        return Event::current()->load(['agendaItems', 'faqs']);
    }

    private function viewData(Event $event): array
    {
        return [
            'event' => $event,
            'seo' => [
                'title' => $event->meta_title ?: $event->publicTitle(),
                'description' => $event->meta_description ?: $event->tagline,
                'canonical' => $event->canonical_url ?: url()->current(),
                'image' => asset('img/site-banner.jpg'),
            ],
        ];
    }

    private function totals(Event $event, EventSponsorPackage $package): array
    {
        $currency = $event->activeCurrency();
        $base = $package->priceForCurrency($currency);
        $taxPercentage = (float) ($event->tax_percentage ?? 0);
        $tax = round($base * $taxPercentage / 100, 2);
        return compact('currency', 'base', 'tax') + [
            'total' => round($base + $tax, 2),
            'tax_percentage' => $taxPercentage,
        ];
    }

    private function bankDetails(): array
    {
        return config('services.bank_transfer', []);
    }

    private function normalizedPhone(?string $phone, ?string $countryCode): ?string
    {
        $phone = trim((string) $phone);
        if ($phone === '') {
            return null;
        }

        if (str_starts_with($phone, '+')) {
            return $phone;
        }

        $countryCode = trim((string) $countryCode) ?: '+91';
        return trim($countryCode . ' ' . $phone);
    }

    private function sendMail(string $to, \Illuminate\Mail\Mailable $mailable): void
    {
        try {
            Mail::to($to)->send($mailable);
        } catch (\Throwable $exception) {
            Log::warning('Unable to send event email.', [
                'to' => $to,
                'mailable' => get_class($mailable),
                'error' => $exception->getMessage(),
            ]);
        }
    }
}
