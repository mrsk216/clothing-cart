@extends('layouts.guest')

@section('title', $post->title . ' - SPM Enterprise')

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
        <span class="text-sm text-secondary font-medium">{{ $post->category?->name ?? 'General' }}</span>
        <h1 class="text-3xl font-bold text-primary mt-2 mb-4">{{ $post->title }}</h1>
        <p class="text-sm text-gray-500 mb-6">{{ $post->published_at?->format('d M Y') ?? $post->created_at->format('d M Y') }}</p>

        <div class="prose max-w-none text-gray-700 leading-relaxed">
            {!! nl2br(e($post->content)) !!}
        </div>
    </article>

    <a href="{{ route('blog') }}" class="inline-flex items-center gap-2 text-secondary mt-6 hover:underline">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Blog
    </a>
</div>
@endsection
