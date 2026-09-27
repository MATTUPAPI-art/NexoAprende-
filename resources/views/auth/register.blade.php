<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Crear cuenta | NexoAprende</title>

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
                    circle at top left,
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
            margin: 0 0 34px;
            color: #e8e5ff;
            font-size: 1.05rem;
            line-height: 1.7;
        }

        .feature-list {
            display: grid;
            gap: 16px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .feature-list li {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            line-height: 1.5;
        }

        .feature-icon {
            display: grid;
            flex: 0 0 28px;
            width: 28px;
            height: 28px;
            place-items: center;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.18);
            font-weight: 800;
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

        .error-summary strong {
            display: block;
            margin-bottom: 8px;
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

        .field input {
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

        .field input[aria-invalid="true"] {
            border-color: var(--danger);
        }

        .field-hint {
            display: block;
            margin-top: 7px;
            color: var(--muted);
            font-size: 0.83rem;
            line-height: 1.4;
        }

        .field-error {
            display: block;
            margin-top: 7px;
            color: var(--danger);
            font-size: 0.85rem;
        }

        .submit-button {
            width: 100%;
            margin-top: 8px;
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

        .login-text {
            margin: 24px 0 0;
            color: var(--muted);
            text-align: center;
        }

        .login-text a {
            color: var(--primary);
            font-weight: 800;
            text-decoration: none;
        }

        .login-text a:hover {
            text-decoration: underline;
        }

        .privacy-notice {
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

            .feature-list {
                display: none;
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
                    Acompaña su aprendizaje paso a paso
                </h1>

                <p>
                    Crea tu cuenta de tutor para administrar perfiles
                    infantiles y consultar el progreso de sus actividades.
                </p>

                <ul class="feature-list">
                    <li>
                        <span class="feature-icon">✓</span>

                        <span>
                            Actividades educativas sencillas y accesibles.
                        </span>
                    </li>

                    <li>
                        <span class="feature-icon">✓</span>

                        <span>
                            Resultados descriptivos y fáciles de comprender.
                        </span>
                    </li>

                    <li>
                        <span class="feature-icon">✓</span>

                        <span>
                            Información administrada por el tutor.
                        </span>
                    </li>
                </ul>
            </div>
        </section>

        <section class="form-section">
            <div class="form-container">
                <a class="back-link" href="{{ route('inicio') }}">
                    ← Volver al inicio
                </a>

                <header class="form-header">
                    <h2>Crear cuenta de tutor</h2>

                    <p>
                        Completa tus datos para comenzar a utilizar
                        NexoAprende.
                    </p>
                </header>

                @if ($errors->any())
                    <div
                        class="error-summary"
                        role="alert"
                        aria-live="polite"
                    >
                        <strong>
                            Revisa los datos ingresados:
                        </strong>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="field">
                        <label for="name">
                            Nombre completo
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            autocomplete="name"
                            maxlength="255"
                            required
                            autofocus
                            aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                        >

                        @error('name')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

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
                            autocomplete="new-password"
                            required
                            aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                        >

                        <span class="field-hint">
                            Utiliza al menos 8 caracteres.
                        </span>

                        @error('password')
                            <span class="field-error">
                                {{ $message }}
                            </span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="password_confirmation">
                            Confirmar contraseña
                        </label>

                        <input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            autocomplete="new-password"
                            required
                        >
                    </div>

                    <button class="submit-button" type="submit">
                        Crear mi cuenta
                    </button>
                </form>

                <p class="login-text">
                    ¿Ya tienes una cuenta?

                    <a href="{{ route('login') }}">
                        Iniciar sesión
                    </a>
                </p>

                <p class="privacy-notice">
                    La cuenta pertenece al tutor. Los perfiles infantiles
                    serán administrados posteriormente desde un espacio
                    privado.
                </p>
            </div>
        </section>
    </main>
</body>
</html>
