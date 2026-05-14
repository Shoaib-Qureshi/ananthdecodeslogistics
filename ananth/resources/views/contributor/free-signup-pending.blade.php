@extends('layouts.front')
@section('title', 'Free Account Pending Approval - Ananth Decodes Logistics')
@section('description', 'Your Expert Desk free account request is pending admin approval.')
@section('url', route('contributor.free-signup.pending', ['payment' => $payment->id]))
@section('img', asset('img/site-banner.jpg'))

@section('styles')
<style>
header{position:sticky;top:0;background:var(--white)!important;z-index:100}
.pending-page{min-height:70vh;background:#f8fbff;padding:4rem 0}
.pending-card{max-width:680px;margin:0 auto;background:#fff;border:1px solid #e2e8f0;border-radius:20px;padding:2rem;box-shadow:0 20px 48px rgba(15,23,42,.07)}
.pending-kicker{display:inline-flex;align-items:center;padding:.35rem .75rem;border-radius:999px;background:#eff6ff;color:#1d4ed8;font-size:.72rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;margin-bottom:1rem}
.pending-card h1{font-size:clamp(1.75rem,3vw,2.35rem);line-height:1.1;color:#0f172a;font-weight:800;margin:0 0 .75rem}
.pending-card p{color:#475569;line-height:1.75;margin:0 0 1rem}
.pending-details{display:grid;gap:.65rem;margin:1.5rem 0;padding:1rem;border-radius:14px;background:#f8fafc;border:1px solid #e2e8f0}
.pending-detail{display:flex;justify-content:space-between;gap:1rem;color:#334155;font-size:.9rem}
.pending-detail strong{color:#0f172a}
.pending-actions{display:flex;flex-wrap:wrap;gap:.75rem;margin-top:1.5rem}
.pending-btn{display:inline-flex;align-items:center;justify-content:center;border-radius:12px;padding:.8rem 1.15rem;font-weight:800;text-decoration:none;font-size:.9rem}
.pending-btn.primary{background:#3882fa;color:#fff}
.pending-btn.secondary{border:1px solid #cbd5e1;color:#334155;background:#fff}
@media(max-width:640px){.pending-page{padding:2rem 0}.pending-card{border-left:none;border-right:none;border-radius:0;padding:1.25rem}.pending-detail{flex-direction:column;gap:.15rem}}
</style>
@endsection

@section('content')
<div class="pending-page">
    <div class="container">
        <div class="pending-card">
            <span class="pending-kicker">Pending approval</span>
            <h1>Your free account request is in review</h1>
            <p>Thanks for applying to The Expert Desk. Admin approval is required before you can set your password, log in, or submit posts.</p>
            <p>Once approved, you will receive a password setup email at <strong>{{ $payment->email }}</strong>.</p>

            <div class="pending-details">
                <div class="pending-detail">
                    <span>Plan</span>
                    <strong>{{ $plan['name'] }}</strong>
                </div>
                <div class="pending-detail">
                    <span>Access window</span>
                    <strong>{{ $plan['duration_label'] }}</strong>
                </div>
                <div class="pending-detail">
                    <span>Submission limit</span>
                    <strong>{{ $plan['post_limit_label'] }}</strong>
                </div>
            </div>

            <div class="pending-actions">
                <a href="{{ route('contributor.login') }}" class="pending-btn primary">Go to Expert Desk Login</a>
                <a href="/" class="pending-btn secondary">Back to site</a>
            </div>
        </div>
    </div>
</div>
@endsection
