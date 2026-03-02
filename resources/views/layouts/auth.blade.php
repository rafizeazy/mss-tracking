<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="auth-bg flex min-h-dvh items-center justify-center font-sans antialiased" style="color: #4c4c5c;">

        <div class="flex w-full justify-center px-3 py-8 sm:px-4 xl:m-5 xl:px-4">
            <div class="w-full max-w-md">
                {{-- Boron Auth Card --}}
                <div class="boron-card mb-0 overflow-hidden text-center">
                    <div class="p-6 sm:p-8 xl:p-10">
                        {{-- Logo --}}
                        <a href="{{ route('home') }}" class="mb-5 inline-flex items-center gap-2" wire:navigate>
                            <x-app-logo-icon class="size-6 fill-current text-[#313a46] dark:text-white" />
                            <span class="text-lg font-semibold text-[#313a46] dark:text-white">{{ config('app.name', 'MSS Tracking') }}</span>
                        </a>

                        {{ $slot }}

                        {{-- Footer --}}
                        <p class="mb-0 mt-6 text-xs text-[#8a969c]">
                            &copy; {{ date('Y') }} {{ config('app.name') }} — By <span class="font-bold uppercase">MSS</span>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @fluxScripts
    </body>
</html>
