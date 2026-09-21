<?php

use App\Http\Controllers\ActivityResultController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')
    ->name('inicio');

Route::view('/actividades/atencion', 'demo-atencion')
    ->name('activities.attention');

Route::post(
    '/resultados-actividad',
    [ActivityResultController::class, 'store']
)->name('activity-results.store');

Route::get(
    '/progreso',
    [ActivityResultController::class, 'index']
)->name('activity-results.index');
