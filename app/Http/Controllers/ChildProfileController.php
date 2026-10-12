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
     * Formulario para crear un perfil.
     */
    public function create(Request $request): View
    {
        $this->ensureTutor($request);

        return view('child-profiles.create');
    }

    /**
     * Guardar un perfil.
     */
    public function store(Request $request): RedirectResponse
    {
        $this->ensureTutor($request);

        $validated = $this->validateProfile($request);

        $request->user()
            ->childProfiles()
            ->create($validated);

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Perfil creado correctamente.'
            );
    }

    /**
     * Mostrar el formulario de edición.
     */
    public function edit(
        Request $request,
        int $childProfile
    ): View {
        $profile = $this->ownedProfile(
            $request,
            $childProfile
        );

        return view('child-profiles.edit', [
            'childProfile' => $profile,
        ]);
    }

    /**
     * Actualizar el perfil.
     */
    public function update(
        Request $request,
        int $childProfile
    ): RedirectResponse {
        $profile = $this->ownedProfile(
            $request,
            $childProfile
        );

        $profile->update(
            $this->validateProfile($request)
        );

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Perfil actualizado correctamente.'
            );
    }

    /**
     * Mostrar la confirmación para eliminar.
     */
    public function confirmDestroy(
        Request $request,
        int $childProfile
    ): View {
        $profile = $this->ownedProfile(
            $request,
            $childProfile
        );

        return view('child-profiles.delete', [
            'childProfile' => $profile,
        ]);
    }

    /**
     * Eliminar el perfil después de validar la contraseña.
     */
    public function destroy(
        Request $request,
        int $childProfile
    ): RedirectResponse {
        $profile = $this->ownedProfile(
            $request,
            $childProfile
        );

        $request->validate([
            'password' => [
                'required',
                'string',
                'current_password',
            ],
        ], [
            'password.required' => (
                'Debes ingresar tu contraseña.'
            ),
            'password.current_password' => (
                'La contraseña ingresada no es correcta.'
            ),
        ]);

        $profileName = $profile->name;

        $profile->delete();

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                "El perfil de {$profileName} fue eliminado."
            );
    }

    /**
     * Abrir la actividad de atención.
     */
    public function activity(
        Request $request,
        int $childProfile
    ): View {
        $profile = $this->ownedProfile(
            $request,
            $childProfile
        );

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
        $profile = $this->ownedProfile(
            $request,
            $childProfile
        );

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
        $profile = $this->ownedProfile(
            $request,
            $childProfile
        );

        return view('demo-lectura', [
            'childProfile' => $profile,
        ]);
    }

    /**
     * Validar los datos editables del perfil.
     *
     * @return array{name: string, age: int}
     */
    private function validateProfile(Request $request): array
    {
        return $request->validate([
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
    }

    /**
     * Obtener un perfil propiedad del tutor autenticado.
     */
    private function ownedProfile(
        Request $request,
        int $childProfile
    ): ChildProfile {
        $this->ensureTutor($request);

        return $request->user()
            ->childProfiles()
            ->findOrFail($childProfile);
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
