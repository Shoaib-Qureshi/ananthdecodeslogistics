<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Edit Contributor Post</title>
</head>

<body>
    <style>
        .ck-editor__editable {
            min-height: 280px;
        }
    </style>
    @include('admin.adminHeader')
    <section class="main_section">
        <div class="container-fluid">
            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="outer_wrapper mt-3">
                <div class="wrapper_head">
                    <h3>Edit Contributor Post</h3>
                </div>
                <div class="wrapper_body">
                    <form class="form_input" action="{{ route('admin.contributor.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Contributor</h4>
                                <input type="text" value="{{ $post->author->name }}{{ $post->author->designation ? ' — ' . $post->author->designation : '' }}" readonly>
                            </div>
                            <div class="col-md-6">
                                <h4>Category</h4>
                                <input type="text" value="{{ $category->category_name ?? $category->name }}" readonly>
                            </div>
                            <div class="col-md-12">
                                <h4>Title</h4>
                                <input name="title" value="{{ old('title', $post->title) }}" type="text" required>
                            </div>
                            <div class="col-md-12">
                                <h4>Slug</h4>
                                <input name="slug" value="{{ old('slug', $post->slug) }}" type="text" required>
                            </div>
                            <div class="col-md-4">
                                <h4>Status</h4>
                                <select name="status" required>
                                    <option value="pending" {{ old('status', $post->status) === 'pending' ? 'selected' : '' }}>Pending Review</option>
                                    <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="rejected" {{ old('status', $post->status) === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <div class="col-md-8">
                                <h4>Featured Image (Optional)</h4>
                                <input name="featured_image" type="file" accept="image/png, image/jpeg, image/webp">
                            </div>
                            <div class="col-md-12">
                                <h4>Rejection Reason</h4>
                                <textarea name="rejection_reason" rows="3" placeholder="Only needed if the post is being rejected.">{{ old('rejection_reason', $post->rejection_reason) }}</textarea>
                            </div>
                            <div class="col-md-12 mb-3">
                                <h4>Content</h4>
                                <textarea name="body" id="ckeditor">{{ old('body', $post->body) }}</textarea>
                            </div>
                        </div>
                        <button type="submit">Update Contributor Post</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @include('admin.adminFooter')
    <script src="/js/ckeditor.js"></script>
    <script>
        ClassicEditor
            .create(document.querySelector('#ckeditor'), {
                ckfinder: {
                    uploadUrl: "{{ '/admin/image_upload?_token=' . csrf_token() }}"
                }
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>
