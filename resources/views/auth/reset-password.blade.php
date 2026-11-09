<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Nueva contraseña | NexoAprende</title>

    <style>
        :root {
            --primary: #5747e8;
            --primary-dark: #4031bd;
            --primary-soft: #eeecff;
            --background: #f5f7fc;
            --surface: #ffffff;
            --text: #182235;
            --muted: #68758a;
            --border: #dfe5ef;
            --danger: #b42318;
        }

        * {
            box-sizing: border-box;
        }

        body {
            display: grid;
            min-height: 100vh;
            margin: 0;
            place-items: center;
            padding: 24px;
            background:
                radial-gradient(
                    circle at top right,
                    #eeecff,
                    transparent 38%
                ),
                var(--background);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        .card {
            width: min(500px, 100%);
            padding: 38px;
            border: 1px solid var(--border);
            border-radius: 22px;
            background: var(--surface);
            box-shadow: 0 20px 55px rgba(40, 35, 100, 0.1);
        }

        .brand {
            display: inline-block;
            margin-bottom: 30px;
            color: var(--primary);
            font-size: 1.4rem;
            font-weight: 900;
            text-decoration: none;
        }

        h1 {
            margin: 0 0 12px;
            font-size: 2rem;
        }

        .description {
            margin: 0 0 26px;
            color: var(--muted);
            line-height: 1.65;
        }

        .field {
            margin-bottom: 19px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 800;
        }

        input {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            color: var(--text);
            font: inherit;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .error {
            display: block;
            margin-top: 7px;
            color: var(--danger);
            font-size: 0.87rem;
        }

        .help {
            margin: -8px 0 20px;
            color: var(--muted);
            font-size: 0.88rem;
            line-height: 1.5;
        }

        button {
            width: 100%;
            padding: 14px 18px;
            border: 0;
            border-radius: 12px;
            color: #ffffff;
            background: var(--primary);
            cursor: pointer;
            font: inherit;
            font-weight: 900;
        }

        button:hover {
            background: var(--primary-dark);
        }

        @media (max-width: 520px) {
            .card {
                padding: 28px 22px;
            }
        }
    </style>
</head>

<body>
    <main class="card">
        <a class="brand" href="{{ route('inicio') }}">
            NexoAprende
        </a>

        <h1>Crea una nueva contraseña</h1>

        <p class="description">
            Utiliza una contraseña segura que no estés usando en
            otras aplicaciones.
        </p>

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input
                name="token"
                type="hidden"
                value="{{ $request->route('token') }}"
            >

            <div class="field">
                <label for="email">Correo electrónico</label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email', $request->email) }}"
                    autocomplete="email"
                    required
                    readonly
                >

                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <label for="password">Nueva contraseña</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    autocomplete="new-password"
                    required
                >

                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div class="field">
                <label for="password_confirmation">
                    Confirmar nueva contraseña
                </label>

                <input
                    id="password_confirmation"
                    name="password_confirmation"
                    type="password"
                    autocomplete="new-password"
                    required
                >
            </div>

            <p class="help">
                Utiliza al menos 8 caracteres y evita datos fáciles
                de adivinar.
            </p>

            <button type="submit">
                Guardar nueva contraseña
            </button>
        </form>
    </main>
</body>
</html>
