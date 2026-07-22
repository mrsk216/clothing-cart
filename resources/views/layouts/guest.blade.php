<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="@yield('meta_description', config('app.name', 'SPM App'))">
    <meta name="keywords" content="@yield('meta_keywords', 'paper, stamp pad, rubber seal, screen printing')">

    <title>@yield('title', config('app.name', 'SPM App'))</title>

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

    <!-- Page Content -->
    <main class="min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('partials.footer')

    <!-- WhatsApp Widget -->
    @include('partials.whatsapp-widget')

    <!-- Toast Notifications -->
    @include('partials.toast')

    @stack('scripts')
</body>
</html>
