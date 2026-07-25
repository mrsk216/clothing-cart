@extends('admin.layout')

@section('title', 'Order #' . $order->order_number)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Order #{{ $order->order_number }}</h1>
        <a href="{{ route('admin.orders') }}" class="btn-outline">Back to Orders</a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Order Details -->
        <div class="lg:col-span-2 space-y-6">
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Order Information</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Order Number</p>
                        <p class="font-medium text-primary">#{{ $order->order_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date</p>
                        <p class="font-medium text-primary">{{ $order->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $order->status === 'delivered' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}
                            {{ !in_array($order->status, ['delivered','cancelled']) ? 'bg-yellow-100 text-yellow-800' : '' }}">
                            {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                        </span>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Total Amount</p>
                        <p class="font-medium text-primary text-lg">₹{{ number_format($order->total, 2) }}</p>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Order Items</h3>
                <div class="space-y-3">
                    @foreach($order->items as $item)
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                    <span class="text-2xl">📦</span>
                                </div>
                                <div>
                                    <p class="font-medium text-primary">{{ $item->product->name ?? 'Product' }}</p>
                                    <p class="text-sm text-gray-500">Qty: {{ $item->quantity }} × ₹{{ number_format($item->unit_price, 2) }}</p>
                                </div>
                            </div>
                            <p class="font-medium text-primary">₹{{ number_format($item->subtotal, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Customer Information</h3>
                <div class="space-y-3">
                    <div>
                        <p class="text-sm text-gray-500">Name</p>
                        <p class="font-medium text-primary">{{ $order->user?->name ?? 'Guest' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-primary">{{ $order->user?->email ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="font-medium text-primary">{{ $order->shipping_phone ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Shipping Address</h3>
                <p class="text-sm text-gray-700">{{ $order->shipping_address ?? 'N/A' }}</p>
            </div>

            @if($order->payment)
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Payment Information</h3>
                <div class="space-y-2 text-sm">
                    <div>
                        <p class="text-gray-500">UTR Number</p>
                        <p class="font-medium font-mono">{{ $order->payment->utr_number ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Amount</p>
                        <p class="font-medium">₹{{ number_format($order->payment->amount, 2) }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Method</p>
                        <p class="font-medium capitalize">{{ str_replace('_', ' ', $order->payment->payment_method ?? 'N/A') }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Status</p>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                            {{ $order->payment->status === 'approved' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $order->payment->status === 'rejected' ? 'bg-red-100 text-red-800' : '' }}
                            {{ $order->payment->status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                            {{ ucfirst($order->payment->status) }}
                        </span>
                    </div>
                    @if($order->payment->screenshot_path)
                        <div>
                            <p class="text-gray-500">Screenshot</p>
                            <a href="{{ asset('storage/' . $order->payment->screenshot_path) }}" target="_blank" class="text-secondary hover:underline">View Payment Proof</a>
                        </div>
                    @endif
                    @if($order->payment->rejection_reason)
                        <div>
                            <p class="text-gray-500">Rejection Reason</p>
                            <p class="text-red-600">{{ $order->payment->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif

            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Update Status</h3>
                <form method="POST" action="{{ route('admin.orders.status', $order->id) }}">
                    @csrf @method('PUT')
                    <select name="status" class="input-field mb-3">
                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="shipped" {{ $order->status === 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="delivered" {{ $order->status === 'delivered' ? 'selected' : '' }}>Delivered</option>
                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    <button type="submit" class="btn-primary w-full">Update Status</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
