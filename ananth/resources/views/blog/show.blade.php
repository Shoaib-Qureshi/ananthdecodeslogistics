@extends('layouts.front')
@section('title', $post->title . ' — Ananth Decodes Logistics')
@section('description', Str::limit(strip_tags($post->content), 160))
@section('img', $post->thumbnail ? asset('media/' . $post->thumbnail) : asset('img/site-banner.jpg'))
@section('url', route('blog.show', $post->slug))

@section('content')
<style>header { position:sticky; top:0; background-color:var(--white) !important; }</style>

<section class="gradientBg bothPadding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="headingMain">
                    <span class="topicName">Editorial</span>
                    <h1>{!! $post->title !!}</h1>
                    <div class="userDetails">
                        @if($post->user && $post->user->profile_pic)
                            <img src="{{ asset('img/site/' . $post->user->profile_pic) }}" alt="{{ $post->user->name ?? 'Author' }}">
                        @endif
                        <div>
                            <h5>by {{ $post->user->name ?? 'Ananthakrishnan J' }}</h5>
                            <p><span></span> {{ $readingTime }} Mins Read</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="headingBanner">
                    <img src="{{ $post->thumbnail ? asset('media/' . $post->thumbnail) : asset('img/site-banner.jpg') }}" alt="{{ $post->title }}">
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

                @if($post->user)
                    <div class="overviewCard authorCard">
                        <div class="founderImg">
                            @if($post->user->profile_pic)
                                <img src="{{ asset('img/site/' . $post->user->profile_pic) }}" alt="{{ $post->user->name }}">
                            @else
                                <img src="{{ asset('img/blank-picture.webp') }}" alt="{{ $post->user->name }}">
                            @endif
                            <div>
                                <h4>{{ $post->user->name }}</h4>
                                <span>{{ $post->user->designation ?? 'Author' }}</span>
                            </div>
                        </div>
                        @if($post->user->intro)
                            <p>{{ $post->user->intro }}</p>
                        @endif
                        <div class="footerSocial">
                            <ul>
                                @if (!empty($post->user->insta))
                                    <li><a href="{{ $post->user->insta }}"><i class='bx bxl-instagram-alt'></i></a></li>
                                @endif
                                @if (!empty($post->user->linkedin))
                                    <li><a href="{{ $post->user->linkedin }}"><i class='bx bxl-linkedin'></i></a></li>
                                @endif
                                @if (!empty($post->user->twitter))
                                    <li>
                                        <a href="{{ $post->user->twitter }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
                                                <g fill="none">
                                                    <g clip-path="url(#primeTwitter0Blog)">
                                                        <path fill="currentColor"
                                                            d="M11.025.656h2.147L8.482 6.03L14 13.344H9.68L6.294 8.909l-3.87 4.435H.275l5.016-5.75L0 .657h4.43L7.486 4.71zm-.755 11.4h1.19L3.78 1.877H2.504z" />
                                                    </g>
                                                    <defs>
                                                        <clipPath id="primeTwitter0Blog">
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
                @endif

                @if($related->isNotEmpty())
                    <div class="articleRelatedSection">
                        <h3>Read More</h3>
                        <div class="row">
                            @foreach($related as $rel)
                            <div class="col-md-4 mb-4">
                                <div class="postCard articleRelatedCard" style="height:100%;">
                                    @if($rel->thumbnail)
                                        <img src="{{ asset('media/' . $rel->thumbnail) }}" alt="{{ $rel->title }}">
                                    @endif
                                    <h3><a href="{{ route('blog.show', $rel->slug) }}">{{ $rel->title }}</a></h3>
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
