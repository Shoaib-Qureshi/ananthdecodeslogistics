@php($footer = \App\Models\SiteSetting::first())
<footer class="footer">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="footerSocial">
                    <img src="{{ $footer?->footer_logo ? Storage::url($footer->footer_logo) : '/img/site/ananth-inverted0logo.svg' }}" alt="Ananth Decodes Logistics">
                    <p>{{ $footer?->footer_tagline ?? 'Logistics leader sharing insights on strategy, innovation, and sustainable growth' }}</p>
                    @if($footer?->footer_company_name)<p>{{ $footer->footer_company_name }}</p>@endif
                    <ul>
                        <li><a href="{{ $footer?->social_linkedin ?? 'https://www.linkedin.com/in/ananthakrishnan-janardhanan/' }}" aria-label="LinkedIn"><i class='bx bxl-linkedin'></i></a></li>
                        @if($footer?->social_twitter)
                            <li>
                                <a href="{{ $footer->social_twitter }}" aria-label="Twitter / X">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14"><path fill="currentColor" d="M11.025.656h2.147L8.482 6.03 14 13.344H9.68L6.294 8.909l-3.87 4.435H.275l5.016-5.75L0 .657h4.43L7.486 4.71zm-.755 11.4h1.19L3.78 1.877H2.504z"/></svg>
                                </a>
                            </li>
                        @endif
                        @if($footer?->social_instagram)
                            <li><a href="{{ $footer->social_instagram }}" aria-label="Instagram"><i class='bx bxl-instagram'></i></a></li>
                        @endif
                    </ul>
                </div>
            </div>
            <div class="col-lg-7 col-md-6 offset-lg-1">
                <div class="row">
                    <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                        <div class="footerLinks">
                            <h4>Navigation</h4>
                            <ul>
                                <li><a href="/">Home</a></li>
                                <li><a href="/about-us/">About Us</a></li>
                                <li><a href="/blog/">Blog</a></li>
                                <li><a href="{{ route('contributors.index') }}">The Expert Desk</a></li>
                                <li><a href="/board-insights/">Board Insights</a></li>
                                <li><a href="/book-review/">Book Reviews</a></li>
                                <li><a href="/contact-us/">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-6 col-6">
                        <div class="footerLinks">
                            <h4>Important Links</h4>
                            <ul>
                                <li><a href="/privacy-policy/">Privacy Policy</a></li>
                                <li><a href="/terms-and-conditions/">Terms & Conditions</a></li>
                                <li><a href="/disclaimer/">Disclaimer</a></li>
                                <li><a href="{{ route('write-for-us') }}">Write for Us</a></li>
                                <li><a href="{{ route('contributor.register') }}">Apply to The Expert Desk</a></li>
                                <li><a href="{{ route('contributor.login') }}">The Expert Desk Login</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footerCredit">
            <p>{{ $footer?->footer_copyright ?? '(c) ' . now()->year . ' Ananth Decodes Logistics. All rights reserved.' }}</p>
            @if($footer?->cin)<p>CIN: {{ $footer->cin }}</p>@endif
        </div>
    </div>
</footer>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"></script>
<script src="/js/script.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        $(".chosen-select").chosen({ width: "100%", placeholder_text_multiple: "Select one or more services" });
    });
</script>
