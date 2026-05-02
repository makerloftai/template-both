<nav class="flex flex-1 justify-end gap-2">
    @auth
        <flux:button :href="url('/dashboard')" variant="ghost">{{ __('Dashboard') }}</flux:button>
    @else
        <flux:button :href="route('login')" variant="ghost">{{ __('Log in') }}</flux:button>

        @if (Route::has('register'))
            <flux:button :href="route('register')" variant="primary">{{ __('Register') }}</flux:button>
        @endif
    @endauth
</nav>
