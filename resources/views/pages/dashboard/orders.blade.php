@extends('layouts.guest')

@section('title', 'My Orders')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <span class="separator">/</span>
        <span class="current">My Orders</span>
    </div>

    <h1 class="text-2xl font-bold text-primary mb-6">My Orders</h1>

    @if($orders->count() > 0)
        <div class="space-y-4">
            @foreach($orders as $order)
                <div class="card p-6">
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h3 class="font-semibold text-primary">Order #{{ $order->order_number }}</h3>
                            <p class="text-sm text-gray-500">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                            {{ !in_array($order->status, ['delivered','cancelled']) ? 'bg-yellow-100 text-yellow-800' : '' }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                    <div class="border-t border-gray-200 pt-4">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">{{ $order->items->count() }} item(s)</p>
                                <p class="text-lg font-bold text-primary">₹{{ number_format($order->total, 2) }}</p>
                            </div>
                            <a href="{{ route('order.detail', $order->id) }}" class="btn-primary text-sm">View Details</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-6">
            {{ $orders->links() }}
        </div>
    @else
        <div class="text-center py-16">
            <span class="text-5xl mb-4 block">📦</span>
            <h3 class="text-xl font-semibold text-primary mb-2">No orders yet</h3>
            <p class="text-gray-500 mb-6">Start shopping to place your first order</p>
            <a href="{{ route('shop') }}" class="btn-primary">Start Shopping</a>
        </div>
    @endif
</div>
@endsection
