@extends('layouts.front')

@section('img', asset('media/' . $article->thumbnail))
@section('title', $article->title)
@section('description', Str::limit(strip_tags($article->content), 160))
@section('url', asset($article->slug))
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
                <div class="col-lg-6">
                    <div class="headingMain">
                        <a href="/topic/{{ $article->category_slug }}"><span
                                class="topicName">{{ $article->category_name }}</span></a>
                        <h1>{!! $article->title !!}</h1>
                        <div class="userDetails">
                            <img src="{{ asset('img/site/' . $article->profile_pic) }}" alt="{!! $article->name !!}">
                            <div>
                                <h5>by <a href="/author/{{ $article->username }}">{{ $article->name }}</a></h5>
                                <p>
                                    <!--{{ $article->created_at->toFormattedDateString() }} -->
                                    <span></span> {{ $readingTime }} Mins Read</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="headingBanner">
                        <img src="{{ asset('media/' . $article->thumbnail) }}" alt="!! $article->title !!}">
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bothPadding">
        <div class="container">
            <div class="row justify-content-center">
                @if(count($tableOfContents) > 0)
                    <div class="col-lg-2 col-md-4">
                        <aside class="contentIndex">
                            <p><strong>Table of Contents</strong></p>
                            <ul>
                                @foreach ($tableOfContents as $item)
                                    <li><a href="#{{ $item['id'] }}">{{ $item['text'] }}</a></li>
                                @endforeach
                            </ul>
                        </aside>
                    </div>
                    <div class="col-lg-7 col-md-8">
                @else
                    <div class="col-lg-8 col-md-8">
                @endif
                        <div class="mainContent articleContent">
                            {!! $htmlContent !!}
                        </div>

                        @include('partials.article-faq', [
                            'faqItems' => ($article->has_faqs ?? false) ? ($article->faqs ?? []) : [],
                            'sectionId' => 'article-faqs',
                        ])

                        @php
                            $profileImage = $founderProfile->image ?? null;
                            $profileName = $founderProfile->heading ?? ($author->name ?? '');
                            $profileTitle = $founderProfile->subheading ?? ($author->designation ?? '');
                            $profileContent = $founderProfile->content ?? ($author->intro ?? '');
                        @endphp
                        <div class="overviewCard authorCard">
                            <div class="founderImg">
                                <img src="{{ $profileImage ? asset($profileImage) : (isset($author->profile_pic) ? asset('img/site/' . $author->profile_pic) : '/img/site/blank-picture.webp') }}" alt="{{ $profileName }}">
                                <div>
                                    <h4>{{ $profileName }}</h4>
                                    <span>{{ $profileTitle }}</span>
                                </div>
                            </div>
                            @if($profileContent)
                                <p>{!! nl2br(e($profileContent)) !!}</p>
                            @endif
                            <div class="footerSocial">
                                <ul>
                                    @if (!empty($author->insta))
                                        <li><a href="{{ $author->insta }}"><i class='bx bxl-instagram-alt'></i></a></li>
                                    @endif
                                    @if (!empty($author->linkedin))
                                        <li><a href="{{ $author->linkedin }}"><i class='bx bxl-linkedin'></i></a></li>
                                    @endif
                                    @if (!empty($author->twitter))
                                        <li>
                                            <a href="{{ $author->twitter }}">
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
                                            </a>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>

                    @php
                        $filteredRelated = $related->where('id', '!=', $article->id)->take(8);
                    @endphp
                    @if($filteredRelated->isNotEmpty())
                        <div class="col-lg-3 col-md-12">
                            <div class="relatedArticle">
                                <h3>Read More</h3>
                                <ul>
                                    @foreach ($filteredRelated as $item)
                                        <li><a href="/{{ $item->slug }}">{{ $item->title }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
            </div>
        </div>
    </section>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const currentDomain = window.location.hostname;
            const contentSection = document.querySelector(".mainContent");
    
            if (contentSection) {
                const links = contentSection.querySelectorAll("a[href]");
    
                links.forEach(function(link) {
                    const href = link.getAttribute("href");
    
                    // Check if link is external
                    if (
                        href.startsWith("http") &&
                        !href.includes(currentDomain)
                    ) {
                        link.setAttribute("target", "_blank");
                        // link.setAttribute("rel", "noopener noreferrer");
                    }
                });
            }
        });
    </script>
@endsection
