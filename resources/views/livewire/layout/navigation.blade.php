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

<div
    class="dropdown dropdown-end"
    x-data="{ open: false }"
    @click.outside="open = false"
    @keydown.escape.window="open && (open = false, $refs.trigger.focus())"
>
    <button
        type="button"
        class="btn btn-ghost rounded-btn"
        x-ref="trigger"
        @click="open = !open"
        :aria-expanded="open"
        aria-haspopup="menu"
    >
        <div class="avatar placeholder">
            <div class="bg-neutral text-neutral-content w-8 rounded-full">
                <span class="text-sm">{{ mb_strtoupper(mb_substr($name, 0, 1)) ?: '?' }}</span>
            </div>
        </div>
        <span class="hidden sm:inline ms-2">{{ $name }}</span>
    </button>

    <ul
        class="menu dropdown-content bg-base-100 border border-base-300 rounded-box shadow z-10 mt-2 w-52 p-2"
        role="menu"
        x-show="open"
        x-cloak
        x-transition.opacity.duration.150ms
    >
        <li>
            <a href="{{ route('profile') }}" wire:navigate role="menuitem">
                {{ __('Profile') }}
            </a>
        </li>
        <li><div class="divider my-0"></div></li>
        <li>
            <button type="button" wire:click="logout" role="menuitem" class="text-error w-full text-left">
                {{ __('Log out') }}
            </button>
        </li>
    </ul>
</div>
