<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityResultController extends Controller
{
    /**
     * Historial de un perfil perteneciente al tutor.
     */
    public function index(
        Request $request,
        int $childProfile
    ): View {
        $profile = $request->user()
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
     * Guardar el resultado para un perfil del tutor.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'child_profile_id' => [
                'required',
                'integer',
            ],
            'activity_code' => [
                'required',
                'string',
                'in:attention-dogs,memory-pairs',
            ],
            'correct_answers' => [
                'required',
                'integer',
                'min:0',
                'max:6',
            ],
            'errors' => [
                'required',
                'integer',
                'min:0',
                'max:100',
            ],
            'duration_seconds' => [
                'required',
                'integer',
                'min:1',
                'max:3600',
            ],
            'level' => [
                'required',
                'integer',
                'min:1',
                'max:10',
            ],
        ]);

        $profile = $request->user()
            ->childProfiles()
            ->findOrFail($validated['child_profile_id']);

        $result = $profile
            ->activityResults()
            ->create([
                'activity_code' => $validated['activity_code'],
                'correct_answers' => $validated['correct_answers'],
                'errors' => $validated['errors'],
                'attempts' => (
                    $validated['correct_answers']
                    + $validated['errors']
                ),
                'duration_seconds' => (
                    $validated['duration_seconds']
                ),
                'level' => $validated['level'],
                'completed' => true,
            ]);

        return response()->json([
            'message' => 'Resultado guardado correctamente.',
            'result_id' => $result->id,
        ], 201);
    }
}
