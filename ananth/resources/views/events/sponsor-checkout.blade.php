@extends('layouts.front')

@section('styles')
@include('events.partials.styles')
@endsection

@section('content')
<main class="event-page">
    @include('events.partials.hero', [
        'eyebrow'  => 'Sponsor Checkout',
        'title'    => $package->name . ' Sponsorship',
        'subtitle' => 'Confirm organisation details before payment.',
        'showActions' => false,
    ])
    @include('events.partials.nav')

    <section class="event-section event-checkout-section">
        <div class="event-container event-checkout-layout">
            <aside class="event-card event-card--dark event-checkout-summary">
                <div class="event-eyebrow">Package Summary</div>
                <h2>{{ $package->name }}</h2>
                <p>{{ $package->description }}</p>
                <table class="event-table event-table--dark">
                    <tbody>
                        <tr>
                            <td>Base price</td>
                            <td>{{ $currency }} {{ number_format($totals['base'], 2) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $event->tax_label ?: 'GST' }} ({{ $totals['tax_percentage'] }}%)</td>
                            <td>{{ $currency }} {{ number_format($totals['tax'], 2) }}</td>
                        </tr>
                        <tr class="event-table--total">
                            <td><strong>Total payable</strong></td>
                            <td><strong>{{ $currency }} {{ number_format($totals['total'], 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
                <div class="event-checkout-note">
                    <span>Direct bank transfer</span>
                    Submit your organisation details to receive our bank account details and payment reference.
                </div>
            </aside>
            <div class="event-card event-checkout-form-card">
                <div class="event-eyebrow" style="color:#0369a1">Organisation Details</div>
                <h3 style="font-family:'Playfair Display',Georgia,serif;font-size:1.4rem;margin:0 0 20px">Complete your details</h3>
                @if($errors->any())
                    <div class="event-alert event-alert--error" role="alert">{{ $errors->first() }}</div>
                @endif
                <form class="event-form" id="checkout-form" method="POST" action="{{ route('events.sponsor.checkout.start', $package) }}" novalidate>
                    @csrf
                    <label for="co_company">Company / Organisation
                        <input id="co_company" name="company" value="{{ old('company') }}" placeholder="Your company name" required maxlength="180" autocomplete="organization">
                        <span class="field-error" id="err_company" hidden></span>
                    </label>
                    <label for="co_contact">Contact Name
                        <input id="co_contact" name="contact_name" value="{{ old('contact_name') }}" placeholder="Full name" required maxlength="160" autocomplete="name">
                        <span class="field-error" id="err_contact_name" hidden></span>
                    </label>
                    <label for="co_email">Email Address
                        <input id="co_email" type="email" name="email" value="{{ old('email') }}" placeholder="billing@company.com" required maxlength="180" autocomplete="email">
                        <span class="field-error" id="err_email" hidden></span>
                    </label>
                    @include('events.partials.phone-field', ['idPrefix' => 'co_phone', 'required' => true])
                    <label for="co_gst">GST Number
                        <input id="co_gst" name="gst_number" value="{{ old('gst_number') }}" placeholder="22AAAAA0000A1Z5" maxlength="80">
                    </label>
                    <label for="co_billing">Billing Address
                        <textarea id="co_billing" name="billing_address" placeholder="Full billing address including city and PIN" maxlength="2000">{{ old('billing_address') }}</textarea>
                    </label>
                    <button class="event-btn event-btn--primary" type="submit" id="checkout-submit" style="width:100%;justify-content:center">
                        Continue to Bank Details
                    </button>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
@include('events.partials.phone-script')
@include('events.partials.form-validation')
@endsection
