@extends('layouts.guest')

@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="separator">/</span>
        <a href="{{ route('orders') }}">Orders</a>
        <span class="separator">/</span>
        <span class="current">#{{ $order->order_number }}</span>
    </div>

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Order #{{ $order->order_number }}</h1>
        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
            {{ !in_array($order->status, ['delivered','cancelled']) ? 'bg-yellow-100 text-yellow-800' : '' }}">
            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
        </span>
    </div>

    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="card p-6">
            <h3 class="font-semibold text-primary mb-3">Shipping Address</h3>
            <p class="text-sm text-gray-600">{{ $order->shipping_name }}</p>
            <p class="text-sm text-gray-600">{{ $order->shipping_phone }}</p>
            <p class="text-sm text-gray-600">{{ $order->shipping_address }}</p>
            <p class="text-sm text-gray-600">{{ $order->shipping_city }}, {{ $order->shipping_state }} - {{ $order->shipping_pincode }}</p>
        </div>
        <div class="card p-6">
            <h3 class="font-semibold text-primary mb-3">Order Details</h3>
            <p class="text-sm text-gray-600">Order Date: {{ $order->created_at->format('d M Y, h:i A') }}</p>
            <p class="text-sm text-gray-600">Payment Method: UPI / Bank Transfer</p>
            <p class="text-sm text-gray-600">Items: {{ $order->items->count() }}</p>
        </div>
        <div class="card p-6">
            <h3 class="font-semibold text-primary mb-3">Order Summary</h3>
            <div class="space-y-1 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-600">Subtotal</span>
                    <span>₹{{ number_format($order->subtotal, 2) }}</span>
                </div>
                @if($order->discount > 0)
                    <div class="flex justify-between">
                        <span class="text-gray-600">Discount</span>
                        <span class="text-success">-₹{{ number_format($order->discount, 2) }}</span>
                    </div>
                @endif
                <div class="flex justify-between font-bold text-lg pt-2 border-t">
                    <span>Total</span>
                    <span class="text-primary">₹{{ number_format($order->total, 2) }}</span>
                </div>
            </div>
        </div>
    </div>

    <div class="card p-6 mb-6">
        <h3 class="font-semibold text-primary mb-4">Order Items</h3>
        <div class="space-y-4">
            @foreach($order->items as $item)
                <div class="flex items-center gap-4 pb-4 border-b border-gray-100 last:border-0">
                    <div class="w-16 h-16 bg-gray-50 rounded-lg flex items-center justify-center shrink-0">
                        <span class="text-2xl">📦</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-primary">{{ $item->product->name }}</h4>
                        <p class="text-sm text-gray-500">SKU: {{ $item->product->sku ?? 'N/A' }}</p>
                        <p class="text-sm text-gray-600">Qty: {{ $item->quantity }} × ₹{{ number_format($item->unit_price, 2) }}</p>
                    </div>
                    <div class="text-right">
                        <p class="font-semibold text-primary">₹{{ number_format($item->subtotal, 2) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    @if($order->status === 'pending_payment_verification')
    <div class="card p-6 mb-6 border-l-4 border-yellow-400">
        <h3 class="font-semibold text-primary mb-4">Payment Under Verification</h3>
        <p class="text-sm text-gray-600 mb-4">Your payment proof has been submitted and is pending verification by the admin. You will be notified via email once verified.</p>
        <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm">
            <p><strong>UTR / Transaction ID:</strong> <span class="font-medium">{{ $order->payment?->utr_number ?? 'N/A' }}</span></p>
            <p><strong>Payment Method:</strong> <span class="font-medium capitalize">{{ str_replace('_', ' ', $order->payment_method ?? 'N/A') }}</span></p>
            <p><strong>Amount:</strong> <span class="font-medium">₹{{ number_format($order->total, 2) }}</span></p>
            <p><strong>Status:</strong> <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending Verification</span></p>
        </div>
    </div>
    @endif

    @if($order->status === 'pending_payment')
    <div class="card p-6 mb-6 border-l-4 border-red-400">
        <h3 class="font-semibold text-primary mb-4">Payment Required</h3>
        <p class="text-sm text-gray-600 mb-4">Your payment was not submitted or was rejected. Please make the payment and submit the proof.</p>
        <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm">
            <p><strong>Total Amount:</strong> ₹{{ number_format($order->total, 2) }}</p>
            @if($order->payment && $order->payment->rejection_reason)
                <p class="text-red-600"><strong>Rejection Reason:</strong> {{ $order->payment->rejection_reason }}</p>
            @endif
        </div>
        <a href="{{ route('payment.form', $order) }}" class="btn-primary mt-4 inline-block">Submit Payment Proof</a>
    </div>
    @endif

    <div class="flex gap-4">
        <a href="{{ route('orders') }}" class="btn-outline">Back to Orders</a>
        <a href="{{ route('shop') }}" class="btn-primary">Continue Shopping</a>
    </div>
</div>
@endsection
