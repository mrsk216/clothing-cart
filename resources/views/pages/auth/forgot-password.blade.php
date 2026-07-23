<x-layouts::auth :title="__('Forgot password')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-primary">{{ __('Forgot Password?') }}</h2>
            <p class="text-gray-500 mt-1 text-sm">{{ __('Enter your email to receive a password reset link') }}</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email address') }}</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    placeholder="email@example.com"
                    class="input-field @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                />
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary w-full py-3">
                {{ __('Send Reset Link') }}
            </button>
        </form>

        <div class="text-center text-sm text-gray-500">
            <span>{{ __('Remember your password?') }}</span>
            <a href="{{ route('login') }}" class="text-secondary font-medium hover:underline ml-1">
                {{ __('Log in') }}
            </a>
        </div>
    </div>
</x-layouts::auth>
