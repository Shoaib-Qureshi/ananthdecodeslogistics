@extends('layouts.front')

@section('styles')
<style>
    .gallery-page{font-family:"Public Sans",system-ui,sans-serif;color:#0f172a;background:#fff}
    .gallery-container{width:min(1200px,calc(100% - 32px));margin:0 auto}

    /* ── Hero ───────────────────────────────────────────────── */
    .gallery-hero{position:relative;overflow:hidden;background:#030712;color:#fff}
    .gallery-hero:before{content:"";position:absolute;inset:0;background:radial-gradient(circle at 78% 18%,rgba(37,98,233,.42),transparent 30%),linear-gradient(105deg,#020617 0%,#07111f 52%,#12324a 100%)}
    .gallery-hero:after{content:"GALLERY";position:absolute;right:-3vw;bottom:8px;color:rgba(255,255,255,.04);font-size:clamp(5rem,15vw,14rem);font-weight:900;line-height:1;letter-spacing:.04em;pointer-events:none}
    .gallery-hero__inner{position:relative;z-index:1;display:grid;grid-template-columns:minmax(0,1fr) 280px;gap:34px;align-items:center;min-height:320px;padding:58px 0 64px}
    .gallery-eyebrow{display:inline-flex;align-items:center;gap:10px;margin:0 0 16px;color:#bae6fd;font-size:.74rem;font-weight:900;letter-spacing:.18em;text-transform:uppercase}
    .gallery-eyebrow:before,.gallery-eyebrow:after{content:"";width:24px;height:1px;background:#38bdf8}
    .gallery-hero h1{max-width:640px;margin:0;color:#fff;font-family:"Playfair Display",Georgia,serif;font-size:clamp(2rem,4vw,3.6rem);font-weight:500;line-height:1.14}
    .gallery-hero p{max-width:560px;margin:14px 0 0;color:rgba(255,255,255,.72);font-size:.97rem;line-height:1.72}
    .gallery-hero__stats{display:flex;gap:24px;margin-top:24px}
    .gallery-hero__stat span{display:block;color:rgba(255,255,255,.5);font-size:.7rem;font-weight:800;letter-spacing:.12em;text-transform:uppercase}
    .gallery-hero__stat strong{display:block;margin-top:3px;color:#fff;font-size:1.3rem;font-weight:700}
    .gallery-note{border:1px solid rgba(255,255,255,.14);border-radius:18px;background:rgba(255,255,255,.07);padding:20px;backdrop-filter:blur(18px);box-shadow:0 24px 70px rgba(0,0,0,.22)}
    .gallery-note strong{display:block;margin-bottom:6px;color:#fff;font-size:.97rem;font-weight:700}
    .gallery-note span{display:block;color:rgba(255,255,255,.6);font-size:.88rem;line-height:1.65}

    /* ── Section ─────────────────────────────────────────────── */
    .gallery-section{padding:72px 0 88px;background:linear-gradient(180deg,#f8fbff 0%,#fff 40%)}

    /* ── Filter tabs ─────────────────────────────────────────── */
    .gallery-filters{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:36px}
    .gallery-filter-btn{display:inline-flex;align-items:center;gap:6px;border:1px solid #d8e3f0;border-radius:999px;background:#fff;color:#475569;padding:8px 18px;font-size:.83rem;font-weight:700;cursor:pointer;transition:all .18s ease;white-space:nowrap}
    .gallery-filter-btn:hover{border-color:#2562E9;color:#2562E9;background:#eff6ff}
    .gallery-filter-btn.is-active{border-color:#2562E9;background:#2562E9;color:#fff}
    .gallery-filter-btn:focus-visible{outline:2px solid #2562E9;outline-offset:2px}
    .gallery-filter-count{font-size:.72rem;font-weight:900;opacity:.75}

    /* ── Section head ────────────────────────────────────────── */
    .gallery-head{margin-bottom:32px}
    .gallery-head h2{margin:0 0 8px;color:#0f172a;font-family:"Playfair Display",Georgia,serif;font-size:clamp(1.8rem,3.5vw,3rem);font-weight:500;line-height:1.1}
    .gallery-head p{margin:0;color:#64748b;font-size:.97rem;line-height:1.7;max-width:600px}

    /* ── Grid ────────────────────────────────────────────────── */
    .gallery-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px}
    .gallery-card{position:relative;display:block;overflow:hidden;border-radius:20px;background:#0f172a;text-decoration:none;cursor:pointer;transition:transform .25s ease,box-shadow .25s ease;aspect-ratio:4/3}
    .gallery-card:hover{transform:translateY(-5px);box-shadow:0 28px 80px rgba(15,23,42,.18)}
    .gallery-card:focus-visible{outline:3px solid #2562E9;outline-offset:3px}
    .gallery-card img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .5s ease,filter .5s ease}
    .gallery-card:hover img{transform:scale(1.07);filter:saturate(1.1) brightness(.92)}
    .gallery-card:after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,transparent 30%,rgba(2,6,23,.75) 100%);transition:opacity .25s ease}
    .gallery-card:hover:after{opacity:.9}

    /* Hover eye overlay */
    .gallery-card__eye{position:absolute;inset:0;z-index:2;display:flex;align-items:center;justify-content:center;opacity:0;transition:opacity .25s ease}
    .gallery-card:hover .gallery-card__eye{opacity:1}
    .gallery-card__eye-inner{width:52px;height:52px;border-radius:50%;background:rgba(255,255,255,.18);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,.3);display:flex;align-items:center;justify-content:center;color:#fff;transform:scale(.8);transition:transform .25s ease}
    .gallery-card:hover .gallery-card__eye-inner{transform:scale(1)}

    .gallery-card__body{position:absolute;z-index:3;left:0;right:0;bottom:0;padding:20px 18px}
    .gallery-chip{display:inline-flex;margin-bottom:8px;border:1px solid rgba(255,255,255,.2);border-radius:999px;background:rgba(255,255,255,.1);padding:5px 10px;color:#dbeafe;font-size:.7rem;font-weight:900;letter-spacing:.1em;text-transform:uppercase;backdrop-filter:blur(10px)}
    .gallery-card h3{margin:0 0 4px;color:#fff;font-size:1.05rem;font-weight:700;line-height:1.35}
    .gallery-card p{margin:0;color:rgba(255,255,255,.65);font-size:.85rem;line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}

    /* Hidden state for filter */
    .gallery-card.is-hidden{display:none}

    /* Empty state */
    .gallery-empty{display:none;grid-column:1/-1;text-align:center;padding:60px 0;color:#94a3b8}
    .gallery-empty.is-visible{display:block}

    /* ── CTA ─────────────────────────────────────────────────── */
    .gallery-cta{margin-top:64px;border-radius:24px;background:linear-gradient(135deg,#0f172a 0%,#1e3a5f 100%);padding:36px 40px;display:flex;align-items:center;justify-content:space-between;gap:24px;position:relative;overflow:hidden}
    .gallery-cta:before{content:"";position:absolute;right:-40px;top:-40px;width:200px;height:200px;border-radius:50%;background:rgba(37,98,233,.2);filter:blur(40px);pointer-events:none}
    .gallery-cta h2{margin:0 0 6px;color:#fff;font-family:"Playfair Display",Georgia,serif;font-size:1.5rem;font-weight:500}
    .gallery-cta p{margin:0;color:rgba(255,255,255,.65);line-height:1.65;font-size:.95rem}
    .gallery-btn{display:inline-flex;align-items:center;gap:8px;border-radius:40px;background:#2562E9;color:#fff!important;padding:13px 26px;font-weight:700;font-size:.9rem;text-decoration:none;white-space:nowrap;transition:background .2s ease,transform .2s ease;cursor:pointer;flex-shrink:0}
    .gallery-btn:hover{background:#1a4fc4;transform:translateY(-1px)}
    .gallery-btn:focus-visible{outline:2px solid #fff;outline-offset:3px}

    /* ── Lightbox ────────────────────────────────────────────── */
    .gallery-lightbox{position:fixed;inset:0;z-index:10000;display:none;align-items:center;justify-content:center;background:rgba(2,6,23,.92);padding:20px;backdrop-filter:blur(12px)}
    .gallery-lightbox.is-open{display:flex}
    .gallery-lightbox__panel{position:relative;width:min(1000px,100%);border-radius:20px;overflow:hidden;background:#020617;box-shadow:0 40px 120px rgba(0,0,0,.7)}
    .gallery-lightbox img{width:100%;max-height:72vh;object-fit:contain;background:#020617;display:block}
    .gallery-lightbox__footer{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:16px 20px;border-top:1px solid rgba(255,255,255,.08)}
    .gallery-lightbox__caption strong{display:block;color:#fff;font-size:1rem;margin-bottom:3px}
    .gallery-lightbox__caption span{color:rgba(255,255,255,.55);font-size:.88rem}
    .gallery-lightbox__counter{color:rgba(255,255,255,.4);font-size:.82rem;font-weight:700;white-space:nowrap}
    .gallery-lightbox__nav{display:flex;gap:8px}
    .gallery-lb-btn{width:38px;height:38px;border:1px solid rgba(255,255,255,.2);border-radius:50%;background:rgba(255,255,255,.08);color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .18s,border-color .18s}
    .gallery-lb-btn:hover{background:rgba(255,255,255,.18);border-color:rgba(255,255,255,.4)}
    .gallery-lb-btn:focus-visible{outline:2px solid #2562E9;outline-offset:2px}
    .gallery-lb-btn:disabled{opacity:.3;cursor:not-allowed}
    .gallery-close{position:absolute;top:14px;right:14px;z-index:1;width:40px;height:40px;border:1px solid rgba(255,255,255,.2);border-radius:50%;background:rgba(0,0,0,.5);color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:background .18s;backdrop-filter:blur(8px)}
    .gallery-close:hover{background:rgba(255,255,255,.15)}
    .gallery-close:focus-visible{outline:2px solid #2562E9;outline-offset:2px}

    /* ── Entrance animations ─────────────────────────────────── */
    .gallery-reveal{opacity:0;transform:translateY(22px);transition:opacity .55s ease,transform .55s ease}
    .gallery-reveal.is-visible{opacity:1;transform:translateY(0)}
    @media(prefers-reduced-motion:reduce){.gallery-reveal{opacity:1;transform:none;transition:none}.gallery-card:hover img{transform:none}.gallery-card__eye-inner{transform:none}}

    /* ── Responsive ──────────────────────────────────────────── */
    @media(max-width:1000px){.gallery-hero__inner{grid-template-columns:1fr}.gallery-note{display:none}.gallery-grid{grid-template-columns:1fr 1fr}}
    @media(max-width:640px){.gallery-grid{grid-template-columns:1fr}.gallery-cta{display:block;padding:28px 24px}.gallery-cta .gallery-btn{margin-top:20px;width:100%;justify-content:center}}
</style>
@endsection

@section('content')
@php
    $categories = $galleryItems->pluck('category')->unique()->values();
    $totalCount = $galleryItems->count();
@endphp
<main class="gallery-page">

    {{-- Hero --}}
    <section class="gallery-hero">
        <div class="gallery-container gallery-hero__inner">
            <div>
                <div class="gallery-eyebrow">ADL Gallery</div>
                <h1>A visual record of logistics thinking.</h1>
                <p>Boardroom conversations, field perspectives, events, and the systems that keep ideas moving.</p>
                <div class="gallery-hero__stats">
                    <div class="gallery-hero__stat">
                        <span>Images</span>
                        <strong>{{ $totalCount }}</strong>
                    </div>
                    @if($categories->count() > 1)
                    <div class="gallery-hero__stat">
                        <span>Categories</span>
                        <strong>{{ $categories->count() }}</strong>
                    </div>
                    @endif
                </div>
            </div>
            <aside class="gallery-note">
                <strong>Curated for context</strong>
                <span>Images are grouped around strategy, operations, infrastructure, innovation, and people. Click any image to view it larger.</span>
            </aside>
        </div>
    </section>

    {{-- Gallery --}}
    <section class="gallery-section">
        <div class="gallery-container">

            <div class="gallery-head gallery-reveal">
                <h2>Scenes behind the thinking.</h2>
                <p>Click any image to view it larger. Use the filters to browse by category.</p>
            </div>

            {{-- Category filters --}}
            @if($categories->count() > 1)
            <div class="gallery-filters gallery-reveal" id="galleryFilters">
                <button class="gallery-filter-btn is-active" data-filter="all" type="button">
                    All <span class="gallery-filter-count">{{ $totalCount }}</span>
                </button>
                @foreach($categories as $cat)
                    @php $catCount = $galleryItems->where('category', $cat)->count(); @endphp
                    <button class="gallery-filter-btn" data-filter="{{ $cat }}" type="button">
                        {{ $cat }} <span class="gallery-filter-count">{{ $catCount }}</span>
                    </button>
                @endforeach
            </div>
            @endif

            <div class="gallery-grid" id="galleryGrid">
                @foreach($galleryItems as $index => $item)
                    <a class="gallery-card gallery-reveal"
                       href="{{ $item['image'] }}"
                       data-gallery-item
                       data-index="{{ $index }}"
                       data-title="{{ $item['title'] }}"
                       data-caption="{{ $item['caption'] }}"
                       data-category="{{ $item['category'] }}"
                       aria-label="View {{ $item['title'] }}">
                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" loading="{{ $loop->first ? 'eager' : 'lazy' }}">
                        <div class="gallery-card__eye" aria-hidden="true">
                            <div class="gallery-card__eye-inner">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 3h6m0 0v6m0-6L14 10M9 21H3m0 0v-6m0 6l7-7"/></svg>
                            </div>
                        </div>
                        <div class="gallery-card__body">
                            <span class="gallery-chip">{{ $item['category'] }}</span>
                            <h3>{{ $item['title'] }}</h3>
                            <p>{{ $item['caption'] }}</p>
                        </div>
                    </a>
                @endforeach
                <div class="gallery-empty" id="galleryEmpty">
                    <svg width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin:0 auto 12px;display:block;color:#cbd5e1"><path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909M3 21h18M21 3H3"/></svg>
                    <p>No images in this category yet.</p>
                </div>
            </div>

            <div class="gallery-cta gallery-reveal">
                <div>
                    <h2>Planning LogiSphere moments?</h2>
                    <p>Event images can be added here after the Bengaluru edition, keeping the gallery alive and current.</p>
                </div>
                <a class="gallery-btn" href="{{ route('events.conference') }}">
                    View LogiSphere
                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7l5 5-5 5M6 12h12"/></svg>
                </a>
            </div>
        </div>
    </section>

    {{-- Lightbox --}}
    <div class="gallery-lightbox" id="galleryLightbox" aria-hidden="true" role="dialog" aria-modal="true" aria-label="Gallery image viewer">
        <div class="gallery-lightbox__panel">
            <button class="gallery-close" type="button" aria-label="Close gallery">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
            <img src="" alt="">
            <div class="gallery-lightbox__footer">
                <div class="gallery-lightbox__caption">
                    <strong></strong>
                    <span></span>
                </div>
                <div style="display:flex;align-items:center;gap:14px;flex-shrink:0">
                    <span class="gallery-lightbox__counter"></span>
                    <div class="gallery-lightbox__nav">
                        <button class="gallery-lb-btn" id="lbPrev" type="button" aria-label="Previous image">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button class="gallery-lb-btn" id="lbNext" type="button" aria-label="Next image">
                            <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ── Entrance animations ── */
    var observer = new IntersectionObserver(function (entries) {
        entries.forEach(function (e) {
            if (e.isIntersecting) { e.target.classList.add('is-visible'); observer.unobserve(e.target); }
        });
    }, { threshold: 0.08, rootMargin: '0px 0px -40px 0px' });
    document.querySelectorAll('.gallery-reveal').forEach(function (el, i) {
        el.style.transitionDelay = Math.min(i * 0.06, 0.36) + 's';
        observer.observe(el);
    });

    /* ── Category filter ── */
    var filterBtns = document.querySelectorAll('.gallery-filter-btn');
    var cards = document.querySelectorAll('[data-gallery-item]');
    var emptyEl = document.getElementById('galleryEmpty');
    filterBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            filterBtns.forEach(function (b) { b.classList.remove('is-active'); });
            btn.classList.add('is-active');
            var filter = btn.dataset.filter;
            var visible = 0;
            cards.forEach(function (card) {
                var match = filter === 'all' || card.dataset.category === filter;
                card.classList.toggle('is-hidden', !match);
                if (match) visible++;
            });
            if (emptyEl) emptyEl.classList.toggle('is-visible', visible === 0);
        });
    });

    /* ── Lightbox ── */
    var lightbox = document.getElementById('galleryLightbox');
    if (!lightbox) return;
    var lbImg    = lightbox.querySelector('img');
    var lbTitle  = lightbox.querySelector('strong');
    var lbCap    = lightbox.querySelector('span');
    var lbCnt    = lightbox.querySelector('.gallery-lightbox__counter');
    var btnClose = lightbox.querySelector('.gallery-close');
    var btnPrev  = document.getElementById('lbPrev');
    var btnNext  = document.getElementById('lbNext');
    var activeItems = [];
    var currentIdx  = 0;

    function getVisibleItems() {
        return Array.from(document.querySelectorAll('[data-gallery-item]:not(.is-hidden)'));
    }

    function openAt(idx) {
        activeItems = getVisibleItems();
        currentIdx  = idx;
        var item    = activeItems[currentIdx];
        if (!item) return;
        lbImg.src        = item.href;
        lbImg.alt        = item.dataset.title || 'Gallery image';
        lbTitle.textContent = item.dataset.title || '';
        lbCap.textContent   = item.dataset.caption || '';
        lbCnt.textContent   = (currentIdx + 1) + ' / ' + activeItems.length;
        btnPrev.disabled = currentIdx === 0;
        btnNext.disabled = currentIdx === activeItems.length - 1;
        lightbox.classList.add('is-open');
        lightbox.setAttribute('aria-hidden', 'false');
        btnClose.focus();
    }

    function closeLightbox() {
        lightbox.classList.remove('is-open');
        lightbox.setAttribute('aria-hidden', 'true');
        lbImg.src = '';
    }

    document.querySelectorAll('[data-gallery-item]').forEach(function (item, i) {
        item.addEventListener('click', function (e) {
            e.preventDefault();
            var visible = getVisibleItems();
            openAt(visible.indexOf(item));
        });
    });

    btnClose.addEventListener('click', closeLightbox);
    btnPrev.addEventListener('click', function () { if (currentIdx > 0) openAt(currentIdx - 1); });
    btnNext.addEventListener('click', function () { if (currentIdx < activeItems.length - 1) openAt(currentIdx + 1); });

    lightbox.addEventListener('click', function (e) { if (e.target === lightbox) closeLightbox(); });
    document.addEventListener('keydown', function (e) {
        if (!lightbox.classList.contains('is-open')) return;
        if (e.key === 'Escape')      closeLightbox();
        if (e.key === 'ArrowLeft'  && currentIdx > 0)                     openAt(currentIdx - 1);
        if (e.key === 'ArrowRight' && currentIdx < activeItems.length - 1) openAt(currentIdx + 1);
    });
});
</script>
@endsection
