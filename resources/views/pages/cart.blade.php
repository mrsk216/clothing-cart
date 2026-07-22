@extends('layouts.guest')

@section('title', 'Shopping Cart')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <span class="current">Shopping Cart</span>
    </div>

    <h1 class="text-2xl font-bold text-primary mb-6">Shopping Cart</h1>

    @if($cart && $cart->items->count() > 0)
        <div class="grid lg:grid-cols-3 gap-8">
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart->items as $item)
                    <div class="card p-4">
                        <div class="flex gap-4">
                            <div class="w-24 h-24 bg-gray-50 rounded-lg flex items-center justify-center shrink-0">
                                <span class="text-3xl">📦</span>
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-primary mb-1">{{ $item->product->name }}</h3>
                                <p class="text-sm text-gray-500 mb-2">SKU: {{ $item->product->sku }}</p>
                                <div class="flex items-center justify-between">
                                    <div class="qty-input">
                                        <button type="button" onclick="updateCartItem({{ $item->id }}, {{ $item->quantity - 1 }})">-</button>
                                        <input type="number" value="{{ $item->quantity }}" min="1" max="100" readonly class="w-16">
                                        <button type="button" onclick="updateCartItem({{ $item->id }}, {{ $item->quantity + 1 }})">+</button>
                                    </div>
                                    <div class="text-right">
                                        <p class="font-bold text-primary">₹{{ number_format($item->subtotal, 2) }}</p>
                                        <p class="text-xs text-gray-500">₹{{ number_format($item->unit_price, 2) }} each</p>
                                    </div>
                                </div>
                            </div>
                            <button onclick="removeCartItem({{ $item->id }})" class="text-gray-400 hover:text-error">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="lg:col-span-1">
                <div class="card p-6">
                    <h3 class="font-semibold text-primary mb-4">Cart Summary</h3>
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

                    <form method="POST" action="{{ route('cart.apply-coupon') }}" class="mb-4">
                        @csrf
                        <input type="text" name="coupon_code" placeholder="Coupon Code" class="input-field text-sm mb-2">
                        <button type="submit" class="w-full btn-outline text-sm">Apply Coupon</button>
                    </form>

                    <a href="{{ route('checkout') }}" class="block w-full btn-primary text-center">Proceed to Checkout</a>
                    <a href="{{ route('shop') }}" class="block w-full text-center text-sm text-secondary mt-3 hover:underline">Continue Shopping</a>
                </div>
            </div>
        </div>
    @else
        <div class="text-center py-16">
            <span class="text-5xl mb-4 block">🛒</span>
            <h3 class="text-xl font-semibold text-primary mb-2">Your cart is empty</h3>
            <p class="text-gray-500 mb-6">Looks like you haven't added any products yet</p>
            <a href="{{ route('shop') }}" class="btn-primary">Start Shopping</a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
function updateCartItem(itemId, qty) {
    if (qty < 1) return;
    fetch(`/cart/update`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
        body: JSON.stringify({ item_id: itemId, quantity: qty })
    }).then(() => location.reload());
}
function removeCartItem(itemId) {
    if (confirm('Remove this item?')) {
        fetch(`/cart/remove`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: JSON.stringify({ item_id: itemId })
        }).then(() => location.reload());
    }
}
</script>
@endpush
