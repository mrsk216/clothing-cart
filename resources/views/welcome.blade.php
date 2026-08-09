@extends('layouts.guest')

@section('title', $siteName() . ' - Fashion & Clothing Store')

@section('meta_description', 'Discover the latest fashion trends at ' . $siteName() . '. Shop premium quality clothing, accessories, and footwear for men, women, and kids.')

@section('meta_keywords', 'fashion, clothing, apparel, mens fashion, womens fashion, kids fashion, accessories, footwear, online shopping')

@section('content')
    <!-- Hero Section -->
    <section class="hero-luxe">
        <!-- Soft light gradient wash -->
        <div class="hero-luxe-bg"></div>
        <!-- Colorful floating blobs -->
        <div class="hero-blob hero-blob-1"></div>
        <div class="hero-blob hero-blob-2"></div>
        <div class="hero-blob hero-blob-3"></div>
        <!-- Subtle dotted texture -->
        <div class="hero-dots"></div>

        <div class="relative max-w-7xl mx-auto px-4">
            <div class="grid lg:grid-cols-2 gap-14 items-center">
                <!-- Left: Copy -->
                <div class="text-center lg:text-left animate-fade-in">
                    <span class="hero-badge">
                        <svg fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.077 10.1c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                        New Season Collection 2025
                    </span>
                    <h1 class="hero-title">
                        Elevate Your
                        <span class="hero-accent">Style</span><br>
                        with Modern Fashion
                    </h1>
                    <p class="hero-subtitle">
                        Discover the latest trends in clothing, accessories &amp; footwear — curated collections for every style, every occasion, every you.
                    </p>
                    <div class="flex flex-wrap gap-4 justify-center lg:justify-start mt-8">
                        <a href="{{ route('shop') }}" class="hero-btn hero-btn-primary">
                            Shop Now
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                        <a href="{{ route('shop') }}" class="hero-btn hero-btn-outline">
                            Explore Collection
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                    <!-- Trust Stats -->
                    <div class="hero-stats">
                        <div class="hero-stat">
                            <span class="hero-stat-value">10+</span>
                            <span class="hero-stat-label">Years of Style</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-value">50K+</span>
                            <span class="hero-stat-label">Happy Customers</span>
                        </div>
                        <div class="hero-stat">
                            <span class="hero-stat-value">1000+</span>
                            <span class="hero-stat-label">Fashion Items</span>
                        </div>
                    </div>
                </div>

                <!-- Right: Visual collage -->
                <div class="hero-visual animate-slide-up">
                    <div class="hero-photo">
                        @if(isset($popularProducts[0]) && $popularProducts[0]->primaryImage)
                            <img src="{{ asset('storage/' . $popularProducts[0]->primaryImage->image_path) }}" alt="{{ $popularProducts[0]->name }}">
                        @else
                            <div class="hero-photo-fallback">🛍️</div>
                        @endif
                    </div>

                    <!-- Floating: trending product card -->
                    @if(isset($popularProducts[1]))
                        <div class="hero-float hero-float-1">
                            <div class="hero-float-thumb">
                                @if($popularProducts[1]->primaryImage)
                                    <img src="{{ asset('storage/' . $popularProducts[1]->primaryImage->image_path) }}" alt="{{ $popularProducts[1]->name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-2xl bg-gradient-to-br from-purple-200 to-pink-200">👕</div>
                                @endif
                            </div>
                            <div>
                                <span class="hero-float-sub">Trending Now</span>
                                <span class="hero-float-title">{{ $popularProducts[1]->name }}</span>
                            </div>
                        </div>
                    @endif

                    <!-- Floating: free shipping pill -->
                    <div class="hero-float hero-float-pill">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/></svg>
                        <div>
                            <span class="hero-float-sub">Free Shipping</span>
                            <span class="hero-float-title">On Orders 1500+</span>
                        </div>
                    </div>

                    <!-- Floating: rating card -->
                    <div class="hero-float hero-float-rate">
                        <div class="stars">★★★★★</div>
                        <div>
                            <span class="hero-float-title">4.9 Rated</span>
                            <span class="hero-float-sub">by 12K+ shoppers</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="fashion-section-padding">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="section-title">Shop by Category</h2>
                <div class="fashion-divider"></div>
                <p class="section-subtitle">Explore our curated fashion collections</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 fashion-category">
                @forelse($categories->take(4) as $category)
                    <a href="{{ route('shop', ['category' => $category->slug]) }}" class="fashion-category-circle group">
                        <div class="fashion-category-circle-media">
                            <span class="text-6xl sm:text-7xl">{{ $category->image }}</span>
                        </div>
                        <div>
                            <h3 class="fashion-category-circle-title">{{ $category->name }}</h3>
                            <p class="fashion-category-circle-subtitle">{{ $category->description ?? 'Explore collection' }}</p>
                        </div>
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Categories coming soon...</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Popular Products -->
    <section class="fashion-section-padding bg-surface">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="section-title">Trending Now</h2>
                    <div class="fashion-divider !mx-0"></div>
                    <p class="section-subtitle">Most loved fashion items by our customers</p>
                </div>
                <a href="{{ route('shop') }}" class="btn-ghost text-secondary hidden sm:inline-flex">
                    View All
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($popularProducts as $product)
                    <div class="product-card">
                        <a href="{{ route('product.detail', $product->slug) }}" class="block fashion-product-image">
                            <div class="w-full h-full bg-gradient-to-br from-secondary/10 to-primary/10 flex items-center justify-center">
                                @if ($product->primaryImage != null)
                                    <img src="{{ asset('storage/'. $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full">
                                @else
                                    <span class="text-4xl">👕</span>
                                @endif
                            </div>
                            @if($product->discount_percent > 0)
                                <span class="fashion-badge-sale">
                                    -{{ $product->discount_percent }}%
                                </span>
                            @endif
                            <div class="fashion-quick-add">
                                @if($product->stock_quantity > 0)
                                    <button onclick="addToCart({{ $product->id }})" class="w-full bg-white text-primary py-2.5 rounded-full font-semibold shadow-lg hover:bg-primary hover:text-white transition-colors">
                                        Add to Cart
                                    </button>
                                @else
                                    <button class="w-full bg-gray-200 text-gray-500 py-2.5 rounded-full font-semibold cursor-not-allowed">
                                        Out of Stock
                                    </button>
                                @endif
                            </div>
                        </a>
                        <div class="p-4">
                            @if($product->category)
                                <span class="text-xs text-secondary font-medium tracking-wider uppercase">{{ $product->category->name }}</span>
                            @endif
                            <a href="{{ route('product.detail', $product->slug) }}">
                                <h3 class="font-semibold text-primary mt-1 mb-2 line-clamp-2 hover:text-secondary transition-colors">{{ $product->name }}</h3>
                            </a>
                            <div class="flex items-center gap-2 mb-3">
                                <span class="price text-xl">₹{{ number_format($product->final_price, 2) }}</span>
                                @if($product->compare_price)
                                    <span class="price-discount">₹{{ number_format($product->compare_price, 2) }}</span>
                                @endif
                            </div>
                            <div class="flex gap-2 mt-2">
                                <button onclick="addToWishlist({{ $product->id }})" class="w-10 h-10 bg-white rounded-full shadow flex items-center justify-center text-gray-600 hover:text-error transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Popular products coming soon...</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center sm:hidden mt-8">
                <a href="{{ route('shop') }}" class="btn-primary">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Special Offers Banner -->
    <section class="fashion-section-padding">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-gradient-to-r from-primary to-primary-light rounded-2xl p-8 md:p-12 text-white relative overflow-hidden">
                <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23fff' fill-opacity='0.4' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E')"></div>
                <div class="relative grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <span class="inline-block bg-secondary/20 text-secondary px-3 py-1 rounded-full text-sm font-medium mb-4 tracking-widest uppercase">Special Offer</span>
                        <h2 class="text-3xl md:text-4xl font-serif font-bold mb-4">Season Sale - <span class="text-secondary">Up to 50% Off</span></h2>
                        <p class="text-white/70 mb-6">Refresh your wardrobe with our exclusive seasonal collection. Limited time offers on premium fashion items.</p>
                        <a href="{{ route('shop') }}" class="inline-flex items-center gap-2 bg-secondary text-primary px-6 py-3 rounded-full font-semibold hover:bg-secondary-light transition-colors">
                            Shop the Sale
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                        </a>
                    </div>
                    <div class="hidden md:block">
                        <div class="grid grid-cols-2 gap-4">
                            <div class="bg-white/10 rounded-xl p-4 text-center backdrop-blur-sm">
                                <div class="text-2xl font-bold text-secondary">₹0</div>
                                <div class="text-sm text-white/60">Free Shipping</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 text-center backdrop-blur-sm">
                                <div class="text-2xl font-bold text-secondary">100%</div>
                                <div class="text-sm text-white/60">Secure Payment</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 text-center backdrop-blur-sm">
                                <div class="text-2xl font-bold text-secondary">24/7</div>
                                <div class="text-sm text-white/60">Customer Support</div>
                            </div>
                            <div class="bg-white/10 rounded-xl p-4 text-center backdrop-blur-sm">
                                <div class="text-2xl font-bold text-secondary">7 Days</div>
                                <div class="text-sm text-white/60">Easy Returns</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust Badges -->
    <section class="py-12 bg-white border-t border-gray-100">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="trust-badge">
                    <div class="badge-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-primary text-sm">Secure Payment</h4>
                        <p class="text-xs text-gray-500">100% secure transactions</p>
                    </div>
                </div>
                <div class="trust-badge">
                    <div class="badge-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-primary text-sm">Free Shipping</h4>
                        <p class="text-xs text-gray-500">On orders above ₹500</p>
                    </div>
                </div>
                <div class="trust-badge">
                    <div class="badge-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-primary text-sm">Easy Returns</h4>
                        <p class="text-xs text-gray-500">7-day return policy</p>
                    </div>
                </div>
                <div class="trust-badge">
                    <div class="badge-icon">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="font-semibold text-primary text-sm">24/7 Support</h4>
                        <p class="text-xs text-gray-500">Dedicated customer service</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials -->
    <section class="fashion-section-padding bg-surface">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="section-title">What Our Customers Say</h2>
                <div class="fashion-divider"></div>
                <p class="section-subtitle">Loved by fashion enthusiasts across India</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="fashion-testimonial-card">
                    <div class="flex items-center gap-1 mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm mb-4">"Amazing quality clothing! The fabric is premium and the fit is perfect. Fast delivery and great customer service. Highly recommend for fashion lovers."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                            <span class="text-sm font-bold text-primary">PS</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm text-primary">Priya Sharma</h4>
                            <p class="text-xs text-gray-500">Fashion Blogger</p>
                        </div>
                    </div>
                </div>
                <div class="fashion-testimonial-card">
                    <div class="flex items-center gap-1 mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm mb-4">"Best online fashion store! The collection is trendy and prices are very competitive. Their size guide is accurate and returns are hassle-free."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                            <span class="text-sm font-bold text-primary">AK</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm text-primary">Arjun Kapoor</h4>
                            <p class="text-xs text-gray-500">Style Enthusiast</p>
                        </div>
                    </div>
                </div>
                <div class="fashion-testimonial-card">
                    <div class="flex items-center gap-1 mb-3">
                        @for($i = 1; $i <= 4; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">"Great variety of fashion items for the whole family. The quality is consistent and the new arrivals are always exciting. Highly recommended!"</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-primary/10 flex items-center justify-center">
                            <span class="text-sm font-bold text-primary">NM</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm text-primary">Neha Mehta</h4>
                            <p class="text-xs text-gray-500">Fashion Shopper</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
