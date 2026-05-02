<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-2 text-center">
        <flux:heading size="lg">{{ __('Log in to your account') }}</flux:heading>
        <flux:subheading>{{ __('Enter your email and password below to log in') }}</flux:subheading>
    </div>

    @if (session('status'))
        <flux:callout color="emerald" icon="check-circle" inline>
            {{ session('status') }}
        </flux:callout>
    @endif

    <form wire:submit="login" class="flex flex-col gap-4">
        <flux:input
            wire:model="form.email"
            :label="__('Email')"
            type="email"
            required
            autofocus
            autocomplete="username"
            placeholder="email@example.com"
        />

        <flux:input
            wire:model="form.password"
            :label="__('Password')"
            type="password"
            required
            autocomplete="current-password"
            viewable
            :placeholder="__('Password')"
        />

        <div class="flex items-center justify-between">
            <flux:checkbox wire:model="form.remember" :label="__('Remember me')" />

            @if (Route::has('password.request'))
                <flux:link href="{{ route('password.request') }}" wire:navigate variant="subtle" class="text-sm">
                    {{ __('Forgot your password?') }}
                </flux:link>
            @endif
        </div>

        <flux:button type="submit" variant="primary" class="w-full">
            {{ __('Log in') }}
        </flux:button>
    </form>

    @if (Route::has('register'))
        <div class="text-center text-sm text-zinc-600 dark:text-zinc-400">
            {{ __("Don't have an account?") }}
            <flux:link href="{{ route('register') }}" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif
</div>
