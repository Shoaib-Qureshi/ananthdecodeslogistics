@extends('layouts.front')
@section('title', 'Board Insights | Ananth Decodes Logistics')
@section('description', 'Explore latest Board Insight')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('board-insights') . '/')

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
                        <h1>Board Insights</h1>
                        <p>Gain valuable perspectives and strategic insights from industry leaders and board members driving
                            change in logistics and transportation businesses.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bothPadding">
        <div class="container">
            <div class="row">
                @if (count($insightList) > 0)
                    @foreach ($insightList as $item)
                        <div class="col-lg-12 col-md-10 mb-4">
                            <div class="postCard">
                                <h3><a title="{!! $item->title !!}"
                                        href="/board-insights/{{ $item->slug }}/">{!! $item->title !!}</a>
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
                    {{ $insightList->links() }}
                </div>
            </div>
        </div>
    </section>

@endsection
