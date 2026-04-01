<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Edit Blog</title>
</head>

<body>
    <style>
        .ck-editor__editable {
            min-height: 250px;
        }
    </style>
    @include('admin.adminHeader')
    <section class="main_section">
        <div class="container-fluid">
            @if (session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            @if (session()->has('errors'))
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="outer_wrapper mt-3">
                <div class="wrapper_head">
                    <h3>Edit Blog</h3>
                </div>
                <div class="wrapper_body">
                    <form class="form_input" action="{{ url('admin/update/blog/' . $editBlog->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <h4>Author</h4>
                                <select name="user_id" required>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $editBlog->user_id ? 'selected' : '' }}>{{ $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <h4>Title</h4>
                                <input name="title" value="{{ $editBlog->title }}" type="text" required>
                            </div>
                            <div class="col-md-12">
                                <h4>Slug</h4>
                                <input name="slug" value="{{ $editBlog->slug }}" type="text" required>
                            </div>
                            <div class="col-md-3">
                                <h4>Category</h4>
                                <select name="category_id" required>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $editBlog->category_id ? 'selected' : '' }}>
                                            {{ $item->category_name ?? $item->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <h4>Status</h4>
                                <select name="status">
                                    @if ($editBlog->status == 1)
                                        <option value="1">Live</option>
                                        <option value="0">Draft</option>
                                    @else
                                        <option value="0">Draft</option>
                                        <option value="1">Live</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <h4>Visibility</h4>
                                <select name="visibility">
                                    @if ($editBlog->visibility == 1)
                                        <option value="1">Visible</option>
                                        <option value="0">Hidden</option>
                                    @else
                                        <option value="0">Hidden</option>
                                        <option value="1">Visible</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-3">
                                <h4>Thumbnail (Optional)</h4>
                                <input name="thumbnail" type="file" accept="image/png, image/jpeg">
                            </div>
                            <div class="col-md-12 mb-3">
                                <h4>Content</h4>
                                <textarea name="content" id="ckeditor">{{ $editBlog->content }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <h4>Status</h4>
                                <select name="status">
                                    <option value="1" {{ $editBlog->status == 1 ? 'selected' : '' }}>Live</option>
                                    <option value="0" {{ $editBlog->status == 0 ? 'selected' : '' }}>Draft</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <h4>Visibility</h4>
                                <select name="visibility">
                                    <option value="public" {{ $editBlog->visibility == 'public' ? 'selected' : '' }}>Visible</option>
                                    <option value="private" {{ $editBlog->visibility == 'private' ? 'selected' : '' }}>Hidden</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <hr>
                                <h4>SEO Meta Title</h4>
                                <input name="meta_title" value="{{ old('meta_title', $editBlog->meta_title) }}" type="text" placeholder="Optional SEO title">
                            </div>
                            <div class="col-md-12">
                                <h4>SEO Meta Description</h4>
                                <textarea name="meta_description" rows="3" placeholder="Optional SEO meta description">{{ old('meta_description', $editBlog->meta_description) }}</textarea>
                            </div>
                            <div class="col-md-12">
                                <h4>SEO Keywords</h4>
                                <textarea name="meta_keywords" rows="2" placeholder="keyword 1, keyword 2, keyword 3">{{ old('meta_keywords', $editBlog->meta_keywords) }}</textarea>
                            </div>
                            <div class="col-md-4">
                                <h4>Canonical URL</h4>
                                <input name="canonical_url" value="{{ old('canonical_url', $editBlog->canonical_url) }}" type="text" placeholder="https://example.com/blog/post">
                            </div>
                            <div class="col-md-4">
                                <h4>OG Image Path</h4>
                                <input name="og_image" value="{{ old('og_image', $editBlog->og_image) }}" type="text" placeholder="media/custom-og-image.webp">
                            </div>
                            <div class="col-md-2">
                                <h4>Robots Index</h4>
                                <select name="robots_index">
                                    <option value="1" {{ old('robots_index', $editBlog->robots_index ?? 1) == 1 ? 'selected' : '' }}>Index</option>
                                    <option value="0" {{ old('robots_index', $editBlog->robots_index ?? 1) == 0 ? 'selected' : '' }}>No Index</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <h4>Robots Follow</h4>
                                <select name="robots_follow">
                                    <option value="1" {{ old('robots_follow', $editBlog->robots_follow ?? 1) == 1 ? 'selected' : '' }}>Follow</option>
                                    <option value="0" {{ old('robots_follow', $editBlog->robots_follow ?? 1) == 0 ? 'selected' : '' }}>No Follow</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <h4>Schema JSON-LD</h4>
                                <textarea name="schema_json_ld" rows="6" placeholder='{"@context":"https://schema.org"}'>{{ old('schema_json_ld', $editBlog->schema_json_ld) }}</textarea>
                            </div>
                        </div>
                        <button type="submit">Update Post</button>
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
            }, {
                alignment: {
                    options: ['right', 'right']
                }
            })
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
</body>

</html>
