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

    <h1 class="text-2xl font-bold text-primary mb-6">Checkout</h1>

    <form method="POST" action="{{ route('checkout.process') }}" class="grid lg:grid-cols-3 gap-8">
        @csrf
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Shipping Address</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                        <input type="text" name="name" value="{{ old('name', auth()->user()->name ?? '') }}" required class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                        <input type="text" name="phone" value="{{ old('phone') }}" required class="input-field">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                        <textarea name="address" rows="3" required class="input-field">{{ old('address') }}</textarea>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                        <input type="text" name="city" value="{{ old('city') }}" required class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                        <input type="text" name="state" value="{{ old('state') }}" required class="input-field">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Pincode *</label>
                        <input type="text" name="pincode" value="{{ old('pincode') }}" required class="input-field">
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Payment Method</h3>
                <div class="space-y-3">
                    <label class="flex items-center gap-3 p-4 border-2 border-secondary rounded-lg cursor-pointer">
                        <input type="radio" name="payment_method" value="upi" checked class="text-secondary">
                        <div>
                            <p class="font-medium text-primary">UPI / Bank Transfer</p>
                            <p class="text-sm text-gray-500">Pay via UPI or direct bank transfer</p>
                        </div>
                    </label>
                </div>
            </div>
        </div>

        <div class="lg:col-span-1">
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Order Summary</h3>
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
@endsection
