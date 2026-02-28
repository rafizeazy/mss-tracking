<x-layouts::auth :title="__('Register')">
    <div class="space-y-8">
        <div>
            <div class="flex items-center gap-3 mb-4">
                <div class="w-6 h-px bg-amber-500/60"></div>
                <span class="text-[11px] font-medium tracking-[0.15em] uppercase text-amber-500/70">{{ __('Get started') }}</span>
            </div>
            <h2 class="text-2xl font-semibold tracking-tight text-white">{{ __('Create your account') }}</h2>
            <p class="mt-2 text-sm text-neutral-500">{{ __('Just a few details to get you going') }}</p>
        </div>

        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
            @csrf

            <flux:input
                name="name"
                :label="__('Full name')"
                :value="old('name')"
                type="text"
                required
                autofocus
                autocomplete="name"
                :placeholder="__('Jane Smith')"
            />

            <flux:input
                name="email"
                :label="__('Email')"
                :value="old('email')"
                type="email"
                required
                autocomplete="email"
                placeholder="you@company.com"
            />

            <div class="grid gap-5 sm:grid-cols-2">
                <flux:input
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Password')"
                    viewable
                />

                <flux:input
                    name="password_confirmation"
                    :label="__('Confirm')"
                    type="password"
                    required
                    autocomplete="new-password"
                    :placeholder="__('Confirm')"
                    viewable
                />
            </div>

            <div class="pt-3">
                <flux:button type="submit" variant="primary" class="w-full" data-test="register-user-button">
                    {{ __('Create account') }}
                </flux:button>
            </div>
        </form>

        <div class="pt-4 border-t border-neutral-800/50">
            <p class="text-sm text-center text-neutral-500">
                {{ __('Already have an account?') }}
                <flux:link :href="route('login')" wire:navigate>{{ __('Sign in') }}</flux:link>
            </p>
        </div>
    </div>
</x-layouts::auth>
