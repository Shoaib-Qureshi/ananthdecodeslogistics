<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Update Author</title>
</head>

<body>
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
                    <h3>Update Author</h3>
                </div>
                <div class="wrapper_body">
                    <form class="form_input" action="{{ url('admin/update/user/' . $editUser->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Name</h4>
                                <input name="name" maxlength="30" type="text" value="{{ $editUser->name }}"
                                    placeholder="e.g. M.S. Dhoni" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Designation</h4>
                                <input value="{{ $editUser->designation }}" name="designation" type="text"
                                    placeholder="e.g. Engineer" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Content Role</h4>
                                <select name="account_type" required>
                                    <option value="author" {{ $editUser->user_role !== 'guest' ? 'selected' : '' }}>Author</option>
                                    <option value="contributor" {{ $editUser->user_role === 'guest' ? 'selected' : '' }}>Contributor</option>
                                </select>
                                <div class="form-text" style="font-size:.78rem;margin-top:-10px;margin-bottom:14px;">
                                    Changing this user to Contributor will move their authored blogs into the contributor posts tab.
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h4>Profile Picture (Optional)</h4>
                                <input name="profile_pic" type="file">
                            </div>
                            <div class="col-md-6">
                                <h4>LinkedIn URL</h4>
                                <input value="{{ $editUser->linkedin }}" name="linkedin" type="url"
                                    placeholder="Enter LinkedIn Profile URL">
                            </div>
                            <div class="col-md-6">
                                <h4>Instagram URL</h4>
                                <input value="{{ $editUser->insta }}" name="insta" type="url"
                                    placeholder="Enter Instagram Profile URL">
                            </div>
                            <div class="col-md-6">
                                <h4>Twitter URL</h4>
                                <input value="{{ $editUser->twitter }}" name="twitter" type="url"
                                    placeholder="Enter Twitter Profile URL">
                            </div>
                            <div class="col-md-12">
                                <h4>Auhor Bio</h4>
                                <textarea name="intro" placeholder="Type author bio...">{{ $editUser->intro }}</textarea>
                            </div>
                        </div>
                        <button type="submit">Update Author</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @include('admin.adminFooter')
</body>

</html>
