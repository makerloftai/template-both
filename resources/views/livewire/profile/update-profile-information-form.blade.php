<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';
    public string $email = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $this->name = Auth::user()->name;
        $this->email = Auth::user()->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->fill($validated);

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        $user->save();

        $this->dispatch('profile-updated', name: $user->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function sendVerification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}; ?>

<section>
    <header class="mb-6">
        <h2 class="text-lg font-semibold">{{ __('Profile Information') }}</h2>
        <p class="text-sm text-base-content/70">{{ __("Update your account's profile information and email address.") }}</p>
    </header>

    <form wire:submit="updateProfileInformation" class="flex flex-col gap-4">
        <label class="form-control w-full">
            <span class="label-text">{{ __('Name') }}</span>
            <input type="text" wire:model="name" class="input input-bordered w-full" required autofocus autocomplete="name" />
            @error('name')<span class="text-error text-sm mt-1">{{ $message }}</span>@enderror
        </label>

        <label class="form-control w-full">
            <span class="label-text">{{ __('Email') }}</span>
            <input type="email" wire:model="email" class="input input-bordered w-full" required autocomplete="username" />
            @error('email')<span class="text-error text-sm mt-1">{{ $message }}</span>@enderror
        </label>

        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
            <div role="alert" class="alert alert-warning">
                <span>
                    {{ __('Your email address is unverified.') }}
                    <button type="button" wire:click.prevent="sendVerification" class="link">{{ __('Click here to re-send the verification email.') }}</button>
                </span>
            </div>

            @if (session('status') === 'verification-link-sent')
                <div role="alert" class="alert alert-success">
                    <span>{{ __('A new verification link has been sent to your email address.') }}</span>
                </div>
            @endif
        @endif

        <div class="flex items-center gap-4">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">{{ __('Save') }}</button>

            <span x-data="{ shown: false }" x-init="$wire.on('profile-updated', () => { shown = true; setTimeout(() => shown = false, 2000); })" x-show="shown" x-cloak x-transition class="text-success text-sm">
                {{ __('Saved.') }}
            </span>
        </div>
    </form>
</section>
