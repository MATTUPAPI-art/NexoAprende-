<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse as SymfonyRedirectResponse;
use Throwable;

class GoogleAuthController extends Controller
{
    /**
     * Enviar al usuario al consentimiento oficial de Google.
     */
    public function redirect(): SymfonyRedirectResponse
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    /**
     * Procesar la respuesta enviada por Google.
     */
    public function callback(Request $request): RedirectResponse
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('login')
                ->withErrors([
                    'google' => 'No fue posible iniciar sesión con Google. Inténtalo nuevamente.',
                ]);
        }

        $googleId = trim((string) $googleUser->getId());
        $email = Str::lower(trim((string) $googleUser->getEmail()));
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
                ->route('login')
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
                    ->route('login')
                    ->withErrors([
                        'google' => 'Este correo ya está vinculado con otra cuenta de Google.',
                    ]);
            }

            $user->forceFill([
                'google_id' => $googleId,
                'avatar_url' => $this->safeAvatarUrl(
                    $googleUser->getAvatar()
                ),
                'email_verified_at' => $user->email_verified_at ?? now(),
            ])->save();

            Auth::login($user, remember: true);
            $request->session()->regenerate();

            return redirect()->intended(
                $user->isProfessional()
                    ? route('professional.dashboard')
                    : route('dashboard')
            );
        }

        $request->session()->put('google_registration', [
            'google_id' => $googleId,
            'name' => $name !== '' ? $name : 'Tutor de NexoAprende',
            'email' => $email,
            'avatar_url' => $this->safeAvatarUrl(
                $googleUser->getAvatar()
            ),
        ]);

        return redirect()->route('auth.google.complete');
    }

    /**
     * Mostrar el formulario adicional de NexoAprende.
     */
    public function showCompletion(
        Request $request
    ): RedirectResponse|\Illuminate\View\View {
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
        ]);
    }

    /**
     * Crear la cuenta local del padre o tutor.
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

        $validated = $request->validate([
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
        ]);

                $user = DB::transaction(function () use (
            $validated,
            $googleRegistration
        ): User {
            $user = User::query()->create([
                'name' => $validated['name'],
                'email' => $googleRegistration['email'],
                'password' => $validated['password'],
                'role' => 'tutor',
                'google_id' => $googleRegistration['google_id'],
                'avatar_url' => $googleRegistration['avatar_url'],
            ]);

            $user->forceFill([
                'email_verified_at' => now(),
            ])->save();

            return $user;
        });

        $request->session()->forget('google_registration');

        Auth::login($user, remember: true);
        $request->session()->regenerate();

        return redirect()
            ->route('dashboard')
            ->with(
                'success',
                'Tu cuenta de tutor fue creada correctamente.'
            );
    }

    /**
     * Admitir únicamente fotografías remotas mediante HTTPS.
     */
    private function safeAvatarUrl(?string $avatarUrl): ?string
    {
        if (
            $avatarUrl === null
            || filter_var($avatarUrl, FILTER_VALIDATE_URL) === false
            || parse_url($avatarUrl, PHP_URL_SCHEME) !== 'https'
        ) {
            return null;
        }

        return Str::limit($avatarUrl, 2048, '');
    }
}
