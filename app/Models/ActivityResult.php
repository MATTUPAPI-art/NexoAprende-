<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
