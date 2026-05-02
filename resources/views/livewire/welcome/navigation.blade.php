<nav class="flex flex-1 justify-end gap-2">
    @auth
        <a href="{{ url('/dashboard') }}" wire:navigate class="btn btn-ghost">{{ __('Dashboard') }}</a>
    @else
        <a href="{{ route('login') }}" wire:navigate class="btn btn-ghost">{{ __('Log in') }}</a>

        @if (Route::has('register'))
            <a href="{{ route('register') }}" wire:navigate class="btn btn-primary">{{ __('Register') }}</a>
        @endif
    @endauth
</nav>
