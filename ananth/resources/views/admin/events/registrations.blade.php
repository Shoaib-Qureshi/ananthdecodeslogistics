<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Event Registrations</title>
    @include('admin.events.partials.styles')
</head>
<body>
@include('admin.adminHeader')
<section class="main_section">
    <div class="container-fluid">
        @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
        <div class="event-admin-hero">
            <div><h2>Event Registrations</h2><p>Event interest submissions.</p></div>
            <div class="event-admin-actions">
                <a class="event-admin-btn primary" href="{{ route('admin.events.registrations.export', request()->only(['type', 'status'])) }}" aria-label="Download all event registrations for Excel">
                    <svg aria-hidden="true" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                        <path d="M7 10l5 5 5-5"/>
                        <path d="M12 15V3"/>
                    </svg>
                    Download for Excel
                </a>
                <a class="event-admin-btn" href="{{ route('events.register') }}" target="_blank" rel="noopener">View Form</a>
            </div>
        </div>
        <div class="event-admin-card">
            <table class="event-admin-table">
                <thead><tr><th>Name</th><th>Type</th><th>Company</th><th>Contact</th><th>Message</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($registrations as $registration)
                    <tr>
                        <td><strong>{{ $registration->name }}</strong><br>{{ $registration->created_at->format('d M Y') }}</td>
                        <td>{{ $registration->event ? ($registration->event->interestOptionMap()[$registration->inquiry_type] ?? \Illuminate\Support\Str::headline($registration->inquiry_type)) : \Illuminate\Support\Str::headline($registration->inquiry_type) }}</td>
                        <td>{{ $registration->company }}<br>{{ $registration->designation }}</td>
                        <td>{{ $registration->email }}<br>{{ $registration->phone }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($registration->message, 140) }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.events.registrations.status', $registration) }}">
                                @csrf
                                <select name="status" onchange="this.form.submit()">
                                    @foreach(['new' => 'New', 'contacted' => 'Contacted', 'confirmed' => 'Confirmed', 'not_interested' => 'Not Interested'] as $status => $label)
                                        <option value="{{ $status }}" {{ ($registration->status === $status || ($registration->status === 'closed' && $status === 'not_interested')) ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">No registrations yet.</td></tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $registrations->links() }}</div>
        </div>
    </div>
</section>
@include('admin.adminFooter')
</body>
</html>
