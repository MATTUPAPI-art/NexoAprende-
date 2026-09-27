<?php

use App\Http\Controllers\ActivityResultController;
use App\Http\Controllers\ChildProfileController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')
    ->name('inicio');

Route::view('/actividades/atencion', 'demo-atencion')
    ->name('activities.attention');

Route::post(
    '/resultados-actividad',
    [ActivityResultController::class, 'store']
)->name('activity-results.store');

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
        '/progreso',
        [ActivityResultController::class, 'index']
    )->name('activity-results.index');
});
