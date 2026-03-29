<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Edit Member</title>
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
                    <h3>Edit Member</h3>
                </div>
                <div class="wrapper_body">
                    <form class="form_input" action="{{ url('admin/update-member/' . $editMember->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Name</h4>
                                <input name="name" type="text" placeholder="e.g. M.S. Dhoni"
                                    value="{{ $editMember->name }}" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Thumbnail (Optional)</h4>
                                <input name="image" type="file" accept="image/png, image/jpeg, imahe/webp">
                            </div>
                            <div class="col-md-6">
                                <h4>Designation</h4>
                                <input name="designation" value="{{ $editMember->designation }}" type="text"
                                    placeholder="e.g. Co-Founder & CMO at XYZ Firm" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Instagram URL</h4>
                                <input name="insta" value="{{ $editMember->insta }}" type="url"
                                    placeholder="Instagram URL">
                            </div>
                            <div class="col-md-6">
                                <h4>LinkedIn URL</h4>
                                <input name="linkedin" value="{{ $editMember->linkedin }}" type="url"
                                    placeholder="LinkedIn Profile URL">
                            </div>
                            <div class="col-md-6">
                                <h4>Twitter URL</h4>
                                <input name="twitter" value="{{ $editMember->twitter }}" type="url"
                                    placeholder="Twitter URL">
                            </div>
                            <div class="col-md-6">
                                <h4>Position</h4>
                                <input name="position" value="{{ $editMember->position }}" type="number"
                                    placeholder="e.g. 10" required>
                            </div>
                        </div>
                        <button type="submit">Update Member</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @include('admin.adminFooter')
</body>

</html>
