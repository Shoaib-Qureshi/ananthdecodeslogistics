@extends('layouts.front')

@section('styles')
@include('events.partials.styles')
@endsection

@section('content')
<main class="event-page">
    @include('events.partials.hero', [
        'eyebrow'  => 'FAQ',
        'title'    => 'LogiSphere Questions',
        'subtitle' => 'Answers for delegates, sponsors, exhibitors, and speakers.',
    ])
    @include('events.partials.nav')

    <section class="event-section">
        <div class="event-container">
            @if($faqs->isNotEmpty())
                <div class="event-eyebrow">Frequently Asked Questions</div>
                <h2 class="event-title">Quick answers.</h2>
                <p class="event-lead" style="margin-bottom:36px">Quick answers for LogiSphere delegates, sponsors, exhibitors, and speakers.</p>

                <div class="event-faq-list" id="event-faq-accordion" role="list">
                    @foreach($faqs as $i => $faq)
                        <div class="event-faq-item{{ $i === 0 ? ' is-open' : '' }}" role="listitem">
                            <button class="event-faq-summary"
                                    type="button"
                                    aria-expanded="{{ $i === 0 ? 'true' : 'false' }}"
                                    aria-controls="faq-body-{{ $i }}">
                                <span>{{ $faq->question }}</span>
                                <span class="event-faq-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </span>
                            </button>
                            <div class="event-faq-body" id="faq-body-{{ $i }}" role="region">
                                <div class="event-faq-body-inner">
                                    <div class="event-faq-answer">{!! nl2br(e($faq->answer)) !!}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="event-card">
                    <h2 class="event-title" style="font-size:1.6rem">No FAQs published yet.</h2>
                    <p class="event-lead">Use the admin event editor to add questions and answers.</p>
                </div>
            @endif
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
(function () {
    var accordion = document.getElementById('event-faq-accordion');
    if (!accordion) return;

    function openItem(item) {
        item.classList.add('is-open');
        item.querySelector('button').setAttribute('aria-expanded', 'true');
    }

    function closeItem(item) {
        item.classList.remove('is-open');
        item.querySelector('button').setAttribute('aria-expanded', 'false');
    }

    accordion.querySelectorAll('.event-faq-summary').forEach(function (btn) {
        btn.addEventListener('click', function () {
            var item = btn.closest('.event-faq-item');
            var isOpen = item.classList.contains('is-open');

            // Close all
            accordion.querySelectorAll('.event-faq-item').forEach(closeItem);

            // Toggle current
            if (!isOpen) openItem(item);
        });
    });
})();
</script>
@endsection
