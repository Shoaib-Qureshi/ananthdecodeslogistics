<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>All Events — Admin</title>
    @include('admin.events.partials.styles')
    <style>
        .ev-index-header{display:flex;align-items:center;justify-content:space-between;gap:16px;margin:18px 0 22px;padding:22px 24px;border:1px solid #d8e3f0;border-radius:18px;background:linear-gradient(135deg,#fff,#f8fbff);box-shadow:0 18px 50px rgba(15,23,42,.06)}
        .ev-index-header h2{margin:0;color:#0f172a;font-size:1.65rem;font-weight:800}
        .ev-index-header p{margin:6px 0 0;color:#64748b}
        .ev-table{width:100%;border-collapse:separate;border-spacing:0;border:1px solid #d8e3f0;border-radius:18px;overflow:hidden;background:#fff;box-shadow:0 14px 40px rgba(15,23,42,.05)}
        .ev-table th{background:#f0f7ff;color:#0369a1;font-size:.76rem;font-weight:800;letter-spacing:.08em;text-transform:uppercase;padding:13px 16px;border-bottom:1px solid #d8e3f0;text-align:left}
        .ev-table td{padding:14px 16px;border-bottom:1px solid #e5edf7;vertical-align:middle;color:#334155;font-size:.92rem}
        .ev-table tr:last-child td{border-bottom:0}
        .ev-table tr:hover td{background:#f8fbff}
        .ev-badge{display:inline-flex;align-items:center;gap:5px;border-radius:999px;padding:4px 10px;font-size:.72rem;font-weight:800;letter-spacing:.04em}
        .ev-badge--active{background:#ecfdf5;color:#059669;border:1px solid #a7f3d0}
        .ev-badge--inactive{background:#f1f5f9;color:#64748b;border:1px solid #e2e8f0}
        .ev-badge--future{background:#eff6ff;color:#2562E9;border:1px solid rgba(37,98,233,.2)}
        .ev-badge--past{background:#fef9ec;color:#b45309;border:1px solid #fde68a}
        .ev-actions-cell{display:flex;flex-wrap:wrap;gap:8px;align-items:center}
        .ev-btn{display:inline-flex;align-items:center;gap:6px;border-radius:40px;padding:7px 14px;font-size:.78rem;font-weight:800;text-decoration:none;border:1px solid #d8e3f0;color:#475569;background:#fff;cursor:pointer;white-space:nowrap}
        .ev-btn:hover{border-color:#2562E9;color:#2562E9;background:#eff6ff}
        .ev-btn--primary{border-color:#2562E9;background:#2562E9;color:#fff}
        .ev-btn--primary:hover{background:#1a4fc4;border-color:#1a4fc4;color:#fff}
        .ev-btn--activate{border-color:#059669;color:#059669}
        .ev-btn--activate:hover{background:#ecfdf5}
        .ev-btn--danger{border-color:#dc2626;color:#dc2626}
        .ev-btn--danger:hover{background:#fef2f2}
        .ev-name{font-family:Georgia,serif;font-weight:700;color:#0f172a}
        .ev-chapter{font-size:.78rem;color:#64748b;margin-top:2px}
    </style>
</head>
<body>
@include('admin.adminHeader')
<section class="main_section">
    <div class="container-fluid">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        @if($errors->any())<div class="alert alert-danger">{{ $errors->first() }}</div>@endif

        <div class="ev-index-header">
            <div>
                <h2>All Events</h2>
                <p>Manage all LogiSphere events. Only one event is active at a time — it drives all public-facing event pages.</p>
            </div>
            <a href="{{ route('admin.events.create') }}" class="ev-btn ev-btn--primary">
                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
                New Event
            </a>
        </div>

        <table class="ev-table">
            <thead>
                <tr>
                    <th>Event</th>
                    <th>Date</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($events as $ev)
                <tr>
                    <td>
                        <div class="ev-name">{{ $ev->name }}</div>
                        @if($ev->chapter)<div class="ev-chapter">{{ $ev->chapter }}</div>@endif
                    </td>
                    <td>{{ $ev->event_date ? $ev->event_date->format('d M Y') : '—' }}</td>
                    <td>{{ $ev->location ?: '—' }}</td>
                    <td>
                        @if($ev->is_active)
                            <span class="ev-badge ev-badge--active">
                                <svg width="7" height="7" viewBox="0 0 8 8" fill="#059669" aria-hidden="true"><circle cx="4" cy="4" r="4"/></svg>
                                Active
                            </span>
                        @elseif($ev->event_date && $ev->event_date->isFuture())
                            <span class="ev-badge ev-badge--future">Upcoming</span>
                        @elseif($ev->event_date && $ev->event_date->isPast())
                            <span class="ev-badge ev-badge--past">Past</span>
                        @else
                            <span class="ev-badge ev-badge--inactive">Draft</span>
                        @endif
                    </td>
                    <td>
                        <div class="ev-actions-cell">
                            <a href="{{ route('admin.events.event.edit', $ev) }}" class="ev-btn">Edit</a>
                            <a href="{{ route('events.conference') }}" target="_blank" class="ev-btn">View</a>
                            @if(!$ev->is_active)
                                <form method="POST" action="{{ route('admin.events.event.activate', $ev) }}" style="display:contents">
                                    @csrf
                                    <button type="submit" class="ev-btn ev-btn--activate">Set Active</button>
                                </form>
                                <form method="POST" action="{{ route('admin.events.event.destroy', $ev) }}" style="display:contents"
                                      onsubmit="return confirm('Delete {{ addslashes($ev->name) }}? This cannot be undone.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="ev-btn ev-btn--danger">Delete</button>
                                </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align:center;color:#94a3b8;padding:40px">No events yet. <a href="{{ route('admin.events.create') }}">Create one.</a></td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</section>
@include('admin.adminFooter')
</body>
</html>
