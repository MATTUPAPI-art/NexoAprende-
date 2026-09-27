<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Crear perfil infantil | NexoAprende</title>

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
            --shadow: 0 18px 45px rgba(31, 45, 78, 0.09);
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
                    #eeecff,
                    transparent 35%
                ),
                var(--background);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        .topbar {
            border-bottom: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.95);
        }

        .nav {
            display: flex;
            width: min(1000px, calc(100% - 32px));
            min-height: 72px;
            margin: 0 auto;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        .brand {
            color: var(--primary);
            font-size: 1.3rem;
            font-weight: 900;
            text-decoration: none;
        }

        .back-link {
            padding: 10px 14px;
            border-radius: 10px;
            color: var(--primary);
            font-weight: 800;
            text-decoration: none;
        }

        .back-link:hover {
            background: var(--primary-soft);
        }

        .container {
            width: min(620px, calc(100% - 32px));
            margin: 0 auto;
            padding: 50px 0;
        }

        .card {
            padding: 32px;
            border: 1px solid var(--border);
            border-radius: 22px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .icon {
            display: grid;
            width: 56px;
            height: 56px;
            margin-bottom: 20px;
            place-items: center;
            border-radius: 16px;
            background: var(--primary-soft);
            font-size: 1.7rem;
        }

        h1 {
            margin: 0 0 10px;
            font-size: clamp(1.8rem, 5vw, 2.4rem);
        }

        .description {
            margin: 0 0 28px;
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
            margin-bottom: 21px;
        }

        .field label {
            display: block;
            margin-bottom: 8px;
            font-weight: 800;
        }

        .field input,
        .field select {
            width: 100%;
            padding: 14px 15px;
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            background: var(--surface);
            color: var(--text);
            font: inherit;
        }

        .field input:focus,
        .field select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px var(--primary-soft);
        }

        .hint {
            display: block;
            margin-top: 7px;
            color: var(--muted);
            font-size: 0.84rem;
            line-height: 1.4;
        }

        .field-error {
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

        .primary-button,
        .secondary-button {
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
        }

        .primary-button {
            border: 0;
            background: var(--primary);
            color: #ffffff;
            cursor: pointer;
        }

        .primary-button:hover {
            background: var(--primary-dark);
        }

        .secondary-button {
            border: 1px solid var(--border);
            color: var(--muted);
            background: var(--surface);
        }

        .secondary-button:hover {
            color: var(--primary-dark);
            background: var(--primary-soft);
        }

        .privacy {
            margin: 24px 0 0;
            padding: 16px;
            border-radius: 13px;
            background: #f8f9fc;
            color: var(--muted);
            font-size: 0.84rem;
            line-height: 1.5;
        }

        @media (max-width: 500px) {
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
    <header class="topbar">
        <nav class="nav" aria-label="Navegación">
            <a class="brand" href="{{ route('dashboard') }}">
                NexoAprende
            </a>

            <a class="back-link" href="{{ route('dashboard') }}">
                Volver al panel
            </a>
        </nav>
    </header>

    <main class="container">
        <section class="card">
            <div class="icon" aria-hidden="true">👤</div>

            <h1>Crear perfil infantil</h1>

            <p class="description">
                Registra únicamente la información necesaria para organizar
                sus actividades y resultados.
            </p>

            @if ($errors->any())
                <div class="error-summary" role="alert">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form
                method="POST"
                action="{{ route('child-profiles.store') }}"
            >
                @csrf

                <div class="field">
                    <label for="name">
                        Nombre o alias
                    </label>

                    <input
                        id="name"
                        name="name"
                        type="text"
                        value="{{ old('name') }}"
                        maxlength="60"
                        autocomplete="off"
                        required
                        autofocus
                    >

                    <span class="hint">
                        Puedes utilizar un alias para proteger su identidad.
                    </span>

                    @error('name')
                        <span class="field-error">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="field">
                    <label for="age">
                        Edad
                    </label>

                    <select id="age" name="age" required>
                        <option value="">
                            Selecciona una edad
                        </option>

                        @for ($age = 6; $age <= 13; $age++)
                            <option
                                value="{{ $age }}"
                                @selected(old('age') == $age)
                            >
                                {{ $age }} años
                            </option>
                        @endfor
                    </select>

                    @error('age')
                        <span class="field-error">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

                <div class="actions">
                    <a
                        class="secondary-button"
                        href="{{ route('dashboard') }}"
                    >
                        Cancelar
                    </a>

                    <button class="primary-button" type="submit">
                        Guardar perfil
                    </button>
                </div>
            </form>

            <p class="privacy">
                NexoAprende no solicita diagnósticos, documentos de
                identidad, dirección, colegio ni información clínica.
            </p>
        </section>
    </main>
</body>
</html>
