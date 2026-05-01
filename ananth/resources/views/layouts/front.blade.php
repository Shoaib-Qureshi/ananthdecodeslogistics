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
    <script src="/js/script.js"></script>
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
