@extends('layouts.front')
@section('title', 'The Expert Desk - Ananth Decodes Logistics')
@section('description', 'A platform where verified experts share real-world insights across logistics, supply chain, finance, technology, and beyond.')
@section('img', asset('img/site-banner.jpg'))
@section('url', route('contributors.index'))

@section('styles')
<style>
    header { position: sticky; top: 0; background-color: var(--white) !important; }
    .contributor-card-footer { margin-top:auto;padding-top:16px;border-top:1px solid #d8e3f0;display:flex;flex-direction:column;gap:14px; }
    .author-chip { display:flex;align-items:center;gap:.5rem; }
    .author-avatar { width:34px;height:34px;border-radius:50%;background:#2562E9;color:#fff;display:flex;align-items:center;justify-content:center;font-size:.78rem;font-weight:700;flex-shrink:0; }
    .author-name { font-size:.9rem;font-weight:700;color:#0f172a; }
    .author-role { font-size:.76rem;color:#64748b;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden; }
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
        <div class="adl-resource-grid">
            @forelse($posts as $post)
                <a class="adl-resource-card" href="{{ route('contributors.show', $post->slug) }}" title="{{ $post->title }}">
                    <div class="adl-resource-card__media">
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset(\App\Models\ContributorPost::DEFAULT_FEATURED_IMAGE) }}';">
                    </div>
                    <div class="adl-resource-card__body">
                        <div class="adl-resource-card__meta">
                            <span>{{ $post->published_at?->format('d M Y') }}</span>
                        </div>
                        <h3>{{ $post->title }}</h3>
                        <p class="contributor-excerpt">{{ Str::limit(trim(html_entity_decode(strip_tags($post->body), ENT_QUOTES | ENT_HTML5, 'UTF-8')), 120) }}</p>
                        <div class="contributor-card-footer">
                            <div class="author-chip">
                                <div class="author-avatar">{{ strtoupper(substr($post->author?->name ?? 'A', 0, 1)) }}</div>
                                <div>
                                    <div class="author-name">{{ $post->author?->name ?? 'ADL Contributor' }}</div>
                                    @if($post->author?->designation)<div class="author-role">{{ $post->author->designation }}</div>@endif
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
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
