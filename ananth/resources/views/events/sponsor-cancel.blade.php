@extends('layouts.front')

@section('styles')
@include('events.partials.styles')
@endsection

@section('content')
<main class="event-page">
    @include('events.partials.hero', [
        'eyebrow'  => 'Payment Cancelled',
        'title'    => 'No worries — it happens.',
        'subtitle' => 'Your checkout was not completed. No charge has been made.',
    ])
    @include('events.partials.nav')

    <section class="event-section">
        <div class="event-container">
            <div class="event-card event-status-card">
                <div class="event-status-icon event-status-icon--cancel" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z"/>
                    </svg>
                </div>
                <h1 class="event-title" style="font-size:clamp(1.6rem,3vw,2.4rem);margin-bottom:10px">
                    Checkout was not completed
                </h1>
                <p class="event-lead" style="margin:0 auto 28px;text-align:center">
                    You closed the payment window before completing the transaction.
                    No amount has been charged. You can restart the checkout at any time,
                    or get in touch with the LogiSphere team for assistance.
                </p>
                <div class="event-actions" style="justify-content:center">
                    <a class="event-btn event-btn--primary" href="{{ route('events.sponsorship') }}">Choose a Package</a>
                    <a class="event-btn event-btn--light" href="{{ route('events.register', ['type' => 'sponsor']) }}">Contact the Team</a>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
