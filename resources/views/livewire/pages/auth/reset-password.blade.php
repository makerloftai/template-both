<?php

use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Locked;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    #[Locked]
    public string $token = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(string $token): void
    {
        $this->token = $token;

        $this->email = request()->string('email');
    }

    /**
     * Reset the password for the given user.
     */
    public function resetPassword(): void
    {
        $this->validate([
            'token' => ['required'],
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $status = Password::reset(
            $this->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) {
                $user->forceFill([
                    'password' => Hash::make($this->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        if ($status != Password::PASSWORD_RESET) {
            $this->addError('email', __($status));

            return;
        }

        Session::flash('status', __($status));

        $this->redirectRoute('login', navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-2 text-center">
        <h2 class="text-xl font-semibold">{{ __('Reset your password') }}</h2>
        <p class="text-sm text-base-content/70">{{ __('Enter your new password below.') }}</p>
    </div>

    <form wire:submit="resetPassword" class="flex flex-col gap-4">
        <label class="form-control w-full">
            <span class="label-text">{{ __('Email') }}</span>
            <input type="email" wire:model="email" class="input input-bordered w-full" required autofocus autocomplete="username" />
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
            {{ __('Reset Password') }}
        </button>
    </form>
</div>
