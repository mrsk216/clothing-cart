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
            <div>
                <label class="text-sm font-medium text-gray-700"><input type="checkbox" name="default" value="1" class="mr-2"> Deafult Address</label>
            </div>
            <button type="submit" class="btn-primary">Add Address</button>
        </form>
    </div>

    <div class="space-y-4">
        @forelse($addresses as $address)
            <div class="card p-4 flex items-start justify-between">
                <div>
                    <p class="font-medium text-primary">{{ $address->full_name }}</p>
                    <p class="text-sm text-gray-600">{{ $address->address_line1 }}, {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}</p>
                    <p class="text-sm text-gray-500">Phone: {{ $address->phone }}</p>
                    <div class="flex gap-3">
                        @if ($address->is_default)
                            <p class="border rounded-xl text-sm text-blue-700 px-3">Default</p>
                        @else
                            <a href="{{ route('addresses.update', $address->id) }}" class="text-sm text-blue-700 underline mt-1">Make Default</a>
                        @endif
                    </div>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('addresses.destroy', $address->id) }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M3 7h18"/>
                        </svg>
                    </a>
                </div>
            </div>
        @empty
            <p class="text-gray-500 text-center py-8">No addresses saved yet.</p>
        @endforelse
    </div>
</div>
@endsection
