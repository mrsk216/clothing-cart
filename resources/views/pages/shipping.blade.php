@extends('layouts.guest')

@section('title', 'Shipping Policy')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <span class="current">Shipping Policy</span>
    </div>

    <h1 class="text-3xl font-bold text-primary mb-6">Shipping Policy</h1>
    <div class="card p-6 prose max-w-none text-gray-700">
        <h2 class="text-xl font-bold text-primary mt-6 mb-3">Delivery Time</h2>
        <p>Orders are typically delivered within 3-7 business days across India. Metro cities may receive deliveries in 2-3 business days.</p>
        <h2 class="text-xl font-bold text-primary mt-6 mb-3">Shipping Charges</h2>
        <p>Free shipping on orders above ₹500. For orders below ₹500, a nominal shipping charge of ₹50 applies.</p>
        <h2 class="text-xl font-bold text-primary mt-6 mb-3">Order Tracking</h2>
        <p>Once your order is shipped, you will receive a tracking number via email and SMS to track your package.</p>
    </div>
</div>
@endsection
