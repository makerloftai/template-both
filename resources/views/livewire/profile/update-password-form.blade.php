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
        <h2 class="text-lg font-semibold">{{ __('Update Password') }}</h2>
        <p class="text-sm text-base-content/70">{{ __('Ensure your account is using a long, random password to stay secure.') }}</p>
    </header>

    <form wire:submit="updatePassword" class="flex flex-col gap-4">
        <label class="form-control w-full">
            <span class="label-text">{{ __('Current Password') }}</span>
            <input type="password" wire:model="current_password" class="input input-bordered w-full" autocomplete="current-password" />
            @error('current_password')<span class="text-error text-sm mt-1">{{ $message }}</span>@enderror
        </label>

        <label class="form-control w-full">
            <span class="label-text">{{ __('New Password') }}</span>
            <input type="password" wire:model="password" class="input input-bordered w-full" autocomplete="new-password" />
            @error('password')<span class="text-error text-sm mt-1">{{ $message }}</span>@enderror
        </label>

        <label class="form-control w-full">
            <span class="label-text">{{ __('Confirm Password') }}</span>
            <input type="password" wire:model="password_confirmation" class="input input-bordered w-full" autocomplete="new-password" />
        </label>

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>

            <span x-data="{ shown: false }" x-init="$wire.on('password-updated', () => { shown = true; setTimeout(() => shown = false, 2000); })" x-show="shown" x-cloak x-transition class="text-success text-sm">
                {{ __('Saved.') }}
            </span>
        </div>
    </form>
</section>
