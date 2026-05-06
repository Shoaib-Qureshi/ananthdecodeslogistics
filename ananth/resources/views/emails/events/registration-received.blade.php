<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration received</title>
    @include('emails.events.partials.styles')
</head>
<body>
<div class="wrap">
    <div class="card">
        <div class="header">
            <p class="eyebrow">{{ $registration->event?->name ?: 'LogiSphere' }}</p>
            <h1>Thanks {{ $registration->name }}, your interest has been received.</h1>
        </div>
        <div class="body">
            <p>We have received your {{ ucfirst($registration->inquiry_type) }} interest for {{ $registration->event?->publicTitle() ?: 'LogiSphere' }}. The event team will review your details and follow up with the next step.</p>
            <div class="panel">
                <div class="row"><span class="label">Event</span><span class="value">{{ $registration->event?->publicTitle() ?: 'LogiSphere' }}</span></div>
                <div class="row"><span class="label">Date</span><span class="value">{{ $registration->event?->formattedDate() }}</span></div>
                <div class="row"><span class="label">Interest type</span><span class="value">{{ ucfirst($registration->inquiry_type) }}</span></div>
                <div class="row"><span class="label">Company</span><span class="value">{{ $registration->company ?: 'Not provided' }}</span></div>
            </div>
            <p class="muted">This is an acknowledgement, not the final confirmation. You will receive another email once the team confirms your registration.</p>
        </div>
        <div class="footer">Ananth Decodes Logistics</div>
    </div>
</div>
</body>
</html>
