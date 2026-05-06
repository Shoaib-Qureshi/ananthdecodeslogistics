<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration update</title>
    @include('emails.events.partials.styles')
</head>
<body>
<div class="wrap">
    <div class="card">
        <div class="header">
            <p class="eyebrow">{{ $registration->event?->name ?: 'LogiSphere' }}</p>
            <h1>Update on your LogiSphere registration interest.</h1>
        </div>
        <div class="body">
            <p>Hello {{ $registration->name }},</p>
            <p>Thank you for your interest in {{ $registration->event?->publicTitle() ?: 'LogiSphere' }}. After review, the event team is not moving this registration forward at this time.</p>
            <div class="panel">
                <div class="row"><span class="label">Event</span><span class="value">{{ $registration->event?->publicTitle() ?: 'LogiSphere' }}</span></div>
                <div class="row"><span class="label">Interest type</span><span class="value">{{ ucfirst($registration->inquiry_type) }}</span></div>
            </div>
            @if($registration->event?->contact_email)
                <p class="muted">For questions, write to {{ $registration->event->contact_email }}.</p>
            @endif
        </div>
        <div class="footer">Ananth Decodes Logistics</div>
    </div>
</div>
</body>
</html>
