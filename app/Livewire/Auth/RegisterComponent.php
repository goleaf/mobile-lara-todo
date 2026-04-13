<?php

namespace App\Livewire\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Livewire\Concerns\UsesFormRequestValidation;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
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

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
        ]);

        event(new Registered($user));

        Auth::login($user);
        session()->regenerate();

        return redirect()->route('app.home');
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
