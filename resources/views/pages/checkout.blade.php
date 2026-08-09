@extends('layouts.guest')

@section('title', 'Checkout')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <a href="{{ route('cart') }}">Cart</a>
        <span class="separator">/</span>
        <span class="current">Checkout</span>
    </div>

    <h1 class="text-2xl font-serif font-bold text-primary mb-6">Checkout</h1>

    <form method="POST" action="{{ route('checkout.process') }}" enctype="multipart/form-data" class="grid lg:grid-cols-3 gap-8">
        @csrf
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                <h3 class="font-serif font-semibold text-primary mb-4">Shipping Address</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name', $customerAddress->full_name ?? auth()->user()->name) }}" required class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                        <input type="text" name="phone" value="{{ old('phone', $customerAddress->phone ?? '') }}" required class="input-field">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                        <textarea name="address" rows="3" required class="input-field">{{ old('address', $customerAddress->address_line1 ?? '') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                        <input type="text" name="city" value="{{ old('city', $customerAddress->city ?? '') }}" required class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                        <input type="text" name="state" value="{{ old('state', $customerAddress->state ?? '') }}" required class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pincode *</label>
                        <input type="text" name="pincode" value="{{ old('pincode', $customerAddress->pincode ?? '') }}" required class="input-field">
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="font-serif font-semibold text-primary mb-4">Payment Method</h3>
                <p class="text-gray-400 text-sm">Payment Method will be place here</p>
                {{-- <div class="space-y-3">
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
                </div> --}}
            </div>

            <!-- Payment Details Section -->
            {{-- <div class="card p-6" id="paymentDetails">
                <h3 class="font-serif font-semibold text-primary mb-4">Payment Details</h3>

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
            </div> --}}
        </div>

        <div class="lg:col-span-1">
            <div class="card p-6">
                <h3 class="font-serif font-semibold text-primary mb-4">Order Summary</h3>
                <div class="space-y-2 mb-4">
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Subtotal</span>
                        <span class="font-medium">₹{{ number_format($cart->subtotal, 2) }}</span>
                    </div>
                    @if($cart->discount > 0)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">Discount</span>
                            <span class="font-medium text-success">-₹{{ number_format($cart->discount, 2) }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between text-sm">
                        <span class="text-gray-600">Shipping</span>
                        <span class="font-medium">{{ $cart->subtotal >= 500 ? 'FREE' : '₹50' }}</span>
                    </div>
                    <hr class="border-gray-200">
                    <div class="flex justify-between text-lg font-bold">
                        <span>Total</span>
                        <span class="text-primary">₹{{ number_format($cart->total + ($cart->subtotal >= 500 ? 0 : 50), 2) }}</span>
                    </div>
                </div>
                <button type="submit" class="w-full btn-primary">Place Order</button>
            </div>
        </div>
    </form>
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
