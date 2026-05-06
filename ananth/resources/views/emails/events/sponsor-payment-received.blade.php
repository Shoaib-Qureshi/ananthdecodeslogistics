<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sponsorship payment confirmed</title>
    @include('emails.events.partials.styles')
</head>
<body>
<div class="wrap">
    <div class="card">
        <div class="header">
            <p class="eyebrow">{{ $payment->event?->name ?: 'LogiSphere' }}</p>
            <h1>Your sponsorship payment is confirmed.</h1>
        </div>
        <div class="body">
            <p>Hello {{ $payment->contact_name }},</p>
            <p>Thank you. We have received the sponsorship payment for {{ $payment->company }}.</p>
            <div class="panel">
                <div class="row"><span class="label">Event</span><span class="value">{{ $payment->event?->publicTitle() ?: 'LogiSphere' }}</span></div>
                <div class="row"><span class="label">Package</span><span class="value">{{ $payment->package?->name }}</span></div>
                <div class="row"><span class="label">Base amount</span><span class="value">{{ $payment->currency }} {{ number_format((float) $payment->base_amount, 2) }}</span></div>
                <div class="row"><span class="label">{{ $payment->tax_label ?: 'Tax' }}</span><span class="value">{{ $payment->currency }} {{ number_format((float) $payment->tax_amount, 2) }}</span></div>
                <div class="row"><span class="label">Total paid</span><span class="value">{{ $payment->currency }} {{ number_format((float) $payment->total_amount, 2) }}</span></div>
                <div class="row"><span class="label">Payment ID</span><span class="value">{{ $payment->razorpay_payment_id }}</span></div>
            </div>
            <p>The event team will contact you with sponsor coordination details and branding requirements.</p>
            <p class="muted">A PDF sponsorship invoice is attached to this email. GST-specific fields can be added once final GST details are provided.</p>
        </div>
        <div class="footer">Ananth Decodes Logistics</div>
    </div>
</div>
</body>
</html>
