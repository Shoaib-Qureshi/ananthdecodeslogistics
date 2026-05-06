<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css?v=') . time() }}">
    <title>Sponsor Payments</title>
    @include('admin.events.partials.styles')
</head>
<body>
@include('admin.adminHeader')
<section class="main_section">
    <div class="container-fluid">
        <div class="event-admin-hero">
            <div><h2>Sponsor Payments</h2><p>Payment records created through sponsor package checkout.</p></div>
            <a class="event-admin-btn" href="{{ route('admin.events.packages') }}">Sponsor Packages</a>
        </div>
        <div class="event-admin-card">
            <table class="event-admin-table">
                <thead><tr><th>Company</th><th>Package</th><th>Amount</th><th>Gateway</th><th>Status</th><th>Created</th></tr></thead>
                <tbody>
                @forelse($payments as $payment)
                    <tr>
                        <td><strong>{{ $payment->company }}</strong><br>{{ $payment->contact_name }}<br>{{ $payment->email }}</td>
                        <td>{{ $payment->package?->name }}</td>
                        <td>
                            Base: {{ $payment->currency }} {{ number_format($payment->base_amount, 2) }}<br>
                            {{ $payment->tax_label }}: {{ $payment->currency }} {{ number_format($payment->tax_amount, 2) }}<br>
                            <strong>Total: {{ $payment->currency }} {{ number_format($payment->total_amount, 2) }}</strong>
                        </td>
                        <td>{{ $payment->razorpay_order_id }}<br>{{ $payment->razorpay_payment_id }}</td>
                        <td>{{ ucfirst($payment->status) }}</td>
                        <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6">No sponsor payments yet.</td></tr>
                @endforelse
                </tbody>
            </table>
            <div class="mt-3">{{ $payments->links() }}</div>
        </div>
    </div>
</section>
@include('admin.adminFooter')
</body>
</html>
