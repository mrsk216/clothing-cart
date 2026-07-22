@extends('layouts.guest')

@section('title', 'Contact Us - SPM Enterprise')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <span class="current">Contact Us</span>
    </div>

    <h1 class="text-2xl font-bold text-primary mb-6">Contact Us</h1>

    <div class="grid md:grid-cols-3 gap-8 mb-12">
        <div class="card p-6 text-center">
            <div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
            </div>
            <h3 class="font-semibold text-primary mb-2">Phone</h3>
            <a href="tel:+919876543210" class="text-secondary hover:underline">+91-9876543210</a>
        </div>
        <div class="card p-6 text-center">
            <div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
            </div>
            <h3 class="font-semibold text-primary mb-2">Email</h3>
            <a href="mailto:info@spmapp.com" class="text-secondary hover:underline">info@spmapp.com</a>
        </div>
        <div class="card p-6 text-center">
            <div class="w-12 h-12 bg-secondary/10 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-6 h-6 text-secondary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h3 class="font-semibold text-primary mb-2">Business Hours</h3>
            <p class="text-gray-600 text-sm">Mon-Sat: 9:00 AM - 7:00 PM</p>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-8">
        <div class="card p-6">
            <h3 class="font-semibold text-primary mb-4">Send us a Message</h3>
            <form method="POST" action="{{ route('contact') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" required class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="email" required class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Message *</label>
                    <textarea name="message" rows="4" required class="input-field"></textarea>
                </div>
                <button type="submit" class="btn-primary">Send Message</button>
            </form>
        </div>
        <div>
            <div class="card p-6 mb-6">
                <h3 class="font-semibold text-primary mb-4">Our Address</h3>
                <p class="text-gray-600">123, Business Street,<br>Mumbai - 400001, India</p>
            </div>
            <div class="bg-gray-100 rounded-xl h-64 flex items-center justify-center">
                <p class="text-gray-500">Google Maps Integration</p>
            </div>
        </div>
    </div>
</div>
@endsection
