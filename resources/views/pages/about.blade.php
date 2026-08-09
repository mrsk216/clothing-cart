@extends('layouts.guest')

@section('title', 'About Us - ' . $siteName())

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <span class="current">About Us</span>
    </div>

    <div class="bg-gradient-to-r from-primary to-primary-light text-white rounded-2xl p-8 md:p-12 mb-12">
        <h1 class="text-3xl md:text-4xl font-serif font-bold mb-4">About {{ $siteName() }}</h1>
        <p class="text-white/80 text-lg max-w-3xl">Your premier destination for premium fashion and clothing. Discover curated collections that define your unique style.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-12 mb-12">
        <div>
            <h2 class="text-2xl font-serif font-bold text-primary mb-4">Our Story</h2>
            <p class="text-gray-600 mb-4">{{ $siteName() }} was founded with a vision to bring the latest fashion trends to fashion enthusiasts across India. Over the past 10+ years, we have grown from a small boutique to a trusted name in the fashion industry.</p>
            <p class="text-gray-600">We specialize in premium clothing, accessories, and footwear for men, women, and kids, serving thousands of satisfied customers who value quality, style, and affordability.</p>
        </div>
        <div>
            <h2 class="text-2xl font-serif font-bold text-primary mb-4">Our Mission</h2>
            <p class="text-gray-600 mb-4">To provide premium quality fashion at competitive prices with exceptional customer service. We aim to be the one-stop destination for all your fashion needs.</p>
            <h2 class="text-2xl font-serif font-bold text-primary mb-4 mt-6">Our Vision</h2>
            <p class="text-gray-600">To become India's most trusted fashion destination, known for quality, style, and customer satisfaction.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
        <div class="stat-card text-center">
            <div class="stat-value text-secondary">10+</div>
            <div class="stat-label">Years of Style</div>
        </div>
        <div class="stat-card text-center">
            <div class="stat-value text-secondary">50K+</div>
            <div class="stat-label">Happy Customers</div>
        </div>
        <div class="stat-card text-center">
            <div class="stat-value text-secondary">1000+</div>
            <div class="stat-label">Fashion Items</div>
        </div>
        <div class="stat-card text-center">
            <div class="stat-value text-secondary">100+</div>
            <div class="stat-label">Cities Served</div>
        </div>
    </div>

    <div class="bg-surface rounded-2xl p-8 md:p-12">
        <h2 class="text-2xl font-serif font-bold text-primary mb-6 text-center">Why Choose Us</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="font-semibold text-primary mb-2">Premium Quality</h3>
                <p class="text-sm text-gray-600">We source only the finest fabrics and materials from trusted manufacturers</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-semibold text-primary mb-2">Best Prices</h3>
                <p class="text-sm text-gray-600">Competitive pricing with seasonal discounts and offers</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h3 class="font-semibold text-primary mb-2">24/7 Support</h3>
                <p class="text-sm text-gray-600">Dedicated customer support via phone, email, and WhatsApp</p>
            </div>
        </div>
    </div>
</div>
@endsection
