<x-layouts::auth :title="__('Log in')">
    <h4 class="mb-2 text-lg font-semibold text-[#313a46] dark:text-white">{{ __('Masuk Akun') }}</h4>
    <p class="mb-6 text-sm text-[#8a969c]">{{ __('Masukkan alamat email dan kata sandi Anda untuk masuk') }}</p>

    <x-auth-session-status class="mb-4 text-center" :status="session('status')" />

    <form method="POST" action="{{ route('login.store') }}" class="mb-4 text-start">
        @csrf

        <div class="mb-3">
            <flux:input
                name="email"
                :label="__('Email')"
                :value="old('email')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="Masukkan alamat email"
            />
        </div>

        <div class="mb-3">
            <flux:input
                name="password"
                :label="__('Sandi')"
                type="password"
                required
                autocomplete="current-password"
                placeholder="masukkan password"
                viewable
            />
        </div>

        <div class="mb-4 flex items-center justify-between">
            <flux:checkbox name="remember" :label="__('Ingatkan Saya')" :checked="old('remember')" />

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="border-b border-dashed border-[#8a969c] text-sm text-[#8a969c] hover:text-[#313a46] dark:hover:text-white">
                    {{ __('Lupa Sandi') }}
                </a>
            @endif
        </div>

        <button type="submit" class="btn-boron btn-boron-primary w-full py-2.5" data-test="login-button">
            {{ __('Login') }}
        </button>
    </form>
</x-layouts::auth>
