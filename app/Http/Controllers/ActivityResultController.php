<?php

namespace App\Http\Controllers;

use App\Models\ActivityResult;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityResultController extends Controller
{
    public function index(): View
    {
        $results = ActivityResult::query()
            ->latest()
            ->limit(20)
            ->get();

        $summary = [
            'sessions' => ActivityResult::count(),
            'best_time' => ActivityResult::min('duration_seconds'),
            'total_correct' => ActivityResult::sum('correct_answers'),
            'total_errors' => ActivityResult::sum('errors'),
        ];

        return view('progress', compact('results', 'summary'));
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'activity_code' => [
                'required',
                'string',
                'in:attention-dogs',
            ],
            'correct_answers' => [
                'required',
                'integer',
                'min:0',
                'max:4',
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

        $result = ActivityResult::create([
            'activity_code' => $validated['activity_code'],
            'correct_answers' => $validated['correct_answers'],
            'errors' => $validated['errors'],
            'attempts' => $validated['correct_answers'] + $validated['errors'],
            'duration_seconds' => $validated['duration_seconds'],
            'level' => $validated['level'],
            'completed' => true,
        ]);

        return response()->json([
            'message' => 'Resultado guardado correctamente.',
            'result_id' => $result->id,
        ], 201);
    }
}
