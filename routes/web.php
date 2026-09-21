<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ActivityResultController;

Route::view('/', 'demo-atencion')->name('inicio');
Route::post('/resultados-actividad', [ActivityResultController::class, 'store'])
    ->name('activity-results.store');
