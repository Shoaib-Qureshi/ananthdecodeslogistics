<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Users List</title>
</head>

<body>
    @include('admin.adminHeader')
    <section class="main_section">
        <div class="container-fluid">
            <div class="outer_wrapper">
                <div class="wrapper_head row align-items-center">
                    <div class="col-md-6">
                        <h3>All Users</h3>
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
                    @if (session()->has('message'))
                        <div class="alert alert-success">{{ session()->get('message') }}</div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger">{{ session()->get('error') }}</div>
                    @endif
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Name</th>
                                <th scope="col">Designation</th>
                                <th scope="col">Plan</th>
                                <th scope="col">Payment</th>
                                <th scope="col">Status</th>
                                <th scope="col">Intro</th>
                                <th scope="col">Edit</th>
                                <th scope="col">Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($users->count() > 0)
                                @foreach ($users as $item)
                                    <tr>
                                        <th>{{ $loop->iteration }}</th>
                                        <td><a class="link-primary" target="_blank"
                                                href="{{ asset('author/' . $item->username) }}/">{{ $item->name }}</a>
                                        </td>
                                        <td>{{ $item->designation }}</td>
                                        <td>{{ $item->contributor_plan ? \App\Support\ContributorPlans::label($item->contributor_plan, true) : '—' }}</td>
                                        <td>{{ $item->payment_status ?? '—' }}</td>
                                        <td>{{ $item->status ?? '—' }}</td>
                                        <td>{{ $item->intro }}</td>
                                        <td><a class="link-primary"
                                                href="{{ asset('admin/edit/user/' . $item->id) }}/">Edit</a></td>
                                        <td>
                                            <form method="POST" action="{{ route('admin.users.delete', $item->id) }}" onsubmit="return confirm('Delete this user and all posts authored by them?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                            </form>
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
                        {{ $users->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.adminFooter')
</body>

</html>
