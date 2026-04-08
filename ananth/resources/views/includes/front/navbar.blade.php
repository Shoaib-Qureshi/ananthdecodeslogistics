<header id="nav-menu" aria-label="navigation bar">
    <div class="container menu_container">
        <div class="nav-start">
            <a class="logo" href="/">
                <img src="/img/site/ananth-logo.svg" alt="" />
            </a>
        </div>
        <div class="nav-center">
            <nav class="menu">
                <ul class="menu-bar container">
                    <li><a class="mainColor nav-link" href="/">Home</a></li>
                    <li><a class="mainColor nav-link" href="/about-us/">About</a></li>
                    <li><a class="mainColor nav-link" href="/blog/">Blog</a></li>
                    <li><a class="mainColor nav-link" href="{{ route('contributors.index') }}">The Expert Desk</a></li>
                    <li class="contributor-mobile-link"><a class="mainColor nav-link" href="{{ route('contributor.login') }}">The Expert Desk Login</a></li>
                    <li><a class="mainColor nav-link" href="/board-insights/">Board Insights</a></li>
                    <li><a class="mainColor nav-link" href="/book-review/">Book Reviews</a></li>
                </ul>
            </nav>
        </div>
        <div class="nav-end">
            <div class="right-container">
                <a href="{{ route('contributor.login') }}" class="menu_secondary_btn" aria-label="The Expert Desk Login" title="The Expert Desk Login">
                    <i class='bx bx-user-circle' aria-hidden="true"></i>
                </a>
                <a href="/contact-us/"><button class="menu_btn">Contact Us</button></a>
            </div>

            <button id="hamburger" aria-label="hamburger" aria-haspopup="true" aria-expanded="false">
                <i class="bx bx-menu" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</header>
