@extends('layouts.front')
@section('title', 'Complete Your Expert Desk Payment - Ananth Decodes Logistics')
@section('description', 'Complete your Expert Desk application securely with Razorpay.')
@section('url', route('contributor.register'))
@section('img', asset('img/site-banner.jpg'))

@section('styles')
<style>
    #nav-menu {
        background: rgba(255, 255, 255, 0.96);
        box-shadow: 0 18px 40px rgba(9, 17, 58, 0.08);
        backdrop-filter: blur(18px);
        -webkit-backdrop-filter: blur(18px);
    }
    .menu_container { height: 82px; }
    .menu_container a,
    .menu_container .menu-bar .nav-link,
    .menu_container #hamburger { color: #16203b !important; }
    .menu_container .logo img { width: 235px; }
    .checkoutSection {
        padding: 9rem 0 6rem;
        background: linear-gradient(180deg, #f8fbff 0%, #eef5ff 100%);
        min-height: 100vh;
    }
    .checkoutCard {
        max-width: 880px;
        margin: 0 auto;
        padding: 3rem;
        border-radius: 32px;
        background: #fff;
        border: 1px solid #dbeafe;
        box-shadow: 0 30px 70px rgba(15, 23, 42, 0.08);
        text-align: center;
    }
    .checkoutBadge {
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        padding: 0.75rem 1rem;
        border-radius: 999px;
        background: rgba(56, 130, 250, 0.1);
        color: #1d4ed8;
        font-size: 0.9rem;
        font-weight: 700;
    }
    .checkoutBadgeDot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: #3882fa;
        box-shadow: 0 0 0 6px rgba(56, 130, 250, 0.12);
    }
    .checkoutCard h1 {
        margin: 1.25rem 0 0.85rem;
        font-size: clamp(2.2rem, 4vw, 3.6rem);
        line-height: 1.08;
        color: #0f172a;
        letter-spacing: -0.03em;
    }
    .checkoutCard p {
        margin: 0 auto;
        max-width: 640px;
        color: #475569;
        font-size: 1rem;
        line-height: 1.8;
    }
    .checkoutPlan {
        margin: 2rem auto 0;
        max-width: 460px;
        padding: 1.25rem 1.35rem;
        border-radius: 22px;
        background: #f8fbff;
        border: 1px solid #dbeafe;
        text-align: left;
    }
    .checkoutPlan span {
        display: block;
        font-size: 0.78rem;
        font-weight: 800;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        margin-bottom: 0.45rem;
    }
    .checkoutPlan strong {
        display: block;
        font-size: 1.1rem;
        color: #0f172a;
        margin-bottom: 0.3rem;
    }
    .checkoutPlan small {
        color: #64748b;
        font-size: 0.92rem;
        line-height: 1.7;
    }
    .checkoutActions {
        display: flex;
        justify-content: center;
        gap: 1rem;
        flex-wrap: wrap;
        margin-top: 2rem;
    }
    .checkoutBtn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 220px;
        padding: 0.95rem 1.4rem;
        border-radius: 999px;
        font-size: 0.95rem;
        font-weight: 700;
        text-decoration: none;
        border: none;
        cursor: pointer;
        transition: transform 0.2s ease, box-shadow 0.2s ease, background 0.2s ease;
    }
    .checkoutBtnPrimary {
        background: #3882fa;
        color: #fff;
        box-shadow: 0 16px 32px rgba(56, 130, 250, 0.24);
    }
    .checkoutBtnSecondary {
        background: #fff;
        color: #334155;
        border: 1px solid #cbd5e1;
    }
    .checkoutBtn:hover {
        transform: translateY(-2px);
    }
    .checkoutBtnPrimary:hover {
        background: #1d4ed8;
        color: #fff;
    }
    .checkoutBtnSecondary:hover {
        color: #0f172a;
        background: #f8fafc;
    }
    .checkoutNote {
        margin-top: 1.2rem !important;
        font-size: 0.86rem !important;
        color: #64748b !important;
    }
    @media (max-width: 991px) {
        .menu_container { height: 74px; }
        .checkoutSection { padding: 8rem 0 5rem; }
        .checkoutCard {
            padding: 2.2rem;
            border-radius: 26px;
        }
    }
    @media (max-width: 575px) {
        .checkoutSection { padding: 7.2rem 0 4rem; }
        .checkoutCard {
            padding: 1.5rem;
            border-radius: 22px;
        }
        .checkoutBtn {
            width: 100%;
            min-width: 0;
        }
    }
