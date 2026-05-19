@extends('layouts.front')

@section('styles')
<style>
    .gallery-soon{font-family:"Public Sans",system-ui,sans-serif;background:linear-gradient(180deg,#f8fbff 0%,#fff 100%);color:#0f172a}
    .gallery-soon__section{padding:82px 0 96px}
    .gallery-soon__inner{width:min(960px,calc(100% - 32px));margin:0 auto;text-align:center}
    .gallery-soon__badge{display:inline-flex;align-items:center;gap:10px;margin-bottom:18px;border:1px solid #d8e3f0;border-radius:999px;background:#fff;padding:9px 15px;color:#0369a1;font-size:.76rem;font-weight:900;letter-spacing:.12em;text-transform:uppercase}
    .gallery-soon h2{margin:0 auto 14px;max-width:720px;color:#0f172a;font-family:"Playfair Display",Georgia,serif;font-size:clamp(2rem,4vw,3.7rem);font-weight:500;line-height:1.12}
    .gallery-soon p{margin:0 auto;color:#475569;font-size:1rem;line-height:1.75;max-width:640px}
    .gallery-soon__actions{display:flex;justify-content:center;gap:12px;flex-wrap:wrap;margin-top:30px}
    .gallery-soon__btn{display:inline-flex;align-items:center;justify-content:center;border-radius:40px;padding:13px 24px;font-size:.9rem;font-weight:800;text-decoration:none}
    .gallery-soon__btn.primary{background:#2562E9;color:#fff}
    .gallery-soon__btn.secondary{border:1px solid #d8e3f0;background:#fff;color:#0f172a}
    .gallery-soon__panel{margin-top:46px;border:1px solid #d8e3f0;border-radius:22px;background:#fff;box-shadow:0 18px 55px rgba(15,23,42,.07);padding:28px}
    .gallery-soon__grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px;text-align:left}
    .gallery-soon__item{border-left:3px solid #2562E9;padding-left:14px}
    .gallery-soon__item strong{display:block;margin-bottom:5px;color:#0f172a;font-size:.95rem}
    .gallery-soon__item span{display:block;color:#64748b;font-size:.86rem;line-height:1.6}
    @media(max-width:720px){.gallery-soon__section{padding:58px 0 72px}.gallery-soon__grid{grid-template-columns:1fr}.gallery-soon__actions{display:grid}.gallery-soon__btn{width:100%}}
</style>
@endsection

@section('content')
<main class="gallery-soon">
    @include('partials.page-banner', [
        'banner' => $banner ?? null,
        'fallbackHeading' => 'Gallery coming soon',
        'fallbackSubheading' => 'A visual record of events, conversations, and logistics moments is being prepared.',
    ])

    <section class="gallery-soon__section">
        <div class="gallery-soon__inner">
            <span class="gallery-soon__badge">Coming Soon</span>
            <h2>The gallery is being curated.</h2>
            <p>New images will appear here once they are ready for publication. For now, explore the latest writing and event updates from Ananth Decodes Logistics.</p>
            <div class="gallery-soon__actions">
                <a class="gallery-soon__btn primary" href="{{ route('blog.index') }}">Read Blog</a>
                <a class="gallery-soon__btn secondary" href="{{ route('events.conference') }}">View Events</a>
            </div>
            <div class="gallery-soon__panel">
                <div class="gallery-soon__grid">
                    <div class="gallery-soon__item">
                        <strong>Events</strong>
                        <span>Conference and session images will be added after publication approval.</span>
                    </div>
                    <div class="gallery-soon__item">
                        <strong>Insights</strong>
                        <span>Visual notes from field perspectives and boardroom conversations.</span>
                    </div>
                    <div class="gallery-soon__item">
                        <strong>People</strong>
                        <span>Selected moments from contributors, speakers, and logistics leaders.</span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
@endsection
