<x-layouts::auth :title="__('Reset password')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-primary">{{ __('Reset Password') }}</h2>
            <p class="text-gray-500 mt-1 text-sm">{{ __('Please enter your new password below') }}</p>
        </div>

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('password.update') }}" class="flex flex-col gap-5">
            @csrf
            <!-- Token -->
            <input type="hidden" name="token" value="{{ request()->route('token') }}">

            <!-- Email Address -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email') }}</label>
                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ request('email') }}"
                    required
                    autocomplete="email"
                    class="input-field @error('email') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                />
                @error('email')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('New Password') }}</label>
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
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Confirm New Password') }}</label>
                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    required
                    autocomplete="new-password"
                    placeholder="Re-enter your new password"
                    class="input-field"
                />
            </div>

            <button type="submit" class="btn-primary w-full py-3">
                {{ __('Reset password') }}
            </button>
        </form>
    </div>
</x-layouts::auth>
