@extends('admin.layout')

@section('title', 'Admin Dashboard')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-white mb-6">Dashboard</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="stat-card">
            <div class="stat-icon bg-primary/10 text-primary">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
            </div>
            <div class="stat-value">{{ $stats['orders'] }}</div>
            <div class="stat-label">Total Orders</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-success/10 text-success">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <div class="stat-value">₹{{ number_format($stats['revenue'], 2) }}</div>
            <div class="stat-label">Total Revenue</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-secondary/10 text-secondary">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <div class="stat-value">{{ $stats['products'] }}</div>
            <div class="stat-label">Products</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon bg-warning/10 text-warning">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
            </div>
            <div class="stat-value">{{ $stats['users'] }}</div>
            <div class="stat-label">Customers</div>
        </div>
    </div>

    <div class="grid lg:grid-cols-2 gap-6">
        <div class="card p-6">
            <h3 class="font-semibold text-white mb-4">Recent Orders</h3>
            <div class="space-y-3">
                @forelse($recentOrders as $order)
                    <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-white">#{{ $order->order_number }}</p>
                            <p class="text-xs text-gray-400">{{ $order->created_at->diffForHumans() }}</p>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $order->status === 'delivered' ? 'bg-green-500/20 text-green-300' : 'bg-yellow-500/20 text-yellow-300' }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No orders yet.</p>
                @endforelse
            </div>
        </div>

        <div class="card p-6">
            <h3 class="font-semibold text-white mb-4">Pending Payment Verifications</h3>
            <div class="space-y-3">
                @forelse($pendingVerifications as $payment)
                    <div class="flex items-center justify-between p-3 bg-white/5 rounded-lg">
                        <div>
                            <p class="text-sm font-medium text-white">Order #{{ $payment->order->order_number ?? 'N/A' }}</p>
                            <p class="text-xs text-gray-400">₹{{ number_format($payment->amount, 2) }}</p>
                        </div>
                        <a href="{{ route('admin.payment-verification') }}" class="text-xs text-secondary hover:underline">Review</a>
                    </div>
                @empty
                    <p class="text-gray-400 text-sm">No pending verifications.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
