<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalProfile;
use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class QuestionnaireQuestionController extends Controller
{
    /**
     * Agregar una pregunta al cuestionario.
     */
    public function store(
        Request $request,
        int $questionnaire
    ): RedirectResponse {
        $questionnaire = $this->ownedQuestionnaire(
            $request,
            $questionnaire
        );

        $validated = $this->validateQuestion($request);

        DB::transaction(function () use (
            $questionnaire,
            $validated
        ): void {
            $nextPosition = (
                $questionnaire->questions()->max('position')
                ?? 0
            ) + 1;

            $question = $questionnaire
                ->questions()
                ->create([
                    'question_text' =>
                        $validated['question_text'],
                    'question_type' =>
                        $validated['question_type'],
                    'is_required' =>
                        $validated['is_required'],
                    'position' => $nextPosition,
                ]);

            $this->replaceOptions(
                $question,
                $validated['options']
            );
        });

        return redirect()
            ->route(
                'professional.questionnaires.edit',
                $questionnaire
            )
            ->with(
                'success',
                'Pregunta agregada correctamente.'
            );
    }

    /**
     * Actualizar una pregunta propia.
     */
    public function update(
        Request $request,
        int $questionnaire,
        int $question
    ): RedirectResponse {
        $questionnaire = $this->ownedQuestionnaire(
            $request,
            $questionnaire
        );

        $question = $questionnaire
            ->questions()
            ->findOrFail($question);

        $validated = $this->validateQuestion($request);

        DB::transaction(function () use (
            $question,
            $validated
        ): void {
            $question->update([
                'question_text' =>
                    $validated['question_text'],
                'question_type' =>
                    $validated['question_type'],
                'is_required' =>
                    $validated['is_required'],
            ]);

            $this->replaceOptions(
                $question,
                $validated['options']
            );
        });

        return redirect()
            ->route(
                'professional.questionnaires.edit',
                $questionnaire
            )
            ->with(
                'success',
                'Pregunta actualizada correctamente.'
            );
    }

    /**
     * Eliminar una pregunta propia.
     */
    public function destroy(
        Request $request,
        int $questionnaire,
        int $question
    ): RedirectResponse {
        $questionnaire = $this->ownedQuestionnaire(
            $request,
            $questionnaire
        );

        $question = $questionnaire
            ->questions()
            ->findOrFail($question);

        $question->delete();

        return redirect()
            ->route(
                'professional.questionnaires.edit',
                $questionnaire
            )
            ->with(
                'success',
                'Pregunta eliminada correctamente.'
            );
    }

    /**
     * Validar una pregunta y preparar sus opciones.
     *
     * @return array{
     *     question_text: string,
     *     question_type: string,
     *     is_required: bool,
     *     options: array<int, string>
     * }
     */
    private function validateQuestion(
        Request $request
    ): array {
        $validated = $request->validate([
            'question_text' => [
                'required',
                'string',
                'max:1000',
            ],
            'question_type' => [
                'required',
                'string',
                Rule::in([
                    QuestionnaireQuestion::TYPE_WRITTEN,
                    QuestionnaireQuestion::TYPE_SINGLE_CHOICE,
                    QuestionnaireQuestion::TYPE_MULTIPLE_CHOICE,
                ]),
            ],
            'is_required' => [
                'nullable',
                'boolean',
            ],
            'options' => [
                'nullable',
                'array',
                'max:10',
            ],
            'options.*' => [
                'nullable',
                'string',
                'max:255',
            ],
        ]);

        $options = collect(
            $validated['options'] ?? []
        )
            ->map(
                fn (mixed $option): string =>
                    trim((string) $option)
            )
            ->filter(
                fn (string $option): bool =>
                    $option !== ''
            )
            ->values()
            ->all();

        $usesOptions = in_array(
            $validated['question_type'],
            [
                QuestionnaireQuestion::TYPE_SINGLE_CHOICE,
                QuestionnaireQuestion::TYPE_MULTIPLE_CHOICE,
            ],
            true
        );

        if ($usesOptions && count($options) < 2) {
            throw ValidationException::withMessages([
                'options' => (
                    'Las preguntas de selección deben tener '
                    .'al menos dos opciones.'
                ),
            ]);
        }

        return [
            'question_text' =>
                $validated['question_text'],
            'question_type' =>
                $validated['question_type'],
            'is_required' =>
                $request->boolean('is_required'),
            'options' => $usesOptions ? $options : [],
        ];
    }

    /**
     * Reemplazar las opciones de una pregunta.
     *
     * @param array<int, string> $options
     */
    private function replaceOptions(
        QuestionnaireQuestion $question,
        array $options
    ): void {
        $question->options()->delete();

        foreach ($options as $index => $option) {
            $question->options()->create([
                'option_text' => $option,
                'position' => $index + 1,
            ]);
        }
    }

    /**
     * Obtener un cuestionario perteneciente al profesional.
     */
    private function ownedQuestionnaire(
        Request $request,
        int $questionnaire
    ): Questionnaire {
        $professional = $this->professional($request);

        return $professional
            ->questionnaires()
            ->findOrFail($questionnaire);
    }

    /**
     * Obtener el perfil profesional autenticado.
     */
    private function professional(
        Request $request
    ): ProfessionalProfile {
        abort_unless(
            $request->user()->isProfessional(),
            403
        );

        return $request->user()
            ->professionalProfile()
            ->firstOrFail();
    }
}
