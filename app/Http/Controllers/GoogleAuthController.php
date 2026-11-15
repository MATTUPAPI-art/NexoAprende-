<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Enviar al tutor al consentimiento oficial de Google.
     */
    public function redirect(Request $request): SymfonyRedirectResponse
    {
        return $this->redirectForAccountType($request, 'tutor');
    }

    /**
     * Enviar al profesional al consentimiento oficial de Google.
     */
    public function redirectProfessional(
        Request $request
    ): SymfonyRedirectResponse {
        return $this->redirectForAccountType(
            $request,
            'professional'
        );
    }

    /**
     * Procesar la respuesta enviada por Google.
     */
    public function callback(Request $request): RedirectResponse
    {
        $accountType = $this->requestedAccountType($request);
        $errorRoute = $accountType === 'professional'
            ? 'professional.register'
            : 'login';

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route($errorRoute)
                ->withErrors([
                    'google' => 'No fue posible iniciar sesión con Google. Inténtalo nuevamente.',
                ]);
        }

        $googleId = trim((string) $googleUser->getId());
        $email = Str::lower(
            trim((string) $googleUser->getEmail())
        );
        $name = trim((string) $googleUser->getName());

        $verifiedEmail = (bool) (
            data_get($googleUser->user, 'verified_email')
            ?? data_get($googleUser->user, 'email_verified')
            ?? false
        );

        if (
            $googleId === ''
            || $email === ''
            || ! filter_var($email, FILTER_VALIDATE_EMAIL)
            || ! $verifiedEmail
        ) {
            return redirect()
                ->route($errorRoute)
                ->withErrors([
                    'google' => 'Google no proporcionó un correo electrónico verificado.',
                ]);
        }

        $user = User::query()
            ->where('google_id', $googleId)
            ->orWhere('email', $email)
            ->first();

        if ($user !== null) {
            if (
                $user->google_id !== null
                && ! hash_equals($user->google_id, $googleId)
            ) {
                return redirect()
                    ->route($errorRoute)
                    ->withErrors([
                        'google' => 'Este correo ya está vinculado con otra cuenta de Google.',
                    ]);
            }

            $user->forceFill([
                'google_id' => $googleId,
                'avatar_url' => $this->safeAvatarUrl(
                    $googleUser->getAvatar()
                ),
                'email_verified_at' => (
                    $user->email_verified_at ?? now()
                ),
            ])->save();

            $request->session()->forget([
                'google_account_type',
                'google_registration',
            ]);

            Auth::login($user, remember: true);
            $request->session()->regenerate();

            return redirect()->intended(
                $user->isProfessional()
                    ? route('professional.dashboard')
                    : route('dashboard')
            );
        }

        $defaultName = $accountType === 'professional'
            ? 'Profesional de NexoAprende'
            : 'Tutor de NexoAprende';

        $request->session()->put('google_registration', [
            'google_id' => $googleId,
            'name' => $name !== '' ? $name : $defaultName,
            'email' => $email,
            'avatar_url' => $this->safeAvatarUrl(
                $googleUser->getAvatar()
            ),
            'account_type' => $accountType,
        ]);

        $request->session()->forget('google_account_type');

        return redirect()->route('auth.google.complete');
    }

    /**
     * Mostrar el formulario adicional de NexoAprende.
     */
    public function showCompletion(
        Request $request
    ): RedirectResponse|View {
        $googleRegistration = $request->session()
            ->get('google_registration');

        if (! is_array($googleRegistration)) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'google' => 'La solicitud de registro con Google expiró.',
                ]);
        }

        return view('auth.complete-google-registration', [
            'googleRegistration' => $googleRegistration,
            'isProfessional' => (
                ($googleRegistration['account_type'] ?? 'tutor')
                === 'professional'
            ),
        ]);
    }

    /**
     * Crear la cuenta local vinculada con Google.
     */
    public function storeCompletion(
        Request $request
    ): RedirectResponse {
        $googleRegistration = $request->session()
            ->get('google_registration');

        if (! is_array($googleRegistration)) {
            return redirect()
                ->route('login')
                ->withErrors([
                    'google' => 'La solicitud de registro con Google expiró.',
                ]);
        }

        $accountType = (
            ($googleRegistration['account_type'] ?? 'tutor')
            === 'professional'
        )
            ? 'professional'
            : 'tutor';

        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'password' => [
                'required',
                'confirmed',
                Password::defaults(),
            ],
            'terms' => [
                'accepted',
            ],
        ];

        if ($accountType === 'professional') {
            $rules = array_merge($rules, [
                'specialty' => [
                    'required',
                    'string',
                    'max:255',
                ],
                'license_number' => [
                    'required',
                    'string',
                    'max:100',
                    Rule::unique(
                        'professional_profiles',
                        'license_number'
                    ),
                ],
                'years_experience' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:80',
                ],
                'biography' => [
                    'nullable',
                    'string',
                    'max:1000',
                ],
            ]);
        }

        $validated = $request->validate($rules);

        $user = DB::transaction(function () use (
            $validated,
            $googleRegistration,
            $accountType
        ): User {
            $user = User::query()->create([
                'name' => $validated['name'],
                'email' => $googleRegistration['email'],
                'password' => $validated['password'],
                'role' => $accountType,
                'google_id' => $googleRegistration['google_id'],
                'avatar_url' => (
                    $googleRegistration['avatar_url'] ?? null
                ),
            ]);

            $user->forceFill([
                'email_verified_at' => now(),
            ])->save();

            if ($accountType === 'professional') {
                $user->professionalProfile()->create([
                    'specialty' => $validated['specialty'],
                    'license_number' => (
                        $validated['license_number']
                    ),
                    'years_experience' => (
                        $validated['years_experience']
                    ),
                    'biography' => (
                        $validated['biography'] ?? null
                    ),
                ]);
            }

            return $user;
        });

        $request->session()->forget('google_registration');

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        if ($user->isProfessional()) {
            return redirect()
                ->route('professional.dashboard')
                ->with(
                    'success',
                    'Tu cuenta profesional fue creada correctamente.'
                );
        }

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Tu cuenta de tutor fue creada correctamente.'
            );
    }

    /**
     * Guardar el tipo de cuenta antes de salir hacia Google.
     */
    private function redirectForAccountType(
        Request $request,
        string $accountType
    ): SymfonyRedirectResponse {
        $request->session()->put(
            'google_account_type',
            $accountType
        );

        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Recuperar únicamente tipos de cuenta permitidos.
     */
    private function requestedAccountType(
        Request $request
    ): string {
        $accountType = $request->session()
            ->get('google_account_type', 'tutor');

        return $accountType === 'professional'
            ? 'professional'
            : 'tutor';
    }

    /**
     * Admitir únicamente fotografías remotas mediante HTTPS.
     */
    private function safeAvatarUrl(
        ?string $avatarUrl
    ): ?string {
        if (
            $avatarUrl === null
            || filter_var(
                $avatarUrl,
                FILTER_VALIDATE_URL
            ) === false
            || parse_url(
                $avatarUrl,
                PHP_URL_SCHEME
            ) !== 'https'
        ) {
            return null;
        }

        return Str::limit($avatarUrl, 2048, '');
    }
}
