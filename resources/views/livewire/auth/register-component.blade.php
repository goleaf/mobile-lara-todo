<x-auth-card
    title="Create account"
    subtitle="Set up a new account with the default Laravel user model and a mobile-first Material card."
>
    <form wire:submit="register" class="auth-form">
        <div class="md3-field">
            <label class="md3-field__label" for="register-name">Name</label>
            <input
                wire:model.blur="name"
                class="md3-field__input"
                id="register-name"
                type="text"
                autocomplete="name"
                placeholder="Taylor Otwell"
            >
            @error('name') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="md3-field">
            <label class="md3-field__label" for="register-email">Email</label>
            <input
                wire:model.blur="email"
                class="md3-field__input"
                id="register-email"
                type="email"
                autocomplete="email"
                inputmode="email"
                placeholder="you@example.com"
            >
            @error('email') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="md3-field">
            <label class="md3-field__label" for="register-password">Password</label>
            <input
                wire:model.blur="password"
                class="md3-field__input"
                id="register-password"
                type="password"
                autocomplete="new-password"
                placeholder="Choose a password"
            >
            @error('password') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="md3-field">
            <label class="md3-field__label" for="register-password-confirmation">Confirm password</label>
            <input
                wire:model.blur="passwordConfirmation"
                class="md3-field__input"
                id="register-password-confirmation"
                type="password"
                autocomplete="new-password"
                placeholder="Repeat your password"
            >
            @error('passwordConfirmation') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="md3-button md3-button--filled">Create account</button>
    </form>

    <div class="auth-links">
        <p class="auth-helper">Already have an account? <a href="{{ route('login') }}" class="auth-link" wire:navigate>Sign in</a></p>
    </div>
</x-auth-card>
