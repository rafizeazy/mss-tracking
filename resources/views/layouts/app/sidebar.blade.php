<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark"
    x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
    x-init="$watch('darkMode', val => { localStorage.setItem('darkMode', val); val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark') }); if(darkMode) document.documentElement.classList.add('dark'); else document.documentElement.classList.remove('dark');"
    :class="{ 'dark': darkMode }"
>
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen font-sans antialiased bg-[#f4f5f7] text-gray-800 dark:bg-[#0f0f1a] dark:text-gray-200"
        x-data="{ sidebarOpen: window.innerWidth >= 1024, userDropdownOpen: false }"
        @resize.window="sidebarOpen = window.innerWidth >= 1024"
    >
        <aside
            class="admin-sidebar fixed inset-y-0 left-0 z-40 flex w-64 flex-col transition-transform duration-200"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
        >
            <div class="flex h-16 items-center gap-3 px-5">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3" wire:navigate>
                    <span class="flex size-9 items-center justify-center rounded-lg bg-[#4ecca3]/15">
                        <x-app-logo-icon class="size-5 fill-current text-[#4ecca3]" />
                    </span>
                    <span class="text-base font-bold tracking-tight text-white">{{ config('app.name', 'MSS') }}</span>
                </a>
                <button @click="sidebarOpen = false" class="ml-auto rounded-md p-1 text-[#c5c5d2] hover:text-white lg:hidden">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <nav class="mt-4 flex-1 space-y-1 overflow-y-auto px-3 scrollbar-thin">
                <p class="mb-2 px-3 text-[10px] font-semibold uppercase tracking-[0.15em] text-[#6b6b80]">{{ __('Platform') }}</p>

                <a href="{{ route('dashboard') }}" wire:navigate
                    class="sidebar-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('dashboard') ? 'active bg-[#4ecca3]/10 text-white' : 'text-[#c5c5d2] hover:bg-white/5 hover:text-white' }}"
                >
                    <svg class="size-[18px] shrink-0 {{ request()->routeIs('dashboard') ? 'text-[#4ecca3]' : 'text-[#6b6b80] group-hover:text-[#4ecca3]' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6A2.25 2.25 0 016 3.75h2.25A2.25 2.25 0 0110.5 6v2.25a2.25 2.25 0 01-2.25 2.25H6a2.25 2.25 0 01-2.25-2.25V6zM3.75 15.75A2.25 2.25 0 016 13.5h2.25a2.25 2.25 0 012.25 2.25V18a2.25 2.25 0 01-2.25 2.25H6A2.25 2.25 0 013.75 18v-2.25zM13.5 6a2.25 2.25 0 012.25-2.25H18A2.25 2.25 0 0120.25 6v2.25A2.25 2.25 0 0118 10.5h-2.25a2.25 2.25 0 01-2.25-2.25V6zM13.5 15.75a2.25 2.25 0 012.25-2.25H18a2.25 2.25 0 012.25 2.25V18A2.25 2.25 0 0118 20.25h-2.25a2.25 2.25 0 01-2.25-2.25v-2.25z"/></svg>
                    {{ __('Dashboard') }}
                    @if(request()->routeIs('dashboard'))
                        <span class="ml-auto h-1.5 w-1.5 rounded-full bg-[#4ecca3]"></span>
                    @endif
                </a>

                @if (auth()->user()->isSuperAdmin())
                    <p class="mb-2 mt-6 px-3 text-[10px] font-semibold uppercase tracking-[0.15em] text-[#6b6b80]">{{ __('Administration') }}</p>

                    <a href="{{ route('users.index') }}" wire:navigate
                        class="sidebar-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('users.*') ? 'active bg-[#4ecca3]/10 text-white' : 'text-[#c5c5d2] hover:bg-white/5 hover:text-white' }}"
                    >
                        <svg class="size-[18px] shrink-0 {{ request()->routeIs('users.*') ? 'text-[#4ecca3]' : 'text-[#6b6b80] group-hover:text-[#4ecca3]' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"/></svg>
                        {{ __('User Management') }}
                        @if(request()->routeIs('users.*'))
                            <span class="ml-auto h-1.5 w-1.5 rounded-full bg-[#4ecca3]"></span>
                        @endif
                    </a>
                @endif

                <p class="mb-2 mt-6 px-3 text-[10px] font-semibold uppercase tracking-[0.15em] text-[#6b6b80]">{{ __('Account') }}</p>

                <a href="{{ route('profile.edit') }}" wire:navigate
                    class="sidebar-item group flex items-center gap-3 rounded-lg px-3 py-2.5 text-sm font-medium transition-all duration-150 {{ request()->routeIs('profile.*') ? 'active bg-[#4ecca3]/10 text-white' : 'text-[#c5c5d2] hover:bg-white/5 hover:text-white' }}"
                >
                    <svg class="size-[18px] shrink-0 {{ request()->routeIs('profile.*') ? 'text-[#4ecca3]' : 'text-[#6b6b80] group-hover:text-[#4ecca3]' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    {{ __('Settings') }}
                </a>
            </nav>

            <div class="border-t border-white/10 p-3">
                <div class="flex items-center gap-3 rounded-lg px-3 py-2.5">
                    <div class="flex size-9 items-center justify-center rounded-full bg-[#4ecca3]/20 text-sm font-bold text-[#4ecca3]">
                        {{ auth()->user()->initials() }}
                    </div>
                    <div class="flex-1 truncate">
                        <p class="truncate text-sm font-medium text-white">{{ auth()->user()->name }}</p>
                        <p class="truncate text-xs text-[#6b6b80]">{{ auth()->user()->role->label() }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div class="transition-all duration-200 lg:ml-64" :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-0'">
            <header class="admin-topbar sticky top-0 z-30 flex h-16 items-center gap-4 border-b px-4 sm:px-6 bg-white/80 backdrop-blur-md border-[#e8e8e8] dark:bg-[#141422]/80 dark:border-[#2a2a3d]">
                <button @click="sidebarOpen = !sidebarOpen" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5" data-test="sidebar-toggle">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/></svg>
                </button>

                <div class="hidden sm:block flex-1 max-w-md">
                    <div class="relative">
                        <svg class="absolute left-3 top-1/2 size-4 -translate-y-1/2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z"/></svg>
                        <input type="text" placeholder="Search something.." class="w-full rounded-xl border-0 bg-gray-100 py-2.5 pl-10 pr-4 text-sm text-gray-600 placeholder:text-gray-400 focus:bg-white focus:ring-2 focus:ring-[#4ecca3]/30 dark:bg-white/5 dark:text-gray-300 dark:placeholder:text-gray-500 dark:focus:bg-white/10">
                    </div>
                </div>

                <div class="flex flex-1 items-center justify-end gap-1 sm:gap-2">
                    <button @click="darkMode = !darkMode" class="rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5" title="Toggle dark mode">
                        <svg x-show="!darkMode" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/></svg>
                        <svg x-show="darkMode" x-cloak class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z"/></svg>
                    </button>

                    <button class="relative rounded-lg p-2 text-gray-500 hover:bg-gray-100 dark:text-gray-400 dark:hover:bg-white/5">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0"/></svg>
                        <span class="absolute right-1.5 top-1.5 flex size-2"><span class="absolute inline-flex size-full animate-ping rounded-full bg-[#4ecca3] opacity-75"></span><span class="relative inline-flex size-2 rounded-full bg-[#4ecca3]"></span></span>
                    </button>

                    <div class="relative ml-2" x-data="{ open: false }">
                        <button @click="open = !open" class="flex items-center gap-2 rounded-xl border border-gray-200 bg-white py-1.5 pl-1.5 pr-3 text-sm shadow-sm transition hover:shadow dark:border-[#2a2a3d] dark:bg-[#1a1a2e]" data-test="sidebar-menu-button">
                            <span class="flex size-8 items-center justify-center rounded-lg bg-[#4ecca3]/15 text-xs font-bold text-[#4ecca3]">
                                {{ auth()->user()->initials() }}
                            </span>
                            <span class="hidden font-medium sm:inline dark:text-gray-200">{{ Str::words(auth()->user()->name, 2, '') }}</span>
                            <svg class="size-4 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/></svg>
                        </button>

                        <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-150" x-transition:enter-start="opacity-0 scale-95 -translate-y-1" x-transition:enter-end="opacity-100 scale-100 translate-y-0" x-transition:leave="transition ease-in duration-100" x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95" x-cloak
                            class="absolute right-0 mt-2 w-56 origin-top-right rounded-xl border bg-white p-1.5 shadow-lg border-gray-200 dark:border-[#2a2a3d] dark:bg-[#1a1a2e]"
                        >
                            <div class="border-b border-gray-100 px-3 py-2.5 dark:border-white/10">
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ auth()->user()->email }}</p>
                            </div>

                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" wire:navigate class="flex items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-gray-600 hover:bg-gray-50 dark:text-gray-300 dark:hover:bg-white/5">
                                    <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 010 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281z"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    {{ __('Settings') }}
                                </a>
                            </div>

                            <div class="border-t border-gray-100 pt-1 dark:border-white/10">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex w-full items-center gap-2.5 rounded-lg px-3 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-500/10" data-test="logout-button">
                                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3 0l3-3m0 0l-3-3m3 3H9"/></svg>
                                        {{ __('Sign Out') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{ $slot }}
        </div>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 z-30 bg-black/40 backdrop-blur-sm lg:hidden" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-cloak></div>

        @fluxScripts
    </body>
</html>
