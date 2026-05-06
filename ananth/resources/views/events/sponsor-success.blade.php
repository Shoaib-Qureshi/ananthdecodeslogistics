@extends('layouts.front')

@section('styles')
@include('events.partials.styles')
@endsection

@section('content')
@php
    $invoiceNumber = \App\Support\EventSponsorInvoicePdf::invoiceNumber($payment);
@endphp
<main class="event-page">
    @include('events.partials.nav')

    <section class="event-section event-success-section">
        <div class="event-container">
            <div class="event-card event-status-card event-success-card">
                <div class="event-status-icon event-status-icon--success" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="event-eyebrow">Payment Confirmed</div>
                <h1 class="event-title" style="font-size:clamp(1.8rem,4vw,3.2rem);margin-bottom:12px">
                    Thank you, {{ $payment->company }}.
                </h1>
                <p class="event-lead" style="margin:0 auto 22px;text-align:center">
                    Your <strong>{{ $payment->package?->name }}</strong> sponsorship payment of
                    <strong>{{ $payment->currency }} {{ number_format($payment->total_amount, 2) }}</strong>
                    has been recorded successfully.
                </p>

                <div class="event-success-summary">
                    <div><span>Invoice No</span><strong>{{ $invoiceNumber }}</strong></div>
                    <div><span>Payment Ref</span><strong>{{ $payment->razorpay_payment_id }}</strong></div>
                    <div><span>Email</span><strong>{{ $payment->email }}</strong></div>
                </div>

                <div class="event-next-steps">
                    <h3>What happens next?</h3>
                    <ol>
                        <li>A confirmation email with the PDF invoice has been sent to you and the admin team.</li>
                        <li>The LogiSphere team will reach out with sponsor kit and logistics details.</li>
                        <li>Your sponsor listing will be coordinated after verification of brand assets.</li>
                    </ol>
                </div>

                <div class="event-actions" style="justify-content:center;margin-top:32px">
                    <a class="event-btn event-btn--primary" href="{{ route('events.conference') }}">Back to LogiSphere</a>
                    <a class="event-btn event-btn--light" href="{{ route('events.sponsorship') }}">View Sponsor Packages</a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
