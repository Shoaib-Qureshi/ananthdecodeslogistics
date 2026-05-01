@extends('layout.app')

@section('title', $settings?->meta_title ?: ($settings?->hero_heading ?? 'Ananth Decodes Logistics'))
@section('description', $settings?->meta_description ?: ($settings?->hero_subheading ?? 'Logistics insights, strategy, and thought leadership.'))
@section('url', $settings?->canonical_url ?: url('/'))

@section('styles')
<style>
    .reveal{opacity:0;transform:translateY(18px);transition:opacity .65s ease,transform .65s ease}
    .reveal.is-visible{opacity:1;transform:none}
    .reveal-delay{transition-delay:.08s}
    .reveal-delay-2{transition-delay:.16s}
    .banner-shift{animation:bannerShift 18s ease-in-out infinite alternate}
    @keyframes bannerShift{from{transform:scale(1.02)}to{transform:scale(1.08)}}
    .hero-badge{background:rgba(255,255,255,0.92);backdrop-filter:blur(10px);border:1px solid rgba(216,227,240,0.9)}
    .service-card:hover .service-icon{transform:scale(1.1) rotate(-3deg)}
    .service-icon{transition:transform 0.3s ease}
    .section-kicker:before{content:"";display:inline-block;width:1.5rem;height:1px;background:currentColor;margin-right:.75rem;vertical-align:middle}
    .section-kicker:after{content:"";display:inline-block;width:1.5rem;height:1px;background:currentColor;margin-left:.75rem;vertical-align:middle}
    @media(prefers-reduced-motion:reduce){.reveal,.banner-shift{animation:none;transition:none;opacity:1;transform:none}}
</style>
@endsection

@section('content')
@php
    $heroImage = $settings?->hero_image ? Storage::url($settings->hero_image) : asset('img/site/About-us-banner.jpg');
    $heroHeading = trim(strip_tags(html_entity_decode($settings?->hero_heading ?? 'Your Journey in Logistics, Made Simpler.', ENT_QUOTES, 'UTF-8')));
@endphp

{{-- ═══════════════════════════════════════════════
     HERO — Full-viewport split layout
═══════════════════════════════════════════════ --}}
<section class="relative min-h-[calc(100vh-5rem)] overflow-hidden bg-slate-950" aria-label="Hero">
    <div class="absolute inset-0 bg-cover bg-center banner-shift opacity-55" style="background-image:url('{{ $heroImage }}')"></div>
    <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(15,23,42,.96)_0%,rgba(15,23,42,.84)_42%,rgba(15,23,42,.35)_100%)]"></div>

    <div class="relative z-10 max-w-screen-xl mx-auto px-4 sm:px-6 py-20 lg:py-28 min-h-[calc(100vh-5rem)] flex items-center">
        <div class="grid lg:grid-cols-[1fr_360px] gap-10 lg:gap-16 items-end w-full">
            <div class="max-w-4xl">
                @if($settings?->hero_eyebrow)
                <p class="inline-flex items-center gap-3 hero-badge rounded-full px-4 py-2 mb-7 reveal text-steel text-xs font-semibold uppercase">
                    <i class="bx bx-compass text-base text-cta" aria-hidden="true"></i>
                    {{ $settings->hero_eyebrow }}
                </p>
                @endif

                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-semibold text-white leading-[1.05] mb-6 reveal">
                    {!! nl2br(e($heroHeading)) !!}
                </h1>

                <p class="text-lg sm:text-xl text-slate-100/80 leading-8 mb-9 max-w-2xl reveal reveal-delay">
                    {{ $settings?->hero_subheading ?? 'Seamless workforce mobility, premium fleet solutions, and daily supply chain intelligence.' }}
                </p>

                <div class="flex flex-wrap gap-4 reveal reveal-delay-2">
                    <a href="{{ $settings?->hero_cta_primary_link ?? '#services' }}"
                       class="inline-flex items-center gap-2 bg-cta text-white text-sm font-semibold px-7 py-3.5 rounded-lg hover:bg-steel transition-colors duration-200 shadow-lg shadow-cta/25 focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                        {{ $settings?->hero_cta_primary_label ?? 'Explore Our Services' }}
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                    </a>
                    <a href="{{ $settings?->hero_cta_secondary_link ?? '/blog' }}"
                       class="inline-flex items-center gap-2 border border-white/35 text-white text-sm font-semibold px-7 py-3.5 rounded-lg hover:bg-white/10 hover:border-white/70 transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-white">
                        {{ $settings?->hero_cta_secondary_label ?? 'Read the Blog' }}
                    </a>
                </div>
            </div>

            <aside class="hidden lg:block bg-white/10 backdrop-blur-xl rounded-xl border border-white/30 p-6 shadow-[0_22px_70px_rgba(15,23,42,0.28)] reveal reveal-delay-2" aria-label="Editorial focus">
                <p class="text-sky-200 text-xs font-semibold uppercase mb-3">Logistics Intelligence</p>
                <p class="font-heading text-2xl text-white leading-tight mb-4">Strategy, policy, mobility, and future-ready supply chains.</p>
                <div class="grid grid-cols-2 gap-4 border-t border-white/35 pt-5">
                    <div>
                        <p class="text-cta font-bold text-2xl">{{ $settings?->stat1_number }}</p>
                        <p class="text-white/55 text-xs">{{ $settings?->stat1_label }}</p>
                    </div>
                    <div>
                        <p class="text-cta font-bold text-2xl">{{ $settings?->stat2_number }}</p>
                        <p class="text-white/55 text-xs">{{ $settings?->stat2_label }}</p>
                    </div>
                </div>
            </aside>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     KEY STATISTICS
