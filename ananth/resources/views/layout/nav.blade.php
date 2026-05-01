<style>
    #adl-nav, #adl-nav *, #adl-nav-offset { box-sizing: border-box; }
    #adl-nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 9999;
        background: rgba(255,255,255,.95);
        border-bottom: 1px solid #D8E3F0;
        box-shadow: 0 1px 3px rgba(15,23,42,.08);
        backdrop-filter: blur(8px);
        font-family: "Public Sans", system-ui, sans-serif;
        line-height: 1.5;
    }
    #adl-nav > div {
        max-width: 1200px;
        margin-left: auto;
        margin-right: auto;
        padding-left: 1rem;
        padding-right: 1rem;
    }
    #adl-nav > div > div:first-child {
        height: 4rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    #adl-nav ul, #adl-nav li { list-style: none; margin: 0; padding: 0; }
    #adl-nav a { text-decoration: none; color: #0F172A; }
    #adl-nav button { appearance: none; border: 0; background: transparent; font: inherit; margin: 0; color: #0F172A; }
    #adl-nav svg, #adl-nav img { display: block; }
    #adl-nav .logo-img { height: 2.25rem; width: auto; }
    #adl-nav .desktop-menu { display: none; align-items: center; gap: .125rem; }
    #adl-nav .desktop-menu a,
    #adl-nav .desktop-menu button,
    #adl-mobile-menu a,
    #adl-mobile-menu button {
        font-size: .875rem;
        font-weight: 500;
        color: #0F172A;
        border-radius: .5rem;
        transition: color .2s ease, background-color .2s ease, border-color .2s ease;
    }
    #adl-nav .desktop-menu > li > a,
    #adl-nav .desktop-menu > li > button {
        display: flex;
        align-items: center;
        gap: .25rem;
        padding: .5rem .625rem;
        line-height: 1.25rem;
    }
    #adl-nav .desktop-menu a:hover,
    #adl-nav .desktop-menu button:hover,
    #adl-mobile-menu a:hover,
    #adl-mobile-menu button:hover { color: #2563EB; }
    #adl-nav .desktop-submenu {
        position: absolute;
        top: 100%;
        left: 0;
        margin-top: .25rem;
        min-width: 13rem;
        padding: .5rem 0;
        border: 1px solid #D8E3F0;
        border-radius: .75rem;
        background: #fff;
        box-shadow: 0 8px 30px rgba(0,0,0,.12);
        opacity: 0;
        visibility: hidden;
        transform: translateY(.5rem);
        transition: opacity .2s ease, visibility .2s ease, transform .2s ease;
    }
    #adl-nav .group:hover .desktop-submenu {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    #adl-nav .desktop-submenu a {
        display: block;
        padding: .625rem 1rem;
        font-size: .875rem;
        color: #0F172A;
        border-radius: 0;
    }
    #adl-nav .nav-actions { display: none; align-items: center; gap: .75rem; }
    #adl-nav .nav-login {
        display: flex;
        align-items: center;
        gap: .375rem;
        padding: .5rem .75rem;
        color: #475569;
        font-size: .875rem;
        font-weight: 500;
    }
    #adl-nav .nav-cta {
        display: inline-flex;
        align-items: center;
        background: #2562E9;
        color: #fff;
        padding: .625rem 1.25rem;
        border-radius: 40px;
        font-size: .875rem;
        font-weight: 600;
    }
    #adl-nav .nav-cta:hover { background: #181A3F; color: #fff; }
    #adl-hamburger {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 2.5rem;
        height: 2.5rem;
        border-radius: .5rem;
    }
    #adl-mobile-menu {
        display: none;
        border-top: 1px solid #D8E3F0;
        padding: .5rem 0 1rem;
    }
    #adl-mobile-menu:not(.hidden) { display: block; }
    #adl-mobile-menu a,
    #adl-mobile-menu button {
        display: flex;
        width: 100%;
        align-items: center;
        justify-content: space-between;
        padding: .625rem .75rem;
    }
    #adl-mobile-menu .mobile-cta {
        justify-content: center;
        background: #2562E9;
        color: #fff;
        padding: .75rem 1.25rem;
        border-radius: 40px;
        font-weight: 600;
    }
    #adl-mobile-menu .mobile-cta:hover { background:#181A3F; color:#fff; }
    #adl-nav-offset { height: 4rem; }
    @media (min-width: 640px) {
        #adl-nav > div { padding-left: 1.5rem; padding-right: 1.5rem; }
    }
    @media (min-width: 1024px) {
        #adl-nav > div > div:first-child { height: 5rem; }
        #adl-nav .logo-img { height: 2.75rem; }
        #adl-nav .desktop-menu { display: flex; }
        #adl-nav .nav-actions { display: flex; }
        #adl-hamburger { display: none; }
        #adl-nav-offset { height: 5rem; }
    }
