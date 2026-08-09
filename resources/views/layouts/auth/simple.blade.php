<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', config('app.name', 'Clothing Cart'))">
    <title>@yield('title', __('Login')) – {{ $siteName() }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="font-sans antialiased bg-surface text-text-primary">
    <!-- Header -->
    @include('partials.header')

    <!-- Auth Page Content -->
    <main class="min-h-[calc(100vh-200px)] flex items-center justify-center py-12 px-4">
        <div class="w-full max-w-md">
            <!-- Logo centered -->
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-r from-primary to-accent rounded-full flex items-center justify-center shadow-lg animate-pulse-glow">
                        <span class="text-white font-serif font-bold text-lg">CC</span>
                    </div>
                    <div class="text-left hidden sm:block">
                        <h1 class="text-xl font-serif font-bold text-primary leading-tight bg-gradient-to-r from-primary to-accent bg-clip-text text-transparent">{{ $siteName() }}</h1>
                        <p class="text-xs text-gray-500 tracking-widest uppercase">Fashion & Clothing</p>
                    </div>
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                {{ $slot }}
            </div>
        </div>
    </main>

    <!-- Simple Footer -->
    <footer class="bg-primary text-white py-6">
        <div class="max-w-7xl mx-auto px-4 text-center text-sm text-white/60">
            &copy; {{ date('Y') }} {{ $siteName() }}. All rights reserved.
        </div>
    </footer>

    @persist('toast')
        <flux:toast.group>
            <flux:toast />
        </flux:toast.group>
    @endpersist

    @stack('scripts')
    @fluxScripts
</body>
</html>
