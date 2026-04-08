<!DOCTYPE html>
<html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;background:#f4f4f4;margin:0;padding:20px}
.wrap{max-width:560px;margin:auto;background:#fff;border-radius:8px;overflow:hidden}
.header{background:#1a3c5e;padding:24px 32px}.header h2{color:#fff;margin:0;font-size:1.2rem}.header p{color:#93c5fd;margin:4px 0 0;font-size:.88rem}
.body{padding:28px 32px}.body p{color:#374151;line-height:1.6;margin:0 0 14px}
.highlight{background:#f0fdf4;border-left:4px solid #22c55e;border-radius:0 6px 6px 0;padding:12px 16px;margin:16px 0}
.btn{display:inline-block;background:#e07b39;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;font-size:.9rem;margin-top:8px}
.footer{padding:16px 32px;border-top:1px solid #e5e7eb;font-size:.78rem;color:#9ca3af}
</style></head>
<body><div class="wrap">
<div class="header">
<h2>Your application has been approved!</h2>
<p>Welcome to The Expert Desk on Ananth Decodes Logistics.</p>
</div>
<div class="body">
<p>Hi <strong>{{ $user->name }}</strong>,</p>
<p>Congratulations! Your application to join <strong>The Expert Desk</strong> on Ananth Decodes Logistics has been approved.</p>
<div class="highlight">
<strong>Next step:</strong> Click the link in the password setup email sent separately to <strong>{{ $user->email }}</strong> to set your password and access your Expert Desk dashboard.
</div>
<p>Once your password is set, you can log in at:</p>
<a href="{{ route('contributor.login') }}" class="btn">Access The Expert Desk</a>
<p style="margin-top:20px;">We look forward to reading your logistics insights.</p>
</div>
<div class="footer">&copy; {{ date('Y') }} Ananth Decodes Logistics. This email was sent to {{ $user->email }}.</div>
</div></body></html>
