<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Complete your sponsorship via bank transfer</title>
    @include('emails.events.partials.styles')
</head>
<body>
<div class="wrap">
    <div class="card">
        <div class="header">
            <p class="eyebrow">{{ $payment->event?->name ?: 'LogiSphere' }}</p>
            <h1>Complete your sponsorship via bank transfer.</h1>
        </div>
        <div class="body">
            <p>Hello {{ $payment->contact_name }},</p>
            <p>Thank you for choosing to sponsor as {{ $payment->company }}. To confirm your
                <strong>{{ $payment->package?->name }}</strong> sponsorship, please transfer the amount below to our
                bank account and quote the payment reference in your transfer remarks.</p>
            <div class="panel">
                <div class="row"><span class="label">Package</span><span class="value">{{ $payment->package?->name }}</span></div>
                <div class="row"><span class="label">Base amount</span><span class="value">{{ $payment->currency }} {{ number_format((float) $payment->base_amount, 2) }}</span></div>
                <div class="row"><span class="label">{{ $payment->tax_label ?: 'Tax' }}</span><span class="value">{{ $payment->currency }} {{ number_format((float) $payment->tax_amount, 2) }}</span></div>
                <div class="row"><span class="label">Amount payable</span><span class="value">{{ $payment->currency }} {{ number_format((float) $payment->total_amount, 2) }}</span></div>
                <div class="row"><span class="label">Payment reference</span><span class="value">{{ $reference }}</span></div>
            </div>
            <p style="margin-top:18px"><strong>Bank account details</strong></p>
            <div class="panel">
                <div class="row"><span class="label">Account name</span><span class="value">{{ $bank['account_name'] ?? '' }}</span></div>
                <div class="row"><span class="label">Account number</span><span class="value">{{ $bank['account_number'] ?? '' }}</span></div>
                <div class="row"><span class="label">IFSC code</span><span class="value">{{ $bank['ifsc'] ?? '' }}</span></div>
                <div class="row"><span class="label">Bank</span><span class="value">{{ $bank['bank_name'] ?? '' }}</span></div>
                <div class="row"><span class="label">Branch</span><span class="value">{{ $bank['branch'] ?? '' }}</span></div>
            </div>
            <p>Once your transfer is received and verified, we will email your official PDF invoice and sponsor
                confirmation. Please reply to this email with your transfer confirmation / UTR to speed up verification.</p>
            <p class="muted">Reference {{ $reference }} · Ananth Decodes Logistics GSTIN 29ABFCA6103M1ZI</p>
        </div>
        <div class="footer">Ananth Decodes Logistics</div>
    </div>
</div>
</body>
</html>
