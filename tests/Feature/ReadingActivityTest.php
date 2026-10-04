<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadingActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_tutor_can_open_reading_activity_for_own_profile(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Pepito',
            'age' => 10,
        ]);

        $this->actingAs($tutor)
            ->get(route(
                'child-profiles.activities.reading',
                $profile
            ))
            ->assertOk()
            ->assertSee('Completa la historia')
            ->assertSee('Pepito');
    }

    public function test_tutor_cannot_open_reading_activity_for_other_profile(): void
    {
        $firstTutor = User::factory()
            ->tutor()
            ->create();

        $secondTutor = User::factory()
            ->tutor()
            ->create();

        $otherProfile = $secondTutor->childProfiles()->create([
            'name' => 'Perfil ajeno',
            'age' => 9,
        ]);

        $this->actingAs($firstTutor)
            ->get(route(
                'child-profiles.activities.reading',
                $otherProfile
            ))
            ->assertNotFound();
    }

    public function test_tutor_can_store_reading_activity_result(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Pepito',
            'age' => 10,
        ]);

        $this->actingAs($tutor)
            ->postJson(route('activity-results.store'), [
                'child_profile_id' => $profile->id,
                'activity_code' => 'reading-story',
                'correct_answers' => 5,
                'errors' => 2,
                'duration_seconds' => 43,
                'level' => 1,
            ])
            ->assertCreated()
            ->assertJson([
                'message' => 'Resultado guardado correctamente.',
            ]);

        $this->assertDatabaseHas('activity_results', [
            'child_profile_id' => $profile->id,
            'activity_code' => 'reading-story',
            'correct_answers' => 5,
            'errors' => 2,
            'attempts' => 7,
            'duration_seconds' => 43,
            'level' => 1,
            'completed' => true,
        ]);
    }

    public function test_professional_cannot_open_reading_activity(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $professional = User::factory()
            ->professional()
            ->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Perfil protegido',
            'age' => 8,
        ]);

        $this->actingAs($professional)
            ->get(route(
                'child-profiles.activities.reading',
                $profile
            ))
            ->assertForbidden();
    }
}