</style>

<nav id="adl-nav" class="fixed top-0 inset-x-0 z-50 transition-all duration-300 bg-white/95 backdrop-blur-sm border-b border-border shadow-sm" aria-label="Main navigation">
    <div class="max-w-screen-xl mx-auto px-4 sm:px-6">
        <div class="flex items-center justify-between h-16 lg:h-20">

            {{-- Logo --}}
            <a href="/" class="flex-shrink-0 focus:outline-none focus-visible:ring-2 focus-visible:ring-cta rounded" aria-label="Ananth Decodes Logistics — Home">
                <img src="/img/site/ananth-logo.svg" alt="Ananth Decodes Logistics" class="logo-img">
            </a>

            {{-- Desktop Navigation --}}
            <ul class="desktop-menu" role="menubar">

                <li role="none">
                    <a href="/" class="px-3 py-2 text-sm font-medium text-body hover:text-navy transition-colors duration-200 rounded cursor-pointer" role="menuitem">
                        Home
                    </a>
                </li>

                <li role="none">
                    <a href="/about-us" class="px-3 py-2 text-sm font-medium text-body hover:text-navy transition-colors duration-200 rounded cursor-pointer" role="menuitem">
                        About
                    </a>
                </li>

                {{-- Resources Dropdown --}}
                <li class="relative group" role="none">
                    <button class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-body group-hover:text-cta transition-colors duration-200 rounded cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-cta"
                            aria-haspopup="true" aria-expanded="false" role="menuitem">
                        Resources
                        <svg class="w-4 h-4 text-muted transition-transform duration-200 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <ul class="desktop-submenu"
                        role="menu" aria-label="Resources submenu">
                        <li role="none"><a href="/blog" class="block px-4 py-2.5 text-sm text-body hover:text-navy hover:bg-cream transition-colors duration-150 cursor-pointer" role="menuitem">Blog</a></li>
                        <li role="none"><a href="/board-insights" class="block px-4 py-2.5 text-sm text-body hover:text-navy hover:bg-cream transition-colors duration-150 cursor-pointer" role="menuitem">Board Insights</a></li>
                        <li role="none"><a href="/book-review" class="block px-4 py-2.5 text-sm text-body hover:text-navy hover:bg-cream transition-colors duration-150 cursor-pointer" role="menuitem">Book Reviews</a></li>
                    </ul>
                </li>

                <li role="none">
                    <a href="{{ route('contributors.index') }}" class="px-3 py-2 text-sm font-medium text-body hover:text-navy transition-colors duration-200 rounded cursor-pointer" role="menuitem">
                        The Expert Desk
                    </a>
                </li>

                {{-- Events Dropdown --}}
                <li class="relative group" role="none">
                    <button class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-body group-hover:text-cta transition-colors duration-200 rounded cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-cta"
                            aria-haspopup="true" aria-expanded="false" role="menuitem">
                        Events
                        <svg class="w-4 h-4 text-muted transition-transform duration-200 group-hover:rotate-180" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <ul class="desktop-submenu"
                        role="menu" aria-label="Events submenu">
                        <li role="none"><a href="/events/sponsorship" class="block px-4 py-2.5 text-sm text-body hover:text-navy hover:bg-cream transition-colors duration-150 cursor-pointer" role="menuitem">Sponsor &amp; Exhibitors</a></li>
                        <li role="none"><a href="/events/why-who" class="block px-4 py-2.5 text-sm text-body hover:text-navy hover:bg-cream transition-colors duration-150 cursor-pointer" role="menuitem">Why &amp; Who</a></li>
                        <li role="none"><a href="/events/conference" class="block px-4 py-2.5 text-sm text-body hover:text-navy hover:bg-cream transition-colors duration-150 cursor-pointer" role="menuitem">Upcoming Networking Event</a></li>
                    </ul>
                </li>

                <li role="none">
                    <a href="/gallery" class="px-3 py-2 text-sm font-medium text-body hover:text-navy transition-colors duration-200 rounded cursor-pointer" role="menuitem">
                        Gallery
                    </a>
                </li>

            </ul>

            {{-- Desktop Right Actions --}}
            <div class="nav-actions">
                <a href="{{ route('contributor.login') }}"
                   class="nav-login"
                   aria-label="Expert Desk Login">
                    <i class="bx bx-user-circle text-lg" aria-hidden="true"></i>
                    <span class="hidden xl:inline">Expert Desk</span>
                </a>
                <a href="/contact-us"
                   class="nav-cta">
                    Contact Us
                </a>
            </div>

            {{-- Mobile Hamburger --}}
            <button id="adl-hamburger"
                    class="lg:hidden flex items-center justify-center w-10 h-10 rounded-lg text-navy hover:bg-cream transition-colors duration-200 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-cta"
                    aria-label="Toggle navigation menu"
                    aria-controls="adl-mobile-menu"
                    aria-expanded="false">
                <svg id="hamburger-open" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <svg id="hamburger-close" class="w-6 h-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

        </div>

        {{-- Mobile Menu --}}
        <div id="adl-mobile-menu"
             class="hidden lg:hidden border-t border-border pb-4 pt-2"
             role="region"
             aria-label="Mobile navigation">
            <ul class="space-y-0.5">
                <li><a href="/" class="block px-3 py-2.5 text-sm font-medium text-body hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer">Home</a></li>
                <li><a href="/about-us" class="block px-3 py-2.5 text-sm font-medium text-body hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer">About</a></li>

                {{-- Resources accordion --}}
                <li>
                    <button class="adl-mobile-toggle w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-body hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer"
                            aria-expanded="false">
                        Resources
                        <svg class="w-4 h-4 text-muted transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <ul class="hidden pl-4 mt-0.5 space-y-0.5">
                        <li><a href="/blog" class="block px-3 py-2 text-sm text-muted hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer">Blog</a></li>
                        <li><a href="/board-insights" class="block px-3 py-2 text-sm text-muted hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer">Board Insights</a></li>
                        <li><a href="/book-review" class="block px-3 py-2 text-sm text-muted hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer">Book Reviews</a></li>
                    </ul>
                </li>

                <li><a href="{{ route('contributors.index') }}" class="block px-3 py-2.5 text-sm font-medium text-body hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer">The Expert Desk</a></li>

                {{-- Events accordion --}}
                <li>
                    <button class="adl-mobile-toggle w-full flex items-center justify-between px-3 py-2.5 text-sm font-medium text-body hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer"
                            aria-expanded="false">
                        Events
                        <svg class="w-4 h-4 text-muted transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <ul class="hidden pl-4 mt-0.5 space-y-0.5">
                        <li><a href="/events/sponsorship" class="block px-3 py-2 text-sm text-muted hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer">Sponsor &amp; Exhibitors</a></li>
                        <li><a href="/events/why-who" class="block px-3 py-2 text-sm text-muted hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer">Why &amp; Who</a></li>
                        <li><a href="/events/conference" class="block px-3 py-2 text-sm text-muted hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer">Upcoming Networking Event</a></li>
                    </ul>
                </li>

                <li><a href="/gallery" class="block px-3 py-2.5 text-sm font-medium text-body hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer">Gallery</a></li>
                <li><a href="{{ route('contributor.login') }}" class="block px-3 py-2.5 text-sm font-medium text-body hover:text-navy hover:bg-cream rounded-lg transition-colors duration-150 cursor-pointer">Expert Desk Login</a></li>
                <li class="pt-2">
                    <a href="/contact-us"
                       class="mobile-cta">
                        Contact Us
                    </a>
                </li>
            </ul>
        </div>

    </div>
