@extends('layouts.front')
@section('title', 'The Expert Desk - Ananth Decodes Logistics')
@section('description', 'A multi-domain platform where verified experts share real-world insights across logistics, supply chain, finance, technology, and beyond.')
@section('img', asset('img/site-banner.jpg'))
@section('url', route('contributors.index'))

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    header { position: sticky; top: 0; background-color: var(--white) !important; }
    .postCard {
        display: flex;
        flex-direction: column;
    }
    .postCard h3 { margin-bottom: 12px; }
    .postCard h3 a {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .postCard .contributor-excerpt {
        margin-bottom: 0;
        color: #526070;
        line-height: 1.65;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .postCard .post-date { margin-bottom: 10px; }
    .contributor-card-footer {
        margin-top: auto;
        padding-top: 16px;
        border-top: 1px solid #edf2f7;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }
    .author-chip {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-top: 0;
        padding-top: 0;
        border-top: none;
    }
    .author-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #3882fa;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: .78rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    .author-info { line-height: 1.3; }
    .author-name { font-size: .9rem; font-weight: 600; color: #1f2937; }
    .author-role {
        font-size: .76rem;
        color: #64748b;
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cta-strip {
        background: #f3f7ff;
        border: 1px solid #dbeafe;
        border-radius: 12px;
        padding: 1.25rem 1.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
        margin-top: 3rem;
    }
    .cta-strip p { margin: 0; color: #334155; font-size: .9rem; }
    .cta-strip a {
        background: #3882fa;
        color: #fff;
        padding: .5rem 1.25rem;
        border-radius: 8px;
        font-weight: 600;
        font-size: .875rem;
        text-decoration: none;
        white-space: nowrap;
        transition: background .2s;
    }
    .cta-strip a:hover { background: #2563d4; color: #fff; }
</style>
@endsection

@section('content')
<section class="gradientBg bothPadding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="headingMain text-center">
                    <p>Expert Perspectives</p>
                    <h1>The Expert Desk</h1>
                    <p style="max-width:580px;margin:1rem auto 0;opacity:.85;">
                        A multi-domain platform where verified experts share real-world insights.
                        Covering logistics, supply chain, finance, technology, and beyond.
                        Built to help you think better, decide faster, and grow stronger.
                    </p>
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
                        <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}">
                        <span class="post-date">{{ $post->published_at?->format('d M Y') }}</span>

                        <h3>
                            <a href="{{ route('contributors.show', $post->slug) }}" title="{{ $post->title }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p class="contributor-excerpt">{{ Str::limit(trim(html_entity_decode(strip_tags($post->body), ENT_QUOTES | ENT_HTML5, 'UTF-8')), 120) }}</p>

                        <div class="contributor-card-footer">
                            <div class="author-chip">
                                <div class="author-avatar">{{ strtoupper(substr($post->author->name, 0, 1)) }}</div>
                                <div class="author-info">
                                    <div class="author-name">{{ $post->author->name }}</div>
                                    @if($post->author->designation)
                                        <div class="author-role">{{ $post->author->designation }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center" style="padding:4rem 0;">
                    <p style="color:#636363;font-size:1rem;">No Expert Desk posts are published yet. Check back soon.</p>
                </div>
            @endforelse
        </div>

        @if($posts->hasPages())
            <div class="row mt-5">
                <div class="col-12 d-flex justify-content-center">
                    {{ $posts->links() }}
                </div>
            </div>
        @endif

        <div class="cta-strip">
            <p><strong>Are you a logistics professional?</strong> Share your expertise with our readers through The Expert Desk.</p>
            <a href="{{ route('contributor.register') }}">Apply to The Expert Desk</a>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
