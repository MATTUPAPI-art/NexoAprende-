<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Eliminar perfil | NexoAprende</title>

    <style>
        :root {
            --danger: #b42318;
            --danger-dark: #8a1711;
            --danger-soft: #fff1f0;
            --background: #f5f7fc;
            --surface: #ffffff;
            --text: #182235;
            --muted: #68758a;
            --border: #dfe5ef;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        .container {
            width: min(620px, calc(100% - 32px));
            margin: 0 auto;
            padding: 48px 0;
        }

        .card {
            padding: 32px;
            border: 1px solid #f2b8b5;
            border-radius: 22px;
            background: var(--surface);
            box-shadow:
                0 18px 45px rgba(31, 45, 78, 0.09);
        }

        .warning {
            display: grid;
            width: 58px;
            height: 58px;
            margin-bottom: 20px;
            place-items: center;
            border-radius: 17px;
            background: var(--danger-soft);
            font-size: 1.8rem;
        }

        h1 {
            margin: 0 0 10px;
            color: var(--danger);
        }

        .description {
            margin: 0 0 20px;
            color: var(--muted);
            line-height: 1.6;
        }

        .consequences {
            margin-bottom: 24px;
            padding: 16px;
            border-radius: 14px;
            background: var(--danger-soft);
            color: var(--danger-dark);
            line-height: 1.6;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 800;
        }

        input {
            width: 100%;
            padding: 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            font: inherit;
        }

        input:focus {
            border-color: var(--danger);
            outline: 0;
            box-shadow:
                0 0 0 4px var(--danger-soft);
        }

        .error {
            display: block;
            margin-top: 7px;
            color: var(--danger);
            font-size: 0.85rem;
        }

        .actions {
            display: flex;
            gap: 12px;
            margin-top: 28px;
        }

        .button {
            display: inline-flex;
            min-height: 48px;
            flex: 1;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border-radius: 12px;
            font: inherit;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
        }

        .button-secondary {
            border: 1px solid var(--border);
            color: var(--muted);
            background: var(--surface);
        }

        .button-danger {
            border: 0;
            color: #ffffff;
            background: var(--danger);
        }

        .button-danger:hover {
            background: var(--danger-dark);
        }

        @media (max-width: 520px) {
            .card {
                padding: 24px 20px;
            }

            .actions {
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
    <main class="container">
        <section class="card">
            <div class="warning" aria-hidden="true">
                ⚠️
            </div>

            <h1>
                Eliminar perfil de {{ $childProfile->name }}
            </h1>

            <p class="description">
                Esta acción requiere la contraseña del tutor
                propietario del perfil.
            </p>

            <div class="consequences">
                Se eliminarán el perfil, sus resultados de
                actividades y sus autorizaciones profesionales.
                Esta acción no se puede deshacer.
            </div>

            <form
                method="POST"
                action="{{ route(
                    'child-profiles.destroy',
                    $childProfile
                ) }}"
            >
                @csrf
                @method('DELETE')

                <label for="password">
                    Contraseña del tutor
                </label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="current-password"
                    required
                    autofocus
                >

                @error('password')
                    <span class="error">
                        {{ $message }}
                    </span>
                @enderror

                <div class="actions">
                    <a
                        class="button button-secondary"
                        href="{{ route('dashboard') }}"
                    >
                        Cancelar
                    </a>

                    <button
                        class="button button-danger"
                        type="submit"
                    >
                        Eliminar definitivamente
                    </button>
                </div>
            </form>
        </section>
    </main>
</body>
</html>
