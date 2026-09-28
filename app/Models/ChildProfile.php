<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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
