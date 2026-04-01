@extends('layouts.dashboard')
@section('title', 'Edit Post')
@section('page-title', 'Edit Post')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor { min-height: 340px; font-size: .9rem; line-height: 1.7; font-family: 'Inter', sans-serif; }
    .ql-toolbar.ql-snow { border-radius: 8px 8px 0 0; border-color: #e2e8f0; background: #f8fafc; }
    .ql-container.ql-snow { border-radius: 0 0 8px 8px; border-color: #e2e8f0; }
    .form-section {
        background: #fff;
        border-radius: 12px;
        border: 1px solid #e8edf5;
        padding: 1.75rem;
        margin-bottom: 1.25rem;
    }
    .form-section-title {
        font-size: .78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: #94a3b8;
        margin-bottom: 1.1rem;
        padding-bottom: .65rem;
        border-bottom: 1px solid #f1f5f9;
    }
    .form-label { font-weight: 600; font-size: .855rem; color: #334155; margin-bottom: .4rem; }
    .form-control, .form-select {
        border-radius: 8px;
        border: 1.5px solid #e2e8f0;
        padding: .6rem .9rem;
        font-size: .9rem;
        transition: border-color .15s, box-shadow .15s;
    }
    .form-control-lg { font-size: 1rem; padding: .7rem 1rem; }
    .form-control:focus, .form-select:focus {
        border-color: #3882fa;
        box-shadow: 0 0 0 3px rgba(56,130,250,.1);
    }
    .rejection-banner {
        background: #fef2f2;
        border: 1px solid #fecaca;
        border-left: 4px solid #ef4444;
        border-radius: 12px;
        padding: 1.1rem 1.4rem;
        margin-bottom: 1.25rem;
    }
    .rejection-banner .label {
        font-size: .72rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .07em;
        color: #ef4444;
        margin-bottom: .4rem;
        display: flex;
        align-items: center;
        gap: .35rem;
    }
    .rejection-banner .reason {
        color: #7f1d1d;
        font-size: .88rem;
        line-height: 1.6;
        margin: 0;
    }
</style>
@endsection

@section('content')
<div class="row g-4">

    <div class="col-lg-8">

        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('dashboard.posts') }}" style="color:#64748b;text-decoration:none;font-size:.83rem;display:flex;align-items:center;gap:.3rem;">
                <i class="bi bi-arrow-left"></i> Back to posts
            </a>
        </div>

        @if($post->rejection_reason)
        <div class="rejection-banner">
            <div class="label">
                <i class="bi bi-x-circle-fill"></i> Feedback from editorial team
            </div>
            <p class="reason">{{ $post->rejection_reason }}</p>
        </div>
        @endif

        <form method="POST" action="{{ route('dashboard.posts.update', $post->id) }}" enctype="multipart/form-data" id="editForm">
            @csrf

            <div class="form-section">
                <p class="form-section-title">Post Details</p>
                <div class="mb-3">
                    <label class="form-label">Post Title <span class="text-danger">*</span></label>
                    <input type="text" name="title"
                           class="form-control form-control-lg @error('title') is-invalid @enderror"
                           value="{{ old('title', $post->title) }}" required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label">Category</label>
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        <input type="text" class="form-control" value="{{ $category->category_name ?? $category->name }}" readonly>
                        <div class="form-text" style="font-size:.77rem;">Contributor posts always stay in Transport &amp; Logistics.</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Featured Image</label>
                        @if(!$post->featured_image)
                            <div class="mb-2" style="position:relative;">
                                <img src="{{ $post->featured_image_url }}"
                                     style="width:100%;height:90px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0;">
                                <small class="d-block text-muted mt-1" style="font-size:.75rem;">Default contributor image will be used unless you upload one below</small>
                            </div>
                        @endif
                        @if($post->featured_image)
                            <div class="mb-2" style="position:relative;">
                                <img src="{{ asset('storage/posts/' . $post->featured_image) }}"
                                     style="width:100%;height:90px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0;">
                                <small class="d-block text-muted mt-1" style="font-size:.75rem;">Current image — upload below to replace</small>
                            </div>
                        @endif
                        <input type="file" name="featured_image"
                               class="form-control @error('featured_image') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/webp">
                        <div class="form-text" style="font-size:.77rem;">JPEG, PNG, or WEBP · Max 3MB</div>
                        @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>

            <div class="form-section">
                <p class="form-section-title">Content</p>
                <div id="editor">{!! old('body', $post->body) !!}</div>
                <input type="hidden" name="body" id="bodyInput">
                @error('body')
                    <div class="text-danger mt-1" style="font-size:.82rem;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
            </div>

            <div class="d-flex gap-3">
                <button type="submit" class="btn-write px-4 py-2" style="font-size:.9rem;">
                    <i class="bi bi-send"></i> Save Changes & Resubmit
                </button>
                <a href="{{ route('dashboard.posts') }}" class="btn btn-outline-secondary" style="border-radius:8px;font-size:.9rem;">Cancel</a>
            </div>

        </form>
    </div>

    <div class="col-lg-4">
        <div style="position:sticky;top:80px;">

            <div style="background:#fff;border-radius:10px;border:1px solid #e8edf5;padding:1.1rem;font-size:.8rem;color:#475569;margin-bottom:1rem;">
                <p style="font-weight:700;color:#334155;margin-bottom:.6rem;font-size:.82rem;">
                    <i class="bi bi-info-circle me-1" style="color:#3882fa;"></i> What to do
                </p>
                <ol style="padding-left:1.15rem;margin:0;line-height:1.8;">
                    <li>Update the title, content, or image as needed</li>
                    <li>Save your changes when you're ready</li>
                    <li>The post will go back into the admin approval queue</li>
                </ol>
            </div>

            <div style="background:#f0fdf4;border:1px solid #bbf7d0;border-radius:10px;padding:1rem 1.1rem;font-size:.8rem;color:#166534;">
                <p style="font-weight:700;margin-bottom:.35rem;font-size:.82rem;">
                    <i class="bi bi-check-circle me-1"></i> Post info
                </p>
                <div style="color:#4ade80;opacity:.7;font-size:.75rem;line-height:1.7;">
                    Originally submitted: {{ $post->created_at->format('d M Y') }}<br>
                    Status: <strong>{{ ucfirst($post->status) }}</strong>
                </div>
            </div>

        </div>
    </div>

</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.js"></script>
<script>
    const quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                [{ header: [2, 3, false] }],
                ['bold', 'italic', 'underline'],
                ['link', 'blockquote'],
                [{ list: 'ordered' }, { list: 'bullet' }],
                ['clean']
            ]
        }
    });

    document.getElementById('editForm').addEventListener('submit', function () {
        document.getElementById('bodyInput').value = quill.root.innerHTML;
    });
</script>
@endsection
