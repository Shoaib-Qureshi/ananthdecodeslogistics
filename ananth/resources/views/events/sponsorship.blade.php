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
                @foreach([
                    ['Premium Brand Visibility', 'Prominent logo and brand placement across stage, venue, event collateral, digital assets, and social media.'],
                    ['Qualified Lead Generation', 'Direct access to opted-in senior professionals who represent genuine sales and partnership prospects.'],
                    ['Thought Leadership', 'Speaking slots, panel participation, and content association that position your brand as a credible industry voice.'],
                    ['Strategic Relationships', 'High-value relationships with prospective clients, strategic partners, and influencers in a trust-driven environment.'],
                    ['Market Intelligence', 'Firsthand insight into priorities, challenges, and needs of enterprise supply chain leaders.'],
                    ['Live Product Demonstrations', 'Exhibition and demo opportunities for an audience actively evaluating supply chain capability.'],
                ] as [$title, $copy])
                    <article class="event-card">
                        <h3>{{ $title }}</h3>
                        <p>{{ $copy }}</p>
                    </article>
                @endforeach
            </div>

            <div class="event-grid event-grid--3" style="margin-top:48px">
                @foreach($packages as $package)
                    @php $isFeatured = $loop->first; @endphp
                    <article class="package-card {{ $isFeatured ? 'package-card--featured' : '' }}">
                        @if($isFeatured)
                            <div class="package-badge">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                Category Exclusive
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
                @if($event->registrationsOpen())
                <div class="event-actions">
                    <a class="event-btn event-btn--primary"
                       href="{{ route('events.register', ['type' => 'exhibitor']) }}"
                       aria-label="Register exhibitor interest">Register Exhibitor Interest</a>
                </div>
                @endif
            </article>
        </div>
    </section>

    <section class="event-section">
        <div class="event-container">
            <div class="event-eyebrow">Marketing Reach</div>
            <h2 class="event-title">Multi-channel promotion for sponsors.</h2>
            <p class="event-lead">Every sponsor benefits from a marketing programme designed to build visibility before delegates arrive and sustain brand recall during the event.</p>
            <div class="event-grid event-grid--3" style="margin-top:34px">
                @foreach([
                    ['LinkedIn Campaigns', 'Targeted organic and sponsored content reaching supply chain professionals, CXOs, and industry communities.'],
                    ['Instagram Promotions', 'Visual storytelling and event buzz-building for broader awareness and digital amplification.'],
                    ['Email Marketing', 'Direct campaigns to a curated database with sponsor highlights, session previews, and event updates.'],
                    ['PR & Media Outreach', 'Press releases and partnerships with trade publications and logistics industry portals.'],
                    ['Website Listing', 'Dedicated sponsor profile and logo placement on the official event website with hyperlinks.'],
                    ['Stage & Venue Branding', 'Backdrop, signage, registration desk, and session-room visibility for maximum in-person exposure.'],
                    ['Delegate Collateral', 'Sponsor inclusion in delegate kits, agendas, and event brochures distributed on the day.'],
                    ['Celebrity Amplification', 'Radhika Narayan, Kannada film actress and wellness coach, will serve as the face of the digital campaign.'],
                ] as [$title, $copy])
                    <article class="event-card">
                        <h3>{{ $title }}</h3>
                        <p>{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="event-section event-section--soft">
        <div class="event-container">
            <div class="event-eyebrow">Indicative Sponsor Benefits</div>
            <h2 class="event-title">Deliverables that move beyond logo placement.</h2>
            <div class="event-grid event-grid--3" style="margin-top:34px">
                @foreach($event->sponsor_inclusions ?: [] as $item)
                    <article class="event-card">
                        <p>{{ $item }}</p>
                    </article>
                @endforeach
            </div>
            <p class="event-lead" style="margin-top:28px">Specific entitlements vary by sponsorship category and tier. Final deliverables are confirmed in the sponsorship prospectus and partnership agreement.</p>
        </div>
    </section>

    <section class="event-section">
        <div class="event-container">
            <div class="event-eyebrow">Return on Sponsorship Investment</div>
            <h2 class="event-title">A business development investment, not a conventional media buy.</h2>
            <div class="event-grid event-grid--3" style="margin-top:34px">
                @foreach([
                    ['Qualified Sales Conversations', 'Warm conversations with vetted senior professionals who hold budget authority and active mandates.'],
                    ['Strategic Partnerships', 'Structured and informal networking that creates trust-based partnership opportunities.'],
                    ['Enhanced Brand Credibility', 'Association with a curated premium platform signals market leadership and category credibility.'],
                    ['Live Product Demonstrations', 'Show your solution value to decision-makers actively looking for the next generation of capability.'],
                ] as [$title, $copy])
                    <article class="event-card">
                        <h3>{{ $title }}</h3>
                        <p>{{ $copy }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="event-section event-section--dark" style="padding:64px 0">
        <div class="event-container event-grid">
            <div>
                <div class="event-eyebrow">Partner With Us</div>
                <h2 class="event-title" style="color:#fff">Contact the LogiSphere team.</h2>
                <p style="color:rgba(255,255,255,.72);font-size:1.08rem">{!! nl2br(e($event->contact_note)) !!}</p>
            </div>
            <article class="event-card">
                <div class="event-eyebrow">Partnership Categories</div>
                <ul class="event-list">
                    <li>Title Sponsor: category-exclusive, maximum visibility partnership</li>
                    <li>Powered By Sponsor: prominent branding with keynote speaking rights</li>
                    <li>Associate Sponsor: high-visibility digital and on-ground association</li>
                    <li>Session Sponsor: ownership of a curated seminar or panel session</li>
                    <li>Networking Sponsor: exclusive branding at breakfast, lunch, and cocktail dinner</li>
                    <li>Exhibition Partner: dedicated booth and qualified lead generation</li>
                </ul>
            </article>
        </div>
    </section>
</main>
@endsection
