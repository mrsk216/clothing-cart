@extends('admin.layout')

@section('title', 'Notifications')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-primary mb-6">Notifications</h1>

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg text-sm">{{ session('success') }}</div>
    @endif

    <div class="card p-6">
        <div class="space-y-3">
            @forelse($notifications as $notification)
                <div class="flex items-start justify-between gap-4 p-4 rounded-lg {{ $notification->is_read ? 'bg-gray-50' : 'bg-secondary/5 border border-secondary/20' }}">
                    <div>
                        <p class="font-medium text-primary">{{ $notification->title }}</p>
                        <p class="text-sm text-gray-600 mt-1">{{ $notification->message }}</p>
                        <p class="text-xs text-gray-400 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                    </div>
                    <div class="flex items-center gap-2 shrink-0">
                        @if($notification->action_url)
                            <a href="{{ $notification->action_url }}" class="text-sm text-secondary hover:underline">Open</a>
                        @endif
                        @unless($notification->is_read)
                            <form method="POST" action="{{ route('admin.notifications.read', $notification) }}">
                                @csrf
                                <button type="submit" class="text-sm text-gray-600 hover:text-primary">Mark read</button>
                            </form>
                        @endunless
                    </div>
                </div>
            @empty
                <p class="text-center text-gray-400 py-8">No notifications yet.</p>
            @endforelse
        </div>

        @if($notifications->hasPages())
            <div class="mt-4">{{ $notifications->links() }}</div>
        @endif
    </div>
</div>
@endsection
