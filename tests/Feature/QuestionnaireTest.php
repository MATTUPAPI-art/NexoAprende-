<?php

namespace Tests\Feature;

use App\Models\ProfessionalProfile;
use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionnaireTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_open_questionnaire_management(): void
    {
        $this->get(
            route('professional.questionnaires.index')
        )->assertRedirect(route('login'));

        $this->get(
            route('professional.questionnaires.create')
        )->assertRedirect(route('login'));
    }

    public function test_tutor_cannot_manage_questionnaires(): void
    {
        $tutor = User::factory()
            ->tutor()
            ->create();

        $this->actingAs($tutor)
            ->get(route('professional.questionnaires.index'))
            ->assertForbidden();

        $this->actingAs($tutor)
            ->get(route('professional.questionnaires.create'))
            ->assertForbidden();

        $this->actingAs($tutor)
            ->post(
                route('professional.questionnaires.store'),
                [
                    'title' => 'Intento del tutor',
                ]
            )
            ->assertForbidden();

        $this->assertDatabaseMissing('questionnaires', [
            'title' => 'Intento del tutor',
        ]);
    }

    public function test_professional_can_open_questionnaire_creation_form(): void
    {
        [$professional] = $this->createProfessional();

        $this->actingAs($professional)
            ->get(route('professional.questionnaires.create'))
            ->assertOk()
            ->assertSee('cuestionario', false);
    }

    public function test_professional_only_sees_own_questionnaires(): void
    {
        [$professional, $profile] =
            $this->createProfessional();

        [, $otherProfile] =
            $this->createProfessional(
                email: 'otro@example.com',
                license: 'PSP-OTRO-001'
            );

        $profile->questionnaires()->create([
            'title' => 'Cuestionario propio',
            'description' => 'Visible para su propietario.',
            'instructions' => null,
            'is_active' => true,
        ]);

        $otherProfile->questionnaires()->create([
            'title' => 'Cuestionario ajeno',
            'description' => 'No debe ser visible.',
            'instructions' => null,
            'is_active' => true,
        ]);

        $this->actingAs($professional)
            ->get(route('professional.questionnaires.index'))
            ->assertOk()
            ->assertSee('Cuestionario propio')
            ->assertDontSee('Cuestionario ajeno');
    }

    public function test_professional_can_create_questionnaire(): void
    {
        [$professional, $profile] =
            $this->createProfessional();

        $response = $this
            ->actingAs($professional)
            ->post(
                route('professional.questionnaires.store'),
                [
                    'title' => 'Hábitos de estudio',
                    'description' =>
                        'Cuestionario de acompañamiento.',
                    'instructions' =>
                        'Responde con tranquilidad.',
                    'is_active' => '1',
                ]
            );

        $questionnaire = Questionnaire::query()
            ->where('title', 'Hábitos de estudio')
            ->firstOrFail();

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(
                route(
                    'professional.questionnaires.edit',
                    $questionnaire
                )
            )
            ->assertSessionHas(
                'success',
                'Cuestionario creado correctamente. '
                .'Ahora puedes agregar preguntas.'
            );

        $this->assertDatabaseHas('questionnaires', [
            'id' => $questionnaire->id,
            'professional_profile_id' => $profile->id,
            'title' => 'Hábitos de estudio',
            'description' =>
                'Cuestionario de acompañamiento.',
            'instructions' =>
                'Responde con tranquilidad.',
            'is_active' => true,
        ]);
    }

    public function test_questionnaire_creation_validates_required_title(): void
    {
        [$professional] = $this->createProfessional();

        $this->actingAs($professional)
            ->post(
                route('professional.questionnaires.store'),
                [
                    'title' => '',
                    'description' => 'Sin título.',
                    'is_active' => '1',
                ]
            )
            ->assertSessionHasErrors('title');

        $this->assertDatabaseCount('questionnaires', 0);
    }

    public function test_professional_can_open_own_questionnaire_edit_form(): void
    {
        [$professional, $profile] =
            $this->createProfessional();

        $questionnaire = $profile
            ->questionnaires()
            ->create([
                'title' => 'Desarrollo de lectura',
                'description' => 'Descripción de prueba.',
                'instructions' => 'Lee cada pregunta.',
                'is_active' => true,
            ]);

        $question = $questionnaire
            ->questions()
            ->create([
                'question_text' => '¿Te gusta leer?',
                'question_type' =>
                    QuestionnaireQuestion::TYPE_SINGLE_CHOICE,
                'is_required' => true,
                'position' => 1,
            ]);

        $question->options()->create([
            'option_text' => 'Sí',
            'position' => 1,
        ]);

        $this->actingAs($professional)
            ->get(
                route(
                    'professional.questionnaires.edit',
                    $questionnaire
                )
            )
            ->assertOk()
            ->assertSee('Desarrollo de lectura')
            ->assertSee('¿Te gusta leer?')
            ->assertSee('Sí');
    }

    public function test_professional_can_update_own_questionnaire(): void
    {
        [$professional, $profile] =
            $this->createProfessional();

        $questionnaire = $profile
            ->questionnaires()
            ->create([
                'title' => 'Título anterior',
                'description' => 'Descripción anterior.',
                'instructions' => 'Instrucciones anteriores.',
                'is_active' => true,
            ]);

        $response = $this
            ->actingAs($professional)
            ->put(
                route(
                    'professional.questionnaires.update',
                    $questionnaire
                ),
                [
                    'title' => 'Título actualizado',
                    'description' =>
                        'Descripción actualizada.',
                    'instructions' =>
                        'Instrucciones actualizadas.',
                ]
            );

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(
                route(
                    'professional.questionnaires.edit',
                    $questionnaire
                )
            )
            ->assertSessionHas(
                'success',
                'Cuestionario actualizado correctamente.'
            );

        $this->assertDatabaseHas('questionnaires', [
            'id' => $questionnaire->id,
            'professional_profile_id' => $profile->id,
            'title' => 'Título actualizado',
            'description' => 'Descripción actualizada.',
            'instructions' => 'Instrucciones actualizadas.',
            'is_active' => false,
        ]);
    }

    public function test_professional_cannot_manage_another_professionals_questionnaire(): void
    {
        [$professional] = $this->createProfessional();

        [, $otherProfile] =
            $this->createProfessional(
                email: 'propietario@example.com',
                license: 'PSP-PROPIETARIO-001'
            );

        $questionnaire = $otherProfile
            ->questionnaires()
            ->create([
                'title' => 'Cuestionario protegido',
                'description' => null,
                'instructions' => null,
                'is_active' => true,
            ]);

        $this->actingAs($professional)
            ->get(
                route(
                    'professional.questionnaires.edit',
                    $questionnaire
                )
            )
            ->assertNotFound();

        $this->actingAs($professional)
            ->put(
                route(
                    'professional.questionnaires.update',
                    $questionnaire
                ),
                [
                    'title' => 'Intento de modificación',
                ]
            )
            ->assertNotFound();

        $this->actingAs($professional)
            ->delete(
                route(
                    'professional.questionnaires.destroy',
                    $questionnaire
                )
            )
            ->assertNotFound();

        $this->assertDatabaseHas('questionnaires', [
            'id' => $questionnaire->id,
            'professional_profile_id' => $otherProfile->id,
            'title' => 'Cuestionario protegido',
        ]);
    }

    public function test_deleting_questionnaire_cascades_questions_and_options(): void
    {
        [$professional, $profile] =
            $this->createProfessional();

        $questionnaire = $profile
            ->questionnaires()
            ->create([
                'title' => 'Cuestionario eliminable',
                'description' => null,
                'instructions' => null,
                'is_active' => true,
            ]);

        $question = $questionnaire
            ->questions()
            ->create([
                'question_text' => 'Pregunta eliminable',
                'question_type' =>
                    QuestionnaireQuestion::TYPE_SINGLE_CHOICE,
                'is_required' => true,
                'position' => 1,
            ]);

        $option = $question->options()->create([
            'option_text' => 'Opción eliminable',
            'position' => 1,
        ]);

        $response = $this
            ->actingAs($professional)
            ->delete(
                route(
                    'professional.questionnaires.destroy',
                    $questionnaire
                )
            );

        $response
            ->assertRedirect(
                route('professional.questionnaires.index')
            )
            ->assertSessionHas(
                'success',
                'Cuestionario eliminado correctamente.'
            );

        $this->assertDatabaseMissing('questionnaires', [
            'id' => $questionnaire->id,
        ]);

        $this->assertDatabaseMissing(
            'questionnaire_questions',
            [
                'id' => $question->id,
            ]
        );

        $this->assertDatabaseMissing('question_options', [
            'id' => $option->id,
        ]);
    }

    /**
     * @return array{0: User, 1: ProfessionalProfile}
     */
    private function createProfessional(
        string $email = 'profesional@example.com',
        string $license = 'PSP-TEST-001'
    ): array {
        $user = User::factory()
            ->professional()
            ->create([
                'email' => $email,
            ]);

        $profile = $user
            ->professionalProfile()
            ->create([
                'specialty' => 'Psicopedagogía',
                'license_number' => $license,
                'years_experience' => 5,
                'biography' =>
                    'Experiencia en acompañamiento educativo.',
            ]);

        return [$user, $profile];
    }
}
