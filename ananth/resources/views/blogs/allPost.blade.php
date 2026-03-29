@extends('layouts.front')
@section('title', 'Latest Blogs & Articles')
@section('description', 'Explore Latest Blogs & Articles')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('blog') . '/')

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
                <div class="col-12">
                    <div class="headingMain text-center">
                        <h1>Latest Blogs & Articles</h1>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bothPadding">
        <div class="container">
            <div class="row">
                @if ($allPost->currentPage() == 1)
                    @if ($featured != null)
                        <div class="col-lg-4 col-md-6 mt-4">
                            <div class="postCard">
                                <img src="{{ asset('media/' . $featured->thumbnail) }}" alt="{!! $featured->title !!}">
                                <h3><a title="{!! $featured->title !!}"
                                        href="/{{ $featured->slug }}">{!! $featured->title !!}</a>
                                </h3>
                                <p>{{ strip_tags(Str::limit($featured->content ?? $featured->description, 120)) }}</p>
                                {{-- <span>{{ $featured->created_at->toFormattedDateString() }}</span> --}}
                            </div>
                        </div>
                    @endif
                @endif
                @foreach ($allPost as $item)
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
                        {{ $allPost->links() }}
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
