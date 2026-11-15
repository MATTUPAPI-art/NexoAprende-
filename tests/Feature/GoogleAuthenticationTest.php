<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class GoogleAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_google_redirect_is_available_to_guests(): void
    {
        Socialite::fake('google');

        $this->get(route('auth.google.redirect'))
            ->assertRedirect();
    }

    public function test_professional_google_redirect_is_available_to_guests(): void
    {
        Socialite::fake('google');

        $this->get(route('auth.google.professional.redirect'))
            ->assertRedirect()
            ->assertSessionHas(
                'google_account_type',
                'professional'
            );
    }

    public function test_new_google_user_is_sent_to_completion_form(): void
    {
        Socialite::fake(
            'google',
            $this->googleUser(
                id: 'google-new-123',
                email: 'madre@example.com',
                name: 'María Pérez'
            )
        );

        $response = $this->get(
            route('auth.google.callback')
        );

        $response
            ->assertRedirect(route('auth.google.complete'))
            ->assertSessionHas(
                'google_registration',
                function (array $registration): bool {
                    return $registration['google_id']
                            === 'google-new-123'
                        && $registration['email']
                            === 'madre@example.com'
                        && $registration['name']
                            === 'María Pérez'
                        && $registration['account_type']
                            === 'tutor';
                }
            );

        $this->assertGuest();

        $this->assertDatabaseMissing('users', [
            'email' => 'madre@example.com',
        ]);
    }

    public function test_new_professional_google_user_keeps_account_type(): void
    {
        Socialite::fake(
            'google',
            $this->googleUser(
                id: 'google-professional-123',
                email: 'profesional@example.com',
                name: 'Laura Profesional'
            )
        );

        $response = $this
            ->withSession([
                'google_account_type' => 'professional',
            ])
            ->get(route('auth.google.callback'));

        $response
            ->assertRedirect(route('auth.google.complete'))
            ->assertSessionHas(
                'google_registration',
                function (array $registration): bool {
                    return $registration['google_id']
                            === 'google-professional-123'
                        && $registration['email']
                            === 'profesional@example.com'
                        && $registration['account_type']
                            === 'professional';
                }
            );

        $this->assertGuest();

        $this->assertDatabaseMissing('users', [
            'email' => 'profesional@example.com',
        ]);
    }

    public function test_professional_completion_form_displays_professional_fields(): void
    {
        $pendingRegistration = [
            'google_id' => 'google-professional-form',
            'name' => 'Profesional de prueba',
            'email' => 'profesional-form@example.com',
            'avatar_url' => 'https://example.com/avatar.png',
            'account_type' => 'professional',
        ];

        $this
            ->withSession([
                'google_registration' => $pendingRegistration,
            ])
            ->get(route('auth.google.complete'))
            ->assertOk()
            ->assertSee('Completa tu perfil profesional')
            ->assertSee('Especialidad')
            ->assertSee('Número de matrícula')
            ->assertSee('Años de experiencia')
            ->assertSee('Presentación profesional');
    }

    public function test_google_registration_creates_verified_tutor(): void
    {
        $pendingRegistration = [
            'google_id' => 'google-parent-456',
            'name' => 'Padre de familia',
            'email' => 'padre@example.com',
            'avatar_url' => 'https://example.com/avatar.png',
            'account_type' => 'tutor',
        ];

        $response = $this
            ->withSession([
                'google_registration' => $pendingRegistration,
            ])
            ->post(
                route('auth.google.complete.store'),
                [
                    'name' => 'Carlos Mendoza',
                    'password' => 'Clave-segura-2026',
                    'password_confirmation' => 'Clave-segura-2026',
                    'terms' => '1',
                ]
            );

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard'));

        $user = User::query()
            ->where('email', 'padre@example.com')
            ->firstOrFail();

        $this->assertAuthenticatedAs($user);
        $this->assertSame('tutor', $user->role);

        $this->assertSame(
            'google-parent-456',
            $user->google_id
        );

        $this->assertNotNull(
            $user->email_verified_at
        );

        $this->assertTrue(
            Hash::check(
                'Clave-segura-2026',
                $user->password
            )
        );

        $this->assertFalse(
            session()->has('google_registration')
        );
    }

    public function test_google_registration_creates_verified_professional(): void
    {
        $pendingRegistration = [
            'google_id' => 'google-professional-456',
            'name' => 'Profesional de Google',
            'email' => 'psicopedagoga@example.com',
            'avatar_url' => 'https://example.com/professional.png',
            'account_type' => 'professional',
        ];

        $response = $this
            ->withSession([
                'google_registration' => $pendingRegistration,
            ])
            ->post(
                route('auth.google.complete.store'),
                [
                    'name' => 'Andrea Salazar',
                    'specialty' => 'Psicopedagogía',
                    'license_number' => 'PSP-GOOGLE-001',
                    'years_experience' => 6,
                    'biography' => 'Experiencia en apoyo educativo infantil.',
                    'password' => 'Clave-profesional-2026',
                    'password_confirmation' => 'Clave-profesional-2026',
                    'terms' => '1',
                ]
            );

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(
                route('professional.dashboard')
            );

        $professional = User::query()
            ->where(
                'email',
                'psicopedagoga@example.com'
            )
            ->firstOrFail();

        $this->assertAuthenticatedAs($professional);

        $this->assertSame(
            'professional',
            $professional->role
        );

        $this->assertSame(
            'google-professional-456',
            $professional->google_id
        );

        $this->assertNotNull(
            $professional->email_verified_at
        );

        $this->assertTrue(
            Hash::check(
                'Clave-profesional-2026',
                $professional->password
            )
        );

        $this->assertDatabaseHas(
            'professional_profiles',
            [
                'user_id' => $professional->id,
                'specialty' => 'Psicopedagogía',
                'license_number' => 'PSP-GOOGLE-001',
                'years_experience' => 6,
                'biography' =>
                    'Experiencia en apoyo educativo infantil.',
            ]
        );

        $this->assertFalse(
            session()->has('google_registration')
        );
    }

    public function test_existing_user_can_login_with_matching_google_email(): void
    {
        $user = User::factory()
            ->unverified()
            ->create([
                'email' => 'tutor@example.com',
                'role' => 'tutor',
                'google_id' => null,
            ]);

        Socialite::fake(
            'google',
            $this->googleUser(
                id: 'google-existing-789',
                email: 'tutor@example.com',
                name: 'Tutor existente'
            )
        );

        $response = $this->get(
            route('auth.google.callback')
        );

        $response->assertRedirect(route('dashboard'));

        $user->refresh();

        $this->assertAuthenticatedAs($user);

        $this->assertSame(
            'google-existing-789',
            $user->google_id
        );

        $this->assertNotNull(
            $user->email_verified_at
        );
    }

    public function test_existing_professional_keeps_professional_role(): void
    {
        $professional = User::factory()
            ->unverified()
            ->create([
                'email' => 'existing-professional@example.com',
                'role' => 'professional',
                'google_id' => null,
            ]);

        $professional->professionalProfile()->create([
            'specialty' => 'Psicología educativa',
            'license_number' => 'PSI-EXISTING-001',
            'years_experience' => 4,
            'biography' => 'Profesional previamente registrado.',
        ]);

        Socialite::fake(
            'google',
            $this->googleUser(
                id: 'google-existing-professional',
                email: 'existing-professional@example.com',
                name: 'Profesional existente'
            )
        );

        $response = $this
            ->withSession([
                'google_account_type' => 'professional',
            ])
            ->get(route('auth.google.callback'));

        $response->assertRedirect(
            route('professional.dashboard')
        );

        $professional->refresh();

        $this->assertAuthenticatedAs($professional);

        $this->assertSame(
            'professional',
            $professional->role
        );

        $this->assertSame(
            'google-existing-professional',
            $professional->google_id
        );

        $this->assertNotNull(
            $professional->email_verified_at
        );

        $this->assertDatabaseHas(
            'professional_profiles',
            [
                'user_id' => $professional->id,
                'license_number' => 'PSI-EXISTING-001',
            ]
        );
    }

    public function test_google_cannot_replace_another_google_identity(): void
    {
        User::factory()->create([
            'email' => 'protegido@example.com',
            'google_id' => 'original-google-id',
        ]);

        Socialite::fake(
            'google',
            $this->googleUser(
                id: 'different-google-id',
                email: 'protegido@example.com',
                name: 'Intento diferente'
            )
        );

        $response = $this->get(
            route('auth.google.callback')
        );

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('google');

        $this->assertGuest();

        $this->assertDatabaseHas('users', [
            'email' => 'protegido@example.com',
            'google_id' => 'original-google-id',
        ]);
    }

    public function test_unverified_google_email_is_rejected(): void
    {
        Socialite::fake(
            'google',
            $this->googleUser(
                id: 'google-unverified-123',
                email: 'unverified@example.com',
                name: 'Correo no verificado',
                verified: false
            )
        );

        $response = $this->get(
            route('auth.google.callback')
        );

        $response
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('google');

        $this->assertGuest();

        $this->assertDatabaseMissing('users', [
            'email' => 'unverified@example.com',
        ]);
    }

    public function test_completion_requires_pending_google_session(): void
    {
        $this->get(route('auth.google.complete'))
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('google');

        $this->post(
            route('auth.google.complete.store'),
            [
                'name' => 'Usuario inválido',
                'password' => 'Clave-segura-2026',
                'password_confirmation' =>
                    'Clave-segura-2026',
                'terms' => '1',
            ]
        )
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('google');

        $this->assertGuest();
    }

    private function googleUser(
        string $id,
        string $email,
        string $name,
        bool $verified = true
    ): SocialiteUser {
        return (new SocialiteUser())
            ->map([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'avatar' =>
                    'https://example.com/avatar.png',
            ])
            ->setRaw([
                'id' => $id,
                'name' => $name,
                'email' => $email,
                'verified_email' => $verified,
                'picture' =>
                    'https://example.com/avatar.png',
            ]);
    }
}
