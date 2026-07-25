<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $defaultDesc = \App\Models\Setting::where('key', 'meta_description')->value('value')
            ?: 'Buy paper products, stamp pads, rubber seals and screen printing materials online. Fast delivery across India.';
        $defaultKeywords = \App\Models\Setting::where('key', 'meta_keywords')->value('value')
            ?: 'paper, stamp pad, rubber seal, screen printing, wholesale stationery';
        $pageTitle = trim($__env->yieldContent('title', config('app.name', 'SPM Enterprise')));
        $pageDesc = trim($__env->yieldContent('meta_description', $defaultDesc));
        $canonical = trim($__env->yieldContent('canonical', url()->current()));
    @endphp
    <meta name="description" content="{{ $pageDesc }}">
    <meta name="keywords" content="@yield('meta_keywords', $defaultKeywords)">
    <meta name="robots" content="@yield('meta_robots', 'index, follow')">
    <link rel="canonical" href="{{ $canonical }}">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ config('app.name', 'SPM Enterprise') }}">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDesc }}">
    <meta property="og:url" content="{{ $canonical }}">
    @hasSection('og_image')
        <meta property="og:image" content="@yield('og_image')">
    @endif

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDesc }}">

    <title>{{ $pageTitle }}</title>

    <link rel="icon" href="/favicon.ico" sizes="any">
    <link rel="icon" href="/favicon.svg" type="image/svg+xml">
    <link rel="apple-touch-icon" href="/apple-touch-icon.png">

    @fonts
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
    @stack('structured_data')
</head>
<body class="font-sans antialiased bg-surface text-text-primary">
    @include('partials.header')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('partials.footer')
    @include('partials.whatsapp-widget')
    @include('partials.toast')

    @stack('scripts')
</body>
</html>
