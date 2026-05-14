@extends('layouts.front')

@section('styles')
@include('events.partials.styles')
@endsection

@section('content')
@php
    $interestOptions = $event->interestOptionMap();
    $fallbackInterest = array_key_first($interestOptions) ?: 'delegate';
    $selectedInterest = old('inquiry_type', request('type', $fallbackInterest));
    if (! array_key_exists($selectedInterest, $interestOptions)) {
        $selectedInterest = $fallbackInterest;
    }
    $selectedInterestLabel = $interestOptions[$selectedInterest] ?? 'Delegate';
@endphp
<main class="event-page">
    @include('events.partials.hero', [
        'eyebrow'  => $event->registration_eyebrow ?: 'Register',
        'title'    => $event->registration_heading ?: 'Register for LogiSphere',
        'subtitle' => $event->registration_subheading ?: 'Share your interest as a delegate, speaker, sponsor, or exhibitor.',
    ])
    @include('events.partials.nav')

    <section class="event-section event-register-section">
        <div class="event-container event-register-layout">
            <aside class="event-register-panel">
                <div class="event-eyebrow">{{ $event->registration_panel_eyebrow ?: 'Contact Information' }}</div>
                <h2 class="event-title">{{ $event->registration_panel_heading ?: 'The event team will follow up.' }}</h2>
                <p class="event-lead">{!! nl2br(e($event->contact_note)) !!}</p>

                @if($event->contact_email)
                    <div class="event-register-contact">
                        <span>Event desk</span>
                        <a href="mailto:{{ $event->contact_email }}">{{ $event->contact_email }}</a>
                    </div>
                @endif

                <ul class="event-register-steps">
                    @foreach($event->registrationSteps() as $index => $step)
                        <li>
                            <span class="event-register-step-num">{{ $index + 1 }}</span>
                            <div>
                                <strong>{{ $step['title'] }}</strong>
                                @if($step['text'])
                                    <span>{{ $step['text'] }}</span>
                                @endif
                            </div>
                        </li>
                    @endforeach
                </ul>
            </aside>

            <div class="event-card event-register-form-card">
                <div class="event-register-form-head">
                    <div>
                        <h2>{{ $event->registration_form_heading ?: 'Register Interest' }}</h2>
                        <p>{{ $event->registration_form_subheading ?: 'Tell us how you want to participate in LogiSphere.' }}</p>
                    </div>
                    <span class="event-register-badge">{{ $event->formattedDate() }}</span>
                </div>

                <div aria-live="polite" aria-atomic="true">
                    @if(session('success'))
                        <div class="event-alert event-alert--success" role="alert">{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="event-alert event-alert--error" role="alert">{{ $errors->first() }}</div>
                    @endif
                </div>

                <form class="event-form" id="register-form" method="POST" action="{{ route('events.register.submit') }}" novalidate>
                    @csrf
                    <div class="event-form-grid">
                        <div class="event-field event-choice-field full js-event-choice">
                            <label class="event-field-label" id="interest_type_label">Interest Type</label>
                            <input type="hidden" id="inquiry_type" name="inquiry_type" value="{{ $selectedInterest }}">
                            <button type="button" class="event-choice-trigger" aria-haspopup="listbox" aria-expanded="false" aria-labelledby="interest_type_label">
                                <span class="event-choice-current">{{ $selectedInterestLabel }}</span>
                                <svg class="event-choice-chevron" width="12" height="12" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg>
                            </button>
                            <div class="event-choice-menu" hidden role="listbox" aria-label="Interest Type">
                                @foreach($interestOptions as $value => $label)
                                    <button type="button" class="event-choice-option {{ $selectedInterest === $value ? 'is-active' : '' }}" role="option" aria-selected="{{ $selectedInterest === $value ? 'true' : 'false' }}" data-value="{{ $value }}">{{ $label }}</button>
                                @endforeach
                            </div>
                        </div>

                        <label for="reg_name">Full Name
                            <input id="reg_name" name="name" value="{{ old('name') }}" placeholder="Your full name" required autocomplete="name">
                        </label>

                        <label for="reg_email">Work Email
                            <input id="reg_email" type="email" name="email" value="{{ old('email') }}" placeholder="you@company.com" required autocomplete="email">
                        </label>

                        @include('events.partials.phone-field', ['idPrefix' => 'reg_phone'])

                        <label for="reg_company">Company / Organisation
                            <input id="reg_company" name="company" value="{{ old('company') }}" placeholder="Your organisation" autocomplete="organization">
                        </label>

                        <label for="reg_designation">Designation / Role
                            <input id="reg_designation" name="designation" value="{{ old('designation') }}" placeholder="e.g. VP Supply Chain">
                        </label>

                        <label class="full" for="reg_message">Message (optional)
                            <textarea id="reg_message" name="message" placeholder="Any specific topics, questions, or context for the team">{{ old('message') }}</textarea>
                        </label>

                        <label class="event-form-checkbox full">
                            <input type="checkbox" name="consent" value="1" required>
                            <span>I agree to be contacted about LogiSphere.</span>
                        </label>
                    </div>

                    <button class="event-btn event-btn--primary" type="submit" id="register-submit" style="width:100%;justify-content:center">
                        Submit Interest
                    </button>
                </form>
            </div>
        </div>
    </section>

    @if($event->venue_name || $event->venue_address || $event->venue_map_embed)
    <section class="event-section event-register-venue">
        <div class="event-container">
            <div class="event-register-venue-card">
                <div class="event-register-venue-head">
                    <div>
                        <div class="event-eyebrow">Venue Map</div>
                        <h2>{{ $event->venue_name ?: 'Event Venue' }}</h2>
                        @if($event->venue_address)
                            <p>{{ $event->venue_address }}</p>
                        @elseif($event->location)
                            <p>{{ $event->location }}</p>
                        @endif
                    </div>
                    <div class="event-register-venue-actions">
                        <a class="event-btn event-btn--primary" href="https://maps.google.com/?q={{ urlencode($event->venue_address ?: $event->venue_name ?: $event->location) }}" target="_blank" rel="noopener">Open in Google Maps</a>
                    </div>
                </div>
                @if($event->venue_map_embed)
                    <div class="event-register-venue-map">
                        <iframe
                            src="{{ $event->venue_map_embed }}"
                            loading="lazy"
                            allowfullscreen=""
                            referrerpolicy="no-referrer-when-downgrade"
                            title="LogiSphere venue map"></iframe>
                    </div>
                @endif
            </div>
        </div>
    </section>
    @endif
</main>
@endsection

@section('scripts')
@include('events.partials.phone-script')
<script>
document.addEventListener('DOMContentLoaded', function () {
    var form = document.getElementById('register-form');
    var btn = document.getElementById('register-submit');
    if (!form || !btn) return;

    form.addEventListener('submit', function () {
        if (!form.checkValidity()) return;

        btn.classList.add('event-btn--loading');
        btn.textContent = '';
        btn.disabled = true;
    });

    document.querySelectorAll('.js-event-choice').forEach(function (root) {
        var trigger = root.querySelector('.event-choice-trigger');
        var menu = root.querySelector('.event-choice-menu');
        var input = root.querySelector('input[type="hidden"]');
        var current = root.querySelector('.event-choice-current');
        var options = root.querySelectorAll('.event-choice-option');

        function close() {
            menu.hidden = true;
            trigger.setAttribute('aria-expanded', 'false');
        }

        trigger.addEventListener('click', function (event) {
            event.stopPropagation();
            menu.hidden = !menu.hidden;
            trigger.setAttribute('aria-expanded', menu.hidden ? 'false' : 'true');
        });

        options.forEach(function (option) {
            option.addEventListener('click', function () {
                input.value = option.dataset.value;
                current.textContent = option.textContent;
                options.forEach(function (item) {
                    var active = item === option;
                    item.classList.toggle('is-active', active);
                    item.setAttribute('aria-selected', active ? 'true' : 'false');
                });
                close();
            });
        });

        document.addEventListener('click', function (event) {
            if (!root.contains(event.target)) close();
        });

        trigger.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') close();
        });
    });
});
</script>
@endsection
