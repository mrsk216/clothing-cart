@extends('admin.layout')

@section('title', 'Add Product')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Add New Product</h1>
        <a href="{{ route('admin.products') }}" class="btn-outline">Back to Products</a>
    </div>

    <div class="card p-6">
        <form method="POST" action="{{ route('admin.products.store') }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                    <input type="text" name="name" value="{{ old('name') }}" required class="input-field" placeholder="Enter product name">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug *</label>
                    <input type="text" name="slug" value="{{ old('slug') }}" required class="input-field" placeholder="product-url-slug">
                    @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4" class="input-field" placeholder="Product description...">{{ old('description') }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Price (₹) *</label>
                    <input type="number" name="price" step="0.01" value="{{ old('price') }}" required class="input-field" placeholder="0.00">
                    @error('price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Compare Price (₹)</label>
                    <input type="number" name="compare_price" step="0.01" value="{{ old('compare_price') }}" class="input-field" placeholder="0.00">
                    @error('compare_price')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Stock Quantity *</label>
                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity') }}" required class="input-field" placeholder="0">
                    @error('stock_quantity')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">SKU</label>
                    <input type="text" name="sku" value="{{ old('sku') }}" class="input-field" placeholder="SKU-001">
                    @error('sku')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                    <select name="category_id" required class="input-field">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                    <select name="is_active" class="input-field">
                        <option value="1" {{ old('is_active', 1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('is_active', 1) == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Images</label>
                    <input type="file" name="images[]" multiple accept="image/*" class="input-field" id="productImages">
                    <p class="text-xs text-gray-500 mt-1">You can upload multiple images. First image will be set as primary.</p>
                <div id="imagePreview" class="flex gap-2 mt-3 flex-wrap"></div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="btn-primary">Create Product</button>
                <a href="{{ route('admin.products') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('productImages').addEventListener('change', function(e) {
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';

    if (this.files && this.files.length > 0) {
        Array.from(this.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative';
                div.innerHTML = '<img src="' + e.target.result + '" class="w-20 h-20 object-cover rounded-lg border-2 ' + (index === 0 ? 'border-secondary' : 'border-gray-200') + '">' + (index === 0 ? '<span class="absolute -top-1 -right-1 bg-secondary text-white text-xs px-1.5 py-0.5 rounded-full">Primary</span>' : '');
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
});
</script>
@endpush
