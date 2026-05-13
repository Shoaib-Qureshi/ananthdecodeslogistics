@extends('layouts.front')
@section('title', 'Something went wrong')
@section('description', 'Something went wrong')
@section('img', asset('img/site-banner.jpg'))
@section('url', url()->current())

@section('content')
    <style>
        header {
            position: sticky;
            top: 0;
            background-color: var(--white) !important;
            box-shadow: rgba(0, 0, 0, 0.25) 0px 0px 5px 0px !important;
        }
    </style>
    <section class="bothPadding">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 m-auto">
                    <div class="headingMain text-center">
                        <h1 style="color:#333333;">Something went wrong</h1>
                        <p style="color:#333333;">Please try again in a moment.</p>
                        <a href="/"><button class="mt-4 siteBtn">Go To Homepage</button></a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

