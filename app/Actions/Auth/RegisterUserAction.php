<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Features\SupportRedirects\Redirector as LivewireRedirector;

class RegisterUserAction
{
    /**
     * @param  array{name: string, email: string, password: string, password_confirmation?: string}  $attributes
     */
    public function handle(array $attributes): RedirectResponse|LivewireRedirector
    {
        $user = User::query()->create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);
        session()->regenerate();

        return redirect()->route('app.home');
    }
}
