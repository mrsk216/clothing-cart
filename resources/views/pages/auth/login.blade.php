<x-layouts::auth :title="__('Log in')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-primary">{{ __('Welcome Back') }}</h2>
            <p class="text-gray-500 mt-1 text-sm">{{ __('Enter your credentials to access your account') }}</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        @if ($teamInvitation)
            <x-team-invitation-alert :invitation="$teamInvitation" :action="__('Log in')" />
        @endif

        <x-passkey-verify />

        <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-5">
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
                <div class="flex items-center justify-between mb-1.5">
                    <label for="password" class="block text-sm font-medium text-gray-700">{{ __('Password') }}</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-xs text-secondary hover:underline">
                            {{ __('Forgot password?') }}
                        </a>
                    @endif
                </div>
                <input
                    id="password"
                    name="password"
                    type="password"
                    required
                    autocomplete="current-password"
                    placeholder="Enter your password"
                    class="input-field @error('password') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                />
                @error('password')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} class="w-4 h-4 rounded border-gray-300 text-secondary focus:ring-secondary/20">
                <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>

            <button type="submit" class="btn-primary w-full py-3">
                {{ __('Log in') }}
            </button>
        </form>

        <div class="text-center text-sm text-gray-500">
            <span>{{ __('Don\'t have an account?') }}</span>
            <a href="{{ $teamInvitation ? route('register', ['invitation' => $teamInvitation['code']]) : route('register') }}" class="text-secondary font-medium hover:underline ml-1">
                {{ __('Sign up') }}
            </a>
        </div>
    </div>
</x-layouts::auth>
