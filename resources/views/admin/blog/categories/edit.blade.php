@extends('admin.layout')

@section('title', 'Edit Blog Category')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Edit Blog Category</h1>
        <a href="{{ route('admin.blog.categories') }}" class="btn-outline">Back to Categories</a>
    </div>

    <div class="card p-6 max-w-2xl">
        <form method="POST" action="{{ route('admin.blog.categories.update', $category->id) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                <input type="text" name="name" value="{{ old('name', $category->name) }}" required class="input-field" placeholder="Category name">
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Slug *</label>
                <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" required class="input-field" placeholder="category-slug">
                @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                <textarea name="description" rows="3" class="input-field" placeholder="Category description...">{{ old('description', $category->description) }}</textarea>
                @error('description')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="btn-primary">Update Category</button>
                <a href="{{ route('admin.blog.categories') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
