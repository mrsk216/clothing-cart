@extends('layouts.guest')

@section('title', 'Order Placed Successfully')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-16 text-center">
    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
    </div>
    <h1 class="text-3xl font-bold text-primary mb-4">Order Placed Successfully!</h1>
    <p class="text-gray-600 mb-2">Thank you for your order.</p>
    <p class="text-lg font-semibold text-primary mb-8">Order #{{ $order->order_number }}</p>

    <div class="card p-6 mb-8 text-left">
        <h3 class="font-semibold text-primary mb-4">Payment Instructions</h3>
        <p class="text-sm text-gray-600 mb-4">Please complete your payment using UPI or bank transfer:</p>
        <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm">
            <p><strong>UPI ID:</strong> {{ env('UPI_ID') }}</p>
            <p><strong>Bank:</strong> {{ env('BANK_NAME') }}</p>
            <p><strong>Account:</strong> {{ env('BANK_ACCOUNT_NAME') }}</p>
            <p><strong>IFSC:</strong> {{ env('BANK_IFSC_CODE') }}</p>
            <p><strong>Amount:</strong> ₹{{ number_format($order->total, 2) }}</p>
        </div>
        <p class="text-sm text-gray-600 mt-4">After payment, submit your payment proof from your order page.</p>
    </div>

    <div class="flex gap-4 justify-center">
        <a href="{{ route('order.detail', $order->id) }}" class="btn-primary">View Order</a>
        <a href="{{ route('shop') }}" class="btn-outline">Continue Shopping</a>
    </div>
</div>
@endsection
