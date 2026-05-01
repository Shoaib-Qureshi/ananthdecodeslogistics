@extends('layout.app')

@section('title', $settings?->meta_title ?: (($settings?->hero_heading ?? 'About') . ' - Ananth Decodes Logistics'))
@section('description', $settings?->meta_description ?: ($settings?->hero_subheading ?? 'Meet the team behind Ananth Decodes Logistics.'))
@section('url', $settings?->canonical_url ?: url('/about'))

@section('styles')
<style>
    .reveal{opacity:0;transform:translateY(18px);transition:opacity .65s ease,transform .65s ease}
    .reveal.is-visible{opacity:1;transform:none}
    .reveal-delay{transition-delay:.08s}
    .banner-shift{animation:bannerShift 18s ease-in-out infinite alternate}
    @keyframes bannerShift{from{transform:scale(1.02)}to{transform:scale(1.08)}}
    .section-kicker:before{content:"";display:inline-block;width:1.5rem;height:1px;background:currentColor;margin-right:.75rem;vertical-align:middle}
    .section-kicker:after{content:"";display:inline-block;width:1.5rem;height:1px;background:currentColor;margin-left:.75rem;vertical-align:middle}
    @media(prefers-reduced-motion:reduce){.reveal,.banner-shift{animation:none;transition:none;opacity:1;transform:none}}
</style>
@endsection

@section('content')
@php
    $heroImage = $settings?->hero_image ? Storage::url($settings->hero_image) : asset('img/site/About-us-banner.jpg');
    $heroHeading = trim(strip_tags(html_entity_decode($settings?->hero_heading ?? 'About Ananth Decodes Logistics', ENT_QUOTES, 'UTF-8')));
@endphp

<section class="relative min-h-[calc(82vh-5rem)] overflow-hidden bg-slate-950" aria-label="About hero">
    <div class="absolute inset-0 bg-cover bg-center banner-shift opacity-50" style="background-image:url('{{ $heroImage }}')"></div>
    <div class="absolute inset-0 bg-[linear-gradient(90deg,rgba(15,23,42,.96)_0%,rgba(15,23,42,.84)_45%,rgba(15,23,42,.35)_100%)]"></div>

    <div class="relative z-10 max-w-screen-xl mx-auto px-4 sm:px-6 py-20 lg:py-28 min-h-[calc(82vh-5rem)] flex items-center">
        <div class="w-full">
            <div class="max-w-4xl">
                @if($settings?->hero_eyebrow)
                    <p class="inline-flex items-center gap-3 rounded-full bg-white/92 border border-border px-4 py-2 mb-7 reveal text-steel text-xs font-semibold uppercase">
                        <i class="bx bx-compass text-base text-cta" aria-hidden="true"></i>
                        {{ $settings->hero_eyebrow }}
                    </p>
                @endif

                <h1 class="font-display text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-semibold text-white leading-[1.05] mb-6 reveal">
                    {!! nl2br(e($heroHeading)) !!}
                </h1>
                <p class="text-lg sm:text-xl text-slate-100/80 leading-8 max-w-2xl reveal reveal-delay">
                    {{ $settings?->hero_subheading }}
                </p>
            </div>

        </div>
    </div>
</section>

<section class="py-20 lg:py-28 bg-[linear-gradient(180deg,#FFFFFF_0%,#EFF6FF_100%)] border-y border-border/70" aria-label="Company Introduction">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="grid lg:grid-cols-[0.9fr_1.1fr] gap-10 lg:gap-14 items-start">
            <div class="reveal lg:sticky lg:top-28">
                @if($settings?->intro_eyebrow)
                    <p class="section-kicker text-steel text-xs font-semibold uppercase mb-5">{{ $settings->intro_eyebrow }}</p>
                @endif
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl text-navy leading-tight mb-6">{{ $settings?->intro_heading }}</h2>
                <p class="text-muted leading-7 max-w-md">A focused point of view on logistics, leadership, and supply chain change.</p>
            </div>
            <div class="reveal reveal-delay">
                <div class="bg-white border border-border rounded-xl p-6 lg:p-8 shadow-[0_18px_50px_rgba(15,23,42,0.08)]">
                    <div class="text-body text-base lg:text-lg leading-8 prose max-w-none">{!! $settings?->intro_body !!}</div>
                </div>
                <div class="grid sm:grid-cols-3 gap-3 mt-4">
                    <div class="bg-white/80 border border-border rounded-lg p-4">
                        <i class="bx bx-compass text-2xl text-cta mb-2 block" aria-hidden="true"></i>
                        <p class="text-navy text-sm font-semibold">Strategy</p>
                    </div>
                    <div class="bg-white/80 border border-border rounded-lg p-4">
                        <i class="bx bx-network-chart text-2xl text-teal mb-2 block" aria-hidden="true"></i>
                        <p class="text-navy text-sm font-semibold">Operations</p>
                    </div>
                    <div class="bg-white/80 border border-border rounded-lg p-4">
                        <i class="bx bx-bulb text-2xl text-steel mb-2 block" aria-hidden="true"></i>
                        <p class="text-navy text-sm font-semibold">Perspective</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-20 lg:py-28 bg-white" aria-label="Our Founders">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="max-w-3xl mx-auto text-center mb-14 reveal">
            <div>
                <p class="section-kicker text-steel text-xs font-semibold uppercase mb-4">The People Behind ADL</p>
                <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl text-navy mb-5">Our Leadership</h2>
                <p class="text-muted text-lg leading-8">The platform is shaped by industry experience, editorial clarity, and a practical understanding of how logistics decisions are made.</p>
            </div>
        </div>

        <div class="space-y-16 lg:space-y-20">
            @forelse($founders as $index => $founder)
                <article class="grid lg:grid-cols-2 gap-10 lg:gap-16 items-center reveal {{ $index % 2 ? 'lg:[direction:rtl]' : '' }}">
                    <div class="{{ $index % 2 ? 'lg:[direction:ltr]' : '' }}">
                        <div class="aspect-[4/5] max-w-md mx-auto rounded-xl overflow-hidden bg-softbg border border-border">
                            @if($founder->photo)
                                <img src="{{ Storage::url($founder->photo) }}" alt="{{ $founder->name }}" class="w-full h-full object-cover" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-steel text-7xl"><i class="bx bx-user"></i></div>
                            @endif
                        </div>
                    </div>

                    <div class="{{ $index % 2 ? 'lg:[direction:ltr]' : '' }}">
                        @if($founder->eyebrow)<p class="text-steel text-xs font-semibold uppercase mb-4">{{ $founder->eyebrow }}</p>@endif
                        <h3 class="font-heading text-3xl sm:text-4xl lg:text-5xl text-navy mb-3 leading-tight">{{ $founder->name }}</h3>
                        <p class="text-steel text-sm font-semibold mb-6">{{ $founder->title }}</p>
                        <div class="text-body text-base lg:text-lg leading-8 prose max-w-none">{!! $founder->bio !!}</div>
                        @if($founder->signature_image)
                            <img src="{{ Storage::url($founder->signature_image) }}" alt="{{ $founder->name }} signature" class="h-12 opacity-70 mt-8" loading="lazy">
                        @endif
                    </div>
                </article>
            @empty
                <p class="text-center text-muted">Founder profiles will appear here soon.</p>
            @endforelse
        </div>
    </div>
