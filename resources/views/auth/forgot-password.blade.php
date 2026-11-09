<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Recuperar contraseña | NexoAprende</title>

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
            --success: #16794b;
            --success-soft: #eaf8f1;
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
            width: min(480px, 100%);
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

        .status {
            margin-bottom: 20px;
            padding: 14px 16px;
            border-radius: 12px;
            color: var(--success);
            background: var(--success-soft);
            line-height: 1.5;
        }

        .field {
            margin-bottom: 20px;
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

        .back-link {
            display: block;
            margin-top: 22px;
            color: var(--primary);
            font-weight: 800;
            text-align: center;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
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

        <h1>Recupera tu contraseña</h1>

        <p class="description">
            Escribe el correo asociado a tu cuenta. Te enviaremos
            un enlace seguro para crear una contraseña nueva.
        </p>

        @if (session('status'))
            <div class="status" role="status">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="field">
                <label for="email">Correo electrónico</label>

                <input
                    id="email"
                    name="email"
                    type="email"
                    value="{{ old('email') }}"
                    autocomplete="email"
                    required
                    autofocus
                >

                @error('email')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit">
                Enviar enlace de recuperación
            </button>
        </form>

        <a class="back-link" href="{{ route('login') }}">
            Volver a iniciar sesión
        </a>
    </main>
</body>
</html>
