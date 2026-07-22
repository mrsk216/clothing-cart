@extends('layouts.guest')

@section('title', 'Track Order')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <span class="current">Track Order</span>
    </div>

    <h1 class="text-2xl font-bold text-primary mb-6">Track Your Order</h1>

    <div class="card p-6 mb-8">
        <form method="POST" action="{{ route('track.order.search') }}" class="flex gap-3">
            @csrf
            <input type="text" name="order_number" placeholder="Enter Order ID (e.g., ORD-12345)" required class="input-field flex-1">
            <button type="submit" class="btn-primary">Track</button>
        </form>
    </div>

    @if(isset($order))
        <div class="card p-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="font-semibold text-primary">Order #{{ $order->order_number }}</h3>
                    <p class="text-sm text-gray-500">Placed on {{ $order->created_at->format('d M Y, h:i A') }}</p>
                </div>
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                    {{ !in_array($order->status, ['delivered','cancelled']) ? 'bg-yellow-100 text-yellow-800' : '' }}">
                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                </span>
            </div>

            <div class="border-t border-gray-200 pt-4">
                <h4 class="font-semibold text-primary mb-3">Order Timeline</h4>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full bg-success mt-2"></div>
                        <div>
                            <p class="text-sm font-medium">Order Placed</p>
                            <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                        </div>
                    </div>
                    @if(in_array($order->status, ['processing', 'shipped', 'delivered']))
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-success mt-2"></div>
                            <div>
                                <p class="text-sm font-medium">Payment Verified</p>
                                <p class="text-xs text-gray-500">Payment confirmed</p>
                            </div>
                        </div>
                    @endif
                    @if(in_array($order->status, ['shipped', 'delivered']))
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-success mt-2"></div>
                            <div>
                                <p class="text-sm font-medium">Shipped</p>
                                <p class="text-xs text-gray-500">On the way</p>
                            </div>
                        </div>
                    @endif
                    @if($order->status === 'delivered')
                        <div class="flex items-start gap-3">
                            <div class="w-2 h-2 rounded-full bg-success mt-2"></div>
                            <div>
                                <p class="text-sm font-medium">Delivered</p>
                                <p class="text-xs text-gray-500">Order completed</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
