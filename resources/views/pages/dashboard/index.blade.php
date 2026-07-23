@extends('layouts.guest')

@section('title', 'My Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-primary mb-6">My Dashboard</h1>

    @auth
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="stat-card">
            <div class="stat-icon bg-primary/10 text-primary">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <div class="stat-value">{{ $totalOrders }}</div>
            <div class="stat-label">Total Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-success/10 text-success">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="stat-value">{{ $completedOrders }}</div>
            <div class="stat-label">Completed Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-secondary/10 text-secondary">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
            </div>
            <div class="stat-value">{{ $wishlistCount }}</div>
            <div class="stat-label">Wishlist Items</div>
        </div>
    </div>

    <div class="grid md:grid-cols-2 gap-6">
        <div class="card p-6">
            <h2 class="font-semibold text-primary mb-4">Recent Orders</h2>
            @if($recentOrders->count() > 0)
                <div class="space-y-3">
                    @foreach($recentOrders as $order)
                        <a href="{{ route('order.detail', $order->id) }}" class="flex items-center justify-between p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors">
                            <div>
                                <p class="text-sm font-medium text-primary">#{{ $order->order_number }}</p>
                                <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                                {{ !in_array($order->status, ['delivered','cancelled']) ? 'bg-yellow-100 text-yellow-800' : '' }}">
                                {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                            </span>
                        </a>
                    @endforeach
                </div>
                <a href="{{ route('orders') }}" class="block text-center text-sm text-secondary mt-4 hover:underline">View All Orders</a>
            @else
                <p class="text-gray-500 text-sm">No orders yet.</p>
                <a href="{{ route('shop') }}" class="btn-primary text-sm mt-3 inline-block">Start Shopping</a>
            @endif
        </div>
        <div class="card p-6">
            <h2 class="font-semibold text-primary mb-4">Quick Links</h2>
            <div class="space-y-2">
                <a href="{{ route('profile') }}" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-sm">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Edit Profile
                </a>
                <a href="{{ route('addresses') }}" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-sm">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                    Manage Addresses
                </a>
                <a href="{{ route('wishlist') }}" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-sm">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    My Wishlist
                </a>
                <a href="{{ route('track.order') }}" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors text-sm">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Track Order
                </a>
            </div>
        </div>
    </div>
    @endauth
</div>
@endsection
