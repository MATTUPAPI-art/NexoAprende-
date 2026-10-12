<?php

namespace Tests\Feature;

use App\Models\ChildProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AgeAdaptiveExperienceTest extends TestCase
{
    use RefreshDatabase;

    public function test_tutor_can_create_profile_for_five_year_old(): void
    {
        $tutor = User::factory()->create([
            'role' => 'tutor',
        ]);

        $response = $this
            ->actingAs($tutor)
            ->post(route('child-profiles.store'), [
                'name' => 'Perfil infantil',
                'age' => 5,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('child_profiles', [
            'user_id' => $tutor->id,
            'name' => 'Perfil infantil',
            'age' => 5,
        ]);
    }

    public function test_tutor_can_create_profile_for_eighteen_year_old(): void
    {
        $tutor = User::factory()->create([
            'role' => 'tutor',
        ]);

        $response = $this
            ->actingAs($tutor)
            ->post(route('child-profiles.store'), [
                'name' => 'Perfil adolescente',
                'age' => 18,
            ]);

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('dashboard'));

        $this->assertDatabaseHas('child_profiles', [
            'user_id' => $tutor->id,
            'age' => 18,
        ]);
    }

    public function test_age_must_be_between_five_and_eighteen(): void
    {
        $tutor = User::factory()->create([
            'role' => 'tutor',
        ]);

        $this
            ->actingAs($tutor)
            ->post(route('child-profiles.store'), [
                'name' => 'Edad inferior',
                'age' => 4,
            ])
            ->assertSessionHasErrors('age');

        $this
            ->actingAs($tutor)
            ->post(route('child-profiles.store'), [
                'name' => 'Edad superior',
                'age' => 19,
            ])
            ->assertSessionHasErrors('age');
    }

    public function test_profile_is_classified_by_age(): void
    {
        $infantil = new ChildProfile(['age' => 5]);
        $preadolescente = new ChildProfile(['age' => 11]);
        $adolescente = new ChildProfile(['age' => 16]);

        $this->assertSame('infantil', $infantil->ageGroup());
        $this->assertSame(
            'Etapa infantil',
            $infantil->ageGroupLabel()
        );

        $this->assertSame(
            'preadolescente',
            $preadolescente->ageGroup()
        );

        $this->assertSame(
            'Etapa preadolescente',
            $preadolescente->ageGroupLabel()
        );

        $this->assertSame(
            'adolescente',
            $adolescente->ageGroup()
        );

        $this->assertSame(
            'Etapa adolescente',
            $adolescente->ageGroupLabel()
        );
    }
}
