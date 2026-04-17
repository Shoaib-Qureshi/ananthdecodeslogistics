<!DOCTYPE html>
<html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;background:#f4f4f4;margin:0;padding:20px}
.wrap{max-width:560px;margin:auto;background:#fff;border-radius:8px;overflow:hidden}
.header{background:#1a3c5e;padding:24px 32px}.header h2{color:#fff;margin:0;font-size:1.2rem}.header p{color:#93c5fd;margin:4px 0 0;font-size:.88rem}
.body{padding:28px 32px}.body p{color:#374151;line-height:1.6;margin:0 0 14px}
.highlight{background:#f0fdf4;border-left:4px solid #22c55e;border-radius:0 6px 6px 0;padding:12px 16px;margin:16px 0}
.steps{background:#f8fafc;border:1px solid #e2e8f0;border-radius:6px;padding:16px 20px;margin:16px 0}
.steps ol{margin:0;padding-left:18px;color:#374151;line-height:1.8}
.btn{display:inline-block;background:#e07b39;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;font-size:.9rem;margin-top:8px}
.note{font-size:.82rem;color:#6b7280;margin-top:10px}
.footer{padding:16px 32px;border-top:1px solid #e5e7eb;font-size:.78rem;color:#9ca3af}
</style></head>
<body><div class="wrap">

<div class="header">
    <h2>Your Expert Desk account is ready!</h2>
    <p>Ananth Decodes Logistics — The Expert Desk</p>
</div>

<div class="body">
    <p>Hi <strong>{{ $user->name }}</strong>,</p>
    <p>
        Your <strong>Expert Desk</strong> contributor account on Ananth Decodes Logistics has been set up by our team.
        You can now set your password and start publishing your logistics insights.
    </p>

    <div class="highlight">
        <strong>Account details:</strong><br>
        Email: <strong>{{ $user->email }}</strong><br>
        Plan: <strong>{{ $user->contributorPlanDetails()['name'] ?? 'Complimentary Contributor' }}</strong>
    </div>

    <div class="steps">
        <strong>Getting started:</strong>
        <ol>
            <li>Click the button below to set your password</li>
            <li>Log in to your Expert Desk dashboard</li>
            <li>Create and submit your first post</li>
        </ol>
    </div>

    <a href="{{ $resetUrl }}" class="btn">Set Password &amp; Get Started</a>

    <p class="note">This link expires in 60 minutes. If it expires, use the <a href="{{ route('password.request') }}" style="color:#e07b39;">forgot password</a> page to get a new one.</p>

    <p style="margin-top:20px;">We look forward to reading your logistics insights.</p>
</div>

<div class="footer">&copy; {{ date('Y') }} Ananth Decodes Logistics. This email was sent to {{ $user->email }}.</div>

</div></body></html>
