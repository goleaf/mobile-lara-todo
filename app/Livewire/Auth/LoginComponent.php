<?php

namespace App\Livewire\Auth;

use App\Http\Requests\Auth\LoginRequest;
use App\Livewire\Concerns\UsesFormRequestValidation;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Sign in')]
class LoginComponent extends Component
{
    use UsesFormRequestValidation;

    public string $email = '';

    public string $password = '';

    public function updated(string $property): void
    {
        $this->validateOnlyWithFormRequest($property, LoginRequest::class);
    }

    public function login()
    {
        $validated = $this->validateWithFormRequest(LoginRequest::class);

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
