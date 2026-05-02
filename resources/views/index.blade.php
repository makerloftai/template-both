<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name') }}</title>

        <script>
            (() => {
                const stored = localStorage.getItem('theme');
                const dark = window.matchMedia('(prefers-color-scheme: dark)').matches;
                document.documentElement.dataset.theme = stored ?? (dark ? 'dark' : 'light');
            })();
        </script>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased font-sans bg-base-100 text-base-content min-h-screen">
        @if (Route::has('login'))
            <header class="navbar bg-base-100 border-b border-base-300 container mx-auto px-4">
                <div class="navbar-start">
                    <a href="{{ url('/') }}" class="btn btn-ghost text-xl normal-case">{{ config('app.name') }}</a>
                </div>
                <div class="navbar-end">
                    <livewire:welcome.navigation />
                </div>
            </header>
        @endif

        <main class="container mx-auto px-4 py-12 text-center">
            <h1 class="text-3xl font-semibold">{{ config('app.name') }}</h1>
            <p class="mt-2 text-base-content/70">{{ __('Welcome.') }}</p>
        </main>
    </body>
</html>
