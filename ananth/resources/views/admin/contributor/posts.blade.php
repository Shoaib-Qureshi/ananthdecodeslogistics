<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Contributor Posts</title>
    <style>
        .status-tab { cursor:pointer; }
        .status-tab.active { border-bottom: 3px solid #e07b39; color:#e07b39 !important; font-weight:600; }
        .badge-pending   { background:#fef3c7;color:#92400e; }
        .badge-approved  { background:#d1fae5;color:#065f46; }
        .badge-published { background:#dbeafe;color:#1e40af; }
        .badge-rejected  { background:#fee2e2;color:#991b1b; }
        .sp { padding:.25rem .65rem;border-radius:20px;font-size:.75rem;font-weight:600; }
        .reject-form { display:none; }
        .preview-body { max-height:300px;overflow-y:auto;background:#f8f9fc;padding:1rem;border-radius:8px;font-size:.9rem; }
    </style>
</head>
<body>
@include('admin.adminHeader')

<section class="main_section">
    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0 fw-bold">Contributor Posts</h4>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="d-flex gap-3 mb-4 border-bottom pb-2">
            @foreach(['pending' => 'Pending', 'published' => 'Published', 'rejected' => 'Rejected'] as $key => $label)
                <a href="?status={{ $key }}" class="status-tab text-decoration-none text-secondary pb-2 {{ $status === $key ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="table-responsive bg-white rounded-3 shadow-sm">
            <table class="table table-hover mb-0">
                <thead style="background:#f8fafc;font-size:.8rem;text-transform:uppercase;letter-spacing:.04em;color:#64748b;">
                    <tr>
                        <th class="px-4 py-3">Title</th>
                        <th class="py-3">Author</th>
                        <th class="py-3">Category</th>
                        <th class="py-3">Featured</th>
                        <th class="py-3">Submitted</th>
                        <th class="py-3">Status</th>
                        <th class="py-3" style="min-width:240px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($posts as $post)
                    <tr>
                        <td class="px-4 py-3" style="max-width:240px;">
                            <span class="fw-semibold d-block text-truncate">{{ $post->title }}</span>
                            <a href="#" class="text-muted" style="font-size:.78rem;" data-bs-toggle="modal" data-bs-target="#previewModal{{ $post->id }}">
                                Preview post →
                            </a>
                        </td>
                        <td class="py-3">
                            <span class="fw-500 d-block">{{ $post->author->name }}</span>
                            <span class="text-muted" style="font-size:.78rem;">{{ $post->author->designation ?? '' }}</span>
                        </td>
                        <td class="py-3 text-muted" style="font-size:.875rem;">{{ $post->category?->category_name ?? $post->category?->name ?? '—' }}</td>
                        <td class="py-3 text-muted" style="font-size:.82rem;">{{ $post->is_featured ? 'Yes' : 'No' }}</td>
                        <td class="py-3 text-muted" style="font-size:.82rem;">{{ $post->created_at->format('d M Y') }}</td>
                        <td class="py-3">
                            <span class="sp badge-{{ $post->status }}">{{ ucfirst($post->status) }}</span>
                        </td>
                        <td class="py-3">
                            @if($post->status === 'pending')
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('admin.contributor.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <form method="POST" action="{{ route('admin.contributor.posts.approve', $post->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Publish this post?')">Approve & Publish</button>
                                    </form>
                                    <button class="btn btn-sm btn-outline-danger" type="button" onclick="document.getElementById('rejectPostForm{{ $post->id }}').style.display='block'">Reject</button>
                                </div>
                                <div id="rejectPostForm{{ $post->id }}" class="reject-form mt-2">
                                    <form method="POST" action="{{ route('admin.contributor.posts.reject', $post->id) }}">
                                        @csrf
                                        <textarea name="rejection_reason" rows="2" class="form-control form-control-sm mb-2" placeholder="Reason for rejection (sent to contributor)..." required></textarea>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-sm btn-danger">Confirm Reject</button>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="document.getElementById('rejectPostForm{{ $post->id }}').style.display='none'">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="mt-2">
                                    <form method="POST" action="{{ route('admin.contributor.posts.delete', $post->id) }}" onsubmit="return confirm('Delete this pending contributor post?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            @elseif($post->status === 'published')
                                <div class="d-flex gap-2 flex-wrap">
                                    <a href="{{ route('admin.contributor.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <a href="{{ route('contributors.show', $post->slug) }}" target="_blank" class="btn btn-sm btn-outline-primary">View Live</a>
                                    <form method="POST" action="{{ route('admin.contributor.posts.delete', $post->id) }}" onsubmit="return confirm('Delete this contributor post?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            @else
                                <div class="d-flex gap-2 flex-wrap align-items-center">
                                    <a href="{{ route('admin.contributor.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-secondary">Edit</a>
                                    <span class="text-muted" style="font-size:.8rem;">Rejected</span>
                                    <form method="POST" action="{{ route('admin.contributor.posts.delete', $post->id) }}" onsubmit="return confirm('Delete this contributor post?');">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>
                                </div>
                            @endif
                        </td>
                    </tr>

                    <div class="modal fade" id="previewModal{{ $post->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h6 class="modal-title">{{ $post->title }}</h6>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <img src="{{ $post->featured_image_url }}" class="img-fluid rounded mb-3" style="max-height:200px;">
                                    <div class="preview-body">{!! $post->body !!}</div>
                                    <div class="mt-3 text-muted" style="font-size:.82rem;">
                                        By <strong>{{ $post->author->name }}</strong> · {{ $post->author->designation ?? '' }} · {{ $post->created_at->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    @empty
                    <tr><td colspan="7" class="text-center py-5 text-muted">No {{ $status }} posts found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($posts->hasPages())
            <div class="mt-4">{{ $posts->links() }}</div>
        @endif

    </div>
</section>

@include('admin.adminFooter')
</body>
</html>
