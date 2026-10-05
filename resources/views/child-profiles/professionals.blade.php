<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Profesionales autorizados | NexoAprende</title>

    <style>
        :root {
            --primary: #5747e8;
            --primary-dark: #4031bd;
            --primary-soft: #efedff;
            --success: #16805d;
            --success-soft: #e8f7f1;
            --danger: #b42318;
            --danger-soft: #fff0ef;
            --warning: #9a6700;
            --warning-soft: #fff8df;
            --background: #f5f7fc;
            --surface: #ffffff;
            --text: #182235;
            --muted: #68758a;
            --border: #dfe5ef;
            --shadow: 0 12px 32px rgba(31, 45, 78, 0.08);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        button,
        a {
            font: inherit;
        }

        .topbar {
            border-bottom: 1px solid var(--border);
            background: var(--surface);
        }

        .nav,
        .container {
            width: min(1050px, calc(100% - 32px));
            margin: 0 auto;
        }

        .nav {
            display: flex;
            min-height: 74px;
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
            color: var(--primary-dark);
            background: var(--primary-soft);
            font-weight: 800;
            text-decoration: none;
        }

        .container {
            padding: 42px 0 70px;
        }

        .hero {
            margin-bottom: 24px;
            padding: 28px;
            border-radius: 22px;
            background: linear-gradient(135deg, #5747e8, #4031bd);
            color: #ffffff;
            box-shadow: var(--shadow);
        }

        .hero p {
            margin: 0 0 8px;
            color: #e7e4ff;
            font-size: 0.8rem;
            font-weight: 900;
            letter-spacing: 0.07em;
            text-transform: uppercase;
        }

        .hero h1 {
            margin: 0 0 10px;
            font-size: clamp(2rem, 5vw, 3rem);
        }

        .hero span {
            color: #e7e4ff;
            line-height: 1.6;
        }

        .success-message,
        .error-summary {
            margin-bottom: 22px;
            padding: 16px 18px;
            border-radius: 14px;
            font-weight: 700;
        }

        .success-message {
            color: var(--success);
            background: var(--success-soft);
        }

        .error-summary {
            color: var(--danger);
            background: var(--danger-soft);
        }

        .error-summary ul {
            margin: 8px 0 0;
            padding-left: 20px;
        }

        .information {
            margin-bottom: 25px;
            padding: 19px;
            border-left: 4px solid var(--primary);
            border-radius: 14px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            line-height: 1.6;
        }

        .section-title {
            margin: 0 0 18px;
            font-size: 1.4rem;
        }

        .professional-list {
            display: grid;
            gap: 17px;
        }

        .professional-card {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 22px;
            align-items: center;
            padding: 23px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .professional-name {
            margin: 0 0 7px;
            font-size: 1.18rem;
        }

        .professional-specialty {
            margin: 0 0 12px;
            color: var(--primary-dark);
            font-weight: 800;
        }

        .professional-details {
            display: flex;
            gap: 10px 18px;
            flex-wrap: wrap;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .professional-details span {
            line-height: 1.5;
        }

        .status {
            display: inline-flex;
            margin-top: 13px;
            padding: 7px 11px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: 900;
        }

        .status-verified {
            color: var(--success);
            background: var(--success-soft);
        }

        .status-pending {
            color: var(--warning);
            background: var(--warning-soft);
        }

        .authorize-button,
        .remove-button {
            min-width: 130px;
            padding: 12px 16px;
            border: 0;
            border-radius: 11px;
            cursor: pointer;
            font-weight: 900;
        }

        .authorize-button {
            color: #ffffff;
            background: var(--primary);
        }

        .authorize-button:hover {
            background: var(--primary-dark);
        }

        .remove-button {
            color: var(--danger);
            background: var(--danger-soft);
        }

        .empty-state {
            padding: 32px;
            border: 1px dashed var(--border);
            border-radius: 18px;
            background: var(--surface);
            color: var(--muted);
            line-height: 1.7;
            text-align: center;
        }

        .privacy {
            margin-top: 24px;
            padding: 18px;
            border-radius: 14px;
            color: var(--muted);
            background: #eceff5;
            font-size: 0.9rem;
            line-height: 1.6;
        }

        @media (max-width: 680px) {
            .professional-card {
                grid-template-columns: 1fr;
            }

            .authorize-button,
            .remove-button {
                width: 100%;
            }

            .nav {
                align-items: flex-start;
                flex-direction: column;
                padding: 17px 0;
            }
        }
    </style>
</head>

<body>
    <header class="topbar">
        <nav class="nav">
            <a class="brand" href="{{ route('inicio') }}">
                NexoAprende
            </a>

            <a class="back-link" href="{{ route('dashboard') }}">
                ← Volver al panel
            </a>
        </nav>
    </header>

    <main class="container">
        <section class="hero">
            <p>Autorización profesional</p>

            <h1>{{ $childProfile->name }}</h1>

            <span>
                Selecciona qué profesionales pueden consultar el progreso
                educativo de este perfil.
            </span>
        </section>

        @if (session('success'))
            <div class="success-message" role="status">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="error-summary" role="alert">
                <strong>Revisa la información:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="information">
            El profesional autorizado podrá consultar los resultados y el
            historial de actividades. No podrá modificar el perfil,
            jugar actividades ni registrar resultados.
        </div>

        <h2 class="section-title">
            Profesionales disponibles
        </h2>

        <section class="professional-list">
            @forelse ($professionals as $professional)
                @php
                    $isAuthorized = in_array(
                        $professional->id,
                        $authorizedIds,
                        true
                    );
                @endphp

                <article class="professional-card">
                    <div>
                        <h3 class="professional-name">
                            {{ $professional->user->name }}
                        </h3>

                        <p class="professional-specialty">
                            {{ $professional->specialty }}
                        </p>

                        <div class="professional-details">
                            <span>
                                Matrícula:
                                {{ $professional->license_number }}
                            </span>

                            <span>
                                Experiencia:
                                {{ $professional->years_experience }}
                                años
                            </span>

                            <span>
                                {{ $professional->user->email }}
                            </span>
                        </div>

                        @if ($professional->verified)
                            <span class="status status-verified">
                                Perfil verificado
                            </span>
                        @else
                            <span class="status status-pending">
                                Verificación pendiente
                            </span>
                        @endif
                    </div>

                    <div>
                        @if ($isAuthorized)
                            <form
                                method="POST"
                                action="{{ route(
                                    'child-profiles.professionals.destroy',
                                    [
                                        $childProfile,
                                        $professional,
                                    ]
                                ) }}"
                            >
                                @csrf
                                @method('DELETE')

                                <button
                                    class="remove-button"
                                    type="submit"
                                >
                                    Retirar acceso
                                </button>
                            </form>
                        @else
                            <form
                                method="POST"
                                action="{{ route(
                                    'child-profiles.professionals.store',
                                    $childProfile
                                ) }}"
                            >
                                @csrf

                                <input
                                    name="professional_profile_id"
                                    type="hidden"
                                    value="{{ $professional->id }}"
                                >

                                <button
                                    class="authorize-button"
                                    type="submit"
                                >
                                    Autorizar
                                </button>
                            </form>
                        @endif
                    </div>
                </article>
            @empty
                <div class="empty-state">
                    Todavía no existen profesionales registrados en la
                    plataforma.
                </div>
            @endforelse
        </section>

        <aside class="privacy">
            La autorización puede retirarse en cualquier momento. Los
            profesionales únicamente deben acceder a información necesaria
            para el acompañamiento educativo y siempre con conocimiento
            del tutor.
        </aside>
    </main>
</body>
</html>
