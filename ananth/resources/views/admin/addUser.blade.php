<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Add Author</title>
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
                    <h3>Add Author</h3>
                </div>
                <div class="wrapper_body">
                    <form class="form_input" action="{{ route('saveUser') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Name</h4>
                                <input name="name" type="text" placeholder="e.g. Mark" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Email <small style="font-weight:400;color:#6b7280;">(required for contributors — welcome email will be sent)</small></h4>
                                <input name="email" type="email" placeholder="e.g. mark@example.com" value="{{ old('email') }}">
                            </div>
                            <div class="col-md-6">
                                <h4>Designation</h4>
                                <input name="designation" type="text" placeholder="e.g. Engineer" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Content Role</h4>
                                <select name="account_type" required>
                                    <option value="author">Author</option>
                                    <option value="contributor">Contributor</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <h4>Contributor Plan</h4>
                                <select name="contributor_plan">
                                    @foreach($contributorPlans as $plan)
                                        <option value="{{ $plan['code'] }}" {{ $plan['code'] === \App\Support\ContributorPlans::FREE ? 'selected' : '' }}>
                                            {{ $plan['admin_name'] }}{{ $plan['code'] !== 'free' ? ' - ' . $plan['price_label'] : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <h4>Profile Picture</h4>
                                <input name="profile_pic" type="file" required>
                            </div>
                            <div class="col-md-6">
                                <h4>LinkedIn URL</h4>
                                <input name="linkedin" type="url" placeholder="Enter LinkedIn Profile URL">
                            </div>
                            <div class="col-md-6">
                                <h4>Instagram URL</h4>
                                <input name="insta" type="url" placeholder="Enter Instagram Profile URL">
                            </div>
                            <div class="col-md-6">
                                <h4>Twitter URL</h4>
                                <input name="twitter" type="url" placeholder="Enter Twitter Profile URL">
                            </div>
                            <div class="col-md-12">
                                <h4>Auhor Bio</h4>
                                <textarea name="intro" placeholder="Type author bio..."></textarea>
                            </div>
                        </div>
                        <button type="submit">Save Author</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    @include('admin.adminFooter')
</body>

</html>
