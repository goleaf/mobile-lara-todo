<x-auth-card
    title="Welcome back"
    subtitle="Sign in to continue from the same mobile-first shell with Material Design 3 form styling."
>
    <form wire:submit="login" class="auth-form">
        <div class="md3-field">
            <label class="md3-field__label" for="login-email">Email</label>
            <input
                wire:model.blur="email"
                class="md3-field__input"
                id="login-email"
                type="email"
                autocomplete="email"
                inputmode="email"
                placeholder="you@example.com"
            >
            @error('email') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="md3-field">
            <label class="md3-field__label" for="login-password">Password</label>
            <input
                wire:model.blur="password"
                class="md3-field__input"
                id="login-password"
                type="password"
                autocomplete="current-password"
                placeholder="Enter your password"
            >
            @error('password') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="auth-toggle">
            <label class="auth-toggle__label" for="login-remember">
                <input
                    wire:model.live="remember"
                    class="auth-toggle__input"
                    id="login-remember"
                    type="checkbox"
                >
                <span>Remember me</span>
            </label>
        </div>

        <button type="submit" class="md3-button md3-button--filled">Sign in</button>
    </form>

    <div class="auth-links">
        <a href="{{ route('password.request') }}" class="auth-link" wire:navigate>Forgot password?</a>
        <p class="auth-helper">Need an account? <a href="{{ route('register') }}" class="auth-link" wire:navigate>Create one</a></p>
    </div>
</x-auth-card>
