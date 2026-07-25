@extends('admin.layout')

@section('title', 'Reviews Management')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Reviews Management</h1>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card p-6">
        @if($reviews->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="text-left text-sm text-gray-500 border-b">
                            <th class="pb-3 pr-4">Product</th>
                            <th class="pb-3 pr-4">Customer</th>
                            <th class="pb-3 pr-4">Rating</th>
                            <th class="pb-3 pr-4">Comment</th>
                            <th class="pb-3 pr-4">Status</th>
                            <th class="pb-3 pr-4">Date</th>
                            <th class="pb-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($reviews as $review)
                            <tr class="border-b border-gray-100">
                                <td class="py-3 pr-4">
                                    <a href="{{ route('admin.products.show', $review->product_id) }}" class="text-secondary hover:underline text-sm font-medium">
                                        {{ $review->product->name ?? 'N/A' }}
                                    </a>
                                </td>
                                <td class="py-3 pr-4 text-sm text-gray-600">{{ $review->user->name ?? 'N/A' }}</td>
                                <td class="py-3 pr-4">
                                    <div class="flex items-center gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                        @endfor
                                    </div>
                                </td>
                                <td class="py-3 pr-4 text-sm text-gray-600 max-w-xs truncate">{{ $review->comment ?? '—' }}</td>
                                <td class="py-3 pr-4">
                                    @if($review->is_approved)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                    @endif
                                </td>
                                <td class="py-3 pr-4 text-sm text-gray-500">{{ $review->created_at->format('d M Y') }}</td>
                                <td class="py-3">
                                    <div class="flex gap-2">
                                        @if(!$review->is_approved)
                                            <form method="POST" action="{{ route('admin.reviews.approve', $review) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-xs bg-green-100 text-green-700 px-2 py-1 rounded hover:bg-green-200">Approve</button>
                                            </form>
                                        @else
                                            <form method="POST" action="{{ route('admin.reviews.reject', $review) }}" class="inline">
                                                @csrf
                                                <button type="submit" class="text-xs bg-yellow-100 text-yellow-700 px-2 py-1 rounded hover:bg-yellow-200">Reject</button>
                                            </form>
                                        @endif
                                        <form method="POST" action="{{ route('admin.reviews.destroy', $review) }}" class="inline" onsubmit="return confirm('Delete this review?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $reviews->links() }}
            </div>
        @else
            <p class="text-center text-gray-500 py-8">No reviews found.</p>
        @endif
    </div>
</div>
@endsection
