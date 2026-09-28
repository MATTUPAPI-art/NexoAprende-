<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MemoryActivityTest extends TestCase
{
    use RefreshDatabase;

    public function test_tutor_can_open_memory_activity_for_own_profile(): void
    {
        $tutor = User::factory()->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Pepito',
            'age' => 10,
        ]);

        $this->actingAs($tutor)
            ->get(route('child-profiles.activities.memory', $profile))
            ->assertOk()
            ->assertSee('Encuentra las parejas')
            ->assertSee('Pepito');
    }

    public function test_tutor_cannot_open_memory_activity_for_other_profile(): void
    {
        $tutor = User::factory()->create();
        $otherTutor = User::factory()->create();

        $otherProfile = $otherTutor->childProfiles()->create([
            'name' => 'Perfil privado',
            'age' => 9,
        ]);

        $this->actingAs($tutor)
            ->get(route(
                'child-profiles.activities.memory',
                $otherProfile
            ))
            ->assertNotFound();
    }

    public function test_tutor_can_store_memory_activity_result(): void
    {
        $tutor = User::factory()->create();

        $profile = $tutor->childProfiles()->create([
            'name' => 'Pepito',
            'age' => 10,
        ]);

        $this->actingAs($tutor)
            ->postJson(route('activity-results.store'), [
                'child_profile_id' => $profile->id,
                'activity_code' => 'memory-pairs',
                'correct_answers' => 6,
                'errors' => 2,
                'duration_seconds' => 30,
                'level' => 1,
            ])
            ->assertCreated();

        $this->assertDatabaseHas('activity_results', [
            'child_profile_id' => $profile->id,
            'activity_code' => 'memory-pairs',
            'correct_answers' => 6,
            'errors' => 2,
            'attempts' => 8,
            'duration_seconds' => 30,
            'completed' => true,
        ]);
    }
}
