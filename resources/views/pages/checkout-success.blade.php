@extends('layouts.guest')

@section('title', 'Order Placed Successfully')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16 text-center">
    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    </div>
    <h1 class="text-3xl font-bold text-primary mb-4">Order Placed Successfully!</h1>
    <p class="text-gray-600 mb-2">Thank you for your order.</p>
    <p class="text-lg font-semibold text-primary mb-4">Order #{{ $order->order_number }}</p>

    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-8 text-left">
        <div class="flex items-start gap-3">
            <svg class="w-6 h-6 text-yellow-600 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            <div>
                <p class="font-medium text-yellow-800">Payment Submitted for Verification</p>
                <p class="text-sm text-yellow-700 mt-1">Your payment proof has been received and is pending verification. You will receive an email notification once the payment is verified (usually within 24 hours).</p>
            </div>
        </div>
    </div>

    <div class="card p-6 mb-8 text-left">
        <h3 class="font-semibold text-primary mb-4">Order Summary</h3>
        <div class="space-y-2 text-sm">
            <div class="flex justify-between">
                <span class="text-gray-600">UTR / Transaction ID</span>
                <span class="font-medium">{{ $order->payment?->utr_number ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Payment Method</span>
                <span class="font-medium capitalize">{{ str_replace('_', ' ', $order->payment_method ?? 'N/A') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Amount Paid</span>
                <span class="font-medium">₹{{ number_format($order->total, 2) }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-gray-600">Payment Status</span>
                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending Verification</span>
            </div>
        </div>
    </div>

    <div class="flex gap-4 justify-center">
        <a href="{{ route('order.detail', $order->id) }}" class="btn-primary">View Order</a>
        <a href="{{ route('shop') }}" class="btn-outline">Continue Shopping</a>
    </div>
</div>
@endsection
