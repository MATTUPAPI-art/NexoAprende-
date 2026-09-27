<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Panel del tutor | NexoAprende</title>

    <style>
        :root {
            --primary: #5747e8;
            --primary-dark: #4031bd;
            --primary-soft: #efedff;
            --accent: #198754;
            --accent-soft: #e9f8f0;
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

        .topbar {
            border-bottom: 1px solid var(--border);
            background: var(--surface);
        }

        .nav,
        .container {
            width: min(1120px, calc(100% - 32px));
            margin: 0 auto;
        }

        .nav {
            display: flex;
            min-height: 76px;
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

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .home-link {
            padding: 10px 14px;
            border-radius: 10px;
            color: var(--muted);
            font-weight: 700;
            text-decoration: none;
        }

        .home-link:hover {
            color: var(--primary-dark);
            background: var(--primary-soft);
        }

        .logout-form {
            margin: 0;
        }

        .logout-button {
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--surface);
            color: var(--muted);
            cursor: pointer;
            font: inherit;
            font-weight: 700;
        }

        .logout-button:hover {
            border-color: var(--primary);
            color: var(--primary-dark);
            background: var(--primary-soft);
        }

        .container {
            padding: 42px 0 56px;
        }

        .welcome {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 32px;
        }

        .eyebrow {
            margin: 0 0 8px;
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 900;
            letter-spacing: 0.06em;
            text-transform: uppercase;
        }

        .welcome h1 {
            margin: 0 0 10px;
            font-size: clamp(2rem, 5vw, 3rem);
        }

        .welcome-description {
            max-width: 680px;
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .status {
            display: inline-flex;
            padding: 9px 13px;
            border-radius: 999px;
            background: var(--accent-soft);
            color: var(--accent);
            font-size: 0.85rem;
            font-weight: 800;
            white-space: nowrap;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }

        .summary-card {
            padding: 22px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .summary-card span {
            display: block;
            margin-bottom: 8px;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .summary-card strong {
            font-size: 1.7rem;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 1.35fr 0.65fr;
            gap: 22px;
        }

        .panel-card {
            padding: 26px;
            border: 1px solid var(--border);
            border-radius: 20px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .panel-card h2 {
            margin: 0 0 8px;
            font-size: 1.3rem;
        }

        .panel-description {
            margin: 0 0 22px;
            color: var(--muted);
            line-height: 1.6;
        }

        .activity {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding: 18px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: #fafaff;
        }

        .activity-info {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .activity-icon {
            display: grid;
            flex: 0 0 48px;
            width: 48px;
            height: 48px;
            place-items: center;
            border-radius: 14px;
            background: var(--primary-soft);
            font-size: 1.5rem;
        }

        .activity h3 {
            margin: 0 0 5px;
            font-size: 1rem;
        }

        .activity p {
            margin: 0;
            color: var(--muted);
            font-size: 0.88rem;
        }

        .primary-button {
            display: inline-flex;
            padding: 11px 16px;
            border-radius: 11px;
            background: var(--primary);
            color: #ffffff;
            font-size: 0.9rem;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
        }

        .primary-button:hover {
            background: var(--primary-dark);
        }

        .secondary-button {
            display: inline-flex;
            width: 100%;
            justify-content: center;
            padding: 12px 16px;
            border: 1px solid var(--primary);
            border-radius: 11px;
            color: var(--primary);
            font-weight: 800;
            text-decoration: none;
        }

        .secondary-button:hover {
            color: #ffffff;
            background: var(--primary);
        }

        .empty-profile {
            margin-bottom: 20px;
            padding: 18px;
            border: 1px dashed #b9c2d2;
            border-radius: 15px;
            color: var(--muted);
            line-height: 1.5;
            text-align: center;
        }

        .next-step {
            margin-top: 24px;
            padding: 17px;
            border-radius: 14px;
            background: #fff8e8;
            color: #6b541f;
            font-size: 0.9rem;
            line-height: 1.5;
        }

        @media (max-width: 820px) {
            .summary-grid,
            .content-grid {
                grid-template-columns: 1fr;
            }

            .welcome {
                flex-direction: column;
            }
        }

        @media (max-width: 560px) {
            .nav {
                align-items: flex-start;
                flex-direction: column;
                padding: 18px 0;
            }

            .nav-actions {
                width: 100%;
                justify-content: space-between;
            }

            .activity {
                align-items: flex-start;
                flex-direction: column;
            }

            .primary-button {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>

<body>
    <header class="topbar">
        <nav class="nav" aria-label="Navegación del tutor">
            <a class="brand" href="{{ route('dashboard') }}">
                NexoAprende
            </a>

            <div class="nav-actions">
                <a class="home-link" href="{{ route('inicio') }}">
                    Ir al inicio
                </a>

                <form
                    class="logout-form"
                    method="POST"
                    action="{{ route('logout') }}"
                >
                    @csrf

                    <button class="logout-button" type="submit">
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </nav>
    </header>

    <main class="container">
        <section class="welcome">
            <div>
                <p class="eyebrow">Panel del tutor</p>

                <h1>
                    Hola, {{ auth()->user()->name }}
                </h1>

                <p class="welcome-description">
                    Desde este espacio podrás administrar los perfiles
                    infantiles, acceder a las actividades y revisar sus
                    resultados.
                </p>
            </div>

            <span class="status">
                Sesión protegida
            </span>
        </section>

        <section
            class="summary-grid"
            aria-label="Resumen del panel"
        >
            <article class="summary-card">
                <span>Perfiles infantiles</span>
                <strong>0</strong>
            </article>

            <article class="summary-card">
                <span>Actividades disponibles</span>
                <strong>1</strong>
            </article>

            <article class="summary-card">
                <span>Área disponible</span>
                <strong>Atención</strong>
            </article>
        </section>

        <section class="content-grid">
            <article class="panel-card">
                <h2>Actividades</h2>

                <p class="panel-description">
                    Selecciona una actividad para comenzar.
                </p>

                <div class="activity">
                    <div class="activity-info">
                        <span
                            class="activity-icon"
                            aria-hidden="true"
                        >
                            🐶
                        </span>

                        <div>
                            <h3>Encuentra los perros</h3>
                            <p>
                                Actividad de atención visual · Nivel 1
                            </p>
                        </div>
                    </div>

                    <a
                        class="primary-button"
                        href="{{ route('activities.attention') }}"
                    >
                        Comenzar
                    </a>
                </div>

                <div class="next-step">
                    Próximamente cada resultado será asociado al perfil
                    infantil que el tutor seleccione.
                </div>
            </article>

            <aside class="panel-card">
                <h2>Perfiles infantiles</h2>

                <p class="panel-description">
                    Los perfiles permiten organizar los resultados de cada
                    niño por separado.
                </p>

                <div class="empty-profile">
                    Todavía no tienes perfiles infantiles registrados.
                </div>

                <a
                    class="secondary-button"
                    href="{{ route('activity-results.index') }}"
                >
                    Ver historial actual
                </a>
            </aside>
        </section>
    </main>
</body>
</html>
