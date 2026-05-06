<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration confirmed</title>
    @include('emails.events.partials.styles')
</head>
<body>
<div class="wrap">
    <div class="card">
        <div class="header">
            <p class="eyebrow">{{ $registration->event?->name ?: 'LogiSphere' }}</p>
            <h1>Your LogiSphere registration is confirmed.</h1>
        </div>
        <div class="body">
            <p>Hello {{ $registration->name }},</p>
            <p>Your {{ ucfirst($registration->inquiry_type) }} registration for {{ $registration->event?->publicTitle() ?: 'LogiSphere' }} has been confirmed by the event team.</p>
            <div class="panel">
                <div class="row"><span class="label">Event</span><span class="value">{{ $registration->event?->publicTitle() ?: 'LogiSphere' }}</span></div>
                <div class="row"><span class="label">Date</span><span class="value">{{ $registration->event?->formattedDate() }}</span></div>
                <div class="row"><span class="label">Venue</span><span class="value">{{ $registration->event?->venue_name ?: $registration->event?->location }}</span></div>
            </div>
            @if($registration->event?->contact_email)
                <p class="muted">Questions? Write to {{ $registration->event->contact_email }}.</p>
            @endif
        </div>
        <div class="footer">Ananth Decodes Logistics</div>
    </div>
</div>
</body>
</html>
