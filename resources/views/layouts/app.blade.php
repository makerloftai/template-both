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
        <flux:header container class="bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-700">
            <a href="{{ route('dashboard') }}" wire:navigate class="flex items-center gap-2">
                <x-application-logo class="h-8 w-auto fill-current text-zinc-800 dark:text-zinc-200" />
            </a>

            <flux:navbar class="ms-8 me-auto">
                <flux:navbar.item :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </flux:navbar.item>
            </flux:navbar>

            <livewire:layout.navigation />
        </flux:header>

        <flux:main container>
            @if (isset($header))
                <header class="mb-6">
                    {{ $header }}
                </header>
            @endif

            {{ $slot }}
        </flux:main>

        @fluxScripts
    </body>
</html>
