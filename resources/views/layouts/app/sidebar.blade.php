<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="boron-body min-h-screen font-sans antialiased overflow-x-hidden"
        x-data="{ 
            sidebarMobileOpen: false, 
            sidebarHovered: false,
            sidebarPinned: localStorage.getItem('sidebarPinned') === 'true',
            toggleSidebar() {
                if (window.innerWidth >= 1024) {
                    this.sidebarPinned = !this.sidebarPinned;
                    localStorage.setItem('sidebarPinned', this.sidebarPinned);
                    
                    setTimeout(() => { window.dispatchEvent(new Event('resize')); }, 310);
                } else {
                    this.sidebarMobileOpen = !this.sidebarMobileOpen;
                }
            }
        }"
        @toggle-sidebar.window="toggleSidebar()"
    >
        <div class="flex min-h-screen w-full">
            <aside
                class="boron-sidebar boron-scrollbar fixed inset-y-0 left-0 z-40 flex flex-col overflow-y-auto overflow-x-hidden transition-all duration-300"
                :class="{
                    '-translate-x-full lg:translate-x-0': !sidebarMobileOpen,
                    'translate-x-0': sidebarMobileOpen,
                    'sidebar-expanded': sidebarHovered || sidebarPinned,
                    'sidebar-collapsed': !sidebarHovered && !sidebarPinned
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

                    @else
                        <div class="side-nav-title"><span class="sidebar-label">{{ __('Main') }}</span></div>
                        <a href="{{ route('dashboard') }}" wire:navigate
                            class="side-nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                            title="{{ __('Dashboard') }}"
                        >
                            <span class="sidebar-icon-center shrink-0 flex items-center justify-center"><i class="ti ti-dashboard text-lg"></i></span>
                            <span class="sidebar-label whitespace-nowrap">{{ __('Dashboard') }}</span>
                        </a>

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

                        @if (auth()->user()->role === \App\Enums\Role::Finance || auth()->user()->isSuperAdmin())
                            <div class="side-nav-title"><span class="sidebar-label">{{ __('Provisioning & Billing') }}</span></div>

                            <a href="{{ route('finance.tracking.index') }}" wire:navigate
                                class="side-nav-link {{ request()->routeIs('finance.tracking.*') ? 'active' : '' }}"
                                title="{{ __('Tracking Registrasi') }}"
                            >
                                <span class="sidebar-icon-center shrink-0 flex items-center justify-center">
                                    <i class="ti ti-file-invoice text-lg"></i>
                                </span>
                                <span class="sidebar-label whitespace-nowrap">{{ __('Tracking Registrasi') }}</span>
                            </a>
                        @endif

                        @if (auth()->user()->role === \App\Enums\Role::Noc || auth()->user()->isSuperAdmin())
                            <div class="side-nav-title"><span class="sidebar-label">{{ __('Network Operations') }}</span></div>

                            <a href="{{ route('noc.tracking.index') }}" wire:navigate
                                class="side-nav-link {{ request()->routeIs('noc.tracking.*') ? 'active' : '' }}"
                                title="{{ __('Tracking Registrasi') }}"
                            >
                                <span class="sidebar-icon-center shrink-0 flex items-center justify-center">
                                    <i class="ti ti-router text-lg"></i>
                                </span>
                                <span class="sidebar-label whitespace-nowrap">{{ __('Tracking Registrasi') }}</span>
                            </a>
                        @endif

                        <div class="side-nav-title"><span class="sidebar-label">{{ __('Customers') }}</span></div>
                        
                        @php
                            $dataPelangganRoute = '#';
                            if (auth()->user()->role === \App\Enums\Role::Marketing) $dataPelangganRoute = route('marketing.datapelanggan.index');
                            elseif (auth()->user()->role === \App\Enums\Role::Finance) $dataPelangganRoute = route('finance.datapelanggan.index');
                            elseif (auth()->user()->role === \App\Enums\Role::Noc) $dataPelangganRoute = route('noc.datapelanggan.index');
                            elseif (auth()->user()->isSuperAdmin()) $dataPelangganRoute = route('marketing.datapelanggan.index');
                        @endphp

                        <a href="{{ $dataPelangganRoute }}" wire:navigate
                            class="side-nav-link {{ request()->routeIs('*.datapelanggan.index') ? 'active' : '' }}"
                            title="{{ __('Data Pelanggan') }}"
                        >
                            <span class="sidebar-icon-center shrink-0 flex items-center justify-center">
                                <i class="ti ti-users-group text-lg"></i>
                            </span>
                            <span class="sidebar-label whitespace-nowrap">{{ __('Data Pelanggan') }}</span>
                        </a>

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

            <div class="flex min-h-screen w-full flex-1 flex-col transition-all duration-300 min-w-0" :class="sidebarPinned ? 'lg:ml-[250px]' : 'lg:ml-[70px]'">
                <header class="boron-topbar sticky top-0 z-30 flex items-center gap-4 px-4 sm:px-6">
                    
                    <button @click="$dispatch('toggle-sidebar')" class="cursor-pointer flex h-[38px] w-[42px] shrink-0 items-center justify-center rounded-[0.3rem] border border-[#dee2e6] bg-transparent text-[#313a46] hover:bg-[#f6f7fb] dark:border-[#37394d] dark:text-[#aab8c5] dark:hover:bg-white/5" data-test="sidebar-toggle">
                        <i class="ti ti-menu-2 text-lg"></i>
                    </button>

                    <div class="hidden flex-1 sm:block sm:max-w-xs" x-data>
                        <div class="relative">
                            <i class="ti ti-search absolute left-3 top-1/2 -translate-y-1/2 text-[#a1a9b1]"></i>
                            <input type="text" 
                                @input.debounce.500ms="$dispatch('trigger-search', { query: $event.target.value })"
                                placeholder="Cari di halaman ini..."
                                class="w-full rounded-[0.3rem] border border-[#dee2e6] bg-transparent py-2 pl-9 pr-4 text-sm placeholder:text-[#a1a9b1] focus:outline-none focus:ring-2 focus:ring-[#669776]/30 dark:border-[#37394d] dark:text-white"
                            >
                        </div>
                    </div>

                    <div class="flex flex-1 items-center justify-end gap-2">
                        
                        <livewire:notification-bell />

                        <button x-data @click="$flux.appearance = $flux.appearance === 'dark' ? 'light' : 'dark'" class="boron-topbar-btn" title="Toggle dark mode">
                            <template x-if="$flux.appearance !== 'dark'">
                                <i class="ti ti-moon text-lg"></i>
                            </template>
                            <template x-if="$flux.appearance === 'dark'">
                                <i class="ti ti-sun text-lg"></i>
                            </template>
                        </button>

                        <div class="relative ml-1" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-2 rounded-[0.3rem] border border-[#dee2e6] bg-white px-3 py-1.5 text-sm transition-all hover:bg-[#f6f7fb] dark:border-[#37394d] dark:bg-[#1e1f27] dark:hover:bg-[#252630]" data-test="sidebar-menu-button">
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
                                class="absolute right-0 mt-2 w-52 origin-top-right rounded-[0.3rem] border border-[#dee2e6] bg-white py-1 shadow-lg dark:border-[#37394d] dark:bg-[#1e1f27]"
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

                <div class="flex-1 px-4 sm:px-6 w-full max-w-full overflow-x-hidden">
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

        <div
            x-data="{
                toast: null,
                timer: null,
                show(detail) {
                    clearTimeout(this.timer);
                    this.toast = detail;
                    this.timer = setTimeout(() => { this.toast = null; }, detail.duration ?? 4000);
                },
                close() { clearTimeout(this.timer); this.toast = null; }
            }"
            @toast.window="show($event.detail)"
            x-cloak
        >
            <div
                x-show="toast !== null"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
                class="fixed inset-0 z-[9990] bg-black/40 backdrop-blur-sm"
                @click="close()"
            ></div>

            <div
                x-show="toast !== null"
                x-transition:enter="transition ease-out duration-250"
                x-transition:enter-start="opacity-0 scale-90"
                x-transition:enter-end="opacity-100 scale-100"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                class="fixed inset-0 z-[9991] flex items-center justify-center pointer-events-none"
                aria-live="polite"
            >
                <div class="pointer-events-auto mx-4 w-full max-w-sm rounded-xl bg-white shadow-2xl dark:bg-[#1e1e2a] overflow-hidden">

                    <div
                        :class="{
                            'bg-[#70bb63]': toast?.type === 'success',
                            'bg-[#ed6060]': toast?.type === 'error',
                            'bg-[#60addf]': toast?.type === 'info',
                            'bg-[#ebb751]': toast?.type === 'warning',
                        }"
                        class="h-1.5 w-full"
                    ></div>

                    <div class="p-6">
                        <div class="flex items-start justify-between gap-3 mb-4">
                            <div
                                :class="{
                                    'bg-[#70bb63]/10 text-[#70bb63]': toast?.type === 'success',
                                    'bg-[#ed6060]/10 text-[#ed6060]': toast?.type === 'error',
                                    'bg-[#60addf]/10 text-[#60addf]': toast?.type === 'info',
                                    'bg-[#ebb751]/10 text-[#ebb751]': toast?.type === 'warning',
                                }"
                                class="flex size-12 shrink-0 items-center justify-center rounded-full text-2xl"
                            >
                                <template x-if="toast?.type === 'success'"><i class="ti ti-circle-check"></i></template>
                                <template x-if="toast?.type === 'error'"><i class="ti ti-circle-x"></i></template>
                                <template x-if="toast?.type === 'info'"><i class="ti ti-info-circle"></i></template>
                                <template x-if="toast?.type === 'warning'"><i class="ti ti-alert-triangle"></i></template>
                            </div>
                            <button @click="close()" class="text-[#a1a9b1] hover:text-[#313a46] dark:hover:text-white transition-colors mt-0.5">
                                <i class="ti ti-x text-lg"></i>
                            </button>
                        </div>

                        <p x-show="toast?.title" x-text="toast?.title" class="text-base font-bold text-[#313a46] dark:text-white mb-1"></p>
                        <p x-text="toast?.message" class="text-sm text-[#4c4c5c] dark:text-[#aab8c5] leading-relaxed"></p>

                        <button
                            @click="close()"
                            :class="{
                                'bg-[#70bb63] hover:bg-[#5da855] shadow-[#70bb63]/30': toast?.type === 'success',
                                'bg-[#ed6060] hover:bg-[#d95454] shadow-[#ed6060]/30': toast?.type === 'error',
                                'bg-[#60addf] hover:bg-[#4d9acc] shadow-[#60addf]/30': toast?.type === 'info',
                                'bg-[#ebb751] hover:bg-[#d4a448] shadow-[#ebb751]/30': toast?.type === 'warning',
                            }"
                            class="mt-5 w-full rounded-lg py-2.5 text-sm font-semibold text-white shadow-md transition-colors"
                        >
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div
            x-data="{
                show: false,
                message: '',
                confirmText: 'Ya, Lanjutkan',
                cancelText: 'Batal',
                resolve: null,
                open(detail) {
                    this.message     = detail.message ?? 'Apakah Anda yakin?';
                    this.confirmText = detail.confirmText ?? 'Ya, Lanjutkan';
                    this.cancelText  = detail.cancelText  ?? 'Batal';
                    this.show        = true;
                    return new Promise(res => { this.resolve = res; });
                },
                confirm() { this.show = false; this.resolve && this.resolve(true); },
                cancel()  { this.show = false; this.resolve && this.resolve(false); },
            }"
            @show-confirm.window="open($event.detail).then(ok => ok && $dispatch('confirmed-' + $event.detail.key))"
            x-cloak
        >
            <div
                x-show="show"
                class="fixed inset-0 z-[9998] flex items-center justify-center bg-black/50 backdrop-blur-sm px-4"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0"
                x-transition:enter-end="opacity-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100"
                x-transition:leave-end="opacity-0"
            >
                <div
                    class="w-full max-w-sm rounded-[0.5rem] bg-white p-6 shadow-2xl dark:bg-[#1e1e2a]"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-90"
                    x-transition:enter-end="opacity-100 scale-100"
                    @click.stop
                >
                    <div class="mb-4 flex items-center gap-3">
                        <div class="flex size-10 shrink-0 items-center justify-center rounded-full bg-[#ebb751]/10">
                            <i class="ti ti-alert-triangle text-xl text-[#ebb751]"></i>
                        </div>
                        <h5 class="font-semibold text-[#313a46] dark:text-white">Konfirmasi Aksi</h5>
                    </div>
                    <p x-text="message" class="mb-6 text-sm leading-relaxed text-[#4c4c5c] dark:text-[#aab8c5]"></p>
                    <div class="flex flex-col-reverse sm:flex-row justify-end gap-3">
                        <button @click="cancel()" x-text="cancelText" class="w-full sm:w-auto btn-boron border border-[#dee2e6] px-4 py-2 text-sm text-[#313a46] hover:bg-[#f6f7fb] dark:border-[#37394d] dark:text-white dark:hover:bg-white/5"></button>
                        <button @click="confirm()" x-text="confirmText" class="w-full sm:w-auto btn-boron btn-boron-primary px-4 py-2 text-sm shadow-md shadow-[#669776]/30"></button>
                    </div>
                </div>
            </div>
        </div>

        @fluxScripts
        <script>
            document.addEventListener('livewire:initialized', () => {
                Livewire.on('notify', (event) => {
                    let data = event[0] || event;
                    
                    window.dispatchEvent(new CustomEvent('toast', {
                        detail: {
                            type: data.type || 'success',
                            title: data.type === 'error' ? 'Gagal' : 'Berhasil',
                            message: data.message,
                            duration: 5000
                        }
                    }));
                });
            });

            @if(session('success'))
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { type: 'success', title: 'Berhasil', message: "{{ session('success') }}", duration: 5000 }
                }));
            @endif
            @if(session('error'))
                window.dispatchEvent(new CustomEvent('toast', {
                    detail: { type: 'error', title: 'Gagal', message: "{{ session('error') }}", duration: 5000 }
                }));
            @endif
        </script>
    </body>
</html>