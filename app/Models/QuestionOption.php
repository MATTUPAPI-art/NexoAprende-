<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'option_text',
    'position',
])]
class QuestionOption extends Model
{
    /**
     * Pregunta a la que pertenece la opción.
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(
            QuestionnaireQuestion::class,
            'questionnaire_question_id'
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
            'position' => 'integer',
        ];
    }
}
