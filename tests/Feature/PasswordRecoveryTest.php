<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordRecoveryTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_forgot_password_form(): void
    {
        $this->get(route('password.request'))
            ->assertOk()
            ->assertSee('Recupera tu contraseña');
    }

    public function test_login_page_contains_recovery_link(): void
    {
        $this->get(route('login'))
            ->assertOk()
            ->assertSee(route('password.request'));
    }

    public function test_reset_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('password.email'), [
            'email' => $user->email,
        ])->assertSessionHasNoErrors();

        Notification::assertSentTo(
            $user,
            ResetPassword::class
        );
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post(route('password.email'), [
            'email' => $user->email,
        ]);

        Notification::assertSentTo(
            $user,
            ResetPassword::class,
            function (ResetPassword $notification) use ($user) {
                $response = $this->post(
                    route('password.update'),
                    [
                        'token' => $notification->token,
                        'email' => $user->email,
                        'password' => 'NuevaClaveSegura123!',
                        'password_confirmation' =>
                            'NuevaClaveSegura123!',
                    ]
                );

                $response
                    ->assertSessionHasNoErrors()
                    ->assertRedirect(route('login'));

                $this->assertTrue(
                    Hash::check(
                        'NuevaClaveSegura123!',
                        $user->fresh()->password
                    )
                );

                return true;
            }
        );
    }
}
