<!DOCTYPE html>
<html><head><meta charset="UTF-8"><style>
body{font-family:Arial,sans-serif;background:#f4f4f4;margin:0;padding:20px;}
.wrap{max-width:560px;margin:auto;background:#fff;border-radius:8px;overflow:hidden;}
.header{background:#1a3c5e;padding:24px 32px;} .header h2{color:#fff;margin:0;font-size:1.2rem;}
.body{padding:28px 32px;} .body p{color:#374151;line-height:1.6;margin:0 0 12px;}
.field{background:#f8f9fc;border-radius:6px;padding:12px 16px;margin:8px 0;}
.field .label{font-size:.75rem;text-transform:uppercase;letter-spacing:.06em;color:#6b7280;margin-bottom:2px;}
.field .value{color:#111827;font-size:.9rem;}
.btn{display:inline-block;background:#e07b39;color:#fff;padding:10px 24px;border-radius:6px;text-decoration:none;font-weight:600;font-size:.9rem;margin-top:16px;}
.footer{padding:16px 32px;border-top:1px solid #e5e7eb;font-size:.78rem;color:#9ca3af;}
</style></head>
<body><div class="wrap">
<div class="header"><h2>New Contributor Post — Pending Review</h2></div>
<div class="body">
<p>A contributor has submitted a new post for review.</p>
<div class="field"><div class="label">Post Title</div><div class="value">{{ $post->title }}</div></div>
<div class="field"><div class="label">Author</div><div class="value">{{ $post->author->name }}</div></div>
<div class="field"><div class="label">Category</div><div class="value">{{ $post->category?->name ?? '—' }}</div></div>
<div class="field"><div class="label">Submitted</div><div class="value">{{ $post->created_at->format('d M Y, H:i') }}</div></div>
<a href="{{ url('admin/contributor-posts') }}" class="btn">Review Post →</a>
</div>
<div class="footer">Ananth Decodes Logistics — Admin Notification</div>
</div></body></html>
