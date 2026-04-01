@extends('layouts.front')
@section('title', 'Contributor Payment Cancelled - Ananth Decodes Logistics')
@section('description', 'Your contributor checkout was cancelled before payment completed.')
@section('url', route('contributor.payment.cancel', ['payment' => request('payment')]))
@section('img', asset('img/site-banner.jpg'))

@section('styles')
<style>
    #nav-menu {
        background: rgba(255, 255, 255, 0.96);
        box-shadow: 0 18px 40px rgba(9, 17, 58, 0.08);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }

    .menu_container {
        height: 82px;
    }

    .menu_container a,
    .menu_container .menu-bar .nav-link,
    .menu_container #hamburger {
        color: #16203b !important;
    }

    .menu_container .logo img {
        width: 235px;
    }

    .paymentStatusSection .container {
        position: relative;
        z-index: 1;
    }

    .paymentStatusSection {
        padding: 9rem 0 6rem;
        position: relative;
        overflow: hidden;
    }

    .paymentStatusWrap {
        max-width: 920px;
        margin: 0 auto;
    }

    .paymentStatusCard {
        position: relative;
        border-radius: 32px;
        padding: 3rem;
        background: linear-gradient(180deg, rgba(10, 16, 63, 0.9) 0%, rgba(14, 23, 88, 0.96) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: 0 32px 80px rgba(6, 10, 38, 0.32);
        color: #fff;
        overflow: hidden;
    }

    .paymentStatusCard::before {
        content: "";
        position: absolute;
        inset: auto -80px -120px auto;
        width: 260px;
        height: 260px;
        border-radius: 999px;
        background: radial-gradient(circle, rgba(56, 130, 250, 0.24) 0%, rgba(56, 130, 250, 0) 74%);
        filter: blur(14px);
        pointer-events: none;
    }

    .paymentStatusInner {
        position: relative;
        z-index: 1;
    }

    .paymentStatusBadge {
        display: inline-flex;
        align-items: center;
        gap: 0.65rem;
        padding: 0.75rem 1rem;
        border-radius: 999px;
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.12);
        color: rgba(255, 255, 255, 0.92);
        font-size: 0.95rem;
        font-weight: 600;
    }

    .paymentStatusDot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #ffb14a;
        box-shadow: 0 0 0 6px rgba(255, 177, 74, 0.15);
    }

    .paymentStatusHero h1 {
        margin: 1.2rem 0 1rem;
        color: #fff;
        font-size: clamp(2.2rem, 4.8vw, 4rem);
        line-height: 1.08;
        letter-spacing: -0.03em;
    }

    .paymentStatusLead {
        max-width: 700px;
        margin: 0 auto;
        color: rgba(234, 240, 255, 0.84);
        font-size: 1.12rem;
        line-height: 1.8;
    }

    .paymentStatusPanel {
        max-width: 640px;
        margin: 2.2rem auto 0;
        padding: 1.4rem;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        text-align: left;
    }

    .paymentStatusPanel h3 {
        color: #fff;
        font-size: 1.1rem;
        margin-bottom: 0.8rem;
    }

    .paymentStatusPanel ul {
        margin: 0;
        padding-left: 1.15rem;
        color: rgba(225, 233, 252, 0.82);
    }

    .paymentStatusPanel li + li {
        margin-top: 0.55rem;
    }

    .paymentStatusActions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2.3rem;
    }

    .paymentStatusBtn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 220px;
        padding: 0.95rem 1.5rem;
        border-radius: 999px;
        text-decoration: none;
        font-weight: 600;
        transition: transform 0.25s ease, box-shadow 0.25s ease, background 0.25s ease;
    }

    .paymentStatusBtnPrimary {
        background: #3882fa;
        color: #fff;
        box-shadow: 0 14px 30px rgba(56, 130, 250, 0.28);
    }

    .paymentStatusBtnSecondary {
        background: rgba(255, 255, 255, 0.08);
        border: 1px solid rgba(255, 255, 255, 0.14);
        color: #fff;
    }

    .paymentStatusBtn:hover {
        transform: translateY(-2px);
        color: #fff;
    }

    .paymentStatusBtnPrimary:hover {
        background: #4a90ff;
        box-shadow: 0 18px 34px rgba(56, 130, 250, 0.32);
    }

    .paymentStatusBtnSecondary:hover {
        background: rgba(255, 255, 255, 0.13);
    }

    @media (max-width: 991px) {
        .menu_container {
            height: 74px;
        }

        .paymentStatusSection {
            padding: 8rem 0 5rem;
        }

        .paymentStatusCard {
            padding: 2.2rem;
            border-radius: 26px;
        }
    }

    @media (max-width: 575px) {
        .paymentStatusSection {
            padding: 7.4rem 0 4rem;
        }

        .paymentStatusCard {
            padding: 1.5rem;
            border-radius: 22px;
        }

        .paymentStatusLead {
            font-size: 1rem;
        }

        .paymentStatusBtn {
            width: 100%;
            min-width: 0;
        }
    }
</style>
@endsection

@section('content')
<section class="gradientBg paymentStatusSection">
    <div class="container">
        <div class="paymentStatusWrap">
            <div class="paymentStatusCard text-center">
                <div class="paymentStatusInner">
                    <div class="paymentStatusBadge">
                        <span class="paymentStatusDot"></span>
                        Checkout Cancelled
                    </div>

                    <div class="paymentStatusHero">
                        <h1>Your contributor payment was not completed</h1>
                        <p class="paymentStatusLead">
                            No contributor account was activated, and no publishing access was created. You can return to the contributor plans page and restart checkout whenever you are ready.
                        </p>
                    </div>

                    <div class="paymentStatusPanel">
                        <h3>Before trying again</h3>
                        <ul>
                            <li>Choose the contributor plan that matches the visibility you want for your future posts.</li>
                            <li>Use the same email address if you want your payment and account setup to stay in one place.</li>
                            <li>Once payment succeeds, we will send your password setup link right away.</li>
                        </ul>
                    </div>

                    <div class="paymentStatusActions">
                        <a href="{{ route('contributor.register') }}" class="paymentStatusBtn paymentStatusBtnPrimary">Back to Contributor Plans</a>
                        <a href="{{ route('contributors.index') }}" class="paymentStatusBtn paymentStatusBtnSecondary">View Contributors Blog</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script>
    (function() {
        function applyPaymentHeaderState() {
            const header = document.getElementById('nav-menu');
            const menuLinks = document.querySelectorAll('.mainColor');
            const menuButton = document.querySelector('.menu_container .menu_btn');

            if (!header) {
                return;
            }

            header.style.backgroundColor = '#ffffff';
            header.style.boxShadow = '0 18px 40px rgba(9, 17, 58, 0.08)';
            header.style.backdropFilter = 'blur(18px)';
            header.style.webkitBackdropFilter = 'blur(18px)';

            menuLinks.forEach((link) => {
                link.style.color = '#16203b';
            });

            if (menuButton) {
                menuButton.style.backgroundColor = '#3882fa';
                menuButton.style.color = '#ffffff';
            }
        }

        document.addEventListener('DOMContentLoaded', applyPaymentHeaderState);
        window.addEventListener('load', applyPaymentHeaderState);
        window.addEventListener('scroll', applyPaymentHeaderState);
    })();
</script>
@endsection
