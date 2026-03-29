@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#eff6ff;">
                <i class="bi bi-file-earmark-text" style="color:#3b82f6;"></i>
            </div>
            <div>
                <div class="stat-label">Total Posts</div>
                <div class="stat-value">{{ $stats['total'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fffbeb;">
                <i class="bi bi-clock-history" style="color:#d97706;"></i>
            </div>
            <div>
                <div class="stat-label">Under Review</div>
                <div class="stat-value">{{ $stats['pending'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#f0fdf4;">
                <i class="bi bi-globe" style="color:#16a34a;"></i>
            </div>
            <div>
                <div class="stat-label">Published</div>
                <div class="stat-value">{{ $stats['published'] }}</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-xl-3">
        <div class="stat-card">
            <div class="stat-icon" style="background:#fef2f2;">
                <i class="bi bi-arrow-counterclockwise" style="color:#dc2626;"></i>
            </div>
            <div>
                <div class="stat-label">Needs Revision</div>
                <div class="stat-value">{{ $stats['rejected'] }}</div>
            </div>
        </div>
    </div>
</div>

{{-- Welcome / Tips (only when no posts) --}}
@if($posts->isEmpty())
<div style="background:#fff;border-radius:12px;border:1px solid #e8edf5;padding:3rem;text-align:center;">
    <div style="width:64px;height:64px;border-radius:16px;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;">
        <i class="bi bi-pencil-square" style="font-size:1.75rem;color:#3882fa;"></i>
    </div>
    <h5 style="font-weight:700;color:#181a3f;margin-bottom:.5rem;">Ready to share your expertise?</h5>
    <p style="color:#64748b;font-size:.9rem;max-width:400px;margin:0 auto 1.5rem;line-height:1.6;">
        Write your first article and reach thousands of logistics professionals. Our team reviews every submission within 48 hours.
    </p>
    <a href="{{ route('dashboard.posts.create') }}" class="btn-write" style="display:inline-flex;">
        <i class="bi bi-plus-lg"></i> Write Your First Post
    </a>
</div>

@else

{{-- Posts table --}}
<div class="card-table">
    <div class="card-header">
        <span>Recent Submissions</span>
        <a href="{{ route('dashboard.posts') }}" style="font-size:.78rem;color:#3882fa;font-weight:600;">View all</a>
    </div>
    <div class="table-responsive">
        <table class="table table-hover mb-0" style="font-size:.855rem;">
            <thead style="background:#f8fafc;font-size:.72rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">
                <tr>
                    <th class="px-4 py-3 fw-semibold border-0">Title</th>
                    <th class="py-3 fw-semibold border-0">Category</th>
                    <th class="py-3 fw-semibold border-0 d-none d-md-table-cell">Submitted</th>
                    <th class="py-3 fw-semibold border-0">Status</th>
                    <th class="py-3 fw-semibold border-0">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($posts as $post)
                <tr style="border-color:#f1f5f9;">
                    <td class="px-4 py-3" style="max-width:260px;">
                        <span class="fw-semibold d-block text-truncate" style="color:#1e293b;">{{ $post->title }}</span>
                    </td>
                    <td class="py-3 text-muted" style="white-space:nowrap;">{{ $post->category?->category_name ?? $post->category?->name ?? '—' }}</td>
                    <td class="py-3 text-muted d-none d-md-table-cell" style="white-space:nowrap;">{{ $post->created_at->format('d M Y') }}</td>
                    <td class="py-3" style="white-space:nowrap;">
                        <span class="status-badge badge-{{ $post->status === 'published' ? 'published' : ($post->status === 'approved' ? 'approved' : ($post->status === 'rejected' ? 'rejected' : 'pending')) }}">
                            {{ $post->status === 'pending' ? 'In Review' : ucfirst($post->status) }}
                        </span>
                    </td>
                    <td class="py-3">
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <a href="{{ route('dashboard.posts.edit', $post->id) }}"
                               class="btn btn-sm btn-outline-warning"
                               style="font-size:.76rem;border-radius:6px;">
                               <i class="bi bi-pencil me-1"></i>Edit & Resubmit
                            </a>
                            @if($post->status === 'published')
                                <a href="{{ route('contributors.show', $post->slug) }}" target="_blank"
                                   class="btn btn-sm btn-outline-primary"
                                   style="font-size:.76rem;border-radius:6px;">
                                   <i class="bi bi-box-arrow-up-right me-1"></i>View Live
                                </a>
                            @elseif($post->status === 'pending')
                                <span style="color:#94a3b8;font-size:.8rem;">
                                    <i class="bi bi-hourglass-split me-1"></i>Awaiting review
                                </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if($posts->hasPages())
        <div class="px-4 py-3" style="border-top:1px solid #e8edf5;">{{ $posts->links() }}</div>
    @endif
</div>

{{-- Revision needed callout --}}
@if($stats['rejected'] > 0)
<div style="background:#fffbeb;border:1px solid #fde68a;border-left:4px solid #f59e0b;border-radius:10px;padding:.9rem 1.2rem;margin-top:1rem;display:flex;align-items:center;gap:.75rem;font-size:.875rem;color:#92400e;">
    <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;"></i>
    <span>You have {{ $stats['rejected'] }} post{{ $stats['rejected'] > 1 ? 's' : '' }} with revision notes from the editorial team.</span>
</div>
@endif

@endif

@endsection
