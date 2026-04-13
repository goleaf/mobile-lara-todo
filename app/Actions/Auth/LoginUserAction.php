<?php

namespace App\Actions\Auth;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Livewire\Features\SupportRedirects\Redirector as LivewireRedirector;

class LoginUserAction
{
    /**
     * @param  array{email: string, password: string}  $credentials
     */
    public function handle(array $credentials, bool $remember = false): RedirectResponse|LivewireRedirector
    {
        if (! Auth::attempt($credentials, $remember)) {
            throw ValidationException::withMessages([
                'email' => __('auth.failed'),
            ]);
        }

        session()->regenerate();

        return redirect()->intended(route('app.home'));
    }
}
