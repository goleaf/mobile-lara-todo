<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\RegisterUserAction;
use App\Http\Requests\Auth\RegisterRequest;
use App\Livewire\Concerns\UsesFormRequestValidation;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Create account')]
class RegisterComponent extends Component
{
    use UsesFormRequestValidation;

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $passwordConfirmation = '';

    public function updated(string $property): void
    {
        $field = $property === 'passwordConfirmation' ? 'password' : $property;

        $this->validateOnlyWithFormRequest($field, RegisterRequest::class, [
            'password_confirmation' => $this->passwordConfirmation,
        ]);
    }

    public function register()
    {
        $validated = $this->validateWithFormRequest(RegisterRequest::class);

        return app(RegisterUserAction::class)->handle($validated);
    }

    protected function prepareForValidation($attributes): array
    {
        $attributes['password_confirmation'] = $this->passwordConfirmation;

        return $attributes;
    }

    public function render(): View
    {
        return view('livewire.auth.register-component');
    }
}
