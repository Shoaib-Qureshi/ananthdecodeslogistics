<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Contributor Registrations</title>
    <style>
        .status-tab { cursor:pointer; }
        .status-tab.active { border-bottom: 3px solid #e07b39; color:#e07b39 !important; font-weight:600; }
        .badge-pending  { background:#fef3c7;color:#92400e; }
        .badge-approved { background:#d1fae5;color:#065f46; }
        .badge-rejected { background:#fee2e2;color:#991b1b; }
        .sp { padding:.25rem .65rem;border-radius:20px;font-size:.75rem;font-weight:600; }
        .reject-form { display:none; }
        .reason-toggle { cursor:pointer; font-size:.8rem; color:#6b7280; text-decoration:underline; }
    </style>
</head>
<body>
@include('admin.adminHeader')

<section class="main_section">
    <div class="container-fluid">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h4 class="mb-0 fw-bold">Contributor Registrations</h4>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show">{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        {{-- Status Tabs --}}
        <div class="d-flex gap-3 mb-4 border-bottom pb-2">
            @foreach(['pending' => 'Pending', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $key => $label)
                <a href="?status={{ $key }}" class="status-tab text-decoration-none text-secondary pb-2 {{ $status === $key ? 'active' : '' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>

        <div class="table-responsive bg-white rounded-3 shadow-sm">
            <table class="table table-hover mb-0">
                <thead style="background:#f8fafc;font-size:.8rem;text-transform:uppercase;letter-spacing:.04em;color:#64748b;">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="py-3">Email</th>
                        <th class="py-3">Designation</th>
                        <th class="py-3">Reason</th>
                        <th class="py-3">Applied</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($registrations as $reg)
                    <tr>
                        <td class="px-4 py-3 fw-semibold">{{ $reg->name }}</td>
                        <td class="py-3 text-muted" style="font-size:.875rem;">{{ $reg->email }}</td>
                        <td class="py-3 text-muted" style="font-size:.875rem;">{{ $reg->designation ?? '—' }}</td>
                        <td class="py-3" style="max-width:200px;">
                            <span style="font-size:.8rem;color:#475569;">{{ Str::limit($reg->reason_for_joining, 80) }}</span>
                            @if(strlen($reg->reason_for_joining ?? '') > 80)
                                <a href="#" class="reason-toggle ms-1" data-bs-toggle="modal" data-bs-target="#reasonModal{{ $reg->id }}">read more</a>
                            @endif
                        </td>
                        <td class="py-3 text-muted" style="font-size:.82rem;">{{ $reg->created_at->format('d M Y') }}</td>
                        <td class="py-3">
                            <span class="sp badge-{{ $reg->status }}">{{ ucfirst($reg->status) }}</span>
                        </td>
                        <td class="py-3">
                            @if($reg->status === 'pending')
                                <div class="d-flex gap-2 flex-wrap">
                                    <form method="POST" action="{{ route('admin.registrations.approve', $reg->id) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Approve {{ $reg->name }}?')">Approve</button>
                                    </form>
                                    <button class="btn btn-sm btn-outline-danger" type="button" onclick="document.getElementById('rejectForm{{ $reg->id }}').style.display='block'">Reject</button>
                                </div>
                                <div id="rejectForm{{ $reg->id }}" class="reject-form mt-2">
                                    <form method="POST" action="{{ route('admin.registrations.reject', $reg->id) }}">
                                        @csrf
                                        <textarea name="rejection_reason" rows="2" class="form-control form-control-sm mb-2" placeholder="Reason for rejection..." required></textarea>
                                        <div class="d-flex gap-2">
                                            <button type="submit" class="btn btn-sm btn-danger">Confirm Reject</button>
                                            <button type="button" class="btn btn-sm btn-secondary" onclick="document.getElementById('rejectForm{{ $reg->id }}').style.display='none'">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            @else
                                <span class="text-muted" style="font-size:.8rem;">{{ $reg->status === 'approved' ? 'Approved ✓' : 'Rejected' }}</span>
                            @endif
                        </td>
                    </tr>

                    {{-- Reason Modal --}}
                    @if(strlen($reg->reason_for_joining ?? '') > 80)
                    <div class="modal fade" id="reasonModal{{ $reg->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header"><h6 class="modal-title">{{ $reg->name }} — Reason for Joining</h6><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                                <div class="modal-body" style="font-size:.9rem;">{{ $reg->reason_for_joining }}</div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @empty
                    <tr><td colspan="7" class="text-center py-5 text-muted">No {{ $status }} registrations found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($registrations->hasPages())
            <div class="mt-4">{{ $registrations->links() }}</div>
        @endif

    </div>
</section>

@include('admin.adminFooter')
</body>
</html>
