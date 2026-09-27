<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Iniciar sesión | NexoAprende</title>

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
            --danger-soft: #fff1f0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background:
                radial-gradient(
                    circle at top right,
                    #eeecff 0,
                    transparent 36%
                ),
                var(--background);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        .page {
            display: grid;
            grid-template-columns: 1fr 1fr;
            min-height: 100vh;
        }

        .presentation {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            background:
                linear-gradient(
                    145deg,
                    #5747e8,
                    #4031bd
                );
            color: #ffffff;
        }

        .presentation-content {
            width: min(480px, 100%);
        }

        .brand {
            display: inline-block;
            margin-bottom: 48px;
            color: #ffffff;
            font-size: 1.55rem;
            font-weight: 800;
            text-decoration: none;
        }

        .presentation h1 {
            margin: 0 0 18px;
            font-size: clamp(2.2rem, 5vw, 3.8rem);
            line-height: 1.05;
        }

        .presentation p {
            margin: 0;
            color: #e8e5ff;
            font-size: 1.05rem;
            line-height: 1.7;
        }

        .form-section {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 42px 24px;
        }

        .form-container {
            width: min(460px, 100%);
        }

        .back-link {
            display: inline-flex;
            margin-bottom: 30px;
            color: var(--primary);
            font-weight: 700;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .form-header {
            margin-bottom: 28px;
        }

        .form-header h2 {
            margin: 0 0 10px;
            font-size: 2rem;
        }

        .form-header p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .error-summary {
            margin-bottom: 22px;
            padding: 16px 18px;
            border: 1px solid #f2b8b5;
            border-radius: 14px;
            background: var(--danger-soft);
            color: var(--danger);
        }

        .error-summary ul {
            margin: 0;
            padding-left: 20px;
        }

        .field {
            margin-bottom: 19px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.94rem;
            font-weight: 700;
        }

        .field input[type="email"],
        .field input[type="password"] {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            background: var(--surface);
            color: var(--text);
            font: inherit;
            transition:
                border-color 0.2s,
                box-shadow 0.2s;
        }

        .field input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .field-error {
            display: block;
            margin-top: 7px;
            color: var(--danger);
            font-size: 0.85rem;
        }

        .remember-row {
            display: flex;
            align-items: center;
            margin: 4px 0 22px;
        }

        .remember-row label {
            display: inline-flex;
            align-items: center;
            gap: 9px;
            color: var(--muted);
            cursor: pointer;
            font-size: 0.92rem;
        }

        .remember-row input {
            width: 17px;
            height: 17px;
            accent-color: var(--primary);
        }

        .submit-button {
            width: 100%;
            padding: 14px 20px;
            border: 0;
            border-radius: 12px;
            background: var(--primary);
            color: #ffffff;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 800;
            transition:
                background 0.2s,
                transform 0.2s;
        }

        .submit-button:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .register-text {
            margin: 24px 0 0;
            color: var(--muted);
            text-align: center;
        }

        .register-text a {
            color: var(--primary);
            font-weight: 800;
            text-decoration: none;
        }

        .register-text a:hover {
            text-decoration: underline;
        }

        .security-notice {
            margin: 24px 0 0;
            color: var(--muted);
            font-size: 0.8rem;
            line-height: 1.5;
            text-align: center;
        }

        @media (max-width: 860px) {
            .page {
                grid-template-columns: 1fr;
            }

            .presentation {
                padding: 36px 24px;
            }

            .brand {
                margin-bottom: 28px;
            }

            .presentation h1 {
                font-size: 2.3rem;
            }
        }

        @media (max-width: 480px) {
            .form-section {
                padding: 32px 18px;
            }

            .form-header h2 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>

<body>
    <main class="page">
        <section class="presentation">
            <div class="presentation-content">
                <a class="brand" href="{{ route('inicio') }}">
                    NexoAprende
                </a>

                <h1>
                    Bienvenido nuevamente
                </h1>

                <p>
                    Inicia sesión para administrar los perfiles infantiles,
                    acceder a sus actividades y consultar su progreso.
                </p>
            </div>
        </section>

        <section class="form-section">
            <div class="form-container">
                <a class="back-link" href="{{ route('inicio') }}">
                    ← Volver al inicio
                </a>

                <header class="form-header">
                    <h2>Iniciar sesión</h2>

                    <p>
                        Ingresa con la cuenta registrada por el tutor.
                    </p>
                </header>

                @if ($errors->any())
                    <div
                        class="error-summary"
                        role="alert"
                        aria-live="polite"
                    >
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}">
                    @csrf

                    <div class="field">
                        <label for="email">
                            Correo electrónico
                        </label>

                        <input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            autocomplete="email"
                            maxlength="255"
                            required
                            autofocus
                            aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                        >

                        @error('email')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password">
                            Contraseña
                        </label>

                        <input
                            id="password"
                            name="password"
                            type="password"
                            autocomplete="current-password"
                            required
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                        >

                        @error('password')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="remember-row">
                        <label for="remember">
                            <input
                                id="remember"
                                name="remember"
                                type="checkbox"
                                value="1"
                            >

                            Mantener mi sesión iniciada
                        </label>
                    </div>

                    <button class="submit-button" type="submit">
                        Iniciar sesión
                    </button>
                </form>

                <p class="register-text">
                    ¿Todavía no tienes una cuenta?

                    <a href="{{ route('register') }}">
                        Crear cuenta
                    </a>
                </p>

                <p class="security-notice">
                    Tu contraseña se procesa de forma segura y no se
                    almacena como texto visible.
                </p>
            </div>
        </section>
    </main>
</body>
</html>
