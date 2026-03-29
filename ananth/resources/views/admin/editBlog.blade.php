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