═══════════════════════════════════════════════ --}}
<section class="bg-navy py-10 -mt-1" aria-label="Key statistics">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-px bg-white/10 rounded-xl overflow-hidden">
            @foreach ([[1], [2], [3], [4]] as [$i])
                <div class="bg-navy/95 px-5 py-7 text-center reveal">
                    <p class="font-display text-3xl sm:text-4xl font-semibold text-sky-200">{{ $settings?->{'stat'.$i.'_number'} }}</p>
                    <p class="text-white/65 text-sm mt-2">{{ $settings?->{'stat'.$i.'_label'} }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     ABOUT THE FOUNDER
═══════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28 bg-cream" aria-label="About the Founder">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-12 lg:gap-20 items-center">
        <div class="relative reveal">
            <div class="aspect-[4/5] rounded-xl overflow-hidden shadow-[0_22px_60px_rgba(15,23,42,0.16)] border border-border bg-white">
                @if($settings?->founder_photo)
                    <img src="{{ Storage::url($settings->founder_photo) }}" alt="{{ $settings->founder_heading }}" class="w-full h-full object-cover" loading="lazy">
                @else
                    <div class="w-full h-full bg-softbg flex items-center justify-center text-steel text-6xl"><i class="bx bx-user"></i></div>
                @endif
            </div>
            <div class="absolute -bottom-5 -right-5 w-24 h-24 bg-cta/10 rounded-xl -z-10"></div>
        </div>
        <div class="reveal reveal-delay">
            @if($settings?->founder_eyebrow)
                <p class="section-kicker text-steel text-xs font-semibold uppercase mb-4">{{ $settings->founder_eyebrow }}</p>
            @endif
            <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl text-navy mb-3 leading-tight">{{ $settings?->founder_heading }}</h2>
            <p class="text-steel text-sm font-semibold mb-6">{{ $settings?->founder_title_badge }}</p>
            <div class="text-body leading-relaxed mb-8 text-base lg:text-lg prose max-w-none">{!! $settings?->founder_bio !!}</div>
            @if($credentials->count())
                <ul class="space-y-2.5 mb-9">
                    @foreach($credentials as $item)
                        <li class="flex gap-3 text-sm text-body"><i class="bx bx-check text-cta text-lg leading-none" aria-hidden="true"></i>{{ $item->credential }}</li>
                    @endforeach
                </ul>
            @endif
            <a href="{{ $settings?->founder_cta_link ?? '/about' }}" class="inline-flex items-center gap-2 text-cta font-semibold hover:text-steel transition-colors">
                {{ $settings?->founder_cta_label ?? 'Know More About Dr. Ananth' }}
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     OUR SERVICES — Icon-card grid redesign
═══════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28 bg-white" id="services" aria-label="Services">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">

        {{-- Section header --}}
        <div class="text-center max-w-2xl mx-auto mb-14 reveal">
            @if($settings?->services_eyebrow)
                <p class="section-kicker inline-flex items-center text-cta text-xs font-semibold uppercase mb-4">
                    {{ $settings->services_eyebrow }}
                </p>
            @endif
            <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl text-navy mb-4">{{ $settings?->services_heading ?? 'What We Offer' }}</h2>
            <p class="text-muted text-lg leading-relaxed">{{ $settings?->services_intro }}</p>
        </div>

        {{-- Service cards --}}
        <div class="grid sm:grid-cols-2 lg:grid-cols-2 gap-6 xl:gap-8">
            @foreach($services as $index => $service)
            @php
                $icons = ['bx-network-chart', 'bx-briefcase', 'bx-trending-up', 'bx-bulb', 'bx-book-open', 'bx-group'];
                $icon = $icons[$index % count($icons)];
                $accentColors = ['bg-blue-50 text-cta', 'bg-teal-50 text-teal', 'bg-sky-50 text-steel', 'bg-indigo-50 text-indigo-600'];
                $accent = $accentColors[$index % count($accentColors)];
            @endphp
            <article class="service-card group relative border border-border rounded-2xl p-8 bg-white hover:shadow-[0_16px_48px_rgba(15,23,42,0.10)] hover:-translate-y-1 transition-all duration-300 reveal overflow-hidden">

                {{-- Subtle top gradient accent --}}
                <div class="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-cta to-steel opacity-0 group-hover:opacity-100 transition-opacity duration-300 rounded-t-2xl"></div>

                <div class="flex items-start gap-5">
                    {{-- Icon --}}
                    <div class="service-icon flex-shrink-0 w-14 h-14 rounded-xl {{ $accent }} flex items-center justify-center text-2xl">
                        <i class="bx {{ $icon }}"></i>
                    </div>

                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-3 mb-3">
                            <h3 class="font-heading text-xl text-navy leading-snug">{{ $service->title }}</h3>
                            @if($service->status === 'coming_soon')
                                <div class="flex-shrink-0 text-xs bg-amber-50 text-amber-600 border border-amber-200 px-2.5 py-1 rounded-full font-medium">Coming Soon</div>
                            @endif
                        </div>
                        <p class="text-muted text-sm leading-relaxed">{{ $service->description }}</p>
                        @if($service->link_url && $service->status !== 'coming_soon')
                            <a href="{{ $service->link_url }}" class="inline-flex items-center gap-1.5 mt-5 text-cta text-sm font-semibold hover:text-steel transition-colors group/link">
                                Learn more
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover/link:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                            </a>
                        @endif
                    </div>
                </div>

            </article>
            @endforeach
        </div>

    </div>
</section>

{{-- ═══════════════════════════════════════════════
     LATEST INSIGHTS (Editorial — Dr. Ananth's Blog)
═══════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28 bg-softbg" aria-label="Latest Insights">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-12 reveal">
            <div>
                @if($settings?->blog_eyebrow)<p class="text-steel text-xs font-semibold uppercase tracking-[0.18em] mb-4">{{ $settings->blog_eyebrow }}</p>@endif
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl text-navy mb-2">{{ $settings?->blog_heading ?? 'Latest Insights' }}</h2>
                <p class="text-muted">{{ $settings?->blog_subheading }}</p>
            </div>
            <a href="{{ $settings?->blog_cta_link ?? '/blog' }}" class="inline-flex items-center justify-center border border-cta text-cta text-sm font-semibold px-6 py-3 rounded-lg hover:bg-cta hover:text-white transition-colors">{{ $settings?->blog_cta_label ?? 'View All Articles' }}</a>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($featured as $post)
                <article class="bg-white rounded-xl overflow-hidden border border-border shadow-card hover:shadow-card-hover hover:-translate-y-1 transition-all duration-300 reveal">
                    <div class="aspect-[16/9] bg-cream overflow-hidden">
                        <img src="{{ $post->thumbnail ? asset('media/' . $post->thumbnail) : asset('img/site-banner.jpg') }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-500 hover:scale-105" loading="lazy">
                    </div>
                    <div class="p-6">
                        <p class="text-xs font-semibold text-steel mb-3">{{ $post->created_at?->format('d M Y') }}</p>
                        <h3 class="font-heading text-lg text-navy leading-snug mb-3">{{ $post->title }}</h3>
                        <p class="text-muted text-sm leading-relaxed mb-5">{{ Str::limit(strip_tags($post->content ?? ''), 120) }}</p>
                        <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-1.5 text-cta text-sm font-semibold hover:text-steel transition-colors">
                            Read More
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     AUTHORITY CONTRIBUTOR — Community Blog Listing
═══════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28 bg-slate-950" aria-label="The Expert Desk">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="grid lg:grid-cols-[1.05fr_.95fr] gap-10 lg:gap-14 items-center">
            <div class="reveal">
                @if($settings?->expertdesk_eyebrow)<p class="section-kicker text-sky-200 text-xs font-semibold uppercase mb-5">{{ $settings->expertdesk_eyebrow }}</p>@endif
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl text-white mb-6">{{ $settings?->expertdesk_heading }}</h2>
                <div class="text-white/70 leading-8 mb-8 max-w-2xl">{!! $settings?->expertdesk_body !!}</div>

                <div class="flex flex-wrap gap-4">
                    <a href="{{ $settings?->expertdesk_cta1_link ?? route('contributor.register') }}" class="inline-flex items-center gap-2 bg-cta text-white text-sm font-semibold px-6 py-3.5 rounded-lg hover:bg-steel transition-colors">
                        {{ $settings?->expertdesk_cta1_label ?? 'Write for Us' }}
                        <i class="bx bx-edit-alt text-base" aria-hidden="true"></i>
                    </a>
                    <a href="{{ $settings?->expertdesk_cta2_link ?? route('contributors.index') }}" class="inline-flex items-center gap-2 border border-white/25 text-white text-sm font-semibold px-6 py-3.5 rounded-lg hover:bg-white/10 transition-colors">
                        {{ $settings?->expertdesk_cta2_label ?? 'Read Expert Articles' }}
                        <i class="bx bx-right-arrow-alt text-base" aria-hidden="true"></i>
                    </a>
                </div>
            </div>

            <div class="grid gap-4 reveal reveal-delay">
                @if($pillars->count())
                    @foreach($pillars as $pillar)
                        <article class="rounded-xl border border-white/10 bg-white/[0.06] p-5 backdrop-blur-sm">
                            <p class="text-white font-semibold mb-2">{{ $pillar->title }}</p>
                            <p class="text-white/60 text-sm leading-6">{{ $pillar->body }}</p>
                        </article>
                    @endforeach
                @endif
                <article class="rounded-xl border border-sky-300/20 bg-sky-300/10 p-5">
                    <p class="text-sky-100 font-semibold mb-2">A focused desk for serious logistics voices.</p>
                    <p class="text-white/60 text-sm leading-6">Built for practitioners, operators, consultants, and supply chain leaders who want their perspective read in context.</p>
                </article>
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     THE EXPERT DESK — CTA split
═══════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28 bg-[linear-gradient(180deg,#FFFFFF_0%,#EFF6FF_100%)] border-y border-border/70" aria-label="Authority Contributor Posts">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-6 mb-12 reveal">
            <div>
                <p class="section-kicker text-teal text-xs font-semibold uppercase mb-4">The Expert Desk</p>
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl text-navy mb-2">Authority Contributors</h2>
                <p class="text-muted max-w-xl">Perspectives from logistics professionals, supply chain experts, and industry thought leaders.</p>
            </div>
            <a href="{{ route('contributors.index') }}" class="inline-flex items-center justify-center bg-teal text-white text-sm font-semibold px-6 py-3 rounded-lg hover:bg-steel transition-colors whitespace-nowrap focus:outline-none focus-visible:ring-2 focus-visible:ring-teal focus-visible:ring-offset-2">
                View All Contributions
            </a>
        </div>

        @if($contributorPosts->count())
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($contributorPosts as $post)
            <article class="reveal">
                <a href="{{ route('contributors.show', $post->slug) }}" class="group block h-full bg-white rounded-xl overflow-hidden border border-border hover:border-teal/35 hover:shadow-[0_18px_50px_rgba(15,23,42,0.12)] hover:-translate-y-1 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-teal focus-visible:ring-offset-2">
                    <div class="relative aspect-[16/9] bg-softbg overflow-hidden">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" onerror="this.onerror=null;this.src='{{ asset(\App\Models\ContributorPost::DEFAULT_FEATURED_IMAGE) }}';">
                        <div class="absolute inset-0 bg-gradient-to-t from-navy/55 via-navy/0 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300" aria-hidden="true"></div>
                        @if($post->is_featured)
                            <p class="absolute left-4 top-4 rounded-full bg-white/92 px-3 py-1 text-xs font-semibold text-cta shadow-sm">Featured</p>
                        @endif
                    </div>

                    <div class="p-6 flex flex-col min-h-[260px]">
                    @if($post->category)
                        <p class="inline-block text-xs font-semibold text-teal bg-teal/10 border border-teal/20 px-2.5 py-1 rounded-full mb-3 self-start">{{ $post->category->name }}</p>
                    @endif

                    <h3 class="font-heading text-xl text-navy leading-snug mb-3 group-hover:text-teal transition-colors">{{ $post->title }}</h3>

                    @if($post->excerpt)
                        <p class="text-muted text-sm leading-relaxed mb-5">{{ Str::limit($post->excerpt, 118) }}</p>
                    @endif

                    <div class="flex items-center justify-between gap-3 pt-4 border-t border-border mt-auto">
                        <div class="flex items-center gap-2.5 min-w-0">
                            <div class="w-8 h-8 rounded-full bg-softbg border border-border overflow-hidden flex-shrink-0">
                                @if($post->author?->profile_photo_path)
                                    <img src="{{ asset('storage/' . $post->author->profile_photo_path) }}" alt="{{ $post->author->name }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-steel text-xs font-bold">
                                        {{ strtoupper(substr($post->author?->name ?? 'A', 0, 1)) }}
                                    </div>
                                @endif
                            </div>
                            <p class="text-xs font-medium text-body truncate">{{ $post->author?->name }}</p>
                        </div>
                        <p class="text-xs text-muted flex-shrink-0">{{ $post->published_at?->format('d M Y') }}</p>
                    </div>

                    <div class="inline-flex items-center gap-1.5 mt-4 text-teal text-sm font-semibold">
                        Read Article
                        <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                    </div>
                    </div>
                </a>
            </article>
            @endforeach
        </div>
        @else
        <div class="text-center py-16 text-muted">
            <i class="bx bx-edit-alt text-4xl mb-3 block text-border"></i>
            <p>Contributor articles coming soon.</p>
        </div>
        @endif
    </div>
</section>

{{-- ═══════════════════════════════════════════════
     BOARD INSIGHTS
═══════════════════════════════════════════════ --}}
<section class="py-20 lg:py-28 bg-softbg border-y border-border/70" aria-label="Board Insights">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="grid lg:grid-cols-[1.05fr_.95fr] gap-10 lg:gap-14 items-center">
            <div class="reveal">
                @if($settings?->boardinsights_eyebrow)
                    <p class="section-kicker text-steel text-xs font-semibold uppercase mb-5">{{ $settings->boardinsights_eyebrow }}</p>
                @endif
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl text-navy mb-6 leading-tight">{{ $settings?->boardinsights_heading }}</h2>
                <div class="text-body text-lg leading-8 mb-8 max-w-2xl">{!! $settings?->boardinsights_body !!}</div>

                <div class="grid sm:grid-cols-3 gap-3 mb-9 max-w-2xl">
                    <div class="border border-border bg-white px-4 py-4 rounded-lg">
                        <i class="bx bx-line-chart text-2xl text-cta mb-3 block" aria-hidden="true"></i>
                        <p class="text-navy text-sm font-semibold">Market Signals</p>
                    </div>
                    <div class="border border-border bg-white px-4 py-4 rounded-lg">
                        <i class="bx bx-shield-quarter text-2xl text-teal mb-3 block" aria-hidden="true"></i>
                        <p class="text-navy text-sm font-semibold">Governance Lens</p>
                    </div>
                    <div class="border border-border bg-white px-4 py-4 rounded-lg">
                        <i class="bx bx-briefcase-alt-2 text-2xl text-steel mb-3 block" aria-hidden="true"></i>
                        <p class="text-navy text-sm font-semibold">Boardroom Context</p>
                    </div>
                </div>

                <a href="{{ $settings?->boardinsights_cta_link ?? '/board-insights' }}" class="inline-flex items-center gap-2 bg-cta text-white text-sm font-semibold px-6 py-3.5 rounded-lg hover:bg-steel transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-cta focus-visible:ring-offset-2">
                    {{ $settings?->boardinsights_cta_label ?? 'Explore Board Insights' }}
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                </a>
            </div>

            <div class="reveal reveal-delay">
                <div class="relative border border-border bg-white rounded-xl p-6 lg:p-8 overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-cta" aria-hidden="true"></div>
                    <div class="flex items-start justify-between gap-4 mb-8">
                        <div>
                            <p class="text-muted text-xs font-semibold uppercase mb-2">Executive Brief</p>
                            <p class="font-heading text-2xl text-navy leading-tight">Logistics board decisions need sharper operating intelligence.</p>
                        </div>
                        <div class="h-12 w-12 rounded-lg bg-softbg border border-border flex items-center justify-center text-cta">
                            <i class="bx bx-buildings text-2xl" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div class="flex gap-4 border-t border-border pt-4">
                            <p class="text-cta font-bold text-sm w-10 shrink-0">01</p>
                            <div>
                                <p class="text-navy font-semibold">Risk, resilience, and capital allocation</p>
                                <p class="text-muted text-sm leading-6">Context for decisions that shape logistics networks.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 border-t border-border pt-4">
                            <p class="text-cta font-bold text-sm w-10 shrink-0">02</p>
                            <div>
                                <p class="text-navy font-semibold">Policy and infrastructure movement</p>
                                <p class="text-muted text-sm leading-6">Readable analysis of shifts that affect operators.</p>
                            </div>
                        </div>
                        <div class="flex gap-4 border-t border-border pt-4">
                            <p class="text-cta font-bold text-sm w-10 shrink-0">03</p>
                            <div>
                                <p class="text-navy font-semibold">Leadership perspective</p>
                                <p class="text-muted text-sm leading-6">A practical lens for senior executives and founders.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const items = document.querySelectorAll('.reveal');

        if (!('IntersectionObserver' in window)) {
            items.forEach(function (item) { item.classList.add('is-visible'); });
            return;
        }

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('is-visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.16 });

        items.forEach(function (item) { observer.observe(item); });
    });
</script>
@endsection
