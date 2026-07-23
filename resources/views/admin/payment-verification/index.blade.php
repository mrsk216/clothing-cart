@extends('admin.layout')

@section('title', 'Payment Verification')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-primary mb-6">Payment Verification</h1>

    <div class="card p-6">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>UTR Number</th>
                        <th>Payment Proof</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>#{{ $payment->order->order_number ?? 'N/A' }}</td>
                            <td>{{ $payment->order->user?->name ?? 'Guest' }}</td>
                            <td>₹{{ number_format($payment->amount, 2) }}</td>
                            <td>{{ $payment->utr_number }}</td>
                            <td>
                                @if($payment->screenshot_path)
                                    <a href="{{ asset('storage/' . $payment->screenshot_path) }}" target="_blank" class="text-secondary hover:underline text-sm">View</a>
                                @else
                                    <span class="text-gray-500 text-sm">N/A</span>
                                @endif
                            </td>
                            <td>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $payment->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                                    {{ $payment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                                    {{ $payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td>
                                @if($payment->status === 'pending')
                                    <form method="POST" action="{{ route('admin.payment.verify', $payment->id) }}" class="flex gap-2">
                                        @csrf
                                        <input type="hidden" name="status" value="approved">
                                        <button type="submit" class="text-green-600 hover:text-green-800 text-sm">Approve</button>
                                    </form>
                                    <button onclick="showRejectModal({{ $payment->id }})" class="text-red-600 hover:text-red-800 text-sm">Reject</button>
                                @else
                                    <span class="text-gray-500 text-sm">Processed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-400 py-8">No pending payments.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="rejectModal" class="modal-backdrop hidden">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="font-semibold text-primary">Reject Payment</h3>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div class="modal-body">
                <label class="block text-sm font-medium text-gray-700 mb-1">Reason for Rejection</label>
                <select name="rejection_reason" class="input-field" required>
                    <option value="">Select reason</option>
                    <option value="Payment not received">Payment not received in bank account</option>
                    <option value="UTR mismatch">UTR number mismatch</option>
                    <option value="Screenshot unclear">Screenshot not clear</option>
                    <option value="Amount mismatch">Amount mismatch</option>
                    <option value="Duplicate payment">Duplicate payment</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="closeRejectModal()" class="btn-outline">Cancel</button>
                <button type="submit" class="btn-danger">Reject Payment</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function showRejectModal(paymentId) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/payment-verify/${paymentId}`;
    modal.classList.remove('hidden');
}
function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endpush
