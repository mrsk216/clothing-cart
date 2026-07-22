@extends('admin.layout')

@section('title', 'Manage Orders')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-white mb-6">Orders Management</h1>

    <div class="card p-6">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order #</th>
                        <th>Customer</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->order_number }}</td>
                            <td>{{ $order->user?->name ?? 'Guest' }}</td>
                            <td>₹{{ number_format($order->total, 2) }}</td>
                            <td>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $order->status === 'delivered' ? 'bg-green-500/20 text-green-300' : '' }}
                                    {{ $order->status === 'cancelled' ? 'bg-red-500/20 text-red-300' : '' }}
                                    {{ !in_array($order->status, ['delivered','cancelled']) ? 'bg-yellow-500/20 text-yellow-300' : '' }}">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="text-secondary hover:underline text-sm">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-gray-400 py-8">No orders found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>
</div>
@endsection
