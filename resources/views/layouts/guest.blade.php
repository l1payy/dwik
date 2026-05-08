<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-gray-50/50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div class="w-full sm:max-w-md mt-6 px-10 py-12 bg-white shadow-[0_20px_50px_rgba(230,119,38,0.12)] border border-gray-100 sm:rounded-[2.5rem] transition-all overflow-hidden">
                {{ $slot }}
            </div>
            <div class="mt-8 text-center">
                <p class="text-[10px] font-black text-gray-400 uppercase tracking-[0.3em]">© 2026 BPBD Kota Binjai</p>
            </div>
        </div>
    </body>
</html>
