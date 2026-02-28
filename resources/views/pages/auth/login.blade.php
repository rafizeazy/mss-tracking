<x-layouts::auth :title="__('Log in')">
    <div class="space-y-8">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-6 h-px bg-amber-500/60"></div>
                <span class="text-[11px] font-medium tracking-[0.15em] uppercase text-amber-500/70">{{ __('Welcome back') }}</span>
            </div>
            <h2 class="text-2xl font-semibold tracking-tight text-white">{{ __('Sign in to your account') }}</h2>
            <p class="mt-2 text-sm text-neutral-500">{{ __('Enter your credentials to continue') }}</p>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
            @csrf

            <flux:input
                name="email"
                :label="__('Email')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="you@company.com"
            />

            <div class="relative">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />

                @if (Route::has('password.request'))
                    <flux:link class="absolute top-0 text-sm end-0" :href="route('password.request')" wire:navigate>
                        {{ __('Forgot?') }}
                    </flux:link>
                @endif
            </div>

            <flux:checkbox name="remember" :label="__('Keep me signed in')" :checked="old('remember')" />

            <div class="pt-3">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('Continue') }}
                </flux:button>
            </div>
        </form>

        @if (Route::has('register'))
            <div class="pt-4 border-t border-neutral-800/50">
                <p class="text-sm text-center text-neutral-500">
                    {{ __('New here?') }}
                    <flux:link :href="route('register')" wire:navigate>{{ __('Create an account') }}</flux:link>
                </p>
            </div>
        @endif
    </div>
</x-layouts::auth>
