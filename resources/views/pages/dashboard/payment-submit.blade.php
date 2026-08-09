@extends('layouts.guest')

@section('title', 'Submit Payment - Order #' . $order->order_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="separator">/</span>
        <a href="{{ route('orders') }}">Orders</a>
        <span class="separator">/</span>
        <a href="{{ route('order.detail', $order->id) }}">#{{ $order->order_number }}</a>
        <span class="separator">/</span>
        <span class="current">Submit Payment</span>
    </div>

    <h1 class="text-2xl font-bold text-primary mb-6">Submit Payment for Order #{{ $order->order_number }}</h1>

    <div class="grid lg:grid-cols-3 gap-8">
        <div class="lg:col-span-2 space-y-6">
            <form method="POST" action="{{ route('payment.submit', $order) }}" enctype="multipart/form-data">
                @csrf

                <div class="card p-6">
                    <h3 class="font-semibold text-primary mb-4">Payment Method</h3>
                    <div class="space-y-3">
                        <label class="flex items-center gap-3 p-4 border-2 border-secondary rounded-lg cursor-pointer">
                            <input type="radio" name="payment_method" value="qr_code" checked class="text-secondary">
                            <div>
                                <p class="font-medium text-primary">Scan QR Code</p>
                                <p class="text-sm text-gray-500">Pay by scanning the company QR code</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer">
                            <input type="radio" name="payment_method" value="upi" class="text-secondary">
                            <div>
                                <p class="font-medium text-primary">UPI ID</p>
                                <p class="text-sm text-gray-500">Pay via UPI ID (Google Pay, PhonePe, Paytm)</p>
                            </div>
                        </label>
                        <label class="flex items-center gap-3 p-4 border-2 border-gray-200 rounded-lg cursor-pointer">
                            <input type="radio" name="payment_method" value="bank_transfer" class="text-secondary">
                            <div>
                                <p class="font-medium text-primary">Bank Transfer</p>
                                <p class="text-sm text-gray-500">Pay via NEFT/IMPS bank transfer</p>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Payment Details Section -->
                <div class="card p-6" id="paymentDetails">
                    <h3 class="font-semibold text-primary mb-4">Payment Details</h3>

                    <!-- QR Code Payment -->
                    <div id="qrCodeSection" class="payment-section">
                        <div class="bg-gray-50 p-6 rounded-lg text-center">
                            @if(!empty($settings['qr_code_path']))
                                <img src="{{ asset('storage/' . $settings['qr_code_path']) }}" alt="Company QR Code" class="mx-auto mb-4" style="max-width: 200px;">
                            @else
                                <div class="w-48 h-48 bg-gray-200 rounded-lg mx-auto mb-4 flex items-center justify-center">
                                    <span class="text-gray-400 text-sm">QR Code not set</span>
                                </div>
                            @endif
                            <p class="text-sm text-gray-600">Scan the QR code using any UPI app to make payment</p>
                        </div>
                    </div>

                    <!-- UPI Payment -->
                    <div id="upiSection" class="payment-section hidden">
                        <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm">
                            <p><strong>UPI ID:</strong> <span class="text-primary">{{ $settings['upi_id'] ?? 'company@upi' }}</span></p>
                            <p><strong>UPI Name:</strong> <span class="text-primary">{{ $settings['bank_account_name'] ?? 'Clothing Cart' }}</span></p>
                            <p class="text-xs text-gray-500 mt-2">Open your UPI app (Google Pay, PhonePe, Paytm) and pay to this UPI ID</p>
                        </div>
                    </div>

                    <!-- Bank Transfer -->
                    <div id="bankSection" class="payment-section hidden">
                        <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm">
                            <p><strong>Bank Name:</strong> <span class="text-primary">{{ $settings['bank_name'] ?? 'State Bank of India' }}</span></p>
                            <p><strong>Account Name:</strong> <span class="text-primary">{{ $settings['bank_account_name'] ?? 'Clothing Cart' }}</span></p>
                            <p><strong>Account Number:</strong> <span class="text-primary">{{ $settings['bank_account_number'] ?? '123456789012' }}</span></p>
                            <p><strong>IFSC Code:</strong> <span class="text-primary">{{ $settings['bank_ifsc_code'] ?? 'SBIN0001234' }}</span></p>
                            <p><strong>Account Type:</strong> <span class="text-primary">Current Account</span></p>
                        </div>
                    </div>

                    <hr class="border-gray-200 my-4">

                    <h4 class="font-medium text-primary mb-3">Submit Payment Proof</h4>
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">UTR / Transaction ID *</label>
                            <input type="text" name="utr_number" value="{{ old('utr_number') }}" required class="input-field" placeholder="Enter UTR or Transaction ID">
                            @error('utr_number')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Payment Screenshot *</label>
                            <input type="file" name="screenshot" accept=".jpg,.jpeg,.png,.pdf" required class="input-field">
                            <p class="text-xs text-gray-500 mt-1">Accepted: JPG, PNG, PDF (Max: 5MB)</p>
                            @error('screenshot')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button type="submit" class="btn-primary">Submit Payment Proof</button>
                    <a href="{{ route('order.detail', $order->id) }}" class="btn-outline">Cancel</a>
                </div>
            </form>
        </div>

        <div class="lg:col-span-1">
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Order Summary</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Order #</span>
                        <span class="font-medium">#{{ $order->order_number }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">₹{{ number_format($order->subtotal, 2) }}</span>
                    </div>
                    @if($order->discount > 0)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Discount</span>
                            <span class="font-medium text-success">-₹{{ number_format($order->discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium">{{ $order->shipping_charge > 0 ? '₹'.number_format($order->shipping_charge, 2) : 'FREE' }}</span>
                    </div>
                    <hr class="border-gray-200">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span class="text-primary">₹{{ number_format($order->total, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.querySelectorAll('input[name="payment_method"]').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.payment-section').forEach(s => s.classList.add('hidden'));
            if (this.value === 'qr_code') {
                document.getElementById('qrCodeSection').classList.remove('hidden');
            } else if (this.value === 'upi') {
                document.getElementById('upiSection').classList.remove('hidden');
            } else if (this.value === 'bank_transfer') {
                document.getElementById('bankSection').classList.remove('hidden');
            }
        });
    });
</script>
@endpush
@endsection
