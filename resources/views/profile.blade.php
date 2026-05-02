<x-app-layout>
    <x-slot name="header">
        <h1 class="text-2xl font-semibold">{{ __('Profile') }}</h1>
    </x-slot>

    <div class="mx-auto max-w-2xl space-y-8 py-6">
        <div class="card bg-base-100 border border-base-300">
            <div class="card-body">
                <livewire:profile.update-profile-information-form />
            </div>
        </div>

        <div class="card bg-base-100 border border-base-300">
            <div class="card-body">
                <livewire:profile.update-password-form />
            </div>
        </div>

        <div class="card bg-base-100 border border-base-300">
            <div class="card-body">
                <livewire:profile.delete-user-form />
            </div>
        </div>
    </div>
</x-app-layout>
