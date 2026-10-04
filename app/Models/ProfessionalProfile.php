<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function specialty(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => trim($value),
        );
    }
}
