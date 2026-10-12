<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['name', 'age'])]
class ChildProfile extends Model
{
    /**
     * Tutor propietario del perfil.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Resultados registrados para el perfil.
     */
    public function activityResults(): HasMany
    {
        return $this->hasMany(ActivityResult::class);
    }

    /**
     * Profesionales autorizados por el tutor.
     */
    public function professionals(): BelongsToMany
    {
        return $this->belongsToMany(
            ProfessionalProfile::class,
            'child_profile_professional'
        )->withTimestamps();
    }

    /**
     * Grupo de experiencia correspondiente a su edad.
     */
    public function ageGroup(): string
    {
        return match (true) {
            $this->age <= 9 => 'infantil',
            $this->age <= 13 => 'preadolescente',
            default => 'adolescente',
        };
    }

    /**
     * Nombre visible de la etapa.
     */
    public function ageGroupLabel(): string
    {
        return match ($this->ageGroup()) {
            'infantil' => 'Etapa infantil',
            'preadolescente' => 'Etapa preadolescente',
            'adolescente' => 'Etapa adolescente',
        };
    }

    /**
     * Breve explicación para el tutor.
     */
    public function ageGroupDescription(): string
    {
        return match ($this->ageGroup()) {
            'infantil' =>
                'Experiencia visual, sencilla y acompañada.',
            'preadolescente' =>
                'Actividades dinámicas con desafíos progresivos.',
            'adolescente' =>
                'Experiencia más madura, autónoma y orientada a metas.',
        };
    }

    /**
     * Conversiones de atributos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'age' => 'integer',
        ];
    }
}
