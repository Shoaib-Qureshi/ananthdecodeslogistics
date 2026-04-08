@extends('layouts.front')
@section('title', 'Write for Us | The Expert Desk – Ananth Decodes Logistics')
@section('description', 'Publish your logistics expertise through The Expert Desk. Choose a plan that fits your publishing pace and apply today.')
@section('img', asset('img/site-banner.jpg'))
@section('url', route('write-for-us'))

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
/* ── Base ── */
header{position:sticky;top:0;background:var(--white)!important;z-index:100}
.wfu-shell{background:#f8fbff}

/* ── Hero ── */
.wfu-hero{padding:5rem 0 4rem;text-align:center}
.wfu-eyebrow{display:inline-flex;align-items:center;gap:.4rem;padding:.4rem .85rem;background:rgba(37,99,235,.08);color:#1d4ed8;font-size:.72rem;font-weight:700;letter-spacing:.09em;text-transform:uppercase;border-radius:999px;margin-bottom:1.25rem}
.wfu-h1{font-size:clamp(2.2rem,4vw,3.6rem);font-weight:800;color:#0f172a;line-height:1.08;letter-spacing:-.03em;margin:0 0 1rem;max-width:90%;margin-left:auto;margin-right:auto}
.wfu-h1 span{color:#3882fa}
.wfu-lead{color:#64748b;font-size:1rem;line-height:1.75;max-width:560px;margin:0 auto 2rem}
.wfu-actions{display:flex;gap:.85rem;justify-content:center;flex-wrap:wrap}
.btn-primary-x{display:inline-flex;align-items:center;gap:.45rem;padding:.8rem 1.5rem;background:#3882fa;color:#fff;font-size:.9rem;font-weight:700;border-radius:10px;text-decoration:none;transition:.16s ease;box-shadow:0 8px 20px rgba(37,99,235,.2)}
.btn-primary-x:hover{background:#1d4ed8;color:#fff;box-shadow:0 12px 28px rgba(37,99,235,.28)}
.btn-ghost-x{display:inline-flex;align-items:center;gap:.45rem;padding:.8rem 1.5rem;background:#fff;color:#334155;font-size:.9rem;font-weight:600;border-radius:10px;text-decoration:none;border:1.5px solid #e2e8f0;transition:.16s ease}
.btn-ghost-x:hover{border-color:#93c5fd;color:#1d4ed8}

/* ── Trust strip ── */
.trust-strip{display:grid;grid-template-columns:repeat(3,1fr);gap:1px;background:#e2e8f0;border:1px solid #e2e8f0;border-radius:16px;overflow:hidden;margin-top:3.5rem}
.trust-item{background:#fff;padding:1.25rem 1.5rem;text-align:center}
.trust-item strong{display:block;font-size:.92rem;font-weight:700;color:#0f172a;margin-bottom:.2rem}
.trust-item span{font-size:.8rem;color:#64748b;line-height:1.5}

/* ── Sections ── */
.wfu-body{padding:0 0 5rem}
.wfu-section{margin-top:2.5rem}

/* ── Editorial card ── */
.editorial-card{background:#fff;border:1px solid #e2e8f0;border-radius:18px;padding:2.5rem}
.section-eyebrow{font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:#3882fa;display:block;margin-bottom:.5rem}
.section-title{font-size:clamp(1.3rem,2vw,1.65rem);font-weight:800;color:#0f172a;line-height:1.2;margin:0 0 .75rem}
.section-body{color:#64748b;font-size:.93rem;line-height:1.75;margin:0 0 1.1rem}
.topic-list{list-style:none;padding:0;margin:0;display:grid;gap:.55rem}
.topic-list li{display:flex;align-items:flex-start;gap:.65rem;color:#475569;font-size:.9rem;line-height:1.6}
.topic-list li::before{content:'';width:6px;height:6px;border-radius:50%;background:#3882fa;flex-shrink:0;margin-top:.52rem}
.editorial-divider{border:none;border-left:1px solid #e2e8f0;margin:0}

/* ── Pricing ── */
.pricing-header{margin-bottom:1.75rem}
.pricing-header .section-title{font-size:clamp(1.5rem,2.5vw,2rem);margin-bottom:.5rem}
.pricing-header p{color:#64748b;font-size:.93rem;line-height:1.75;margin:0;max-width:640px}
.plan-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:1rem}
.plan-card{display:flex;flex-direction:column;padding:1.6rem;border-radius:18px;background:#fff;border:1.5px solid #e2e8f0;cursor:pointer;transition:.18s ease}
.plan-card:hover{border-color:#93c5fd;box-shadow:0 12px 32px rgba(15,23,42,.08);transform:translateY(-2px)}
.plan-card.is-selected{border-color:#3882fa;box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.plan-card.is-popular{background:linear-gradient(160deg,#eff6ff 0%,#fff 60%)}
.plan-popular-badge{display:inline-flex;width:fit-content; align-items:center;padding:.22rem .6rem;background:#3882fa;color:#fff;font-size:.66rem;font-weight:700;letter-spacing:.07em;text-transform:uppercase;border-radius:999px;margin-bottom:.9rem}
.plan-name{font-size:.95rem;font-weight:700;color:#0f172a;margin-bottom:.25rem}
.plan-price-row{display:flex;align-items:baseline;gap:.3rem;margin-bottom:.85rem}
.plan-price-row strong{font-size:2.1rem;font-weight:800;color:#0f172a;line-height:1}
.plan-price-row small{font-size:.8rem;color:#94a3b8;font-weight:600}
.plan-tags{display:flex;flex-wrap:wrap;gap:.4rem;margin-bottom:1rem}
.plan-tag{display:inline-flex;align-items:center;padding:.25rem .6rem;background:#f1f5f9;color:#475569;font-size:.74rem;border-radius:999px}
.plan-features{list-style:none;padding:0;margin:0;display:grid;gap:.5rem}
.plan-features li{display:flex;align-items:flex-start;gap:.6rem;color:#475569;font-size:.84rem;line-height:1.55}
.plan-features li::before{content:'';width:5px;height:5px;border-radius:50%;background:#3882fa;flex-shrink:0;margin-top:.52rem}
.plan-cta-wrap{margin-top:auto;padding-top:1.25rem}
.plan-cta{display:block;text-align:center;padding:.72rem 1rem;border-radius:10px;background:#f1f5f9;color:#334155;font-size:.85rem;font-weight:700;text-decoration:none;transition:.16s ease;border:none;cursor:pointer;width:100%}
.plan-card.is-selected .plan-cta,.plan-cta:hover{background:#3882fa;color:#fff}

/* ── Comparison ── */
.comparison-card{background:#fff;border:1px solid #e2e8f0;border-radius:18px;padding:2.5rem}
.comparison-table{width:100%;border-collapse:collapse;margin-top:1.25rem}
.comparison-table th{font-size:.78rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#64748b;padding:.75rem 1rem;border-bottom:2px solid #e2e8f0;text-align:left}
.comparison-table th:first-child{padding-left:0;width:26%}
.comparison-table th:last-child{padding-right:0}
.comparison-table td{padding:.9rem 1rem;border-bottom:1px solid #f1f5f9;font-size:.875rem;color:#334155;vertical-align:top;line-height:1.55}
.comparison-table td:first-child{padding-left:0;font-weight:600;color:#0f172a}
.comparison-table td:last-child{padding-right:0}
.comparison-table tbody tr:last-child td{border-bottom:none}
.comparison-table .col-popular{color:#1d4ed8;font-weight:500}
.comparison-mobile{display:none;gap:1rem;margin-top:1.25rem}
.comparison-mobile-card{background:#f8fbff;border:1px solid #e2e8f0;border-radius:14px;padding:1.25rem}
.comparison-mobile-card h4{font-size:.92rem;font-weight:700;color:#0f172a;margin-bottom:.9rem}
.comparison-row{padding:.6rem 0;border-bottom:1px solid #e2e8f0}
.comparison-row:last-child{border-bottom:none;padding-bottom:0}
.comparison-row span{display:block;font-size:.72rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#94a3b8;margin-bottom:.25rem}
.comparison-row p{margin:0;font-size:.85rem;color:#334155;line-height:1.55}

/* ── FAQ ── */
.faq-card{background:#fff;border:1px solid #e2e8f0;border-radius:18px;padding:2.5rem}
.faq-card .accordion-item{border:1px solid #e2e8f0;border-radius:12px!important;overflow:hidden;margin-bottom:.75rem}
.faq-card .accordion-item:last-child{margin-bottom:0}
.faq-card .accordion-button{font-size:.93rem;font-weight:600;color:#0f172a;background:#fff;box-shadow:none;padding:1rem 1.1rem}
.faq-card .accordion-button:not(.collapsed){color:#1d4ed8;background:#f0f6ff}
.faq-card .accordion-button::after{filter:none}
.faq-card .accordion-body{font-size:.88rem;color:#64748b;line-height:1.75;padding:.75rem 1.1rem 1.1rem}

/* ── Final CTA ── */
.final-cta{background:#0f172a;border-radius:18px;padding:2.5rem;text-align:center;margin-top:2.5rem}
.final-cta h3{font-size:1.35rem;font-weight:800;color:#fff;margin:0 0 .5rem}
.final-cta p{color:rgba(255,255,255,.6);font-size:.9rem;line-height:1.7;margin:0 0 1.5rem}
.final-cta .btn-primary-x{background:#3882fa;box-shadow:none}
.final-cta .btn-primary-x:hover{background:#1d4ed8}
.final-cta-note{font-size:.78rem;color:rgba(255,255,255,.35);margin-top:.85rem}

/* ── Sticky apply bar ── */
.apply-bar{position:fixed;bottom:0;left:0;right:0;z-index:1040;background:#fff;border-top:1px solid #e2e8f0;padding:.85rem 1.5rem;display:flex;align-items:center;justify-content:space-between;gap:1rem;box-shadow:0 -6px 20px rgba(15,23,42,.07);transform:translateY(100%);transition:transform .28s ease}
.apply-bar.is-visible{transform:translateY(0)}
.apply-bar-left p{margin:0;font-size:.73rem;color:#94a3b8}
.apply-bar-left strong{display:block;font-size:.92rem;color:#0f172a;font-weight:700}
.apply-bar-btn{display:inline-flex;align-items:center;gap:.45rem;background:#3882fa;color:#fff;border:none;border-radius:10px;padding:.72rem 1.25rem;font-size:.88rem;font-weight:700;text-decoration:none;white-space:nowrap;transition:.16s ease;cursor:pointer}
.apply-bar-btn:hover{background:#1d4ed8;color:#fff}

/* ── Responsive ── */
@media(max-width:991px){
    .trust-strip{grid-template-columns:1fr}
    .plan-grid{grid-template-columns:1fr}
    .comparison-table{display:none}
    .comparison-mobile{display:grid}
    .editorial-divider{display:none}
}
@media(max-width:767px){
    .wfu-hero{padding:3.5rem 0 3rem}
    .editorial-card{padding:1.5rem}
    .comparison-card,.faq-card{padding:1.5rem}
    .final-cta{padding:2rem 1.5rem}
    .apply-bar{flex-direction:column;align-items:stretch}
    .apply-bar-btn{justify-content:center}
}
</style>
@endsection

@section('content')
@php
$popularPlan = \App\Support\ContributorPlans::GROWTH;
$comparisonRows = [
    ['label' => 'Publishing window',       \App\Support\ContributorPlans::STARTER => '3 months',                         \App\Support\ContributorPlans::GROWTH => '6 months',                         \App\Support\ContributorPlans::AUTHORITY => '12 months'],
    ['label' => 'Article submissions',     \App\Support\ContributorPlans::STARTER => 'Up to 3 articles',                 \App\Support\ContributorPlans::GROWTH => 'Up to 8 articles',                 \App\Support\ContributorPlans::AUTHORITY => 'Unlimited (fair use)'],
    ['label' => 'Editorial queue',         \App\Support\ContributorPlans::STARTER => 'Standard review',                  \App\Support\ContributorPlans::GROWTH => 'Priority queue',                   \App\Support\ContributorPlans::AUTHORITY => 'Priority queue'],
    ['label' => 'Visibility support',      \App\Support\ContributorPlans::STARTER => 'LinkedIn & X promotion',           \App\Support\ContributorPlans::GROWTH => 'Enhanced promotion + newsletter',  \App\Support\ContributorPlans::AUTHORITY => 'Spotlight & amplification'],
    ['label' => 'Homepage placement',      \App\Support\ContributorPlans::STARTER => '—',                                \App\Support\ContributorPlans::GROWTH => '—',                                \App\Support\ContributorPlans::AUTHORITY => 'Eligible (editorial approval)'],
];
$faqItems = [
    ['q' => 'When does my access start?',            'a' => 'Immediately after payment. You\'ll receive a password setup email to activate your contributor dashboard.'],
    ['q' => 'Do edits count against my article cap?','a' => 'No — only publishing a new post uses a slot. Editing or resubmitting an existing article does not.'],
    ['q' => 'What happens when my plan expires?',    'a' => 'Your profile, login, and published articles stay live. New submissions pause until you renew or upgrade.'],
    ['q' => 'Is homepage placement guaranteed on Authority?','a' => 'No. Authority makes eligible approved posts available for homepage placement, but editorial selection still applies.'],
    ['q' => 'What is handled automatically vs manually?','a' => 'Duration limits, article caps, and Authority feature eligibility are automated. Promotion, newsletter mentions, and spotlight coordination are handled by the editorial team.'],
];
@endphp

<div class="wfu-shell">

{{-- ── Hero ── --}}
<section class="wfu-hero">
    <div class="container">
        <span class="wfu-eyebrow">
            <svg width="10" height="10" viewBox="0 0 16 16" fill="currentColor"><circle cx="8" cy="8" r="7"/></svg>
            The Expert Desk
        </span>
        <h1 class="wfu-h1">Write for a logistics audience that <span>reads with intent</span></h1>
        <p class="wfu-lead">The Expert Desk is a credibility-first contributor platform for logistics and supply chain professionals. Pick a publishing plan that fits your pace — and build a real author presence.</p>
        <div class="wfu-actions">
            <a href="#pricing" class="btn-primary-x">
                <svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor"><path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/></svg>
                View Plans
            </a>
            <a href="{{ route('contributors.index') }}" class="btn-ghost-x">Browse The Expert Desk</a>
        </div>

        <div class="trust-strip">
            <div class="trust-item"><strong>Focused readership</strong><span>Logistics & supply chain professionals</span></div>
            <div class="trust-item"><strong>Full author credit</strong><span>Profile, bio & credentials on every article</span></div>
            <div class="trust-item"><strong>Editorial review</strong><span>Every piece reviewed before it goes live</span></div>
        </div>
    </div>
</section>

{{-- ── Body ── --}}
<section class="wfu-body">
<div class="container">

    {{-- Why & What --}}
    <div class="editorial-card wfu-section">
        <div class="row g-0">
            <div class="col-md-6" style="padding-right:2rem">
                <span class="section-eyebrow">Why contribute</span>
                <h2 class="section-title">Why write for us?</h2>
                <p class="section-body">Ananth Decodes Logistics reaches practitioners and decision-makers looking for grounded, experience-driven perspectives on how supply chains actually work. Writing here gives you:</p>
                <ul class="topic-list">
                    <li>A published author presence with credentials and bio</li>
                    <li>Reach to a niche audience that reads with professional intent</li>
                    <li>Co-branded promotion across LinkedIn and X</li>
                    <li>A durable record of thought leadership in your field</li>
                </ul>
            </div>
            <div class="col-md-1 d-none d-md-flex justify-content-center"><hr class="editorial-divider" style="height:100%"></div>
            <div class="col-md-5" style="padding-left:1rem">
                <span class="section-eyebrow">What we publish</span>
                <h2 class="section-title">Topics we cover</h2>
                <p class="section-body">Original articles, case studies, and perspectives on:</p>
                <ul class="topic-list">
                    <li>Logistics trends and operational innovation</li>
                    <li>Supply chain strategy and risk management</li>
                    <li>Warehousing, last-mile, and freight forwarding</li>
                    <li>Technology in logistics — AI, IoT, automation</li>
                    <li>Career growth and leadership in the industry</li>
                </ul>
            </div>
        </div>
    </div>

    {{-- Pricing --}}
    <div class="wfu-section" id="pricing">
        <div class="pricing-header">
            <span class="section-eyebrow">Plans & Pricing</span>
            <h2 class="section-title">Pick the pace that fits your goals</h2>
            <p>Growth is the right default for most contributors — six months, eight articles, and stronger editorial reach. Authority is for those who want a year-long presence and homepage placement eligibility.</p>
        </div>

        <div class="plan-grid" id="planGrid">
            @foreach($plans as $plan)
            @php($isPopular = $plan['code'] === $popularPlan)
            <div class="plan-card {{ $isPopular ? 'is-popular is-selected' : '' }}"
                 data-plan="{{ $plan['code'] }}"
                 data-plan-name="{{ $plan['name'] }}"
                 data-apply-url="{{ route('contributor.register') }}?plan={{ $plan['code'] }}">
                @if($isPopular)<span class="plan-popular-badge">Most popular</span>@endif
                <div class="plan-name">{{ $plan['name'] }}</div>
                <div class="plan-price-row"><strong>{{ $plan['price_label'] }}</strong><small>USD one-time</small></div>
                <div class="plan-tags">
                    <span class="plan-tag">{{ $plan['duration_label'] }}</span>
                    <span class="plan-tag">{{ $plan['post_limit_label'] }}</span>
                </div>
                <ul class="plan-features">
                    @foreach($plan['highlights'] as $h)<li>{{ $h }}</li>@endforeach
                </ul>
                <div class="plan-cta-wrap">
                    <a href="{{ route('contributor.register') }}?plan={{ $plan['code'] }}" class="plan-cta plan-apply-btn">
                        {{ $isPopular ? 'Apply with this plan' : 'Select & apply' }}
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Comparison --}}
    <div class="comparison-card wfu-section">
        <span class="section-eyebrow">Plan comparison</span>
        <h2 class="section-title">What's included in each plan</h2>
        <table class="comparison-table">
            <thead>
                <tr>
                    <th></th>
                    @foreach($plans as $plan)
                        <th>{{ $plan['name'] }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach($comparisonRows as $row)
                <tr>
                    <td>{{ $row['label'] }}</td>
                    @foreach($plans as $plan)
                        <td class="{{ $plan['code'] === $popularPlan ? 'col-popular' : '' }}">{{ $row[$plan['code']] }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="comparison-mobile">
            @foreach($plans as $plan)
            <div class="comparison-mobile-card">
                <h4>{{ $plan['name'] }} · {{ $plan['price_label'] }}</h4>
                @foreach($comparisonRows as $row)
                <div class="comparison-row">
                    <span>{{ $row['label'] }}</span>
                    <p>{{ $row[$plan['code']] }}</p>
                </div>
                @endforeach
            </div>
            @endforeach
        </div>
    </div>

    {{-- FAQ --}}
    <div class="faq-card wfu-section">
        <span class="section-eyebrow">Common questions</span>
        <h2 class="section-title">Before you apply</h2>
        <div class="accordion mt-4" id="wfuFaq">
            @foreach($faqItems as $faq)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" type="button"
                            data-bs-toggle="collapse" data-bs-target="#faq{{ $loop->index }}"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}">{{ $faq['q'] }}</button>
                </h2>
                <div id="faq{{ $loop->index }}" class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" data-bs-parent="#wfuFaq">
                    <div class="accordion-body">{{ $faq['a'] }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- Final CTA --}}
    <div class="final-cta">
        <h3>Ready to publish through The Expert Desk?</h3>
        <p>Choose a plan, complete a short application, and go through Stripe checkout.<br>Access activates immediately after payment.</p>
        <a href="{{ route('contributor.register') }}" class="btn-primary-x">
            <svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor"><path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11z"/></svg>
            Apply to The Expert Desk
        </a>
        <p class="final-cta-note">Questions? Reach out at jana.ananthakrishnan@gmail.com</p>
    </div>

</div>
</section>
</div>

{{-- Sticky apply bar --}}
<div class="apply-bar" id="applyBar">
    <div class="apply-bar-left">
        <p>Selected plan</p>
        <strong id="applyBarPlanName">Growth Contributor</strong>
    </div>
    <a href="{{ route('contributor.register') }}?plan={{ \App\Support\ContributorPlans::GROWTH }}" class="apply-bar-btn" id="applyBarBtn">
        <svg width="14" height="14" viewBox="0 0 16 16" fill="currentColor"><path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11z"/></svg>
        Apply now
    </a>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
(function () {
    const cards      = document.querySelectorAll('.plan-card');
    const applyBar   = document.getElementById('applyBar');
    const barName    = document.getElementById('applyBarPlanName');
    const barBtn     = document.getElementById('applyBarBtn');
    const pricing    = document.getElementById('pricing');

    function select(card) {
        cards.forEach(c => {
            c.classList.remove('is-selected');
            const b = c.querySelector('.plan-apply-btn');
            if (b) b.textContent = 'Select & apply';
        });
        card.classList.add('is-selected');
        const b = card.querySelector('.plan-apply-btn');
        if (b) b.textContent = 'Apply with this plan';
        if (barName) barName.textContent = card.dataset.planName;
        if (barBtn)  barBtn.href = card.dataset.applyUrl;
    }

    cards.forEach(card => {
        card.addEventListener('click', function (e) {
            if (e.target.closest('.plan-apply-btn')) return;
            select(this);
        });
    });

    const popular = document.querySelector('.plan-card.is-popular');
    if (popular) select(popular);

    if (pricing && applyBar) {
        new IntersectionObserver(entries => {
            applyBar.classList.toggle('is-visible', !entries[0].isIntersecting);
        }, { threshold: 0.1 }).observe(pricing);
    }
})();
</script>
@endsection
