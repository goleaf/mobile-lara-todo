<?php

namespace Tests\Feature\Auth;

use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\LogoutUserAction;
use App\Actions\Auth\RegisterUserAction;
use App\Actions\Auth\SendPasswordResetAction;
use App\Livewire\Auth\ForgotPasswordComponent;
use App\Livewire\Auth\LoginComponent;
use App\Livewire\Auth\RegisterComponent;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Mockery\MockInterface;
use Tests\TestCase;

class AuthActionWiringTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_component_delegates_submission_to_the_login_action(): void
    {
        $user = User::factory()->create([
            'email' => 'remember@example.com',
            'password' => 'password',
        ]);

        $this->mock(LoginUserAction::class, function (MockInterface $mock) use ($user): void {
            $mock->shouldReceive('handle')
                ->once()
                ->with([
                    'email' => $user->email,
                    'password' => 'password',
                ], true)
                ->andReturn(to_route('app.home'));
        });

        Livewire::test(LoginComponent::class)
            ->set('email', $user->email)
            ->set('password', 'password')
            ->set('remember', true)
            ->call('login')
            ->assertHasNoErrors();
    }

    public function test_register_component_delegates_submission_to_the_register_action(): void
    {
        $this->mock(RegisterUserAction::class, function (MockInterface $mock): void {
            $mock->shouldReceive('handle')
                ->once()
                ->with([
                    'name' => 'Taylor Otwell',
                    'email' => 'taylor@example.com',
                    'password' => 'password',
                    'password_confirmation' => 'password',
                ])
                ->andReturn(to_route('app.home'));
        });

        Livewire::test(RegisterComponent::class)
            ->set('name', 'Taylor Otwell')
            ->set('email', 'taylor@example.com')
            ->set('password', 'password')
            ->set('passwordConfirmation', 'password')
            ->call('register')
            ->assertHasNoErrors();
    }

    public function test_forgot_password_component_delegates_submission_to_the_send_reset_action(): void
    {
        $user = User::factory()->create([
            'email' => 'reset@example.com',
        ]);

        $status = 'Reset link sent.';

        $this->mock(SendPasswordResetAction::class, function (MockInterface $mock) use ($user, $status): void {
            $mock->shouldReceive('handle')
                ->once()
                ->with($user->email)
                ->andReturn($status);
        });

        Livewire::test(ForgotPasswordComponent::class)
            ->set('email', $user->email)
            ->call('sendResetLink')
            ->assertHasNoErrors()
            ->assertSet('status', $status);
    }

    public function test_logout_route_delegates_to_the_logout_action(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->mock(LogoutUserAction::class, function (MockInterface $mock): void {
            $mock->shouldReceive('handle')
                ->once()
                ->withArgs(fn ($request) => $request->routeIs('logout'))
                ->andReturn(to_route('login'));
        });

        $this->post(route('logout'))
            ->assertRedirect(route('login'));
    }
}
