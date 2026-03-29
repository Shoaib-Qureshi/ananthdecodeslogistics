@extends('layouts.front')

@section('img', asset('img/thumbnail/' . $bookDetail->cover))
@section('title', $bookDetail->name)
@section('description', Str::limit($bookDetail->short_description, 160))
@section('url', asset('book-review/' . $bookDetail->slug) . '/')
@section('content')
    <style>
        header {
            position: sticky;
            top: 0;
            background-color: var(--white) !important;
        }
    </style>

    <section class="bothPadding gradientBg">
        <div class="container">
            <div class="col-lg-8 m-auto">
                <div class="row">
                    <div class="col-lg-4 col-md-5">
                        <div class="bookCover">
                            <img src="{{ '/img/thumbnail/' . $bookDetail->cover }}" alt="">
                        </div>
                    </div>
                    <div class="col-lg-8 col-md-7">
                        <div class="bookMeta">
                            <p class="bookGenre">Genre: <span>{{ $bookDetail->genre }}</span></p>
                            <h1>{{ $bookDetail->name }}</h1>
                            by <span class="bookAuthor">{{ $bookDetail->author }}</span>
                            <span class="bookPublished">Published: {{ $bookDetail->published }}</span>
                            <h3>Overview</h3>
                            <div class="bookOverview">
                                <p>{{ $bookDetail->short_description }}</p>
                            </div>
                            @if(!empty($bookDetail->buy_link))
                                <a href="{{ $bookDetail->buy_link }}"><button class="siteBtn bookBuy">Buy This Book</button></a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bothPadding">
        <div class="container">
            <div class="col-lg-8 m-auto">
                <div class="mainContent">
                    <h2 style="margin-top:0;">Detailed Review</h2>
                    {!! $bookDetail->detail_review !!}
                </div>
                <div class="overviewCard authorCard mt-4">
                    <div class="founderImg">
                        <img src="/img/site/anantha-profile.webp" alt="">
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
                            <li><a href="https://www.instagram.com/janaananthakrishnan/"><i class="bx bxl-instagram-alt"></i></a></li>
                            <li><a href="https://www.linkedin.com/in/ananthakrishnan-janardhanan/"><i class="bx bxl-linkedin"></i></a></li>
                            <li><a href="https://x.com/Anantha80112802/">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14">
                                        <g fill="none">
                                            <g clip-path="url(#primeTwitter0)">
                                                <path fill="currentColor"
                                                    d="M11.025.656h2.147L8.482 6.03L14 13.344H9.68L6.294 8.909l-3.87 4.435H.275l5.016-5.75L0 .657h4.43L7.486 4.71zm-.755 11.4h1.19L3.78 1.877H2.504z">
                                                </path>
                                            </g>
                                            <defs>
                                                <clipPath id="primeTwitter0">
                                                    <path fill="#fff" d="M0 0h14v14H0z"></path>
                                                </clipPath>
                                            </defs>
                                        </g>
                                    </svg>
                                </a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
