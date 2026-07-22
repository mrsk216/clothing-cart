@extends('layouts.guest')

@section('title', 'My Profile')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="separator">/</span>
        <span class="current">Profile</span>
    </div>

    <h1 class="text-2xl font-bold text-primary mb-6">My Profile</h1>

    <div class="card p-6">
        <form method="POST" action="{{ route('profile') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name *</label>
                    <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                    <input type="email" value="{{ auth()->user()->email }}" disabled class="input-field bg-gray-100">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="input-field">
                </div>
            </div>
            <button type="submit" class="btn-primary">Update Profile</button>
        </form>
    </div>

    <div class="card p-6 mt-6">
        <h3 class="font-semibold text-primary mb-4">Change Password</h3>
        <form method="POST" action="{{ route('profile') }}" class="space-y-4">
            @csrf
            @method('PUT')
            <input type="hidden" name="action" value="password">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" name="current_password" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" required class="input-field">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Confirm New Password</label>
                <input type="password" name="password_confirmation" required class="input-field">
            </div>
            <button type="submit" class="btn-primary">Change Password</button>
        </form>
    </div>
</div>
@endsection