</section>

<section class="py-20 lg:py-28 bg-softbg border-y border-border/70" aria-label="Vision Mission Values">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="max-w-3xl mb-12 reveal">
            <p class="section-kicker text-steel text-xs font-semibold uppercase mb-4">Our Purpose</p>
            <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl text-navy">Why We Exist</h2>
        </div>

        <div class="grid lg:grid-cols-3 gap-6">
            @foreach([
                ['icon' => 'bx-show', 'title' => $settings?->vision_title, 'body' => $settings?->vision_body],
                ['icon' => 'bx-target-lock', 'title' => $settings?->mission_title, 'body' => $settings?->mission_body],
                ['icon' => 'bx-diamond', 'title' => $settings?->values_title, 'body' => $settings?->values_body],
            ] as $item)
                <article class="border border-border bg-white rounded-xl p-7 reveal hover:shadow-[0_16px_48px_rgba(15,23,42,0.08)] transition-shadow">
                    <div class="h-12 w-12 rounded-lg bg-blue-50 text-cta flex items-center justify-center mb-6">
                        <i class="bx {{ $item['icon'] }} text-2xl" aria-hidden="true"></i>
                    </div>
                    <h3 class="font-heading text-navy text-2xl mb-4">{{ $item['title'] }}</h3>
                    <div class="text-muted text-sm leading-7 prose max-w-none">{!! $item['body'] !!}</div>
                </article>
            @endforeach
        </div>
    </div>
</section>

<section class="py-20 lg:py-28 bg-[linear-gradient(180deg,#FFFFFF_0%,#EFF6FF_100%)]" aria-label="Services">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="max-w-3xl mb-12 reveal">
            @if($settings?->services_eyebrow)<p class="section-kicker text-steel text-xs font-semibold uppercase mb-4">{{ $settings->services_eyebrow }}</p>@endif
            <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl text-navy mb-4">{{ $settings?->services_heading }}</h2>
            <p class="text-muted text-lg leading-relaxed">{{ $settings?->services_intro }}</p>
        </div>

        <div class="grid sm:grid-cols-2 gap-6 mb-10">
            @foreach($services as $index => $service)
                @php($icons = ['bx-network-chart', 'bx-briefcase', 'bx-trending-up', 'bx-bulb', 'bx-book-open', 'bx-group'])
                <article class="service-card group relative border border-border rounded-xl p-7 bg-white hover:shadow-[0_16px_48px_rgba(15,23,42,0.10)] hover:-translate-y-1 transition-all duration-300 reveal overflow-hidden">
                    <div class="absolute top-0 left-0 right-0 h-1 bg-cta opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                    <div class="flex items-start gap-5">
                        <div class="service-icon flex-shrink-0 w-12 h-12 rounded-lg bg-blue-50 text-cta flex items-center justify-center text-2xl">
                            <i class="bx {{ $icons[$index % count($icons)] }}"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3 mb-3">
                                <h3 class="font-heading text-xl text-navy leading-snug">{{ $service->title }}</h3>
                                @if($service->status === 'coming_soon')<div class="flex-shrink-0 text-xs bg-amber-50 text-amber-600 border border-amber-200 px-2.5 py-1 rounded-full font-medium">Coming Soon</div>@endif
                            </div>
                            <p class="text-muted text-sm leading-relaxed">{{ $service->description }}</p>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        @if($settings?->transparency_note_title)
            <aside class="border border-border bg-white px-6 lg:px-8 py-7 rounded-xl reveal">
                <p class="text-steel text-xs font-semibold uppercase mb-3">Transparency Note</p>
                <h4 class="text-navy font-semibold mb-3">{{ $settings->transparency_note_title }}</h4>
                <div class="text-body text-sm leading-7 mb-3 prose max-w-none">{!! $settings->transparency_note_body !!}</div>
                @if($settings->transparency_note_disclaimer)<p class="text-muted text-xs italic">{{ $settings->transparency_note_disclaimer }}</p>@endif
            </aside>
        @endif
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
