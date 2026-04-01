@extends('layouts.front')
@section('title', 'Contribute a Guest Post — Ananth Decodes Logistics')
@section('description', 'Are you passionate about logistics, supply chain management, transportation, or warehousing? We invite you to contribute to Ananth Decodes Logistics.')
@section('url', url('write-for-us'))
@section('img', asset('img/site-banner.jpg'))

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    header { position: sticky; top: 0; background-color: var(--white) !important; }
    .wfu-benefit {
        display: flex;
        align-items: flex-start;
        gap: 1rem;
        padding: 1rem 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .wfu-benefit:last-child { border-bottom: none; }
    .wfu-benefit-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        background: #eff4ff;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .wfu-benefit-icon svg { width: 20px; height: 20px; color: #3882fa; fill: currentColor; }
    .wfu-benefit h6 { font-size: .9rem; font-weight: 600; color: #181a3f; margin-bottom: .25rem; }
    .wfu-benefit p  { font-size: .83rem; color: #636363; margin: 0; line-height: 1.5; }
    .form-card {
        background: #fff;
        border-radius: 16px;
        padding: 2.25rem 2.5rem;
        box-shadow: 0 4px 24px rgba(0,0,0,0.07);
        border: 1px solid #e8edf5;
    }
    .form-control, .form-select {
        border-radius: 8px;
        padding: .6rem 1rem;
        border: 1.5px solid #e2e8f0;
        font-size: .9rem;
        transition: border-color .15s, box-shadow .15s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #3882fa;
        box-shadow: 0 0 0 3px rgba(56,130,250,.12);
    }
    .form-label { font-weight: 600; font-size: .875rem; color: #181a3f; margin-bottom: .4rem; }
    .btn-submit {
        background: #3882fa;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: .7rem 2rem;
        font-weight: 600;
        font-size: .95rem;
        width: 100%;
        cursor: pointer;
        transition: background .2s, transform .1s;
        display: flex; align-items: center; justify-content: center; gap: .5rem;
    }
    .btn-submit:hover { background: #2563d4; }
    .btn-submit:active { transform: scale(.99); }
    .alert-success-custom {
        background: #f0fdf4;
        border: 1px solid #bbf7d0;
        border-left: 4px solid #22c55e;
        border-radius: 10px;
        padding: 1rem 1.25rem;
        font-size: .9rem;
        color: #166534;
    }
    .alert-danger-custom {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-left: 4px solid #ef4444;
        border-radius: 10px;
        padding: 1rem 1.25rem;
        font-size: .9rem;
        color: #991b1b;
    }
    .invalid-feedback { font-size: .8rem; }
    .section-divider {
        height: 1px;
        background: linear-gradient(to right, transparent, #e2e8f0, transparent);
        margin: 2.5rem 0;
    }
    .plan-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
    }
    .plan-card {
        position: relative;
        border: 1.5px solid #dbe7f6;
        border-radius: 14px;
        padding: 1.15rem;
        background: #f8fbff;
        cursor: pointer;
        transition: border-color .18s, box-shadow .18s, transform .18s;
    }
    .plan-card:hover {
        border-color: #93c5fd;
        transform: translateY(-2px);
    }
    .plan-card input {
        position: absolute;
        opacity: 0;
        inset: 0;
        cursor: pointer;
    }
    .plan-card.is-selected {
        border-color: #3882fa;
        box-shadow: 0 0 0 3px rgba(56,130,250,.12);
        background: #eff6ff;
    }
    .plan-card strong {
        display: block;
        color: #181a3f;
        font-size: .98rem;
        margin-bottom: .35rem;
    }
    .plan-card .price {
        display: block;
        color: #3882fa;
        font-size: 1.4rem;
        font-weight: 700;
        margin-bottom: .5rem;
    }
    .plan-card p {
        font-size: .82rem;
        color: #64748b;
        margin: 0;
        line-height: 1.6;
    }
    @media(max-width: 768px) {
        .form-card { padding: 1.5rem; }
        .plan-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<section class="gradientBg bothPadding">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8 mx-auto">
                <div class="headingMain text-center">
                    <p>Interested in writing for us?</p>
                    <h1>Contribute a Guest Post</h1>
                    <p style="max-width:560px;margin:1rem auto 0;opacity:.85;">
                        Share your logistics and supply chain expertise with a wider audience through Ananth Decodes Logistics.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="bothPadding" style="background:#f8f9fc;">
    <div class="container">
        <div class="row justify-content-center g-5">

            <div class="col-lg-4">
                <h5 style="font-weight:700;color:#181a3f;margin-bottom:1.5rem;">Why Write For Us?</h5>

                <div class="wfu-benefit">
                    <div class="wfu-benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 14.5v-9l6 4.5-6 4.5z"/></svg>
                    </div>
                    <div>
                        <h6>Share your knowledge with a wider audience</h6>
                        <p>Reach logistics professionals, students, and businesses looking for practical insights.</p>
                    </div>
                </div>

                <div class="wfu-benefit">
                    <div class="wfu-benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 12c2.7 0 4.8-2.1 4.8-4.8S14.7 2.4 12 2.4 7.2 4.5 7.2 7.2 9.3 12 12 12zm0 2.4c-3.2 0-9.6 1.6-9.6 4.8v2.4h19.2v-2.4c0-3.2-6.4-4.8-9.6-4.8z"/></svg>
                    </div>
                    <div>
                        <h6>Build your personal brand</h6>
                        <p>Get featured on our platform with full author credit and a stronger online presence.</p>
                    </div>
                </div>

                <div class="wfu-benefit">
                    <div class="wfu-benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/></svg>
                    </div>
                    <div>
                        <h6>Contribute to the logistics community</h6>
                        <p>Help simplify transport and supply chain knowledge for readers across the industry.</p>
                    </div>
                </div>

                <div class="wfu-benefit">
                    <div class="wfu-benefit-icon">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    </div>
                    <div>
                        <h6>Establish thought leadership</h6>
                        <p>Share original ideas, real-world experience, and practical guidance in your domain.</p>
                    </div>
                </div>

                <div class="section-divider"></div>

                <div style="background:#eff4ff;border-radius:12px;padding:1.25rem;">
                    <p style="font-size:.83rem;color:#2563d4;font-weight:600;margin-bottom:.5rem;">What we're looking for</p>
                    <p style="font-size:.82rem;color:#475569;line-height:1.7;margin:0;">
                        Logistics trends &amp; innovations · Supply chain strategies · Warehouse management · Transportation &amp; last-mile delivery · Freight forwarding &amp; shipping · Career tips · AI &amp; IoT in logistics
                    </p>
                </div>
            </div>

            <div class="col-lg-7">

                @if(session('success'))
                    <div class="alert-success-custom mb-4">
                        <strong>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right:.4rem;vertical-align:-.15em"><path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/></svg>
                            Application Received!
                        </strong><br>
                        <span style="font-weight:400;">{{ session('success') }}</span>
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert-danger-custom mb-4">
                        <ul class="mb-0 ps-3">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                    </div>
                @endif

                <div class="form-card">
                    <h5 style="font-weight:700;color:#181a3f;margin-bottom:.4rem;">Ready to Contribute?</h5>
                    <p style="font-size:.875rem;color:#636363;margin-bottom:1.75rem;">Choose a contributor plan, then fill in your details. Paid plans activate your contributor account after successful payment.</p>

                    <form method="POST" action="{{ route('contributor.register.submit') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="form-label">Choose Your Contributor Plan <span class="text-danger">*</span></label>
                            <div class="plan-grid" id="planGrid">
                                <label class="plan-card {{ old('plan', 'paid_standard') === 'paid_standard' ? 'is-selected' : '' }}">
                                    <input type="radio" name="plan" value="paid_standard" {{ old('plan', 'paid_standard') === 'paid_standard' ? 'checked' : '' }}>
                                    <strong>Paid Contributor</strong>
                                    <span class="price">$50</span>
                                    <p>One-time payment. Your contributor account is activated after Stripe payment so you can start posting.</p>
                                </label>
                                <label class="plan-card {{ old('plan') === 'paid_featured' ? 'is-selected' : '' }}">
                                    <input type="radio" name="plan" value="paid_featured" {{ old('plan') === 'paid_featured' ? 'checked' : '' }}>
                                    <strong>Featured Contributor</strong>
                                    <span class="price">$100</span>
                                    <p>One-time payment. Includes contributor access plus homepage featured placement for eligible contributor posts.</p>
                                </label>
                            </div>
                            @error('plan')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}" placeholder="Your full name" required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label class="form-label">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email') }}" placeholder="you@example.com" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Designation / Role <span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="form-control @error('designation') is-invalid @enderror"
                                   value="{{ old('designation') }}" placeholder="e.g. Logistics Manager, Supply Chain Analyst" required>
                            @error('designation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Short Bio <span class="text-danger">*</span></label>
                            <textarea name="intro" rows="3" class="form-control @error('intro') is-invalid @enderror"
                                      placeholder="Brief background on your experience and expertise (max 1000 chars)" required>{{ old('intro') }}</textarea>
                            @error('intro')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Why do you want to contribute? <span class="text-danger">*</span></label>
                            <textarea name="reason_for_joining" rows="4" class="form-control @error('reason_for_joining') is-invalid @enderror"
                                      placeholder="Tell us what topics you want to write about and the value you'll bring to our readers." required>{{ old('reason_for_joining') }}</textarea>
                            @error('reason_for_joining')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn-submit" id="planSubmitBtn">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16"><path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11z"/></svg>
                            <span>Submit Application</span>
                        </button>
                    </form>
                </div>

                <div class="mt-4 text-center" style="font-size:.875rem;color:#636363;">
                    Already a contributor?
                    <a href="{{ route('contributor.login') }}" style="color:#3882fa;font-weight:600;">Sign in to your dashboard →</a>
                </div>

            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    const planCards = document.querySelectorAll('.plan-card');
    const submitLabel = document.querySelector('#planSubmitBtn span');

    function syncPlanCards() {
        let selectedPlan = 'paid_standard';
        planCards.forEach(card => {
            const input = card.querySelector('input[type="radio"]');
            const isSelected = input.checked;
            card.classList.toggle('is-selected', isSelected);
            if (isSelected) {
                selectedPlan = input.value;
            }
        });

        submitLabel.textContent = 'Continue to Payment';
    }

    planCards.forEach(card => {
        card.addEventListener('click', function () {
            const input = this.querySelector('input[type="radio"]');
            input.checked = true;
            syncPlanCards();
        });
    });

    syncPlanCards();
</script>
@endsection
