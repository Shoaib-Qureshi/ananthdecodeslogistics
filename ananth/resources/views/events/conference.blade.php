@extends('layouts.front')

@section('styles')
@include('events.partials.styles')
@endsection

@section('content')
<main class="event-page">
    @include('events.partials.hero', [
        'eyebrow'  => $event->chapter,
        'title'    => $event->name,
        'subtitle' => $event->tagline,
    ])
    @include('events.partials.nav')

    {{-- Stats bar --}}
    <div class="event-stats-bar">
        <div class="event-container">
            <div class="event-stats-bar__inner">
                <div class="event-stat">
                    <span class="event-stat__label">Date</span>
                    <strong class="event-stat__value">{{ $event->formattedDate() }}</strong>
                </div>
                <div class="event-stat">
                    <span class="event-stat__label">Location</span>
                    <strong class="event-stat__value">{{ $event->location ?: 'Bengaluru' }}</strong>
                </div>
                <div class="event-stat">
                    <span class="event-stat__label">Format</span>
                    <strong class="event-stat__value">{{ $event->format ?: 'Executive Conclave' }}</strong>
                </div>
                <div class="event-stat">
                    <span class="event-stat__label">Audience</span>
                    <strong class="event-stat__value">250-300 senior professionals</strong>
                </div>
            </div>
        </div>
    </div>

    {{-- Welcome & About --}}
    <section class="event-section">
        <div class="event-container event-grid">
            <article class="event-card">
                <div class="event-eyebrow">Welcome Note</div>
                <h2 class="event-title">One day. One room. High-signal supply chain conversations.</h2>
                <p>{!! nl2br(e($event->welcome_note)) !!}</p>
            </article>
            <article class="event-card event-card--dark">
                <div class="event-eyebrow">About LogiSphere</div>
                <p>{!! nl2br(e($event->about)) !!}</p>
                <div class="event-actions" style="margin-top:24px">
                    <a class="event-btn event-btn--primary" href="{{ route('events.why-who') }}">Why & Who</a>
                </div>
            </article>
        </div>
    </section>

    {{-- Formats & Outcomes --}}
    <section class="event-section">
        <div class="event-container">
            <div class="event-eyebrow">Why It Matters</div>
            <h2 class="event-title">Practical conversations. Real business outcomes.</h2>
            <p class="event-lead">Every format, session, and networking moment is structured to maximise engagement between attendees, test ideas, form partnerships, and influence business decisions.</p>
            <div class="event-grid event-grid--3" style="margin-top:34px">
                @foreach([
                    ['Insightful Seminars', 'Deep-dive sessions led by practitioners on topics that matter most to supply chain leaders.'],
                    ['Expert-Led Panels', 'Cross-functional conversations with CXOs, innovators, and policy leaders sharing direct perspectives.'],
                    ['Exhibition Showcase', 'Curated product and solution demonstrations for a targeted audience of senior decision-makers.'],
                    ['Premium Networking', 'Business breakfast, curated lunch, and cocktail dinner built for relationship development.'],
                    ['Actionable Insights', 'Implementation-ready takeaways from proven operators and industry practitioners.'],
                    ['Partnership Opportunities', 'A focused setting that accelerates conversations and shortens the path to strategic partnerships.'],
                ] as [$title, $copy])
                    <article class="event-card">
                        <h3>{{ $title }}</h3>
                        <p>{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Theme --}}
    <section class="event-section event-section--soft">
        <div class="event-container">
            <div class="event-grid">
                <div>
                    <div class="event-eyebrow">Theme for 2026</div>
                    <h2 class="event-title">{{ $event->theme_title ?: 'From Visibility to Velocity' }}</h2>
                    <p class="event-lead">Moving beyond dashboards into decisions, orchestration, and resilient execution.</p>
                </div>
                <div class="event-card">
                    <ul class="event-list">
                        @foreach(($event->theme_points ?: []) as $point)
                            <li>{{ $point }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>

    {{-- Event Snapshot --}}
    <section class="event-section">
        <div class="event-container">
            <div class="event-eyebrow">Event Snapshot</div>
            <h2 class="event-title">A single intensive day of curated engagement.</h2>
            <div class="event-grid event-grid--3" style="margin-top:34px">
                <article class="event-card">
                    <h3>300</h3>
                    <p><strong>Senior Professionals</strong><br>250-300 carefully curated delegates from India's leading supply chain organisations.</p>
                </article>
                <article class="event-card">
                    <h3>100+</h3>
                    <p><strong>Companies Represented</strong><br>Manufacturing, FMCG, retail, e-commerce, pharma, automotive, and logistics tech.</p>
                </article>
                <article class="event-card">
                    <h3>40</h3>
                    <p><strong>Exhibitors</strong><br>Technology providers, solution innovators, and service companies showcasing new capabilities.</p>
                </article>
            </div>
        </div>
    </section>

    {{-- Upcoming events --}}
    @if($upcomingEvents->isNotEmpty())
    <section class="event-section event-section--soft" style="padding:56px 0">
        <div class="event-container">
            <div class="event-eyebrow">Coming Up</div>
            <h2 class="event-title" style="margin-bottom:28px">Upcoming Events</h2>
            <div class="event-upcoming-list">
                @foreach($upcomingEvents as $upcoming)
                <article class="event-upcoming-card">
                    <div class="event-upcoming-card__top">
                            <span class="event-date-chip event-date-chip--upcoming">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                                {{ $upcoming->formattedDate() }}
                            </span>
                            <span class="event-upcoming-card__title">{{ $upcoming->name }}</span>
                            @if($upcoming->chapter)<span class="event-upcoming-card__chapter">{{ $upcoming->chapter }}</span>@endif
                        </div>
                    @if($upcoming->tagline)
                        <p class="event-upcoming-card__copy">{{ $upcoming->tagline }}</p>
                    @endif
                    @if($upcoming->location || $upcoming->format)
                        <div class="event-upcoming-card__details">
                            @if($upcoming->location)
                            <div>
                                <span>Location</span>
                                <strong>{{ $upcoming->location }}</strong>
                            </div>
                            @endif
                            @if($upcoming->format)
                            <div>
                                <span>Format</span>
                                <strong>{{ $upcoming->format }}</strong>
                            </div>
                            @endif
                        </div>
                    @endif
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- Agenda --}}
    @if($event->registrationsOpen())
    <section class="event-section">
        <div class="event-container">
            <div class="event-eyebrow">Agenda Preview</div>
            <h2 class="event-title">A compact day built for depth.</h2>
            <ol class="agenda" style="margin-top:36px">
                @foreach($event->agendaItems->where('visible', true) as $item)
                    <li class="agenda-row">
                        <div class="agenda-time">
                            <span class="agenda-time-chip">{{ $item->start_time }}{{ $item->end_time ? '–' . $item->end_time : '' }}</span>
                        </div>
                        <span class="agenda-dot" aria-hidden="true"></span>
                        <div class="agenda-row__card">
                            <h3>{{ $item->title }}</h3>
                            @if($item->session_type || $item->duration)
                                <p><strong>{{ $item->session_type }}</strong>{{ $item->session_type && $item->duration ? ' · ' : '' }}{{ $item->duration }}</p>
                            @endif
                            @if($item->description)<p>{{ $item->description }}</p>@endif
                        </div>
                    </li>
                @endforeach
            </ol>
            <div class="event-actions" style="margin-top:40px">
                <a class="event-btn event-btn--primary" href="{{ route('events.why-who') }}">See Why & Who</a>
                <a class="event-btn event-btn--light" href="{{ route('events.faq') }}">Read FAQ</a>
            </div>
        </div>
    </section>
    @endif

    {{-- Venue --}}
    @if($event->venue_name || $event->venue_address || $event->venue_map_embed)
    <section class="event-section event-section--soft event-venue-section">
        <div class="event-container">
           
            
            <div class="event-venue-grid">
                <div class="event-venue-info">
                     <div class="event-eyebrow">Venue</div>
                    <h2 class="event-title">Where it happens</h2>
                    @if($event->venue_name)
                        <h3 class="event-venue-name">{{ $event->venue_name }}</h3>
                    @endif
                    @if($event->venue_address)
                        <p class="event-venue-address">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $event->venue_address }}
                        </p>
                    @endif
                    @if($event->location)
                        <p class="event-venue-city">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
                            {{ $event->location }}
                        </p>
                    @endif
                    <div class="event-actions" style="margin-top:28px">
                        @if($event->registrationsOpen())
                        <a class="event-btn event-btn--primary" href="{{ route('events.register') }}">Register Now</a>
                        @endif
                        @if($event->venue_map_embed)
                            <a class="event-btn event-btn--light" href="https://maps.google.com/?q={{ urlencode($event->venue_address ?: $event->venue_name ?: $event->location) }}" target="_blank" rel="noopener">Open in Google Maps</a>
                        @endif
                    </div>
                </div>
                @if($event->venue_map_embed)
                <div class="event-venue-map">
                    <iframe
                        src="{{ $event->venue_map_embed }}"
                        width="100%"
                        height="100%"
                        style="border:0;min-height:340px"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        title="Event venue map"></iframe>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    @php
        $marketingPartners = $event->marketing_partners;
        if ($marketingPartners === null) {
            $marketingPartners = [
                ['name' => 'NeuWork Solutions', 'role' => 'Marketing & Execution Partners', 'logo' => '/img/events/marketing-partners/neuwork-solutions.jpg'],
                ['name' => '360 Degree Media', 'role' => 'Marketing & Media Partners', 'logo' => '/img/events/marketing-partners/360-media-exchange.jpg'],
                ['name' => 'Leveragez', 'role' => 'Marketing & Delegate Management Partners', 'logo' => '/img/events/marketing-partners/leveragez-marketing.jpg'],
            ];
        }
        $marketingPartners = collect($marketingPartners)
            ->filter(fn ($partner) => is_array($partner) && !empty($partner['name']) && !empty($partner['logo']))
            ->map(function ($partner) {
                $partner['logo'] = \App\Models\Event::normalizePublicAssetUrl($partner['logo']);
                return $partner;
            })
            ->values();
    @endphp
    {{-- Marketing and execution partners --}}
    @if($marketingPartners->isNotEmpty())
    <section class="event-section event-partners-section" aria-labelledby="marketing-partners-title">
        <div class="event-container">
            <h2 class="event-title event-partners-title" id="marketing-partners-title">Partners</h2>
            @if($marketingPartners->count() > 4)
                <div class="event-partners-carousel" aria-label="Event partners">
                    <div class="event-partners-track" style="--partner-scroll-duration:{{ max(48, $marketingPartners->count() * 8) }}s">
                        <div class="event-partners-set" role="list">
                            @foreach($marketingPartners as $partner)
                                @include('events.partials.marketing-partner-card', ['partner' => $partner])
                            @endforeach
                        </div>
                        <div class="event-partners-set" aria-hidden="true">
                            @foreach($marketingPartners as $partner)
                                @include('events.partials.marketing-partner-card', ['partner' => $partner])
                            @endforeach
                        </div>
                    </div>
                </div>
            @else
                <div class="event-partners-grid event-partners-grid--{{ $marketingPartners->count() }}" role="list" aria-label="Event partners">
                    @foreach($marketingPartners as $partner)
                        @include('events.partials.marketing-partner-card', ['partner' => $partner])
                    @endforeach
                </div>
            @endif
        </div>
    </section>
    @endif

    {{-- Past events --}}
    @if($pastEvents->isNotEmpty())
    <section class="event-section event-section--dark" style="padding:64px 0">
        <div class="event-container">
            <div class="event-eyebrow">Archive</div>
            <h2 class="event-title" style="color:#fff;margin-bottom:8px">Previous Events</h2>
            <p style="color:rgba(255,255,255,.6);margin:0 0 28px;font-size:1rem">The LogiSphere conversations that started it all.</p>
            <div class="event-upcoming-list">
                @foreach($pastEvents as $past)
                <article class="event-upcoming-card event-upcoming-card--dark">
                    <div class="event-upcoming-card__top">
                            <span class="event-date-chip event-date-chip--past">
                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                                {{ $past->formattedDate() }}
                            </span>
                            <span class="event-upcoming-card__title">{{ $past->name }}</span>
                            @if($past->chapter)<span class="event-upcoming-card__chapter">{{ $past->chapter }}</span>@endif
                        </div>
                    @if($past->tagline)
                        <p class="event-upcoming-card__copy">{{ $past->tagline }}</p>
                    @endif
                    @if($past->location || $past->format)
                        <div class="event-upcoming-card__details">
                            @if($past->location)
                            <div>
                                <span>Location</span>
                                <strong>{{ $past->location }}</strong>
                            </div>
                            @endif
                            @if($past->format)
                            <div>
                                <span>Format</span>
                                <strong>{{ $past->format }}</strong>
                            </div>
                            @endif
                        </div>
                    @endif
                </article>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    <section class="event-section event-section--dark" style="padding:64px 0">
        <div class="event-container">
            <div class="event-eyebrow">One Day. One Room.</div>
            <h2 class="event-title" style="color:#fff">Infinite possibilities.</h2>
            <p style="color:rgba(255,255,255,.72);font-size:1.08rem;max-width:760px">{!! nl2br(e($event->closing_note)) !!}</p>
            <div class="event-actions" style="margin-top:28px">
                @if($event->registrationsOpen())
                <a class="event-btn event-btn--primary" href="{{ route('events.register') }}">Register Interest</a>
                <a class="event-btn" href="{{ route('events.sponsorship') }}">Partner With Us</a>
                @endif
            </div>
        </div>
    </section>
</main>
@endsection
