@extends('admin.layout')

@section('title', 'Products')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-white">Products</h1>
        <a href="{{ route('admin.products.create') }}" class="btn-primary">Add Product</a>
    </div>

    <div class="card p-6">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                                    <span class="text-2xl">📦</span>
                                </div>
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name ?? 'N/A' }}</td>
                            <td>₹{{ number_format($product->final_price, 2) }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $product->is_active ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product->id) }}" class="text-secondary hover:underline text-sm">Edit</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-gray-400 py-8">No products found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection
