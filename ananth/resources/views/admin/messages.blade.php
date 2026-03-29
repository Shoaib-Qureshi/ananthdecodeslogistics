<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Messages</title>
</head>

<body>
    @include('admin.adminHeader')
    <section class="main_section">
        <div class="container-fluid">
            <div class="outer_wrapper">
                <div class="wrapper_head row align-items-center">
                    <div class="col-md-6">
                        <h3>Messages</h3>
                    </div>
                </div>
                <div class="wrapper_body">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th scope="col">Date</th>
                                <th scope="col">Name</th>
                                <th scope="col">Email</th>
                                <th scope="col">Subject</th>
                                <th scope="col">Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($messages->count() > 0)
                                @foreach ($messages as $item)
                                    <tr>
                                        <td>{{ $item->created_at->toFormattedDateString() }}</td>
                                        <th>{{ $item->name }}</th>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->subject }}</td>
                                        <td>{{ $item->message }}</td>
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
                        {{ $messages->links() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
    @include('admin.adminFooter')
</body>

</html>
