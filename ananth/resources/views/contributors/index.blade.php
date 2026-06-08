@extends('layouts.front')
@section('title', 'The Expert Desk - Ananth Decodes Logistics')
@section('description', 'A platform where verified experts share real-world insights across logistics, supply chain, finance, technology, and beyond.')
@section('img', asset('img/site-banner.jpg'))
@section('url', route('contributors.index'))

@section('styles')
<style>
    header { position: sticky; top: 0; background-color: var(--white) !important; }
    .cta-strip { background:#fff;border:1px solid #d8e3f0;border-radius:18px;padding:1.25rem 1.75rem;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-top:3rem;box-shadow:0 14px 40px rgba(15,23,42,.06); }
    .cta-strip p { margin:0;color:#334155;font-size:.9rem; }
    .cta-strip a { padding:.75rem 1.35rem;font-weight:700;font-size:.875rem;text-decoration:none;white-space:nowrap;transition:background .2s; }
</style>
@endsection

@section('content')
@include('partials.page-banner', [
    'banner' => $banner ?? null,
    'fallbackHeading' => 'The Expert Desk',
    'fallbackSubheading' => 'A multi-domain platform where verified experts share real-world insights.',
])

<section class="adl-resource-section">
    <div class="adl-resource-container">
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($posts as $post)
                <article>
                    <a href="{{ route('contributors.show', $post->slug) }}" class="group block h-full bg-white rounded-xl overflow-hidden border border-border hover:border-cta/35 hover:shadow-[0_18px_50px_rgba(15,23,42,0.12)] hover:-translate-y-1 transition-all duration-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-cta focus-visible:ring-offset-2">
                        <div class="relative aspect-[16/9] bg-softbg overflow-hidden">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105" loading="lazy" onerror="this.onerror=null;this.src='{{ asset(\App\Models\ContributorPost::DEFAULT_FEATURED_IMAGE) }}';">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/55 via-navy/0 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300" aria-hidden="true"></div>
                            @if($post->is_featured)
                                <p class="absolute left-4 top-4 rounded-full bg-white/92 px-3 py-1 text-xs font-semibold text-cta shadow-sm">Featured</p>
                            @endif
                        </div>

                        <div class="p-6 flex flex-col min-h-[260px]">
                            @if($post->category)
                                <p class="inline-block text-xs font-semibold text-cta bg-cta/10 border border-cta/20 px-2.5 py-1 rounded-full mb-3 self-start">{{ $post->category->category_name ?? $post->category->name }}</p>
                            @endif

                            <h3 class="font-heading text-xl text-navy leading-snug mb-3 group-hover:text-cta transition-colors">{{ $post->title }}</h3>

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
                                    <p class="text-xs font-medium text-body truncate">{{ $post->author?->name ?? 'ADL Contributor' }}</p>
                                </div>
                                <p class="text-xs text-muted flex-shrink-0">{{ $post->published_at?->format('d M Y') }}</p>
                            </div>

                            <div class="inline-flex items-center gap-1.5 mt-4 text-cta text-sm font-semibold">
                                Read Article
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                            </div>
                        </div>
                    </a>
                </article>
            @empty
                <div class="adl-resource-empty">No Expert Desk posts are published yet. Check back soon.</div>
            @endforelse
        </div>

        @if($posts->hasPages())
            <div class="adl-resource-pagination">{{ $posts->links() }}</div>
        @endif

        <div class="cta-strip">
            <p><strong>Are you a logistics professional?</strong> Share your expertise with our readers through The Expert Desk.</p>
            <a href="{{ route('contributor.register') }}">Apply to The Expert Desk</a>
        </div>
    </div>
</section>
@endsection
