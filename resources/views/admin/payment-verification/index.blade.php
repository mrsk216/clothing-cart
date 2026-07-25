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
                        <th>Payment Method</th>
                        <th>UTR Number</th>
                        <th>Payment Proof</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $payment)
                        <tr>
                            <td>
                                <a href="{{ route('admin.orders.show', $payment->order_id) }}" class="text-secondary hover:underline font-medium">
                                    #{{ $payment->order->order_number ?? 'N/A' }}
                                </a>
                            </td>
                            <td>
                                <div class="text-sm">
                                    <p class="font-medium text-gray-900">{{ $payment->order->user?->name ?? 'Guest' }}</p>
                                    <p class="text-gray-500 text-xs">{{ $payment->order->user?->email ?? '' }}</p>
                                </div>
                            </td>
                            <td>₹{{ number_format($payment->amount, 2) }}</td>
                            <td>
                                <span class="text-sm capitalize">{{ str_replace('_', ' ', $payment->payment_method ?? 'N/A') }}</span>
                            </td>
                            <td>
                                <span class="text-sm font-mono">{{ $payment->utr_number }}</span>
                            </td>
                            <td>
                                @if($payment->screenshot_path)
                                    <a href="{{ asset('storage/' . $payment->screenshot_path) }}" target="_blank" class="text-secondary hover:underline text-sm">View Screenshot</a>
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
                                    <div class="flex gap-2">
                                        <form method="POST" action="{{ route('admin.payment.verify', $payment->id) }}" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="approved">
                                            <button type="submit" class="text-green-600 hover:text-green-800 text-sm font-medium">Approve</button>
                                        </form>
                                        <button onclick="showRejectModal({{ $payment->id }}, '{{ $payment->order->order_number ?? 'N/A' }}', '{{ addslashes($payment->order->user?->name ?? 'Guest') }}', '₹{{ number_format($payment->amount, 2) }}', '{{ $payment->utr_number }}')" class="text-red-600 hover:text-red-800 text-sm font-medium">Reject</button>
                                    </div>
                                @else
                                    <span class="text-gray-500 text-sm">Processed</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-gray-400 py-8">No pending payments.</td>
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
            <input type="hidden" name="status" value="rejected">
            <div class="modal-body">
                <!-- Payment Details Summary -->
                <div id="paymentDetailsSummary" class="bg-gray-50 p-4 rounded-lg mb-4 text-sm space-y-1">
                    <p><strong>Order:</strong> <span id="modalOrderNumber" class="text-secondary"></span></p>
                    <p><strong>Customer:</strong> <span id="modalCustomerName"></span></p>
                    <p><strong>Amount:</strong> <span id="modalAmount"></span></p>
                    <p><strong>UTR:</strong> <span id="modalUtrNumber" class="font-mono"></span></p>
                </div>
                <hr class="border-gray-200 my-3">
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
function showRejectModal(paymentId, orderNumber, customerName, amount, utrNumber) {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');
    form.action = `/admin/payment-verify/${paymentId}`;
    modal.classList.remove('hidden');

    // Populate payment details in modal
    document.getElementById('modalOrderNumber').textContent = '#' + orderNumber;
    document.getElementById('modalCustomerName').textContent = customerName;
    document.getElementById('modalAmount').textContent = amount;
    document.getElementById('modalUtrNumber').textContent = utrNumber;
}
function closeRejectModal() {
    document.getElementById('rejectModal').classList.add('hidden');
}
</script>
@endpush
