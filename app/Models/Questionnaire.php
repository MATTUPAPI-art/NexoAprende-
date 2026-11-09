<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'title',
    'description',
    'instructions',
    'is_active',
])]
class Questionnaire extends Model
{
    /**
     * Profesional que creó el cuestionario.
     */
    public function professionalProfile(): BelongsTo
    {
        return $this->belongsTo(
            ProfessionalProfile::class
        );
    }

    /**
     * Preguntas que contiene el cuestionario.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(
            QuestionnaireQuestion::class
        )->orderBy('position');
    }

    /**
     * Conversiones de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }
}
