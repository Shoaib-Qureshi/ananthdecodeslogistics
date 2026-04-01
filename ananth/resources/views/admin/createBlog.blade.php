<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Create Blog</title>
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
                    <h3>Create Blog</h3>
                </div>
                <div class="wrapper_body">
                    <form class="form_input" action="{{ route('saveBlog') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <h4>Select Author</h4>
                                <select name="user_id" required>
                                    <option selected disabled value="">Select Author</option>
                                    @foreach ($users as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-12">
                                <h4>Title</h4>
                                <input name="title" type="text" placeholder="Write Post Title" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Category</h4>
                                <select name="category_id" required>
                                    <option selected disabled value="">Select Category</option>
                                    @foreach ($category as $item)
                                        <option value="{{ $item->id }}">{{ $item->category_name ?? $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <h4>Thumbnail</h4>
                                <input name="thumbnail" type="file" accept="image/png, image/jpeg, imahe/webp"
                                    required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <h4>Content</h4>
                                <textarea name="content" id="ckeditor"></textarea>
                            </div>
                            <div class="col-md-4">
                                <h4>Status</h4>
                                <select name="status" required>
                                    <option value="1" selected>Live</option>
                                    <option value="0">Draft</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <h4>Visibility</h4>
                                <select name="visibility" required>
                                    <option value="public" selected>Visible</option>
                                    <option value="private">Hidden</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <hr>
                                <h4>SEO Meta Title</h4>
                                <input name="meta_title" type="text" placeholder="Optional SEO title">
                            </div>
                            <div class="col-md-12">
                                <h4>SEO Meta Description</h4>
                                <textarea name="meta_description" rows="3" placeholder="Optional SEO meta description"></textarea>
                            </div>
                            <div class="col-md-12">
                                <h4>SEO Keywords</h4>
                                <textarea name="meta_keywords" rows="2" placeholder="keyword 1, keyword 2, keyword 3"></textarea>
                            </div>
                            <div class="col-md-4">
                                <h4>Canonical URL</h4>
                                <input name="canonical_url" type="text" placeholder="https://example.com/blog/post">
                            </div>
                            <div class="col-md-4">
                                <h4>OG Image Path</h4>
                                <input name="og_image" type="text" placeholder="media/custom-og-image.webp">
                            </div>
                            <div class="col-md-2">
                                <h4>Robots Index</h4>
                                <select name="robots_index">
                                    <option value="1" selected>Index</option>
                                    <option value="0">No Index</option>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <h4>Robots Follow</h4>
                                <select name="robots_follow">
                                    <option value="1" selected>Follow</option>
                                    <option value="0">No Follow</option>
                                </select>
                            </div>
                            <div class="col-md-12">
                                <h4>Schema JSON-LD</h4>
                                <textarea name="schema_json_ld" rows="6" placeholder='{"@context":"https://schema.org"}'></textarea>
                            </div>
                        </div>
                        <button type="submit">Publish Post</button>
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
