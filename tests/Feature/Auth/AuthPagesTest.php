<?php

namespace Tests\Feature\Auth;

use App\Livewire\Auth\ForgotPasswordComponent;
use App\Livewire\Auth\LoginComponent;
use App\Livewire\Auth\RegisterComponent;
use App\Livewire\Auth\ResetPasswordComponent;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Livewire\Livewire;
use Tests\TestCase;

class AuthPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_auth_pages_render_successfully(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee('Welcome back')
            ->assertSee('Forgot password?');

        $this->get(route('register'))
            ->assertOk()
            ->assertSee('Create account')
            ->assertSee('Already have an account?');

        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee('Reset your password')
            ->assertSee('Send reset link');
    }

    public function test_user_can_register_from_the_livewire_component(): void
    {
        Livewire::test(RegisterComponent::class)
            ->set('name', 'Taylor Otwell')
            ->set('email', 'taylor@example.com')
            ->set('password', 'password')
            ->set('passwordConfirmation', 'password')
            ->call('register')
            ->assertHasNoErrors();

        $this->assertAuthenticated();
        $this->assertDatabaseHas('users', ['email' => 'taylor@example.com']);
    }

    public function test_user_can_log_in_from_the_livewire_component(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => 'password',
        ]);

        Livewire::test(LoginComponent::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->call('login')
            ->assertHasNoErrors();

        $this->assertAuthenticatedAs($user);
    }

    public function test_forgot_password_component_sends_a_reset_link(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'reset@example.com',
        ]);

        Livewire::test(ForgotPasswordComponent::class)
            ->set('email', $user->email)
            ->call('sendResetLink')
            ->assertHasNoErrors()
            ->assertSet('status', __(
                Password::RESET_LINK_SENT
            ));

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_reset_password_page_renders_and_can_update_the_password(): void
    {
        $user = User::factory()->create([
            'email' => 'recover@example.com',
        ]);

        $token = Password::broker()->createToken($user);

        $this->get(route('password.reset', ['token' => $token, 'email' => $user->email]))
            ->assertOk()
            ->assertSee('Choose a new password');

        Livewire::withQueryParams(['email' => $user->email])
            ->test(ResetPasswordComponent::class, ['token' => $token])
            ->set('email', $user->email)
            ->set('password', 'new-password')
            ->set('passwordConfirmation', 'new-password')
            ->call('resetPassword')
            ->assertHasNoErrors();

        $this->assertCredentials([
            'email' => $user->email,
            'password' => 'new-password',
        ]);
    }
}
