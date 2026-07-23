@extends('admin.layout')

@section('title', 'Contact Messages')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold text-primary mb-6">Contact Messages</h1>

    <div class="card p-6">
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr>
                            <td>{{ $message->name }}</td>
                            <td>{{ $message->email }}</td>
                            <td>{{ $message->phone ?? 'N/A' }}</td>
                            <td>{{ Str::limit($message->message, 50) }}</td>
                            <td>{{ $message->created_at->format('d M Y') }}</td>
                            <td>
                                <a href="mailto:{{ $message->email }}" class="text-secondary hover:underline text-sm text-shadow">Reply</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="text-center text-gray-400 py-8">No messages found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
