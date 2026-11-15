<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class ValidTurnstile implements ValidationRule
{
    /**
     * Comprobar el desafío de protección contra bots.
     *
     * @param  Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(
        string $attribute,
        mixed $value,
        Closure $fail
    ): void {
        if (! is_string($value) || trim($value) === '') {
            $fail(
                'Confirma que no eres un robot por fa,antes de continuar.'
            );

            return;
        }

        $secretKey = config('services.turnstile.secret_key');
        $verifyUrl = config('services.turnstile.verify_url');

        if (
            ! is_string($secretKey)
            || $secretKey === ''
            || ! is_string($verifyUrl)
            || $verifyUrl === ''
        ) {
            report(
                new \RuntimeException(
                    'Turnstile no está configurado correctamente.'
                )
            );

            $fail(
                'No fue posible validar la solicitud. Inténtalo nuevamente.'
            );

            return;
        }

        try {
            $response = Http::asForm()
                ->acceptJson()
                ->timeout(8)
                ->retry(2, 150)
                ->post($verifyUrl, [
                    'secret' => $secretKey,
                    'response' => $value,
                    'remoteip' => request()->ip(),
                    'idempotency_key' => (string) Str::uuid(),
                ]);
        } catch (Throwable $exception) {
            report($exception);

            $fail(
                'No fue posible validar la solicitud. Inténtalo nuevamente.'
            );

            return;
        }

        if (
            ! $response->successful()
            || $response->json('success') !== true
        ) {
            $fail(
                'La verificación de seguridad expiró o no es válida. Inténtalo nuevamente.'
            );
        }
    }
}
