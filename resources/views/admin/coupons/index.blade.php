@extends('admin.layout')

@section('title', 'Coupons')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Coupons</h1>
        <button onclick="document.getElementById('couponForm').classList.toggle('hidden')" class="btn-primary">Add Coupon</button>
    </div>

    <div id="couponForm" class="card p-6 mb-6 hidden">
        <form method="POST" action="{{ route('admin.coupons.store') }}" class="space-y-4">
            @csrf
            <div class="grid md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Code *</label>
                    <input type="text" name="code" required class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type *</label>
                    <select name="type" class="input-field">
                        <option value="percentage">Percentage</option>
                        <option value="fixed">Fixed Amount</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Value *</label>
                    <input type="number" name="value" step="0.01" required class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Min Order Amount</label>
                    <input type="number" name="min_order_amount" step="0.01" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Usage Limit</label>
                    <input type="number" name="usage_limit" class="input-field">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expires At</label>
                    <input type="date" name="expires_at" class="input-field">
                </div>
            </div>
            <button type="submit" class="btn-primary">Save Coupon</button>
        </form>
    </div>

    <div class="card p-6">
        @foreach($coupons as $coupon)
            <div id="editCoupon{{ $coupon->id }}" class="hidden mb-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <form method="POST" action="{{ route('admin.coupons.update', $coupon->id) }}" class="space-y-3">
                    @csrf @method('PUT')
                    <div class="grid md:grid-cols-2 gap-3">
                        <input type="text" name="code" value="{{ $coupon->code }}" required class="input-field" placeholder="Coupon Code">
                        <select name="type" class="input-field">
                            <option value="percentage" {{ $coupon->type === 'percentage' ? 'selected' : '' }}>Percentage</option>
                            <option value="fixed" {{ $coupon->type === 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        </select>
                        <input type="number" name="value" value="{{ $coupon->value }}" step="0.01" required class="input-field" placeholder="Value">
                        <input type="number" name="min_order_amount" value="{{ $coupon->min_order_amount }}" step="0.01" class="input-field" placeholder="Min Order Amount">
                        <input type="number" name="usage_limit" value="{{ $coupon->usage_limit }}" class="input-field" placeholder="Usage Limit">
                        <input type="date" name="expires_at" value="{{ $coupon->expires_at?->format('Y-m-d') }}" class="input-field">
                    </div>
                    <div class="flex gap-2">
                        <button type="submit" class="btn-primary text-sm py-2">Update</button>
                        <button type="button" onclick="document.getElementById('editCoupon{{ $coupon->id }}').classList.toggle('hidden')" class="btn-outline text-sm py-2">Cancel</button>
                    </div>
                </form>
            </div>
        @endforeach

        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Used</th>
                        <th>Expires</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ ucfirst($coupon->type) }}</td>
                            <td>{{ $coupon->type === 'percentage' ? $coupon->value . '%' : '₹' . $coupon->value }}</td>
                            <td>{{ $coupon->used_count }}/{{ $coupon->usage_limit ?? '∞' }}</td>
                            <td>{{ $coupon->expires_at?->format('d M Y') ?? 'Never' }}</td>
                            <td>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $coupon->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                                </span>
                            </td>
                            <td>
                                <div class="flex items-center gap-1.5">
                                    <button onclick="document.getElementById('editCoupon{{ $coupon->id }}').classList.toggle('hidden')" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors text-xs font-medium shadow-sm" title="Edit">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('admin.coupons.destroy', $coupon->id) }}" class="inline" onsubmit="return confirm('Delete coupon {{ $coupon->code }}? This cannot be undone.')">
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
                        <tr><td colspan="7" class="text-center text-gray-400 py-8">No coupons found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
