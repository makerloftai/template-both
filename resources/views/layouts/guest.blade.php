<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <script>
            (() => {
                const stored = localStorage.getItem('theme');
                const dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.dataset.theme = stored ?? (dark ? 'dark' : 'light');
            })();
        </script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen bg-base-100 text-base-content">
        <div class="flex min-h-screen flex-col items-center justify-center px-4 py-8">
            <a href="/" wire:navigate class="mb-6">
                <x-application-logo class="h-12 w-auto fill-current" />
            </a>

            <div class="card bg-base-100 border border-base-300 shadow-sm w-full sm:max-w-md">
                <div class="card-body">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
