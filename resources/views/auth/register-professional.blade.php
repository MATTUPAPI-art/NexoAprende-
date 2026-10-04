<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Registro profesional | NexoAprende</title>

    <style>
        :root {
            --primary: #5747e8;
            --primary-dark: #4031bd;
            --primary-soft: #efedff;
            --accent: #16805d;
            --background: #f5f7fc;
            --surface: #ffffff;
            --text: #182235;
            --muted: #68758a;
            --border: #dfe5ef;
            --danger: #b42318;
            --danger-soft: #fff1f0;
            --shadow: 0 18px 45px rgba(31, 45, 78, 0.1);
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
                    #e9e6ff 0,
                    transparent 35%
                ),
                var(--background);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        .page {
            display: grid;
            grid-template-columns: 0.85fr 1.15fr;
            min-height: 100vh;
        }

        .presentation {
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px;
            background: linear-gradient(145deg, #5747e8, #4031bd);
            color: #ffffff;
        }

        .presentation-content {
            width: min(470px, 100%);
        }

        .brand {
            display: inline-block;
            margin-bottom: 46px;
            color: #ffffff;
            font-size: 1.55rem;
            font-weight: 900;
            text-decoration: none;
        }

        .presentation h1 {
            margin: 0 0 18px;
            font-size: clamp(2.2rem, 5vw, 3.6rem);
            line-height: 1.05;
        }

        .presentation p {
            margin: 0 0 30px;
            color: #e8e5ff;
            line-height: 1.7;
        }

        .notice {
            padding: 18px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.12);
            line-height: 1.6;
        }

        .form-section {
            display: flex;
            justify-content: center;
            padding: 40px 24px;
        }

        .form-container {
            width: min(650px, 100%);
        }

        .back-link {
            display: inline-flex;
            margin-bottom: 25px;
            color: var(--primary);
            font-weight: 800;
            text-decoration: none;
        }

        .form-header {
            margin-bottom: 25px;
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

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 0 18px;
        }

        .field {
            margin-bottom: 18px;
        }

        .field-full {
            grid-column: 1 / -1;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.94rem;
            font-weight: 800;
        }

        .field input,
        .field textarea {
            width: 100%;
            padding: 13px 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            background: var(--surface);
            color: var(--text);
            font: inherit;
        }

        .field textarea {
            min-height: 110px;
            resize: vertical;
        }

        .field input:focus,
        .field textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .field-hint,
        .field-error {
            display: block;
            margin-top: 7px;
            font-size: 0.83rem;
            line-height: 1.4;
        }

        .field-hint {
            color: var(--muted);
        }

        .field-error {
            color: var(--danger);
        }

        .submit-button {
            width: 100%;
            padding: 15px 20px;
            border: 0;
            border-radius: 12px;
            background: var(--primary);
            color: #ffffff;
            cursor: pointer;
            font-size: 1rem;
            font-weight: 900;
        }

        .submit-button:hover {
            background: var(--primary-dark);
        }

        .login-text {
            margin: 22px 0 0;
            color: var(--muted);
            text-align: center;
        }

        .login-text a {
            color: var(--primary);
            font-weight: 800;
        }

        @media (max-width: 900px) {
            .page {
                grid-template-columns: 1fr;
            }

            .presentation {
                padding: 34px 24px;
            }

            .brand {
                margin-bottom: 24px;
            }
        }

        @media (max-width: 620px) {
            .form-grid {
                grid-template-columns: 1fr;
            }

            .field-full {
                grid-column: auto;
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

                <h1>Espacio para profesionales</h1>

                <p>
                    Registra tu perfil para participar en el acompañamiento
                    educativo de las familias.
                </p>

                <div class="notice">
                    La cuenta profesional no realiza diagnósticos clínicos.
                    Su función será orientar y consultar únicamente la
                    información que las familias autoricen.
                </div>
            </div>
        </section>

        <section class="form-section">
            <div class="form-container">
                <a class="back-link" href="{{ route('register') }}">
                    ← Volver al registro de tutor
                </a>

                <header class="form-header">
                    <h2>Crear cuenta profesional</h2>

                    <p>
                        Completa tus datos personales y profesionales.
                    </p>
                </header>

                @if ($errors->any())
                    <div class="error-summary" role="alert">
                        <strong>Revisa los datos ingresados:</strong>

                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    method="POST"
                    action="{{ route('professional.register.store') }}"
                >
                    @csrf

                    <div class="form-grid">
                        <div class="field field-full">
                            <label for="name">Nombre completo</label>

                            <input
                                id="name"
                                name="name"
                                type="text"
                                value="{{ old('name') }}"
                                maxlength="255"
                                autocomplete="name"
                                required
                                autofocus
                            >

                            @error('name')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field field-full">
                            <label for="email">Correo electrónico</label>

                            <input
                                id="email"
                                name="email"
                                type="email"
                                value="{{ old('email') }}"
                                maxlength="255"
                                autocomplete="email"
                                required
                            >

                            @error('email')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="specialty">Especialidad</label>

                            <input
                                id="specialty"
                                name="specialty"
                                type="text"
                                value="{{ old('specialty') }}"
                                maxlength="100"
                                placeholder="Ej.: Psicopedagogía"
                                required
                            >

                            @error('specialty')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="license_number">
                                Número de matrícula
                            </label>

                            <input
                                id="license_number"
                                name="license_number"
                                type="text"
                                value="{{ old('license_number') }}"
                                maxlength="80"
                                required
                            >

                            @error('license_number')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field field-full">
                            <label for="years_experience">
                                Años de experiencia
                            </label>

                            <input
                                id="years_experience"
                                name="years_experience"
                                type="number"
                                value="{{ old('years_experience', 0) }}"
                                min="0"
                                max="60"
                                required
                            >

                            @error('years_experience')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field field-full">
                            <label for="biography">
                                Presentación profesional
                            </label>

                            <textarea
                                id="biography"
                                name="biography"
                                maxlength="1000"
                                placeholder="Describe brevemente tu experiencia y área de trabajo."
                            >{{ old('biography') }}</textarea>

                            <span class="field-hint">
                                Campo opcional. Máximo 1000 caracteres.
                            </span>

                            @error('biography')
                                <span class="field-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="field">
                            <label for="password">Contraseña</label>

                            <input
                                id="password"
                                name="password"
                                type="password"
                                autocomplete="new-password"
                                required
                            >

                            <span class="field-hint">
                                Utiliza al menos 8 caracteres.
                            </span>

                            @error('password')
                                <span class="field-error">{{ $message }}</span>
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
                    </div>

                    <button class="submit-button" type="submit">
                        Crear cuenta profesional
                    </button>
                </form>

                <p class="login-text">
                    ¿Ya tienes una cuenta?

                    <a href="{{ route('login') }}">
                        Iniciar sesión
                    </a>
                </p>
            </div>
        </section>
    </main>
</body>
</html>
