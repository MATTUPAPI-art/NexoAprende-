<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class TurnstileProtectionTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.turnstile.site_key' => 'test-site-key',
            'services.turnstile.secret_key' => 'test-secret-key',
            'services.turnstile.verify_url' => 'https://challenges.cloudflare.com/turnstile/v0/siteverify',
        ]);
    }

    public function test_tutor_registration_displays_turnstile(): void
    {
        $this->get(route('register'))
            ->assertOk()
            ->assertSee('cf-turnstile', false)
            ->assertSee('test-site-key', false);
    }

    public function test_professional_registration_displays_turnstile(): void
    {
        $this->get(route('professional.register'))
            ->assertOk()
            ->assertSee('cf-turnstile', false)
            ->assertSee('test-site-key', false);
    }

    public function test_tutor_cannot_register_without_turnstile_token(): void
    {
        $response = $this->from(route('register'))
            ->post(route('register.store'), [
                'name' => 'Tutor sin captcha',
                'email' => 'tutor-sin-captcha@example.com',
                'password' => 'ClaveSegura123!',
                'password_confirmation' => 'ClaveSegura123!',
            ]);

        $response
            ->assertRedirect(route('register'))
            ->assertSessionHasErrors('cf-turnstile-response');

        $this->assertDatabaseMissing('users', [
            'email' => 'tutor-sin-captcha@example.com',
        ]);
    }

    public function test_professional_cannot_register_without_turnstile_token(): void
    {
        $response = $this->from(route('professional.register'))
            ->post(
                route('professional.register.store'),
                $this->professionalData()
            );

        $response
            ->assertRedirect(route('professional.register'))
            ->assertSessionHasErrors('cf-turnstile-response');

        $this->assertDatabaseMissing('users', [
            'email' => 'profesional-turnstile@example.com',
        ]);
    }

    public function test_invalid_turnstile_token_is_rejected(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response([
                'success' => false,
                'error-codes' => ['invalid-input-response'],
            ], 200),
        ]);

        $response = $this->from(route('professional.register'))
            ->post(
                route('professional.register.store'),
                array_merge(
                    $this->professionalData(),
                    [
                        'cf-turnstile-response' => 'invalid-test-token',
                    ]
                )
            );

        $response
            ->assertRedirect(route('professional.register'))
            ->assertSessionHasErrors('cf-turnstile-response');

        $this->assertDatabaseMissing('users', [
            'email' => 'profesional-turnstile@example.com',
        ]);

        Http::assertSentCount(1);
    }

    public function test_valid_turnstile_token_allows_professional_registration(): void
    {
        Http::fake([
            'challenges.cloudflare.com/*' => Http::response([
                'success' => true,
            ], 200),
        ]);

        $response = $this->post(
            route('professional.register.store'),
            array_merge(
                $this->professionalData(),
                [
                    'cf-turnstile-response' => 'valid-test-token',
                ]
            )
        );

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('verification.notice'));

        $this->assertDatabaseHas('users', [
            'email' => 'profesional-turnstile@example.com',
            'role' => 'professional',
        ]);

        $this->assertDatabaseHas('professional_profiles', [
            'license_number' => 'TURNSTILE-TEST-001',
        ]);

        Http::assertSentCount(1);
    }

    private function professionalData(): array
    {
        return [
            'name' => 'Profesional Turnstile',
            'email' => 'profesional-turnstile@example.com',
            'password' => 'ClaveSegura123!',
            'password_confirmation' => 'ClaveSegura123!',
            'specialty' => 'Psicopedagogía',
            'license_number' => 'TURNSTILE-TEST-001',
            'years_experience' => 5,
            'biography' => 'Perfil utilizado para probar la protección Turnstile.',
        ];
    }
}
