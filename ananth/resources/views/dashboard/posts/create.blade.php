@extends('layouts.dashboard')
@section('title', 'New Post')
@section('page-title', 'New Post')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/quill@2.0.2/dist/quill.snow.css" rel="stylesheet">
<style>
    .ql-editor { min-height: 340px; font-size: .9rem; line-height: 1.7; font-family: 'Inter', sans-serif; }
    .ql-toolbar.ql-snow { border-radius: 8px 8px 0 0; border-color: #e2e8f0; background: #f8fafc; }
    .ql-container.ql-snow { border-radius: 0 0 8px 8px; border-color: #e2e8f0; }
    .ql-container.ql-snow:focus-within { border-color: #3882fa; }
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
    .tip-card {
        background: #f0f7ff;
        border: 1px solid #bfdbfe;
        border-radius: 10px;
        padding: 1rem 1.1rem;
        font-size: .8rem;
        color: #1e40af;
    }
    .tip-card ul { margin: .5rem 0 0; padding-left: 1.2rem; }
    .tip-card li { margin-bottom: .3rem; line-height: 1.5; }
    .char-counter { font-size: .75rem; color: #94a3b8; text-align: right; margin-top: .25rem; }
</style>
@endsection

@section('content')
<div class="row g-4">

    {{-- Main Form --}}
    <div class="col-lg-8">

        <div class="d-flex align-items-center gap-2 mb-3">
            <a href="{{ route('dashboard.posts') }}" style="color:#64748b;text-decoration:none;font-size:.83rem;display:flex;align-items:center;gap:.3rem;">
                <i class="bi bi-arrow-left"></i> Back
            </a>
        </div>

        <form method="POST" action="{{ route('dashboard.posts.store') }}" enctype="multipart/form-data" id="postForm">
            @csrf

            {{-- Title --}}
            <div class="form-section">
                <p class="form-section-title">Post Details</p>
                <div class="mb-3">
                    <label class="form-label">Post Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" id="titleInput"
                           class="form-control form-control-lg @error('title') is-invalid @enderror"
                           value="{{ old('title') }}"
                           placeholder="Write a clear, descriptive title..." required>
                    @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="char-counter"><span id="titleCount">0</span> / 120</div>
                </div>

                <div class="row g-3">
                    <div class="col-sm-6">
                        <label class="form-label">Category</label>
                        <input type="hidden" name="category_id" value="{{ $category->id }}">
                        <input type="text" class="form-control" value="{{ $category->category_name ?? $category->name }}" readonly>
                        <div class="form-text" style="font-size:.77rem;">Contributor posts are published under Transport &amp; Logistics.</div>
                    </div>
                    <div class="col-sm-6">
                        <label class="form-label">Featured Image</label>
                        <div id="defaultImgPreview" style="margin:.35rem 0 .5rem;">
                            <img src="{{ asset('img/thumbnail/Default_Contributor_img.webp') }}" style="width:100%;max-height:140px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0;">
                            <small class="d-block text-muted mt-1" style="font-size:.75rem;">This default contributor image will be used if you do not upload one.</small>
                        </div>
                        <input type="file" name="featured_image"
                               class="form-control @error('featured_image') is-invalid @enderror"
                               accept="image/jpeg,image/png,image/webp"
                               id="imgInput"
                               onchange="previewImage(this)">
                        <div class="form-text" style="font-size:.77rem;">JPEG, PNG, or WEBP · Max 3MB</div>
                        @error('featured_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div id="imgPreview" style="display:none;margin-top:.5rem;">
                            <img id="previewImg" style="width:100%;max-height:140px;object-fit:cover;border-radius:6px;border:1px solid #e2e8f0;">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Content Editor --}}
            <div class="form-section">
                <p class="form-section-title">Content</p>
                <div id="editor">{!! old('body') !!}</div>
                <input type="hidden" name="body" id="bodyInput">
                @error('body')
                    <div class="text-danger mt-1" style="font-size:.82rem;"><i class="bi bi-exclamation-circle me-1"></i>{{ $message }}</div>
                @enderror
                <div class="form-text mt-2" style="font-size:.77rem;">Minimum 100 characters. Every submission goes through admin approval before it appears live.</div>
            </div>

            <div class="form-section">
                @include('partials.faq-editor', [
                    'instance' => 'contributor-post-create',
                    'faqEnabled' => old('has_faqs', false),
                    'faqItems' => old('faq_items', []),
                ])
            </div>

            {{-- Actions --}}
            <div class="d-flex gap-3">
                <button type="submit" class="btn-write px-4 py-2" style="font-size:.9rem;">
                    <i class="bi bi-send"></i> Submit for Review
                </button>
                <a href="{{ route('dashboard.posts') }}" class="btn btn-outline-secondary" style="border-radius:8px;font-size:.9rem;">Cancel</a>
            </div>

        </form>
    </div>

    {{-- Sidebar Tips --}}
    <div class="col-lg-4">
        <div style="position:sticky;top:80px;">

            <div class="tip-card mb-3">
                <p style="font-weight:700;margin-bottom:0;font-size:.82rem;">
                    <i class="bi bi-lightbulb me-1"></i> Writing Tips
                </p>
                <ul>
                    <li>Use a clear, specific title that includes key logistics terms</li>
                    <li>Start with a hook — a surprising stat or real problem</li>
                    <li>Use headers (H2/H3) to break up long sections</li>
                    <li>Include practical takeaways for professionals</li>
                    <li>Aim for 600–1500 words for best engagement</li>
                </ul>
            </div>

            <div style="background:#fff;border-radius:10px;border:1px solid #e8edf5;padding:1rem 1.1rem;font-size:.8rem;color:#475569;">
                <p style="font-weight:700;color:#334155;margin-bottom:.5rem;">
                    <i class="bi bi-info-circle me-1" style="color:#3882fa;"></i> Review Process
                </p>
                <p style="margin-bottom:.4rem;line-height:1.6;">After submission, our editorial team reviews your post within <strong>48 hours</strong>.</p>
                <p style="margin:0;line-height:1.6;">If you edit a published post later, it returns to the approval queue before going live again.</p>
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
        placeholder: 'Start writing your article...',
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

    document.getElementById('postForm').addEventListener('submit', function () {
        document.getElementById('bodyInput').value = quill.root.innerHTML;
    });

    // Title char counter
    const titleInput = document.getElementById('titleInput');
    const titleCount = document.getElementById('titleCount');
    function updateCount() {
        titleCount.textContent = titleInput.value.length;
        titleCount.style.color = titleInput.value.length > 110 ? '#ef4444' : '#94a3b8';
    }
    titleInput.addEventListener('input', updateCount);
    updateCount();

    // Image preview
    function previewImage(input) {
        const preview = document.getElementById('imgPreview');
        const img = document.getElementById('previewImg');
        const defaultPreview = document.getElementById('defaultImgPreview');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = e => {
                img.src = e.target.result;
                preview.style.display = 'block';
                if (defaultPreview) {
                    defaultPreview.style.display = 'none';
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection
