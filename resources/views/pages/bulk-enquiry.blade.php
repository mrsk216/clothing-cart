@extends('layouts.guest')

@section('title', 'Bulk Order Enquiry - ' . $siteName())
@section('meta_description', 'Request wholesale pricing for paper, stamp pads, rubber seals and screen printing materials. Submit your bulk order enquiry.')
@section('meta_keywords', 'bulk order, wholesale, paper wholesale, stamp pad bulk, screen printing materials')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <span class="current">Bulk Order Enquiry</span>
    </div>

    <h1 class="text-2xl font-bold text-primary mb-2">Bulk Order Enquiry</h1>
    <p class="text-gray-600 mb-6">Need wholesale quantities? Share your requirements and our team will respond with pricing.</p>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="card p-6">
        <form method="POST" action="{{ route('bulk.enquiry.send') }}" class="space-y-4">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="input-field @error('name') border-red-500 @enderror">
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Company</label>
                    <input type="text" name="company" value="{{ old('company') }}" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="input-field @error('email') border-red-500 @enderror">
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone *</label>
                    <input type="text" name="phone" value="{{ old('phone') }}" required class="input-field @error('phone') border-red-500 @enderror">
                    @error('phone') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product Category</label>
                    <select name="category" class="input-field">
                        <option value="">Select category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->name }}" {{ old('category') === $category->name ? 'selected' : '' }}>{{ $category->name }}</option>
                        @endforeach
                        <option value="Mixed / Multiple" {{ old('category') === 'Mixed / Multiple' ? 'selected' : '' }}>Mixed / Multiple</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estimated Quantity</label>
                    <input type="text" name="estimated_quantity" value="{{ old('estimated_quantity') }}" class="input-field" placeholder="e.g. 500 units">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Requirements *</label>
                <textarea name="message" rows="5" required class="input-field @error('message') border-red-500 @enderror" placeholder="Describe products, sizes, delivery location, timeline...">{{ old('message') }}</textarea>
                @error('message') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>
            <button type="submit" class="btn-primary">Submit Enquiry</button>
        </form>
    </div>
</div>
@endsection
