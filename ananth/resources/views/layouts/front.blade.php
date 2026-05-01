<!doctype html>
<html>

<head>
    @include('includes.front.head')
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Bodoni:wght@400;500;600;700&family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            corePlugins: { preflight: false },
            theme: {
                extend: {
                    colors: {
                        navy:   '#0F172A',
                        steel:  '#0369A1',
                        teal:   '#0F766E',
                        cta:    '#2562E9',
                        cream:  '#F8FAFC',
                        softbg: '#EFF6FF',
                        body:   '#0F172A',
                        muted:  '#475569',
                        border: '#D8E3F0',
                    },
                    fontFamily: {
                        display: ['"Libre Bodoni"', 'Georgia', 'serif'],
                        heading: ['"Libre Bodoni"', 'Georgia', 'serif'],
                        sans:    ['"Public Sans"', 'system-ui', 'sans-serif'],
                    },
                    maxWidth: {
                        'screen-xl': '1200px',
                    },
                    boxShadow: {
                        card:       '0 4px 20px rgba(0,0,0,0.08)',
                        'card-hover': '0 8px 40px rgba(0,0,0,0.13)',
                    },
                }
            }
        }
    </script>
    <style>
        :root{--adl-primary-cta:#2562E9;--adl-primary-cta-hover:#181A3F;--dark-blue:#0f172a;--white:#fff}
        .adl-page-banner{position:relative;min-height:360px;display:flex;align-items:center;overflow:hidden;background:#0f172a}
        .adl-page-banner__image{position:absolute;inset:0;background-size:cover;background-position:center;transform:scale(1.03)}
        .adl-page-banner__overlay{position:absolute;inset:0;background:linear-gradient(90deg,rgb(15 23 42),rgb(3 105 161 / 40%))}
        .adl-page-banner__inner{position:relative;z-index:1;width:100%;max-width:1200px;margin-left:auto;margin-right:auto;padding:64px 1rem}
        .adl-page-banner__copy{max-width:700px;color:#fff}
        .adl-page-banner__eyebrow{color:#bae6fd;font-size:.78rem;font-weight:700;letter-spacing:.18em;text-transform:uppercase;margin-bottom:1rem}
        .adl-page-banner h1{color:#fff;font-family:"Libre Bodoni",Georgia,serif;font-size:clamp(2.15rem,4vw,4rem);line-height:1.14;font-weight:600;margin:0 0 1rem}
        .adl-page-banner__subheading{color:rgba(255,255,255,.82);font-size:1.08rem;line-height:1.75;max-width:620px;margin-bottom:0}
        .adl-page-banner__cta,.adl-primary-cta,.post-readmore,.cta-strip a{display:inline-flex;align-items:center;justify-content:center;border-radius:40px!important;background:var(--adl-primary-cta)!important;color:#fff!important;text-decoration:none}
        .adl-page-banner__cta{margin-top:1.7rem;padding:.85rem 1.25rem;font-size:.92rem;font-weight:700}
        .adl-page-banner__cta:hover,.adl-primary-cta:hover,.post-readmore:hover,.cta-strip a:hover{background:var(--adl-primary-cta-hover)!important;color:#fff!important}
        .adl-resource-section{padding:72px 0;background:radial-gradient(circle at 10% 0%,rgba(37,98,233,.10),transparent 34%),linear-gradient(180deg,#fff 0%,#f8fbff 100%)}
        .adl-resource-container{width:min(1200px,calc(100% - 32px));margin:0 auto}
        .adl-resource-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:28px}
        .adl-resource-grid--wide{grid-template-columns:repeat(2,minmax(0,1fr))}
        .adl-resource-card{position:relative;display:flex;flex-direction:column;min-height:100%;overflow:hidden;border:1px solid #d8e3f0;border-radius:18px;background:rgba(255,255,255,.92);box-shadow:0 14px 40px rgba(15,23,42,.06);text-decoration:none;transition:transform .2s,border-color .2s,box-shadow .2s}
        .adl-resource-card:hover{transform:translateY(-3px);border-color:rgba(37,98,233,.28);box-shadow:0 22px 54px rgba(15,23,42,.11)}
        .adl-resource-card__media{position:relative;aspect-ratio:16/10;overflow:hidden;background:#eaf3fb}
        .adl-resource-card__media img{width:100%;height:100%;object-fit:cover;object-position:center;display:block}
        .adl-resource-card__body{display:flex;flex:1;flex-direction:column;padding:20px}
        .adl-resource-card__meta{display:flex;flex-wrap:wrap;gap:.65rem;color:#0369a1;font-size:.72rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;margin-bottom:.8rem}
        .adl-resource-card h3{color:#0f172a;font-family:"Libre Bodoni",Georgia,serif;font-size:clamp(1.18rem,1.7vw,1.45rem);line-height:1.22;margin:0 0 .75rem}
        .adl-resource-card p{color:#475569;font-size:.95rem;line-height:1.62;margin:0 0 1rem}
        .adl-resource-card__cta{margin-top:auto;display:inline-flex;align-items:center;gap:.35rem;color:#2562E9;font-size:.86rem;font-weight:800}
        .adl-resource-empty{border:1px dashed #cbd5e1;border-radius:18px;background:#fff;color:#64748b;padding:4rem 1.5rem;text-align:center}
        .adl-resource-pagination{margin-top:42px;display:flex;justify-content:center}
        @media(min-width:640px){.adl-page-banner__inner{padding-left:1.5rem;padding-right:1.5rem}}
        @media(max-width:991px){.adl-resource-grid,.adl-resource-grid--wide{grid-template-columns:repeat(2,minmax(0,1fr))}}
        @media(max-width:640px){.adl-page-banner{min-height:320px}.adl-page-banner__inner{padding-top:48px;padding-bottom:48px}.adl-page-banner h1{font-size:clamp(2rem,12vw,3rem);line-height:1.12}.adl-resource-section{padding:54px 0}.adl-resource-container{width:min(100% - 24px,1200px)}.adl-resource-grid,.adl-resource-grid--wide{grid-template-columns:1fr;gap:20px}}
    </style>
    @yield('styles')
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "syw3izboc4");
    </script>
</head>

<body>
    @include('layout.nav')
    @yield('content')
    @include('layout.footer')

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
    <script src="{{ asset('js/script.js?v=') . filemtime(public_path('js/script.js')) }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            if (window.jQuery && $(".chosen-select").length) {
                $(".chosen-select").chosen({ width: "100%", placeholder_text_multiple: "Select one or more services" });
            }
        });
    </script>
    @yield('scripts')
</body>

</html>
