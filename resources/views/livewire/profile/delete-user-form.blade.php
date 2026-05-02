<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Livewire\Volt\Component;

new class extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        tap(Auth::user(), $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}; ?>

<section x-data="{ open: false }" @keydown.escape.window="open && (open = false)">
    <header class="mb-6">
        <h2 class="text-lg font-semibold">{{ __('Delete Account') }}</h2>
        <p class="text-sm text-base-content/70">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button type="button" class="btn btn-error" x-ref="trigger" @click="open = true">
        {{ __('Delete Account') }}
    </button>

    <dialog class="modal" :class="{ 'modal-open': open }" @click.self="open = false">
        <div class="modal-box">
            <h3 class="text-lg font-semibold">{{ __('Are you sure you want to delete your account?') }}</h3>
            <p class="py-2 text-sm text-base-content/70">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm.') }}
            </p>

            <form wire:submit="deleteUser" class="flex flex-col gap-3">
                <label class="form-control w-full">
                    <span class="label-text">{{ __('Password') }}</span>
                    <input type="password" wire:model="password" class="input input-bordered w-full" placeholder="{{ __('Password') }}" />
                    @error('password')<span class="text-error text-sm mt-1">{{ $message }}</span>@enderror
                </label>

                <div class="modal-action">
                    <button type="button" class="btn btn-ghost" @click="open = false">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-error" wire:loading.attr="disabled">{{ __('Delete Account') }}</button>
                </div>
            </form>
        </div>
    </dialog>
</section>
