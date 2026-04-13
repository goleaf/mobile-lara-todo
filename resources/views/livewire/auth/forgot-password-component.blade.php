<x-auth-card
    title="Reset your password"
    subtitle="Enter your email and Laravel will send the built-in password reset link."
>
    <form wire:submit="sendResetLink" class="auth-form">
        <div class="md3-field">
            <label class="md3-field__label" for="forgot-password-email">Email</label>
            <input
                wire:model.blur="email"
                class="md3-field__input"
                id="forgot-password-email"
                type="email"
                autocomplete="email"
                inputmode="email"
                placeholder="you@example.com"
            >
            @error('email') <p class="field-error">{{ $message }}</p> @enderror
        </div>

        @if ($status)
            <p class="status-banner">{{ $status }}</p>
        @endif

        <button type="submit" class="md3-button md3-button--filled">Send reset link</button>
    </form>

    <div class="auth-links">
        <p class="auth-helper">Remembered it? <a href="{{ route('login') }}" class="auth-link" wire:navigate>Go back to sign in</a></p>
    </div>
</x-auth-card>
