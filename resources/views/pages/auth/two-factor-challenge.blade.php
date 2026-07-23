<x-layouts::auth :title="__('Two-factor authentication')">
    <div class="flex flex-col gap-6">
        <div
            class="relative w-full"
            x-cloak
            x-data="{
                showRecoveryInput: @js($errors->has('recovery_code')),
                code: ['', '', '', '', '', ''],
                recovery_code: '',
                focusOtp() {
                    this.$nextTick(() => {
                        const firstInput = this.$el.querySelector('.otp-input');
                        if (firstInput) firstInput.focus();
                    });
                },
                init() {
                    if (!this.showRecoveryInput) {
                        this.focusOtp();
                    }
                },
                toggleInput() {
                    this.showRecoveryInput = !this.showRecoveryInput;
                    this.code = ['', '', '', '', '', ''];
                    this.recovery_code = '';
                    this.$nextTick(() => {
                        this.showRecoveryInput
                            ? this.$refs.recovery_code?.focus()
                            : this.focusOtp();
                    });
                },
                moveNext(index, event) {
                    if (event.target.value && index < 5) {
                        const next = this.$el.querySelectorAll('.otp-input')[index + 1];
                        if (next) next.focus();
                    }
                },
                movePrev(index, event) {
                    if (event.key === 'Backspace' && !event.target.value && index > 0) {
                        const prev = this.$el.querySelectorAll('.otp-input')[index - 1];
                        if (prev) { prev.focus(); prev.value = ''; }
                    }
                },
            }"
        >
            <div x-show="!showRecoveryInput">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-primary">{{ __('Authentication Code') }}</h2>
                    <p class="text-gray-500 mt-1 text-sm">{{ __('Enter the code from your authenticator app.') }}</p>
                </div>
            </div>

            <div x-show="showRecoveryInput">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-primary">{{ __('Recovery Code') }}</h2>
                    <p class="text-gray-500 mt-1 text-sm">{{ __('Enter one of your emergency recovery codes.') }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('two-factor.login.store') }}" class="flex flex-col gap-5">
                @csrf

                <div x-show="!showRecoveryInput">
                    <div class="flex justify-center gap-2 my-5">
                        <template x-for="(digit, index) in code" :key="index">
                            <input
                                type="text"
                                inputmode="numeric"
                                pattern="[0-9]*"
                                maxlength="1"
                                autocomplete="one-time-code"
                                x-model="code[index]"
                                @input="moveNext(index, $event)"
                                @keydown="movePrev(index, $event)"
                                class="otp-input w-12 h-14 text-center text-xl font-bold border-2 border-gray-300 rounded-lg focus:border-secondary focus:ring-2 focus:ring-secondary/20 focus:outline-none"
                                :class="{ 'border-secondary': code[index] }"
                            />
                        </template>
                    </div>
                    <input type="hidden" name="code" x-bind:value="code.join('')" />
                    @error('code')
                        <p class="text-red-500 text-xs text-center">{{ $message }}</p>
                    @enderror
                </div>

                <div x-show="showRecoveryInput">
                    <div>
                        <label for="recovery_code" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Recovery Code') }}</label>
                        <input
                            type="text"
                            name="recovery_code"
                            id="recovery_code"
                            x-ref="recovery_code"
                            x-bind:required="showRecoveryInput"
                            autocomplete="one-time-code"
                            x-model="recovery_code"
                            placeholder="XXXXX-XXXXX"
                            class="input-field @error('recovery_code') border-red-500 focus:border-red-500 focus:ring-red-500/20 @enderror"
                        />
                    </div>
                    @error('recovery_code')
                        <p class="text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full py-3">
                    {{ __('Continue') }}
                </button>

                <div class="text-center text-sm text-gray-500">
                    <span class="opacity-75">{{ __('or you can') }}</span>
                    <button type="button" @click="toggleInput()" class="text-secondary font-medium hover:underline ml-1">
                        <span x-show="!showRecoveryInput">{{ __('use a recovery code') }}</span>
                        <span x-show="showRecoveryInput">{{ __('use an authentication code') }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts::auth>
