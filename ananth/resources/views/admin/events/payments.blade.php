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
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            <table class="event-admin-table">
                <thead><tr><th>Company</th><th>Package</th><th>Amount</th><th>Reference</th><th>Status</th><th>Created</th><th>Action</th></tr></thead>
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
                        <td>{{ $payment->transfer_reference ?: '—' }}</td>
                        <td>{{ ucfirst(str_replace('_', ' ', $payment->status)) }}</td>
                        <td>{{ $payment->created_at->format('d M Y H:i') }}</td>
                        <td>
                            @if($payment->status === 'paid')
                                Paid {{ optional($payment->paid_at)->format('d M Y H:i') }}
                            @else
                                <form method="POST" action="{{ route('admin.events.payments.markPaid', $payment) }}">
                                    @csrf
                                    <input type="text" name="transfer_reference" placeholder="UTR / reference" class="form-control form-control-sm mb-1" maxlength="120">
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Mark this sponsor payment as paid and send the invoice email?')">Mark as Paid</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7">No sponsor payments yet.</td></tr>
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
