@php
    $hasImage = !empty($event->hero_image);
    $watermark = strtoupper($event->name);
    $showActions = $showActions ?? true;
    $aside = $aside ?? null;
    $countdownTarget = $event->event_date ? $event->event_date->copy()->startOfDay()->toIso8601String() : null;
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
            @if($countdownTarget)
                @include('events.partials.countdown')
            @endif
            @if($showActions)
                <div class="event-actions">
                    @if($event->registrationsOpen())
                        <a class="event-btn event-btn--primary" href="{{ route('events.register') }}">Register Interest</a>
                    @endif
                    <a class="event-btn {{ $event->registrationsOpen() ? '' : 'event-btn--primary' }}" href="{{ route('events.sponsorship') }}">Sponsor LogiSphere</a>
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
                @if($event->registrationsOpen())
                    <a class="event-hero-upcoming__link" href="{{ route('events.register', ['type' => 'sponsor']) }}">Register sponsor interest</a>
                @endif
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

@if($countdownTarget)
    <script>
        (function () {
            function initCountdown(root) {
                var target = new Date(root.dataset.countdownTarget).getTime();
                var label = root.querySelector('[data-countdown-label]');
                var fields = {
                    days: root.querySelector('[data-countdown-days]'),
                    hours: root.querySelector('[data-countdown-hours]'),
                    minutes: root.querySelector('[data-countdown-minutes]'),
                    seconds: root.querySelector('[data-countdown-seconds]')
                };

                function update() {
                    var remaining = Math.max(0, target - Date.now());
                    var totalSeconds = Math.floor(remaining / 1000);
                    var days = Math.floor(totalSeconds / 86400);
                    var hours = Math.floor((totalSeconds % 86400) / 3600);
                    var minutes = Math.floor((totalSeconds % 3600) / 60);
                    var seconds = totalSeconds % 60;

                    fields.days.textContent = String(days).padStart(2, '0');
                    fields.hours.textContent = String(hours).padStart(2, '0');
                    fields.minutes.textContent = String(minutes).padStart(2, '0');
                    fields.seconds.textContent = String(seconds).padStart(2, '0');

                    if (remaining === 0) {
                        label.textContent = 'Event day is here';
                        root.classList.add('is-complete');
                        return false;
                    }
                    return true;
                }

                if (update()) {
                    window.setInterval(update, 1000);
                }
            }

            function startCountdowns() {
                document.querySelectorAll('[data-event-countdown]').forEach(initCountdown);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', startCountdowns);
            } else {
                startCountdowns();
            }
        }());
    </script>
@endif
