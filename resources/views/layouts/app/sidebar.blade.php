<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="boron-body min-h-screen font-sans antialiased"
        x-data="{ sidebarMobileOpen: false, sidebarHovered: false }"
    >
        <div class="flex min-h-screen">
            <aside
                class="boron-sidebar boron-scrollbar fixed inset-y-0 left-0 z-40 flex flex-col overflow-y-auto overflow-x-hidden sidebar-collapsed"
                :class="{
                    '-translate-x-full lg:translate-x-0': !sidebarMobileOpen,
                    'translate-x-0': sidebarMobileOpen,
                    'sidebar-expanded': sidebarHovered,
                    'sidebar-collapsed': !sidebarHovered
                }"
                @mouseenter="sidebarHovered = true"
                @mouseleave="sidebarHovered = false"
            >
                <div class="flex h-[70px] items-center border-b border-[#343a40] px-0 dark:border-[#37394d] sidebar-logo">
                    <a href="{{ auth()->user()->role === \App\Enums\Role::Customer ? route('customer.dashboard') : route('dashboard') }}" class="flex items-center gap-2.5 w-full" wire:navigate>
                        <span class="sidebar-icon-center shrink-0 flex items-center justify-center">
                            <x-app-logo-icon class="size-5 fill-current text-white" />
                        </span>
                        <span class="text-base font-semibold text-white sidebar-label whitespace-nowrap">{{ config('app.name', 'MSS') }}</span>
                    </a>
                    <button @click="sidebarMobileOpen = false" class="ml-auto p-1 text-[#8a969c] hover:text-white lg:hidden">
                        <i class="ti ti-x text-lg"></i>
                    </button>
                </div>


                <nav class="flex-1 py-2">
                    @if (auth()->user()->role === \App\Enums\Role::Customer)
                        <div class="side-nav-title"><span class="sidebar-label">{{ __('Main') }}</span></div>
                        <a href="{{ route('customer.dashboard') }}" wire:navigate
                            class="side-nav-link {{ request()->routeIs('customer.dashboard') ? 'active' : '' }}"
                            title="{{ __('Dashboard') }}"
                        >
                            <span class="sidebar-icon-center shrink-0 flex items-center justify-center"><i class="ti ti-dashboard text-lg"></i></span>
                            <span class="sidebar-label whitespace-nowrap">{{ __('Dashboard') }}</span>
                        </a>

                        <div class="side-nav-title"><span class="sidebar-label">{{ __('Billing') }}</span></div>
                        <a href="#" wire:navigate
                            class="side-nav-link"
                            title="{{ __('Tagihan Saya') }}"
                        >
                            <span class="sidebar-icon-center shrink-0 flex items-center justify-center"><i class="ti ti-receipt text-lg"></i></span>
                            <span class="sidebar-label whitespace-nowrap">{{ __('Tagihan Saya') }}</span>
                        </a>

                    @else
                        <div class="side-nav-title"><span class="sidebar-label">{{ __('Main') }}</span></div>
                        <a href="{{ route('dashboard') }}" wire:navigate
                            class="side-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            title="{{ __('Dashboard') }}"
                        >
                            <span class="sidebar-icon-center shrink-0 flex items-center justify-center"><i class="ti ti-dashboard text-lg"></i></span>
                            <span class="sidebar-label whitespace-nowrap">{{ __('Dashboard') }}</span>
                        </a>

                        {{-- Menu Khusus Marketing & Super Admin --}}
                        @if (auth()->user()->role === \App\Enums\Role::Marketing || auth()->user()->isSuperAdmin())
                            <div class="side-nav-title"><span class="sidebar-label">{{ __('Sales & Marketing') }}</span></div>

                            <a href="{{ route('marketing.tracking.index') }}" wire:navigate
                                class="side-nav-link {{ request()->routeIs('marketing.tracking.*') ? 'active' : '' }}"
                                title="{{ __('Tracking Registrasi') }}"
                            >
                                <span class="sidebar-icon-center shrink-0 flex items-center justify-center">
                                    <i class="ti ti-radar text-lg"></i>
                                </span>
                                <span class="sidebar-label whitespace-nowrap">{{ __('Tracking Registrasi') }}</span>
                            </a>
                        @endif

                        <div class="side-nav-title"><span class="sidebar-label">{{ __('Customers') }}</span></div>
                        <a href="{{ route('customers.index') }}" wire:navigate
                            class="side-nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}"
                            title="{{ __('Data Pelanggan') }}"
                        >
                            <span class="sidebar-icon-center shrink-0 flex items-center justify-center">
                                <i class="ti ti-users-group text-lg"></i>
                            </span>
                            <span class="sidebar-label whitespace-nowrap">{{ __('Data Pelanggan') }}</span>
                        </a>


                        @if (auth()->user()->role === \App\Enums\Role::Finance)
                            <div class="side-nav-title"><span class="sidebar-label">{{ __('Provisioning & Billing') }}</span></div>

                            <a href="{{ route('finance.tracking') }}" wire:navigate
                                class="side-nav-link {{ request()->routeIs('finance.tracking') ? 'active' : '' }}"
                                title="{{ __('Provisioning Tracking') }}"
                            >
                                <span class="sidebar-icon-center shrink-0 flex items-center justify-center">
                                    <i class="ti ti-track text-lg"></i>
                                </span>
                                <span class="sidebar-label whitespace-nowrap">{{ __('Tracking') }}</span>
                            </a>
                        @endif

                        @if (auth()->user()->isSuperAdmin())
                            <div class="side-nav-title"><span class="sidebar-label">{{ __('Administration') }}</span></div>

                            <a href="{{ route('users.index') }}" wire:navigate
                                class="side-nav-link {{ request()->routeIs('users.*') ? 'active' : '' }}"
                                title="{{ __('User Management') }}"
                            >
                                <span class="sidebar-icon-center shrink-0 flex items-center justify-center"><i class="ti ti-users text-lg"></i></span>
                                <span class="sidebar-label whitespace-nowrap">{{ __('User Management') }}</span>
                            </a>
                        @endif

                    @endif

                    

                    <div class="side-nav-title"><span class="sidebar-label">{{ __('Account') }}</span></div>
                    <a href="{{ route('profile.edit') }}" wire:navigate
                        class="side-nav-link {{ request()->routeIs('profile.*') ? 'active' : '' }}"
                        title="{{ __('Settings') }}"
                    >
                        <span class="sidebar-icon-center shrink-0 flex items-center justify-center"><i class="ti ti-settings text-lg"></i></span>
                        <span class="sidebar-label whitespace-nowrap">{{ __('Settings') }}</span>
                    </a>
                </nav>

                <div class="border-t border-[#343a40] p-4 dark:border-[#37394d]">
                    <div class="flex items-center gap-3">
                        <span class="sidebar-icon-center shrink-0 flex size-8 items-center justify-center rounded-full bg-[#669776]/20 text-xs font-bold text-[#669776]">
                            {{ auth()->user()->initials() }}
                        </span>
                        <div class="flex-1 truncate sidebar-label">
                            <p class="truncate text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                            <p class="truncate text-[11px] text-[#8a969c]">{{ auth()->user()->role->label() }}</p>
                        </div>
                    </div>
                </div>
            </aside>

            <div class="flex min-h-screen flex-1 flex-col transition-all duration-200 lg:ml-[70px]">
                <header class="boron-topbar sticky top-0 z-30 flex items-center gap-4 px-4 sm:px-6">
                    <button @click="sidebarMobileOpen = !sidebarMobileOpen" class="boron-topbar-btn lg:hidden" data-test="sidebar-toggle">
                        <i class="ti ti-menu-2 text-lg"></i>
                    </button>

                    <div class="hidden flex-1 sm:block sm:max-w-xs">
                        <div class="relative">
                            <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-[#a1a9b1]"></i>
                            <input type="text" placeholder="Search something..."
                                class="w-full rounded-[0.3rem] border border-[#343a40] bg-transparent py-2 pl-9 pr-4 text-sm placeholder:text-[#a1a9b1] focus:outline-none focus:ring-2 focus:ring-[#669776]/30 dark:border-[#37394d]"
                            >
                        </div>
                    </div>

                    <div class="flex flex-1 items-center justify-end gap-2">
                        <button class="boron-topbar-btn relative">
                            <i class="ti ti-bell animate-ring-bell text-lg"></i>
                            <span class="absolute -right-0.5 -top-0.5 flex size-2"><span class="absolute inline-flex size-full rounded-full bg-[#ed6060]"></span></span>
                        </button>

                        <button x-data @click="$flux.appearance = $flux.appearance === 'dark' ? 'light' : 'dark'" class="boron-topbar-btn" title="Toggle dark mode">
                            <template x-if="$flux.appearance !== 'dark'">
                                <i class="ti ti-moon text-lg"></i>
                            </template>
                            <template x-if="$flux.appearance === 'dark'">
                                <i class="ti ti-sun text-lg"></i>
                            </template>
                        </button>

                        <div class="relative ml-1" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 rounded-[0.3rem] border border-[#343a40] bg-white px-3 py-1.5 text-sm transition-all hover:bg-[#f6f7fb] dark:border-[#37394d] dark:bg-[#1e1f27] dark:hover:bg-[#252630]" data-test="sidebar-menu-button">
                                <span class="flex size-7 items-center justify-center rounded-full bg-[#669776]/20 text-xs font-bold text-[#669776]">
                                    {{ auth()->user()->initials() }}
                                </span>
                                <span class="hidden font-medium sm:inline dark:text-[#aab8c5]">{{ Str::words(auth()->user()->name, 2, '') }}</span>
                                <i class="ti ti-chevron-down text-xs text-[#a1a9b1]" :class="open ? 'rotate-180' : ''" style="transition: transform 0.2s;"></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                x-transition:leave="transition ease-in duration-75"
                                x-transition:leave-start="opacity-100 scale-100"
                                x-transition:leave-end="opacity-0 scale-95"
                                x-cloak
                                class="absolute right-0 mt-2 w-52 origin-top-right rounded-[0.3rem] border border-[#343a40] bg-white py-1 shadow-lg dark:border-[#37394d] dark:bg-[#1e1f27]"
                                style="box-shadow: 5px 7px 0 #6c757d;"
                            >
                                <div class="border-b border-dashed border-[#e7e9eb] px-4 py-3 dark:border-[#37394d]">
                                    <p class="text-sm font-semibold text-[#313a46] dark:text-white">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-[#8a969c]">{{ auth()->user()->email }}</p>
                                </div>

                                <a href="{{ route('profile.edit') }}" wire:navigate class="flex items-center gap-2 px-4 py-2 text-sm text-[#4c4c5c] hover:bg-[#f6f7fb] dark:text-[#aab8c5] dark:hover:bg-white/5">
                                    <i class="ti ti-settings text-base"></i>
                                    {{ __('Settings') }}
                                </a>

                                <div class="border-t border-dashed border-[#e7e9eb] dark:border-[#37394d]">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-sm text-[#ed6060] hover:bg-[#ed6060]/5" data-test="logout-button">
                                            <i class="ti ti-logout text-base"></i>
                                            {{ __('Sign Out') }}
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </header>

                <div class="flex-1 px-4 sm:px-6">
                    {{ $slot }}
                </div>

                <footer class="boron-footer">
                    &copy; {{ date('Y') }} {{ config('app.name') }} — By <span class="font-bold uppercase">MSS</span>
                </footer>
            </div>
        </div>

        <div x-show="sidebarMobileOpen" @click="sidebarMobileOpen = false"
            class="fixed inset-0 z-30 bg-black/40 lg:hidden"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            x-cloak
        ></div>

        @fluxScripts
    </body>
</html>