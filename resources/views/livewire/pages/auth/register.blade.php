<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-2 text-center">
        <h2 class="text-xl font-semibold">{{ __('Create an account') }}</h2>
        <p class="text-sm text-base-content/70">{{ __('Enter your details below to create your account') }}</p>
    </div>

    <form wire:submit="register" class="flex flex-col gap-4">
        <label class="form-control w-full">
            <span class="label-text">{{ __('Name') }}</span>
            <input type="text" wire:model="name" class="input input-bordered w-full" required autofocus autocomplete="name" />
            @error('name')<span class="text-error text-sm mt-1">{{ $message }}</span>@enderror
        </label>

        <label class="form-control w-full">
            <span class="label-text">{{ __('Email') }}</span>
            <input type="email" wire:model="email" class="input input-bordered w-full" required autocomplete="username" placeholder="email@example.com" />
            @error('email')<span class="text-error text-sm mt-1">{{ $message }}</span>@enderror
        </label>

        <label class="form-control w-full">
            <span class="label-text">{{ __('Password') }}</span>
            <input type="password" wire:model="password" class="input input-bordered w-full" required autocomplete="new-password" />
            @error('password')<span class="text-error text-sm mt-1">{{ $message }}</span>@enderror
        </label>

        <label class="form-control w-full">
            <span class="label-text">{{ __('Confirm Password') }}</span>
            <input type="password" wire:model="password_confirmation" class="input input-bordered w-full" required autocomplete="new-password" />
        </label>

        <button type="submit" class="btn btn-primary w-full" wire:loading.attr="disabled">
            {{ __('Register') }}
        </button>
    </form>

    <div class="text-center text-sm text-base-content/70">
        {{ __('Already have an account?') }}
        <a href="{{ route('login') }}" wire:navigate class="link">{{ __('Log in') }}</a>
    </div>
</div>
