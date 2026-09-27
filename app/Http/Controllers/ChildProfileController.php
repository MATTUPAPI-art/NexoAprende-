<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChildProfileController extends Controller
{
    /**
     * Panel del tutor con sus propios perfiles.
     */
    public function index(Request $request): View
    {
        $profiles = $request->user()
            ->childProfiles()
            ->latest()
            ->get();

        return view('dashboard', compact('profiles'));
    }

    /**
     * Formulario para crear un perfil infantil.
     */
    public function create(): View
    {
        return view('child-profiles.create');
    }

    /**
     * Guardar el perfil para el tutor autenticado.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:60',
            ],
            'age' => [
                'required',
                'integer',
                'min:6',
                'max:13',
            ],
        ]);

        $request->user()
            ->childProfiles()
            ->create($validated);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Perfil infantil creado correctamente.'
            );
    }
}
