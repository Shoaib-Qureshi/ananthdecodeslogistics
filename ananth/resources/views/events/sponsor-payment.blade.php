@extends('layouts.front')

@section('styles')
@include('events.partials.styles')
@endsection

@section('content')
<main class="event-page">
    @include('events.partials.hero', [
        'eyebrow'  => 'Secure Payment',
        'title'    => 'Complete Your Payment',
        'subtitle' => 'One step away from confirming your ' . $package->name . ' sponsorship.',
        'showActions' => false,
    ])
    @include('events.partials.nav')

    <section class="event-section event-payment-section">
        <div class="event-container event-payment-layout">
            <aside class="event-card event-card--dark event-checkout-summary">
                <div class="event-eyebrow">Order Summary</div>
                <h2>{{ $package->name }}</h2>
                <p>{{ $payment->company }}</p>
                <table class="event-table event-table--dark">
                    <tbody>
                        <tr class="event-table--total">
                            <td><strong>Total</strong></td>
                            <td><strong>{{ $payment->currency }} {{ number_format($payment->total_amount, 2) }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </aside>
            <div class="event-card event-status-card event-payment-card" style="text-align:center;max-width:100%">
                <div class="event-status-icon event-status-icon--payment" style="margin-bottom:20px">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z"/>
                    </svg>
                </div>
                <h2 style="font-family:'Playfair Display',Georgia,serif;font-size:1.5rem;margin:0 0 8px">{{ $payment->currency }} {{ number_format($payment->total_amount, 2) }}</h2>
                <p id="payment-status-copy" style="color:#64748b;margin:0 0 24px;font-size:.95rem">Opening the secure Razorpay payment window...</p>

                <div id="payment-fallback-actions" class="event-actions" style="justify-content:center;margin-top:0" hidden>
                    <button id="sponsor-pay-btn" class="event-btn event-btn--primary" type="button">Retry Payment</button>
                    <a class="event-btn event-btn--light" href="{{ route('events.register', ['type' => 'sponsor']) }}">Contact the Team</a>
                </div>

                <form id="sponsor-verify-form" method="POST" action="{{ route('events.sponsor.verify') }}" style="display:none">
                    @csrf
                    <input type="hidden" name="payment" value="{{ $payment->id }}">
                    <input type="hidden" name="razorpay_payment_id">
                    <input type="hidden" name="razorpay_order_id">
                    <input type="hidden" name="razorpay_signature">
                </form>

                <p style="margin-top:18px;color:#94a3b8;font-size:.78rem;display:flex;align-items:center;justify-content:center;gap:6px">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 10-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z"/></svg>
                    Secured by Razorpay · 256-bit SSL encryption
                </p>
            </div>
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    var btn = document.getElementById('sponsor-pay-btn');
    var copy = document.getElementById('payment-status-copy');
    var fallback = document.getElementById('payment-fallback-actions');
    var options = @json($checkout);
    var opened = false;

    options.handler = function (response) {
        var form = document.getElementById('sponsor-verify-form');
        copy.textContent = 'Payment received. Confirming your sponsorship...';
        form.querySelector('[name="razorpay_payment_id"]').value = response.razorpay_payment_id || '';
        form.querySelector('[name="razorpay_order_id"]').value  = response.razorpay_order_id  || '';
        form.querySelector('[name="razorpay_signature"]').value = response.razorpay_signature  || '';
        form.submit();
    };

    options.modal = {
        ondismiss: function () {
            copy.textContent = 'Payment was not completed. You can retry checkout or contact the team.';
            fallback.hidden = false;
            btn.classList.remove('event-btn--loading');
            btn.textContent = 'Retry Payment';
            btn.disabled = false;
        }
    };

    function openPayment() {
        if (opened) return;
        opened = true;
        btn.classList.add('event-btn--loading');
        btn.disabled = true;
        copy.textContent = 'Opening the secure Razorpay payment window...';
        fallback.hidden = true;

        try {
            var gateway = new Razorpay(options);
            gateway.open();
        } catch (error) {
            copy.textContent = 'Unable to open Razorpay automatically. Please retry payment.';
            fallback.hidden = false;
            btn.classList.remove('event-btn--loading');
            btn.textContent = 'Retry Payment';
            btn.disabled = false;
        }
    }

    btn.addEventListener('click', function () {
        opened = false;
        openPayment();
    });

    setTimeout(openPayment, 350);
});
</script>
@endsection
