<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sponsor payment received</title>
    @include('emails.events.partials.styles')
</head>
<body>
<div class="wrap">
    <div class="card">
        <div class="header">
            <p class="eyebrow">Admin notification</p>
            <h1>Sponsor payment received: {{ $payment->company }}</h1>
        </div>
        <div class="body">
            <div class="panel">
                <div class="row"><span class="label">Event</span><span class="value">{{ $payment->event?->publicTitle() ?: 'LogiSphere' }}</span></div>
                <div class="row"><span class="label">Package</span><span class="value">{{ $payment->package?->name }}</span></div>
                <div class="row"><span class="label">Contact</span><span class="value">{{ $payment->contact_name }} - {{ $payment->email }}</span></div>
                <div class="row"><span class="label">Company</span><span class="value">{{ $payment->company }}</span></div>
                <div class="row"><span class="label">GST number</span><span class="value">{{ $payment->gst_number ?: 'Not provided' }}</span></div>
                <div class="row"><span class="label">Total paid</span><span class="value">{{ $payment->currency }} {{ number_format((float) $payment->total_amount, 2) }}</span></div>
                <div class="row"><span class="label">Gateway reference</span><span class="value">{{ $payment->razorpay_payment_id }}</span></div>
            </div>
            <a class="btn" href="{{ route('admin.events.payments') }}">View sponsor payments</a>
        </div>
        <div class="footer">Sent from LogiSphere sponsor checkout.</div>
    </div>
</div>
</body>
</html>
