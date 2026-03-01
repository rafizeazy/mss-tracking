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

    <div class="boron-card">
        <div class="boron-card-body">
            <div class="flex items-start max-md:flex-col">
                <div class="me-10 w-full pb-4 md:w-[220px]">
                    <flux:navlist aria-label="{{ __('Settings') }}">
                        <flux:navlist.item :href="route('profile.edit')" wire:navigate>{{ __('Profile') }}</flux:navlist.item>
                        <flux:navlist.item :href="route('user-password.edit')" wire:navigate>{{ __('Password') }}</flux:navlist.item>
                        @if (Laravel\Fortify\Features::canManageTwoFactorAuthentication())
                            <flux:navlist.item :href="route('two-factor.show')" wire:navigate>{{ __('Two-factor auth') }}</flux:navlist.item>
                        @endif
                        <flux:navlist.item :href="route('appearance.edit')" wire:navigate>{{ __('Appearance') }}</flux:navlist.item>
                    </flux:navlist>
                </div>

                <flux:separator class="md:hidden" />

                <div class="flex-1 self-stretch max-md:pt-6">
                    <flux:heading>{{ $heading ?? '' }}</flux:heading>
                    <flux:subheading>{{ $subheading ?? '' }}</flux:subheading>

                    <div class="mt-5 w-full max-w-lg">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
