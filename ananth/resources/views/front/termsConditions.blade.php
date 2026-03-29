@extends('layouts.front')
@section('title', 'Terms & Conditions | Ananth Decodes Logistics')
@section('description', '')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('terms-and-conditions') . '/')

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
                        <h1>Terms & Conditions</h1>
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
                        <p>Welcome to Ananth Decodes Logistics. By accessing or using our website at
                            <a href="https://www.ananthdecodeslogistics.com/">www.ananthdecodeslogistics.com</a>, you agree
                            to comply with and be bound by the following Terms and
                            Conditions. Please read them carefully before using our website or services.
                        </p>

                        <h3>1. Use of the Website</h3>
                        <p>You agree to use this website only for lawful purposes and in a manner that does not infringe the
                            rights or restrict the use and enjoyment of this site by any third party. You must not use the
                            site to engage in any conduct that is unlawful, harmful, threatening, abusive, defamatory, or
                            otherwise objectionable.</p>

                        <h3>2. Intellectual Property</h3>

                        <h3>3. User Submissions</h3>
                        <p>If you submit any information or material to us via forms, email, or other means, you grant
                            Ananth Decodes Logistics the right to use such submissions for the purpose of responding to your
                            queries or improving our services. You are responsible for ensuring that any material you submit
                            does not violate any law or infringe on the rights of third parties.</p>
                        <h3>4. Limitation of Liability</h3>
                        <p>Ananth Decodes Logistics shall not be liable for any direct, indirect, incidental, or
                            consequential damages arising out of your access to or use of this website. Your use of the site
                            and any reliance on its content is at your own risk.</p>
                        <h3>5. External Links</h3>
                        <p>Our website may contain links to third-party websites. These links are provided for convenience
                            only, and we do not endorse or assume any responsibility for the content, policies, or practices
                            of these external sites.</p>
                        <h3>6. Modifications to Terms</h3>
                        <p>We reserve the right to update or change these Terms and Conditions at any time without prior
                            notice. Continued use of the site after changes are posted constitutes your acceptance of the
                            revised terms.</p>
                        <h3>7. Governing Law</h3>
                        <p>These Terms and Conditions are governed by and construed in accordance with the laws of [Insert
                            Jurisdiction, e.g., the Republic of India], and any disputes relating to these terms shall be
                            subject to the exclusive jurisdiction of the courts located in [Insert Location].</p>
                        <h3>8. Contact Information</h3>
                        <p>If you have any questions about these Terms and Conditions, please contact us through the details
                            provided on our <a href="/contact-us/">contact page</a>.</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
