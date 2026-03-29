@extends('layouts.front')
@section('title', 'Book Reviews')
@section('description', 'Explore Book Reviews')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('book-review') . '/')

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
                        <h1>Book Reviews</h1>
                        <p>Discover insightful summaries and honest opinions on a wide range of books. Whether you're
                            looking for your next great read or just curious about a title, our reviews offer thoughtful
                            reflections to guide your reading journey.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bookListing">
        <div class="container">
            <div class="row">
                 @if (count($listBook) > 0)
                    @foreach ($listBook as $item)
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="bookCard">
                                <img src="{{ '/img/thumbnail/' . $item->cover }}" alt="{{ $item->name }}">
                                <div class="bookCardMeta">
                                    <h3><a href="/book-review/{{ $item->slug }}/">{{ $item->name }}</a></h3>
                                    <p>by <span>{{ $item->author }}</span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <h3 class="text-center">No book reviews posted yet!</h3>
                @endif
            </div>
        </div>
    </section>
@endsection
