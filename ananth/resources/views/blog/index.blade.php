@extends('layouts.front')
@section('title', 'Editorial Insights - Ananth Decodes Logistics')
@section('description', 'In-depth analysis and editorial insights on logistics and supply chain by Ananthakrishnan J.')
@section('img', asset('img/site-banner.jpg'))
@section('url', url('blog'))

@section('styles')
<style>
    header { position: sticky; top: 0; background-color: var(--white) !important; }
</style>
@endsection

@section('content')
@include('partials.page-banner', [
    'banner' => $banner ?? null,
    'fallbackHeading' => 'Editorial Insights',
    'fallbackSubheading' => 'Written by Ananthakrishnan J - analysis, opinion, and deep-dives on global logistics.',
])

<section class="adl-resource-section">
    <div class="adl-resource-container">
        <div class="adl-resource-grid">
            @forelse($posts as $post)
                @php
                    $image = $post->thumbnail ? asset('media/' . $post->thumbnail) : asset('img/site-banner.jpg');
                @endphp
                <a class="adl-resource-card" href="{{ route('blog.show', $post->slug) }}" title="{{ $post->title }}">
                    <div class="adl-resource-card__media">
                        <img src="{{ $image }}" alt="{{ $post->title }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('img/site-banner.jpg') }}';">
                    </div>
                    <div class="adl-resource-card__body">
                        <div class="adl-resource-card__meta">
                            <span>{{ $post->created_at->format('d M Y') }}</span>
                        </div>
                        <h3>{{ $post->title }}</h3>
                        <p>{{ Str::limit(strip_tags($post->content), 120) }}</p>
                        <span class="adl-resource-card__cta">Read More <i class="bx bx-right-arrow-alt" aria-hidden="true"></i></span>
                    </div>
                </a>
            @empty
                <div class="adl-resource-empty">No posts published yet. Check back soon.</div>
            @endforelse
        </div>

        @if($posts->hasPages())
            <div class="adl-resource-pagination">{{ $posts->links() }}</div>
        @endif
    </div>
</section>
@endsection
