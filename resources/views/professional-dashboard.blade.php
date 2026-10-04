<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Panel profesional | NexoAprende</title>

    <style>
        :root {
            --primary: #5747e8;
            --primary-dark: #4031bd;
            --primary-soft: #efedff;
            --success: #16805d;
            --success-soft: #e8f7f1;
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
            color: var(--muted);
            font-weight: 700;
            text-decoration: none;
        }

        .logout-button {
            padding: 10px 14px;
            border: 0;
            border-radius: 10px;
            background: var(--primary);
            color: #ffffff;
            cursor: pointer;
            font-weight: 800;
        }

        .container {
            padding: 44px 0 70px;
        }

        .welcome {
            margin-bottom: 28px;
            padding: 30px;
            border-radius: 22px;
            background: linear-gradient(135deg, #5747e8, #4031bd);
            color: #ffffff;
            box-shadow: var(--shadow);
        }

        .welcome p {
            margin: 0 0 8px;
            color: #e7e4ff;
            font-weight: 700;
        }

        .welcome h1 {
            margin: 0 0 10px;
            font-size: clamp(2rem, 5vw, 3rem);
        }

        .welcome span {
            color: #e7e4ff;
            line-height: 1.6;
        }

        .success-message {
            margin-bottom: 24px;
            padding: 16px 18px;
            border-radius: 14px;
            background: var(--success-soft);
            color: var(--success);
            font-weight: 700;
        }

        .grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 22px;
        }

        .card {
            padding: 25px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .card h2 {
            margin: 0 0 20px;
            font-size: 1.25rem;
        }

        .information {
            display: grid;
            gap: 16px;
            margin: 0;
        }

        .information div {
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border);
        }

        .information div:last-child {
            padding-bottom: 0;
            border-bottom: 0;
        }

        .information dt {
            margin-bottom: 5px;
            color: var(--muted);
            font-size: 0.85rem;
            font-weight: 800;
            text-transform: uppercase;
        }

        .information dd {
            margin: 0;
            font-weight: 700;
            line-height: 1.5;
        }

        .status {
            display: inline-flex;
            padding: 7px 11px;
            border-radius: 999px;
            background: var(--warning-soft);
            color: var(--warning);
            font-size: 0.84rem;
            font-weight: 900;
        }

        .empty-state {
            padding: 22px;
            border: 1px dashed var(--border);
            border-radius: 14px;
            color: var(--muted);
            line-height: 1.7;
            text-align: center;
        }

        .privacy {
            margin-top: 22px;
            padding: 18px;
            border-left: 4px solid var(--primary);
            border-radius: 12px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            line-height: 1.6;
        }

        @media (max-width: 760px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .nav {
                align-items: flex-start;
                flex-direction: column;
                padding: 18px 0;
            }

            .nav-actions {
                width: 100%;
                justify-content: space-between;
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

            <div class="nav-actions">
                <a class="home-link" href="{{ route('inicio') }}">
                    Ir al inicio
                </a>

                <form method="POST" action="{{ route('logout') }}">
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
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <section class="welcome">
            <p>Panel profesional</p>

            <h1>
                Bienvenido, {{ auth()->user()->name }}
            </h1>

            <span>
                Desde este espacio podrás acompañar a las familias que
                autoricen el acceso a sus perfiles infantiles.
            </span>
        </section>

        <div class="grid">
            <section class="card">
                <h2>Información profesional</h2>

                <dl class="information">
                    <div>
                        <dt>Especialidad</dt>
                        <dd>{{ $professional->specialty }}</dd>
                    </div>

                    <div>
                        <dt>Número de matrícula</dt>
                        <dd>{{ $professional->license_number }}</dd>
                    </div>

                    <div>
                        <dt>Experiencia</dt>
                        <dd>
                            {{ $professional->years_experience }}
                            años
                        </dd>
                    </div>

                    <div>
                        <dt>Estado de verificación</dt>
                        <dd>
                            @if ($professional->verified)
                                <span class="status">
                                    Perfil verificado
                                </span>
                            @else
                                <span class="status">
                                    Verificación pendiente
                                </span>
                            @endif
                        </dd>
                    </div>

                    @if ($professional->biography)
                        <div>
                            <dt>Presentación</dt>
                            <dd>{{ $professional->biography }}</dd>
                        </div>
                    @endif
                </dl>
            </section>

            <section class="card">
                <h2>Perfiles infantiles autorizados</h2>

                <div class="empty-state">
                    Todavía no tienes perfiles infantiles asignados.

                    <br><br>

                    Más adelante, el tutor podrá autorizar de manera
                    explícita qué profesional puede consultar el progreso
                    del niño.
                </div>
            </section>
        </div>

        <aside class="privacy">
            La información mostrada en NexoAprende tiene una finalidad
            educativa y descriptiva. No reemplaza una evaluación clínica
            ni constituye un diagnóstico.
        </aside>
    </main>
</body>
</html>
