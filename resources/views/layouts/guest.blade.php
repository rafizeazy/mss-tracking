<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        {{-- Memanggil head yang sama dengan layout app Anda --}}
        @include('partials.head')
    </head>
    <body class="boron-body font-sans antialiased bg-[#f6f7fb] dark:bg-[#15151b]">
        
        {{-- Konten Livewire (Form Registrasi) akan otomatis masuk ke variabel $slot ini --}}
        {{ $slot }}

        @fluxScripts
    </body>
</html>