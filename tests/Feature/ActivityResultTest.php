<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ActivityResultTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_store_activity_results(): void
    {
        $response = $this->postJson(
            route('activity-results.store'),
            $this->validResultData(1)
        );

        $response->assertUnauthorized();
    }

    public function test_tutor_can_store_result_for_their_own_child_profile(): void
    {
        $tutor = User::factory()->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Pepito',
            'age' => 10,
        ]);

        $response = $this
            ->actingAs($tutor)
            ->postJson(
                route('activity-results.store'),
                $this->validResultData($profile->id)
            );

        $response
            ->assertCreated()
            ->assertJson([
                'message' => 'Resultado guardado correctamente.',
            ]);

        $this->assertDatabaseHas('activity_results', [
            'child_profile_id' => $profile->id,
            'activity_code' => 'attention-dogs',
            'correct_answers' => 4,
            'errors' => 2,
            'attempts' => 6,
            'duration_seconds' => 15,
            'level' => 1,
            'completed' => true,
        ]);
    }

    public function test_tutor_cannot_store_result_for_another_tutors_profile(): void
    {
        $tutor = User::factory()->create();
        $otherTutor = User::factory()->create();

        $otherProfile = $otherTutor->childProfiles()->create([
            'name' => 'Perfil ajeno',
            'age' => 9,
        ]);

        $response = $this
            ->actingAs($tutor)
            ->postJson(
                route('activity-results.store'),
                $this->validResultData($otherProfile->id)
            );

        $response->assertNotFound();

        $this->assertDatabaseMissing('activity_results', [
            'child_profile_id' => $otherProfile->id,
        ]);
    }

    public function test_tutor_can_view_their_child_progress(): void
    {
        $tutor = User::factory()->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Pepito',
            'age' => 10,
        ]);

        $profile->activityResults()->create([
            'activity_code' => 'attention-dogs',
            'correct_answers' => 4,
            'errors' => 1,
            'attempts' => 5,
            'duration_seconds' => 12,
            'level' => 1,
            'completed' => true,
        ]);

        $response = $this
            ->actingAs($tutor)
            ->get(route('child-profiles.progress', $profile));

        $response
            ->assertOk()
            ->assertSee('Progreso de Pepito')
            ->assertSee('4 / 4');
    }

    public function test_tutor_cannot_view_another_tutors_child_progress(): void
    {
        $tutor = User::factory()->create();
        $otherTutor = User::factory()->create();

        $otherProfile = $otherTutor->childProfiles()->create([
            'name' => 'Perfil privado',
            'age' => 8,
        ]);

        $response = $this
            ->actingAs($tutor)
            ->get(route('child-profiles.progress', $otherProfile));

        $response->assertNotFound();
    }

    /**
     * @return array<string, int|string>
     */
    private function validResultData(int $profileId): array
    {
        return [
            'child_profile_id' => $profileId,
            'activity_code' => 'attention-dogs',
            'correct_answers' => 4,
            'errors' => 2,
            'duration_seconds' => 15,
            'level' => 1,
        ];
    }
}
