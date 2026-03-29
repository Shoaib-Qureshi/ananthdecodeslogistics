<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Manage Milestones</title>
</head>

<body>
    @include('admin.adminHeader')
    <section class="main_section">
        <div class="container-fluid">
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="outer_wrapper mt-3">
                <div class="wrapper_head">
                    <h3>Manage Milestones</h3>
                    <a href="/admin/add-milestone/"><button class="add_btn">Add Milestone</button></a>
                </div>
                <div class="wrapper_body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Position</th>
                                    <th>Year</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($milestones as $milestone)
                                    <tr>
                                        <td>{{ $milestone->position }}</td>
                                        <td>{{ $milestone->year }}</td>
                                        <td>{{ $milestone->title }}</td>
                                        <td>{{ Str::limit($milestone->description, 50) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $milestone->status ? 'success' : 'secondary' }}">
                                                {{ $milestone->status ? 'Active' : 'Inactive' }}
                                            </span>
                                        </td>
                                        <td>
                                            <a href="/admin/edit-milestone/{{ $milestone->id }}">
                                                <button class="edit_btn">Edit</button>
                                            </a>
                                            <a href="/admin/delete-milestone/{{ $milestone->id }}"
                                               onclick="return confirm('Are you sure you want to delete this milestone?')">
                                                <button class="delete_btn">Delete</button>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No milestones found. Add your first milestone!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('admin.adminFooter')
</body>

</html>
