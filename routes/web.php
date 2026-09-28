<?php

use App\Http\Controllers\ActivityResultController;
use App\Http\Controllers\ChildProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')
    ->name('inicio');

/*
|--------------------------------------------------------------------------
| Demostración pública
|--------------------------------------------------------------------------
|
| Permite conocer la actividad, pero no guarda resultados.
|
*/

Route::view('/actividades/atencion', 'demo-atencion')
    ->name('activities.attention');

/*
|--------------------------------------------------------------------------
| Área privada del tutor
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get(
        '/panel',
        [ChildProfileController::class, 'index']
    )->name('dashboard');

    Route::get(
        '/perfiles/crear',
        [ChildProfileController::class, 'create']
    )->name('child-profiles.create');

    Route::post(
        '/perfiles',
        [ChildProfileController::class, 'store']
    )->name('child-profiles.store');

    Route::get(
        '/perfiles/{childProfile}/actividades/atencion',
        [ChildProfileController::class, 'activity']
    )->name('child-profiles.activities.attention');

    Route::get(
        '/perfiles/{childProfile}/actividades/memoria',
        [ChildProfileController::class, 'memoryActivity']
    )->name('child-profiles.activities.memory');

    Route::post(
        '/resultados-actividad',
        [ActivityResultController::class, 'store']
    )->name('activity-results.store');

    Route::get(
        '/perfiles/{childProfile}/progreso',
        [ActivityResultController::class, 'index']
    )->name('child-profiles.progress');
});
