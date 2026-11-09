<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalProfile;
use App\Models\Questionnaire;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class QuestionnaireController extends Controller
{
    /**
     * Mostrar los cuestionarios del profesional.
     */
    public function index(Request $request): View
    {
        $professional = $this->professional($request);

        $questionnaires = $professional
            ->questionnaires()
            ->withCount('questions')
            ->latest()
            ->get();

        return view('questionnaires.index', [
            'professional' => $professional,
            'questionnaires' => $questionnaires,
        ]);
    }

    /**
     * Mostrar el formulario de creación.
     */
    public function create(Request $request): View
    {
        $this->professional($request);

        return view('questionnaires.create');
    }

    /**
     * Guardar un cuestionario.
     */
    public function store(
        Request $request
    ): RedirectResponse {
        $professional = $this->professional($request);

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:120',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'instructions' => [
                'nullable',
                'string',
                'max:1500',
            ],
        ]);

        $questionnaire = $professional
            ->questionnaires()
            ->create([
                ...$validated,
                'is_active' => $request->boolean(
                    'is_active'
                ),
            ]);

        return redirect()
            ->route(
                'professional.questionnaires.edit',
                $questionnaire
            )
            ->with(
                'success',
                'Cuestionario creado correctamente. '
                .'Ahora puedes agregar preguntas.'
            );
    }

    /**
     * Mostrar el formulario de edición.
     */
    public function edit(
        Request $request,
        int $questionnaire
    ): View {
        $professional = $this->professional($request);

        $questionnaire = $professional
            ->questionnaires()
            ->with([
                'questions.options',
            ])
            ->findOrFail($questionnaire);

        return view('questionnaires.edit', [
            'questionnaire' => $questionnaire,
        ]);
    }

    /**
     * Actualizar el cuestionario.
     */
    public function update(
        Request $request,
        int $questionnaire
    ): RedirectResponse {
        $professional = $this->professional($request);

        $questionnaire = $professional
            ->questionnaires()
            ->findOrFail($questionnaire);

        $validated = $request->validate([
            'title' => [
                'required',
                'string',
                'max:120',
            ],
            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],
            'instructions' => [
                'nullable',
                'string',
                'max:1500',
            ],
        ]);

        $questionnaire->update([
            ...$validated,
            'is_active' => $request->boolean(
                'is_active'
            ),
        ]);

        return redirect()
            ->route(
                'professional.questionnaires.edit',
                $questionnaire
            )
            ->with(
                'success',
                'Cuestionario actualizado correctamente.'
            );
    }

    /**
     * Eliminar un cuestionario propio.
     */
    public function destroy(
        Request $request,
        int $questionnaire
    ): RedirectResponse {
        $professional = $this->professional($request);

        $questionnaire = $professional
            ->questionnaires()
            ->findOrFail($questionnaire);

        $questionnaire->delete();

        return redirect()
            ->route('professional.questionnaires.index')
            ->with(
                'success',
                'Cuestionario eliminado correctamente.'
            );
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
