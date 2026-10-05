<?php

namespace Tests\Feature;

use App\Models\ProfessionalProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfessionalAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_tutor_can_open_professional_management_for_own_child(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $child = $tutor->childProfiles()->create([
            'name' => 'Pepito',
            'age' => 10,
        ]);

        [$professional] = $this->createProfessional(
            'Profesional disponible',
            'MAT-001'
        );

        $this->actingAs($tutor)
            ->get(route(
                'child-profiles.professionals',
                $child
            ))
            ->assertOk()
            ->assertSee('Pepito')
            ->assertSee($professional->name)
            ->assertSee('Autorizar');
    }

    public function test_tutor_can_authorize_professional(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $child = $tutor->childProfiles()->create([
            'name' => 'Pepito',
            'age' => 10,
        ]);

        [, $professionalProfile] = $this->createProfessional(
            'Profesional autorizado',
            'MAT-002'
        );

        $this->actingAs($tutor)
            ->post(
                route(
                    'child-profiles.professionals.store',
                    $child
                ),
                [
                    'professional_profile_id' => (
                        $professionalProfile->id
                    ),
                ]
            )
            ->assertSessionHasNoErrors()
            ->assertRedirect(route(
                'child-profiles.professionals',
                $child
            ));

        $this->assertDatabaseHas(
            'child_profile_professional',
            [
                'child_profile_id' => $child->id,
                'professional_profile_id' => (
                    $professionalProfile->id
                ),
            ]
        );
    }

    public function test_tutor_can_remove_professional_authorization(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $child = $tutor->childProfiles()->create([
            'name' => 'Pepito',
            'age' => 10,
        ]);

        [, $professionalProfile] = $this->createProfessional(
            'Profesional removido',
            'MAT-003'
        );

        $child->professionals()->attach(
            $professionalProfile->id
        );

        $this->actingAs($tutor)
            ->delete(route(
                'child-profiles.professionals.destroy',
                [
                    $child,
                    $professionalProfile,
                ]
            ))
            ->assertRedirect(route(
                'child-profiles.professionals',
                $child
            ));

        $this->assertDatabaseMissing(
            'child_profile_professional',
            [
                'child_profile_id' => $child->id,
                'professional_profile_id' => (
                    $professionalProfile->id
                ),
            ]
        );
    }

    public function test_tutor_cannot_manage_another_tutors_child(): void
    {
        $firstTutor = User::factory()
            ->tutor()
            ->create();

        $secondTutor = User::factory()
            ->tutor()
            ->create();

        $otherChild = $secondTutor->childProfiles()->create([
            'name' => 'Perfil ajeno',
            'age' => 8,
        ]);

        $this->actingAs($firstTutor)
            ->get(route(
                'child-profiles.professionals',
                $otherChild
            ))
            ->assertNotFound();
    }

    public function test_professional_sees_authorized_child_on_dashboard(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $child = $tutor->childProfiles()->create([
            'name' => 'Niño autorizado',
            'age' => 9,
        ]);

        [$professional, $professionalProfile] = (
            $this->createProfessional(
                'Profesional asignado',
                'MAT-004'
            )
        );

        $child->professionals()->attach(
            $professionalProfile->id
        );

        $this->actingAs($professional)
            ->get(route('professional.dashboard'))
            ->assertOk()
            ->assertSee('Niño autorizado')
            ->assertSee('Consultar progreso');
    }

    public function test_professional_can_view_authorized_child_progress(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $child = $tutor->childProfiles()->create([
            'name' => 'Perfil con progreso',
            'age' => 11,
        ]);

        $child->activityResults()->create([
            'activity_code' => 'reading-story',
            'correct_answers' => 5,
            'errors' => 1,
            'attempts' => 6,
            'duration_seconds' => 40,
            'level' => 1,
            'completed' => true,
        ]);

        [$professional, $professionalProfile] = (
            $this->createProfessional(
                'Profesional lector',
                'MAT-005'
            )
        );

        $child->professionals()->attach(
            $professionalProfile->id
        );

        $this->actingAs($professional)
            ->get(route(
                'professional.child-profiles.progress',
                $child
            ))
            ->assertOk()
            ->assertSee('Perfil con progreso')
            ->assertSee('Completa la historia')
            ->assertSee('5 / 5');
    }

    public function test_professional_cannot_view_unauthorized_child(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $child = $tutor->childProfiles()->create([
            'name' => 'Perfil privado',
            'age' => 7,
        ]);

        [$professional] = $this->createProfessional(
            'Profesional sin acceso',
            'MAT-006'
        );

        $this->actingAs($professional)
            ->get(route(
                'professional.child-profiles.progress',
                $child
            ))
            ->assertNotFound();
    }

    public function test_professional_cannot_grant_themselves_access(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $child = $tutor->childProfiles()->create([
            'name' => 'Perfil protegido',
            'age' => 8,
        ]);

        [$professional, $professionalProfile] = (
            $this->createProfessional(
                'Profesional sin permiso',
                'MAT-007'
            )
        );

        $this->actingAs($professional)
            ->post(
                route(
                    'child-profiles.professionals.store',
                    $child
                ),
                [
                    'professional_profile_id' => (
                        $professionalProfile->id
                    ),
                ]
            )
            ->assertForbidden();

        $this->assertDatabaseMissing(
            'child_profile_professional',
            [
                'child_profile_id' => $child->id,
                'professional_profile_id' => (
                    $professionalProfile->id
                ),
            ]
        );
    }

    /**
     * Crear una cuenta y su perfil profesional.
     *
     * @return array{0: User, 1: ProfessionalProfile}
     */
    private function createProfessional(
        string $name,
        string $licenseNumber
    ): array {
        $user = User::factory()
            ->professional()
            ->create([
                'name' => $name,
            ]);

        $profile = $user->professionalProfile()->create([
            'specialty' => 'Psicopedagogía',
            'license_number' => $licenseNumber,
            'years_experience' => 4,
            'biography' => 'Acompañamiento educativo infantil.',
        ]);

        return [$user, $profile];
    }
}