</style>
@endsection

@section('content')
<section class="checkoutSection">
    <div class="container">
        <div class="checkoutCard">
            <div class="checkoutBadge">
                <span class="checkoutBadgeDot"></span>
                Razorpay Checkout Ready
            </div>

            <h1>Complete your Expert Desk payment</h1>
            <p>
                Your application has been saved. We are opening Razorpay so you can complete payment securely and activate your contributor access right away.
            </p>

            <div class="checkoutPlan">
                <span>Selected plan</span>
                <strong>{{ $plan['name'] }} · {{ $plan['price_label'] }}</strong>
                <small>{{ $plan['summary'] }}</small>
            </div>

            <div class="checkoutActions">
                <button type="button" class="checkoutBtn checkoutBtnPrimary" id="openRazorpayCheckout">Open Razorpay Checkout</button>
                <a href="{{ route('contributor.payment.cancel', ['payment' => $payment->id]) }}" class="checkoutBtn checkoutBtnSecondary">Cancel Payment</a>
            </div>

            <p class="checkoutNote">If Razorpay does not open automatically, use the button above.</p>
        </div>
    </div>
</section>

<form method="POST" action="{{ route('contributor.payment.verify') }}" id="razorpayVerifyForm" style="display:none;">
    @csrf
    <input type="hidden" name="payment" value="{{ $payment->id }}">
    <input type="hidden" name="razorpay_payment_id" id="razorpay_payment_id">
    <input type="hidden" name="razorpay_order_id" id="razorpay_order_id">
    <input type="hidden" name="razorpay_signature" id="razorpay_signature">
</form>
@endsection

@section('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    (function () {
        function applyCheckoutHeaderState() {
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

            menuLinks.forEach(function (link) {
                link.style.color = '#16203b';
            });

            if (menuButton) {
                menuButton.style.backgroundColor = '#3882fa';
                menuButton.style.color = '#ffffff';
            }
        }

        applyCheckoutHeaderState();
        document.addEventListener('DOMContentLoaded', applyCheckoutHeaderState);
        window.addEventListener('load', applyCheckoutHeaderState);
        window.addEventListener('scroll', applyCheckoutHeaderState);

        var verifyForm = document.getElementById('razorpayVerifyForm');
        var openButton = document.getElementById('openRazorpayCheckout');
        var cancelUrl = @json(route('contributor.payment.cancel', ['payment' => $payment->id]));
        var submitted = false;
        var options = @json($checkout);

        options.handler = function (response) {
            submitted = true;
            document.getElementById('razorpay_payment_id').value = response.razorpay_payment_id || '';
            document.getElementById('razorpay_order_id').value = response.razorpay_order_id || '';
            document.getElementById('razorpay_signature').value = response.razorpay_signature || '';
            verifyForm.submit();
        };

        options.modal = {
            confirm_close: true,
            ondismiss: function () {
                if (!submitted) {
                    window.location.href = cancelUrl;
                }
            }
        };

        var razorpay = new Razorpay(options);

        function openCheckout() {
            razorpay.open();
        }

        if (openButton) {
            openButton.addEventListener('click', function (event) {
                event.preventDefault();
                openCheckout();
            });
        }

        window.setTimeout(openCheckout, 250);
    })();
</script>
@endsection
