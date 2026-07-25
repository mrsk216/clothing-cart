@extends('admin.layout')

@section('title', 'Payment Verification')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-primary mb-6">Payment Verification</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-6">
        @forelse($payments as $payment)
            <div class="card p-6">
                <div class="grid lg:grid-cols-3 gap-6">
                    <div class="space-y-3">
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Order ID</p>
                            <a href="{{ route('admin.orders.show', $payment->order_id) }}" class="text-secondary hover:underline font-semibold">
                                #{{ $payment->order->order_number ?? 'N/A' }}
                            </a>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Customer Details</p>
                            <p class="font-medium text-primary">{{ $payment->order->user?->name ?? 'Guest' }}</p>
                            <p class="text-sm text-gray-600">{{ $payment->order->user?->email ?? '' }}</p>
                            <p class="text-sm text-gray-600">{{ $payment->order->shipping_phone ?? '' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">Amount</p>
                            <p class="text-xl font-bold text-primary">₹{{ number_format($payment->amount, 2) }}</p>
                            <p class="text-sm capitalize text-gray-600">{{ str_replace('_', ' ', $payment->payment_method ?? 'N/A') }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500 uppercase tracking-wide">UTR Number</p>
                            <p class="font-mono text-sm">{{ $payment->utr_number }}</p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Products</p>
                        <div class="space-y-2">
                            @forelse($payment->order->items ?? [] as $item)
                                <div class="flex justify-between text-sm bg-gray-50 rounded-lg px-3 py-2">
                                    <span>{{ $item->product_name }} × {{ $item->quantity }}</span>
                                    <span class="font-medium">₹{{ number_format($item->subtotal, 2) }}</span>
                                </div>
                            @empty
                                <p class="text-sm text-gray-400">No items</p>
                            @endforelse
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-gray-500 uppercase tracking-wide mb-2">Screenshot Preview</p>
                        @if($payment->screenshot_path)
                            @php $ext = strtolower(pathinfo($payment->screenshot_path, PATHINFO_EXTENSION)); @endphp
                            @if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                <a href="{{ asset('storage/' . $payment->screenshot_path) }}" target="_blank">
                                    <img src="{{ asset('storage/' . $payment->screenshot_path) }}" alt="Payment screenshot" class="w-full max-h-56 object-contain border rounded-lg bg-gray-50">
                                </a>
                            @else
                                <a href="{{ asset('storage/' . $payment->screenshot_path) }}" target="_blank" class="inline-flex items-center gap-2 text-secondary hover:underline text-sm">
                                    View PDF proof
                                </a>
                            @endif
                        @else
                            <p class="text-sm text-gray-400">No screenshot</p>
                        @endif

                        <div class="flex gap-2 mt-4">
                            <form method="POST" action="{{ route('admin.payment.verify', $payment->id) }}" onsubmit="return confirm('Approve this payment?')">
                                @csrf
                                <input type="hidden" name="status" value="approved">
                                <button type="submit" class="btn-primary text-sm">Approve</button>
                            </form>
                            <button
                                type="button"
                                class="reject-btn btn-outline text-sm text-red-600 border-red-300"
                                data-payment-id="{{ $payment->id }}"
                                data-order-number="{{ $payment->order->order_number ?? 'N/A' }}"
                                data-customer-name="{{ $payment->order->user?->name ?? 'Guest' }}"
                                data-amount="₹{{ number_format($payment->amount, 2) }}"
                                data-utr="{{ $payment->utr_number }}"
                            >Reject</button>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="card p-8 text-center text-gray-400">No pending payments.</div>
        @endforelse

        @if($payments->hasPages())
            <div>{{ $payments->links() }}</div>
        @endif
    </div>

    <div class="card p-6 mt-8">
        <h2 class="text-lg font-semibold text-primary mb-4">Payment Verification Logs</h2>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Order</th>
                        <th>Admin</th>
                        <th>Action</th>
                        <th>Reason</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="text-sm">{{ $log->created_at->format('d M Y, h:i A') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $log->order_id) }}" class="text-secondary hover:underline">
                                    #{{ $log->order->order_number ?? $log->order_id }}
                                </a>
                            </td>
                            <td>{{ $log->admin?->name ?? 'N/A' }}</td>
                            <td>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $log->action === 'approved' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($log->action) }}
                                </span>
                            </td>
                            <td class="text-sm text-gray-600">{{ $log->rejection_reason ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-gray-400 py-6">No verification logs yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($logs->hasPages())
            <div class="mt-4">{{ $logs->links() }}</div>
        @endif
    </div>
</div>

<div id="rejectModal" class="modal-backdrop hidden" aria-hidden="true" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3 class="font-semibold text-primary">Reject Payment</h3>
        </div>
        <form id="rejectForm" method="POST" action="#">
            @csrf
            <input type="hidden" name="status" value="rejected">
            <div class="modal-body">
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
                <button type="button" id="closeRejectModalBtn" class="btn-outline">Cancel</button>
                <button type="submit" class="btn-danger">Reject Payment</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const modal = document.getElementById('rejectModal');
    const form = document.getElementById('rejectForm');

    function closeRejectModal() {
        modal.classList.add('hidden');
        modal.style.display = 'none';
        modal.setAttribute('aria-hidden', 'true');
        form.reset();
        form.action = '#';
    }

    function showRejectModal(btn) {
        form.action = '/admin/payment-verify/' + btn.dataset.paymentId;
        document.getElementById('modalOrderNumber').textContent = '#' + btn.dataset.orderNumber;
        document.getElementById('modalCustomerName').textContent = btn.dataset.customerName;
        document.getElementById('modalAmount').textContent = btn.dataset.amount;
        document.getElementById('modalUtrNumber').textContent = btn.dataset.utr;
        modal.classList.remove('hidden');
        modal.style.display = 'flex';
        modal.setAttribute('aria-hidden', 'false');
    }

    document.querySelectorAll('.reject-btn').forEach(function (btn) {
        btn.addEventListener('click', function () {
            showRejectModal(btn);
        });
    });

    document.getElementById('closeRejectModalBtn').addEventListener('click', closeRejectModal);

    modal.addEventListener('click', function (e) {
        if (e.target === modal) {
            closeRejectModal();
        }
    });

    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
            closeRejectModal();
        }
    });
})();
</script>
@endpush
