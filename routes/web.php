<?php

use App\Http\Controllers\ActivityResultController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')
    ->name('inicio');

Route::view('/panel', 'dashboard')
    ->middleware('auth')
    ->name('dashboard');

Route::view('/actividades/atencion', 'demo-atencion')
    ->name('activities.attention');

Route::post(
    '/resultados-actividad',
    [ActivityResultController::class, 'store']
)->name('activity-results.store');

Route::get(
    '/progreso',
    [ActivityResultController::class, 'index']
)
    ->middleware('auth')
    ->name('activity-results.index');
