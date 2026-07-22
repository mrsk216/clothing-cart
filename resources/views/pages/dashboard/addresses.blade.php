@extends('layouts.guest')

@section('title', 'My Addresses')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="separator">/</span>
        <span class="current">Addresses</span>
    </div>

    <h1 class="text-2xl font-bold text-primary mb-6">My Addresses</h1>

    <div class="card p-6 mb-6">
        <h3 class="font-semibold text-primary mb-4">Add New Address</h3>
        <form method="POST" action="{{ route('addresses.store') }}" class="space-y-4">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                    <input type="text" name="name" required class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                    <input type="text" name="phone" required class="input-field">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address *</label>
                    <textarea name="address" rows="2" required class="input-field"></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">City *</label>
                    <input type="text" name="city" required class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">State *</label>
                    <input type="text" name="state" required class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Pincode *</label>
                    <input type="text" name="pincode" required class="input-field">
                </div>
            </div>
            <button type="submit" class="btn-primary">Add Address</button>
        </form>
    </div>

    <div class="space-y-4">
        @forelse(auth()->user()->addresses ?? [] as $address)
            <div class="card p-4 flex items-start justify-between">
                <div>
                    <p class="font-medium text-primary">{{ $address->name }}</p>
                    <p class="text-sm text-gray-600">{{ $address->address }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}</p>
                    <p class="text-sm text-gray-500">Phone: {{ $address->phone }}</p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-8">No addresses saved yet.</p>
        @endforelse
    </div>
</div>
@endsection
