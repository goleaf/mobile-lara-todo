<x-auth-card
    title="Choose a new password"
    subtitle="Create a fresh password for your account and return to the login screen."
>
    <form wire:submit="resetPassword" class="auth-form">
        <div class="md3-field">
            <label class="md3-field__label" for="reset-password-email">Email</label>
            <input
                wire:model.blur="email"
                class="md3-field__input"
                id="reset-password-email"
                type="email"
                autocomplete="email"
                inputmode="email"
                placeholder="you@example.com"
            >
            @error('email') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="md3-field">
            <label class="md3-field__label" for="reset-password-password">New password</label>
            <input
                wire:model.blur="password"
                class="md3-field__input"
                id="reset-password-password"
                type="password"
                autocomplete="new-password"
                placeholder="Enter a new password"
            >
            @error('password') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <div class="md3-field">
            <label class="md3-field__label" for="reset-password-confirmation">Confirm new password</label>
            <input
                wire:model.blur="passwordConfirmation"
                class="md3-field__input"
                id="reset-password-confirmation"
                type="password"
                autocomplete="new-password"
                placeholder="Repeat the new password"
            >
            @error('passwordConfirmation') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        <button type="submit" class="md3-button md3-button--filled">Save new password</button>
    </form>

    <div class="auth-links">
        <p class="auth-helper">Need the link again? <a href="{{ route('password.request') }}" class="auth-link" wire:navigate>Request a new email</a></p>
    </div>
</x-auth-card>
