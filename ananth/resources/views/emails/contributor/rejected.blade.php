<!DOCTYPE html>
<html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;background:#f4f4f4;margin:0;padding:20px;}
.wrap{max-width:560px;margin:auto;background:#fff;border-radius:8px;overflow:hidden;}
.header{background:#1a3c5e;padding:24px 32px;} .header h2{color:#fff;margin:0;font-size:1.2rem;}
.body{padding:28px 32px;} .body p{color:#374151;line-height:1.6;margin:0 0 14px;}
.reason-box{background:#fef2f2;border-left:4px solid #ef4444;border-radius:0 6px 6px 0;padding:12px 16px;margin:16px 0;color:#7f1d1d;}
.footer{padding:16px 32px;border-top:1px solid #e5e7eb;font-size:.78rem;color:#9ca3af;}
</style></head>
<body><div class="wrap">
<div class="header"><h2>Update on your contributor application</h2></div>
<div class="body">
<p>Hi <strong>{{ $user->name }}</strong>,</p>
<p>Thank you for your interest in contributing to <strong>Ananth Decodes Logistics</strong>. After careful review, we are unable to approve your application at this time.</p>
@if($user->rejection_reason)
<div class="reason-box">
<strong>Reason:</strong><br>{{ $user->rejection_reason }}
</div>
@endif
<p>We appreciate you taking the time to apply and encourage you to continue engaging with our content.</p>
<p>If you have questions, feel free to reach out via our <a href="{{ url('contact-us') }}" style="color:#e07b39;">contact page</a>.</p>
</div>
<div class="footer">© {{ date('Y') }} Ananth Decodes Logistics. This email was sent to {{ $user->email }}.</div>
</div></body></html>
