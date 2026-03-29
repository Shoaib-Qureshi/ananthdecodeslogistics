<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Add Milestone</title>
</head>

<body>
    @include('admin.adminHeader')
    <section class="main_section">
        <div class="container-fluid">
            @if (session()->has('errors'))
                <div class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <p class="mb-0">{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            <div class="outer_wrapper mt-3">
                <div class="wrapper_head">
                    <h3>Add Milestone</h3>
                </div>
                <div class="wrapper_body">
                    <form class="form_input" action="{{ route('saveMilestone') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Year</h4>
                                <input name="year" type="text" placeholder="e.g., 2020" required>
                            </div>
                            <div class="col-md-6">
                                <h4>Position</h4>
                                <input name="position" type="number" placeholder="Display order (0-999)" value="0">
                            </div>
                            <div class="col-md-12">
                                <h4>Title</h4>
                                <input name="title" type="text" placeholder="Milestone title" required>
                            </div>
                            <div class="col-md-12">
                                <h4>Description</h4>
                                <textarea name="description" rows="5" placeholder="Milestone description"></textarea>
                            </div>
                            <div class="col-md-12">
                                <h4>Status</h4>
                                <select name="status" required>
                                    <option value="1" selected>Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit">Add Milestone</button>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @include('admin.adminFooter')
</body>

</html>
