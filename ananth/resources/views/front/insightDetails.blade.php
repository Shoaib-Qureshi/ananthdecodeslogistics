@extends('layouts.front')

@section('img', asset('img/site-banner.jpg'))
@section('title', $insightDetails->title)
@section('description', Str::limit(strip_tags($insightDetails->content), 160))
@section('url', asset('board-insights/' . $insightDetails->slug) . '/')
@section('content')
    <style>
        header {
            position: sticky;
            top: 0;
            background-color: var(--white) !important;
        }
    </style>
    <section class="gradientBg bothPadding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-9">
                    <div class="headingMain">
                        <a href="/board-insights/"><span class="topicName">Board Insights</span></a>
                        <h1>{!! $insightDetails->title !!}</h1>
                        <div class="userDetails">
                            {{-- <img src="{{ asset('img/site/' . $article->profile_pic) }}" alt="{!! $article->name !!}"> --}}
                            <div>
                                {{-- <h5>by <a href="/author/{{ $article->username }}/">{{ $article->name }}</a></h5> --}}
                                <p>{{ $insightDetails->created_at->toFormattedDateString() }} <span></span>
                                    {{ $readingTime }}
                                    Mins Read</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bothPadding">
        <div class="container">
            <div class="row justify-content-center">
                @if (count($tableOfContents) > 0)
                    <div class="col-lg-2 col-md-4">
                        @if (count($tableOfContents) > 0)
                            <div class="contentIndex">
                                <p><strong>Table of Contents</strong></p>
                                <ul>
                                    @foreach ($tableOfContents as $item)
                                        <li><a href="#{{ $item['id'] }}">{{ $item['text'] }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                @endif
                <div class="col-lg-7 col-md-8">
                    <div class="mainContent">
                        {!! $htmlContent !!}
                    </div>
                    {{-- <div class="overviewCard authorCard">
                        <div class="founderImg">
                            <img src="/img/site/founder.jpeg" alt="">
                            <div>
                                <h4>Ananthakrishnan J</h4>
                                <span>CEO and Founder</span>
                            </div>
                        </div>
                        <p>Visionary logistics leader with 25+ years of global experience driving innovation,
                            efficiency, and sustainability in
                            transport and facility management. Passionate about transformation, teamwork, and
                            future-ready supply chains.</p>

                        <div class="footerSocial">
                            <ul>
                                <li><a href=""><i class='bx bxl-instagram-alt'></i></a></li>
                                <li><a href=""><i class='bx bxl-linkedin'></i></a></li>
                                <li><a href="">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
                                            <g fill="none">
                                                <g clip-path="url(#primeTwitter0)">
                                                    <path fill="currentColor"
                                                        d="M11.025.656h2.147L8.482 6.03L14 13.344H9.68L6.294 8.909l-3.87 4.435H.275l5.016-5.75L0 .657h4.43L7.486 4.71zm-.755 11.4h1.19L3.78 1.877H2.504z" />
                                                </g>
                                                <defs>
                                                    <clipPath id="primeTwitter0">
                                                        <path fill="#fff" d="M0 0h14v14H0z" />
                                                    </clipPath>
                                                </defs>
                                            </g>
                                        </svg>
                                    </a></li>
                            </ul>
                        </div>
                    </div> --}}
                </div>
                @if (count($related) > 0)
                    <div class="col-lg-3 col-md-12 ml-auto col-sm-12">
                        <div class="relatedArticle">
                            <h3>More Insights</h3>
                            <ul>
                                @foreach ($related as $item)
                                    <li><a href="/board-insights/{{ $item->slug }}/">{{ $item->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
