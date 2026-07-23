@extends('layouts.guest')

@section('title', $product->name)

@section('meta_description', $product->meta_description ?? $product->short_description ?? Str::limit($product->description, 150))

@section('content')
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="breadcrumb mb-6">
            <a href="{{ route('home') }}">Home</a>
            <span class="separator">/</span>
            <a href="{{ route('shop') }}">Products</a>
            <span class="separator">/</span>
            <a href="{{ route('shop', ['category' => $product->category->slug]) }}">{{ $product->category->name }}</a>
            <span class="separator">/</span>
            <span class="current">{{ $product->name }}</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-8">
            <!-- Product Images -->
            <div>
                <div class="bg-gray-100 rounded-2xl overflow-hidden mb-4">
                    <img id="mainImage" src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-96 object-cover">
                </div>
                @if($product->images->count() > 1)
                    <div class="grid grid-cols-4 gap-3">
                        @foreach($product->images as $image)
                            <button onclick="changeImage('{{ asset('storage/' . $image->image_path) }}')" class="thumbnail-btn border-2 {{ $image->is_primary ? 'border-secondary' : 'border-gray-200' }} rounded-lg overflow-hidden hover:border-secondary transition-colors">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->alt_text }}" class="w-full h-20 object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>

            <!-- Product Info -->
            <div>
                <h1 class="text-3xl font-bold text-primary mb-2">{{ $product->name }}</h1>

                <div class="flex items-center gap-3 mb-4">
                    <span class="text-3xl font-bold text-primary">₹{{ number_format($product->price, 2) }}</span>
                    @if($product->compare_price > $product->price)
                        <span class="text-xl text-gray-400 line-through">₹{{ number_format($product->compare_price, 2) }}</span>
                        <span class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded-full font-medium">
                            {{ $product->discount_percent }}% OFF
                        </span>
                    @endif
                </div>

                <div class="flex items-center gap-2 mb-6">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->is_active ? 'In Stock' : 'Out of Stock' }}
                    </span>
                    <span class="text-sm text-gray-500">SKU: {{ $product->sku ?? 'N/A' }}</span>
                </div>

                <div class="prose max-w-none mb-6">
                    <p class="text-gray-700">{{ $product->short_description ?? Str::limit($product->description, 200) }}</p>
                </div>

                @if($product->specifications)
                    <div class="mb-6">
                        <h3 class="font-semibold text-primary mb-2">Specifications</h3>
                        <div class="bg-gray-50 rounded-lg p-4">
                            @foreach($product->specifications as $key => $value)
                                <div class="flex justify-between py-1">
                                    <span class="text-gray-600">{{ ucfirst($key) }}</span>
                                    <span class="font-medium text-primary">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="flex gap-3 mb-6">
                    <button onclick="addToCart({{ $product->id }})" class="btn-primary flex-1" {{ !$product->is_active ? 'disabled' : '' }}>
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        Add to Cart
                    </button>
                    <button onclick="toggleWishlist({{ $product->id }})" class="btn-outline px-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    </button>
                </div>

                <div class="border-t pt-6">
                    <h3 class="font-semibold text-primary mb-2">Category</h3>
                    <a href="{{ route('shop', ['category' => $product->category->slug]) }}" class="text-secondary hover:underline">
                        {{ $product->category->name }}
                    </a>
                </div>
            </div>
        </div>

        @if($product->description)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-primary mb-4">Product Description</h2>
                <div class="prose max-w-none text-gray-700 whitespace-pre-wrap">{{ $product->description }}</div>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
function changeImage(src) {
    document.getElementById('mainImage').src = src;

    // Update active thumbnail
    document.querySelectorAll('.thumbnail-btn').forEach(btn => {
        btn.classList.remove('border-secondary');
        btn.classList.add('border-gray-200');
    });
    event.target.closest('.thumbnail-btn').classList.remove('border-gray-200');
    event.target.closest('.thumbnail-btn').classList.add('border-secondary');
}

function addToCart(productId) {
    fetch('{{ route('cart.add') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product_id: productId, quantity: 1 })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Product added to cart!');
            updateCartCount(data.cart_count);
        }
    });
}

function toggleWishlist(productId) {
    fetch('{{ route('wishlist.toggle') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ product_id: productId })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
    });
}

function updateCartCount(count) {
    const cartCountElements = document.querySelectorAll('.cart-count');
    cartCountElements.forEach(el => el.textContent = count);
}
</script>
@endpush
@endsection
