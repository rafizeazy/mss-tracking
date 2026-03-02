<div class="py-6">
    {{-- Page Title --}}
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h4 class="text-lg font-semibold text-[#313a46] dark:text-white">{{ __('Settings') }}</h4>
            <p class="mt-0.5 text-sm text-[#8a969c]">{{ __('Manage your account settings') }}</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-[#8a969c]">
            <i class="ti ti-home text-base"></i>
            <span>/</span>
            <span class="font-medium text-[#313a46] dark:text-white">{{ __('Settings') }}</span>
        </div>
    </div>

    <div class="flex gap-6 max-md:flex-col">
        {{-- Settings Nav Card --}}
        <div class="boron-card h-fit w-full md:w-[240px] md:shrink-0">
            <div class="boron-card-body !py-3 !px-3">
                <nav class="flex flex-col gap-0.5">
                    <a href="{{ route('profile.edit') }}" wire:navigate
                        class="settings-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="ti ti-user text-base"></i>
                        {{ __('Profile') }}
                    </a>
                    <a href="{{ route('user-password.edit') }}" wire:navigate
                        class="settings-nav-link {{ request()->routeIs('user-password.*') ? 'active' : '' }}">
                        <i class="ti ti-lock text-base"></i>
                        {{ __('Password') }}
                    </a>
                    @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                        <a href="{{ route('two-factor.show') }}" wire:navigate
                            class="settings-nav-link {{ request()->routeIs('two-factor.*') ? 'active' : '' }}">
                            <i class="ti ti-shield-lock text-base"></i>
                            {{ __('Two-factor auth') }}
                        </a>
                    @endif
                    <a href="{{ route('appearance.edit') }}" wire:navigate
                        class="settings-nav-link {{ request()->routeIs('appearance.*') ? 'active' : '' }}">
                        <i class="ti ti-palette text-base"></i>
                        {{ __('Appearance') }}
                    </a>
                </nav>
            </div>
        </div>

        {{-- Settings Content Card --}}
        <div class="boron-card flex-1">
            <div class="boron-card-header">
                <h5 class="font-semibold text-[#313a46] dark:text-white">{{ $heading ?? '' }}</h5>
            </div>
            <div class="boron-card-body">
                <p class="mb-4 text-sm text-[#8a969c]">{{ $subheading ?? '' }}</p>
                <div class="w-full max-w-lg">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </div>
</div>
