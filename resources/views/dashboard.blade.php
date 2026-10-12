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

        .profile-actions {
    display: grid;
    grid-template-columns: repeat(
        2,
        minmax(0, 1fr)
    );
    gap: 8px;
}

.profile-actions .primary-button,
.profile-actions .secondary-button {
    width: 100%;
    min-width: 0;
    justify-content: center;
    padding: 10px 8px;
    text-align: center;
    white-space: normal;
}
.profiles-list {
    display: grid;
    gap: 14px;
    margin-bottom: 18px;
}

.profile-card {
    --stage-color: #5747e8;
    --stage-dark: #4031bd;
    --stage-soft: #efedff;

    position: relative;
    overflow: hidden;
    padding: 18px;
    border: 1px solid var(--stage-color);
    border-radius: 18px;
    background:
        linear-gradient(
            135deg,
            var(--stage-soft),
            #ffffff 72%
        );
}

.profile-card::before {
    position: absolute;
    top: 0;
    left: 0;
    width: 6px;
    height: 100%;
    background: var(--stage-color);
    content: "";
}

.profile-card--infantil {
    --stage-color: #ec8b2c;
    --stage-dark: #9a4d0b;
    --stage-soft: #fff4df;
}

.profile-card--preadolescente {
    --stage-color: #5747e8;
    --stage-dark: #4031bd;
    --stage-soft: #efedff;
}

.profile-card--adolescente {
    --stage-color: #147d72;
    --stage-dark: #0c5951;
    --stage-soft: #e4f7f4;
}

.profile-header {
    display: flex;
    align-items: flex-start;
    justify-content: space-between;
    gap: 14px;
    margin-bottom: 16px;
}

.profile-identity {
    display: flex;
    align-items: center;
    gap: 12px;
}

.profile-avatar {
    display: grid;
    flex: 0 0 48px;
    width: 48px;
    height: 48px;
    place-items: center;
    border-radius: 15px;
    background: var(--stage-soft);
    font-size: 1.45rem;
}

.profile-name {
    display: block;
    margin-bottom: 4px;
    font-size: 1.05rem;
}

.profile-age {
    color: var(--muted);
    font-size: 0.86rem;
}

.stage-badge {
    display: inline-flex;
    padding: 7px 10px;
    border-radius: 999px;
    color: var(--stage-dark);
    background: var(--stage-soft);
    font-size: 0.76rem;
    font-weight: 900;
    white-space: nowrap;
}

.stage-description {
    margin: 0 0 16px;
    padding: 11px 13px;
    border-radius: 12px;
    color: var(--stage-dark);
    background: rgba(255, 255, 255, 0.72);
    font-size: 0.85rem;
    line-height: 1.5;
}

.profile-card .primary-button {
    background: var(--stage-color);
}

.profile-card .primary-button:hover {
    background: var(--stage-dark);
}

.profile-card .secondary-button {
    justify-content: center;
    background: #ffffff;
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

            .profile-actions {
    display: grid;
    grid-template-columns: repeat(
        2,
        minmax(0, 1fr)
    );
    gap: 8px;
}

.profile-actions .primary-button,
.profile-actions .secondary-button {
    width: 100%;
    min-width: 0;
    justify-content: center;
    padding: 10px 8px;
    text-align: center;
    white-space: normal;
}

.danger-button {
    display: inline-flex;
    width: 100%;
    min-width: 0;
    align-items: center;
    justify-content: center;
    padding: 10px 8px;
    border: 1px solid #f1aaa5;
    border-radius: 11px;
    color: #b42318;
    background: #fff1f0;
    font-size: 0.9rem;
    font-weight: 800;
    text-align: center;
    text-decoration: none;
}

.danger-button:hover {
    color: #ffffff;
    background: #b42318;
}
        }
        @media (max-width: 620px) {
    .profile-header {
        align-items: flex-start;
        flex-direction: column;
    }

    .stage-badge {
        margin-left: 60px;
        white-space: normal;
    }
}

    /* Acciones organizadas de cada perfil */
.profile-actions {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 10px;
    margin-top: 18px;
}

.profile-actions a {
    display: inline-flex;
    width: 100%;
    min-width: 0;
    min-height: 44px;
    padding: 10px 8px;
    align-items: center;
    justify-content: center;
    border-radius: 11px;
    font-size: 0.86rem;
    font-weight: 800;
    line-height: 1.25;
    text-align: center;
    text-decoration: none;
    white-space: normal;
    transition:
        color 0.2s ease,
        border-color 0.2s ease,
        background 0.2s ease,
        transform 0.2s ease;
}

.profile-actions a:hover {
    transform: translateY(-1px);
}

/* Actividades */
.profile-actions .primary-button {
    border: 1px solid var(--stage-color);
    color: #ffffff;
    background: var(--stage-color);
}

.profile-actions .primary-button:hover {
    border-color: var(--stage-dark);
    color: #ffffff;
    background: var(--stage-dark);
}

/* Administración */
.profile-actions .secondary-button {
    border: 1px solid #d9d5ff;
    color: var(--primary-dark);
    background: #f7f6ff;
}

