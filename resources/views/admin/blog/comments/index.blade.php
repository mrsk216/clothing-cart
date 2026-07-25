@extends('admin.layout')

@section('title', 'Blog Comments')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Blog Comments</h1>
        <a href="{{ route('admin.blog') }}" class="btn-outline">Back to Blog</a>
    </div>

    <div class="card p-6">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Comment</th>
                        <th>Post</th>
                        <th>User</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($comments as $comment)
                        <tr>
                            <td class="max-w-xs">
                                <p class="text-sm text-gray-700 line-clamp-2">{{ $comment->comment }}</p>
                            </td>
                            <td>
                                {{ Str::limit($comment->post?->title, 40) }}
                            </td>
                            <td>
                                @if($comment->user)
                                    <span class="text-sm">{{ $comment->user->name }}</span>
                                @else
                                    <span class="text-sm text-gray-400">{{ $comment->guest_name ?? 'Guest' }}</span>
                                @endif
                            </td>
                            <td>
                                @if($comment->is_approved)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Approved</span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Pending</span>
                                @endif
                            </td>
                            <td class="text-sm text-gray-500">{{ $comment->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="flex items-center gap-1.5">
                                    @if(!$comment->is_approved)
                                        <form method="POST" action="{{ route('admin.blog.comments.approve', $comment->id) }}" class="inline">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-green-50 text-green-600 rounded-lg hover:bg-green-100 transition-colors text-xs font-medium shadow-sm">
                                                Approve
                                            </button>
                                        </form>
                                    @endif
                                    <form method="POST" action="{{ route('admin.blog.comments.destroy', $comment->id) }}" class="inline" onsubmit="return confirm('Delete this comment?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors text-xs font-medium shadow-sm">
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-gray-400 py-8">No comments yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">{{ $comments->links() }}</div>
    </div>
</div>
@endsection
