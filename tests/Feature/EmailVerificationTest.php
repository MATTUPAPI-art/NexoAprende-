<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\URL;
use Tests\TestCase;

class EmailVerificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_unverified_user_can_open_verification_page(): void
    {
        $user = User::factory()
            ->unverified()
            ->create();

        $this->actingAs($user)
            ->get(route('verification.notice'))
            ->assertOk()
            ->assertSee('Verifica tu correo electrónico');
    }

    public function test_user_can_request_another_verification_email(): void
    {
        Notification::fake();

        $user = User::factory()
            ->unverified()
            ->create();

        $this->actingAs($user)
            ->post(route('verification.send'))
            ->assertSessionHas(
                'status',
                'verification-link-sent'
            );

        Notification::assertSentTo(
            $user,
            VerifyEmail::class
        );
    }

    public function test_email_can_be_verified_with_valid_link(): void
    {
        $user = User::factory()
            ->unverified()
            ->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1(
                    $user->getEmailForVerification()
                ),
            ]
        );

        $this->actingAs($user)
            ->get($verificationUrl)
            ->assertRedirect();

        $this->assertTrue(
            $user->fresh()->hasVerifiedEmail()
        );
    }

    public function test_invalid_hash_does_not_verify_email(): void
    {
        $user = User::factory()
            ->unverified()
            ->create();

        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1('correo-invalido'),
            ]
        );

        $this->actingAs($user)
            ->get($verificationUrl)
            ->assertForbidden();

        $this->assertFalse(
            $user->fresh()->hasVerifiedEmail()
        );
    }

    public function test_professional_registration_sends_verification(): void
    {
        Notification::fake();

        $this->post(
            route('professional.register.store'),
            [
                'name' => 'Profesional de prueba',
                'email' => 'profesional@example.com',
                'password' => 'ClaveSegura123!',
                'password_confirmation' => 'ClaveSegura123!',
                'specialty' => 'Psicopedagogía',
                'license_number' => 'REG-VERIFICACION-001',
                'years_experience' => 5,
                'biography' => 'Perfil profesional de prueba.',
            ]
        )->assertSessionHasNoErrors();

        $professional = User::query()
            ->where('email', 'profesional@example.com')
            ->firstOrFail();

        Notification::assertSentTo(
            $professional,
            VerifyEmail::class
        );
    }
    public function test_unverified_user_cannot_open_private_panel(): void
{
    $user = User::factory()
        ->unverified()
        ->create();

    $this->actingAs($user)
        ->get(route('dashboard'))
        ->assertRedirect(route('verification.notice'));
}
}
