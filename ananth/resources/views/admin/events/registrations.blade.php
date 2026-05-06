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
            <div><h2>Event Registrations</h2><p>Delegate, speaker, sponsor, and exhibitor interest submissions.</p></div>
            <a class="event-admin-btn" href="{{ route('events.register') }}" target="_blank">View Form</a>
        </div>
        <div class="event-admin-card">
            <table class="event-admin-table">
                <thead><tr><th>Name</th><th>Type</th><th>Company</th><th>Contact</th><th>Message</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($registrations as $registration)
                    <tr>
                        <td><strong>{{ $registration->name }}</strong><br>{{ $registration->created_at->format('d M Y') }}</td>
                        <td>{{ ucfirst($registration->inquiry_type) }}</td>
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