.profile-actions .secondary-button:hover {
    border-color: var(--primary);
    color: #ffffff;
    background: var(--primary);
}

/* Eliminar siempre ocupa todo el ancho */
.profile-actions .danger-button {
    grid-column: 1 / -1;
    border: 1px solid #f1aaa5;
    color: #b42318;
    background: #fff1f0;
}

.profile-actions .danger-button:hover {
    border-color: #b42318;
    color: #ffffff;
    background: #b42318;
}

@media (max-width: 430px) {
    .profile-actions {
        grid-template-columns: 1fr;
    }

    .profile-actions .danger-button {
        grid-column: auto;
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
        @if (session('success'))
    <div
        role="status"
        style="
            margin-bottom: 24px;
            padding: 16px 18px;
            border: 1px solid #9ed8b8;
            border-radius: 14px;
            color: #146c43;
            background: #e9f8f0;
            font-weight: 700;
        "
    >
        {{ session('success') }}
    </div>
@endif
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
    <strong>{{ $profiles->count() }}</strong>
</article>

            <article class="summary-card">
                <span>Actividades disponibles</span>
                <strong>3</strong>
            </article>

            <article class="summary-card">
                <span>Áreas disponibles</span>
                <strong>Atención, memoria y lectura</strong>
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

                    <a class="primary-button" href="#perfiles">
                        Elegir perfil
                    </a>
                </div>

                <div class="activity" style="margin-top: 12px;">
                    <div class="activity-info">
                        <span
                            class="activity-icon"
                            aria-hidden="true"
                        >
                            🧠
                        </span>

                        <div>
                            <h3>Encuentra las parejas</h3>
                            <p>
                                Actividad de memoria visual · Nivel 1
                            </p>
                        </div>
                    </div>

                    <a class="primary-button" href="#perfiles">
                        Elegir perfil
                    </a>
                </div>
                <div class="activity" style="margin-top: 12px;">
                    <div class="activity-info">
                        <span
                            class="activity-icon"
                            aria-hidden="true"
                        >
                            📖
                        </span>

                        <div>
                            <h3>Completa la historia</h3>

                            <p>
                                Actividad de lectura comprensiva · Nivel 1
                            </p>
                        </div>
                    </div>

                    <a class="primary-button" href="#perfiles">
                        Elegir perfil
                    </a>
                </div>
                <div class="next-step">
                    Selecciona un perfil infantil para que cada resultado
                    quede guardado en su historial correspondiente.
                </div>
            </article>

            <aside class="panel-card" id="perfiles">
                <h2>Perfiles infantiles</h2>

                <p class="panel-description">
                    Los perfiles permiten organizar los resultados de cada
                    niño por separado.
                </p>


    @if ($profiles->isEmpty())
    <div class="empty-profile">
        Todavía no tienes perfiles registrados.
    </div>
@else
    <div class="profiles-list">
        @foreach ($profiles as $profile)
            @php
                $profileIcon = match ($profile->ageGroup()) {
                    'infantil' => '🧸',
                    'preadolescente' => '🎯',
                    'adolescente' => '🚀',
                };
            @endphp

            <article
                class="
                    profile-card
                    profile-card--{{ $profile->ageGroup() }}
                "
            >
                <div class="profile-header">
                    <div class="profile-identity">
                        <span
                            class="profile-avatar"
                            aria-hidden="true"
                        >
                            {{ $profileIcon }}
                        </span>

                        <div>
                            <strong class="profile-name">
                                {{ $profile->name }}
                            </strong>

                            <span class="profile-age">
                                {{ $profile->age }} años
                            </span>
                        </div>
                    </div>

                    <span class="stage-badge">
                        {{ $profile->ageGroupLabel() }}
                    </span>
                </div>

                <p class="stage-description">
                    {{ $profile->ageGroupDescription() }}
                </p>

                <div class="profile-actions">
    <a
        class="primary-button"
        href="{{ route(
            'child-profiles.activities.attention',
            $profile
        ) }}"
    >
        Atención
    </a>

    <a
        class="primary-button"
        href="{{ route(
            'child-profiles.activities.memory',
            $profile
        ) }}"
    >
        Memoria
    </a>

    <a
        class="primary-button"
        href="{{ route(
            'child-profiles.activities.reading',
            $profile
        ) }}"
    >
        Lectura
    </a>

    <a
        class="secondary-button"
        href="{{ route(
            'child-profiles.progress',
            $profile
        ) }}"
    >
        Ver progreso
    </a>

    <a
        class="secondary-button"
        href="{{ route(
            'child-profiles.professionals',
            $profile
        ) }}"
    >
        Profesionales
    </a>

    <a
        class="secondary-button"
        href="{{ route(
            'child-profiles.edit',
            $profile
        ) }}"
    >
        Editar perfil
    </a>

    <a
        class="danger-button"
        href="{{ route(
            'child-profiles.delete',
            $profile
        ) }}"
    >
        Eliminar perfil
    </a>
</div>
            </article>
        @endforeach
    </div>
@endif

<a
    class="secondary-button"
    href="{{ route('child-profiles.create') }}"
>
    Crear otro perfil
</a>
            </aside>
        </section>
    </main>
</body>
</html>
