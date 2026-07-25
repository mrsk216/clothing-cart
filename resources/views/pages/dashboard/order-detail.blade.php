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
                        @if($order->status === 'delivered')
                            @php
                                $existingReview = $item->product->reviews->where('user_id', auth()->id())->where('order_id', $order->id)->first();
                            @endphp
                            @if(!$existingReview)
                                <button onclick="openReviewModal({{ $order->id }}, {{ $item->id }}, '{{ $item->product->name }}')" class="text-sm text-secondary hover:underline mt-2 inline-block">
                                    Write a Review
                                </button>
                            @else
                                <span class="text-sm text-success mt-2 inline-block">✓ Reviewed</span>
                            @endif
                        @endif
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

    @if($order->status === 'pending_payment' || ($order->payment && $order->payment->status === 'rejected'))
    <div class="card p-6 mb-6 border-l-4 border-red-400">
        <h3 class="font-semibold text-primary mb-4">Payment Required</h3>
        <p class="text-sm text-gray-600 mb-4">Your payment was rejected or not completed. Please submit a new payment proof.</p>
        <div class="bg-gray-50 p-4 rounded-lg space-y-2 text-sm">
            <p><strong>Total Amount:</strong> ₹{{ number_format($order->total, 2) }}</p>
            @if($order->payment && $order->payment->rejection_reason)
                <p class="text-red-600"><strong>Rejection Reason:</strong> {{ $order->payment->rejection_reason }}</p>
            @endif
        </div>
        <a href="{{ route('payment.form', $order) }}" class="btn-primary mt-4 inline-block">Re-submit Payment Proof</a>
    </div>
    @endif

    @if($order->payment_status === 'paid' && $order->invoice_number)
    <div class="card p-6 mb-6 border-l-4 border-green-400">
        <h3 class="font-semibold text-primary mb-4">GST Invoice</h3>
        <p class="text-sm text-gray-600 mb-4">Your payment has been verified. Invoice <strong>{{ $order->invoice_number }}</strong> is ready.</p>
        <div class="flex gap-3">
            <a href="{{ route('invoice.view', $order) }}" class="btn-primary inline-block" target="_blank">View Invoice (PDF)</a>
            <a href="{{ route('invoice.download', $order) }}" class="btn-outline inline-block">Download Invoice (PDF)</a>
        </div>
    </div>
    @endif

    @if($order->status === 'delivered')
    <div class="card p-6 mb-6 border-l-4 border-secondary">
        <h3 class="font-semibold text-primary mb-4">Review Your Products</h3>
        <p class="text-sm text-gray-600 mb-4">Share your experience with these products to help other customers.</p>
        @foreach($order->items as $item)
            @php
                $existingReview = $item->product->reviews->where('user_id', auth()->id())->where('order_id', $order->id)->first();
            @endphp
            <div class="border-b border-gray-100 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                <div class="flex items-center gap-4 mb-3">
                    <div class="w-12 h-12 bg-gray-50 rounded-lg flex items-center justify-center shrink-0">
                        <span class="text-xl">📦</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-medium text-primary text-sm">{{ $item->product->name }}</h4>
                    </div>
                </div>
                @if($existingReview)
                    <div class="bg-gray-50 rounded-lg p-3 text-sm">
                        <div class="flex items-center gap-1 mb-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $existingReview->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            @endfor
                        </div>
                        <p class="text-gray-600">{{ $existingReview->comment ?? 'No comment' }}</p>
                        <p class="text-xs text-gray-400 mt-1">
                            @if($existingReview->is_approved)
                                <span class="text-success">✓ Approved</span>
                            @else
                                <span class="text-yellow-600">⏳ Pending approval</span>
                            @endif
                        </p>
                    </div>
                @else
                    <form method="POST" action="{{ route('review.store') }}" class="space-y-3">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Rating</label>
                            <div class="star-rating flex gap-1">
                                @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $item->id }}_{{ $i }}" name="rating" value="{{ $i }}" class="hidden" required>
                                    <label for="star{{ $item->id }}_{{ $i }}" class="cursor-pointer text-2xl text-gray-300 hover:text-yellow-400 star-label">★</label>
                                @endfor
                            </div>
                            @error('rating')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <textarea name="comment" rows="2" class="input-field text-sm" placeholder="Share your experience with this product..."></textarea>
                        </div>
                        <button type="submit" class="btn-primary text-sm py-1.5 px-4">Submit Review</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
    @endif

    <div class="flex gap-4">
        <a href="{{ route('orders') }}" class="btn-outline">Back to Orders</a>
        <a href="{{ route('shop') }}" class="btn-primary">Continue Shopping</a>
    </div>
</div>
@endsection
