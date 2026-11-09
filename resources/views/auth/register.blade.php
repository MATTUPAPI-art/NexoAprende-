<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Registro de tutor | NexoAprende</title>

    <style>
        :root {
            --primary: #5747e8;
            --primary-dark: #4031bd;
            --primary-soft: #efedff;
            --background: #f4f7fc;
            --surface: #ffffff;
            --text: #182235;
            --muted: #68758a;
            --border: #dfe5ef;
            --danger: #b42318;
            --danger-soft: #fff1f0;
            --shadow: 0 24px 70px rgba(31, 45, 78, 0.14);
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            display: grid;
            place-items: center;
            padding: 28px 16px;
            color: var(--text);
            background:
                radial-gradient(
                    circle at 12% 10%,
                    rgba(87, 71, 232, 0.18),
                    transparent 34%
                ),
                radial-gradient(
                    circle at 88% 90%,
                    rgba(25, 135, 84, 0.12),
                    transparent 30%
                ),
                var(--background);
            font-family: Arial, Helvetica, sans-serif;
        }

        .auth-shell {
            width: min(1000px, 100%);
            overflow: hidden;
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            border: 1px solid rgba(223, 229, 239, 0.9);
            border-radius: 28px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .presentation {
            padding: 48px 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 36px;
            color: #ffffff;
            background:
                radial-gradient(
                    circle at 80% 20%,
                    rgba(255, 255, 255, 0.16),
                    transparent 25%
                ),
                linear-gradient(
                    145deg,
                    #6455ef,
                    #4031bd
                );
        }

        .brand {
            color: #ffffff;
            font-size: 1.45rem;
            font-weight: 900;
            letter-spacing: -0.03em;
            text-decoration: none;
        }

        .presentation h1 {
            max-width: 430px;
            margin: 0 0 18px;
            font-size: clamp(2.25rem, 5vw, 3.5rem);
            line-height: 1.02;
            letter-spacing: -0.05em;
        }

        .presentation p {
            max-width: 430px;
            margin: 0;
            color: rgba(255, 255, 255, 0.84);
            line-height: 1.7;
        }

        .feature-list {
            margin: 25px 0 0;
            padding: 0;
            display: grid;
            gap: 12px;
            list-style: none;
        }

        .feature-list li {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .feature-list li::before {
            width: 21px;
            height: 21px;
            flex: 0 0 21px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            content: "✓";
            color: #ffffff;
            background: rgba(255, 255, 255, 0.18);
            font-size: 0.72rem;
            font-weight: 900;
        }

        .privacy-note {
            padding: 17px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 17px;
            background: rgba(255, 255, 255, 0.1);
            font-size: 0.86rem;
            line-height: 1.55;
        }

        .form-section {
            padding: 42px 48px;
        }

        .form-container {
            width: 100%;
            max-width: 470px;
            margin: 0 auto;
        }

        .form-header {
            margin-bottom: 23px;
        }

        .form-header h2 {
            margin: 0 0 9px;
            font-size: 2rem;
            letter-spacing: -0.035em;
        }

        .form-header p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .errors {
            margin-bottom: 18px;
            padding: 13px 15px;
            border: 1px solid #ffc9c5;
            border-radius: 13px;
            color: var(--danger);
            background: var(--danger-soft);
            font-size: 0.88rem;
            line-height: 1.5;
        }

        .errors ul {
            margin: 0;
            padding-left: 19px;
        }

        .google-access {
            margin-bottom: 21px;
        }

        .google-button {
            width: 100%;
            min-height: 48px;
            padding: 11px 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 11px;
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--text);
            background: #ffffff;
            font-size: 0.93rem;
            font-weight: 800;
            text-decoration: none;
            cursor: pointer;
            transition:
                border-color 150ms ease,
                background 150ms ease,
                transform 150ms ease,
                box-shadow 150ms ease;
        }

        .google-button:hover {
            border-color: #b9c2d1;
            background: #f8f9fc;
            transform: translateY(-1px);
            box-shadow: 0 7px 18px rgba(31, 45, 78, 0.08);
        }

        .google-button:focus-visible {
            outline: 4px solid var(--primary-soft);
            outline-offset: 2px;
        }

        .google-icon {
            width: 20px;
            height: 20px;
            flex: 0 0 20px;
        }

        .form-divider {
            margin: 18px 0;
            display: flex;
            align-items: center;
            gap: 12px;
            color: var(--muted);
            font-size: 0.78rem;
            font-weight: 700;
        }

        .form-divider::before,
        .form-divider::after {
            height: 1px;
            flex: 1;
            content: "";
            background: var(--border);
        }

        .field {
            margin-bottom: 16px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 0.89rem;
            font-weight: 800;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            min-height: 47px;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            color: var(--text);
            background: #ffffff;
            font: inherit;
            transition:
                border-color 150ms ease,
                box-shadow 150ms ease;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .field-error {
            display: block;
            margin-top: 7px;
            color: var(--danger);
            font-size: 0.8rem;
        }

        .field-help {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 0.78rem;
            line-height: 1.45;
        }

        .submit-button {
            width: 100%;
            min-height: 50px;
            margin-top: 4px;
            border: 0;
            border-radius: 13px;
            color: #ffffff;
            background: var(--primary);
            font: inherit;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 10px 24px rgba(87, 71, 232, 0.25);
            transition:
                transform 150ms ease,
                background 150ms ease;
        }

        .submit-button:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .submit-button:focus-visible {
            outline: 4px solid rgba(87, 71, 232, 0.25);
            outline-offset: 3px;
        }

        .legal-note {
            margin: 14px 0 0;
            color: var(--muted);
            font-size: 0.77rem;
            line-height: 1.5;
            text-align: center;
        }

        .account-options {
            margin-top: 21px;
            padding-top: 19px;
            border-top: 1px solid var(--border);
            color: var(--muted);
            text-align: center;
            font-size: 0.87rem;
            line-height: 1.7;
        }

        .account-options a {
            color: var(--primary-dark);
            font-weight: 800;
            text-decoration: none;
        }

        .account-options a:hover {
            text-decoration: underline;
        }

        @media (max-width: 820px) {
            .auth-shell {
                grid-template-columns: 1fr;
            }

            .presentation {
                padding: 36px 26px;
            }

            .presentation h1 {
                font-size: 2.35rem;
            }

            .privacy-note {
                display: none;
            }

            .form-section {
                padding: 38px 26px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 0;
                background: var(--surface);
            }

            .auth-shell {
                min-height: 100vh;
                border: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .presentation {
                padding: 28px 20px;
            }

            .presentation h1 {
                font-size: 2rem;
            }

            .feature-list {
                display: none;
            }

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
    <main class="auth-shell">
        <section class="presentation">
            <a class="brand" href="{{ route('inicio') }}">
                NexoAprende
            </a>

            <div>
                <h1>Acompaña su aprendizaje paso a paso.</h1>

                <p>
                    Crea una cuenta de padre o tutor para gestionar perfiles,
                    acceder a actividades educativas y consultar avances.
                </p>

                <ul class="feature-list">
                    <li>
                        Perfiles protegidos bajo la responsabilidad del tutor.
                    </li>

                    <li>
                        Actividades adaptadas a la edad del estudiante.
                    </li>

                    <li>
                        Seguimiento descriptivo de sesiones y resultados.
                    </li>

                    <li>
                        Autorización expresa para compartir información con
                        profesionales.
                    </li>
                </ul>
            </div>

            <div class="privacy-note">
                El niño o adolescente no crea una cuenta independiente.
                Su perfil será administrado por un padre o tutor responsable.
            </div>
        </section>

        <section class="form-section">
            <div class="form-container">
                <header class="form-header">
                    <h2>Crear cuenta de tutor</h2>

                    <p>
                        Regístrate con Google o completa tus datos.
                    </p>
                </header>

                @if ($errors->any())
                    <div class="errors" role="alert">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="google-access">
                    <a
                        class="google-button"
                        href="{{ route('auth.google.redirect') }}"
                    >
                        <svg
                            class="google-icon"
                            viewBox="0 0 24 24"
                            aria-hidden="true"
                        >
                            <path
                                fill="#4285F4"
                                d="M21.6 12.23c0-.71-.06-1.4-.18-2.06H12v3.9h5.38a4.6 4.6 0 0 1-2 3.02v2.53h3.24c1.9-1.75 2.98-4.33 2.98-7.39Z"
                            />
                            <path
                                fill="#34A853"
                                d="M12 22c2.7 0 4.98-.9 6.64-2.42l-3.24-2.53c-.9.6-2.05.96-3.4.96-2.61 0-4.82-1.76-5.61-4.13H3.04v2.6A10 10 0 0 0 12 22Z"
                            />
                            <path
                                fill="#FBBC05"
                                d="M6.39 13.88A6 6 0 0 1 6.08 12c0-.65.11-1.28.31-1.88v-2.6H3.04A10 10 0 0 0 2 12c0 1.61.38 3.13 1.04 4.48l3.35-2.6Z"
                            />
                            <path
                                fill="#EA4335"
                                d="M12 5.99c1.47 0 2.79.5 3.83 1.49l2.88-2.88A9.65 9.65 0 0 0 12 2a10 10 0 0 0-8.96 5.52l3.35 2.6C7.18 7.75 9.39 5.99 12 5.99Z"
                            />
                        </svg>

                        Registrarme como tutor con Google
                    </a>

                    <div class="form-divider">
                        o completa el formulario
                    </div>
                </div>

                <form method="POST" action="{{ route('register.store') }}">
                    @csrf

                    <div class="field">
                        <label for="name">
                            Nombre completo del padre o tutor
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            value="{{ old('name') }}"
                            maxlength="255"
                            autocomplete="name"
                            required
                            autofocus
                            aria-invalid="{{ $errors->has('name')
                                ? 'true'
                                : 'false' }}"
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
                            maxlength="255"
                            autocomplete="email"
                            required
                            aria-invalid="{{ $errors->has('email')
                                ? 'true'
                                : 'false' }}"
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
                            aria-invalid="{{ $errors->has('password')
                                ? 'true'
                                : 'false' }}"
                        >

                        <p class="field-help">
                            Utiliza una contraseña segura que no emplees en
                            otros servicios.
                        </p>

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
                        Crear mi cuenta de tutor
                    </button>

                    <p class="legal-note">
                        Al registrarte confirmas que eres padre, madre o tutor
                        responsable. NexoAprende es una herramienta educativa
                        y no realiza diagnósticos clínicos.
                    </p>
                </form>

                <div class="account-options">
                    ¿Ya tienes una cuenta?

                    <a href="{{ route('login') }}">
                        Iniciar sesión
                    </a>

                    <br>

                    ¿Eres especialista?

                    <a href="{{ route('professional.register') }}">
                        Crear cuenta profesional
                    </a>
                </div>
            </div>
        </section>
    </main>
</body>
</html>
