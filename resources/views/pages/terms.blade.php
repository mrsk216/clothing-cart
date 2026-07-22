@extends('layouts.guest')

@section('title', 'Terms & Conditions')

@section('content')
<div class="max-w-4xl mx-auto px-4 py-8">
    <div class="breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span class="separator">/</span>
        <span class="current">Terms & Conditions</span>
    </div>

    <h1 class="text-3xl font-bold text-primary mb-6">Terms & Conditions</h1>
    <div class="card p-6 prose max-w-none text-gray-700">
        <h2 class="text-xl font-bold text-primary mt-6 mb-3">Acceptance of Terms</h2>
        <p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement.</p>
        <h2 class="text-xl font-bold text-primary mt-6 mb-3">Use of the Website</h2>
        <p>You agree to use this website only for lawful purposes and in a way that does not infringe the rights of, restrict or inhibit anyone else's use and enjoyment of the website.</p>
        <h2 class="text-xl font-bold text-primary mt-6 mb-3">Pricing and Payment</h2>
        <p>All prices are subject to change without notice. We reserve the right to modify or discontinue any product without notice.</p>
    </div>
</div>
@endsection
