<?php

namespace App\Livewire\Auth;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Password;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.auth')]
#[Title('Forgot password')]
class ForgotPasswordComponent extends Component
{
    public string $email = '';

    public ?string $status = null;

    protected function rules(): array
    {
        return [
            'email' => ['required', 'email'],
        ];
    }

    public function updated(string $property): void
    {
        $this->validateOnly($property);
    }

    public function sendResetLink(): void
    {
        $validated = $this->validate();

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
