<?php

namespace App\Livewire\Auth;

use App\Http\Requests\Auth\ForgotPasswordRequest;
use App\Livewire\Concerns\UsesFormRequestValidation;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
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

        $status = Password::sendResetLink([
            'email' => $validated['email'],
        ]);

        if ($status !== Password::RESET_LINK_SENT) {
            $this->addError('email', __($status));

            return;
        }

        $this->status = __($status);
    }

    public function render(): View
    {
        return view('livewire.auth.forgot-password-component');
    }
}
