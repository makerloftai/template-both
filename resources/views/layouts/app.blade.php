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
        <header class="navbar bg-base-100 border-b border-base-300 container mx-auto px-4">
            <div class="navbar-start">
                <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2">
                    <x-application-logo class="h-8 w-auto fill-current" />
                </a>
                <nav class="ms-8 hidden md:flex">
                    <ul class="menu menu-horizontal">
                        <li>
                            <a href="{{ route('dashboard') }}" wire:navigate class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                                {{ __('Dashboard') }}
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="navbar-end gap-2">
                <livewire:layout.navigation />
            </div>
        </header>

        <main class="container mx-auto px-4 py-6">
            @if (isset($header))
                <header class="mb-6">
                    {{ $header }}
                </header>
            @endif

            {{ $slot }}
        </main>
    </body>
</html>
