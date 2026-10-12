<?php

namespace App\Http\Controllers;
use App\Services\ProgressInsights;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ActivityResultController extends Controller
{
    /**
     * Historial de un perfil perteneciente al tutor.
     */
   public function index(
    Request $request,
    int $childProfile,
    ProgressInsights $progressInsights
): View {
    abort_unless(
        $request->user()->isTutor(),
        403
    );

    $profile = $request->user()
        ->childProfiles()
        ->findOrFail($childProfile);

    $results = $profile
    ->activityResults()
    ->latest('id')
    ->limit(20)
    ->get();

    $progress = $progressInsights->for($profile);

    return view('progress', [
        'results' => $results,
        'summary' => $progress['summary'],
        'activitySummaries' => (
            $progress['activitySummaries']
        ),
        'insight' => $progress['insight'],
        'childProfile' => $profile,
    ]);
}

    /**
     * Guardar el resultado para un perfil del tutor.
     */
    public function store(Request $request): JsonResponse
    {
        abort_unless(
            $request->user()->isTutor(),
            403
        );

        $validated = $request->validate([
            'child_profile_id' => [
                'required',
                'integer',
            ],
            'activity_code' => [
                'required',
                'string',
                Rule::in([
                    'attention-dogs',
                    'memory-pairs',
                    'reading-story',
                ]),
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
