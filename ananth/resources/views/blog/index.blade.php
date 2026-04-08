@extends('layouts.front')
@section('title', 'Editorial Insights — Ananth Decodes Logistics')
@section('description', 'In-depth analysis and editorial insights on logistics and supply chain by Ananthakrishnan J.')
@section('img', asset('img/site-banner.jpg'))
@section('url', url('blog'))

@section('styles')
<style>
    header { position: sticky; top: 0; background-color: var(--white) !important; }
    .postCard {
        display: flex;
        flex-direction: column;
    }
    .postCard p {
        margin-bottom: 14px;
    }
    .postCard .post-date {
        margin-bottom: 7px;
    }
    .post-readmore {
        margin-top: auto;
        margin-bottom: 6px;
        padding-top: 10px;
        position: relative;
        z-index: 2;
        display: inline-flex;
        align-items: center;
        align-self: flex-start;
        padding: .55rem 1rem;
        border-radius: 999px;
        background: #edf2ff;
        color: var(--dark-blue);
        font-size: .88rem;
        font-weight: 600;
        text-decoration: none;
        transition: background .2s ease, color .2s ease;
    }
    .post-readmore:hover {
        background: var(--primary-color);
        color: var(--white);
    }
    .blog-hero-copy {
        color: #555;
        max-width: 560px;
        margin: 1rem auto 0;
    }
    .blog-pagination nav {
        width: auto;
    }
    .blog-pagination .pagination {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: .65rem;
        padding-left: 0;
        margin-bottom: 0;
        list-style: none;
    }
    .blog-pagination .page-item {
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .blog-pagination .page-link,
    .blog-pagination .page-item span {
        min-width: 42px;
        height: 42px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 999px;
        background: #edf2ff;
        color: var(--dark-blue);
        font-weight: 600;
        text-decoration: none;
        border: none;
        padding: 0 .9rem;
    }
    .blog-pagination .page-item.active span,
    .blog-pagination .page-item.active .page-link {
        background: var(--primary-color);
        color: var(--white);
    }
    .blog-pagination .page-item.disabled span,
    .blog-pagination .page-item.disabled .page-link {
        opacity: .45;
    }
</style>
@endsection

@section('content')
<section class="gradientBg bothPadding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="headingMain text-center">
                    <h1>Editorial Insights</h1>
                    <p class="blog-hero-copy">Written by <strong>Ananthakrishnan J</strong> — analysis, opinion, and deep-dives on global logistics.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bothPadding">
    <div class="container">
        <div class="row">
            @forelse($posts as $post)
                <div class="col-lg-4 col-md-6 mt-4">
                    <div class="postCard">
                        @if($post->thumbnail)
                            <img src="{{ asset('media/' . $post->thumbnail) }}" alt="{{ $post->title }}">
                        @else
                            <img src="{{ asset('img/site-banner.jpg') }}" alt="{{ $post->title }}">
                        @endif
                        <span class="post-date">{{ $post->created_at->format('d M Y') }}</span>
                        <h3><a href="{{ route('blog.show', $post->slug) }}" title="{{ $post->title }}">{{ $post->title }}</a></h3>
                        <p>{{ Str::limit(strip_tags($post->content), 120) }}</p>
                        <a class="post-readmore" href="{{ route('blog.show', $post->slug) }}">Read More</a>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No posts published yet. Check back soon.</p>
                </div>
            @endforelse
        </div>

        @if($posts->hasPages())
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center blog-pagination">
                    {{ $posts->links() }}
                </div>
            </div>
        @endif
    </div>
</section>
@endsection
