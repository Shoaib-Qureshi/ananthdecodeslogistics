@php
    $faqCollection = collect($faqItems ?? [])
        ->filter(function ($item) {
            return filled(data_get($item, 'question')) && filled(data_get($item, 'answer'));
        })
        ->values();
@endphp

@if ($faqCollection->isNotEmpty())
    <style>
       

        .articleFaqSection h2 {
            margin: 0 0 0.5rem;
            color: var(--dark-grey);
            font-size: 2rem;
            line-height: 1.15em;
        }

        .articleFaqIntro {
            margin: 0 0 1.4rem;
            color: var(--medium-grey);
            font-size: 1rem;
            line-height: 1.7;
        }

        .articleFaqList {
            display: grid;
            gap: 0.9rem;
        }

        .articleFaqItem {
            border: 1px solid #e7ebf4;
            border-radius: 12px;
            background: #fbfdff;
            overflow: hidden;
        }

        .articleFaqItem summary {
            list-style: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
            padding: 1rem 1.2rem;
            color: var(--dark-grey);
            font-size: 1.02rem;
            font-weight: 600;
        }

        .articleFaqItem summary::-webkit-details-marker {
            display: none;
        }

        .articleFaqToggle {
            position: relative;
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .articleFaqToggle::before,
        .articleFaqToggle::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 14px;
            height: 2px;
            border-radius: 999px;
            background: var(--primary-color);
            transform: translate(-50%, -50%);
            transition: transform 0.2s ease, opacity 0.2s ease;
        }

        .articleFaqToggle::after {
            transform: translate(-50%, -50%) rotate(90deg);
        }

        .articleFaqItem[open] .articleFaqToggle::after {
            opacity: 0;
            transform: translate(-50%, -50%) rotate(90deg) scaleX(0.2);
        }

        .articleFaqAnswer {
            padding: 0 1.2rem 1.2rem;
            color: var(--medium-grey);
            font-size: 1rem;
            line-height: 1.8;
        }

        .articleFaqAnswer p:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
        }

        @media (max-width: 767px) {
            .articleFaqSection {
                padding: 1.35rem;
            }

            .articleFaqSection h2 {
                font-size: 1.6rem;
            }

            .articleFaqItem summary {
                padding: 0.95rem 1rem;
                font-size: 0.95rem;
            }

            .articleFaqAnswer {
                padding: 0 1rem 1rem;
                font-size: 0.95rem;
            }
        }
    </style>

    <section class="articleFaqSection" id="{{ $sectionId ?? 'article-faqs' }}">
        <h2>Frequently Asked Questions</h2>
        <p class="articleFaqIntro">Quick answers related to this article.</p>

        <div class="articleFaqList">
            @foreach ($faqCollection as $index => $faqItem)
                <details class="articleFaqItem" {{ $index === 0 ? 'open' : '' }}>
                    <summary>
                        <span>{{ $faqItem['question'] }}</span>
                        <span class="articleFaqToggle" aria-hidden="true"></span>
                    </summary>
                    <div class="articleFaqAnswer">{!! nl2br(e($faqItem['answer'])) !!}</div>
                </details>
            @endforeach
        </div>
    </section>
@endif
