<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen antialiased bg-neutral-950 text-white">
        <div class="relative grid min-h-dvh lg:grid-cols-[1.15fr_1fr]">

            <div class="hidden lg:flex relative overflow-hidden bg-gradient-to-br from-neutral-900 via-neutral-950 to-neutral-900">
                <div class="absolute inset-0 auth-dot-pattern"></div>

                <div class="absolute -top-24 -left-24 size-96 rounded-full border border-amber-500/[0.07]"></div>
                <div class="absolute top-1/4 right-0 translate-x-1/2 size-72 rounded-full border border-amber-500/[0.05]"></div>
                <div class="absolute bottom-32 left-16 size-48 border border-amber-500/[0.06] rotate-45"></div>
                <div class="absolute top-1/2 left-1/3 w-px h-32 bg-gradient-to-b from-transparent via-amber-500/20 to-transparent"></div>
                <div class="absolute bottom-1/4 right-1/4 w-24 h-px bg-gradient-to-r from-transparent via-amber-500/15 to-transparent"></div>

                <div class="relative z-10 flex flex-col justify-between h-full w-full p-10 xl:p-14">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group" wire:navigate>
                        <span class="flex size-9 items-center justify-center rounded-lg bg-amber-500/10 ring-1 ring-amber-500/20 transition-all duration-300 group-hover:bg-amber-500/15 group-hover:ring-amber-500/30">
                            <x-app-logo-icon class="size-5 fill-current text-amber-500" />
                        </span>
                        <span class="text-xs font-medium tracking-[0.2em] uppercase text-neutral-500 transition-colors duration-300 group-hover:text-neutral-400">
                            {{ config('app.name', 'Laravel') }}
                        </span>
                    </a>

                    <div class="space-y-8 max-w-md">
                        <div class="w-8 h-px bg-amber-500/40"></div>
                        <h1 class="text-5xl xl:text-6xl 2xl:text-7xl font-semibold leading-[0.92] tracking-[-0.03em] text-white">
                            Track<br>
                            <span class="text-amber-500/70">every</span><br>
                            detail<span class="text-amber-500">.</span>
                        </h1>
                        <p class="text-sm leading-relaxed text-neutral-500 max-w-[280px]">
                            Precision monitoring for the things that matter most to your operation.
                        </p>
                    </div>

                    <p class="text-[11px] text-neutral-700 tracking-wider uppercase">
                        &copy; {{ date('Y') }} {{ config('app.name') }}
                    </p>
                </div>
            </div>

            <div class="relative flex flex-col items-center justify-center px-6 py-16 sm:px-12 lg:px-16 xl:px-24 bg-neutral-950 lg:bg-neutral-900/20">
                <div class="absolute top-0 left-0 right-0 h-px bg-gradient-to-r from-transparent via-amber-500/20 to-transparent lg:hidden"></div>
                <div class="absolute top-0 left-0 bottom-0 w-px bg-gradient-to-b from-transparent via-neutral-800/50 to-transparent hidden lg:block"></div>

                <div class="lg:hidden mb-12">
                    <a href="{{ route('home') }}" class="flex flex-col items-center gap-3" wire:navigate>
                        <span class="flex size-10 items-center justify-center rounded-lg bg-amber-500/10 ring-1 ring-amber-500/20">
                            <x-app-logo-icon class="size-6 fill-current text-amber-500" />
                        </span>
                        <span class="text-xs font-medium tracking-[0.2em] uppercase text-neutral-500">
                            {{ config('app.name', 'Laravel') }}
                        </span>
                    </a>
                </div>

                <div class="w-full max-w-sm">
                    {{ $slot }}
                </div>
            </div>
        </div>
        @fluxScripts
    </body>
</html>
