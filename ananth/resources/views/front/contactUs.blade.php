@extends('layouts.front')
@section('title', 'Contact Us | Ananth Decodes Logistics')
@section('description', '')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('contact-us') . '/')

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
                        <h1>Contact Us</h1>
                        <p>Write us at <strong><a
                                    href="mailto:connect@ananthdecodeslogistics.com">connect@ananthdecodeslogistics.com</a></strong>
                            or fill the query form below!</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="bothPadding">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 m-auto">
                    <div class="contactForm contactPageForm">
                        @if ($errors->any())
                            <div class="alert_message">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session()->has('message'))
                            <div class="success_message">
                                {{ session()->get('message') }}
                            </div>
                        @endif

                        <h3>Fill the form below!</h3>
                        <form action="{{ route('saveContact') }}" method="POST" id="contactForm">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <h4>Name*</h4>
                                    <input type="text" name="name" placeholder="Name *" value="{{ old('name') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <h4>Email*</h4>
                                    <input type="email" name="email" placeholder="Email *" value="{{ old('email') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <h4>Phone Number</h4>
                                    <input type="tel" name="phone" placeholder="Phone Number" value="{{ old('phone') }}" pattern="[0-9+()\\-\\s]*">
                                </div>
                            </div>

                            <h4>Message</h4>
                            <textarea name="message" placeholder="Type your message here..." required>{{ old('message') }}</textarea>

                            <!-- Submit Button -->
                            <button type="submit" class="siteBtn">Get in Touch</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
@endsection
