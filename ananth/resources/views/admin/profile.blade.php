<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>My Profile</title>
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

            @if ($errors->any())
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <div class="outer_wrapper mt-3">
                <div class="wrapper_head">
                    <h3>Update Profile</h3>
                </div>
                <div class="wrapper_body">
                    <form class="form_input" action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3" style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
                                    <img
                                        src="{{ $user->profile_pic ? asset('img/site/' . $user->profile_pic) : asset('img/blank-picture.webp') }}"
                                        alt="{{ $user->name }}"
                                        style="width:84px;height:84px;border-radius:50%;object-fit:cover;border:1px solid #d7deea;"
                                    >
                                    <div>
                                        <h4 style="margin-bottom:6px;">{{ $user->name }}</h4>
                                        <p style="margin:0;color:#64748b;">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h4>Name</h4>
                                <input name="name" maxlength="255" type="text" value="{{ old('name', $user->name) }}" placeholder="Enter your name" required>
                            </div>

                            <div class="col-md-6">
                                <h4>Email</h4>
                                <input name="email" maxlength="255" type="email" value="{{ old('email', $user->email) }}" placeholder="Enter your email" required>
                            </div>

                            <div class="col-md-6">
                                <h4>Designation</h4>
                                <input name="designation" maxlength="255" type="text" value="{{ old('designation', $user->designation) }}" placeholder="Enter your designation">
                            </div>

                            <div class="col-md-6">
                                <h4>Profile Picture</h4>
                                <input name="profile_pic" type="file" accept="image/jpeg,image/png,image/webp">
                            </div>

                            <div class="col-md-6">
                                <h4>LinkedIn URL</h4>
                                <input name="linkedin" type="url" value="{{ old('linkedin', $user->linkedin) }}" placeholder="Enter LinkedIn profile URL">
                            </div>

                            <div class="col-md-6">
                                <h4>Instagram URL</h4>
                                <input name="insta" type="url" value="{{ old('insta', $user->insta) }}" placeholder="Enter Instagram profile URL">
                            </div>

                            <div class="col-md-6">
                                <h4>Twitter URL</h4>
                                <input name="twitter" type="url" value="{{ old('twitter', $user->twitter) }}" placeholder="Enter Twitter profile URL">
                            </div>

                            <div class="col-md-12">
                                <h4>Bio</h4>
                                <textarea name="intro" placeholder="Write a short bio...">{{ old('intro', $user->intro) }}</textarea>
                            </div>

                            <div class="col-md-4">
                                <h4>Current Password</h4>
                                <input name="current_password" type="password" placeholder="Required to change password">
                            </div>

                            <div class="col-md-4">
                                <h4>New Password</h4>
                                <input name="password" type="password" placeholder="Leave blank to keep current password">
                            </div>

                            <div class="col-md-4">
                                <h4>Confirm Password</h4>
                                <input name="password_confirmation" type="password" placeholder="Confirm new password">
                            </div>
                        </div>

                        <button type="submit">Save Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @include('admin.adminFooter')
</body>

</html>
