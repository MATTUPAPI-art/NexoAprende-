<?php

namespace Tests\Feature;

use App\Models\ProfessionalProfile;
use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class QuestionnaireQuestionTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_create_questionnaire_question(): void
    {
        [, , $questionnaire] =
            $this->createQuestionnaire();

        $this->post(
            route(
                'professional.questionnaires.questions.store',
                $questionnaire
            ),
            [
                'question_text' => 'Pregunta no autorizada',
                'question_type' =>
                    QuestionnaireQuestion::TYPE_WRITTEN,
            ]
        )->assertRedirect(route('login'));

        $this->assertDatabaseCount(
            'questionnaire_questions',
            0
        );
    }

    public function test_professional_can_create_written_question(): void
    {
        [$professional, , $questionnaire] =
            $this->createQuestionnaire();

        $response = $this
            ->actingAs($professional)
            ->post(
                route(
                    'professional.questionnaires.questions.store',
                    $questionnaire
                ),
                [
                    'question_text' =>
                        '¿Cómo te sentiste durante la actividad?',
                    'question_type' =>
                        QuestionnaireQuestion::TYPE_WRITTEN,
                    'is_required' => '1',
                    'options' => [
                        'Esta opción debe ignorarse',
                    ],
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
                'Pregunta agregada correctamente.'
            );

        $question = QuestionnaireQuestion::query()
            ->where(
                'questionnaire_id',
                $questionnaire->id
            )
            ->firstOrFail();

        $this->assertSame(
            QuestionnaireQuestion::TYPE_WRITTEN,
            $question->question_type
        );

        $this->assertTrue($question->is_required);
        $this->assertSame(1, $question->position);

        $this->assertDatabaseMissing('question_options', [
            'questionnaire_question_id' => $question->id,
        ]);
    }

    public function test_professional_can_create_choice_question_with_options(): void
    {
        [$professional, , $questionnaire] =
            $this->createQuestionnaire();

        $response = $this
            ->actingAs($professional)
            ->post(
                route(
                    'professional.questionnaires.questions.store',
                    $questionnaire
                ),
                [
                    'question_text' =>
                        '¿Qué actividad prefieres?',
                    'question_type' =>
                        QuestionnaireQuestion::TYPE_SINGLE_CHOICE,
                    'is_required' => '1',
                    'options' => [
                        'Lectura',
                        'Memoria',
                        '',
                    ],
                ]
            );

        $response
            ->assertSessionHasNoErrors()
            ->assertRedirect(
                route(
                    'professional.questionnaires.edit',
                    $questionnaire
                )
            );

        $question = QuestionnaireQuestion::query()
            ->where(
                'questionnaire_id',
                $questionnaire->id
            )
            ->firstOrFail();

        $this->assertDatabaseHas(
            'questionnaire_questions',
            [
                'id' => $question->id,
                'question_text' =>
                    '¿Qué actividad prefieres?',
                'question_type' =>
                    QuestionnaireQuestion::TYPE_SINGLE_CHOICE,
                'is_required' => true,
                'position' => 1,
            ]
        );

        $this->assertDatabaseHas('question_options', [
            'questionnaire_question_id' => $question->id,
            'option_text' => 'Lectura',
            'position' => 1,
        ]);

        $this->assertDatabaseHas('question_options', [
            'questionnaire_question_id' => $question->id,
            'option_text' => 'Memoria',
            'position' => 2,
        ]);

        $this->assertDatabaseCount('question_options', 2);
    }

    public function test_choice_question_requires_at_least_two_options(): void
    {
        [$professional, , $questionnaire] =
            $this->createQuestionnaire();

        $response = $this
            ->actingAs($professional)
            ->from(
                route(
                    'professional.questionnaires.edit',
                    $questionnaire
                )
            )
            ->post(
                route(
                    'professional.questionnaires.questions.store',
                    $questionnaire
                ),
                [
                    'question_text' =>
                        'Pregunta incompleta',
                    'question_type' =>
                        QuestionnaireQuestion::TYPE_MULTIPLE_CHOICE,
                    'options' => [
                        'Única opción',
                        '',
                    ],
                ]
            );

        $response
            ->assertRedirect(
                route(
                    'professional.questionnaires.edit',
                    $questionnaire
                )
            )
            ->assertSessionHasErrors('options');

        $this->assertDatabaseCount(
            'questionnaire_questions',
            0
        );

        $this->assertDatabaseCount(
            'question_options',
            0
        );
    }

    public function test_new_questions_receive_next_position(): void
    {
        [$professional, , $questionnaire] =
            $this->createQuestionnaire();

        $questionnaire->questions()->create([
            'question_text' => 'Primera pregunta',
            'question_type' =>
                QuestionnaireQuestion::TYPE_WRITTEN,
            'is_required' => true,
            'position' => 1,
        ]);

        $this->actingAs($professional)
            ->post(
                route(
                    'professional.questionnaires.questions.store',
                    $questionnaire
                ),
                [
                    'question_text' => 'Segunda pregunta',
                    'question_type' =>
                        QuestionnaireQuestion::TYPE_WRITTEN,
                ]
            )
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas(
            'questionnaire_questions',
            [
                'questionnaire_id' => $questionnaire->id,
                'question_text' => 'Segunda pregunta',
                'position' => 2,
            ]
        );
    }

    public function test_professional_can_update_question_and_replace_options(): void
    {
        [$professional, , $questionnaire] =
            $this->createQuestionnaire();

        $question = $questionnaire
            ->questions()
            ->create([
                'question_text' => 'Pregunta anterior',
                'question_type' =>
                    QuestionnaireQuestion::TYPE_SINGLE_CHOICE,
                'is_required' => true,
                'position' => 1,
            ]);

        $oldOption = $question->options()->create([
            'option_text' => 'Opción anterior',
            'position' => 1,
        ]);

        $question->options()->create([
            'option_text' => 'Segunda opción anterior',
            'position' => 2,
        ]);

        $response = $this
            ->actingAs($professional)
            ->put(
                route(
                    'professional.questionnaires.questions.update',
                    [
                        $questionnaire,
                        $question,
                    ]
                ),
                [
                    'question_text' =>
                        'Pregunta actualizada',
                    'question_type' =>
                        QuestionnaireQuestion::TYPE_MULTIPLE_CHOICE,
                    'options' => [
                        'Nueva opción uno',
                        'Nueva opción dos',
                        'Nueva opción tres',
                    ],
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
                'Pregunta actualizada correctamente.'
            );

        $this->assertDatabaseHas(
            'questionnaire_questions',
            [
                'id' => $question->id,
                'question_text' =>
                    'Pregunta actualizada',
                'question_type' =>
                    QuestionnaireQuestion::TYPE_MULTIPLE_CHOICE,
                'is_required' => false,
                'position' => 1,
            ]
        );

        $this->assertDatabaseMissing('question_options', [
            'id' => $oldOption->id,
        ]);

        foreach (
            [
                1 => 'Nueva opción uno',
                2 => 'Nueva opción dos',
                3 => 'Nueva opción tres',
            ] as $position => $option
        ) {
            $this->assertDatabaseHas('question_options', [
                'questionnaire_question_id' =>
                    $question->id,
                'option_text' => $option,
                'position' => $position,
            ]);
        }

        $this->assertSame(
            3,
            $question->fresh()->options()->count()
        );
    }

    public function test_professional_can_delete_question_and_its_options(): void
    {
        [$professional, , $questionnaire] =
            $this->createQuestionnaire();

        $question = $questionnaire
            ->questions()
            ->create([
                'question_text' =>
                    'Pregunta para eliminar',
                'question_type' =>
                    QuestionnaireQuestion::TYPE_SINGLE_CHOICE,
                'is_required' => true,
                'position' => 1,
            ]);

        $option = $question->options()->create([
            'option_text' => 'Opción para eliminar',
            'position' => 1,
        ]);

        $response = $this
            ->actingAs($professional)
            ->delete(
                route(
                    'professional.questionnaires.questions.destroy',
                    [
                        $questionnaire,
                        $question,
                    ]
                )
            );

        $response
            ->assertRedirect(
                route(
                    'professional.questionnaires.edit',
                    $questionnaire
                )
            )
            ->assertSessionHas(
                'success',
                'Pregunta eliminada correctamente.'
            );

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

    public function test_professional_cannot_manage_questions_from_another_professional(): void
    {
        [$owner, , $questionnaire] =
            $this->createQuestionnaire();

        $question = $questionnaire
            ->questions()
            ->create([
                'question_text' => 'Pregunta protegida',
                'question_type' =>
                    QuestionnaireQuestion::TYPE_WRITTEN,
                'is_required' => true,
                'position' => 1,
            ]);

        [$otherProfessional] =
            $this->createQuestionnaire(
                email: 'otro@example.com',
                license: 'PSP-OTRO-002',
                title: 'Cuestionario del otro'
            );

        $this->actingAs($otherProfessional)
            ->post(
                route(
                    'professional.questionnaires.questions.store',
                    $questionnaire
                ),
                [
                    'question_text' =>
                        'Intento de creación',
                    'question_type' =>
                        QuestionnaireQuestion::TYPE_WRITTEN,
                ]
            )
            ->assertNotFound();

        $this->actingAs($otherProfessional)
            ->put(
                route(
                    'professional.questionnaires.questions.update',
                    [
                        $questionnaire,
                        $question,
                    ]
                ),
                [
                    'question_text' =>
                        'Intento de modificación',
                    'question_type' =>
                        QuestionnaireQuestion::TYPE_WRITTEN,
                ]
            )
            ->assertNotFound();

        $this->actingAs($otherProfessional)
            ->delete(
                route(
                    'professional.questionnaires.questions.destroy',
                    [
                        $questionnaire,
                        $question,
                    ]
                )
            )
            ->assertNotFound();

        $this->assertDatabaseHas(
            'questionnaire_questions',
            [
                'id' => $question->id,
                'question_text' => 'Pregunta protegida',
            ]
        );

        $this->assertNotNull($owner);
    }

    public function test_tutor_cannot_manage_questionnaire_questions(): void
    {
        [, , $questionnaire] =
            $this->createQuestionnaire();

        $question = $questionnaire
            ->questions()
            ->create([
                'question_text' => 'Pregunta profesional',
                'question_type' =>
                    QuestionnaireQuestion::TYPE_WRITTEN,
                'is_required' => true,
                'position' => 1,
            ]);

        $tutor = User::factory()
            ->tutor()
            ->create();

        $this->actingAs($tutor)
            ->post(
                route(
                    'professional.questionnaires.questions.store',
                    $questionnaire
                ),
                [
                    'question_text' => 'Intento del tutor',
                    'question_type' =>
                        QuestionnaireQuestion::TYPE_WRITTEN,
                ]
            )
            ->assertForbidden();

        $this->actingAs($tutor)
            ->put(
                route(
                    'professional.questionnaires.questions.update',
                    [
                        $questionnaire,
                        $question,
                    ]
                ),
                [
                    'question_text' => 'Modificación',
                    'question_type' =>
                        QuestionnaireQuestion::TYPE_WRITTEN,
                ]
            )
            ->assertForbidden();

        $this->actingAs($tutor)
            ->delete(
                route(
                    'professional.questionnaires.questions.destroy',
                    [
                        $questionnaire,
                        $question,
                    ]
                )
            )
            ->assertForbidden();
    }

    /**
     * @return array{
     *     0: User,
     *     1: ProfessionalProfile,
     *     2: Questionnaire
     * }
     */
    private function createQuestionnaire(
        string $email = 'profesional@example.com',
        string $license = 'PSP-PREGUNTAS-001',
        string $title = 'Cuestionario de prueba'
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

        $questionnaire = $profile
            ->questionnaires()
            ->create([
                'title' => $title,
                'description' =>
                    'Descripción del cuestionario.',
                'instructions' =>
                    'Responde todas las preguntas.',
                'is_active' => true,
            ]);

        return [
            $user,
            $profile,
            $questionnaire,
        ];
    }
}
