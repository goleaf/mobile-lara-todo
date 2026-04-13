<?php

namespace Tests\Unit\Actions\Auth;

use App\Actions\Auth\LoginUserAction;
use App\Actions\Auth\LogoutUserAction;
use App\Actions\Auth\RegisterUserAction;
use App\Actions\Auth\SendPasswordResetAction;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class AuthActionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_user_action_authenticates_regenerates_the_session_and_sets_remember_token(): void
    {
        $user = User::factory()->create([
            'email' => 'remember@example.com',
            'password' => 'password',
        ]);

        session()->start();

        $previousSessionId = session()->getId();

        $response = app(LoginUserAction::class)->handle([
            'email' => $user->email,
            'password' => 'password',
        ], true);

        $this->assertAuthenticatedAs($user);
        $this->assertSame(route('app.home'), $response->getTargetUrl());
        $this->assertNotSame($previousSessionId, session()->getId());
        $this->assertNotNull($user->fresh()->remember_token);
    }

    public function test_login_user_action_throws_a_validation_exception_for_invalid_credentials(): void
    {
        User::factory()->create([
            'email' => 'remember@example.com',
            'password' => 'password',
        ]);

        try {
            app(LoginUserAction::class)->handle([
                'email' => 'remember@example.com',
                'password' => 'wrong-password',
            ]);

            $this->fail('Expected the login action to throw a validation exception.');
        } catch (ValidationException $exception) {
            $this->assertSame([
                'email' => [__('auth.failed')],
            ], $exception->errors());
        }

        $this->assertGuest();
    }

    public function test_register_user_action_creates_the_user_hashes_the_password_fires_registered_and_logs_in(): void
    {
        Event::fake([Registered::class]);

        session()->start();

        $previousSessionId = session()->getId();

        $response = app(RegisterUserAction::class)->handle([
            'name' => 'Taylor Otwell',
            'email' => 'taylor@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);

        $user = User::query()
            ->where('email', 'taylor@example.com')
            ->firstOrFail();

        $this->assertAuthenticatedAs($user);
        $this->assertSame(route('app.home'), $response->getTargetUrl());
        $this->assertNotSame($previousSessionId, session()->getId());
        $this->assertTrue(Hash::check('password', $user->password));
        $this->assertNotSame('password', $user->password);

        Event::assertDispatched(Registered::class, fn (Registered $event): bool => $event->user->is($user));
    }

    public function test_logout_user_action_logs_out_invalidates_the_session_and_regenerates_the_csrf_token(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $session = app('session.store');

        $session->start();

        $previousSessionId = $session->getId();
        $previousToken = $session->token();

        $request = Request::create(route('logout'), 'POST');
        $request->setLaravelSession($session);

        $response = app(LogoutUserAction::class)->handle($request);

        $this->assertGuest();
        $this->assertSame(route('login'), $response->getTargetUrl());
        $this->assertNotSame($previousSessionId, $session->getId());
        $this->assertNotSame($previousToken, $session->token());
    }

    public function test_send_password_reset_action_sends_the_reset_link_and_returns_the_translated_status_message(): void
    {
        Notification::fake();

        $user = User::factory()->create([
            'email' => 'reset@example.com',
        ]);

        $status = app(SendPasswordResetAction::class)->handle($user->email);

        $this->assertSame(__(Password::RESET_LINK_SENT), $status);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    public function test_send_password_reset_action_throws_a_validation_exception_when_the_broker_rejects_the_email(): void
    {
        try {
            app(SendPasswordResetAction::class)->handle('missing@example.com');

            $this->fail('Expected the password reset action to throw a validation exception.');
        } catch (ValidationException $exception) {
            $this->assertSame([
                'email' => [__(Password::INVALID_USER)],
            ], $exception->errors());
        }
    }
}
