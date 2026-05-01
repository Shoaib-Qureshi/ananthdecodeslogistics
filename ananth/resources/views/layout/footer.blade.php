@php
    $footer = \App\Models\SiteSetting::first();
    $footerLogo = $footer?->footer_logo ? Storage::url($footer->footer_logo) : '/img/site/ananth-inverted0logo.svg';
@endphp

<footer id="adl-footer" class="bg-white pt-8 lg:pt-10" aria-label="Site footer">
    <div class="relative bg-[linear-gradient(135deg,#030712_0%,#07111F_44%,#101826_100%)] text-white">
        <div class="absolute inset-0 bg-cover bg-center opacity-18" style="background-image: url('{{ asset('img/site/abstract-waves.webp') }}')" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_8%,rgba(37,99,235,0.18),transparent_34%),radial-gradient(circle_at_82%_24%,rgba(14,165,233,0.12),transparent_30%),linear-gradient(180deg,rgba(0,0,0,0.70),rgba(0,0,0,0.88))]" aria-hidden="true"></div>
        <div class="relative z-10 max-w-screen-xl mx-auto px-4 sm:px-6 pt-8 lg:pt-10">
            <section class="relative -top-14 lg:-top-[8rem] mb-0 overflow-hidden rounded-2xl border border-white/10 bg-[linear-gradient(135deg,#030712_0%,#07111F_48%,#000000_100%)] px-6 py-8 sm:px-10 lg:px-12 lg:py-10 shadow-[0_24px_80px_rgba(15,23,42,0.28)]" aria-label="The Expert Desk call to action">
                <div class="absolute inset-0 bg-cover bg-center opacity-14" style="background-image: url('{{ asset('img/site/abstract-waves.webp') }}')" aria-hidden="true"></div>
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_18%_18%,rgba(37,99,235,0.16),transparent_34%),linear-gradient(90deg,rgba(0,0,0,0.88)_0%,rgba(0,0,0,0.94)_48%,rgba(0,0,0,0.62)_100%)]" aria-hidden="true"></div>
                <div class="absolute inset-y-0 right-0 hidden w-1/2 bg-black/35 lg:block" aria-hidden="true"></div>
                <div class="absolute inset-y-0 right-0 hidden w-1/2 bg-right-center bg-contain bg-no-repeat opacity-100 lg:block" style="background-image: url('{{ asset('img/Footer Bg image.png') }}')" aria-hidden="true"></div>
                <div class="relative z-10">
                    <div class="max-w-3xl">
                        <p class="mb-4 inline-flex items-center gap-2 rounded-full border border-sky-300/20 bg-white/[0.06] px-3.5 py-2 text-xs font-semibold uppercase text-sky-100">
                            <i class="bx bx-edit-alt text-sm" aria-hidden="true"></i>
                            The Expert Desk
                        </p>
                        <h2 class="font-heading text-3xl sm:text-4xl lg:text-5xl leading-[1.05] mb-4">
                            Publish sharper logistics perspectives.
                        </h2>
                        <p class="max-w-xl text-white/66 text-sm sm:text-base leading-7 mb-7">
                            Share field-tested ideas with supply chain leaders, operators, and decision makers who read for signal.
                        </p>
                        <div class="flex flex-wrap gap-3">
                            <a href="{{ route('write-for-us') }}" class="adl-primary-cta inline-flex items-center gap-2 px-5 py-3 text-sm font-semibold transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-200">
                                Write for Us
                                <i class="bx bx-right-arrow-alt text-lg" aria-hidden="true"></i>
                            </a>
                            <a href="{{ route('contributor.register') }}" class="inline-flex items-center gap-2 rounded-[40px] border border-white/25 px-5 py-3 text-sm font-semibold text-white hover:bg-white/10 transition-colors duration-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-sky-200">
                                Apply to The Expert Desk
                                <i class="bx bx-user-plus text-lg" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </section>

            <div class="-mt-8 pb-8 lg:-mt-10 lg:pb-10">
                <div class="grid gap-10 lg:grid-cols-[1.25fr_.75fr_.75fr_.85fr]">
                    <div>
                        <img src="{{ $footerLogo }}" alt="Ananth Decodes Logistics" class="h-10 w-auto mb-5">
                        <p class="max-w-xs text-white/55 text-sm leading-7">
                            {{ $footer?->footer_tagline ?? 'Logistics leader sharing insights on strategy, innovation, and sustainable growth.' }}
                        </p>
                    </div>

                    <nav aria-label="Footer explore links">
                        <p class="text-white/42 text-sm font-semibold mb-4">Explore</p>
                        <ul class="grid gap-3">
                            @foreach ([
                                'Home' => '/',
                                'About Us' => '/about-us',
                                'Blog' => '/blog',
                                'The Expert Desk' => route('contributors.index'),
                            ] as $label => $url)
                            <li><a href="{{ $url }}" class="text-white/70 hover:text-white transition-colors duration-200">{{ $label }}</a></li>
                            @endforeach
                        </ul>
                    </nav>

                    <nav aria-label="Footer resources links">
                        <p class="text-white/42 text-sm font-semibold mb-4">Resources</p>
                        <ul class="grid gap-3">
                            @foreach ([
                                'Board Insights' => '/board-insights',
                                'Book Reviews' => '/book-review',
                                'Write for Us' => route('write-for-us'),
                                'Contact Us' => '/contact-us',
                            ] as $label => $url)
                            <li><a href="{{ $url }}" class="text-white/70 hover:text-white transition-colors duration-200">{{ $label }}</a></li>
                            @endforeach
                        </ul>
                    </nav>

                    <nav aria-label="Footer legal links">
                        <p class="text-white/42 text-sm font-semibold mb-4">Legal</p>
                        <ul class="grid gap-3">
                            @foreach ([
                                'Privacy Policy' => '/privacy-policy',
                                'Terms & Conditions' => '/terms-and-conditions',
                                'Disclaimer' => '/disclaimer',
                                'Expert Desk Login' => route('contributor.login'),
                            ] as $label => $url)
                            <li><a href="{{ $url }}" class="text-white/70 hover:text-white transition-colors duration-200">{{ $label }}</a></li>
                            @endforeach
                        </ul>
                    </nav>
                </div>

                <div class="mt-10 flex flex-col gap-5 border-t border-white/10 pt-6 sm:flex-row sm:items-center sm:justify-between">
                    <div class="flex flex-wrap gap-3">
                        <a href="{{ $footer?->social_linkedin ?? 'https://www.linkedin.com/in/ananthakrishnan-janardhanan/' }}" target="_blank" rel="noopener noreferrer" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/65 hover:border-sky-300/50 hover:text-sky-200 transition-colors duration-200" aria-label="LinkedIn">
                            <i class="bx bxl-linkedin text-lg" aria-hidden="true"></i>
                        </a>
                        @if($footer?->social_twitter)
                        <a href="{{ $footer->social_twitter }}" target="_blank" rel="noopener noreferrer" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/65 hover:border-sky-300/50 hover:text-sky-200 transition-colors duration-200" aria-label="Twitter / X">
                            <svg class="w-4 h-4" viewBox="0 0 14 14" fill="none" aria-hidden="true"><path fill="currentColor" d="M11.025.656h2.147L8.482 6.03 14 13.344H9.68L6.294 8.909l-3.87 4.435H.275l5.016-5.75L0 .657h4.43L7.486 4.71zm-.755 11.4h1.19L3.78 1.877H2.504z"/></svg>
                        </a>
                        @endif
                        @if($footer?->social_instagram)
                        <a href="{{ $footer->social_instagram }}" target="_blank" rel="noopener noreferrer" class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-white/10 text-white/65 hover:border-sky-300/50 hover:text-sky-200 transition-colors duration-200" aria-label="Instagram">
                            <i class="bx bxl-instagram text-lg" aria-hidden="true"></i>
                        </a>
                        @endif
                    </div>

                    <div class="text-white/38 text-xs sm:text-right">
                        <p>{{ $footer?->footer_copyright ?? '(c) ' . now()->year . ' Ananth Decodes Logistics Private Limited. All rights reserved.' }}</p>
                        @if($footer?->cin)<p class="mt-1">CIN: {{ $footer->cin }}</p>@endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
