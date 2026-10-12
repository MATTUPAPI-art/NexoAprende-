<?php

namespace Tests\Feature;

use App\Models\ChildProfile;
use App\Models\User;
use App\Services\ProgressInsights;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProgressInsightsTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_calculates_progress_summary(): void
    {
        $profile = $this->createProfile();

        $profile->activityResults()->create([
            'activity_code' => 'attention-dogs',
            'correct_answers' => 2,
            'errors' => 4,
            'attempts' => 6,
            'duration_seconds' => 60,
            'level' => 1,
            'completed' => true,
        ]);

        $profile->activityResults()->create([
            'activity_code' => 'attention-dogs',
            'correct_answers' => 4,
            'errors' => 1,
            'attempts' => 5,
            'duration_seconds' => 40,
            'level' => 2,
            'completed' => true,
        ]);

        $progress = app(ProgressInsights::class)
            ->for($profile);

        $this->assertSame(
            2,
            $progress['summary']['sessions']
        );

        $this->assertSame(
            3.0,
            $progress['summary']['average_correct']
        );

        $this->assertSame(
            2.5,
            $progress['summary']['average_errors']
        );

        $this->assertSame(
            50.0,
            $progress['summary']['average_time']
        );

        $this->assertSame(
            2,
            $progress['summary']['highest_level']
        );
    }

    public function test_it_detects_descriptive_improvement(): void
    {
        $profile = $this->createProfile();

        $profile->activityResults()->create([
            'activity_code' => 'attention-dogs',
            'correct_answers' => 2,
            'errors' => 4,
            'attempts' => 6,
            'duration_seconds' => 60,
            'level' => 1,
            'completed' => true,
            'created_at' => now()->subDay(),
            'updated_at' => now()->subDay(),
        ]);

        $profile->activityResults()->create([
            'activity_code' => 'attention-dogs',
            'correct_answers' => 4,
            'errors' => 1,
            'attempts' => 5,
            'duration_seconds' => 40,
            'level' => 2,
            'completed' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $progress = app(ProgressInsights::class)
            ->for($profile);

        $this->assertSame(
            'positive',
            $progress['insight']['type']
        );

        $this->assertSame(
            'Avance observado',
            $progress['insight']['title']
        );

        $this->assertStringContainsString(
            'aumentó 2 acierto(s)',
            $progress['insight']['message']
        );

        $this->assertStringContainsString(
            'redujo 3 error(es)',
            $progress['insight']['message']
        );

        $this->assertStringContainsString(
            'redujo su tiempo en 20 s',
            $progress['insight']['message']
        );
    }

    public function test_tutor_receives_progress_data(): void
    {
        $profile = $this->createProfile();

        $response = $this
            ->actingAs($profile->user)
            ->get(route(
                'child-profiles.progress',
                $profile
            ));

        $response
            ->assertOk()
            ->assertViewHas('summary')
            ->assertViewHas('activitySummaries')
            ->assertViewHas('insight');
    }

    private function createProfile(): ChildProfile
    {
        $tutor = User::factory()->create([
            'role' => 'tutor',
        ]);

        return $tutor->childProfiles()->create([
            'name' => 'Perfil de prueba',
            'age' => 10,
        ]);
    }
}
