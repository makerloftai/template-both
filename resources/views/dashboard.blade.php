<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold">{{ __('Dashboard') }}</h1>
    </x-slot>

    <div class="mx-auto max-w-7xl py-6">
        <div class="card bg-base-100 border border-base-300">
            <div class="card-body">
                <p>{{ __("You're logged in!") }}</p>
            </div>
        </div>
    </div>
</x-app-layout>
