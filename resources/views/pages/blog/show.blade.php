@extends('layouts.guest')

@section('title', $post->title . ' - ' . $siteName())

@section('meta')
    @if($post->meta_title)<meta name="title" content="{{ $post->meta_title }}">@endif
    @if($post->meta_description)<meta name="description" content="{{ $post->meta_description }}">@endif
@endsection

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <a href="{{ route('blog') }}">Blog</a>
        <span class="separator">/</span>
        <span class="current">{{ $post->title }}</span>
    </div>

    <article class="card p-6 md:p-8">
        @if($post->featured_image)
            <div class="mb-6 -mx-6 -mt-6 md:-mx-8 md:-mt-8">
                <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-64 md:h-80 object-cover rounded-t-xl">
            </div>
        @endif

        <div class="flex flex-wrap items-center gap-3 text-sm text-gray-500 mb-4">
            <span class="text-secondary font-medium">{{ $post->category?->name ?? 'General' }}</span>
            <span>•</span>
            <span>{{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</span>
            @if($post->author)
                <span>•</span>
                <span>By {{ $post->author->name }}</span>
            @endif
        </div>

        <h1 class="text-3xl font-bold text-primary mt-2 mb-4">{{ $post->title }}</h1>

        @if($post->excerpt)
            <p class="text-gray-600 italic mb-6 border-l-4 border-secondary pl-4">{{ $post->excerpt }}</p>
        @endif

        <div class="prose max-w-none text-gray-700 leading-relaxed">
            {!! nl2br(e($post->content)) !!}
        </div>

        @if($post->blogTags->count() > 0)
            <div class="flex flex-wrap gap-2 mt-6 pt-6 border-t">
                @foreach($post->blogTags as $tag)
                    <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-600 rounded-full text-xs font-medium">{{ $tag->name }}</span>
                @endforeach
            </div>
        @endif
    </article>

    {{-- Comments Section --}}
    <div class="card p-6 md:p-8 mt-8">
        <h2 class="text-xl font-bold text-primary mb-6">
            Comments ({{ $post->approvedComments->count() }})
        </h2>

        @if($post->approvedComments->count() > 0)
            <div class="space-y-4 mb-8">
                @foreach($post->approvedComments as $comment)
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="w-8 h-8 rounded-full bg-secondary/20 flex items-center justify-center text-sm font-medium text-secondary">
                                {{ strtoupper(substr($comment->user?->name ?? $comment->guest_name ?? 'A', 0, 1)) }}
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-700">{{ $comment->user?->name ?? $comment->guest_name ?? 'Anonymous' }}</p>
                                <p class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">{{ $comment->comment }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-4">No comments yet. Be the first to comment!</p>
        @endif

        {{-- Comment Form --}}
        @auth
            @if(auth()->user()->isCustomer())
                <div class="border-t pt-6">
                    <h3 class="text-lg font-semibold text-primary mb-4">Leave a Comment</h3>
                    <form method="POST" action="{{ route('blog.comment.store', $post->id) }}" class="space-y-4">
                        @csrf
                        <div>
                            <textarea name="comment" rows="4" required class="input-field @error('comment') border-red-500 @enderror" placeholder="Write your comment...">{{ old('comment') }}</textarea>
                            @error('comment')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="btn-primary">Post Comment</button>
                    </form>
                </div>
            @else
                <div class="border-t pt-6 text-center text-gray-500">
                    Comments are only available for customer accounts.
                </div>
            @endif
        @else
            <div class="border-t pt-6 text-center">
                <p class="text-gray-500">
                    <a href="{{ route('login') }}" class="text-secondary hover:underline">Login</a> to leave a comment.
                </p>
            </div>
        @endauth
    </div>

    <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 text-secondary mt-6 hover:underline">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Blog
    </a>
</div>
@endsection
