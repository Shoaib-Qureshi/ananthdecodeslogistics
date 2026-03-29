<!DOCTYPE html>
<html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;background:#f4f4f4;margin:0;padding:20px;}
.wrap{max-width:560px;margin:auto;background:#fff;border-radius:8px;overflow:hidden;}
.header{background:#1a3c5e;padding:24px 32px;} .header h2{color:#fff;margin:0;font-size:1.2rem;}
.body{padding:28px 32px;} .body p{color:#374151;line-height:1.6;margin:0 0 14px;}
.reason-box{background:#fef2f2;border-left:4px solid #ef4444;border-radius:0 6px 6px 0;padding:12px 16px;margin:16px 0;color:#7f1d1d;}
.btn{display:inline-block;background:#1a3c5e;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;font-weight:600;font-size:.9rem;margin-top:8px;}
.footer{padding:16px 32px;border-top:1px solid #e5e7eb;font-size:.78rem;color:#9ca3af;}
</style></head>
<body><div class="wrap">
<div class="header"><h2>Update on your post submission</h2></div>
<div class="body">
<p>Hi <strong>{{ $post->author->name }}</strong>,</p>
<p>Thank you for submitting <strong>"{{ $post->title }}"</strong> to Ananth Decodes Logistics. After review, we're unable to publish this post in its current form.</p>
@if($post->rejection_reason)
<div class="reason-box">
<strong>Feedback from our editorial team:</strong><br>{{ $post->rejection_reason }}
</div>
@endif
<p>You can log into your dashboard, update the post based on this feedback, and resubmit for review.</p>
<a href="{{ url('dashboard/posts') }}" class="btn">Go to Dashboard →</a>
</div>
<div class="footer">© {{ date('Y') }} Ananth Decodes Logistics. This email was sent to {{ $post->author->email }}.</div>
</div></body></html>
