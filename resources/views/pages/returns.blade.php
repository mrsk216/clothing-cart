@extends('layouts.guest')

@section('title', 'Return Policy')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <span class="current">Return Policy</span>
    </div>

    <h1 class="text-3xl font-bold text-primary mb-6">Return & Refund Policy</h1>
    <div class="card p-6 prose max-w-none text-gray-700">
        <h2 class="text-xl font-bold text-primary mt-6 mb-3">Return Period</h2>
        <p>We accept returns within 7 days of delivery. Products must be unused and in original packaging.</p>
        <h2 class="text-xl font-bold text-primary mt-6 mb-3">Refund Process</h2>
        <p>Once we receive and inspect the returned product, we will process your refund within 5-7 business days.</p>
        <h2 class="text-xl font-bold text-primary mt-6 mb-3">Non-Returnable Items</h2>
        <p>Customized products, perishable items, and products damaged due to misuse cannot be returned.</p>
    </div>
</div>
@endsection
