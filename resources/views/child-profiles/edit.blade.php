<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Editar perfil de {{ $childProfile->name }} | NexoAprende
    </title>

    <style>
        :root {
            --primary: #5747e8;
            --primary-dark: #4031bd;
            --primary-soft: #efedff;
            --background: #f5f7fc;
            --surface: #ffffff;
            --text: #182235;
            --muted: #68758a;
            --border: #dfe5ef;
            --danger: #b42318;
            --danger-soft: #fff1f0;
            --shadow: 0 20px 55px rgba(31, 45, 78, 0.12);
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            color: var(--text);
            background:
                radial-gradient(
                    circle at top right,
                    #e9e6ff 0,
                    transparent 35%
                ),
                var(--background);
            font-family:
                Inter, system-ui, -apple-system, BlinkMacSystemFont,
                "Segoe UI", sans-serif;
        }

        button,
        input {
            font: inherit;
        }

        .topbar {
            border-bottom: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
        }

        .navigation {
            display: flex;
            width: min(1080px, calc(100% - 32px));
            min-height: 74px;
            margin: 0 auto;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand {
            color: var(--primary);
            font-size: 1.25rem;
            font-weight: 900;
            text-decoration: none;
        }

        .back-link {
            display: inline-flex;
            min-height: 42px;
            padding: 10px 15px;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--border);
            border-radius: 11px;
            color: var(--text);
            background: #ffffff;
            font-size: 0.92rem;
            font-weight: 800;
            text-decoration: none;
            transition: 0.2s ease;
        }

        .back-link:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-soft);
        }

        .page {
            display: grid;
            width: min(920px, calc(100% - 32px));
            min-height: calc(100vh - 75px);
            margin: 0 auto;
            padding: 52px 0;
            place-items: center;
        }

        .edit-layout {
            display: grid;
            width: 100%;
            grid-template-columns: 0.85fr 1.15fr;
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 24px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .information {
            display: flex;
            padding: 42px;
            justify-content: space-between;
            flex-direction: column;
            color: #ffffff;
            background:
                linear-gradient(
                    145deg,
                    var(--primary),
                    var(--primary-dark)
                );
        }

        .profile-icon {
            display: grid;
            width: 72px;
            height: 72px;
            margin-bottom: 28px;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, 0.28);
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.14);
            font-size: 2rem;
            font-weight: 900;
        }

        .information h1 {
            margin: 0 0 14px;
            font-size: clamp(1.8rem, 4vw, 2.6rem);
            line-height: 1.1;
        }

        .information p {
            margin: 0;
            color: rgba(255, 255, 255, 0.82);
            line-height: 1.7;
        }

        .privacy-note {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            color: rgba(255, 255, 255, 0.75);
            font-size: 0.82rem;
            line-height: 1.5;
        }

        .form-section {
            padding: 42px;
        }

        .eyebrow {
            display: inline-flex;
            margin: 0 0 12px;
            padding: 7px 11px;
            border-radius: 999px;
            color: var(--primary-dark);
            background: var(--primary-soft);
            font-size: 0.75rem;
            font-weight: 900;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        .form-section h2 {
            margin: 0 0 8px;
            font-size: 1.65rem;
        }

        .description {
            margin: 0 0 30px;
            color: var(--muted);
            line-height: 1.6;
        }

        .field {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 0.9rem;
            font-weight: 800;
        }

        input {
            width: 100%;
            min-height: 50px;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            color: var(--text);
            background: #ffffff;
            transition:
                border-color 0.2s ease,
                box-shadow 0.2s ease;
        }

        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(87, 71, 232, 0.12);
        }

        .field-help {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 0.8rem;
            line-height: 1.5;
        }

        .error-message {
            margin: 7px 0 0;
            color: var(--danger);
            font-size: 0.82rem;
            font-weight: 700;
        }

        .form-actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-top: 30px;
        }

        .button {
            display: inline-flex;
            min-height: 50px;
            padding: 12px 18px;
            align-items: center;
            justify-content: center;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 850;
            text-decoration: none;
            transition:
                transform 0.2s ease,
                background 0.2s ease;
        }

        .button:hover {
            transform: translateY(-1px);
        }

        .button-primary {
            border: 1px solid var(--primary);
            color: #ffffff;
            background: var(--primary);
        }

        .button-primary:hover {
            background: var(--primary-dark);
        }

        .button-secondary {
            border: 1px solid var(--border);
            color: var(--text);
            background: #ffffff;
        }

        .button-secondary:hover {
            border-color: var(--primary);
            color: var(--primary);
            background: var(--primary-soft);
        }

        @media (max-width: 760px) {
            .page {
                padding: 28px 0;
            }

            .edit-layout {
                grid-template-columns: 1fr;
            }

            .information,
            .form-section {
                padding: 30px 24px;
            }

            .privacy-note {
                margin-top: 25px;
            }
        }

        @media (max-width: 480px) {
            .navigation {
                padding: 12px 0;
                align-items: flex-start;
                flex-direction: column;
            }

            .form-actions {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <header class="topbar">
        <nav class="navigation" aria-label="Navegación principal">
            <a class="brand" href="{{ route('inicio') }}">
                NexoAprende
            </a>

            <a class="back-link" href="{{ route('dashboard') }}">
                ← Volver al panel
            </a>
        </nav>
    </header>

    <main class="page">
        <div class="edit-layout">
            <section class="information">
                <div>
                    <div class="profile-icon" aria-hidden="true">
                        {{ mb_strtoupper(
                            mb_substr($childProfile->name, 0, 1)
                        ) }}
                    </div>

                    <h1>
                        Perfil de {{ $childProfile->name }}
                    </h1>

                    <p>
                        Actualiza su nombre o edad. La edad permite
                        adaptar la experiencia y las actividades a su
                        etapa escolar.
                    </p>
                </div>

                <div class="privacy-note">
                    Los cambios realizados no eliminarán los resultados
                    ni el historial de actividades del perfil.
                </div>
            </section>

            <section class="form-section">
                <p class="eyebrow">Administrar perfil</p>

                <h2>Editar información</h2>

                <p class="description">
                    Revisa los datos antes de guardar los cambios.
                </p>

                <form
                    method="POST"
                    action="{{ route(
                        'child-profiles.update',
                        $childProfile
                    ) }}"
                >
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label for="name">
                            Nombre del niño o adolescente
                        </label>

                        <input
                            id="name"
                            name="name"
                            type="text"
                            maxlength="60"
                            value="{{ old(
                                'name',
                                $childProfile->name
                            ) }}"
                            required
                            autofocus
                            autocomplete="off"
                        >

                        @error('name')
                            <p class="error-message">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="age">Edad</label>

                        <input
                            id="age"
                            name="age"
                            type="number"
                            min="5"
                            max="18"
                            value="{{ old(
                                'age',
                                $childProfile->age
                            ) }}"
                            required
                        >

                        <p class="field-help">
                            La edad permitida está entre 5 y 18 años.
                        </p>

                        @error('age')
                            <p class="error-message">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <a
                            class="button button-secondary"
                            href="{{ route('dashboard') }}"
                        >
                            Cancelar
                        </a>

                        <button
                            class="button button-primary"
                            type="submit"
                        >
                            Guardar cambios
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </main>
</body>
</html>
