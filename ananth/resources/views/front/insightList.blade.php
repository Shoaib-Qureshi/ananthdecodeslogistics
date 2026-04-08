@extends('layouts.front')
@section('title', 'Board Insights | Ananth Decodes Logistics')
@section('description', 'Board-level perspectives on governance, strategy, and operational resilience in logistics.')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('board-insights') . '/')

@section('content')
    <style>
        header {
            position: sticky;
            top: 0;
            background-color: var(--white) !important;
        }

        .insight-hero-heading {
            text-align: left;
        }

        .insight-hero-copy {
            max-width: 640px;
            color: rgba(255, 255, 255, 0.82);
            margin-top: 1rem;
        }

        .insight-grid {
            row-gap: 1.5rem;
        }

        .insight-grid .postCard {
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
            border: 1px solid #dbe4ef;
            border-radius: 18px;
            background: #ffffff;
            transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
        }

        .insight-grid .postCard:hover {
            transform: translateY(-2px);
            border-color: #c7d3e3;
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.05);
        }

        .insight-grid .postCard h3 {
            margin-bottom: .85rem;
        }

        .insight-grid .postCard h3 a {
            color: var(--dark-grey);
            font-size: 1.4rem;
            line-height: 1.3;
            text-decoration: none;
        }

        .insight-grid .postCard h3 a:hover {
            color: var(--primary-color);
        }

        .insight-grid .postCard h3 a:focus-visible,
        .insight-card-link:focus-visible {
            outline: 3px solid rgba(37, 99, 235, 0.22);
            outline-offset: 4px;
        }

        .insight-card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            margin-bottom: .95rem;
        }

        .insight-card-date,
        .insight-card-readtime {
            color: #64748b;
            font-size: .82rem;
            font-weight: 600;
        }

        .insight-grid .postCard p {
            color: #526070;
            line-height: 1.75;
            margin: 0;
            flex-grow: 1;
        }

        .insight-card-link {
            display: inline-flex;
            align-items: center;
            margin-top: 1.15rem;
            color: #2563eb;
            font-size: .9rem;
            font-weight: 700;
            text-decoration: none;
        }

        .insight-card-link:hover {
            color: #1d4ed8;
        }

        .insight-empty {
            padding: 4rem 1.5rem;
            border: 1px dashed #cbd5e1;
            border-radius: 20px;
            background: #f8fbff;
            text-align: center;
        }

        .insight-empty h3 {
            margin-bottom: .75rem;
        }

        .insight-empty p {
            margin: 0;
            color: #64748b;
        }

        .board-pagination {
            margin-top: 2.5rem;
        }

        .board-pagination nav {
            width: auto;
        }

        .board-pagination .pagination {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: center;
            gap: .65rem;
            padding-left: 0;
            margin-bottom: 0;
            list-style: none;
        }

        .board-pagination .page-item {
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .board-pagination .page-link,
        .board-pagination .page-item span {
            min-width: 42px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
            background: #edf2ff;
            color: var(--dark-blue);
            font-weight: 600;
            text-decoration: none;
            border: none;
            padding: 0 .9rem;
        }

        .board-pagination .page-item.active span,
        .board-pagination .page-item.active .page-link {
            background: var(--primary-color);
            color: var(--white);
        }

        .board-pagination .page-item.disabled span,
        .board-pagination .page-item.disabled .page-link {
            opacity: .45;
        }

        @media (prefers-reduced-motion: reduce) {
            .insight-grid .postCard,
            .insight-grid .postCard h3 a,
            .insight-card-link {
                transition: none;
            }
        }

        @media (max-width: 767px) {
            .insight-grid .postCard {
                padding: 1.25rem;
            }

            .insight-grid .postCard h3 a {
                font-size: 1.2rem;
            }
        }
    </style>

    <section class="gradientBg bothPadding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="headingMain insight-hero-heading">
                        <h1>Board Insights</h1>
                        <p class="insight-hero-copy">Board-level thinking on governance, operational resilience, leadership judgment, and the strategic decisions shaping logistics businesses.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bothPadding">
        <div class="container">
            @if (count($insightList) > 0)
                <div class="row insight-grid">
                    @foreach ($insightList as $item)
                        <div class="col-lg-6">
                            <article class="postCard">
                                <div class="insight-card-meta">
                                    <span class="insight-card-date">{{ $item->created_at->format('d M Y') }}</span>
                                    <span class="insight-card-readtime">{{ $item->reading_time }} min read</span>
                                </div>
                                <h3>
                                    <a title="{!! $item->title !!}" href="/board-insights/{{ $item->slug }}/">{!! $item->title !!}</a>
                                </h3>
                                <p>{{ $item->excerpt }}</p>
                                <a class="insight-card-link" href="/board-insights/{{ $item->slug }}/">Read Insight</a>
                            </article>
                        </div>
                    @endforeach
                </div>

                @if ($insightList->hasPages())
                    <div class="row">
                        <div class="col-12 d-flex justify-content-center board-pagination">
                            {{ $insightList->links() }}
                        </div>
                    </div>
                @endif
            @else
                <div class="insight-empty">
                    <h3>Board insight content is on the way.</h3>
                    <p>Fresh strategic perspectives will appear here as soon as they are published.</p>
                </div>
            @endif
        </div>
    </section>

@endsection
