<?php

namespace App\Services;

use App\Models\ChildProfile;
use Illuminate\Database\Eloquent\Collection;

class ProgressInsights
{
    /**
     * Construir las estadísticas descriptivas de un perfil.
     *
     * @return array<string, mixed>
     */
    public function for(ChildProfile $profile): array
    {
        $allResults = $profile
    ->activityResults()
    ->latest('id')
    ->get();

        return [
            'summary' => $this->summary($allResults),
            'activitySummaries' => $this->activitySummaries(
                $allResults
            ),
            'insight' => $this->insight($allResults),
        ];
    }

    /**
     * Resumen general.
     *
     * @return array<string, int|float|null>
     */
    private function summary(Collection $results): array
    {
        return [
            'sessions' => $results->count(),
            'best_time' => $results->min('duration_seconds'),
            'total_correct' => $results->sum('correct_answers'),
            'total_errors' => $results->sum('errors'),
            'average_correct' => $this->average(
                $results,
                'correct_answers'
            ),
            'average_errors' => $this->average(
                $results,
                'errors'
            ),
            'average_time' => $this->average(
                $results,
                'duration_seconds'
            ),
            'highest_level' => $results->max('level') ?? 0,
        ];
    }

    /**
     * Resumen separado por actividad.
     *
     * @return array<int, array<string, int|float|string>>
     */
    private function activitySummaries(
        Collection $results
    ): array {
        $activities = [
            'attention-dogs' => [
                'name' => 'Encuentra los perros',
                'area' => 'Atención visual',
            ],
            'memory-pairs' => [
                'name' => 'Encuentra las parejas',
                'area' => 'Memoria visual',
            ],
            'reading-story' => [
                'name' => 'Completa la historia',
                'area' => 'Lectura comprensiva',
            ],
        ];

        $summaries = [];

        foreach ($activities as $code => $activity) {
            $activityResults = $results
                ->where('activity_code', $code)
                ->values();

            if ($activityResults->isEmpty()) {
                continue;
            }

            $summaries[] = [
                'code' => $code,
                'name' => $activity['name'],
                'area' => $activity['area'],
                'sessions' => $activityResults->count(),
                'average_correct' => $this->average(
                    $activityResults,
                    'correct_answers'
                ),
                'average_errors' => $this->average(
                    $activityResults,
                    'errors'
                ),
                'average_time' => $this->average(
                    $activityResults,
                    'duration_seconds'
                ),
                'highest_level' => (
                    $activityResults->max('level') ?? 0
                ),
            ];
        }

        return $summaries;
    }

    /**
     * Comparar las dos sesiones más recientes
     * de una misma actividad.
     *
     * @return array<string, string|null>
     */
    private function insight(Collection $results): array
    {
        $latest = $results->first();

        if ($latest === null) {
            return [
                'type' => 'neutral',
                'title' => 'Todavía no hay resultados',
                'message' => (
                    'Completa una actividad para comenzar '
                    .'a observar el progreso.'
                ),
                'activity_code' => null,
            ];
        }

        $activityResults = $results
            ->where(
                'activity_code',
                $latest->activity_code
            )
            ->values();

        if ($activityResults->count() < 2) {
            return [
                'type' => 'neutral',
                'title' => 'Primer resultado registrado',
                'message' => (
                    'Se necesita otra sesión de esta actividad '
                    .'para realizar una comparación.'
                ),
                'activity_code' => $latest->activity_code,
            ];
        }

        $previous = $activityResults->get(1);
        $changes = [];

        if (
            $latest->correct_answers
            > $previous->correct_answers
        ) {
            $difference = (
                $latest->correct_answers
                - $previous->correct_answers
            );

            $changes[] = "aumentó {$difference} acierto(s)";
        }

        if ($latest->errors < $previous->errors) {
            $difference = (
                $previous->errors
                - $latest->errors
            );

            $changes[] = "redujo {$difference} error(es)";
        }

        if (
            $latest->duration_seconds
            < $previous->duration_seconds
        ) {
            $difference = (
                $previous->duration_seconds
                - $latest->duration_seconds
            );

            $changes[] = "redujo su tiempo en {$difference} s";
        }

        if ($changes === []) {
            return [
                'type' => 'neutral',
                'title' => 'Desempeño estable',
                'message' => (
                    'La sesión más reciente mantiene resultados '
                    .'similares a la anterior.'
                ),
                'activity_code' => $latest->activity_code,
            ];
        }

        return [
            'type' => 'positive',
            'title' => 'Avance observado',
            'message' => (
                'Respecto a la sesión anterior, '
                .implode(', ', $changes)
                .'.'
            ),
            'activity_code' => $latest->activity_code,
        ];
    }

    /**
     * Calcular un promedio con un decimal.
     */
    private function average(
        Collection $results,
        string $field
    ): float {
        if ($results->isEmpty()) {
            return 0;
        }

        return round(
            (float) $results->avg($field),
            1
        );
    }
}
