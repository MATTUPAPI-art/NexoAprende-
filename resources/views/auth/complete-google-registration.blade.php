<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Completar registro | NexoAprende</title>

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
            --success: #198754;
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
                    circle at 10% 10%,
                    rgba(87, 71, 232, 0.17),
                    transparent 32%
                ),
                radial-gradient(
                    circle at 90% 90%,
                    rgba(25, 135, 84, 0.12),
                    transparent 30%
                ),
                var(--background);
            font-family: Arial, Helvetica, sans-serif;
        }

        .registration-shell {
            width: min(940px, 100%);
            overflow: hidden;
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            border: 1px solid rgba(223, 229, 239, 0.9);
            border-radius: 28px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .welcome-panel {
            padding: 46px 38px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 36px;
            color: #ffffff;
            background:
                linear-gradient(
                    145deg,
                    rgba(87, 71, 232, 0.96),
                    rgba(64, 49, 189, 0.98)
                );
        }

        .brand {
            margin: 0;
            font-size: 1.45rem;
            font-weight: 900;
            letter-spacing: -0.03em;
        }

        .welcome-panel h1 {
            max-width: 420px;
            margin: 0 0 16px;
            font-size: clamp(2rem, 4vw, 3rem);
            line-height: 1.05;
            letter-spacing: -0.045em;
        }

        .welcome-panel p {
            margin: 0;
            color: rgba(255, 255, 255, 0.85);
            font-size: 1rem;
            line-height: 1.7;
        }

        .security-note {
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, 0.22);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.1);
            font-size: 0.88rem;
            line-height: 1.55;
        }

        .form-panel {
            padding: 42px;
        }

        .form-panel h2 {
            margin: 0 0 8px;
            font-size: 1.7rem;
            letter-spacing: -0.025em;
        }

        .form-description {
            margin: 0 0 26px;
            color: var(--muted);
            line-height: 1.6;
        }

        .google-account {
            margin-bottom: 25px;
            padding: 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: #fafbff;
        }

        .account-avatar,
        .account-placeholder {
            width: 48px;
            height: 48px;
            flex: 0 0 48px;
            border-radius: 50%;
        }

        .account-avatar {
            object-fit: cover;
            border: 2px solid #ffffff;
            box-shadow: 0 3px 10px rgba(31, 45, 78, 0.12);
        }

        .account-placeholder {
            display: grid;
            place-items: center;
            color: #ffffff;
            background: var(--primary);
            font-size: 1.1rem;
            font-weight: 900;
        }

        .account-information {
            min-width: 0;
        }

        .account-information strong,
        .account-information span {
            display: block;
            overflow-wrap: anywhere;
        }

        .account-information span {
            margin-top: 4px;
            color: var(--muted);
            font-size: 0.87rem;
        }

        .verified-label {
            margin-left: auto;
            padding: 6px 9px;
            border-radius: 999px;
            color: var(--success);
            background: #eaf8f0;
            font-size: 0.72rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .errors {
            margin-bottom: 20px;
            padding: 14px 16px;
            border: 1px solid #ffc9c5;
            border-radius: 14px;
            color: var(--danger);
            background: var(--danger-soft);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .errors ul {
            margin: 0;
            padding-left: 20px;
        }

        .field {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 0.9rem;
            font-weight: 800;
        }

        input[type="text"],
        input[type="email"],
        input[type="password"] {
            width: 100%;
            min-height: 48px;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            color: var(--text);
            background: #ffffff;
            font: inherit;
            transition:
                border-color 160ms ease,
                box-shadow 160ms ease;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        input:disabled {
            color: var(--muted);
            background: #f3f5f9;
            cursor: not-allowed;
        }

        .field-help {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 0.79rem;
            line-height: 1.45;
        }

        .terms {
            margin: 5px 0 22px;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            color: var(--muted);
            font-size: 0.87rem;
            line-height: 1.5;
        }

        .terms input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            flex: 0 0 18px;
            accent-color: var(--primary);
        }

        .submit-button {
            width: 100%;
            min-height: 50px;
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

        .login-link {
            margin: 20px 0 0;
            color: var(--muted);
            text-align: center;
            font-size: 0.87rem;
        }

        .login-link a {
            color: var(--primary-dark);
            font-weight: 800;
            text-decoration: none;
        }

        .login-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 780px) {
            .registration-shell {
                grid-template-columns: 1fr;
            }

            .welcome-panel {
                padding: 30px 26px;
            }

            .welcome-panel h1 {
                font-size: 2rem;
            }

            .security-note {
                display: none;
            }

            .form-panel {
                padding: 30px 24px;
            }
        }

        @media (max-width: 480px) {
            body {
                padding: 0;
                background: var(--surface);
            }

            .registration-shell {
                min-height: 100vh;
                border: 0;
                border-radius: 0;
                box-shadow: none;
            }

            .verified-label {
                display: none;
            }
        }
    </style>
</head>

<body>
    <main class="registration-shell">
        <section class="welcome-panel">
            <p class="brand">NexoAprende</p>

            <div>
                <h1>Un último paso para comenzar.</h1>

                <p>
                    Confirma tus datos y crea una contraseña para que
                    también puedas ingresar con tu correo desde cualquier
                    dispositivo.
                </p>
            </div>

            <div class="security-note">
                La cuenta será creada como padre o tutor. Los perfiles de
                menores solo podrán ser gestionados desde esta cuenta.
            </div>
        </section>

        <section class="form-panel">
            <h2>Completa tu registro</h2>

            <p class="form-description">
                Tu correo ya fue verificado de forma segura mediante Google.
            </p>

            <div class="google-account">
                @if ($googleRegistration['avatar_url'])
                    <img
                        class="account-avatar"
                        src="{{ $googleRegistration['avatar_url'] }}"
                        alt=""
                        referrerpolicy="no-referrer"
                    >
                @else
                    <div class="account-placeholder" aria-hidden="true">
                        {{ mb_strtoupper(
                            mb_substr($googleRegistration['name'], 0, 1)
                        ) }}
                    </div>
                @endif

                <div class="account-information">
                    <strong>
                        {{ $googleRegistration['name'] }}
                    </strong>

                    <span>
                        {{ $googleRegistration['email'] }}
                    </span>
                </div>

                <span class="verified-label">
                    Verificado
                </span>
            </div>

            @if ($errors->any())
                <div class="errors" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('auth.google.complete.store') }}"
            >
                @csrf

                <div class="field">
                    <label for="name">
                        Nombre completo del padre o tutor
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old(
                            'name',
                            $googleRegistration['name']
                        ) }}"
                        maxlength="255"
                        autocomplete="name"
                        required
                        autofocus
                    >
                </div>

                <div class="field">
                    <label for="email">
                        Correo verificado
                    </label>

                    <input
                        id="email"
                        type="email"
                        value="{{ $googleRegistration['email'] }}"
                        disabled
                    >
                </div>

                <div class="field">
                    <label for="password">
                        Crea una contraseña para NexoAprende
                    </label>

                    <input
                        id="password"
                        name="password"
                        type="password"
                        autocomplete="new-password"
                        required
                    >

                    <p class="field-help">
                        Utiliza una contraseña segura que no uses en otros
                        servicios.
                    </p>
                </div>

                <div class="field">
                    <label for="password_confirmation">
                        Confirma tu contraseña
                    </label>

                    <input
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        autocomplete="new-password"
                        required
                    >
                </div>

                <label class="terms" for="terms">
                    <input
                        id="terms"
                        name="terms"
                        type="checkbox"
                        value="1"
                        @checked(old('terms'))
                        required
                    >

                    <span>
                        Confirmo que soy padre, madre o tutor responsable y
                        acepto el uso educativo de la plataforma. Comprendo
                        que NexoAprende no realiza diagnósticos clínicos.
                    </span>
                </label>

                <button class="submit-button" type="submit">
                    Crear mi cuenta de tutor
                </button>
            </form>

            <p class="login-link">
                ¿Deseas usar otra cuenta?
                <a href="{{ route('login') }}">
                    Volver al inicio de sesión
                </a>
            </p>
        </section>
    </main>
</body>
</html>
