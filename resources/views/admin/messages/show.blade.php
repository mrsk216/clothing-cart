@extends('admin.layout')

@section('title', 'Message from ' . $message->name)

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold text-primary">Message Details</h1>
        <a href="{{ route('admin.messages') }}" class="btn-outline">Back to Messages</a>
    </div>

    <div class="grid lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2">
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Message Information</h3>
                <div class="grid md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">From</p>
                        <p class="font-medium text-primary">{{ $message->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Email</p>
                        <p class="font-medium text-primary">{{ $message->email }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Phone</p>
                        <p class="font-medium text-primary">{{ $message->phone ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Date</p>
                        <p class="font-medium text-primary">{{ $message->created_at->format('d M Y, h:i A') }}</p>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-sm text-gray-500 mb-2">Message</p>
                    <div class="bg-gray-50 rounded-lg p-4 text-gray-700 whitespace-pre-wrap">{{ $message->message }}</div>
                </div>
            </div>
        </div>

        <div>
            <div class="card p-6">
                <h3 class="font-semibold text-primary mb-4">Reply</h3>
                <form method="POST" action="{{ route('admin.messages.reply', $message->id) }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Your Reply</label>
                        <textarea name="reply" rows="6" class="input-field" placeholder="Type your reply here..." required>{{ old('reply', $message->reply) }}</textarea>
                        @error('reply')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <button type="submit" class="btn-primary w-full">Send Reply</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
