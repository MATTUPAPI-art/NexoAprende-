<?php

namespace App\Http\Controllers;

use App\Models\ProfessionalProfile;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class ProfessionalProfileController extends Controller
{
    /**
     * Mostrar el formulario de registro profesional.
     */
    public function create(): View
    {
        return view('auth.register-professional');
    }

    /**
     * Registrar una nueva cuenta profesional.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8),
            ],
            'specialty' => [
                'required',
                'string',
                'max:100',
            ],
            'license_number' => [
                'required',
                'string',
                'max:80',
                Rule::unique(ProfessionalProfile::class),
            ],
            'years_experience' => [
                'required',
                'integer',
                'min:0',
                'max:60',
            ],
            'biography' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        $user = DB::transaction(function () use ($validated): User {
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'professional',
            ]);

            $user->professionalProfile()->create([
                'specialty' => $validated['specialty'],
                'license_number' => $validated['license_number'],
                'years_experience' => $validated['years_experience'],
                'biography' => $validated['biography'] ?? null,
            ]);

            return $user;
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()
            ->route('professional.dashboard')
            ->with(
                'success',
                'Tu cuenta profesional fue creada correctamente.'
            );
    }

    /**
     * Mostrar el panel del profesional autenticado.
     */
    public function dashboard(Request $request): View
    {
        abort_unless(
            $request->user()->isProfessional(),
            403
        );

        $professional = $request->user()
            ->professionalProfile()
            ->firstOrFail();

        return view(
            'professional-dashboard',
            compact('professional')
        );
    }
}
