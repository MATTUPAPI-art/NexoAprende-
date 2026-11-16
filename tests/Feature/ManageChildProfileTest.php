<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ManageChildProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_child_profile_edit_form(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Perfil protegido',
            'age' => 9,
        ]);

        $this->get(
            route('child-profiles.edit', $profile)
        )->assertRedirect(route('login'));
    }

    public function test_tutor_can_open_own_child_profile_edit_form(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Lucía',
            'age' => 10,
        ]);

        $this->actingAs($tutor)
            ->get(route('child-profiles.edit', $profile))
            ->assertOk()
            ->assertSee('Lucía');
    }

    public function test_tutor_can_update_own_child_profile(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Nombre anterior',
            'age' => 8,
        ]);

        $response = $this
            ->actingAs($tutor)
            ->put(
                route('child-profiles.update', $profile),
                [
                    'name' => 'Nombre actualizado',
                    'age' => 11,
                ]
            );

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas(
                'success',
                'Perfil actualizado correctamente.'
            );

        $this->assertDatabaseHas('child_profiles', [
            'id' => $profile->id,
            'user_id' => $tutor->id,
            'name' => 'Nombre actualizado',
            'age' => 11,
        ]);
    }

    public function test_child_profile_update_validates_name_and_age(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Perfil original',
            'age' => 10,
        ]);

        $response = $this
            ->actingAs($tutor)
            ->from(route('child-profiles.edit', $profile))
            ->put(
                route('child-profiles.update', $profile),
                [
                    'name' => '',
                    'age' => 19,
                ]
            );

        $response
            ->assertRedirect(
                route('child-profiles.edit', $profile)
            )
            ->assertSessionHasErrors([
                'name',
                'age',
            ]);

        $this->assertDatabaseHas('child_profiles', [
            'id' => $profile->id,
            'name' => 'Perfil original',
            'age' => 10,
        ]);
    }

    public function test_tutor_cannot_edit_another_tutors_child_profile(): void
    {
        $owner = User::factory()
            ->tutor()
            ->create();

        $otherTutor = User::factory()
            ->tutor()
            ->create();

        $profile = $owner->childProfiles()->create([
            'name' => 'Perfil de otro tutor',
            'age' => 12,
        ]);

        $this->actingAs($otherTutor)
            ->get(route('child-profiles.edit', $profile))
            ->assertNotFound();
    }

    public function test_tutor_cannot_update_another_tutors_child_profile(): void
    {
        $owner = User::factory()
            ->tutor()
            ->create();

        $otherTutor = User::factory()
            ->tutor()
            ->create();

        $profile = $owner->childProfiles()->create([
            'name' => 'Perfil protegido',
            'age' => 9,
        ]);

        $this->actingAs($otherTutor)
            ->put(
                route('child-profiles.update', $profile),
                [
                    'name' => 'Intento no autorizado',
                    'age' => 15,
                ]
            )
            ->assertNotFound();

        $this->assertDatabaseHas('child_profiles', [
            'id' => $profile->id,
            'user_id' => $owner->id,
            'name' => 'Perfil protegido',
            'age' => 9,
        ]);
    }

    public function test_tutor_can_open_delete_confirmation_for_own_profile(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Perfil para eliminar',
            'age' => 7,
        ]);

        $this->actingAs($tutor)
            ->get(route('child-profiles.delete', $profile))
            ->assertOk()
            ->assertSee('Perfil para eliminar');
    }

    public function test_wrong_password_does_not_delete_child_profile(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create([
                'password' => Hash::make(
                    'Clave-correcta-2026'
                ),
            ]);

        $profile = $tutor->childProfiles()->create([
            'name' => 'Perfil conservado',
            'age' => 10,
        ]);

        $response = $this
            ->actingAs($tutor)
            ->from(route('child-profiles.delete', $profile))
            ->delete(
                route('child-profiles.destroy', $profile),
                [
                    'password' => 'Clave-incorrecta',
                ]
            );

        $response
            ->assertRedirect(
                route('child-profiles.delete', $profile)
            )
            ->assertSessionHasErrors('password');

        $this->assertDatabaseHas('child_profiles', [
            'id' => $profile->id,
            'name' => 'Perfil conservado',
        ]);
    }

    public function test_tutor_can_delete_own_child_profile_with_password(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create([
                'password' => Hash::make(
                    'Clave-correcta-2026'
                ),
            ]);

        $profile = $tutor->childProfiles()->create([
            'name' => 'Perfil eliminado',
            'age' => 13,
        ]);

        $response = $this
            ->actingAs($tutor)
            ->delete(
                route('child-profiles.destroy', $profile),
                [
                    'password' => 'Clave-correcta-2026',
                ]
            );

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard'))
            ->assertSessionHas(
                'success',
                'El perfil de Perfil eliminado fue eliminado.'
            );

        $this->assertDatabaseMissing('child_profiles', [
            'id' => $profile->id,
        ]);
    }

    public function test_tutor_cannot_delete_another_tutors_child_profile(): void
    {
        $owner = User::factory()
            ->tutor()
            ->create();

        $otherTutor = User::factory()
            ->tutor()
            ->create([
                'password' => Hash::make(
                    'Clave-otro-tutor-2026'
                ),
            ]);

        $profile = $owner->childProfiles()->create([
            'name' => 'Perfil protegido',
            'age' => 11,
        ]);

        $this->actingAs($otherTutor)
            ->delete(
                route('child-profiles.destroy', $profile),
                [
                    'password' => 'Clave-otro-tutor-2026',
                ]
            )
            ->assertNotFound();

        $this->assertDatabaseHas('child_profiles', [
            'id' => $profile->id,
            'user_id' => $owner->id,
        ]);
    }

    public function test_professional_cannot_manage_child_profiles(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $professional = User::factory()
            ->professional()
            ->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Perfil del tutor',
            'age' => 8,
        ]);

        $this->actingAs($professional)
            ->get(route('child-profiles.edit', $profile))
            ->assertForbidden();

        $this->actingAs($professional)
            ->put(
                route('child-profiles.update', $profile),
                [
                    'name' => 'Intento profesional',
                    'age' => 12,
                ]
            )
            ->assertForbidden();

        $this->actingAs($professional)
            ->get(route('child-profiles.delete', $profile))
            ->assertForbidden();

        $this->actingAs($professional)
            ->delete(
                route('child-profiles.destroy', $profile),
                [
                    'password' => 'password',
                ]
            )
            ->assertForbidden();

        $this->assertDatabaseHas('child_profiles', [
            'id' => $profile->id,
            'user_id' => $tutor->id,
            'name' => 'Perfil del tutor',
        ]);
    }
}
