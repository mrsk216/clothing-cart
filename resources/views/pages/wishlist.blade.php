@extends('layouts.guest')

@section('title', 'My Wishlist')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <span class="current">My Wishlist</span>
    </div>

    <h1 class="text-2xl font-bold text-primary mb-6">My Wishlist</h1>

    @if($wishlists->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($wishlists as $wishlist)
                <div class="product-card">
                    <a href="{{ route('product.detail', $wishlist->product->slug) }}" class="block aspect-square bg-gray-50 overflow-hidden">
                        <div class="w-full h-full bg-gradient-to-br from-secondary/10 to-primary/10 flex items-center justify-center">
                            @if ($wishlist->product->primaryImage != null)
                                <img src="{{ asset('storage/'. $wishlist->product->primaryImage->image_path) }}" alt="{{ $wishlist->product->name }}" class="w-full h-full">
                            @else
                                <span class="text-4xl">📦</span>
                            @endif
                        </div>
                    </a>
                    <div class="p-4">
                        <h3 class="font-semibold text-primary text-sm mb-2 line-clamp-2">{{ $wishlist->product->name }}</h3>
                        <span class="text-lg font-bold text-primary">₹{{ number_format($wishlist->product->final_price, 2) }}</span>
                        <div class="flex gap-3">
                            <button onclick="addToCart({{ $wishlist->product->id }})" class="flex-1 btn-primary text-sm py-2">
                                Add to Cart
                            </button>
                            <a href="{{ route('wishlist.delete', $wishlist->id) }}" onclick="confirm('Remove from wishlist?')" class="w-10 h-10 bg-white rounded-lg shadow flex items-center justify-center text-gray-600 hover:text-error">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16">
            <span class="text-5xl mb-4 block">💝</span>
            <h3 class="text-xl font-semibold text-primary mb-2">Your wishlist is empty</h3>
            <p class="text-gray-500 mb-6">Save items you like by clicking the heart icon</p>
            <a href="{{ route('shop') }}" class="btn-primary">Start Shopping</a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
@endpush
