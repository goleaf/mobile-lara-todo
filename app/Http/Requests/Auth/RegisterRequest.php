<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Please enter your name.',
            'name.max' => 'Your name may not be greater than 255 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'That email address is already registered.',
            'password.required' => 'Please enter a password.',
            'password.min' => 'Your password must be at least 8 characters.',
            'password.confirmed' => 'Your password confirmation does not match.',
            'password_confirmation.required' => 'Please confirm your password.',
        ];
    }
}
