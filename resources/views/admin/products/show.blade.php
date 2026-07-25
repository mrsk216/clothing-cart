@extends('admin.layout')

@section('title', 'Product: ' . $product->name)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Product Details</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-primary">Edit Product</a>
            <a href="{{ route('admin.products') }}" class="btn-outline">Back to Products</a>
        </div>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Product Information</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Product Name</p>
                        <p class="font-medium text-primary">{{ $product->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Slug</p>
                        <p class="font-medium text-primary">{{ $product->slug }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Category</p>
                        <p class="font-medium text-primary">{{ $product->category?->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">SKU</p>
                        <p class="font-medium text-primary">{{ $product->sku ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Price</p>
                        <p class="font-medium text-primary text-lg">₹{{ number_format($product->price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Compare Price</p>
                        <p class="font-medium text-primary">₹{{ number_format($product->compare_price, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Stock Quantity</p>
                        <p class="font-medium text-primary">{{ $product->stock_quantity }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $product->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $product->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
                @if($product->short_description)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Short Description</p>
                        <div class="bg-gray-50 rounded-lg p-4 text-gray-700">{{ $product->short_description }}</div>
                    </div>
                @endif
                @if($product->description)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Description</p>
                        <div class="bg-gray-50 rounded-lg p-4 text-gray-700 whitespace-pre-wrap">{{ $product->description }}</div>
                    </div>
                @endif
                @if($product->weight || $product->length || $product->width || $product->height)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Shipping Dimensions</p>
                        <div class="grid grid-cols-4 gap-2">
                            @if($product->weight)<div class="bg-gray-50 rounded-lg p-3 text-center"><p class="text-xs text-gray-500">Weight</p><p class="font-medium text-primary">{{ $product->weight }} kg</p></div>@endif
                            @if($product->length)<div class="bg-gray-50 rounded-lg p-3 text-center"><p class="text-xs text-gray-500">Length</p><p class="font-medium text-primary">{{ $product->length }} cm</p></div>@endif
                            @if($product->width)<div class="bg-gray-50 rounded-lg p-3 text-center"><p class="text-xs text-gray-500">Width</p><p class="font-medium text-primary">{{ $product->width }} cm</p></div>@endif
                            @if($product->height)<div class="bg-gray-50 rounded-lg p-3 text-center"><p class="text-xs text-gray-500">Height</p><p class="font-medium text-primary">{{ $product->height }} cm</p></div>@endif
                        </div>
                    </div>
                @endif
                @if($product->meta_title || $product->meta_description)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">SEO</p>
                        <div class="bg-gray-50 rounded-lg p-4 space-y-2">
                            @if($product->meta_title)<p class="text-sm"><strong>Meta Title:</strong> {{ $product->meta_title }}</p>@endif
                            @if($product->meta_description)<p class="text-sm"><strong>Meta Description:</strong> {{ $product->meta_description }}</p>@endif
                        </div>
                    </div>
                @endif
                @if($product->tags)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Tags</p>
                        <div class="flex flex-wrap gap-1">
                            @foreach((array) $product->tags as $tag)
                                <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded-full">{{ $tag }}</span>
                            @endforeach
                        </div>
                    </div>
                @endif
                @if($product->specifications)
                    <div class="mt-4">
                        <p class="text-sm text-gray-500 mb-2">Specifications</p>
                        <div class="bg-gray-50 rounded-lg p-4">
                            @foreach((array) $product->specifications as $key => $value)
                                <div class="flex justify-between py-1 border-b border-gray-200 last:border-0">
                                    <span class="text-sm text-gray-600">{{ $key }}</span>
                                    <span class="text-sm font-medium text-primary">{{ $value }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div>
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-primary w-full">Edit Product</a>
                    <form method="POST" action="{{ route('admin.products.toggle-status', $product->id) }}" onsubmit="return confirm('{{ $product->is_active ? "Deactivate" : "Activate" }} this product?')">
                        @csrf
                        <button type="submit" class="btn-outline w-full">
                            {{ $product->is_active ? 'Deactivate' : 'Activate' }}
                        </button>
                    </form>
                    <form method="POST" action="{{ route('admin.products.destroy', $product->id) }}" onsubmit="return confirm('Delete {{ $product->name }}? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger w-full">Delete Product</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
