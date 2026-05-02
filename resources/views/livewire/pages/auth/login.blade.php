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
        <h2 class="text-xl font-semibold">{{ __('Log in to your account') }}</h2>
        <p class="text-sm text-base-content/70">{{ __('Enter your email and password below to log in') }}</p>
    </div>

    @if (session('status'))
        <div role="alert" class="alert alert-success">
            <span>{{ session('status') }}</span>
        </div>
    @endif

    <form wire:submit="login" class="flex flex-col gap-4">
        <label class="form-control w-full">
            <span class="label-text">{{ __('Email') }}</span>
            <input
                type="email"
                wire:model="form.email"
                class="input input-bordered w-full"
                required
                autofocus
                autocomplete="username"
                placeholder="email@example.com"
            />
            @error('form.email')<span class="text-error text-sm mt-1">{{ $message }}</span>@enderror
        </label>

        <label class="form-control w-full">
            <span class="label-text">{{ __('Password') }}</span>
            <input
                type="password"
                wire:model="form.password"
                class="input input-bordered w-full"
                required
                autocomplete="current-password"
                placeholder="{{ __('Password') }}"
            />
            @error('form.password')<span class="text-error text-sm mt-1">{{ $message }}</span>@enderror
        </label>

        <div class="flex items-center justify-between">
            <label class="label cursor-pointer gap-2 justify-start">
                <input type="checkbox" wire:model="form.remember" class="checkbox" />
                <span class="label-text">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" wire:navigate class="link link-hover text-sm">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <button type="submit" class="btn btn-primary w-full" wire:loading.attr="disabled">
            {{ __('Log in') }}
        </button>
    </form>

    @if (Route::has('register'))
        <div class="text-center text-sm text-base-content/70">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" wire:navigate class="link">{{ __('Sign up') }}</a>
        </div>
    @endif
</div>
