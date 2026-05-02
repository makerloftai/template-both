<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\ValidationException;
use Livewire\Volt\Component;

new class extends Component
{
    public string $current_password = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', Password::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        Auth::user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}; ?>

<section>
    <header class="mb-6">
        <flux:heading size="lg">{{ __('Update Password') }}</flux:heading>
        <flux:subheading>{{ __('Ensure your account is using a long, random password to stay secure.') }}</flux:subheading>
    </header>

    <form wire:submit="updatePassword" class="flex flex-col gap-4">
        <flux:input
            wire:model="current_password"
            :label="__('Current Password')"
            type="password"
            autocomplete="current-password"
            viewable
        />

        <flux:input
            wire:model="password"
            :label="__('New Password')"
            type="password"
            autocomplete="new-password"
            viewable
        />

        <flux:input
            wire:model="password_confirmation"
            :label="__('Confirm Password')"
            type="password"
            autocomplete="new-password"
            viewable
        />

        <div class="flex items-center gap-4">
            <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>

            <flux:text x-data="{ shown: false }" x-init="$wire.on('password-updated', () => { shown = true; setTimeout(() => shown = false, 2000); })" x-show="shown" x-transition class="text-emerald-600 dark:text-emerald-400">
                {{ __('Saved.') }}
            </flux:text>
        </div>
    </form>
</section>
