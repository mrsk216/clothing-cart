@extends('admin.layout')

@section('title', 'Edit Blog Post')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Edit Blog Post</h1>
        <a href="{{ route('admin.blog') }}" class="btn-outline">Back to Blog</a>
    </div>

    <div class="card p-6">
        <form method="POST" action="{{ route('admin.blog.update', $post->id) }}" class="space-y-6">
            @csrf
            @method('PUT')
            <div class="grid md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title *</label>
                    <input type="text" name="title" value="{{ old('title', $post->title) }}" required class="input-field" placeholder="Enter blog post title">
                    @error('title')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Slug *</label>
                    <input type="text" name="slug" value="{{ old('slug', $post->slug) }}" required class="input-field" placeholder="blog-post-url-slug">
                    @error('slug')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                    <select name="category_id" class="input-field">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id', $post->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select name="status" class="input-field">
                        <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>Published</option>
                    </select>
                    @error('status')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content *</label>
                    <textarea name="content" rows="10" class="input-field" placeholder="Write your blog post content here...">{{ old('content', $post->content) }}</textarea>
                    @error('content')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex gap-3 pt-4">
                <button type="submit" class="btn-primary">Update Post</button>
                <a href="{{ route('admin.blog') }}" class="btn-outline">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
