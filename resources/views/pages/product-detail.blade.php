@extends('layouts.guest')

@section('title', ($product->meta_title ?: $product->name) . ' - ' . $siteName())
@section('meta_description', $product->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($product->short_description ?: $product->description ?: $product->name), 155))
@section('meta_keywords', is_array($product->tags) ? implode(', ', $product->tags) : ($product->category?->name . ', ' . $product->name))
@section('og_type', 'product')

@push('structured_data')
<script type="application/ld+json">
{!! json_encode([
    '@context' => 'https://schema.org',
    '@type' => 'Product',
    'name' => $product->name,
    'description' => strip_tags($product->short_description ?: $product->description ?: $product->name),
    'sku' => $product->sku,
    'offers' => [
        '@type' => 'Offer',
        'priceCurrency' => 'INR',
        'price' => (string) $product->final_price,
        'availability' => $product->isInStock() ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
        'url' => route('product.detail', $product->slug),
    ],
], JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <a href="{{ route('shop') }}">Products</a>
        <span class="separator">/</span>
        <span class="current">{{ $product->name }}</span>
    </div>

    <div class="grid md:grid-cols-2 gap-8 mb-12">
        <div class="aspect-square mb-4">
            @if ($product->images != null)
                <div class="swiper mySwiper2 productThumbSlider2">
                    <div class="swiper-wrapper">
                        @foreach ($product->images as $pimg)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/'. $pimg->image_path) }}" alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                </div>
                <hr class="border-gray-300 my-2">
                <div thumbsSlider="" class="swiper mySwiper productThumbSlider">
                    <div class="swiper-wrapper">
                        @foreach ($product->images as $pimg)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/'. $pimg->image_path) }}" alt="{{ $product->name }}">
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-button-next productThumbSlider-next !text-white w-8 h-8 bg-primary/80 rounded-full p-3"></div>
                    <div class="swiper-button-prev productThumbSlider-prev !text-white w-8 h-8 bg-primary/80 rounded-full p-3"></div>
                </div>
            @else
                <div class="w-full h-full bg-gradient-to-br from-secondary/10 to-primary/10 flex items-center justify-center rounded-2xl">
                    <span class="text-6xl">👕</span>
                </div>
            @endif
        </div>
        <div>
            <span class="text-sm text-secondary font-medium tracking-wider uppercase">{{ $product->category?->name ?? 'General' }}</span>
            <h1 class="text-2xl md:text-3xl font-serif font-bold text-primary mt-2 mb-4">{{ $product->name }}</h1>

            <div class="flex items-center gap-3 mb-4">
                <span class="text-3xl font-bold text-primary">₹{{ number_format($product->final_price, 2) }}</span>
                @if($product->compare_price)
                    <span class="text-xl text-gray-400 line-through">₹{{ number_format($product->compare_price, 2) }}</span>
                    <span class="badge-secondary">Save {{ $product->discount_percent }}%</span>
                @endif
            </div>

            <p class="text-gray-600 mt-6 mb-4">{{ $product->short_description }}</p>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                <div class="qty-input w-fit">
                    <button type="button" onclick="updateQty(-1)">-</button>
                    <input type="number" id="qty" value="1" min="1" max="100" class="w-20">
                    <button type="button" onclick="updateQty(1)">+</button>
                </div>
            </div>

            <div class="flex gap-3 mb-6">
                @if($product->stock_quantity > 0)
                    <button onclick="addToCart({{ $product->id }}, document.getElementById('qty').value)" class="flex-1 btn-primary">
                        Add to Cart
                    </button>
                @else
                    <button class="flex-1 btn-primary" disabled>
                        Out of Stock
                    </button>
                @endif
                <button onclick="addToWishlist({{ $product->id }})" class="w-12 h-12 border-2 border-gray-300 rounded-full flex items-center justify-center text-gray-600 hover:text-error hover:border-error transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                </button>
            </div>

            <div class="border-t border-gray-200 pt-4 space-y-2 text-sm">
                <p class="flex items-center gap-2">
                    @if($product->stock_quantity > 0)
                        <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        In Stock: {{ $product->stock_quantity }} units
                    @else
                        <svg class="w-5 h-5 text-red-800" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                        Out of Stock
                    @endif
                </p>
                <p class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                    Secure Payment
                </p>
                <p class="flex items-center gap-2">
                    <svg class="w-5 h-5 text-success" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    Easy Returns
                </p>
            </div>
        </div>
    </div>

    <div class="w-full mt-8 p-4" x-data="{ activeTab: 'description' }">
        <!-- Tab Headers -->
        <div class="flex border-b border-slate-200">
            <button
            @click="activeTab = 'description'"
            :class="activeTab === 'description' ? 'border-primary text-primary font-semibold' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
            class="px-4 py-3 border-b-2 text-sm font-medium transition-all duration-200 focus:outline-none">
                Description
            </button>
            <button
            @click="activeTab = 'review'"
            :class="activeTab === 'review' ? 'border-primary text-primary font-semibold' : 'border-transparent text-slate-500 hover:text-slate-700 hover:border-slate-300'"
            class="px-4 py-3 border-b-2 text-sm font-medium transition-all duration-200 focus:outline-none">
                Reviews
            </button>
        </div>

        <!-- Tab Content -->
        <div class="mt-6">
            <!-- Description Content -->
            <div x-show="activeTab === 'description'" x-transition class="space-y-4">
                <p class="text-slate-600 leading-relaxed text-sm">
                    {{ $product->description }}
                </p>
            </div>

            <!-- Review Content -->
            <div x-show="activeTab === 'review'" x-transition class="space-y-4">
                <h2 class="section-title mb-6">Customer Reviews</h2>
                @php
                    $approvedReviews = $product->reviews->where('is_approved', true);
                    $avgRating = $approvedReviews->avg('rating');
                    $totalReviews = $approvedReviews->count();
                @endphp

                @if($totalReviews > 0)
                    <div class="flex items-center gap-4 mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary">{{ number_format($avgRating, 1) }}</div>
                            <div class="flex items-center gap-0.5 mt-1">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                @endfor
                            </div>
                            <p class="text-sm text-gray-500 mt-1">Based on {{ $totalReviews }} review(s)</p>
                        </div>
                    </div>

                    <div class="space-y-4">
                        @foreach($approvedReviews as $review)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <div class="flex items-center gap-2">
                                        <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center">
                                            <span class="text-xs font-bold text-primary">{{ substr($review->user->name, 0, 1) }}</span>
                                        </div>
                                        <div>
                                            <p class="font-medium text-sm text-primary">{{ $review->user->name }}</p>
                                            <p class="text-xs text-gray-400">{{ $review->created_at->format('d M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                </div>
                                @if($review->comment)
                                    <p class="text-sm text-gray-600">{{ $review->comment }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8 bg-gray-50 rounded-lg">
                        <p class="text-gray-500">No reviews yet. Be the first to review this product!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if($relatedProducts->count() > 0)
    <div class="mb-12">
        <h2 class="section-title mb-6">You May Also Like</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $related)
                <div class="product-card">
                    <a href="{{ route('product.detail', $related->slug) }}" class="block fashion-product-image">
                        <div class="w-full h-full bg-gradient-to-br from-secondary/10 to-primary/10 flex items-center justify-center">
                            @if ($related->primaryImage != null)
                                <img src="{{ asset('storage/'. $related->primaryImage->image_path) }}" alt="{{ $related->name }}" class="w-full h-full">
                            @else
                                <span class="text-4xl">👕</span>
                            @endif
                        </div>
                    </a>
                    <div class="p-4">
                        <h3 class="font-semibold text-primary text-sm mb-2 line-clamp-2">{{ $related->name }}</h3>
                        <span class="text-lg font-bold text-primary">₹{{ number_format($related->final_price, 2) }}</span>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    function updateQty(delta) {
        const input = document.getElementById('qty');
        let val = parseInt(input.value) + delta;
        if (val < 1) val = 1;
        if (val > 100) val = 100;
        input.value = val;
    }

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
