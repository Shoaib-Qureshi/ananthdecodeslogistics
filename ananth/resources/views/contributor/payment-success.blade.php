@extends('layouts.front')
@section('title', 'Contributor Payment Success - Ananth Decodes Logistics')
@section('description', 'Your contributor account payment was received successfully.')
@section('url', route('contributor.payment.success', ['session_id' => request('session_id')]))
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
        max-width: 980px;
        margin: 0 auto;
    }

    .paymentStatusCard {
        position: relative;
        border-radius: 32px;
        padding: 3rem;
        background: linear-gradient(180deg, rgba(10, 16, 63, 0.9) 0%, rgba(14, 23, 88, 0.96) 100%);
        border: 1px solid rgba(255, 255, 255, 0.12);
        box-shadow: 0 32px 80px rgba(6, 10, 38, 0.35);
        color: #fff;
        overflow: hidden;
    }

    .paymentStatusCard::before,
    .paymentStatusCard::after {
        content: "";
        position: absolute;
        border-radius: 999px;
        filter: blur(10px);
        pointer-events: none;
    }

    .paymentStatusCard::before {
        width: 220px;
        height: 220px;
        right: -50px;
        top: -80px;
        background: radial-gradient(circle, rgba(56, 130, 250, 0.42) 0%, rgba(56, 130, 250, 0) 72%);
    }

    .paymentStatusCard::after {
        width: 260px;
        height: 260px;
        left: -90px;
        bottom: -120px;
        background: radial-gradient(circle, rgba(110, 163, 255, 0.18) 0%, rgba(110, 163, 255, 0) 74%);
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
        letter-spacing: 0.02em;
    }

    .paymentStatusDot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #57e389;
        box-shadow: 0 0 0 6px rgba(87, 227, 137, 0.14);
    }

    .paymentPlanPill {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-top: 1.5rem;
        padding: 0.7rem 1rem;
        border-radius: 999px;
        background: rgba(56, 130, 250, 0.16);
        border: 1px solid rgba(123, 175, 255, 0.28);
        color: #cfe1ff;
        font-size: 0.92rem;
        font-weight: 600;
    }

    .paymentStatusHero h1 {
        margin: 1.2rem 0 1rem;
        color: #fff;
        font-size: clamp(2.4rem, 5vw, 4.25rem);
        line-height: 1.05;
        letter-spacing: -0.03em;
    }

    .paymentStatusLead {
        max-width: 760px;
        margin: 0 auto;
        color: rgba(234, 240, 255, 0.86);
        font-size: 1.2rem;
        line-height: 1.75;
    }

    .paymentStatusLead strong {
        color: #fff;
    }

    .paymentStatusGrid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 1rem;
        margin-top: 2.5rem;
    }

    .paymentStatusItem {
        padding: 1.25rem;
        border-radius: 24px;
        background: rgba(255, 255, 255, 0.06);
        border: 1px solid rgba(255, 255, 255, 0.1);
        text-align: left;
        min-height: 100%;
    }

    .paymentStatusItem span {
        display: inline-block;
        margin-bottom: 0.7rem;
        color: #9ec1ff;
        font-size: 0.84rem;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
    }

    .paymentStatusItem h3 {
        margin-bottom: 0.55rem;
        color: #fff;
        font-size: 1.12rem;
    }

    .paymentStatusItem p {
        margin-bottom: 0;
        color: rgba(225, 233, 252, 0.82);
        font-size: 0.98rem;
        line-height: 1.7;
    }

    .paymentStatusActions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2.4rem;
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

        .paymentStatusGrid {
            grid-template-columns: 1fr;
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
            font-size: 1.02rem;
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
                        Payment Confirmed
                    </div>

                    <div class="paymentPlanPill">
                        {{ $payment->plan === 'paid_featured' ? 'Featured Contributor Plan • $100' : 'Standard Contributor Plan • $50' }}
                    </div>

                    <div class="paymentStatusHero">
                        <h1>Your contributor access is ready</h1>
                        <p class="paymentStatusLead">
                            Your plan has been activated successfully. We have sent a password setup email to
                            <strong>{{ $payment->email }}</strong> so you can sign in, access your contributor dashboard,
                            and begin submitting posts.
                        </p>
                    </div>

                    <div class="paymentStatusGrid">
                        <div class="paymentStatusItem">
                            <span>Step 1</span>
                            <h3>Check your inbox</h3>
                            <p>Open the password setup email we sent and finish creating your contributor login credentials.</p>
                        </div>
                        <div class="paymentStatusItem">
                            <span>Step 2</span>
                            <h3>Access your dashboard</h3>
                            <p>Sign in to manage your profile and submit your first contributor article for review.</p>
                        </div>
                        <div class="paymentStatusItem">
                            <span>Step 3</span>
                            <h3>Start publishing</h3>
                            <p>
                                {{ $payment->plan === 'paid_featured'
                                    ? 'Your account is eligible for featured contributor placement once approved posts go live.'
                                    : 'Your published posts will appear in the contributor blog once they are reviewed and approved.' }}
                            </p>
                        </div>
                    </div>

                    <div class="paymentStatusActions">
                        <a href="{{ route('contributor.login') }}" class="paymentStatusBtn paymentStatusBtnPrimary">Go to Contributor Login</a>
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
