@extends('layouts.guest')

@section('title', 'Products - ' . $siteName())

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <span class="current">Products</span>
    </div>

    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Filters Sidebar -->
        <div class="w-full lg:w-64 shrink-0 space-y-4">
            <div class="card p-4">
                <h3 class="font-semibold text-primary mb-4">Categories</h3>
                <div class="space-y-2">
                    <a href="{{ route('shop', request()->except('category', 'page')) }}" class="block text-sm {{ !request('category') ? 'text-secondary font-medium' : 'text-gray-600 hover:text-secondary' }}">All Products</a>
                    @foreach($categories as $category)
                        <div>
                            <a href="{{ route('shop', array_merge(request()->except('page'), ['category' => $category->slug])) }}" class="block text-sm {{ request('category') === $category->slug ? 'text-secondary font-medium' : 'text-gray-600 hover:text-secondary' }}">
                                {{ $category->name }}
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="card p-4">
                <h3 class="font-semibold text-primary mb-4">Price Filter</h3>
                <form method="GET" action="{{ route('shop') }}" class="space-y-3">
                    @if(request('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    @if(request('sort'))
                        <input type="hidden" name="sort" value="{{ request('sort') }}">
                    @endif
                    @if(request('search'))
                        <input type="hidden" name="search" value="{{ request('search') }}">
                    @endif
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Min Price (₹)</label>
                        <input type="number" name="min_price" min="0" value="{{ request('min_price') }}" class="input-field text-sm" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Max Price (₹)</label>
                        <input type="number" name="max_price" min="0" value="{{ request('max_price') }}" class="input-field text-sm" placeholder="5000">
                    </div>
                    <button type="submit" class="btn-primary w-full text-sm py-2">Apply</button>
                    @if(request()->hasAny(['min_price', 'max_price', 'search', 'category']))
                        <a href="{{ route('shop') }}" class="block text-center text-sm text-gray-500 hover:text-secondary">Clear filters</a>
                    @endif
                </form>
            </div>
        </div>

        <!-- Products Grid -->
        <div class="flex-1">
            <div class="flex items-center justify-between mb-6">
                <p class="text-sm text-gray-500">Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} products</p>
                <form method="GET" class="flex items-center gap-2">
                    @foreach(request()->except('sort', 'page') as $key => $value)
                        @if(filled($value))
                            <input type="hidden" name="{{ $key }}" value="{{ $value }}">
                        @endif
                    @endforeach
                    <select name="sort" onchange="this.form.submit()" class="text-sm border border-gray-300 rounded-lg px-3 py-2 focus:border-secondary focus:outline-none">
                        <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Latest</option>
                        <option value="price-low" {{ request('sort') === 'price-low' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="price-high" {{ request('sort') === 'price-high' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Name</option>
                    </select>
                </form>
            </div>

            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <div class="product-card">
                            <a href="{{ route('product.detail', $product->slug) }}" class="block aspect-square bg-gray-50 overflow-hidden">
                                <div class="w-full h-full bg-gradient-to-br from-secondary/10 to-primary/10 flex items-center justify-center">
                                    @if ($product->primaryImage != null)
                                        <img src="{{ asset('storage/'. $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full">
                                    @else
                                        <span class="text-4xl">📦</span>
                                    @endif
                                </div>
                            </a>
                            <div class="p-4">
                                <span class="text-xs text-secondary font-medium">{{ $product->category?->name ?? 'General' }}</span>
                                <a href="{{ route('product.detail', $product->slug) }}">
                                    <h3 class="font-semibold text-primary mt-1 mb-2 line-clamp-2 hover:text-secondary">{{ $product->name }}</h3>
                                </a>
                                <div class="flex items-center gap-2 mb-3">
                                    <span class="text-xl font-bold text-primary">₹{{ number_format($product->final_price, 2) }}</span>
                                    @if($product->compare_price)
                                        <span class="text-sm text-gray-400 line-through">₹{{ number_format($product->compare_price, 2) }}</span>
                                    @endif
                                </div>
                                <div class="flex gap-2 mt-2">
                                    @if($product->stock_quantity > 0)
                                        <button onclick="addToCart({{ $product->id }})" class="flex-1 btn-primary text-sm py-2">
                                            Add to Cart
                                        </button>
                                    @else
                                        <button class="flex-1 btn-primary text-sm py-2" disabled>
                                            Out of Stock
                                        </button>
                                    @endif
                                    <button onclick="addToWishlist({{ $product->id }})" class="w-10 h-10 bg-white rounded-lg shadow flex items-center justify-center text-gray-600 hover:text-error transition-colors">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16">
                    <span class="text-5xl mb-4 block">🔍</span>
                    <h3 class="text-xl font-semibold text-primary mb-2">No Products Found</h3>
                    <p class="text-gray-500 mb-6">Try adjusting your search or filter criteria</p>
                    <a href="{{ route('shop') }}" class="btn-primary">Clear Filters</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function addToWishlist(productId) {
        fetch('/wishlist/toggle', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ product_id: productId })
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast(data.message || 'Wishlist updated!', 'success');
            } else {
                showToast(data.message || 'Please login to add to wishlist', 'warning');
            }
        })
        .catch(() => showToast('Something went wrong', 'error'));
    }
</script>
@endpush
