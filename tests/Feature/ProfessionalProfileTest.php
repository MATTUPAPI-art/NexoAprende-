<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfessionalProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_open_professional_registration(): void
    {
        $this->get(route('professional.register'))
            ->assertOk()
            ->assertSee('Crear cuenta profesional');
    }

    public function test_guest_can_register_as_professional(): void
    {
        $response = $this->post(
            route('professional.register.store'),
            [
                'name' => 'Ana Profesional',
                'email' => 'ana@example.com',
                'specialty' => 'Psicopedagogía',
                'license_number' => 'PSP-2026-001',
                'years_experience' => 5,
                'biography' => 'Experiencia en acompañamiento educativo.',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ]
        );

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('professional.dashboard'));

        $this->assertAuthenticated();

        $this->assertDatabaseHas('users', [
            'email' => 'ana@example.com',
            'role' => 'professional',
        ]);

        $this->assertDatabaseHas('professional_profiles', [
            'specialty' => 'Psicopedagogía',
            'license_number' => 'PSP-2026-001',
            'years_experience' => 5,
            'verified' => false,
        ]);
    }

    public function test_professional_can_open_own_dashboard(): void
    {
        $professional = User::factory()
            ->professional()
            ->create();

        $professional->professionalProfile()->create([
            'specialty' => 'Psicología educativa',
            'license_number' => 'PSI-2026-002',
            'years_experience' => 4,
            'biography' => 'Acompañamiento educativo infantil.',
        ]);

        $this->actingAs($professional)
            ->get(route('professional.dashboard'))
            ->assertOk()
            ->assertSee('Panel profesional')
            ->assertSee('Psicología educativa')
            ->assertSee('Verificación pendiente');
    }

    public function test_tutor_cannot_open_professional_dashboard(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $this->actingAs($tutor)
            ->get(route('professional.dashboard'))
            ->assertForbidden();
    }

    public function test_professional_is_redirected_from_general_panel(): void
    {
        $professional = User::factory()
            ->professional()
            ->create();

        $professional->professionalProfile()->create([
            'specialty' => 'Fonoaudiología',
            'license_number' => 'FON-2026-003',
            'years_experience' => 3,
        ]);

        $this->actingAs($professional)
            ->get(route('dashboard'))
            ->assertRedirect(route('professional.dashboard'));
    }

    public function test_professional_cannot_create_child_profile(): void
    {
        $professional = User::factory()
            ->professional()
            ->create();

        $this->actingAs($professional)
            ->post(route('child-profiles.store'), [
                'name' => 'Perfil no autorizado',
                'age' => 9,
            ])
            ->assertForbidden();

        $this->assertDatabaseMissing('child_profiles', [
            'name' => 'Perfil no autorizado',
        ]);
    }
}
