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

        .insight-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 1.5rem;
        }

        .insight-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
            border: 1px solid #dbe4ef;
            border-radius: 18px;
            background: #ffffff;
            text-decoration: none;
            transition: transform .2s ease, border-color .2s ease, box-shadow .2s ease;
        }

        .insight-card:hover {
            transform: translateY(-2px);
            border-color: #c7d3e3;
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.05);
        }

        .insight-card:focus-visible {
            outline: 3px solid rgba(37, 98, 233, 0.22);
            outline-offset: 4px;
        }

        .insight-card-meta {
            display: flex;
            flex-wrap: wrap;
            gap: .75rem;
            margin-bottom: .95rem;
        }

        .insight-card-meta span {
            color: #64748b;
            font-size: .76rem;
            font-weight: 600;
        }

        .insight-card h3 {
            color: var(--dark-grey);
            font-size: 1.22rem;
            line-height: 1.34;
            margin-bottom: .85rem;
        }

        .insight-card p {
            color: #526070;
            font-size: .95rem;
            line-height: 1.68;
            margin: 0;
            flex-grow: 1;
        }

        .insight-card-link {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            margin-top: 1.15rem;
            color: #2562E9;
            font-size: .9rem;
            font-weight: 700;
        }

        .insight-card:hover .insight-card-link {
            color: #181A3F;
        }

        @media (prefers-reduced-motion: reduce) {
            .insight-card {
                transition: none;
            }
        }

        @media (max-width: 767px) {
            .insight-grid {
                grid-template-columns: 1fr;
            }

            .insight-card {
                padding: 1.25rem;
            }

            .insight-card h3 {
                font-size: 1.12rem;
            }
        }
    </style>

    @include('partials.page-banner', [
        'banner' => $banner ?? null,
        'fallbackHeading' => 'Board Insights',
        'fallbackSubheading' => 'Board-level thinking on governance, operational resilience, leadership judgment, and the strategic decisions shaping logistics businesses.',
    ])

    <section class="adl-resource-section">
        <div class="adl-resource-container">
            @if (count($insightList) > 0)
                <div class="insight-grid">
                    @foreach ($insightList as $item)
                        <a class="insight-card" href="/board-insights/{{ $item->slug }}/" title="{!! $item->title !!}">
                            <div class="insight-card-meta">
                                <span>{{ $item->created_at->format('d M Y') }}</span>
                                <span>{{ $item->reading_time }} min read</span>
                            </div>
                            <h3>{!! $item->title !!}</h3>
                            <p>{{ $item->excerpt }}</p>
                            <span class="insight-card-link">Read Insight <i class="bx bx-right-arrow-alt" aria-hidden="true"></i></span>
                        </a>
                    @endforeach
                </div>

                @if ($insightList->hasPages())
                    <div class="adl-resource-pagination">{{ $insightList->links() }}</div>
                @endif
            @else
                <div class="adl-resource-empty">
                    <h3>Board insight content is on the way.</h3>
                    <p>Fresh strategic perspectives will appear here as soon as they are published.</p>
                </div>
            @endif
        </div>
    </section>

@endsection
