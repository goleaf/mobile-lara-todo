<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\LoginUserAction;
use App\Http\Requests\Auth\LoginRequest;
use App\Livewire\Concerns\UsesFormRequestValidation;
use Illuminate\Contracts\View\View;
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

    public bool $remember = false;

    public function updated(string $property): void
    {
        if (! in_array($property, ['email', 'password'], true)) {
            return;
        }

        $this->validateOnlyWithFormRequest($property, LoginRequest::class);
    }

    public function login()
    {
        $validated = $this->validateWithFormRequest(LoginRequest::class);

        return app(LoginUserAction::class)->handle($validated, $this->remember);
    }

    public function render(): View
    {
        return view('livewire.auth.login-component');
    }
}
