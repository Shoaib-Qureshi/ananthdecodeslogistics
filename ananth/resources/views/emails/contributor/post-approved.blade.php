<!DOCTYPE html>
<html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;background:#f4f4f4;margin:0;padding:20px;}
.wrap{max-width:560px;margin:auto;background:#fff;border-radius:8px;overflow:hidden;}
.header{background:#1a3c5e;padding:24px 32px;} .header h2{color:#fff;margin:0;font-size:1.2rem;} .header p{color:#93c5fd;margin:4px 0 0;font-size:.88rem;}
.body{padding:28px 32px;} .body p{color:#374151;line-height:1.6;margin:0 0 14px;}
.post-box{background:#f0fdf4;border:1px solid #bbf7d0;border-radius:8px;padding:14px 18px;margin:16px 0;}
.btn{display:inline-block;background:#e07b39;color:#fff;padding:12px 28px;border-radius:6px;text-decoration:none;font-weight:600;font-size:.9rem;margin-top:8px;}
.footer{padding:16px 32px;border-top:1px solid #e5e7eb;font-size:.78rem;color:#9ca3af;}
</style></head>
<body><div class="wrap">
<div class="header">
<h2>Your post has been published! 🎉</h2>
<p>Congratulations — your work is now live.</p>
</div>
<div class="body">
<p>Hi <strong>{{ $post->author->name }}</strong>,</p>
<p>Great news! Your post has been reviewed and published on <strong>Ananth Decodes Logistics</strong>.</p>
<div class="post-box">
<strong>{{ $post->title }}</strong><br>
<span style="font-size:.85rem;color:#065f46;">Published {{ $post->published_at?->format('d M Y') }}</span>
</div>
<a href="{{ route('contributors.show', $post->slug) }}" class="btn">View Your Post Live →</a>
<p style="margin-top:20px;">Share it with your network and keep contributing!</p>
</div>
<div class="footer">© {{ date('Y') }} Ananth Decodes Logistics. This email was sent to {{ $post->author->email }}.</div>
</div></body></html>
