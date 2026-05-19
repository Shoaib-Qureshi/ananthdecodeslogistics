<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Manage Gallery</title>
    <style>
        .gallery-admin-hero{display:flex;align-items:flex-start;justify-content:space-between;gap:20px;margin:18px 0 22px;padding:22px 24px;border:1px solid #d8e3f0;border-radius:18px;background:linear-gradient(135deg,#fff,#f8fbff);box-shadow:0 18px 50px rgba(15,23,42,.06)}
        .gallery-admin-hero h2{margin:0;color:#0f172a;font-size:1.65rem;font-weight:800}
        .gallery-admin-hero p{margin:8px 0 0;color:#64748b;line-height:1.6}
        .gallery-admin-btn{display:inline-flex;align-items:center;justify-content:center;border:1px solid #d8e3f0;border-radius:40px;background:#fff;color:#475569;padding:10px 14px;font-size:.84rem;font-weight:800;text-decoration:none}
        .gallery-admin-btn.primary{border-color:#2562E9;background:#2562E9;color:#fff}
        .gallery-admin-btn.danger{color:#dc2626}
        .gallery-admin-card{border:1px solid #d8e3f0;border-radius:18px;background:#fff;padding:20px;margin-bottom:18px;box-shadow:0 14px 40px rgba(15,23,42,.05)}
        .gallery-admin-card h3{margin:0 0 16px;color:#0f172a;font-size:1.1rem;font-weight:800}
        .gallery-admin-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:16px}
        .gallery-admin-card label{display:block;margin-bottom:12px;color:#0f172a;font-weight:700}
        .gallery-admin-card input,.gallery-admin-card textarea{width:100%;box-sizing:border-box;border:1px solid #d8e3f0;border-radius:14px;padding:11px 13px;margin-top:6px}
        .gallery-admin-card textarea{min-height:95px;resize:vertical}
        .gallery-settings{display:flex;align-items:flex-start;justify-content:space-between;gap:18px}
        .gallery-settings p{margin:6px 0 0;color:#64748b;line-height:1.6}
        .gallery-list{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:18px}
        .gallery-item{overflow:hidden;border:1px solid #d8e3f0;border-radius:18px;background:#fff;box-shadow:0 14px 40px rgba(15,23,42,.05)}
        .gallery-item__media{aspect-ratio:16/9;background:#eaf3fb}
        .gallery-item__media img{width:100%;height:100%;object-fit:cover;display:block}
        .gallery-item__body{padding:16px}
        .visible-toggle{display:inline-flex!important;align-items:center;gap:8px;margin:0 0 12px!important;white-space:nowrap}
        .visible-toggle input{width:auto;margin:0}
        .gallery-actions{display:flex;gap:10px;align-items:center;flex-wrap:wrap}
        @media(max-width:1000px){.gallery-admin-grid,.gallery-list{grid-template-columns:1fr}.gallery-admin-hero,.gallery-settings{display:block}.gallery-admin-hero .gallery-admin-btn,.gallery-settings .gallery-admin-btn{margin-top:14px}}
    </style>
</head>
<body>
@include('admin.adminHeader')
<section class="main_section">
    <div class="container-fluid">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

        <div class="gallery-admin-hero">
            <div>
                <h2>Manage Gallery</h2>
                <p>Add, edit, hide, reorder, or remove images shown on the public gallery page.</p>
            </div>
            <a class="gallery-admin-btn" href="{{ route('gallery') }}" target="_blank">View Gallery</a>
        </div>

        <div class="gallery-admin-card">
            <form class="gallery-settings" method="POST" action="{{ route('admin.gallery.settings') }}">
                @csrf
                <div>
                    <h3>Frontend Visibility</h3>
                    <label class="visible-toggle">
                        <input type="checkbox" name="hide_gallery_page" value="1" {{ !($site->gallery_page_visible ?? true) ? 'checked' : '' }}>
                        Hide gallery page and show Coming Soon
                    </label>
                    <p>When checked, Gallery is removed from the frontend menu and footer. Visiting the URL directly shows a Coming Soon page.</p>
                </div>
                <button class="gallery-admin-btn primary" type="submit">Save Visibility</button>
            </form>
        </div>

        <div class="gallery-admin-card">
            <h3>Add Gallery Image</h3>
            <form method="POST" action="{{ route('admin.gallery.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="gallery-admin-grid">
                    <label>Title <input name="title" value="{{ old('title') }}" required></label>
                    <label>Category <input name="category" value="{{ old('category') }}" placeholder="Event, Boardroom, Logistics"></label>
                    <label>Sort Order <input type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}"></label>
                </div>
                <label>Caption <textarea name="caption">{{ old('caption') }}</textarea></label>
                <label>Image <input type="file" name="image" accept="image/*" required></label>
                <label class="visible-toggle"><input type="checkbox" name="visible" value="1" checked> Visible</label>
                <button class="gallery-admin-btn primary" type="submit">Add Image</button>
            </form>
        </div>

        <div class="gallery-list">
            @forelse($images as $image)
                <article class="gallery-item">
                    <div class="gallery-item__media">
                        <img src="{{ $image->imageUrl() }}" alt="{{ $image->title }}">
                    </div>
                    <div class="gallery-item__body">
                        <form method="POST" action="{{ route('admin.gallery.update', $image) }}" enctype="multipart/form-data">
                            @csrf
                            <div class="gallery-admin-grid">
                                <label>Title <input name="title" value="{{ $image->title }}" required></label>
                                <label>Category <input name="category" value="{{ $image->category }}"></label>
                                <label>Sort Order <input type="number" min="0" name="sort_order" value="{{ $image->sort_order }}"></label>
                            </div>
                            <label>Caption <textarea name="caption">{{ $image->caption }}</textarea></label>
                            <label>Replace Image <input type="file" name="image" accept="image/*"></label>
                            <label class="visible-toggle"><input type="checkbox" name="visible" value="1" {{ $image->visible ? 'checked' : '' }}> Visible</label>
                        </form>
                        <div class="gallery-actions">
                            <button class="gallery-admin-btn primary" type="button" onclick="this.closest('.gallery-item__body').querySelector('form').submit()">Update</button>
                            <form method="POST" action="{{ route('admin.gallery.destroy', $image) }}" onsubmit="return confirm('Remove this gallery image?')">
                                @csrf
                                <button class="gallery-admin-btn danger" type="submit">Remove</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <div class="gallery-admin-card">
                    <h3>No gallery images yet.</h3>
                    <p>Add the first image above. Until then, the public gallery shows a Coming Soon message.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
@include('admin.adminFooter')
</body>
</html>
