<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'question_text',
    'question_type',
    'is_required',
    'position',
])]
class QuestionnaireQuestion extends Model
{
    public const TYPE_WRITTEN = 'written';

    public const TYPE_SINGLE_CHOICE = 'single_choice';

    public const TYPE_MULTIPLE_CHOICE = 'multiple_choice';

    /**
     * Cuestionario al que pertenece la pregunta.
     */
    public function questionnaire(): BelongsTo
    {
        return $this->belongsTo(Questionnaire::class);
    }

    /**
     * Opciones disponibles para la pregunta.
     */
    public function options(): HasMany
    {
        return $this->hasMany(
            QuestionOption::class
        )->orderBy('position');
    }

    /**
     * Indicar si la pregunta utiliza opciones.
     */
    public function usesOptions(): bool
    {
        return in_array(
            $this->question_type,
            [
                self::TYPE_SINGLE_CHOICE,
                self::TYPE_MULTIPLE_CHOICE,
            ],
            true
        );
    }

    /**
     * Conversiones de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_required' => 'boolean',
            'position' => 'integer',
        ];
    }
}
