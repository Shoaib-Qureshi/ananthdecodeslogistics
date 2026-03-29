@extends('layouts.front')
@section('title', 'Contribute a Guest Post | AnanthDecodesLogistics')
@section('description', 'Are you passionate about logistics, supply chain management, transportation, or warehousing? If yes, we invite you to contribute to Ananth Decodes Logistics!')
@section('img', asset('img/site-banner.jpg'))
@section('url', asset('write-for-us') . '/')

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
                        <p>Interested in writing for us?</p>
                        <h1>Contribute a Guest Post</h1>
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
                        <p>Are you passionate about logistics, supply chain management, transportation, or warehousing? Do
                            you have insights, experiences, or tips that can help others in the industry? If yes, we invite
                            you to contribute to Ananth Decodes Logistics!</p>

                        <h3>Why Write for Us?</h3>
                        <p>Ananth Decodes Logistics is a growing platform focused on simplifying logistics and supply chain
                            concepts for professionals, students, and businesses. By writing for us, you get to:</p>

                        <ul>
                            <li>Share your knowledge with a wider audience</li>
                            <li>Build your personal brand and online presence</li>
                            <li>Get featured on our blog with full author credit</li>
                            <li>Contribute to the logistics and supply chain community</li>
                        </ul>

                        <h3>What We’re Looking For</h3>
                        <p>We accept original, informative, and engaging articles on topics such as:</p>

                        <ul>
                            <li>Logistics trends and innovations</li>
                            <li>Supply chain strategies</li>
                            <li>Warehouse management</li>
                            <li>Transportation and last-mile delivery</li>
                            <li>Freight forwarding and shipping</li>
                            <li>Case studies and industry insights</li>
                            <li>Career tips in logistics</li>
                            <li>Tech in logistics (AI, IoT, etc.)</li>
                        </ul>

                        <h3>Ready to Contribute?</h3>
                        <p>Start by emailing us your article pitch or draft today at
                            <strong>jana.ananthakrishnan@gmail.com</strong>.
                        </p>

                        <h3>Or just fill out the query form below!</h3>
                        <div class="contactForm mb-4">
                            @if (count($errors) > 0)
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
                            <form action="{{ route('saveContact') }}" method="POST">
                                @csrf
                                <input value="{{ old('name') }}" type="text" name="name" placeholder="Name">
                                <input value="{{ old('email') }}" type="email" name="email" placeholder="Email"
                                    required>
                                <input value="{{ old('subject') }}" type="text" name="subject" placeholder="Subject"
                                    required>
                                <textarea name="message" placeholder="Type your message..." required>{{ old('message') }}</textarea>
                                <button type="submit" class="siteBtn">Submit</button>
                            </form>
                        </div>

                        <p>We’re excited
                            to collaborate with industry experts, professionals, and enthusiasts like you.</p>

                        <p><strong>Let’s decode logistics together — one article at a time!</strong></p>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
