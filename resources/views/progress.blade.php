<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Mi progreso | NexoAprende</title>

    <style>
        :root {
            --primary: #5747e8;
            --primary-dark: #4031bd;
            --background: #f5f7fc;
            --surface: #ffffff;
            --text: #182235;
            --muted: #68758a;
            --border: #dfe5ef;
            --success: #198754;
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
            margin: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 28px;
        }

        .summary-card {
            padding: 22px;
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--surface);
            box-shadow: 0 8px 24px rgba(31, 45, 78, 0.06);
        }

        .summary-card span {
            display: block;
            margin-bottom: 8px;
            color: var(--muted);
            font-size: 0.9rem;
        }

        .summary-card strong {
            font-size: 1.8rem;
        }

        .history-card {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 20px;
            background: var(--surface);
            box-shadow: 0 8px 24px rgba(31, 45, 78, 0.06);
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

        .status {
            display: inline-block;
            padding: 6px 10px;
            border-radius: 999px;
            background: #e6f7ee;
            color: var(--success);
            font-weight: 700;
            font-size: 0.82rem;
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
            background: #fff9e9;
            color: #6b541f;
            line-height: 1.5;
        }

        @media (max-width: 800px) {
            .summary-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 520px) {
            .top-bar {
                align-items: flex-start;
                flex-direction: column;
            }

            .summary-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <main class="container">
        <nav class="top-bar" aria-label="Navegación principal">
            <h1 class="brand">NexoAprende</h1>

            <a class="back-button" href="{{ url('/') }}">
                Volver a las actividades
            </a>
        </nav>

        <header class="header">
            <h2>Mi progreso</h2>

            <p>
                Aquí puedes revisar los resultados obtenidos durante
                las actividades realizadas.
            </p>
        </header>

        <section
            class="summary-grid"
            aria-label="Resumen de actividades"
        >
            <article class="summary-card">
                <span>Sesiones realizadas</span>
                <strong>{{ $summary['sessions'] }}</strong>
            </article>

            <article class="summary-card">
                <span>Aciertos acumulados</span>
                <strong>{{ $summary['total_correct'] }}</strong>
            </article>

            <article class="summary-card">
                <span>Errores acumulados</span>
                <strong>{{ $summary['total_errors'] }}</strong>
            </article>

            <article class="summary-card">
                <span>Mejor tiempo</span>
                <strong>
                    {{ $summary['best_time'] ?? 0 }} s
                </strong>
            </article>
        </section>

        <section class="history-card">
            <div class="history-title">
                <h3>Historial de actividades</h3>
                <p>Se muestran las últimas 20 sesiones registradas.</p>
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
                            <tr>
                                <td>
                                    {{ $result->created_at
                                        ->timezone('America/La_Paz')
                                        ->format('d/m/Y H:i') }}
                                </td>

                                <td>
                                    Encuentra los perros
                                </td>

                                <td>
                                    {{ $result->correct_answers }} / 4
                                </td>

                                <td>{{ $result->errors }}</td>

                                <td>{{ $result->attempts }}</td>

                                <td>
                                    {{ $result->duration_seconds }} s
                                </td>

                                <td>{{ $result->level }}</td>

                                <td>
                                    <span class="status">
                                        Completada
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="empty-state">
                                    Todavía no existen actividades
                                    registradas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <aside class="notice">
            Estos resultados describen el desempeño dentro de las
            actividades de la plataforma. No constituyen una evaluación
            clínica ni un diagnóstico.
        </aside>
    </main>
</body>
</html>
