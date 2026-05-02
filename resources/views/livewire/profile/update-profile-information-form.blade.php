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
        <flux:heading size="lg">{{ __('Profile Information') }}</flux:heading>
        <flux:subheading>{{ __("Update your account's profile information and email address.") }}</flux:subheading>
    </header>

    <form wire:submit="updateProfileInformation" class="flex flex-col gap-4">
        <flux:input
            wire:model="name"
            :label="__('Name')"
            type="text"
            required
            autofocus
            autocomplete="name"
        />

        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="email"
            required
            autocomplete="username"
        />

        @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! auth()->user()->hasVerifiedEmail())
            <flux:callout color="amber" icon="exclamation-triangle" inline>
                {{ __('Your email address is unverified.') }}
                <flux:link wire:click.prevent="sendVerification">{{ __('Click here to re-send the verification email.') }}</flux:link>
            </flux:callout>

            @if (session('status') === 'verification-link-sent')
                <flux:callout color="emerald" icon="check-circle" inline>
                    {{ __('A new verification link has been sent to your email address.') }}
                </flux:callout>
            @endif
        @endif

        <div class="flex items-center gap-4">
            <flux:button type="submit" variant="primary">{{ __('Save') }}</flux:button>

            <flux:text x-data="{ shown: false }" x-init="$wire.on('profile-updated', () => { shown = true; setTimeout(() => shown = false, 2000); })" x-show="shown" x-transition class="text-emerald-600 dark:text-emerald-400">
                {{ __('Saved.') }}
            </flux:text>
        </div>
    </form>
</section>
