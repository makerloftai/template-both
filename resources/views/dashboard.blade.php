<x-app-layout>
    <x-slot name="header">
        <flux:heading size="xl">{{ __('Dashboard') }}</flux:heading>
    </x-slot>

    <div class="mx-auto max-w-7xl py-6">
        <div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
            <flux:text>{{ __("You're logged in!") }}</flux:text>
        </div>
    </div>
</x-app-layout>
