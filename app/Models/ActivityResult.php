<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityResult extends Model
{
    protected $fillable = [
        'activity_code',
        'correct_answers',
        'errors',
        'attempts',
        'duration_seconds',
        'level',
        'completed',
    ];

    /**
     * Perfil infantil al que pertenece el resultado.
     */
    public function childProfile(): BelongsTo
    {
        return $this->belongsTo(ChildProfile::class);
    }

    /**
     * Conversiones de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'correct_answers' => 'integer',
            'errors' => 'integer',
            'attempts' => 'integer',
            'duration_seconds' => 'integer',
            'level' => 'integer',
            'completed' => 'boolean',
        ];
    }
}
