@extends('admin.layout')

@section('title', 'Products')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Products</h1>
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
                                    @if ($product->primaryImage != null)
                                        <img src="{{ asset('storage/'. $product->primaryImage->image_path) }}" alt="{{ $product->name }}" class="h-full">
                                    @else
                                        <span class="text-2xl">📦</span>
                                    @endif
                                </div>
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category?->name ?? 'N/A' }}</td>
                            <td>₹{{ number_format($product->final_price, 2) }}</td>
                            <td>{{ $product->stock_quantity }}</td>
                            <td>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $product->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center gap-1.5">
                                    <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-xs font-medium shadow-sm" title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.toggle-status', $product->id) }}" class="inline" onsubmit="return confirm('{{ $product->is_active ? "Deactivate" : "Activate" }} this product?')">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 {{ $product->is_active ? 'bg-yellow-50 text-yellow-600 hover:bg-yellow-100' : 'bg-green-50 text-green-600 hover:bg-green-100' }} rounded-lg transition-colors text-xs font-medium shadow-sm" title="{{ $product->is_active ? 'Deactivate' : 'Activate' }}">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/></svg>
                                            {{ $product->is_active ? 'Deactivate' : 'Activate' }}
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" class="inline" onsubmit="return confirm('Delete {{ $product->name }}? This cannot be undone.')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-xs font-medium shadow-sm" title="Delete">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
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
        @if ($products->hasPages())
            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
