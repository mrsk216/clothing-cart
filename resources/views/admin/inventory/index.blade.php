@extends('admin.layout')

@section('title', 'Inventory')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-primary mb-6">Inventory Management</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-lg text-sm">{{ session('error') }}</div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 card p-6">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Stock</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->sku }}</td>
                                <td>{{ $product->stock_quantity }}</td>
                                <td>
                                    @if($product->stock_quantity <= 0)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Out of Stock</span>
                                    @elseif($product->stock_quantity <= ($product->low_stock_threshold ?? 10))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Low Stock</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">In Stock</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-gray-400 py-8">No products found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($products->hasPages())
                <div class="mt-4">{{ $products->links() }}</div>
            @endif
        </div>

        <div class="card p-6">
            <h3 class="font-semibold text-primary mb-4">Adjust Stock</h3>
            <form method="POST" action="{{ route('admin.inventory.adjust') }}" class="space-y-3">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product</label>
                    <select name="product_id" class="input-field" required>
                        <option value="">Select product</option>
                        @foreach($allProducts as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->stock_quantity }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <select name="type" class="input-field" required>
                        <option value="add">Add stock</option>
                        <option value="remove">Remove stock</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                    <input type="number" name="quantity" min="1" class="input-field" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <textarea name="notes" rows="2" class="input-field" placeholder="Optional note"></textarea>
                </div>
                <button type="submit" class="btn-primary w-full">Update Stock</button>
            </form>
        </div>
    </div>

    <div class="card p-6">
        <h3 class="font-semibold text-primary mb-4">Recent Inventory Logs</h3>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Product</th>
                        <th>Type</th>
                        <th>Qty</th>
                        <th>Notes</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentLogs as $log)
                        <tr>
                            <td class="text-sm">{{ $log->created_at->format('d M Y, h:i A') }}</td>
                            <td>{{ $log->product?->name ?? 'N/A' }}</td>
                            <td class="capitalize">{{ $log->type }}</td>
                            <td>{{ $log->quantity }}</td>
                            <td class="text-sm text-gray-600">{{ $log->notes ?? '—' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center text-gray-400 py-6">No inventory adjustments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
