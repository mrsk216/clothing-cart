<x-layouts::auth :title="__('Register')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-primary">{{ __('Create Account') }}</h2>
            <p class="text-gray-500 mt-1 text-sm">{{ __('Join us and start shopping for premium products') }}</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        @if ($teamInvitation)
            <x-team-invitation-alert :invitation="$teamInvitation" :action="__('Register')" />
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-5">
            @csrf

            <!-- Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Full Name') }}</label>
                <input
                    id="name"
                    name="name"
                    type="text"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="John Doe"
                    class="input-field @error('name') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                />
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email address') }}</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    placeholder="email@example.com"
                    class="input-field @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                />
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Password') }}</label>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Min. 8 characters"
                    class="input-field @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Confirm Password') }}</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Re-enter your password"
                    class="input-field"
                />
            </div>

            <button type="submit" class="btn-primary w-full py-3">
                {{ __('Create account') }}
            </button>
        </form>

        <div class="text-center text-sm text-gray-500">
            <span>{{ __('Already have an account?') }}</span>
            <a href="{{ $teamInvitation ? route('login', ['invitation' => $teamInvitation['code']]) : route('login') }}" class="text-secondary font-medium hover:underline ml-1">
                {{ __('Log in') }}
            </a>
        </div>
    </div>
</x-layouts::auth>
