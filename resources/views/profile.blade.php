<x-app-layout>
    <x-slot name="header">
        <flux:heading size="xl">{{ __('Profile') }}</flux:heading>
    </x-slot>

    <div class="mx-auto max-w-2xl space-y-8 py-6">
        <div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
            <livewire:profile.update-profile-information-form />
        </div>

        <div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
            <livewire:profile.update-password-form />
        </div>

        <div class="rounded-lg border border-zinc-200 bg-white p-6 dark:border-zinc-700 dark:bg-zinc-800">
            <livewire:profile.delete-user-form />
        </div>
    </div>
</x-app-layout>
