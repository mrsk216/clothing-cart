@extends('layouts.guest')

@section('title', $siteName() . ' - Paper, Stamp Pad, Rubber Seal & Screen Printing Materials')

@section('meta_description', 'Your trusted source for premium paper products, stamp pads, rubber seals, and screen printing materials. Quality products with fast delivery across India.')

@section('meta_keywords', 'paper products, stamp pads, rubber seals, screen printing materials, A4 paper, custom stamps')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section">
        <div class="relative min-h-[500px] md:min-h-[600px] flex items-center">
            <div class="absolute inset-0 bg-gradient-to-r from-primary via-primary/95 to-primary/80"></div>
            <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E')"></div>
            <div class="relative max-w-7xl mx-auto px-4 py-20">
                <div class="grid md:grid-cols-2 gap-12 items-center">
                    <div class="animate-fade-in">
                        <span class="inline-block bg-secondary/20 text-secondary px-4 py-1 rounded-full text-sm font-medium mb-4">Welcome to {{ $siteName() }}</span>
                        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                            Your Trusted Partner for
                            <span class="text-secondary">Premium Printing</span> & Stationery Products
                        </h1>
                        <p class="text-lg text-white/80 mb-8 max-w-xl">
                            Discover our extensive range of high-quality paper products, stamp pads, rubber seals, and screen printing materials. We deliver excellence across India.
                        </p>
                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('shop') }}" class="bg-secondary text-white px-8 py-3.5 rounded-lg font-semibold text-lg hover:bg-secondary-dark transition-all duration-300 inline-flex items-center gap-2">
                                Shop Now
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                            <a href="{{ route('contact') }}" class="border-2 border-white/30 text-white px-8 py-3.5 rounded-lg font-semibold hover:bg-white/10 transition-all duration-300 inline-flex items-center gap-2">
                                Contact Us
                            </a>
                        </div>
                        <!-- Trust Stats -->
                        <div class="flex gap-8 mt-10 pt-8 border-t border-white/20">
                            <div>
                                <div class="text-2xl font-bold text-secondary">15+</div>
                                <div class="text-sm text-white/60">Years Experience</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-secondary">10K+</div>
                                <div class="text-sm text-white/60">Happy Customers</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-secondary">500+</div>
                                <div class="text-sm text-white/60">Products</div>
                            </div>
                        </div>
                    </div>
                    <div class="hidden md:block animate-slide-up">
                        <div class="relative">
                            <div class="w-full aspect-square max-w-md mx-auto bg-white/5 rounded-2xl border border-white/10 p-8 backdrop-blur-sm">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="bg-secondary/10 rounded-xl p-4 text-center">
                                        <div class="text-3xl mb-2">📄</div>
                                        <div class="text-sm text-white/80">Paper Products</div>
                                    </div>
                                    <div class="bg-secondary/10 rounded-xl p-4 text-center">
                                        <div class="text-3xl mb-2">🔏</div>
                                        <div class="text-sm text-white/80">Stamp Pads</div>
                                    </div>
                                    <div class="bg-secondary/10 rounded-xl p-4 text-center">
                                        <div class="text-3xl mb-2">🖨️</div>
                                        <div class="text-sm text-white/80">Rubber Seals</div>
                                    </div>
                                    <div class="bg-secondary/10 rounded-xl p-4 text-center">
                                        <div class="text-3xl mb-2">🎨</div>
                                        <div class="text-sm text-white/80">Screen Printing</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="section-title">Shop by Category</h2>
                <p class="section-subtitle">Browse our extensive collection of products</p>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($categories as $category)
                    <a href="{{ route('shop', ['category' => $category->slug]) }}" class="card p-6 text-center group hover:border-secondary/50 transition-all duration-300">
                        <div class="w-20 h-20 bg-secondary/10 rounded-2xl flex items-center justify-center mx-auto mb-4 group-hover:bg-secondary/20 transition-colors">
                            <span class="text-3xl">{{ $category->image }}</span>
                        </div>
                        <h3 class="font-semibold text-primary text-lg mb-2">{{ $category->name }}</h3>
                        <p class="text-sm text-gray-500">{{ $category->description ?? Str::limit($category->name . ' - High quality products', 60) }}</p>
                        @if($category->children->count() > 0)
                            <div class="mt-3 flex flex-wrap justify-center gap-1">
                                @foreach($category->children->take(3) as $child)
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $child->name }}</span>
                                @endforeach
                                @if($category->children->count() > 3)
                                    <span class="text-xs text-secondary">+{{ $category->children->count() - 3 }} more</span>
                                @endif
                            </div>
                        @endif
                    </a>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Categories coming soon...</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Featured Products -->
    <section class="py-16 md:py-20 bg-surface">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="section-title">Featured Products</h2>
                    <p class="section-subtitle">Hand-picked products just for you</p>
                </div>
                <a href="{{ route('shop') }}" class="btn-ghost text-secondary hidden sm:inline-flex">
                    View All
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($featuredProducts as $product)
                    <div class="product-card">
                        <a href="{{ route('product.detail', $product->slug) }}" class="block aspect-square bg-gray-50 overflow-hidden">
                            <div class="w-full h-full bg-gradient-to-br from-secondary/10 to-primary/10 flex items-center justify-center">
                                @if ($product->primaryImage != null)
                                    <img src="{{ asset('storage/'. $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="w-full h-full">
                                @else
                                    <span class="text-4xl">📦</span>
                                @endif
                            </div>
                            @if($product->discount_percent > 0)
                                <span class="absolute top-2 left-2 bg-error text-white text-xs px-2 py-1 rounded-full font-semibold">
                                    -{{ $product->discount_percent }}%
                                </span>
                            @endif
                        </a>
                        <div class="p-4">
                            @if($product->category)
                                <span class="text-xs text-secondary font-medium">{{ $product->category->name }}</span>
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
                            <div class="product-actions">
                                <button onclick="addToCart({{ $product->id }})" class="flex-1 btn-primary text-sm py-2">
                                    Add to Cart
                                </button>
                                <button onclick="addToWishlist({{ $product->id }})" class="w-10 h-10 bg-white rounded-lg shadow flex items-center justify-center text-gray-600 hover:text-error transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-12">
                        <p class="text-gray-500">Featured products coming soon...</p>
                    </div>
                @endforelse
            </div>
            <div class="text-center sm:hidden mt-8">
                <a href="{{ route('shop') }}" class="btn-primary">View All Products</a>
            </div>
        </div>
    </section>

    <!-- Special Offers Banner -->
    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4">
            <div class="bg-gradient-to-r from-primary to-primary-light rounded-2xl p-8 md:p-12 text-white relative overflow-hidden">
                <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width='40' height='40' viewBox='0 0 40 40' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%23fff' fill-opacity='0.4' fill-rule='evenodd'%3E%3Cpath d='M0 40L40 0H20L0 20M40 40V20L20 40'/%3E%3C/g%3E%3C/svg%3E')"></div>
                <div class="relative grid md:grid-cols-2 gap-8 items-center">
                    <div>
                        <span class="inline-block bg-secondary/20 text-secondary px-3 py-1 rounded-full text-sm font-medium mb-4">Special Offer</span>
                        <h2 class="text-3xl md:text-4xl font-bold mb-4">Bulk Orders Get <span class="text-secondary">Special Discounts</span></h2>
                        <p class="text-white/70 mb-6">Order in bulk and save big! Perfect for businesses, offices, and printing shops. Get in touch for customized quotes.</p>
                        <a href="{{ route('contact') }}" class="inline-flex items-center gap-2 bg-secondary text-primary px-6 py-3 rounded-lg font-semibold hover:bg-secondary-light transition-colors">
                            Get Quote
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
    <section class="py-16 md:py-20 bg-surface">
        <div class="max-w-7xl mx-auto px-4">
            <div class="text-center mb-12">
                <h2 class="section-title">What Our Customers Say</h2>
                <p class="section-subtitle">Trusted by businesses across India</p>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="card p-6">
                    <div class="flex items-center gap-1 mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm mb-4">"Excellent quality stamp pads and rubber seals. Fast delivery and great customer service. Highly recommend for business supplies."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-secondary/20 flex items-center justify-center">
                            <span class="text-sm font-bold text-secondary">RK</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm text-primary">Rajesh Kumar</h4>
                            <p class="text-xs text-gray-500">Printing Shop Owner</p>
                        </div>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center gap-1 mb-3">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>
                    <p class="text-gray-600 text-sm mb-4">"Best place for screen printing materials. The emulsions and inks are top-notch. Their bulk pricing is unbeatable."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-secondary/20 flex items-center justify-center">
                            <span class="text-sm font-bold text-secondary">SP</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm text-primary">Sunil Patel</h4>
                            <p class="text-xs text-gray-500">Textile Printer</p>
                        </div>
                    </div>
                </div>
                <div class="card p-6">
                    <div class="flex items-center gap-1 mb-3">
                        @for($i = 1; $i <= 4; $i++)
                            <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                        <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    </div>
                    <p class="text-gray-600 text-sm mb-4">"Great variety of A4 and specialty papers. Regular supply for our office needs. The pricing is very competitive."</p>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-secondary/20 flex items-center justify-center">
                            <span class="text-sm font-bold text-secondary">AM</span>
                        </div>
                        <div>
                            <h4 class="font-semibold text-sm text-primary">Anita Mehta</h4>
                            <p class="text-xs text-gray-500">Office Manager</p>
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
