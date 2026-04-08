@extends('layouts.front')
@section('title', 'Ananth Decodes Logistics')
@section('description', 'Ananthakrishnan J is a seasoned executive and strategic leader with over 25 years of distinguished experience in transport, logistics, and integrated facility management.')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('/'))

@section('content')

    <section class="heroBanner" style="background-image: url('{{ isset($homeContent['hero_banner']) && $homeContent['hero_banner']->image ? asset($homeContent['hero_banner']->image) : '/img/site/About-us-banner.jpg' }}');">
        <div class="container">
            <div class="row" data-aos="fade-up" data-aos-delay="50">
                <div class="col-lg-6">
                    <div class="homeText">
                        <h1>{!! isset($homeContent['hero_banner']) && $homeContent['hero_banner']->heading ? $homeContent['hero_banner']->heading : 'Your journey in logistics made <span>simpler.</span>' !!}</h1>
                        <p>{{ isset($homeContent['hero_banner']) && $homeContent['hero_banner']->subheading ? $homeContent['hero_banner']->subheading : 'Your daily route to supply chain intelligence.' }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bothPadding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="homeAbout">
                        <img src="{{ isset($homeContent['about_section']) && $homeContent['about_section']->image ? asset($homeContent['about_section']->image) : '/img/site/anantha-home-banner.jpg' }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="homeAbout">
                        <span class="tinyTitle">ABOUT</span>
                        <h2>{{ isset($homeContent['about_section']) && $homeContent['about_section']->heading ? $homeContent['about_section']->heading : 'Ananthakrishnan J' }}</h2>
                        <p>{{ isset($homeContent['about_section']) && $homeContent['about_section']->content ? $homeContent['about_section']->content : 'Ananthakrishnan J is a seasoned executive and strategic leader with over 25 years of distinguished experience in transport, logistics, and integrated facility management.' }}</p>

                        <img class="signature" src="/img/site/ananth-signature.png" alt="">

                        <a href="{{ isset($homeContent['about_section']) && $homeContent['about_section']->button_link ? $homeContent['about_section']->button_link : '/about-us/' }}">
                            <button class="siteBtn">{{ isset($homeContent['about_section']) && $homeContent['about_section']->button_text ? $homeContent['about_section']->button_text : 'Know More' }}</button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bothPadding newsSection">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-8">
                    <div class="newsHeading">
                        <h3>Latest <span>Blogs</span></h3>
                    </div>
                </div>
                <div class="col-4">
                    <div class="newsButton text-end">
                        <a href="/blog/">
                            <button class="siteBtn viewBtn">View All</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
               @if($featured)
               <div class="col-lg-4 col-md-6 mt-4">
                    <div class="postCard">
                        <img src="{{ asset('media/' . $featured->thumbnail) }}" alt="{!! $featured->title !!}">
                        <h3><a title="{!! $featured->title !!}" href="/{{ $featured->slug }}/">{!! $featured->title !!}</a>
                        </h3>
                        <p>{{ strip_tags(Str::limit($featured->content, 100)) }}</p>
                        <!--<span>{{ $featured->created_at->toFormattedDateString() }}</span>-->
                    </div>
                </div>
               @endif
                @foreach ($latest as $item)
                    <div class="col-lg-4 col-md-6 mt-4">
                        <div class="postCard">
                            <img src="{{ asset('media/' . $item->thumbnail) }}" alt="{!! $item->title !!}">
                            <h3><a title="{!! $item->title !!}" href="/{{ $item->slug }}/">{!! $item->title !!}</a>
                            </h3>
                            <p>{{ strip_tags(Str::limit($item->description, 100)) }}</p>
                            <!--<span>{{ $item->created_at->toFormattedDateString() }}</span>-->
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="featuredSection">
        <img src="/img/site/truck-bg-img-1.webp" alt="">
    </section>
    <section class="bothPadding">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="featuredText">
                        <h3>{!! isset($homeContent['featured_section']) && $homeContent['featured_section']->heading ? $homeContent['featured_section']->heading : 'Logistics Insights Backed by <span>25 Years of Experience</span>' !!}</h3>
                        <p>{{ isset($homeContent['featured_section']) && $homeContent['featured_section']->content ? $homeContent['featured_section']->content : 'Gain a deeper understanding of today\'s complex supply chain landscape.' }}</p>

                        <div class="ourNumbers">
                            <h4 class="number">{{ isset($homeContent['featured_section']) && $homeContent['featured_section']->stat_number ? $homeContent['featured_section']->stat_number : '97%' }}</h4>
                            <span class="fTitle">{!! isset($homeContent['featured_section']) && $homeContent['featured_section']->stat_label ? $homeContent['featured_section']->stat_label : 'Customer <br> Retention Rate' !!}</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="featuredBanner">
                        <img src="{{ isset($homeContent['featured_section']) && $homeContent['featured_section']->image ? asset($homeContent['featured_section']->image) : 'img/site/anantha-logistics.webp' }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if($featuredContributorPosts->count())
    <section class="bothPadding newsSection">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-8">
                    <div class="newsHeading">
                        <h3>Featured <span>Expert Desk Posts</span></h3>
                    </div>
                </div>
                <div class="col-4">
                    <div class="newsButton text-end">
                        <a href="{{ route('contributors.index') }}">
                            <button class="siteBtn viewBtn">View All</button>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                @foreach ($featuredContributorPosts as $item)
                    <div class="col-lg-4 col-md-6 mt-4">
                        <div class="postCard">
                            <img src="{{ $item->featured_image_url }}" alt="{{ $item->title }}">
                            <h3><a title="{{ $item->title }}" href="{{ route('contributors.show', $item->slug) }}">{{ $item->title }}</a></h3>
                            <p>{{ strip_tags(Str::limit($item->body, 100)) }}</p>
                            <span>{{ $item->author->name }}{{ $item->author->designation ? ' • ' . $item->author->designation : '' }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif


@endsection
