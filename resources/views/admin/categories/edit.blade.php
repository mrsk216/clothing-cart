@extends('admin.layout')

@section('title', 'Edit Category')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Edit Category</h1>
        <a href="{{ route('admin.categories') }}" class="btn-outline">Back to Categories</a>
    </div>

    <div class="card p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" class="space-y-6" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Name *</label>
                    <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="input-field" placeholder="Enter category name">
                    @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="input-field" placeholder="category-url-slug">
                    @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Parent Category</label>
                    <select name="parent_id" class="input-field">
                        <option value="">None (Parent Category)</option>
                        @foreach($categories as $cat)
                            @if($cat->id !== $category->id)
                                <option value="{{ $cat->id }}" {{ old('parent_id', $category->parent_id) == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endif
                        @endforeach
                    </select>
                    @error('parent_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Icon (Emoji)</label>
                    <input type="text" name="image" value="{{ old('image', $category->image) }}" class="input-field" placeholder="📦" maxlength="2">
                    @error('image')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category Image</label>
                    <input type="file" name="image" accept="image/*" class="input-field" id="categoryImage">
                    <p class="text-xs text-gray-500 mt-1">Upload a category image (max 2MB)</p>
                    @if($category->image)
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-700 mb-2">Current Image:</p>
                            <img src="{{ asset('storage/' . $category->image) }}" alt="{{ $category->name }}" class="w-24 h-24 object-cover rounded-lg border-2 border-gray-200">
                        </div>
                    @endif
                    <div id="categoryImagePreview" class="mt-3"></div>
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="3" class="input-field" placeholder="Category description...">{{ old('description', $category->description) }}</textarea>
                    @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="btn-primary">Update Category</button>
                <a href="{{ route('admin.categories') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
