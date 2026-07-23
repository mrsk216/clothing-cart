@extends('admin.layout')

@section('title', 'Categories')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Categories</h1>
        <button onclick="document.getElementById('categoryForm').classList.toggle('hidden')" class="btn-primary">Add Category</button>
    </div>

    <div id="categoryForm" class="card p-6 mb-6 hidden">
        <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-4">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" required class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Slug</label>
                    <input type="text" name="slug" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Parent Category</label>
                    <select name="parent_id" class="input-field">
                        <option value="">None (Parent)</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Icon (Emoji)</label>
                    <input type="text" name="image" class="input-field" placeholder="📦">
                </div>
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="2" class="input-field"></textarea>
                </div>
            </div>
            <button type="submit" class="btn-primary">Save Category</button>
        </form>
    </div>

    <div class="card p-6">
        @foreach($categories as $category)
            <div id="editCategory{{ $category->id }}" class="hidden mb-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" class="space-y-3">
                    @csrf @method('PUT')
                    <div class="grid md:grid-cols-2 gap-3">
                        <input type="text" name="name" value="{{ $category->name }}" required class="input-field" placeholder="Category Name">
                        <input type="text" name="slug" value="{{ $category->slug }}" class="input-field" placeholder="Slug">
                        <input type="text" name="image" value="{{ $category->image }}" class="input-field" placeholder="Icon (Emoji)" maxlength="2">
                        <select name="parent_id" class="input-field">
                            <option value="">No Parent</option>
                            @foreach($categories as $cat)
                                @if($cat->id !== $category->id)
                                    <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                                @endif
                            @endforeach
                        </select>
                        <textarea name="description" rows="2" class="input-field md:col-span-2" placeholder="Description">{{ $category->description }}</textarea>
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary text-sm py-2">Update</button>
                        <button type="button" onclick="document.getElementById('editCategory{{ $category->id }}').classList.toggle('hidden')" class="btn-outline text-sm py-2">Cancel</button>
                    </div>
                </form>
            </div>
        @endforeach

        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->slug }}</td>
                            <td>{{ $category->parent?->name ?? 'N/A' }}</td>
                            <td>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $category->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center gap-1.5">
                                    <button onclick="document.getElementById('editCategory{{ $category->id }}').classList.toggle('hidden')" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-xs font-medium shadow-sm" title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category->id) }}" class="inline" onsubmit="return confirm('Delete {{ $category->name }}? This cannot be undone.')">
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
                        <tr><td colspan="5" class="text-center text-gray-400 py-8">No categories found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
