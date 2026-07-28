@extends('layouts.front')

@section('styles')
@include('events.partials.styles')
@endsection

@section('content')
<main class="event-page">
    @include('events.partials.hero', [
        'eyebrow'  => $event->why_who_eyebrow ?: 'Why LogiSphere',
        'title'    => $event->why_who_heading ?: 'Why now? Why Bengaluru?',
        'subtitle' => $event->why_who_subheading ?: ($event->why_now ?: 'Bengaluru is the natural birthplace for Chapter 1.'),
    ])
    @include('events.partials.nav')

    <section class="event-section">
        <div class="event-container">
            <div class="event-eyebrow">Different by Design</div>
            <h2 class="event-title">Not another noisy summit.</h2>
            <table class="event-table" style="margin-top:28px">
                <thead>
                    <tr>
                        <th scope="col">Traditional Summits</th>
                        <th scope="col">LogiSphere</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(($event->comparison_rows ?: []) as $row)
                        <tr>
                            <td><span class="event-table__dash">—</span> {{ $row['traditional'] ?? '' }}</td>
                            <td><span class="event-table__check">&#10003;</span> {{ $row['logisphere'] ?? '' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <section class="event-section event-section--soft">
        <div class="event-container event-grid">
            <div>
                <div class="event-eyebrow">Who Should Attend?</div>
                <h2 class="event-title">Built for decision-makers and influencers.</h2>
                <p class="event-lead">Every delegate is vetted for seniority, relevance, and decision-making authority, giving sponsors, exhibitors, and speakers the audience they genuinely want access to.</p>
                <div class="event-actions">
                    <a class="event-btn event-btn--primary" href="{{ route('events.register') }}">Register Interest</a>
                </div>
            </div>
            <div class="event-card">
                <ul class="event-list">
                    @foreach(($event->attendee_profiles ?: []) as $profile)
                        <li>{{ $profile }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>

    @php
        $delegateLogos = collect($event->delegate_logos ?: [])
            ->map(fn ($logo) => is_array($logo) ? ($logo['url'] ?? null) : $logo)
            ->filter(fn ($logo) => is_string($logo) && trim($logo) !== '')
            ->map(fn ($logo) => \App\Models\Event::normalizePublicAssetUrl($logo))
            ->values();
    @endphp
    @if($delegateLogos->isNotEmpty())
        <section class="event-section event-delegates-section" aria-labelledby="delegate-logos-title">
            <div class="event-container">
                <div class="event-delegates-heading">
                    <div class="event-eyebrow">Delegate Community</div>
                    <h2 class="event-title" id="delegate-logos-title">The companies in the room.</h2>
                    <p class="event-lead">A curated community of leaders shaping the next chapter of supply chain and logistics.</p>
                </div>
                <div class="event-delegates-viewport" aria-label="Companies attending LogiSphere">
                    <div class="event-delegates-track">
                        <div class="event-delegates-set">
                            @foreach($delegateLogos as $logo)
                                <div class="event-delegate-logo">
                                    <img src="{{ $logo }}" alt="Delegate attendee logo" loading="eager">
                                </div>
                            @endforeach
                        </div>
                        <div class="event-delegates-set" aria-hidden="true">
                            @foreach($delegateLogos as $logo)
                                <div class="event-delegate-logo">
                                    <img src="{{ $logo }}" alt="" loading="lazy">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="event-delegates-cta">
                    <span>Join the delegate community</span>
                    <a class="event-btn event-btn--primary" href="{{ route('events.register') }}">Register Interest</a>
                </div>
            </div>
        </section>
    @endif

    <section class="event-section">
        <div class="event-container">
            <div class="event-eyebrow">Key Industry Sectors</div>
            <h2 class="event-title">Cross-industry supply chain leadership in one room.</h2>
            <div class="event-grid event-grid--3" style="margin-top:34px">
                @foreach(['Manufacturing', 'FMCG', 'Retail', 'E-Commerce', 'Pharmaceuticals', 'Automotive', 'Logistics Technology', 'SaaS Companies', 'Innovation Labs'] as $sector)
                    <article class="event-card">
                        <h3>{{ $sector }}</h3>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="event-section event-section--soft">
        <div class="event-container event-grid">
            <div>
                <div class="event-eyebrow">Why Bengaluru for Chapter 1</div>
                <h2 class="event-title">India's supply chain innovation capital.</h2>
                <p class="event-lead">{!! nl2br(e($event->why_now)) !!}</p>
            </div>
            <div class="event-card">
                <ul class="event-list">
                    <li>Global enterprise and APAC supply chain leadership presence</li>
                    <li>Bengaluru-Tumkur manufacturing corridor across aerospace, electronics, and industrial activity</li>
                    <li>India's largest concentration of logistics SaaS, analytics, and fulfilment technology companies</li>
                    <li>Venture-backed startup ecosystem attracting global capital into supply chain innovation</li>
                    <li>Direct access to policy associations, innovation labs, and influential operations leaders</li>
                </ul>
            </div>
        </div>
    </section>

    <section class="event-section">
        <div class="event-container event-grid">
            <article class="event-card event-card--dark">
                <div class="event-eyebrow">Curatorial Authority</div>
                <h2>About Ananth Decodes Logistics</h2>
                <p>Ananth Decodes Logistics is an independent platform dedicated to advancing the understanding, practice, and leadership of supply chain and logistics management across India through thought leadership, community building, and executive programming.</p>
            </article>
            <article class="event-card">
                <div class="event-eyebrow">The LogiSphere Difference</div>
                <p>LogiSphere prioritises depth over breadth, quality over quantity, and substance over spectacle. It is positioned as the better alternative: where every hour invested delivers measurable business value.</p>
                <ul class="event-list">
                    <li>Thought leadership rooted in original research, opinion, and analysis</li>
                    <li>A growing community of practitioners, CXOs, and innovators</li>
                    <li>Curated events and roundtables that bring the right people together for the right conversations</li>
                </ul>
            </article>
        </div>
    </section>
</main>
@endsection
