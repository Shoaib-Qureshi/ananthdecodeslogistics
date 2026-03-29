<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Add Book Review</title>
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
                    <h3>Add Book Review</h3>
                </div>
                <div class="wrapper_body">
                    <form class="form_input" action="{{ url('admin/update/book-review/' . $editBook->id) }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Name</h4>
                                <input value="{{ $editBook->name }}" name="name" type="text"
                                    placeholder="e.g. Rich Dad, Poor Dad" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Slug</h4>
                                <input value="{{ $editBook->slug }}" name="slug" type="text"
                                    placeholder="e.g. rich-dad-poor-dad" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Cover (Optional)</h4>
                                <input name="cover" type="file" accept="image/png, image/jpeg, imahe/webp">
                            </div>
                            <div class="col-md-6">
                                <h4>Author</h4>
                                <input value="{{ $editBook->author }}" name="author" type="text"
                                    placeholder="e.g. Rober Kiyosaki" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Genre</h4>
                                <input value="{{ $editBook->genre }}" name="genre" type="text"
                                    placeholder="e.g. Crime Thriller" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Publish Date</h4>
                                <input value="{{ $editBook->published }}" name="published" type="text"
                                    placeholder="e.g. 1 Jul, 2005" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Buy Link</h4>
                                <input value="{{ $editBook->buy_link }}" name="buy_link" type="url" placeholder="Buy Link">
                            </div>
                            <div class="col-md-6">
                                <h4>Status</h4>
                                <select name="status">
                                    @if ($editBook->status == 1)
                                        <option value="1">Live</option>
                                        <option value="0">Draft</option>
                                    @else
                                        <option value="0">Draft</option>
                                        <option value="1">Live</option>
                                    @endif
                                </select>
                            </div>
                            <div class="col-md-12 mb-3">
                                <h4>Short Description</h4>
                                <input value="{{ $editBook->short_description }}" name="short_description"
                                    type="text" placeholder="Book Name" required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <h4>Detailed Review</h4>
                                <textarea name="detail_review" id="ckeditor">{{ $editBook->detail_review }}</textarea>
                            </div>
                        </div>
                        <button type="submit">Update Book Review</button>
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
