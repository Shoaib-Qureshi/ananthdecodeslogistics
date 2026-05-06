<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New event registration</title>
    @include('emails.events.partials.styles')
</head>
<body>
<div class="wrap">
    <div class="card">
        <div class="header">
            <p class="eyebrow">Admin notification</p>
            <h1>New {{ ucfirst($registration->inquiry_type) }} interest: {{ $registration->name }}</h1>
        </div>
        <div class="body">
            <div class="panel">
                <div class="row"><span class="label">Event</span><span class="value">{{ $registration->event?->publicTitle() ?: 'LogiSphere' }}</span></div>
                <div class="row"><span class="label">Name</span><span class="value">{{ $registration->name }}</span></div>
                <div class="row"><span class="label">Email</span><span class="value">{{ $registration->email }}</span></div>
                <div class="row"><span class="label">Phone</span><span class="value">{{ $registration->phone ?: 'Not provided' }}</span></div>
                <div class="row"><span class="label">Company</span><span class="value">{{ $registration->company ?: 'Not provided' }}</span></div>
                <div class="row"><span class="label">Designation</span><span class="value">{{ $registration->designation ?: 'Not provided' }}</span></div>
                <div class="row"><span class="label">Message</span><span class="value">{{ $registration->message ?: 'No message' }}</span></div>
            </div>
            <a class="btn" href="{{ route('admin.events.registrations') }}">Review registrations</a>
        </div>
        <div class="footer">Sent from the LogiSphere registration form.</div>
    </div>
</div>
</body>
</html>
