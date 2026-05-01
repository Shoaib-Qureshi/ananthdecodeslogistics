<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php
        $seoTitle       = $seo['title']       ?? trim($__env->yieldContent('title'));
        $seoDescription = $seo['description'] ?? trim($__env->yieldContent('description'));
        $seoCanonical   = $seo['canonical']   ?? trim($__env->yieldContent('url'));
        $seoImage       = $seo['image']       ?? trim($__env->yieldContent('img'));
        $seoRobots      = $seo['robots']      ?? null;
        $seoSchema      = $seo['schema']      ?? null;
    @endphp
    <title>{{ $seoTitle }}</title>
    <meta name="description" content="{{ $seoDescription }}">
    @if($seoRobots)<meta name="robots" content="{{ $seoRobots }}">@endif
    <link rel="canonical" href="{{ $seoCanonical }}">
    <meta property="og:title"       content="{{ $seoTitle }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:image"       content="{{ $seoImage }}">
    <meta property="og:url"         content="{{ $seoCanonical }}">
    <meta property="og:type"        content="website">
    <meta property="og:site_name"   content="Ananth Decodes Logistics">
    @if($seoSchema)
    <script type="application/ld+json">{!! $seoSchema !!}</script>
    @endif

    {{-- Google Fonts --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Libre+Bodoni:wght@400;500;600;700&family=Public+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    {{-- Boxicons --}}
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    {{-- Tailwind CDN with custom design tokens --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
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
                }
            }
        }
    </script>

    {{-- Reduced motion support --}}
    <style>
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { animation-duration: 0.01ms !important; transition-duration: 0.01ms !important; }
        }
    </style>

    @yield('styles')

    {{-- Analytics --}}
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-BGWKN61TJH"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-BGWKN61TJH');
    </script>
    <script type="text/javascript">
        (function(c,l,a,r,i,t,y){
            c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
            t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
            y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
        })(window, document, "clarity", "script", "syw3izboc4");
    </script>
</head>
<body class="font-sans bg-white text-body antialiased">

    @include('layout.nav')

    <main>
        @yield('content')
    </main>

    @include('layout.footer')

    @yield('scripts')

</body>
</html>
