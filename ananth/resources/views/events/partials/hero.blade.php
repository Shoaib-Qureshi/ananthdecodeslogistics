@php
    $hasImage = !empty($event->hero_image);
    $watermark = strtoupper($event->name);
    $showActions = $showActions ?? true;
    $aside = $aside ?? null;
@endphp
<section class="event-hero" style="--hero-watermark:'{{ $watermark }}'">
    <div class="event-container event-hero__inner">

        {{-- Left: text --}}
        <div>
            <div class="event-kicker-card">
                <span class="event-kicker-dot" aria-hidden="true"></span>
                {{ $event->formattedDate() }} &nbsp;|&nbsp; {{ $event->location ?: 'Bengaluru' }}
            </div>
            <div class="event-eyebrow">{{ $eyebrow ?? $event->chapter }}</div>
            <h1>{{ $title ?? $event->name }}</h1>
            <p>{{ $subtitle ?? $event->tagline }}</p>
            @if($showActions)
                <div class="event-actions">
                    <a class="event-btn event-btn--primary" href="{{ route('events.register') }}">Register Interest</a>
                    <a class="event-btn" href="{{ route('events.sponsorship') }}">Sponsor LogiSphere</a>
                </div>
            @endif
        </div>

        {{-- Right: image OR facts card --}}
        @if($aside === 'upcoming')
            <aside class="event-hero-upcoming" aria-label="Upcoming event">
                <span class="event-hero-upcoming__label">Upcoming Event</span>
                <h2>{{ $event->name }}</h2>
                @if($event->chapter)
                    <p class="event-hero-upcoming__chapter">{{ $event->chapter }}</p>
                @endif
                <div class="event-hero-upcoming__meta">
                    <div><span>Date</span><strong>{{ $event->formattedDate() }}</strong></div>
                    <div><span>Location</span><strong>{{ $event->location ?: 'Bengaluru' }}</strong></div>
                    <div><span>Format</span><strong>{{ $event->event_time ?: $event->format ?: 'A one-day executive conclave' }}</strong></div>
                </div>
                <a class="event-hero-upcoming__link" href="{{ route('events.register', ['type' => 'sponsor']) }}">Register sponsor interest</a>
            </aside>
        @elseif($hasImage)
            <div class="event-hero__image-wrap">
                <img src="{{ $event->hero_image }}"
                     alt="{{ $event->name }} event"
                     class="event-hero__image">
                {{-- Facts strip below image --}}
                <div class="event-hero__image-facts">
                    <div><span>Date</span><strong>{{ $event->formattedDate() }}</strong></div>
                    <div><span>Location</span><strong>{{ $event->location ?: 'Bengaluru' }}</strong></div>
                </div>
            </div>
        @else
            <div class="event-facts" aria-label="Event at a glance">
                <div><span>Date</span><strong>{{ $event->formattedDate() }}</strong></div>
                <div><span>Location</span><strong>{{ $event->location ?: 'Bengaluru' }}</strong></div>
                <div><span>Format</span><strong>{{ $event->event_time ?: $event->format ?: 'A one-day executive conclave' }}</strong></div>
            </div>
        @endif

    </div>
</section>
