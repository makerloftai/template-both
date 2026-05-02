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

        @fluxAppearance
    </head>
    <body class="font-sans antialiased min-h-screen bg-white dark:bg-zinc-900">
        <div class="flex min-h-screen flex-col items-center justify-center px-4 py-8">
            <a href="/" wire:navigate class="mb-6">
                <x-application-logo class="h-12 w-auto fill-current text-zinc-500" />
            </a>

            <div class="w-full sm:max-w-md rounded-lg border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-700 dark:bg-zinc-800">
                {{ $slot }}
            </div>
        </div>

        @fluxScripts
    </body>
</html>
