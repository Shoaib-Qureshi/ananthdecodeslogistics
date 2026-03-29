<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Manage Insights</title>
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
                        <h3>Manage Insights</h3>
                    </div>
                    <div class="col-md-6">
                        <form class="d-flex admin_buttons" action="" method="GET">
                            <input name="query" class="form-control me-2" type="search" placeholder="Search"
                                aria-label="Search">
                            <button class="btn btn-success" type="submit">Search</button>
                        </form>
                    </div>
                </div>
                <div class="wrapper_body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Title</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($searchInsight->count() > 0)
                                @foreach ($searchInsight as $item)
                                    <tr>
                                        <th>{{ $item->id }}</th>
                                        <td>
                                            <a class="link-primary" target="_blank"
                                                href="{{ asset('board-insight/' . $item->slug) }}/">{{ $item->title }}</a>
                                        </td>
                                        <td>
                                            @if ($item->status == 1)
                                                <strong class="text-success">Live</strong>
                                            @else
                                                <span class="text-danger">Draft</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->created_at->toFormattedDateString() }}</td>
                                        <td><a class="link-primary"
                                                href="{{ asset('admin/edit/insight/' . $item->id) }}/">Edit</a></td>
                                        <td><a class="text-danger"
                                                onclick="return confirm('Are you sure, you want to delete this member?')"
                                                href="{{ URL::asset('admin/delete/insight/' . $item['id']) }}">Delete</a>
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
                    <div class="pagination">
                        {{ $searchInsight->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.adminFooter')
</body>

</html>
