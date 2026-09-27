<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChildProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_tutor_dashboard(): void
    {
        $response = $this->get(route('dashboard'));

        $response->assertRedirect(route('login'));
    }

    public function test_guest_cannot_open_profile_form(): void
    {
        $response = $this->get(
            route('child-profiles.create')
        );

        $response->assertRedirect(route('login'));
    }

    public function test_tutor_can_create_child_profile(): void
    {
        $tutor = User::factory()->create();

        $response = $this
            ->actingAs($tutor)
            ->post(route('child-profiles.store'), [
                'name' => 'Mateo',
                'age' => 8,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('child_profiles', [
            'user_id' => $tutor->id,
            'name' => 'Mateo',
            'age' => 8,
        ]);
    }

    public function test_child_age_must_be_between_6_and_13(): void
    {
        $tutor = User::factory()->create();

        $response = $this
            ->actingAs($tutor)
            ->post(route('child-profiles.store'), [
                'name' => 'Perfil de prueba',
                'age' => 5,
            ]);

        $response->assertSessionHasErrors('age');

        $this->assertDatabaseMissing('child_profiles', [
            'user_id' => $tutor->id,
            'name' => 'Perfil de prueba',
        ]);
    }

    public function test_tutor_only_sees_their_own_profiles(): void
    {
        $firstTutor = User::factory()->create();
        $secondTutor = User::factory()->create();

        $firstTutor->childProfiles()->create([
            'name' => 'Perfil propio',
            'age' => 9,
        ]);

        $secondTutor->childProfiles()->create([
            'name' => 'Perfil ajeno',
            'age' => 10,
        ]);

        $response = $this
            ->actingAs($firstTutor)
            ->get(route('dashboard'));

        $response
            ->assertOk()
            ->assertSee('Perfil propio')
            ->assertDontSee('Perfil ajeno');
    }
}
