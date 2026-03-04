@extends('layouts.app')
@section('title', 'Finance')

@section('content')
<div class="finance-page">
    <div class="page-header">
        <h1>Financial Ledger</h1>
        <p>{{ $student->full_name }} — {{ $student->student_number }}</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">💰</div>
            <div class="stat-value">₱{{ number_format($summary['tuition_balance'], 2) }}</div>
            <div class="stat-label">Tuition Balance</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🎓</div>
            <div class="stat-value">₱{{ number_format($summary['scholarship_balance'], 2) }}</div>
            <div class="stat-label">Scholarship Balance</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-value">₱{{ number_format($summary['total_paid'], 2) }}</div>
            <div class="stat-label">Total Paid</div>
        </div>
    </div>

    <div class="grid-two-col">
        {{-- Payment Form --}}
        <div class="card">
            <div class="card-header"><h2>Make a Payment</h2></div>
            <form method="POST" action="{{ route('finance.payment') }}">
                @csrf
                <div class="form-group">
                    <label for="amount">Amount (₱)</label>
                    <input type="number" id="amount" name="amount" min="100" max="100000" step="0.01"
                           placeholder="e.g. 5000" required>
                </div>
                <div class="form-group">
                    <label for="method">Payment Method</label>
                    <select id="method" name="method" required>
                        <option value="gcash">GCash</option>
                        <option value="bank_transfer">Bank Transfer</option>
                        <option value="cash">Cash (Over-the-Counter)</option>
                        <option value="scholarship">Scholarship Balance</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Process Payment</button>
            </form>
        </div>

        {{-- Payment History --}}
        <div class="card">
            <div class="card-header"><h2>Payment History</h2></div>
            @if($payments->count() > 0)
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Reference</th>
                        <th>Amount</th>
                        <th>Method</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                    <tr>
                        <td><small>{{ $payment->reference_number }}</small></td>
                        <td>₱{{ number_format($payment->amount, 2) }}</td>
                        <td>{{ ucfirst($payment->method) }}</td>
                        <td>
                            <span class="badge badge-{{ $payment->status === 'completed' ? 'success' : 'warning' }}">
                                {{ ucfirst($payment->status) }}
                            </span>
                        </td>
                        <td>{{ $payment->paid_at?->format('M d, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $payments->links() }}
            @else
            <div class="empty-state"><p>No payment records yet.</p></div>
            @endif
        </div>
    </div>
</div>
@endsection