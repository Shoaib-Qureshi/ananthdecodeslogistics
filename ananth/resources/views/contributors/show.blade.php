@extends('layouts.front')
@section('title', $post->title . ' - Ananth Decodes Logistics')
@section('description', Str::limit(strip_tags($post->body), 160))
@section('img', $post->featured_image_url)
@section('url', route('contributors.show', $post->slug))

@section('content')
<style>
    header { position: sticky; top: 0; background-color: var(--white) !important; }
    .contributor-badge {
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        background: rgba(255,255,255,0.15);
        border: 1px solid rgba(255,255,255,0.25);
        border-radius: 20px;
        padding: .25rem .75rem;
        font-size: .72rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: #fff;
        margin-bottom: .75rem;
    }
    .contributor-badge svg { width: 12px; height: 12px; }
</style>

<section class="gradientBg bothPadding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="headingMain">
                    <span class="contributor-badge">
                        <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                        Guest Contributor
                    </span>
                    @if($post->category)
                        <span class="topicName">{{ $post->category->category_name ?? $post->category->name }}</span>
                    @endif
                    <h1>{!! $post->title !!}</h1>
                    <div class="userDetails">
                        @if($post->author->profile_pic)
                            <img src="{{ asset('img/site/' . $post->author->profile_pic) }}" alt="{{ $post->author->name }}">
                        @else
                            <img src="{{ asset('img/blank-picture.webp') }}" alt="{{ $post->author->name }}">
                        @endif
                        <div>
                            <h5>{{ $post->author->name }}</h5>
                            <p><span></span> {{ $readingTime }} Mins Read</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="headingBanner">
                    <img src="{{ $post->featured_image_url }}" alt="{{ $post->title }}">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bothPadding">
    <div class="container">
        <div class="row justify-content-center articleLayoutRow">
            @if(count($tableOfContents) > 0)
                <div class="col-lg-3 col-md-4">
                    <aside class="contentIndex articleSideCard">
                        <p><strong>Table of Contents</strong></p>
                        <ul>
                            @foreach ($tableOfContents as $item)
                                <li><a href="#{{ $item['id'] }}">{{ $item['text'] }}</a></li>
                            @endforeach
                        </ul>
                    </aside>
                </div>
                <div class="col-lg-8 col-md-8 articleMainColumn">
            @else
                <div class="col-lg-8 articleMainColumn">
            @endif
                <div class="mainContent articleContent">
                    {!! $htmlContent !!}
                </div>

                <div class="overviewCard authorCard">
                    <div class="founderImg">
                        @if($post->author->profile_pic)
                            <img src="{{ asset('img/site/' . $post->author->profile_pic) }}" alt="{{ $post->author->name }}">
                        @else
                            <img src="{{ asset('img/blank-picture.webp') }}" alt="{{ $post->author->name }}">
                        @endif
                        <div>
                            <h4>{{ $post->author->name }}</h4>
                            <span>{{ $post->author->designation ?? 'Guest Contributor' }}</span>
                        </div>
                    </div>
                    @if($post->author->intro)
                        <p>{{ $post->author->intro }}</p>
                    @endif
                    <div class="footerSocial">
                        <ul>
                            @if (!empty($post->author->insta))
                                <li><a href="{{ $post->author->insta }}"><i class='bx bxl-instagram-alt'></i></a></li>
                            @endif
                            @if (!empty($post->author->linkedin))
                                <li><a href="{{ $post->author->linkedin }}"><i class='bx bxl-linkedin'></i></a></li>
                            @endif
                            @if (!empty($post->author->twitter))
                                <li>
                                    <a href="{{ $post->author->twitter }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
                                            <g fill="none">
                                                <g clip-path="url(#primeTwitter0Contributor)">
                                                    <path fill="currentColor"
                                                        d="M11.025.656h2.147L8.482 6.03L14 13.344H9.68L6.294 8.909l-3.87 4.435H.275l5.016-5.75L0 .657h4.43L7.486 4.71zm-.755 11.4h1.19L3.78 1.877H2.504z" />
                                                </g>
                                                <defs>
                                                    <clipPath id="primeTwitter0Contributor">
                                                        <path fill="#fff" d="M0 0h14v14H0z" />
                                                    </clipPath>
                                                </defs>
                                            </g>
                                        </svg>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                @if($related->isNotEmpty())
                    <div class="articleRelatedSection">
                        <h3>Read More</h3>
                        <div class="row">
                            @foreach($related as $rel)
                            <div class="col-md-4 mb-4">
                                <div class="postCard articleRelatedCard" style="height:100%;">
                                    <img src="{{ $rel->featured_image_url }}" alt="{{ $rel->title }}">
                                    <h3><a href="{{ route('contributors.show', $rel->slug) }}">{{ $rel->title }}</a></h3>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
        </div>
    </div>
</section>
@endsection
