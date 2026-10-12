<?php

use App\Http\Controllers\ActivityResultController;
use App\Http\Controllers\ChildProfileController;
use App\Http\Controllers\ProfessionalAccessController;
use App\Http\Controllers\ProfessionalProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')
    ->name('inicio');

Route::view('/actividades/atencion', 'demo-atencion')
    ->name('activities.attention');

/*
|--------------------------------------------------------------------------
| Registro profesional
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get(
        '/registro-profesional',
        [ProfessionalProfileController::class, 'create']
    )->name('professional.register');

    Route::post(
        '/registro-profesional',
        [ProfessionalProfileController::class, 'store']
    )->name('professional.register.store');
});

/*
|--------------------------------------------------------------------------
| Área privada
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get(
        '/panel',
        [ChildProfileController::class, 'index']
    )->name('dashboard');

    Route::get(
        '/panel-profesional',
        [ProfessionalProfileController::class, 'dashboard']
    )->name('professional.dashboard');

    Route::get(
        '/perfiles/crear',
        [ChildProfileController::class, 'create']
    )->name('child-profiles.create');

    Route::post(
        '/perfiles',
        [ChildProfileController::class, 'store']
    )->name('child-profiles.store');
Route::get(
    '/perfiles/{childProfile}/editar',
    [ChildProfileController::class, 'edit']
)->name('child-profiles.edit');

Route::put(
    '/perfiles/{childProfile}',
    [ChildProfileController::class, 'update']
)->name('child-profiles.update');

Route::get(
    '/perfiles/{childProfile}/eliminar',
    [ChildProfileController::class, 'confirmDestroy']
)->name('child-profiles.delete');

Route::delete(
    '/perfiles/{childProfile}',
    [ChildProfileController::class, 'destroy']
)->name('child-profiles.destroy');
    /*
    |--------------------------------------------------------------------------
    | Actividades infantiles
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/perfiles/{childProfile}/actividades/atencion',
        [ChildProfileController::class, 'activity']
    )->name('child-profiles.activities.attention');

    Route::get(
        '/perfiles/{childProfile}/actividades/memoria',
        [ChildProfileController::class, 'memoryActivity']
    )->name('child-profiles.activities.memory');

    Route::get(
        '/perfiles/{childProfile}/actividades/lectura',
        [ChildProfileController::class, 'readingActivity']
    )->name('child-profiles.activities.reading');

    /*
    |--------------------------------------------------------------------------
    | Resultados y progreso
    |--------------------------------------------------------------------------
    */

    Route::post(
        '/resultados-actividad',
        [ActivityResultController::class, 'store']
    )->name('activity-results.store');

    Route::get(
        '/perfiles/{childProfile}/progreso',
        [ActivityResultController::class, 'index']
    )->name('child-profiles.progress');

    /*
    |--------------------------------------------------------------------------
    | Autorizaciones profesionales
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/perfiles/{childProfile}/profesionales',
        [ProfessionalAccessController::class, 'manage']
    )->name('child-profiles.professionals');

    Route::post(
        '/perfiles/{childProfile}/profesionales',
        [ProfessionalAccessController::class, 'store']
    )->name('child-profiles.professionals.store');

    Route::delete(
        '/perfiles/{childProfile}/profesionales/{professionalProfile}',
        [ProfessionalAccessController::class, 'destroy']
    )->name('child-profiles.professionals.destroy');

    Route::get(
        '/panel-profesional/perfiles/{childProfile}/progreso',
        [ProfessionalAccessController::class, 'progress']
    )->name('professional.child-profiles.progress');
});
