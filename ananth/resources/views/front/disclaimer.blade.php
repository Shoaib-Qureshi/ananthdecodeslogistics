@extends('layouts.front')
@section('title', 'Disclaimer | Ananth Decodes Logistics')
@section('description', '')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('disclaimer') . '/')

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
                        <h1>Disclaimer</h1>
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
                        <p>The content provided on Ananth Decodes Logistics is for general informational purposes only.
                            While we strive to ensure the accuracy, reliability, and timeliness of the information
                            presented, we make no warranties or representations of any kind, express or implied, regarding
                            the completeness, accuracy, or suitability of the content for any purpose. Any reliance you
                            place on such information is strictly at your own risk.</p>

                        <p>Ananth Decodes Logistics will not be liable for any losses or damages, including indirect or
                            consequential loss, arising from the use of this website or its content. We reserve the right to
                            modify, update, or remove content at any time without prior notice.</p>

                        <p>By using our website, you consent to our Privacy Policy and Disclaimer. If you have any questions
                            or concerns about our policies, please contact us through the information provided on our
                            Contact page.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
