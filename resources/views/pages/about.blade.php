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
        <h1 class="text-3xl md:text-4xl font-bold mb-4">About {{ $siteName() }}</h1>
        <p class="text-white/80 text-lg max-w-3xl">Your trusted partner for premium paper products, stamp pads, rubber seals, and screen printing materials since 2010.</p>
    </div>

    <div class="grid md:grid-cols-2 gap-12 mb-12">
        <div>
            <h2 class="text-2xl font-bold text-primary mb-4">Our Story</h2>
            <p class="text-gray-600 mb-4">{{ $siteName() }} was founded with a vision to provide high-quality printing and stationery products to businesses across India. Over the past 15+ years, we have grown from a small local supplier to a trusted name in the industry.</p>
            <p class="text-gray-600">We specialize in paper products, stamp pads, rubber seals, and screen printing materials, serving thousands of satisfied customers including printing shops, offices, and businesses.</p>
        </div>
        <div>
            <h2 class="text-2xl font-bold text-primary mb-4">Our Mission</h2>
            <p class="text-gray-600 mb-4">To provide premium quality products at competitive prices with exceptional customer service. We aim to be the one-stop solution for all your printing and stationery needs.</p>
            <h2 class="text-2xl font-bold text-primary mb-4 mt-6">Our Vision</h2>
            <p class="text-gray-600">To become India's most trusted supplier of printing materials, known for quality, reliability, and customer satisfaction.</p>
        </div>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12">
        <div class="stat-card text-center">
            <div class="stat-value text-secondary">15+</div>
            <div class="stat-label">Years Experience</div>
        </div>
        <div class="stat-card text-center">
            <div class="stat-value text-secondary">10K+</div>
            <div class="stat-label">Happy Customers</div>
        </div>
        <div class="stat-card text-center">
            <div class="stat-value text-secondary">500+</div>
            <div class="stat-label">Products</div>
        </div>
        <div class="stat-card text-center">
            <div class="stat-value text-secondary">50+</div>
            <div class="stat-label">Cities Served</div>
        </div>
    </div>

    <div class="bg-surface rounded-2xl p-8 md:p-12">
        <h2 class="text-2xl font-bold text-primary mb-6 text-center">Why Choose Us</h2>
        <div class="grid md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <h3 class="font-semibold text-primary mb-2">Quality Products</h3>
                <p class="text-sm text-gray-600">We source only the best quality products from trusted manufacturers</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h3 class="font-semibold text-primary mb-2">Best Prices</h3>
                <p class="text-sm text-gray-600">Competitive pricing with bulk order discounts available</p>
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
