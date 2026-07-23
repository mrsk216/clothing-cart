<x-layouts::auth :title="__('Confirm password')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-primary">{{ __('Confirm Password') }}</h2>
            <p class="text-gray-500 mt-1 text-sm">{{ __('This is a secure area. Please confirm your password before continuing.') }}</p>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <x-passkey-verify
            options-route="passkey.confirm-options"
            submit-route="passkey.confirm"
            :label="__('Confirm with passkey')"
            :loading-label="__('Confirming...')"
            :separator="__('Or confirm with password')"
        />

        <form method="POST" action="{{ route('password.confirm.store') }}" class="flex flex-col gap-5">
            @csrf

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Password') }}</label>
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

            <button type="submit" class="btn-primary w-full py-3">
                {{ __('Confirm') }}
            </button>
        </form>
    </div>
</x-layouts::auth>
