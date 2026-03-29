@extends('layouts.front')
@section('title', $author->name . ' | Author Profile')
@section('description', 'Explore latest blogs published by ' . $author->name . '.')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('author/' . $author->username))

@section('content')
    <style>
        header {
            position: sticky;
            top: 0;
            background-color: var(--white) !important;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 0px 5px 0px !important;
        }
    </style>
    <section class="bothPadding lessPadding">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="overviewCard authorCard mb-4">
                        <div class="founderImg">
                            <img src="{{ asset('img/site/' . $author->profile_pic) }}" alt="{{ $author->name }}">
                            <div>
                                <h4>{{ $author->name }}</h4>
                                <span>{{ $author->designation }}</span>
                            </div>
                        </div>
                        <p>{{ $author->intro }}</p>
                        <div class="footerSocial">
                            <ul>
                                @if (!empty($author->insta))
                                    <li><a target="_blank" href="{{ $author->insta }}"><i class='bx bxl-instagram-alt'></i></a></li>
                                @endif

                                @if (!empty($author->linkedin))
                                    <li><a target="_blank" href="{{ $author->linkedin }}"><i class='bx bxl-linkedin'></i></a></li>
                                @endif
                                @if (!empty($author->twitter))
                                    <li>
                                        <a target="_blank" href="{{ $author->twitter }}">
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
                @foreach ($blogs as $item)
                    <div class="col-lg-4 col-md-6 mt-4">
                        <div class="postCard">
                            <img src="{{ asset('media/' . $item->thumbnail) }}" alt="{!! $item->title !!}">
                            <h3><a title="{!! $item->title !!}" href="/{{ $item->slug }}">{!! $item->title !!}</a>
                            </h3>
                            <p>{{ strip_tags(Str::limit($item->description, 100)) }}</p>
                            <!--<span>{{ $item->created_at->toFormattedDateString() }}</span>-->
                        </div>
                    </div>
                @endforeach
                <div class="col-12">
                    <div class="paginator">
                        {{ $blogs->links() }}
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
