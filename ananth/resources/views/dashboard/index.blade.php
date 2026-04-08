@extends('layouts.dashboard')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
@php
    $plan = Auth::user()->contributorPlanDetails();
    $endsAt = Auth::user()->contributorPlanEndsAt();
    $remainingSlots = Auth::user()->remainingContributorPostSlots($stats['total']);
@endphp

<div style="background:#fff;border-radius:12px;border:1px solid #e8edf5;padding:1.2rem 1.3rem;margin-bottom:1.25rem;">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
        <div>
            <div style="font-size:.74rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#64748b;">Plan status</div>
            <h5 style="margin:.35rem 0;color:#0f172a;font-weight:700;">{{ Auth::user()->contributorPlanLabel() }}</h5>
            <p style="margin:0;color:#64748b;font-size:.88rem;line-height:1.65;">
                {{ $plan['post_limit_label'] }}
                @if($endsAt)
                    . Active until {{ $endsAt->format('d M Y') }}.
                @endif
                @if($remainingSlots !== null)
                    {{ $remainingSlots }} submission slot{{ $remainingSlots === 1 ? '' : 's' }} remaining.
                @endif
            </p>
        </div>
        @if(!$canSubmitPosts)
            <a href="{{ route('contributor.register') }}" class="btn-write" style="display:inline-flex;">
                <i class="bi bi-arrow-repeat"></i> {{ $plan['renew_cta'] }}
            </a>
        @endif
    </div>
    @if($submissionRestrictionMessage)
        <div style="background:#fffbeb;border:1px solid #fde68a;border-left:4px solid #f59e0b;border-radius:10px;padding:.85rem 1rem;margin-top:1rem;color:#92400e;font-size:.86rem;">
            {{ $submissionRestrictionMessage }}
        </div>
    @endif
</div>

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

@if($posts->isEmpty())
    <div style="background:#fff;border-radius:12px;border:1px solid #e8edf5;padding:3rem;text-align:center;">
        <div style="width:64px;height:64px;border-radius:16px;background:#eff6ff;display:flex;align-items:center;justify-content:center;margin:0 auto 1.25rem;">
            <i class="bi bi-pencil-square" style="font-size:1.75rem;color:#3882fa;"></i>
        </div>
        <h5 style="font-weight:700;color:#181a3f;margin-bottom:.5rem;">Ready to share your expertise?</h5>
        <p style="color:#64748b;font-size:.9rem;max-width:430px;margin:0 auto 1.5rem;line-height:1.6;">
            @if($canSubmitPosts)
                Write your first article for The Expert Desk and reach logistics professionals through a focused editorial platform.
            @else
                Your dashboard stays active, but new submissions are paused until you renew or upgrade your Expert Desk access.
            @endif
        </p>
        @if($canSubmitPosts)
            <a href="{{ route('dashboard.posts.create') }}" class="btn-write" style="display:inline-flex;">
                <i class="bi bi-plus-lg"></i> Write Your First Post
            </a>
        @else
            <a href="{{ route('contributor.register') }}" class="btn-write" style="display:inline-flex;">
                <i class="bi bi-arrow-repeat"></i> {{ $plan['renew_cta'] }}
            </a>
        @endif
    </div>
@else
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
                        <td class="py-3 text-muted" style="white-space:nowrap;">{{ $post->category?->category_name ?? $post->category?->name ?? '-' }}</td>
                        <td class="py-3 text-muted d-none d-md-table-cell" style="white-space:nowrap;">{{ $post->created_at->format('d M Y') }}</td>
                        <td class="py-3" style="white-space:nowrap;">
                            <span class="status-badge badge-{{ $post->status === 'published' ? 'published' : ($post->status === 'approved' ? 'approved' : ($post->status === 'rejected' ? 'rejected' : 'pending')) }}">
                                {{ $post->status === 'pending' ? 'In Review' : ucfirst($post->status) }}
                            </span>
                        </td>
                        <td class="py-3">
                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                @if($canSubmitPosts)
                                    <a href="{{ route('dashboard.posts.edit', $post->id) }}"
                                       class="btn btn-sm btn-outline-warning"
                                       style="font-size:.76rem;border-radius:6px;">
                                       <i class="bi bi-pencil me-1"></i>Edit & Resubmit
                                    </a>
                                @else
                                    <span style="color:#94a3b8;font-size:.8rem;">
                                        <i class="bi bi-lock me-1"></i>Renew to resubmit
                                    </span>
                                @endif

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

    @if($stats['rejected'] > 0)
        <div style="background:#fffbeb;border:1px solid #fde68a;border-left:4px solid #f59e0b;border-radius:10px;padding:.9rem 1.2rem;margin-top:1rem;display:flex;align-items:center;gap:.75rem;font-size:.875rem;color:#92400e;">
            <i class="bi bi-exclamation-triangle-fill" style="flex-shrink:0;"></i>
            <span>You have {{ $stats['rejected'] }} post{{ $stats['rejected'] > 1 ? 's' : '' }} with revision notes from the editorial team.</span>
        </div>
    @endif
@endif
@endsection
