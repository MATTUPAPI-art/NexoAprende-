<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Progreso de {{ $childProfile->name }} | NexoAprende
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
            --success: #198754;
            --success-soft: #effbf4;
            --warning: #6b541f;
            --warning-soft: #fff9e9;
            --shadow:
                0 8px 24px rgba(31, 45, 78, 0.06);
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

        .container {
            width: min(1100px, calc(100% - 32px));
            margin: 0 auto;
            padding: 32px 0 48px;
        }

        .top-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 32px;
        }

        .brand {
            margin: 0;
            color: var(--primary);
            font-size: 1.4rem;
        }

        .back-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 11px 18px;
            border-radius: 12px;
            background: var(--primary);
            color: #ffffff;
            font-weight: 700;
            text-decoration: none;
        }

        .back-button:hover {
            background: var(--primary-dark);
        }

        .header {
            margin-bottom: 28px;
        }

        .header h2 {
            margin: 0 0 8px;
            font-size: clamp(1.8rem, 4vw, 2.6rem);
        }

        .header p {
            max-width: 720px;
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .profile-stage {
            display: inline-flex;
            margin-top: 14px;
            padding: 7px 11px;
            border-radius: 999px;
            color: var(--primary-dark);
            background: var(--primary-soft);
            font-size: 0.8rem;
            font-weight: 800;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(170px, 1fr)
            );
            gap: 16px;
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
            color: var(--primary-dark);
            font-size: 1.8rem;
        }

        .insight-card {
            margin-bottom: 28px;
            padding: 22px;
            border: 1px solid #cfd5e4;
            border-radius: 18px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .insight-card--positive {
            border-color: #98d6b2;
            background: var(--success-soft);
        }

        .insight-card--neutral {
            border-color: #d9ddea;
            background: #f8f9fc;
        }

        .insight-label {
            display: inline-flex;
            margin-bottom: 12px;
            padding: 6px 10px;
            border-radius: 999px;
            color: var(--primary-dark);
            background: var(--primary-soft);
            font-size: 0.76rem;
            font-weight: 900;
        }

        .insight-card--positive .insight-label {
            color: #126b42;
            background: #d9f4e4;
        }

        .insight-card h3 {
            margin: 0 0 8px;
        }

        .insight-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .activity-summary-section {
            margin-bottom: 28px;
        }

        .activity-summary-section h3 {
            margin: 0 0 8px;
        }

        .activity-summary-description {
            margin: 0 0 16px;
            color: var(--muted);
            line-height: 1.5;
        }

        .activity-summary-grid {
            display: grid;
            grid-template-columns: repeat(
                auto-fit,
                minmax(230px, 1fr)
            );
            gap: 16px;
        }

        .activity-summary-card {
            padding: 20px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .activity-summary-card h4 {
            margin: 0 0 5px;
            font-size: 1rem;
        }

        .activity-area {
            display: block;
            margin-bottom: 16px;
            color: var(--primary);
            font-size: 0.82rem;
            font-weight: 800;
        }

        .activity-metrics {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
            margin: 0;
        }

        .activity-metrics div {
            padding: 10px;
            border-radius: 11px;
            background: #f7f8fc;
        }

        .activity-metrics dt {
            margin-bottom: 4px;
            color: var(--muted);
            font-size: 0.75rem;
        }

        .activity-metrics dd {
            margin: 0;
            font-size: 0.95rem;
            font-weight: 800;
        }

        .history-card {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 20px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .history-title {
            padding: 22px;
            border-bottom: 1px solid var(--border);
        }

        .history-title h3 {
            margin: 0 0 6px;
        }

        .history-title p {
            margin: 0;
            color: var(--muted);
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 16px;
            border-bottom: 1px solid var(--border);
            text-align: left;
            white-space: nowrap;
        }

        th {
            background: #f0f2ff;
            color: #3f4960;
            font-size: 0.85rem;
        }

        td {
            color: #354056;
        }

        tbody tr:hover {
            background: #fafaff;
        }

        tbody tr:last-child td {
            border-bottom: 0;
        }

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: #e6f7ee;
            color: var(--success);
            font-size: 0.82rem;
            font-weight: 700;
        }

        .empty-state {
            padding: 42px 20px;
            color: var(--muted);
            text-align: center;
        }

        .notice {
            margin-top: 24px;
            padding: 18px;
            border: 1px solid #f1d28b;
            border-radius: 14px;
            background: var(--warning-soft);
            color: var(--warning);
            line-height: 1.5;
        }

        @media (max-width: 800px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .activity-summary-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 520px) {
            .top-bar {
                align-items: flex-start;
                flex-direction: column;
            }

            .back-button {
                width: 100%;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }

            .activity-metrics {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <main class="container">
        <nav
            class="top-bar"
            aria-label="Navegación principal"
        >
            <h1 class="brand">NexoAprende</h1>

            <a
                class="back-button"
                href="{{ route('dashboard') }}"
            >
                Volver al panel
            </a>
        </nav>

        <header class="header">
            <h2>
                Progreso de {{ $childProfile->name }}
            </h2>

            <p>
                Aquí puedes revisar los resultados obtenidos durante
                las actividades realizadas y observar cambios entre
                diferentes sesiones.
            </p>

            <span class="profile-stage">
                {{ $childProfile->ageGroupLabel() }}
                · {{ $childProfile->age }} años
            </span>
        </header>

        <section
            class="summary-grid"
            aria-label="Resumen de actividades"
        >
            <article class="summary-card">
                <span>Sesiones realizadas</span>

                <strong>
                    {{ $summary['sessions'] }}
                </strong>
            </article>

            <article class="summary-card">
                <span>Promedio de aciertos</span>

                <strong>
                    {{ $summary['average_correct'] }}
                </strong>
            </article>

            <article class="summary-card">
                <span>Promedio de errores</span>

                <strong>
                    {{ $summary['average_errors'] }}
                </strong>
            </article>

            <article class="summary-card">
                <span>Tiempo promedio</span>

                <strong>
                    {{ $summary['average_time'] }} s
                </strong>
            </article>

            <article class="summary-card">
                <span>Mejor tiempo</span>

                <strong>
                    {{ $summary['best_time'] ?? 0 }} s
                </strong>
            </article>

            <article class="summary-card">
                <span>Nivel más alto</span>

                <strong>
                    {{ $summary['highest_level'] }}
                </strong>
            </article>
        </section>

        <article
            class="
                insight-card
                insight-card--{{ $insight['type'] }}
            "
        >
            <span class="insight-label">
                Comparación de sesiones
            </span>

            <h3>
                {{ $insight['title'] }}
            </h3>

            <p>
                {{ $insight['message'] }}
            </p>
        </article>

        @if ($activitySummaries !== [])
            <section class="activity-summary-section">
                <h3>Resultados por actividad</h3>

                <p class="activity-summary-description">
                    Estos datos resumen el desempeño registrado en
                    cada actividad y no representan una evaluación
                    clínica.
                </p>

                <div class="activity-summary-grid">
                    @foreach ($activitySummaries as $activity)
                        <article class="activity-summary-card">
                            <h4>
                                {{ $activity['name'] }}
                            </h4>

                            <span class="activity-area">
                                {{ $activity['area'] }}
                            </span>

                            <dl class="activity-metrics">
                                <div>
                                    <dt>Sesiones</dt>

                                    <dd>
                                        {{ $activity['sessions'] }}
                                    </dd>
                                </div>

                                <div>
                                    <dt>Nivel máximo</dt>

                                    <dd>
                                        {{
                                            $activity[
                                                'highest_level'
                                            ]
                                        }}
                                    </dd>
                                </div>

                                <div>
                                    <dt>Promedio de aciertos</dt>

                                    <dd>
                                        {{
                                            $activity[
                                                'average_correct'
                                            ]
                                        }}
                                    </dd>
                                </div>

                                <div>
                                    <dt>Promedio de errores</dt>

                                    <dd>
                                        {{
                                            $activity[
                                                'average_errors'
                                            ]
                                        }}
                                    </dd>
                                </div>

                                <div>
                                    <dt>Tiempo promedio</dt>

                                    <dd>
                                        {{
                                            $activity[
                                                'average_time'
                                            ]
                                        }} s
                                    </dd>
                                </div>
                            </dl>
                        </article>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="history-card">
            <div class="history-title">
                <h3>Historial de actividades</h3>

                <p>
                    Se muestran las últimas 20 sesiones registradas.
                </p>
            </div>

            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Fecha</th>
                            <th>Actividad</th>
                            <th>Aciertos</th>
                            <th>Errores</th>
                            <th>Intentos</th>
                            <th>Tiempo</th>
                            <th>Nivel</th>
                            <th>Estado</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($results as $result)
                            @php
                                $activityName = match (
                                    $result->activity_code
                                ) {
                                    'memory-pairs' =>
                                        'Encuentra las parejas',

                                    'reading-story' =>
                                        'Completa la historia',

                                    default =>
                                        'Encuentra los perros',
                                };

                                $activityGoal = match (
                                    $result->activity_code
                                ) {
                                    'memory-pairs' => 6,
                                    'reading-story' => 5,
                                    default => 4,
                                };
                            @endphp

                            <tr>
                                <td>
                                    {{
                                        $result->created_at
                                            ->timezone(
                                                'America/La_Paz'
                                            )
                                            ->format(
                                                'd/m/Y H:i'
                                            )
                                    }}
                                </td>

                                <td>
                                    {{ $activityName }}
                                </td>

                                <td>{{ $result->correct_answers }} / {{ $activityGoal }}</td>

                                <td>
                                    {{ $result->errors }}
                                </td>

                                <td>
                                    {{ $result->attempts }}
                                </td>

                                <td>
                                    {{
                                        $result->duration_seconds
                                    }} s
                                </td>

                                <td>
                                    {{ $result->level }}
                                </td>

                                <td>
                                    <span class="status">
                                        Completada
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td
                                    colspan="8"
                                    class="empty-state"
                                >
                                    Todavía no existen actividades
                                    registradas para este perfil.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="notice">
            Los resultados describen el desempeño observado dentro
            de las actividades de NexoAprende. No constituyen una
            evaluación clínica, un diagnóstico ni reemplazan la
            valoración de un profesional.
        </aside>
    </main>
</body>
</html>
