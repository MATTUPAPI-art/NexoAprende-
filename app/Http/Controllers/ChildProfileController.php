<?php

namespace App\Http\Controllers;

use App\Models\ChildProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChildProfileController extends Controller
{
    /**
     * Panel correspondiente al usuario autenticado.
     */
    public function index(
        Request $request
    ): View|RedirectResponse {
        if ($request->user()->isProfessional()) {
            return redirect()
                ->route('professional.dashboard');
        }

        $this->ensureTutor($request);

        $profiles = $request->user()
            ->childProfiles()
            ->latest()
            ->get();

        return view('dashboard', compact('profiles'));
    }

    /**
     * Formulario para crear un perfil infantil.
     */
    public function create(Request $request): View
    {
        $this->ensureTutor($request);

        return view('child-profiles.create');
    }

    /**
     * Guardar un perfil infantil.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->ensureTutor($request);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:60',
            ],
            'age' => [
    'required',
    'integer',
    'min:5',
    'max:18',
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

    /**
     * Abrir la actividad de atención.
     */
    public function activity(
        Request $request,
        int $childProfile
    ): View {
        $this->ensureTutor($request);

        $profile = $request->user()
            ->childProfiles()
            ->findOrFail($childProfile);

        return view('demo-atencion', [
            'childProfile' => $profile,
        ]);
    }

    /**
     * Abrir la actividad de memoria.
     */
    public function memoryActivity(
        Request $request,
        int $childProfile
    ): View {
        $this->ensureTutor($request);

        $profile = $request->user()
            ->childProfiles()
            ->findOrFail($childProfile);

        return view('demo-memoria', [
            'childProfile' => $profile,
        ]);
    }

    /**
     * Abrir la actividad de lectura.
     */
    public function readingActivity(
        Request $request,
        int $childProfile
    ): View {
        $this->ensureTutor($request);

        $profile = $request->user()
            ->childProfiles()
            ->findOrFail($childProfile);

        return view('demo-lectura', [
            'childProfile' => $profile,
        ]);
    }

    /**
     * Permitir estas acciones únicamente a tutores.
     */
    private function ensureTutor(Request $request): void
    {
        abort_unless(
            $request->user()->isTutor(),
            403
        );
    }
}
