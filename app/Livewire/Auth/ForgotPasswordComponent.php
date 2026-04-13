<?php

namespace App\Livewire\Auth;

use App\Actions\Auth\SendPasswordResetAction;
use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Livewire\Concerns\UsesFormRequestValidation;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Forgot password')]
class ForgotPasswordComponent extends Component
{
    use UsesFormRequestValidation;

    public string $email = '';

    public ?string $status = null;

    public function updated(string $property): void
    {
        $this->validateOnlyWithFormRequest($property, ForgotPasswordRequest::class);
    }

    public function sendResetLink(): void
    {
        $validated = $this->validateWithFormRequest(ForgotPasswordRequest::class);

        $this->status = app(SendPasswordResetAction::class)->handle($validated['email']);
    }

    public function render(): View
    {
        return view('livewire.auth.forgot-password-component');
    }
}
