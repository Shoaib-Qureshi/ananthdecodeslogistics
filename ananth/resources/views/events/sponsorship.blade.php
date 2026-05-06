@extends('layouts.front')

@section('styles')
@include('events.partials.styles')
@endsection

@section('content')
<main class="event-page">
    @include('events.partials.hero', [
        'eyebrow'  => $event->sponsorship_eyebrow ?: 'Sponsor & Exhibit',
        'title'    => $event->sponsorship_heading ?: 'Partner with LogiSphere',
        'subtitle' => $event->sponsorship_subheading ?: 'Paid sponsorship packages for brands that want precise access to supply chain decision-makers.',
        'showActions' => false,
        'aside' => 'upcoming',
    ])
    @include('events.partials.nav')

    <section class="event-section">
        <div class="event-container">
            <div class="event-grid">
                <div>
                    <div class="event-eyebrow">Sponsorship Packages</div>
                    <h2 class="event-title">Visibility with the right room.</h2>
                    <p class="event-lead">{!! nl2br(e($event->sponsor_intro)) !!}</p>
                </div>
                <div class="event-card">
                    <p style="font-size:.82rem;color:#64748b;margin:0 0 12px">Checkout currency: <strong style="color:#0f172a">{{ $currency }}</strong></p>
                    <ul class="event-list">
                        @foreach(($event->sponsor_benefits ?: []) as $benefit)
                            <li>{{ $benefit }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <div class="event-grid event-grid--3" style="margin-top:48px">
                @foreach($packages as $package)
                    @php $isFeatured = $loop->first; @endphp
                    <article class="package-card {{ $isFeatured ? 'package-card--featured' : '' }}">
                        @if($isFeatured)
                            <div class="package-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                Most Popular
                            </div>
                        @endif
                        <div>
                            <h3>{{ $package->name }}</h3>
                            <div class="package-price">{{ $package->formattedPrice($currency) }}</div>
                            <div class="package-meta">
                                <span>{{ $package->slot_count }} slot{{ $package->slot_count != 1 ? 's' : '' }}</span>
                                <span>{{ $package->included_passes }} pass{{ $package->included_passes != 1 ? 'es' : '' }}</span>
                            </div>
                        </div>
                        <p>{{ $package->description }}</p>
                        <ul class="event-list">
                            @foreach(($package->benefits ?: []) as $benefit)
                                <li>{{ $benefit }}</li>
                            @endforeach
                        </ul>
                        <a class="event-btn event-btn--primary"
                           href="{{ route('events.sponsor.checkout', $package) }}"
                           aria-label="Select {{ $package->name }} package">Select Package</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="event-section event-section--soft">
        <div class="event-container event-grid">
            <article class="event-card">
                <div class="event-eyebrow">Become an Exhibitor</div>
                <p>{!! nl2br(e($event->exhibitor_intro)) !!}</p>
                <ul class="event-list">
                    @foreach(($event->exhibitor_benefits ?: []) as $benefit)
                        <li>{{ $benefit }}</li>
                    @endforeach
                </ul>
            </article>
            <article class="event-card event-card--dark">
                <div class="event-eyebrow">What is Included?</div>
                <ul class="event-list">
                    @foreach(($event->sponsor_inclusions ?: []) as $item)
                        <li>{{ $item }}</li>
                    @endforeach
                </ul>
                <div class="event-actions">
                    <a class="event-btn event-btn--primary"
                       href="{{ route('events.register', ['type' => 'exhibitor']) }}"
                       aria-label="Register exhibitor interest">Register Exhibitor Interest</a>
                </div>
            </article>
        </div>
    </section>
</main>
@endsection
