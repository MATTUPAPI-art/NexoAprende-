<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ProfessionalAccessController extends Controller
{
    /**
     * Mostrar los profesionales disponibles para un perfil infantil.
     */
    public function manage(
        Request $request,
        int $childProfile
    ): View {
        $this->ensureTutor($request);

        $profile = $request->user()
            ->childProfiles()
            ->findOrFail($childProfile);

        $professionals = ProfessionalProfile::query()
            ->with('user:id,name,email')
            ->orderBy('specialty')
            ->get();

        $authorizedIds = $profile
            ->professionals()
            ->pluck('professional_profiles.id')
            ->all();

        return view('child-profiles.professionals', [
            'childProfile' => $profile,
            'professionals' => $professionals,
            'authorizedIds' => $authorizedIds,
        ]);
    }

    /**
     * Autorizar a un profesional.
     */
    public function store(
        Request $request,
        int $childProfile
    ): RedirectResponse {
        $this->ensureTutor($request);

        $profile = $request->user()
            ->childProfiles()
            ->findOrFail($childProfile);

        $validated = $request->validate([
            'professional_profile_id' => [
                'required',
                'integer',
                Rule::exists(
                    'professional_profiles',
                    'id'
                ),
            ],
        ]);

        $profile->professionals()->syncWithoutDetaching([
            $validated['professional_profile_id'],
        ]);

        return redirect()
            ->route(
                'child-profiles.professionals',
                $profile
            )
            ->with(
                'success',
                'Profesional autorizado correctamente.'
            );
    }

    /**
     * Retirar la autorización de un profesional.
     */
    public function destroy(
        Request $request,
        int $childProfile,
        int $professionalProfile
    ): RedirectResponse {
        $this->ensureTutor($request);

        $profile = $request->user()
            ->childProfiles()
            ->findOrFail($childProfile);

        $profile->professionals()
            ->detach($professionalProfile);

        return redirect()
            ->route(
                'child-profiles.professionals',
                $profile
            )
            ->with(
                'success',
                'La autorización fue retirada.'
            );
    }

    /**
     * Mostrar al profesional el progreso de un niño autorizado.
     */
    public function progress(
        Request $request,
        int $childProfile
    ): View {
        abort_unless(
            $request->user()->isProfessional(),
            403
        );

        $professional = $request->user()
            ->professionalProfile()
            ->firstOrFail();

        $profile = $professional
            ->childProfiles()
            ->findOrFail($childProfile);

        $results = $profile
            ->activityResults()
            ->latest()
            ->limit(20)
            ->get();

        $summary = [
            'sessions' => $profile
                ->activityResults()
                ->count(),

            'best_time' => $profile
                ->activityResults()
                ->min('duration_seconds'),

            'total_correct' => $profile
                ->activityResults()
                ->sum('correct_answers'),

            'total_errors' => $profile
                ->activityResults()
                ->sum('errors'),
        ];

        return view('progress', [
            'results' => $results,
            'summary' => $summary,
            'childProfile' => $profile,
        ]);
    }

    /**
     * Comprobar que el usuario sea tutor.
     */
    private function ensureTutor(Request $request): void
    {
        abort_unless(
            $request->user()->isTutor(),
            403
        );
    }
}
