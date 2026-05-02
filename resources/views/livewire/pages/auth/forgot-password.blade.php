<?php

use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $email = '';

    /**
     * Send a password reset link to the provided email address.
     */
    public function sendPasswordResetLink(): void
    {
        $this->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $status = Password::sendResetLink(
            $this->only('email')
        );

        if ($status != Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->reset('email');

        session()->flash('status', __($status));
    }
}; ?>

<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-2 text-center">
        <h2 class="text-xl font-semibold">{{ __('Forgot your password?') }}</h2>
        <p class="text-sm text-base-content/70">
            {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
        </p>
    </div>

    @if (session('status'))
        <div role="alert" class="alert alert-success">
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-4">
        <label class="form-control w-full">
            <span class="label-text">{{ __('Email') }}</span>
            <input type="email" wire:model="email" class="input input-bordered w-full" required autofocus placeholder="email@example.com" />
            @error('email')<span class="text-error text-sm mt-1">{{ $message }}</span>@enderror
        </label>

        <button type="submit" class="btn btn-primary w-full" wire:loading.attr="disabled">
            {{ __('Email Password Reset Link') }}
        </button>
    </form>

    <div class="text-center text-sm text-base-content/70">
        <a href="{{ route('login') }}" wire:navigate class="link">{{ __('Back to login') }}</a>
    </div>
</div>
