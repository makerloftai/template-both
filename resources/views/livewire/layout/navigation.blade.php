<?php

use App\Livewire\Actions\Logout;
use Livewire\Attributes\On;
use Livewire\Volt\Component;

new class extends Component
{
    public string $name = '';

    public function mount(): void
    {
        $this->name = (string) auth()->user()?->name;
    }

    /**
     * Listen for profile updates so the user-menu name reflects edits
     * without a full reload.
     */
    #[On('profile-updated')]
    public function refreshProfile(string $name): void
    {
        $this->name = $name;
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

<flux:dropdown align="end">
    <flux:profile :name="$name" />

    <flux:menu>
        <flux:menu.item icon="user" href="{{ route('profile') }}" wire:navigate>
            {{ __('Profile') }}
        </flux:menu.item>

        <flux:menu.separator />

        <flux:menu.item icon="arrow-right-start-on-rectangle" wire:click="logout" variant="danger">
            {{ __('Log out') }}
        </flux:menu.item>
    </flux:menu>
</flux:dropdown>
