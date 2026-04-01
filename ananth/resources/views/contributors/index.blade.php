@extends('layouts.front')
@section('title', 'Contributors Blog — Ananth Decodes Logistics')
@section('description', 'Expert logistics and supply chain articles written by our approved guest contributors.')
@section('img', asset('img/site-banner.jpg'))
@section('url', url('contributors'))

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    header { position: sticky; top: 0; background-color: var(--white) !important; }
    .author-chip {
        display: flex;
        align-items: center;
        gap: .5rem;
        margin-top: .75rem;
        padding-top: .65rem;
        border-top: 1px solid #f0f0f0;
    }
    .author-avatar {
        width: 28px; height: 28px;
        border-radius: 50%;
        background: #3882fa;
        color: #fff;
        display: flex; align-items: center; justify-content: center;
        font-size: .7rem;
        font-weight: 700;
        flex-shrink: 0;
    }
    .author-info { line-height: 1.3; }
    .author-name { font-size: .8rem; font-weight: 600; color: #333; }
    .author-role { font-size: .72rem; color: #636363; }
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
                    <p>Expert perspectives</p>
                    <h1>Contributors Blog</h1>
                    <p style="max-width:560px;margin:1rem auto 0;opacity:.85;">
                        Real-world insights from approved logistics &amp; supply chain professionals.
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

                        <h3>
                            <a href="{{ route('contributors.show', $post->slug) }}" title="{{ $post->title }}">
                                {{ $post->title }}
                            </a>
                        </h3>
                        <p>{{ Str::limit(strip_tags($post->body), 115) }}</p>
                        <span>{{ $post->published_at?->format('d M Y') }}</span>

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
            @empty
                <div class="col-12 text-center" style="padding:4rem 0;">
                    <p style="color:#636363;font-size:1rem;">No contributor posts published yet. Check back soon.</p>
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
            <p><strong>Are you a logistics professional?</strong> Share your expertise with our readers.</p>
            <a href="{{ route('contributor.register') }}">Apply to Contribute →</a>
        </div>

    </div>
</section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection
