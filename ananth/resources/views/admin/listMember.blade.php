<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Members List</title>
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
            <div class="outer_wrapper">
                <div class="wrapper_head row align-items-center">
                    <div class="col-md-6">
                        <h3>Members List</h3>
                    </div>
                </div>
                <div class="wrapper_body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Image</th>
                                <th scope="col">Name</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Position</th>
                                <th scope="col">Date</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($members->count() > 0)
                                @foreach ($members as $item)
                                    <tr>
                                        <th>{{ $item->id }}</th>
                                        <th><img width="100px" src="/img/site/{{ $item->image }}" alt=""></th>
                                        <td>{{ $item->name }}</td>

                                        <td>{{ $item->designation }}</td>
                                        <td>{{ $item->position }}</td>
                                        <td>{{ $item->created_at->toFormattedDateString() }}</td>
                                        <td><a class="link-primary"
                                                href="{{ asset('admin/edit-member/' . $item->id) }}/">Edit</a></td>
                                        <td><a class="text-danger"
                                                onclick="return confirm('Are you sure, you want to delete this member?')"
                                                href="{{ URL::asset('admin/delete-member/' . $item['id']) }}">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <th>No Result Found!</th>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    @include('admin.adminFooter')
</body>

</html>
