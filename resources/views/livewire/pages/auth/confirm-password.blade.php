<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $password = '';

    /**
     * Confirm the current user's password.
     */
    public function confirmPassword(): void
    {
        $this->validate([
            'password' => ['required', 'string'],
        ]);

        if (! Auth::guard('web')->validate([
            'email' => Auth::user()->email,
            'password' => $this->password,
        ])) {
            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        session(['auth.password_confirmed_at' => time()]);

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-2 text-center">
        <h2 class="text-xl font-semibold">{{ __('Confirm your password') }}</h2>
        <p class="text-sm text-base-content/70">
            {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
        </p>
    </div>

    <form wire:submit="confirmPassword" class="flex flex-col gap-4">
        <label class="form-control w-full">
            <span class="label-text">{{ __('Password') }}</span>
            <input type="password" wire:model="password" class="input input-bordered w-full" required autocomplete="current-password" />
            @error('password')<span class="text-error text-sm mt-1">{{ $message }}</span>@enderror
        </label>

        <button type="submit" class="btn btn-primary w-full" wire:loading.attr="disabled">
            {{ __('Confirm') }}
        </button>
    </form>
</div>
