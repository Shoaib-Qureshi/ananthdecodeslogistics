<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Contributor Plans</title>
    <style>
        .plans-grid {
            display: grid;
            gap: 1.25rem;
        }
        .plan-card {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 12px 28px rgba(15, 23, 42, 0.04);
        }
        .plan-accordion[open] {
            box-shadow: 0 16px 32px rgba(15, 23, 42, 0.08);
        }
        .plan-card-header {
            display: flex;
            justify-content: space-between;
            gap: 1rem;
            align-items: center;
            padding: 1.25rem 1.5rem;
            background: linear-gradient(180deg, #fcfdff 0%, #f8fbff 100%);
            cursor: pointer;
            list-style: none;
        }
        .plan-card-header::-webkit-details-marker {
            display: none;
        }
        .plan-card-header-main {
            display: flex;
            flex-direction: column;
            gap: .45rem;
            min-width: 0;
        }
        .plan-card-meta {
            color: #64748b;
            font-size: .82rem;
            line-height: 1.5;
        }
        .plan-card-header-side {
            display: flex;
            align-items: center;
            gap: .9rem;
            margin-left: auto;
        }
        .plan-code {
            display: inline-flex;
            align-items: center;
            padding: .3rem .6rem;
            border-radius: 999px;
            background: #eff6ff;
            color: #1d4ed8;
            font-size: .72rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
        }
        .plan-badges {
            display: flex;
            gap: .5rem;
            flex-wrap: wrap;
        }
        .plan-badge {
            display: inline-flex;
            align-items: center;
            padding: .3rem .65rem;
            border-radius: 999px;
            font-size: .75rem;
            font-weight: 700;
        }
        .plan-badge.public {
            background: #dcfce7;
            color: #166534;
        }
        .plan-badge.internal {
            background: #f1f5f9;
            color: #475569;
        }
        .plan-badge.featured {
            background: #ede9fe;
            color: #6d28d9;
        }
        .plan-chevron {
            width: 34px;
            height: 34px;
            border-radius: 999px;
            border: 1px solid #dbe4f0;
            background: #fff;
            color: #475569;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            transition: transform .18s ease, color .18s ease, border-color .18s ease;
        }
        .plan-accordion[open] .plan-chevron {
            transform: rotate(180deg);
            color: #1d4ed8;
            border-color: #bfdbfe;
        }
        .plan-card-body {
            padding: 1.5rem;
            border-top: 1px solid #eef2f7;
        }
        .helper-card {
            background: linear-gradient(135deg, #fff7ed 0%, #ffffff 100%);
            border: 1px solid #fed7aa;
            border-radius: 18px;
            padding: 1.25rem 1.5rem;
            margin-bottom: 1.25rem;
        }
        .helper-card p:last-child {
            margin-bottom: 0;
        }
        .toggle-internal-wrap {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 1rem;
        }
        .toggle-internal-btn {
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .45rem .8rem;
            border: 1px solid #cbd5e1;
            border-radius: 999px;
            background: #fff;
            color: #334155;
            font-size: .78rem;
            font-weight: 700;
            line-height: 1;
            cursor: pointer;
            transition: background .16s ease, border-color .16s ease, color .16s ease;
        }
        .toggle-internal-btn:hover {
            background: #f8fafc;
            border-color: #94a3b8;
            color: #0f172a;
        }
        .toggle-internal-btn.is-active {
            background: #eef2ff;
            border-color: #c7d2fe;
            color: #4338ca;
        }
        .internal-plan-wrap[hidden] {
            display: none !important;
        }
        .form-label-admin {
            display: block;
            margin-bottom: .4rem;
            font-size: .78rem;
            font-weight: 700;
            letter-spacing: .04em;
            text-transform: uppercase;
            color: #64748b;
        }
        .checkbox-card {
            height: 100%;
            padding: 1rem;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #f8fafc;
        }
        .checkbox-card .form-check-label {
            font-weight: 700;
            color: #0f172a;
        }
        .muted-note {
            font-size: .78rem;
            color: #64748b;
            line-height: 1.6;
        }
        .save-bar {
            position: sticky;
            bottom: 0;
            z-index: 5;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border: 1px solid #e5e7eb;
            border-radius: 18px;
            padding: 1rem 1.25rem;
            margin-top: 1.25rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 1rem;
            box-shadow: 0 -8px 20px rgba(15, 23, 42, 0.05);
        }
        @media (max-width: 767px) {
            .plan-card-header,
            .save-bar {
                flex-direction: column;
                align-items: flex-start;
            }
            .plan-card-header-side {
                width: 100%;
                justify-content: space-between;
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
@include('admin.adminHeader')

<section class="main_section">
    <div class="container-fluid">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0 fw-bold">Contributor Plans</h4>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                @foreach($errors->all() as $error)
                    <p class="mb-0">{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="helper-card">
            <h5 class="mb-2">What this controls</h5>
            <p class="mb-2 text-muted">The price here is the live amount used for contributor signup and Razorpay checkout. The labels and notes below control the copy shown on the public pricing page, application form, checkout screen, and payment success flow.</p>
            @if(!$storageReady)
                <p class="text-danger fw-semibold mb-0">This page is in fallback mode right now. Run the latest migration before saving changes, otherwise edits cannot be persisted.</p>
            @endif
        </div>

        <form method="POST" action="{{ route('admin.contributor.plans.update') }}">
            @csrf
            @php
                $visiblePlans = [];
                $internalPlan = null;

                foreach (array_values($plans) as $planItem) {
                    if (($planItem['code'] ?? null) === \App\Support\ContributorPlans::FREE) {
                        $internalPlan = $planItem;
                        continue;
                    }

                    $visiblePlans[] = $planItem;
                }

                $internalPlanIndex = count($visiblePlans);
                $showInternalPlan = $internalPlan && old("plans.$internalPlanIndex.code") === \App\Support\ContributorPlans::FREE;
            @endphp

            <div class="plans-grid">
                @foreach($visiblePlans as $index => $plan)
                    @php($publicValue = old("plans.$index.public", $plan['public']))
                    @php($featuredValue = old("plans.$index.homepage_feature", $plan['homepage_feature']))
                    <details class="plan-card plan-accordion" {{ !$errors->any() && $loop->first ? 'open' : '' }}>
                        <summary class="plan-card-header">
                            <div class="plan-card-header-main">
                                <div class="plan-code">{{ $plan['code'] }}</div>
                                <h5 class="mb-1 mt-2">{{ old("plans.$index.name", $plan['name']) }}</h5>
                                <div class="text-muted" style="font-size:.9rem;">Admin label: {{ old("plans.$index.admin_name", $plan['admin_name']) }}</div>
                                <div class="plan-card-meta">
                                    {{ old("plans.$index.price_label", $plan['price_label']) }}
                                    · {{ old("plans.$index.duration_label", $plan['duration_label']) ?: 'No duration set' }}
                                    · {{ old("plans.$index.post_limit_label", $plan['post_limit_label']) ?: 'No limit label set' }}
                                </div>
                            </div>
                            <div class="plan-card-header-side">
                                <div class="plan-badges">
                                    <span class="plan-badge {{ $publicValue ? 'public' : 'internal' }}">{{ $publicValue ? 'Public' : 'Internal only' }}</span>
                                    @if($featuredValue)
                                        <span class="plan-badge featured">Homepage feature enabled</span>
                                    @endif
                                </div>
                                <span class="plan-chevron" aria-hidden="true">
                                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                        <path d="M3.204 5h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0L2.451 6.659A1 1 0 0 1 3.204 5z"/>
                                    </svg>
                                </span>
                            </div>
                        </summary>

                        <div class="plan-card-body">
                            <input type="hidden" name="plans[{{ $index }}][code]" value="{{ $plan['code'] }}">

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label-admin">Plan Name</label>
                                    <input type="text" class="form-control" name="plans[{{ $index }}][name]" value="{{ old("plans.$index.name", $plan['name']) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-admin">Admin Name</label>
                                    <input type="text" class="form-control" name="plans[{{ $index }}][admin_name]" value="{{ old("plans.$index.admin_name", $plan['admin_name']) }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label-admin">Price</label>
                                    <input type="number" min="0" class="form-control" name="plans[{{ $index }}][price]" value="{{ old("plans.$index.price", $plan['price']) }}">
                                </div>
                                <div class="col-md-2">
                                    <label class="form-label-admin">Currency</label>
                                    <input type="text" class="form-control text-uppercase" name="plans[{{ $index }}][currency]" value="{{ old("plans.$index.currency", $plan['currency']) }}">
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label-admin">Price Label</label>
                                    <input type="text" class="form-control" name="plans[{{ $index }}][price_label]" value="{{ old("plans.$index.price_label", $plan['price_label']) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-admin">Success Label</label>
                                    <input type="text" class="form-control" name="plans[{{ $index }}][success_label]" value="{{ old("plans.$index.success_label", $plan['success_label']) }}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label-admin">Renew CTA</label>
                                    <input type="text" class="form-control" name="plans[{{ $index }}][renew_cta]" value="{{ old("plans.$index.renew_cta", $plan['renew_cta']) }}">
                                </div>

                                <div class="col-md-3">
                                    <label class="form-label-admin">Duration Months</label>
                                    <input type="number" min="0" class="form-control" name="plans[{{ $index }}][duration_months]" value="{{ old("plans.$index.duration_months", $plan['duration_months']) }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-admin">Duration Label</label>
                                    <input type="text" class="form-control" name="plans[{{ $index }}][duration_label]" value="{{ old("plans.$index.duration_label", $plan['duration_label']) }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-admin">Max Posts</label>
                                    <input type="number" min="0" class="form-control" name="plans[{{ $index }}][max_posts]" value="{{ old("plans.$index.max_posts", $plan['max_posts']) }}">
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label-admin">Post Limit Label</label>
                                    <input type="text" class="form-control" name="plans[{{ $index }}][post_limit_label]" value="{{ old("plans.$index.post_limit_label", $plan['post_limit_label']) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-admin">Checkout Name</label>
                                    <input type="text" class="form-control" name="plans[{{ $index }}][checkout_name]" value="{{ old("plans.$index.checkout_name", $plan['checkout_name']) }}">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-admin">Checkout Description</label>
                                    <input type="text" class="form-control" name="plans[{{ $index }}][checkout_description]" value="{{ old("plans.$index.checkout_description", $plan['checkout_description']) }}">
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label-admin">Summary</label>
                                    <textarea class="form-control" rows="4" name="plans[{{ $index }}][summary]">{{ old("plans.$index.summary", $plan['summary']) }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label-admin">Highlights</label>
                                    <textarea class="form-control" rows="4" name="plans[{{ $index }}][highlights_text]">{{ old("plans.$index.highlights_text", implode("\n", $plan['highlights'] ?? [])) }}</textarea>
                                    <div class="muted-note mt-2">One highlight per line.</div>
                                </div>

                                <div class="col-md-12">
                                    <label class="form-label-admin">Success Note</label>
                                    <textarea class="form-control" rows="3" name="plans[{{ $index }}][success_note]">{{ old("plans.$index.success_note", $plan['success_note']) }}</textarea>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkbox-card">
                                        <input type="hidden" name="plans[{{ $index }}][public]" value="0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="plans[{{ $index }}][public]" value="1" id="publicPlan{{ $index }}" {{ $publicValue ? 'checked' : '' }}>
                                            <label class="form-check-label" for="publicPlan{{ $index }}">Show on public signup pages</label>
                                        </div>
                                        <div class="muted-note mt-2">If enabled, this plan appears on `/write-for-us` and `/expert-desk/apply`.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="checkbox-card">
                                        <input type="hidden" name="plans[{{ $index }}][homepage_feature]" value="0">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="plans[{{ $index }}][homepage_feature]" value="1" id="featurePlan{{ $index }}" {{ $featuredValue ? 'checked' : '' }}>
                                            <label class="form-check-label" for="featurePlan{{ $index }}">Enable homepage feature eligibility</label>
                                        </div>
                                        <div class="muted-note mt-2">Used for contributor access rules and featured placement eligibility.</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </details>
                @endforeach

                @if($internalPlan)
                    @php($publicValue = old("plans.$internalPlanIndex.public", $internalPlan['public']))
                    @php($featuredValue = old("plans.$internalPlanIndex.homepage_feature", $internalPlan['homepage_feature']))
                    <div class="toggle-internal-wrap">
                        <button
                            type="button"
                            class="toggle-internal-btn {{ $showInternalPlan ? 'is-active' : '' }}"
                            id="toggleInternalPlanBtn"
                            aria-expanded="{{ $showInternalPlan ? 'true' : 'false' }}"
                            aria-controls="internalPlanWrap">
                            <span id="toggleInternalPlanLabel">{{ $showInternalPlan ? 'Hide internal plan' : 'Show internal plan' }}</span>
                        </button>
                    </div>

                    <div id="internalPlanWrap" class="internal-plan-wrap" {{ $showInternalPlan ? '' : 'hidden' }}>
                        <details class="plan-card plan-accordion" {{ $showInternalPlan ? 'open' : '' }}>
                            <summary class="plan-card-header">
                                <div class="plan-card-header-main">
                                    <div class="plan-code">{{ $internalPlan['code'] }}</div>
                                    <h5 class="mb-1 mt-2">{{ old("plans.$internalPlanIndex.name", $internalPlan['name']) }}</h5>
                                    <div class="text-muted" style="font-size:.9rem;">Admin label: {{ old("plans.$internalPlanIndex.admin_name", $internalPlan['admin_name']) }}</div>
                                    <div class="plan-card-meta">
                                        {{ old("plans.$internalPlanIndex.price_label", $internalPlan['price_label']) }}
                                        Â· {{ old("plans.$internalPlanIndex.duration_label", $internalPlan['duration_label']) ?: 'No duration set' }}
                                        Â· {{ old("plans.$internalPlanIndex.post_limit_label", $internalPlan['post_limit_label']) ?: 'No limit label set' }}
                                    </div>
                                </div>
                                <div class="plan-card-header-side">
                                    <div class="plan-badges">
                                        <span class="plan-badge {{ $publicValue ? 'public' : 'internal' }}">{{ $publicValue ? 'Public' : 'Internal only' }}</span>
                                        @if($featuredValue)
                                            <span class="plan-badge featured">Homepage feature enabled</span>
                                        @endif
                                    </div>
                                    <span class="plan-chevron" aria-hidden="true">
                                        <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor">
                                            <path d="M3.204 5h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0L2.451 6.659A1 1 0 0 1 3.204 5z"/>
                                        </svg>
                                    </span>
                                </div>
                            </summary>

                            <div class="plan-card-body">
                                <input type="hidden" name="plans[{{ $internalPlanIndex }}][code]" value="{{ $internalPlan['code'] }}">

                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label-admin">Plan Name</label>
                                        <input type="text" class="form-control" name="plans[{{ $internalPlanIndex }}][name]" value="{{ old("plans.$internalPlanIndex.name", $internalPlan['name']) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-admin">Admin Name</label>
                                        <input type="text" class="form-control" name="plans[{{ $internalPlanIndex }}][admin_name]" value="{{ old("plans.$internalPlanIndex.admin_name", $internalPlan['admin_name']) }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label-admin">Price</label>
                                        <input type="number" min="0" class="form-control" name="plans[{{ $internalPlanIndex }}][price]" value="{{ old("plans.$internalPlanIndex.price", $internalPlan['price']) }}">
                                    </div>
                                    <div class="col-md-2">
                                        <label class="form-label-admin">Currency</label>
                                        <input type="text" class="form-control text-uppercase" name="plans[{{ $internalPlanIndex }}][currency]" value="{{ old("plans.$internalPlanIndex.currency", $internalPlan['currency']) }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label-admin">Price Label</label>
                                        <input type="text" class="form-control" name="plans[{{ $internalPlanIndex }}][price_label]" value="{{ old("plans.$internalPlanIndex.price_label", $internalPlan['price_label']) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-admin">Success Label</label>
                                        <input type="text" class="form-control" name="plans[{{ $internalPlanIndex }}][success_label]" value="{{ old("plans.$internalPlanIndex.success_label", $internalPlan['success_label']) }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label-admin">Renew CTA</label>
                                        <input type="text" class="form-control" name="plans[{{ $internalPlanIndex }}][renew_cta]" value="{{ old("plans.$internalPlanIndex.renew_cta", $internalPlan['renew_cta']) }}">
                                    </div>

                                    <div class="col-md-3">
                                        <label class="form-label-admin">Duration Months</label>
                                        <input type="number" min="0" class="form-control" name="plans[{{ $internalPlanIndex }}][duration_months]" value="{{ old("plans.$internalPlanIndex.duration_months", $internalPlan['duration_months']) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label-admin">Duration Label</label>
                                        <input type="text" class="form-control" name="plans[{{ $internalPlanIndex }}][duration_label]" value="{{ old("plans.$internalPlanIndex.duration_label", $internalPlan['duration_label']) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label-admin">Max Posts</label>
                                        <input type="number" min="0" class="form-control" name="plans[{{ $internalPlanIndex }}][max_posts]" value="{{ old("plans.$internalPlanIndex.max_posts", $internalPlan['max_posts']) }}">
                                    </div>
                                    <div class="col-md-3">
                                        <label class="form-label-admin">Post Limit Label</label>
                                        <input type="text" class="form-control" name="plans[{{ $internalPlanIndex }}][post_limit_label]" value="{{ old("plans.$internalPlanIndex.post_limit_label", $internalPlan['post_limit_label']) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-admin">Checkout Name</label>
                                        <input type="text" class="form-control" name="plans[{{ $internalPlanIndex }}][checkout_name]" value="{{ old("plans.$internalPlanIndex.checkout_name", $internalPlan['checkout_name']) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-admin">Checkout Description</label>
                                        <input type="text" class="form-control" name="plans[{{ $internalPlanIndex }}][checkout_description]" value="{{ old("plans.$internalPlanIndex.checkout_description", $internalPlan['checkout_description']) }}">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label-admin">Summary</label>
                                        <textarea class="form-control" rows="4" name="plans[{{ $internalPlanIndex }}][summary]">{{ old("plans.$internalPlanIndex.summary", $internalPlan['summary']) }}</textarea>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label-admin">Highlights</label>
                                        <textarea class="form-control" rows="4" name="plans[{{ $internalPlanIndex }}][highlights_text]">{{ old("plans.$internalPlanIndex.highlights_text", implode("\n", $internalPlan['highlights'] ?? [])) }}</textarea>
                                        <div class="muted-note mt-2">One highlight per line.</div>
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label-admin">Success Note</label>
                                        <textarea class="form-control" rows="3" name="plans[{{ $internalPlanIndex }}][success_note]">{{ old("plans.$internalPlanIndex.success_note", $internalPlan['success_note']) }}</textarea>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="checkbox-card">
                                            <input type="hidden" name="plans[{{ $internalPlanIndex }}][public]" value="0">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="plans[{{ $internalPlanIndex }}][public]" value="1" id="publicPlan{{ $internalPlanIndex }}" {{ $publicValue ? 'checked' : '' }}>
                                                <label class="form-check-label" for="publicPlan{{ $internalPlanIndex }}">Show on public signup pages</label>
                                            </div>
                                            <div class="muted-note mt-2">If enabled, this plan appears on `/write-for-us` and `/expert-desk/apply`.</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="checkbox-card">
                                            <input type="hidden" name="plans[{{ $internalPlanIndex }}][homepage_feature]" value="0">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="plans[{{ $internalPlanIndex }}][homepage_feature]" value="1" id="featurePlan{{ $internalPlanIndex }}" {{ $featuredValue ? 'checked' : '' }}>
                                                <label class="form-check-label" for="featurePlan{{ $internalPlanIndex }}">Enable homepage feature eligibility</label>
                                            </div>
                                            <div class="muted-note mt-2">Used for contributor access rules and featured placement eligibility.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </details>
                    </div>
                @endif
            </div>

            <div class="save-bar">
                <div>
                    <strong>Save contributor plan changes</strong>
                    <div class="muted-note">This updates the public pricing cards, application flow, and checkout amount for paid plans.</div>
                </div>
                <button type="submit" class="btn btn-primary px-4" {{ !$storageReady ? 'disabled' : '' }}>Save Plans</button>
            </div>
        </form>
    </div>
</section>

@include('admin.adminFooter')
<script>
    (function () {
        const accordionItems = document.querySelectorAll('.plan-accordion');
        const toggleInternalPlanBtn = document.getElementById('toggleInternalPlanBtn');
        const toggleInternalPlanLabel = document.getElementById('toggleInternalPlanLabel');
        const internalPlanWrap = document.getElementById('internalPlanWrap');

        accordionItems.forEach((item) => {
            item.addEventListener('toggle', function () {
                if (!this.open) {
                    return;
                }

                accordionItems.forEach((other) => {
                    if (other !== this) {
                        other.open = false;
                    }
                });
            });
        });

        if (toggleInternalPlanBtn && toggleInternalPlanLabel && internalPlanWrap) {
            toggleInternalPlanBtn.addEventListener('click', function () {
                const isHidden = internalPlanWrap.hasAttribute('hidden');

                if (isHidden) {
                    internalPlanWrap.removeAttribute('hidden');
                    toggleInternalPlanBtn.classList.add('is-active');
                    toggleInternalPlanBtn.setAttribute('aria-expanded', 'true');
                    toggleInternalPlanLabel.textContent = 'Hide internal plan';
                    return;
                }

                internalPlanWrap.setAttribute('hidden', 'hidden');
                toggleInternalPlanBtn.classList.remove('is-active');
                toggleInternalPlanBtn.setAttribute('aria-expanded', 'false');
                toggleInternalPlanLabel.textContent = 'Show internal plan';
            });
        }
    })();
</script>
</body>
</html>
