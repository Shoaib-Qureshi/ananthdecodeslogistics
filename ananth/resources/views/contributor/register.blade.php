@extends('layouts.front')
@section('title', 'Apply to The Expert Desk - Ananth Decodes Logistics')
@section('description', 'Choose an Expert Desk plan and apply to publish your logistics perspective on Ananth Decodes Logistics.')
@section('url', route('contributor.register'))
@section('img', asset('img/site-banner.jpg'))

@section('styles')
<style>
header{position:sticky;top:0;background:var(--white)!important;z-index:100}

/* Page shell */
.apply-page{min-height:100vh;background:#f8fbff;padding:3rem 0 5rem}

/* Two-column grid */
.apply-grid{display:grid;grid-template-columns:1fr 1fr;gap:3rem;align-items:start}

/* ── Left panel ── */
.info-panel{position:sticky;top:88px}
.info-eyebrow{display:inline-flex;align-items:center;gap:.45rem;padding:.38rem .75rem;background:rgba(37,99,235,.08);color:#1d4ed8;font-size:.72rem;font-weight:800;letter-spacing:.09em;text-transform:uppercase;border-radius:999px;margin-bottom:1.1rem}
.info-title{font-size:clamp(1.7rem,2.5vw,2.4rem);font-weight:800;color:#0f172a;line-height:1.1;letter-spacing:-.03em;margin:0 0 .75rem}
.info-title span{color:#3882fa}
.info-sub{color:#475569;font-size:.95rem;line-height:1.8;margin:0 0 1.8rem}
.info-benefits{list-style:none;padding:0;margin:0 0 2rem;display:grid;gap:.85rem}
.info-benefits li{display:flex;gap:.75rem;align-items:flex-start}
.benefit-icon{width:32px;height:32px;border-radius:10px;background:#eff6ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-top:.1rem}
.benefit-icon svg{color:#3882fa}
.benefit-text strong{display:block;font-size:.9rem;font-weight:700;color:#0f172a;margin-bottom:.15rem}
.benefit-text span{font-size:.84rem;color:#64748b;line-height:1.6}
.info-divider{border:none;border-top:1px solid #e2e8f0;margin:1.5rem 0}
.info-trust{display:grid;grid-template-columns:1fr 1fr;gap:.75rem}
.trust-chip{padding:.7rem .9rem;background:#fff;border:1px solid #dbeafe;border-radius:14px}
.trust-chip strong{display:block;font-size:.78rem;font-weight:800;color:#0f172a;margin-bottom:.2rem}
.trust-chip span{font-size:.74rem;color:#64748b;line-height:1.5}
.info-more{margin-top:1.5rem;font-size:.83rem;color:#64748b}
.info-more a{color:#3882fa;font-weight:700;text-decoration:none}
.info-more a:hover{text-decoration:underline}

/* ── Right panel (form card) ── */
.form-card{background:#fff;border:1px solid #e2e8f0;border-radius:20px;box-shadow:0 20px 48px rgba(15,23,42,.07);padding:2rem}

/* Alerts */
.alert-ok,.alert-err{border-radius:12px;padding:.9rem 1.1rem;font-size:.875rem;margin-bottom:1.25rem}
.alert-ok{background:#f0fdf4;border:1px solid #bbf7d0;border-left:4px solid #22c55e;color:#166534}
.alert-err{background:#fef2f2;border:1px solid #fecaca;border-left:4px solid #ef4444;color:#991b1b}

/* Plan selector rows */
.plan-section-label{font-size:.72rem;font-weight:800;letter-spacing:.09em;text-transform:uppercase;color:#64748b;margin-bottom:.65rem}
.plan-rows{display:grid;gap:.6rem;margin-bottom:.35rem}
.plan-row{position:relative;display:flex;align-items:center;gap:.85rem;padding:.9rem 1rem;border:1.5px solid #e2e8f0;border-radius:14px;cursor:pointer;transition:.16s ease;background:#fff}
.plan-row:hover{border-color:#93c5fd;background:#f8fbff}
.plan-row.is-selected{border-color:#3882fa;background:#eff6ff;box-shadow:0 0 0 3px rgba(37,99,235,.1)}
.plan-row input[type="radio"]{position:absolute;opacity:0;pointer-events:none}
.plan-radio{width:18px;height:18px;border-radius:50%;border:2px solid #cbd5e1;flex-shrink:0;display:flex;align-items:center;justify-content:center;transition:.16s}
.plan-row.is-selected .plan-radio{border-color:#3882fa;background:#3882fa}
.plan-row.is-selected .plan-radio::after{content:'';width:6px;height:6px;border-radius:50%;background:#fff}
.plan-row-body{flex:1;min-width:0}
.plan-row-top{display:flex;align-items:center;gap:.5rem;flex-wrap:wrap}
.plan-row-name{font-size:.9rem;font-weight:700;color:#0f172a}
.plan-row-popular{display:inline-flex;align-items:center;padding:.18rem .52rem;background:#3882fa;color:#fff;font-size:.66rem;font-weight:800;letter-spacing:.07em;text-transform:uppercase;border-radius:999px}
.plan-row-tags{display:flex;gap:.4rem;flex-wrap:wrap;margin-top:.3rem}
.plan-row-tag{display:inline-flex;align-items:center;padding:.22rem .55rem;background:#f1f5f9;color:#475569;font-size:.74rem;border-radius:999px}
.plan-row-price{font-size:1.15rem;font-weight:800;color:#0f172a;flex-shrink:0}
.plan-row-price small{font-size:.72rem;font-weight:600;color:#94a3b8;margin-left:.2rem}

/* Tooltip */
.plan-info-btn{width:22px;height:22px;border-radius:50%;border:1.5px solid #cbd5e1;background:#fff;display:flex;align-items:center;justify-content:center;cursor:pointer;flex-shrink:0;position:relative;color:#94a3b8;transition:.15s}
.plan-info-btn:hover{border-color:#3882fa;color:#3882fa}
.plan-tooltip{position:absolute;right:0;top:calc(100% + 8px);width:230px;background:#0f172a;color:#e2e8f0;font-size:.78rem;line-height:1.6;padding:.85rem 1rem;border-radius:12px;box-shadow:0 16px 32px rgba(0,0,0,.2);z-index:200;display:none;pointer-events:none}
.plan-tooltip::before{content:'';position:absolute;top:-6px;right:8px;border-left:6px solid transparent;border-right:6px solid transparent;border-bottom:6px solid #0f172a}
.plan-info-btn:hover .plan-tooltip,.plan-info-btn:focus .plan-tooltip{display:block}
.plan-tooltip ul{list-style:none;padding:0;margin:.45rem 0 0;display:grid;gap:.3rem}
.plan-tooltip ul li::before{content:'· ';color:#60a5fa}
.tooltip-head{font-weight:700;color:#fff;margin-bottom:.25rem}

/* Form fields */
.field-group{display:grid;gap:1rem;margin-top:1.25rem}
.field-row{display:grid;grid-template-columns:1fr 1fr;gap:1rem}
.field-label{display:block;font-size:.74rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:#64748b;margin-bottom:.4rem}
.field-input{width:100%;border:1.5px solid #e2e8f0;border-radius:12px;padding:.75rem .95rem;font-size:.92rem;color:#0f172a;background:#fff;transition:.15s;outline:none}
.field-input:focus{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1)}
.field-input.is-invalid{border-color:#ef4444}
.field-error{font-size:.78rem;color:#ef4444;margin-top:.3rem}

/* Phone field with country picker */
.phone-field-wrap{display:flex;border:1.5px solid #e2e8f0;border-radius:12px;overflow:visible;transition:.15s;background:#fff;position:relative}
.phone-field-wrap:focus-within{border-color:#3b82f6;box-shadow:0 0 0 3px rgba(59,130,246,.1)}
.phone-field-wrap.is-invalid{border-color:#ef4444}
.country-select{position:relative;flex-shrink:0}
.country-trigger{display:flex;align-items:center;gap:.35rem;padding:.75rem .65rem .75rem .85rem;background:transparent;border:none;border-right:1.5px solid #e2e8f0;cursor:pointer;font-size:.85rem;color:#0f172a;white-space:nowrap;border-radius:0;outline:none;transition:.15s}
.country-trigger:hover{background:#f8fbff}
.country-flag{font-size:1.1rem;line-height:1}
.country-code{font-size:.84rem;font-weight:600;color:#334155}
.country-chevron{color:#94a3b8;transition:transform .2s}
.country-trigger[aria-expanded="true"] .country-chevron{transform:rotate(180deg)}
.country-dropdown{position:absolute;top:calc(100% + 6px);left:0;width:270px;background:#fff;border:1.5px solid #e2e8f0;border-radius:14px;box-shadow:0 16px 40px rgba(15,23,42,.12);z-index:500;overflow:hidden}
.country-search-wrap{padding:.65rem .75rem;border-bottom:1px solid #f1f5f9}
.country-search{width:100%;border:1.5px solid #e2e8f0;border-radius:8px;padding:.5rem .75rem;font-size:.83rem;color:#0f172a;outline:none;background:#f8fbff}
.country-search:focus{border-color:#3b82f6}
.country-list{list-style:none;padding:.35rem 0;margin:0;max-height:220px;overflow-y:auto}
.country-list::-webkit-scrollbar{width:4px}
.country-list::-webkit-scrollbar-thumb{background:#e2e8f0;border-radius:4px}
.country-item{display:flex;align-items:center;gap:.65rem;padding:.5rem .9rem;cursor:pointer;font-size:.84rem;color:#334155;transition:.1s}
.country-item:hover,.country-item.is-active{background:#eff6ff;color:#1d4ed8}
.country-item-flag{font-size:1.05rem;line-height:1;flex-shrink:0}
.country-item-name{flex:1;min-width:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.country-item-dial{font-size:.78rem;color:#94a3b8;flex-shrink:0}
.country-no-results{padding:.75rem .9rem;font-size:.83rem;color:#94a3b8;text-align:center}
.phone-number-input{flex:1;border:none;border-radius:0;padding:.75rem .95rem;font-size:.92rem;color:#0f172a;background:transparent;outline:none;min-width:0}

/* Divider */
.form-divider{border:none;border-top:1px solid #f1f5f9;margin:1.5rem 0}

/* Submit */
.submit-row{display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap;margin-top:1.5rem}
.submit-btn{display:inline-flex;align-items:center;gap:.5rem;background:#3882fa;color:#fff;border:none;border-radius:12px;padding:.85rem 1.5rem;font-size:.92rem;font-weight:800;cursor:pointer;box-shadow:0 10px 24px #168ff938;transition:.16s;text-decoration:none}
.submit-btn:hover{opacity:.88}
.submit-note{font-size:.78rem;color:#94a3b8;line-height:1.6;max-width:220px}
.invalid-feedback{display:block;font-size:.78rem;color:#ef4444;margin-top:.3rem}

@media(max-width:1024px){.apply-grid{grid-template-columns:1fr}.info-panel{position:static}.info-trust{grid-template-columns:1fr 1fr}}
@media(max-width:640px){.field-row{grid-template-columns:1fr}.submit-row{flex-direction:column;align-items:stretch}.submit-btn{justify-content:center}.submit-note{max-width:100%;text-align:center}}
</style>
@endsection

@section('content')
@php
$selectedPlan = old('plan', $defaultPlan);
$popularPlan  = \App\Support\ContributorPlans::GROWTH;
@endphp

<div class="apply-page">
<div class="container">
<div class="apply-grid">

    {{-- ── LEFT: Info panel ── --}}
    <div class="info-panel">
        <div class="info-eyebrow">
            <svg width="12" height="12" viewBox="0 0 16 16" fill="currentColor"><path d="M8 1a7 7 0 1 0 0 14A7 7 0 0 0 8 1zm.93 10.58-.93.93-.93-.93V8.07l-.93-.93.93-.93H8V4.35l.93.93V7.14l.93.93-.93.93v2.58z"/></svg>
            The Expert Desk
        </div>
        <h1 class="info-title">Publish your <span>logistics perspective</span></h1>
        <p class="info-sub">Join a credibility-first contributor platform built for logistics professionals. Every plan gives you an author profile, editorial support, and a defined publishing runway.</p>

        <ul class="info-benefits">
            <li>
                <div class="benefit-icon"><svg width="15" height="15" viewBox="0 0 16 16" fill="currentColor"><path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/></svg></div>
                <div class="benefit-text"><strong>Author presence</strong><span>Published profile with bio, credentials, and full authorship on every article.</span></div>
            </li>
            <li>
                <div class="benefit-icon"><svg width="15" height="15" viewBox="0 0 16 16" fill="currentColor"><path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V4zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2zm13 2.383-4.708 2.825L15 11.105V5.383zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741zM1 11.105l4.708-2.897L1 5.383v5.722z"/></svg></div>
                <div class="benefit-text"><strong>Visibility support</strong><span>Co-branded LinkedIn &amp; X promotion with newsletter eligibility on Growth and above.</span></div>
            </li>
            <li>
                <div class="benefit-icon"><svg width="15" height="15" viewBox="0 0 16 16" fill="currentColor"><path d="M2.5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1h-11zm5 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1h-6zm0 3a.5.5 0 0 0 0 1h6a.5.5 0 0 0 0-1h-6zm-5 3a.5.5 0 0 0 0 1h11a.5.5 0 0 0 0-1h-11zm.79-5.373.549-.274V9.5a.5.5 0 1 0 1 0V6.171l-.851.425a.5.5 0 1 0 .448.894l-.146.073V9.5a.5.5 0 0 0 1 0V7.171l.659-.33a.5.5 0 0 0-.448-.894l-.211.106V6.5a.5.5 0 0 0-1 0v.246l-.549.274a.5.5 0 1 0 .447.895l.102-.051z"/></svg></div>
                <div class="benefit-text"><strong>Editorial review</strong><span>Every submission reviewed for clarity and publishing quality before going live.</span></div>
            </li>
            <li>
                <div class="benefit-icon"><svg width="15" height="15" viewBox="0 0 16 16" fill="currentColor"><path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z"/></svg></div>
                <div class="benefit-text"><strong>Focused audience</strong><span>Reach logistics professionals and supply chain decision-makers who read with intent.</span></div>
            </li>
        </ul>

        <hr class="info-divider">

        <div class="info-trust">
            <div class="trust-chip"><strong>Secure checkout</strong><span>Payment INR · instant activation</span></div>
            <div class="trust-chip"><strong>3 clear plans</strong><span>Defined windows &amp; post caps</span></div>
            <div class="trust-chip"><strong>Keep your posts</strong><span>Profile stays after expiry</span></div>
            <div class="trust-chip"><strong>No hidden fees</strong><span>One payment, full access</span></div>
        </div>

        <p class="info-more">Not sure yet? <a href="{{ route('write-for-us') }}">Read the full Write for Us page</a> for plan comparison and FAQ.</p>
    </div>

    {{-- ── RIGHT: Form panel ── --}}
    <div>
        @if(session('success'))
            <div class="alert-ok"><strong>Application received.</strong> {{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert-err"><ul class="mb-0 ps-3" style="padding-left:1.1rem">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <div class="form-card">
            <form method="POST" action="{{ route('contributor.register.submit') }}" id="apply-form">
                @csrf

                {{-- Plan selector --}}
                <p class="plan-section-label">Choose your plan</p>
                <div class="plan-rows" id="planRows">
                    @foreach($plans as $plan)
                    @php($isPopular = $plan['code'] === $popularPlan)
                    <label class="plan-row {{ $selectedPlan === $plan['code'] ? 'is-selected' : '' }}" data-plan="{{ $plan['code'] }}">
                        <input type="radio" name="plan" value="{{ $plan['code'] }}" {{ $selectedPlan === $plan['code'] ? 'checked' : '' }}>
                        <div class="plan-radio"></div>
                        <div class="plan-row-body">
                            <div class="plan-row-top">
                                <span class="plan-row-name">{{ $plan['name'] }}</span>
                                @if($isPopular)<span class="plan-row-popular">Popular</span>@endif
                            </div>
                            <div class="plan-row-tags">
                                <span class="plan-row-tag">{{ $plan['duration_label'] }}</span>
                                <span class="plan-row-tag">{{ $plan['post_limit_label'] }}</span>
                            </div>
                        </div>
                        <div class="plan-row-price">{{ $plan['price_label'] }}<small>INR</small></div>
                        <div class="plan-info-btn" tabindex="0" role="button" aria-label="Plan details" onclick="event.preventDefault()">
                            <svg width="11" height="11" viewBox="0 0 16 16" fill="currentColor"><path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/><path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533L8.93 6.588zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/></svg>
                            <div class="plan-tooltip">
                                <div class="tooltip-head">{{ $plan['name'] }} · {{ $plan['price_label'] }}</div>
                                <ul>
                                    @foreach($plan['highlights'] as $h)<li>{{ $h }}</li>@endforeach
                                    <li>{{ $plan['summary'] }}</li>
                                </ul>
                            </div>
                        </div>
                    </label>
                    @endforeach
                </div>
                @error('plan')<div class="field-error">{{ $message }}</div>@enderror

                <hr class="form-divider">

                {{-- Form fields --}}
                <div class="field-group">
                    <div class="field-row">
                        <div>
                            <label class="field-label">Full Name <span style="color:#ef4444">*</span></label>
                            <input type="text" name="name" class="field-input @error('name') is-invalid @enderror" value="{{ old('name') }}" placeholder="Your full name" required>
                            @error('name')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label class="field-label">Email Address <span style="color:#ef4444">*</span></label>
                            <input type="email" name="email" class="field-input @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="you@example.com" required>
                            @error('email')<div class="field-error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div>
                        <div class="field-row">
                            <div>
                                <label class="field-label">Designation / Role <span style="color:#ef4444">*</span></label>
                                <input type="text" name="designation" class="field-input @error('designation') is-invalid @enderror" value="{{ old('designation') }}" placeholder="e.g. Logistics Manager, Supply Chain Analyst" required>
                                @error('designation')<div class="field-error">{{ $message }}</div>@enderror
                            </div>
                            <div>
                                <label class="field-label">Phone Number</label>
                                <div class="phone-field-wrap @error('phone') is-invalid @enderror">
                                    <div class="country-select" id="countrySelect">
                                        <button type="button" class="country-trigger" id="countryTrigger" aria-haspopup="listbox" aria-expanded="false" aria-label="Select country code">
                                            <span class="country-flag" id="selectedFlag">🇮🇳</span>
                                            <span class="country-code" id="selectedCode">+91</span>
                                            <svg class="country-chevron" width="11" height="11" viewBox="0 0 16 16" fill="currentColor"><path d="M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/></svg>
                                        </button>
                                        <div class="country-dropdown" id="countryDropdown" hidden role="listbox" aria-label="Country codes">
                                            <div class="country-search-wrap">
                                                <input type="text" class="country-search" id="countrySearch" placeholder="Search country..." autocomplete="off" aria-label="Search countries">
                                            </div>
                                            <ul class="country-list" id="countryList"></ul>
                                        </div>
                                    </div>
                                    <input type="hidden" name="phone_country_code" id="phoneCountryCode" value="+91">
                                    <input type="tel" name="phone" class="phone-number-input" id="phoneNumberInput" value="{{ old('phone') }}" placeholder="98765 43210" inputmode="tel" autocomplete="tel-national">
                                </div>
                                @error('phone')<div class="field-error">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                    <div>
                        <label class="field-label">Short Bio <span style="color:#ef4444">*</span></label>
                        <textarea name="intro" rows="3" class="field-input @error('intro') is-invalid @enderror" placeholder="Brief background on your experience and expertise." required>{{ old('intro') }}</textarea>
                        @error('intro')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                    <div>
                        <label class="field-label">Why do you want to contribute? <span style="color:#ef4444">*</span></label>
                        <textarea name="reason_for_joining" rows="4" class="field-input @error('reason_for_joining') is-invalid @enderror" placeholder="Tell us what topics you want to write about and the value you want to bring to readers." required>{{ old('reason_for_joining') }}</textarea>
                        @error('reason_for_joining')<div class="field-error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="submit-row">
                    <button type="submit" class="submit-btn" id="planSubmitBtn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="currentColor" viewBox="0 0 16 16"><path d="M15.854.146a.5.5 0 0 1 .11.54l-5.819 14.547a.75.75 0 0 1-1.329.124l-3.178-4.995L.643 7.184a.75.75 0 0 1 .124-1.33L15.314.037a.5.5 0 0 1 .54.11z"/></svg>
                        <span>Continue to Payment</span>
                    </button>
                    <p class="submit-note">You'll be taken to secure Razorpay checkout. Access starts immediately after payment.</p>
                </div>

            </form>
        </div>
    </div>

</div>
</div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    const rows = document.querySelectorAll('.plan-row');
    const submitLabel = document.querySelector('#planSubmitBtn span');

    function sync() {
        rows.forEach(row => {
            const input = row.querySelector('input[type="radio"]');
            const name  = row.querySelector('.plan-row-name');
            const sel   = input.checked;
            row.classList.toggle('is-selected', sel);
            if (sel && submitLabel) {
                submitLabel.textContent = 'Continue with ' + name.textContent.trim();
            }
        });
    }

    rows.forEach(row => {
        row.addEventListener('click', function (e) {
            if (e.target.closest('.plan-info-btn')) return;
            const input = this.querySelector('input[type="radio"]');
            input.checked = true;
            sync();
        });
    });

    sync();
})();

/* ── Country code picker ── */
(function () {
    const COUNTRIES = [
        {code:'US',dial:'+1',flag:'🇺🇸',name:'United States'},
        {code:'GB',dial:'+44',flag:'🇬🇧',name:'United Kingdom'},
        {code:'CA',dial:'+1',flag:'🇨🇦',name:'Canada'},
        {code:'AU',dial:'+61',flag:'🇦🇺',name:'Australia'},
        {code:'IN',dial:'+91',flag:'🇮🇳',name:'India'},
        {code:'DE',dial:'+49',flag:'🇩🇪',name:'Germany'},
        {code:'FR',dial:'+33',flag:'🇫🇷',name:'France'},
        {code:'IT',dial:'+39',flag:'🇮🇹',name:'Italy'},
        {code:'ES',dial:'+34',flag:'🇪🇸',name:'Spain'},
        {code:'NL',dial:'+31',flag:'🇳🇱',name:'Netherlands'},
        {code:'BE',dial:'+32',flag:'🇧🇪',name:'Belgium'},
        {code:'CH',dial:'+41',flag:'🇨🇭',name:'Switzerland'},
        {code:'AT',dial:'+43',flag:'🇦🇹',name:'Austria'},
        {code:'SE',dial:'+46',flag:'🇸🇪',name:'Sweden'},
        {code:'NO',dial:'+47',flag:'🇳🇴',name:'Norway'},
        {code:'DK',dial:'+45',flag:'🇩🇰',name:'Denmark'},
        {code:'FI',dial:'+358',flag:'🇫🇮',name:'Finland'},
        {code:'PL',dial:'+48',flag:'🇵🇱',name:'Poland'},
        {code:'PT',dial:'+351',flag:'🇵🇹',name:'Portugal'},
        {code:'IE',dial:'+353',flag:'🇮🇪',name:'Ireland'},
        {code:'NZ',dial:'+64',flag:'🇳🇿',name:'New Zealand'},
        {code:'SG',dial:'+65',flag:'🇸🇬',name:'Singapore'},
        {code:'AE',dial:'+971',flag:'🇦🇪',name:'United Arab Emirates'},
        {code:'SA',dial:'+966',flag:'🇸🇦',name:'Saudi Arabia'},
        {code:'QA',dial:'+974',flag:'🇶🇦',name:'Qatar'},
        {code:'KW',dial:'+965',flag:'🇰🇼',name:'Kuwait'},
        {code:'BH',dial:'+973',flag:'🇧🇭',name:'Bahrain'},
        {code:'OM',dial:'+968',flag:'🇴🇲',name:'Oman'},
        {code:'EG',dial:'+20',flag:'🇪🇬',name:'Egypt'},
        {code:'ZA',dial:'+27',flag:'🇿🇦',name:'South Africa'},
        {code:'NG',dial:'+234',flag:'🇳🇬',name:'Nigeria'},
        {code:'KE',dial:'+254',flag:'🇰🇪',name:'Kenya'},
        {code:'GH',dial:'+233',flag:'🇬🇭',name:'Ghana'},
        {code:'ET',dial:'+251',flag:'🇪🇹',name:'Ethiopia'},
        {code:'TZ',dial:'+255',flag:'🇹🇿',name:'Tanzania'},
        {code:'BR',dial:'+55',flag:'🇧🇷',name:'Brazil'},
        {code:'MX',dial:'+52',flag:'🇲🇽',name:'Mexico'},
        {code:'AR',dial:'+54',flag:'🇦🇷',name:'Argentina'},
        {code:'CO',dial:'+57',flag:'🇨🇴',name:'Colombia'},
        {code:'CL',dial:'+56',flag:'🇨🇱',name:'Chile'},
        {code:'PE',dial:'+51',flag:'🇵🇪',name:'Peru'},
        {code:'JP',dial:'+81',flag:'🇯🇵',name:'Japan'},
        {code:'KR',dial:'+82',flag:'🇰🇷',name:'South Korea'},
        {code:'CN',dial:'+86',flag:'🇨🇳',name:'China'},
        {code:'HK',dial:'+852',flag:'🇭🇰',name:'Hong Kong'},
        {code:'TW',dial:'+886',flag:'🇹🇼',name:'Taiwan'},
        {code:'TH',dial:'+66',flag:'🇹🇭',name:'Thailand'},
        {code:'MY',dial:'+60',flag:'🇲🇾',name:'Malaysia'},
        {code:'ID',dial:'+62',flag:'🇮🇩',name:'Indonesia'},
        {code:'PH',dial:'+63',flag:'🇵🇭',name:'Philippines'},
        {code:'VN',dial:'+84',flag:'🇻🇳',name:'Vietnam'},
        {code:'PK',dial:'+92',flag:'🇵🇰',name:'Pakistan'},
        {code:'BD',dial:'+880',flag:'🇧🇩',name:'Bangladesh'},
        {code:'LK',dial:'+94',flag:'🇱🇰',name:'Sri Lanka'},
        {code:'NP',dial:'+977',flag:'🇳🇵',name:'Nepal'},
        {code:'RU',dial:'+7',flag:'🇷🇺',name:'Russia'},
        {code:'UA',dial:'+380',flag:'🇺🇦',name:'Ukraine'},
        {code:'TR',dial:'+90',flag:'🇹🇷',name:'Turkey'},
        {code:'GR',dial:'+30',flag:'🇬🇷',name:'Greece'},
        {code:'CZ',dial:'+420',flag:'🇨🇿',name:'Czech Republic'},
        {code:'HU',dial:'+36',flag:'🇭🇺',name:'Hungary'},
        {code:'RO',dial:'+40',flag:'🇷🇴',name:'Romania'},
        {code:'IL',dial:'+972',flag:'🇮🇱',name:'Israel'},
        {code:'JO',dial:'+962',flag:'🇯🇴',name:'Jordan'},
        {code:'MA',dial:'+212',flag:'🇲🇦',name:'Morocco'},
        {code:'DZ',dial:'+213',flag:'🇩🇿',name:'Algeria'},
        {code:'TN',dial:'+216',flag:'🇹🇳',name:'Tunisia'},
    ].sort((a, b) => {
        // India always first, rest alphabetical
        if (a.code === 'IN') return -1;
        if (b.code === 'IN') return 1;
        return a.name.localeCompare(b.name);
    });

    let selected = COUNTRIES[0]; // India default
    const trigger    = document.getElementById('countryTrigger');
    const dropdown   = document.getElementById('countryDropdown');
    const searchEl   = document.getElementById('countrySearch');
    const listEl     = document.getElementById('countryList');
    const flagEl     = document.getElementById('selectedFlag');
    const codeEl     = document.getElementById('selectedCode');
    const hiddenCode = document.getElementById('phoneCountryCode');

    function renderList(filter) {
        const q = (filter || '').toLowerCase();
        const filtered = q
            ? COUNTRIES.filter(c => c.name.toLowerCase().includes(q) || c.dial.includes(q) || c.code.toLowerCase().includes(q))
            : COUNTRIES;
        listEl.innerHTML = '';
        if (!filtered.length) {
            listEl.innerHTML = '<li class="country-no-results">No countries found</li>';
            return;
        }
        filtered.forEach(c => {
            const li = document.createElement('li');
            li.className = 'country-item' + (c.code === selected.code ? ' is-active' : '');
            li.setAttribute('role', 'option');
            li.setAttribute('aria-selected', c.code === selected.code ? 'true' : 'false');
            li.innerHTML =
                '<span class="country-item-flag">' + c.flag + '</span>' +
                '<span class="country-item-name">' + c.name + '</span>' +
                '<span class="country-item-dial">' + c.dial + '</span>';
            li.addEventListener('click', function () { select(c); });
            listEl.appendChild(li);
        });
    }

    function select(c) {
        selected = c;
        flagEl.textContent  = c.flag;
        codeEl.textContent  = c.dial;
        hiddenCode.value    = c.dial;
        close();
    }

    function open() {
        dropdown.hidden = false;
        trigger.setAttribute('aria-expanded', 'true');
        searchEl.value = '';
        renderList('');
        searchEl.focus();
    }

    function close() {
        dropdown.hidden = true;
        trigger.setAttribute('aria-expanded', 'false');
    }

    trigger.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdown.hidden ? open() : close();
    });

    searchEl.addEventListener('input', function () {
        renderList(this.value);
    });

    searchEl.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') { close(); trigger.focus(); }
    });

    document.addEventListener('click', function (e) {
        if (!document.getElementById('countrySelect').contains(e.target)) close();
    });

    // Initial render (populate list but keep dropdown hidden)
    renderList('');
})();
</script>
@endsection
