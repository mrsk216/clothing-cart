<x-layouts::auth :title="__('Email verification')">
    <div class="flex flex-col gap-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-primary">{{ __('Verify Email') }}</h2>
            <p class="text-gray-500 mt-1 text-sm">{{ __('Please verify your email address by clicking on the link we just emailed to you.') }}</p>
        </div>

        @if (session('status') === 'verification-link-sent')
            <div class="p-4 bg-green-50 border border-green-200 rounded-lg text-sm text-green-700 text-center">
                {{ __('A new verification link has been sent to the email address you provided during registration.') }}
            </div>
        @endif

        <div class="flex flex-col gap-3">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit" class="btn-primary w-full py-3">
                    {{ __('Resend verification email') }}
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-ghost w-full text-gray-500 hover:text-red-600 text-sm">
                    {{ __('Log out') }}
                </button>
            </form>
        </div>
    </div>
</x-layouts::auth>
