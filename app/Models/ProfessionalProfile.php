<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[Fillable([
    'specialty',
    'license_number',
    'years_experience',
    'biography',
])]
class ProfessionalProfile extends Model
{
    protected function casts(): array
    {
        return [
            'years_experience' => 'integer',
            'verified' => 'boolean',
        ];
    }

    /**
     * Cuenta perteneciente al profesional.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Perfiles infantiles autorizados.
     */
    public function childProfiles(): BelongsToMany
    {
        return $this->belongsToMany(
            ChildProfile::class,
            'child_profile_professional'
        )->withTimestamps();
    }

    /**
     * Limpiar espacios innecesarios en la especialidad.
     */
    protected function specialty(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => trim($value),
        );
    }
    /**
 * Cuestionarios creados por el profesional.
 */
public function questionnaires(): HasMany
{
    return $this->hasMany(Questionnaire::class);
}
}