</nav>

{{-- Add top padding to offset fixed nav height --}}
<div id="adl-nav-offset" aria-hidden="true"></div>

<script>
    (function () {
        const hamburger = document.getElementById('adl-hamburger');
        const mobileMenu = document.getElementById('adl-mobile-menu');
        const openIcon = document.getElementById('hamburger-open');
        const closeIcon = document.getElementById('hamburger-close');

        if (!hamburger || !mobileMenu || !openIcon || !closeIcon) {
            return;
        }

        hamburger.addEventListener('click', function () {
            const isOpen = !mobileMenu.classList.contains('hidden');
            mobileMenu.classList.toggle('hidden', isOpen);
            openIcon.classList.toggle('hidden', !isOpen);
            closeIcon.classList.toggle('hidden', isOpen);
            hamburger.setAttribute('aria-expanded', String(!isOpen));
        });

        // Mobile accordion toggles
        document.querySelectorAll('.adl-mobile-toggle').forEach(function (btn) {
            btn.addEventListener('click', function () {
                const submenu = btn.nextElementSibling;
                const chevron = btn.querySelector('svg');
                const isOpen = !submenu.classList.contains('hidden');
                submenu.classList.toggle('hidden', isOpen);
                chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
                btn.setAttribute('aria-expanded', String(!isOpen));
            });
        });
    })();
</script>
