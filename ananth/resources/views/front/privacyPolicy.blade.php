@extends('layouts.front')
@section('title', 'Privacy Policy | Ananth Decodes Logistics')
@section('description', '')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('privacy-policy') . '/')

@section('content')
    <style>
        header {
            position: sticky;
            top: 0;
            background-color: var(--white) !important;
        }
    </style>
    <section class="gradientBg bothPadding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 m-auto">
                    <div class="headingMain text-center">
                        <h1>Privacy Policy</h1>
                        <p>Last Updated: 15 Jun, 2025</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bothPadding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 m-auto">
                    <div class="mainContent">
                        <p>At Ananth Decodes Logistics, accessible from <a
                                href="https://www.ananthdecodeslogistics.com/">www.ananthdecodeslogistics.com</a>, we are
                            committed to
                            safeguarding your privacy. Any personal information collected through our website—such as your
                            name, email address, or contact details submitted via forms—is used solely to provide you with
                            relevant information, respond to your inquiries, or improve our services. We do not sell, trade,
                            or otherwise transfer your information to outside parties, except when required by law or to
                            protect our rights.</p>

                        <p>Our website may use cookies to enhance your browsing experience. These cookies help us understand
                            user preferences and improve our content. You have the option to disable cookies through your
                            browser settings, though this may affect your ability to use certain features of our site.</p>

                        <p>We may include links to third-party websites for your convenience and information. Please be
                            aware that these sites have their own privacy policies, and we do not accept responsibility or
                            liability for their content or practices.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
