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
    @include('partials.page-banner', [
        'banner' => $banner ?? null,
        'fallbackHeading' => 'Book Reviews',
        'fallbackSubheading' => 'Discover thoughtful reviews and practical reading takeaways for logistics and leadership-minded readers.',
    ])
    <section class="adl-resource-section">
        <div class="adl-resource-container">
            <div class="adl-resource-grid">
                 @if (count($listBook) > 0)
                    @foreach ($listBook as $item)
                        @php
                            $cover = $item->cover ? asset('img/thumbnail/' . $item->cover) : asset('img/site-banner.jpg');
                        @endphp
                        <a class="adl-resource-card" href="/book-review/{{ $item->slug }}/" title="{{ $item->name }}">
                            <div class="adl-resource-card__media">
                                <img src="{{ $cover }}" alt="{{ $item->name }}" loading="lazy" onerror="this.onerror=null;this.src='{{ asset('img/site-banner.jpg') }}';">
                            </div>
                            <div class="adl-resource-card__body">
                                <h3>{{ $item->name }}</h3>
                                <p>by {{ $item->author }}</p>
                                <span class="adl-resource-card__cta">Read Review <i class="bx bx-right-arrow-alt" aria-hidden="true"></i></span>
                            </div>
                        </a>
                    @endforeach
                @else
                    <div class="adl-resource-empty">No book reviews posted yet.</div>
                @endif
            </div>
        </div>
    </section>
@endsection
