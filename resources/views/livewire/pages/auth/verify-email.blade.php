<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    /**
     * Send an email verification notification to the user.
     */
    public function sendVerification(): void
    {
        if (Auth::user()->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

            return;
        }

        Auth::user()->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }

    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div class="flex flex-col gap-6">
    <div class="flex flex-col gap-2 text-center">
        <flux:heading size="lg">{{ __('Verify your email') }}</flux:heading>
        <flux:subheading>
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
        </flux:subheading>
    </div>

    @if (session('status') === 'verification-link-sent')
        <flux:callout color="emerald" icon="check-circle" inline>
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </flux:callout>
    @endif

    <div class="flex items-center justify-between gap-4">
        <flux:button wire:click="sendVerification" variant="primary">
            {{ __('Resend Verification Email') }}
        </flux:button>

        <flux:button wire:click="logout" variant="ghost">
            {{ __('Log out') }}
        </flux:button>
    </div>
</div>
