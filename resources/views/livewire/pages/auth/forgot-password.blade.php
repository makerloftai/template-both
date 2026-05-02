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
        <flux:heading size="lg">{{ __('Forgot your password?') }}</flux:heading>
        <flux:subheading>
            {{ __('No problem. Just let us know your email address and we will email you a password reset link.') }}
        </flux:subheading>
    </div>

    @if (session('status'))
        <flux:callout color="emerald" icon="check-circle" inline>
            {{ session('status') }}
        </flux:callout>
    @endif

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-4">
        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="email"
            required
            autofocus
            placeholder="email@example.com"
        />

        <flux:button type="submit" variant="primary" class="w-full">
            {{ __('Email Password Reset Link') }}
        </flux:button>
    </form>

    <div class="text-center text-sm text-zinc-600 dark:text-zinc-400">
        <flux:link href="{{ route('login') }}" wire:navigate>{{ __('Back to login') }}</flux:link>
    </div>
</div>
