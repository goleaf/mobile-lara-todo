<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Sign in')]
class LoginComponent extends Component
{
    public string $email = '';

    public string $password = '';

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ];
    }

    public function updated(string $property): void
    {
        $this->validateOnly($property);
    }

    public function login()
    {
        $validated = $this->validate();

        if (! Auth::attempt($validated)) {
            $this->addError('email', __('auth.failed'));

            return null;
        }

        session()->regenerate();

        return redirect()->intended(route('app.home'));
    }

    public function render(): View
    {
        return view('livewire.auth.login-component');
    }
}
