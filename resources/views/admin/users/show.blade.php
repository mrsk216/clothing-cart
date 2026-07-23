@extends('admin.layout')

@section('title', 'User: ' . $user->name)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">User Details</h1>
        <a href="{{ route('admin.users') }}" class="btn-outline">Back to Users</a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">User Information</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-medium text-primary">{{ $user->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-primary">{{ $user->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="font-medium text-primary">{{ $user->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Role</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $user->role === 'admin' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $user->role === 'staff' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $user->role === 'customer' ? 'bg-blue-100 text-blue-800' : '' }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Joined</p>
                        <p class="font-medium text-primary">{{ $user->created_at->format('d M Y') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $user->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <div>
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Update User</h3>
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf @method('PUT')
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Role</label>
                            <select name="role" class="input-field">
                                <option value="customer" {{ $user->role === 'customer' ? 'selected' : '' }}>Customer</option>
                                <option value="staff" {{ $user->role === 'staff' ? 'selected' : '' }}>Staff</option>
                                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select name="is_active" class="input-field">
                                <option value="1" {{ $user->is_active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$user->is_active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <button type="submit" class="btn-primary w-full">Update User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
