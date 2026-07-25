@extends('layouts.guest')

@section('title', 'Blog - ' . $siteName())

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <span class="current">Blog</span>
    </div>

    <h1 class="text-2xl font-bold text-primary mb-6">Our Blog</h1>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($posts as $post)
            <div class="card overflow-hidden">
                @if ($post->featured_image != null)
                    <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" class="w-full h-56 object-cover">
                @else
                    <div class="aspect-video bg-gradient-to-br from-secondary/10 to-primary/10 flex items-center justify-center">
                        <span class="text-4xl">📝</span>
                    </div>                    
                @endif
                <div class="p-4">
                    <span class="text-xs text-secondary font-medium">{{ $post->category?->name ?? 'General' }}</span>
                    <a href="{{ route('blog.show', $post->slug) }}">
                        <h3 class="font-semibold text-primary mt-1 mb-2 line-clamp-2 hover:text-secondary">{{ $post->title }}</h3>
                    </a>
                    <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $post->excerpt ?? Str::limit($post->content, 100) }}</p>
                    <p class="text-xs text-gray-400">{{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">No blog posts yet.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-8">
        {{ $posts->links() }}
    </div>
</div>
@endsection
