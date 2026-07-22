@extends('layouts.guest')

@section('title', 'Privacy Policy')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <span class="current">Privacy Policy</span>
    </div>

    <h1 class="text-3xl font-bold text-primary mb-6">Privacy Policy</h1>
    <div class="card p-6 prose max-w-none text-gray-700">
        <p>Last updated: {{ date('d M Y') }}</p>
        <h2 class="text-xl font-bold text-primary mt-6 mb-3">Information We Collect</h2>
        <p>We collect information you provide directly to us, such as your name, email address, phone number, and shipping address when you place an order or create an account.</p>
        <h2 class="text-xl font-bold text-primary mt-6 mb-3">How We Use Your Information</h2>
        <p>We use the information we collect to process orders, communicate with you about your orders, and improve our services.</p>
        <h2 class="text-xl font-bold text-primary mt-6 mb-3">Data Security</h2>
        <p>We implement appropriate security measures to protect your personal information from unauthorized access, alteration, or disclosure.</p>
    </div>
</div>
@endsection
