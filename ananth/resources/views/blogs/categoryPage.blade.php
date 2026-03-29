@extends('layouts.front')
@section('title', $category->category_name)
@section('description', 'Explore latest publications in ' . $category->category_name . ' category.')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('topic/' . $category->category_slug))

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
            <div class="row">
                <div class="col-lg-7">
                    <div class="headingMain">
                        <h1>{{ $category->category_name }}</h1>
                        <p>{{ $category->category_desc }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bothPadding">
        <div class="container">
            <div class="row">
                @if ($featured != null)
                    <div class="col-lg-4 col-md-6 mt-4">
                        <div class="postCard">
                            <img src="{{ asset('media/' . $featured->thumbnail) }}" alt="{!! $featured->title !!}">
                            <h3><a title="{!! $featured->title !!}"
                                    href="/{{ $featured->slug }}">{!! $featured->title !!}</a>
                            </h3>
                            <p>{{ strip_tags(Str::limit($featured->description, 100)) }}</p>
                            {{-- <span>{{ $featured->created_at->toFormattedDateString() }}</span> --}}
                        </div>
                    </div>
                @endif
                @if (count($blogs) > 0)
                    @foreach ($blogs as $item)
                        <div class="col-lg-4 col-md-6 mt-4">
                            <div class="postCard">
                                <img src="{{ asset('media/' . $item->thumbnail) }}" alt="{!! $item->title !!}">
                                <h3><a title="{!! $item->title !!}"
                                        href="/{{ $item->slug }}">{!! $item->title !!}</a>
                                </h3>
                                <p>{{ strip_tags(Str::limit($item->description, 100)) }}</p>
                                <!--<span>{{ $item->created_at->toFormattedDateString() }}</span>-->
                            </div>
                        </div>
                    @endforeach
                @else
                    <h3 class="text-center">Our journey has just begun—content arriving shortly!</h3>
                @endif
                <div class="paginator">
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
    </section>

@endsection
