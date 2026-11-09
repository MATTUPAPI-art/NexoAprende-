<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Cuestionarios') | NexoAprende
    </title>

    <style>
        :root {
            --primary: #5747e8;
            --primary-dark: #4031bd;
            --primary-soft: #efedff;
            --accent: #16865d;
            --accent-soft: #e7f8f0;
            --danger: #b42318;
            --danger-soft: #fff1f0;
            --background: #f5f7fc;
            --surface: #ffffff;
            --text: #182235;
            --muted: #68758a;
            --border: #dfe5ef;
            --shadow: 0 15px 45px rgba(31, 45, 78, 0.09);
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
                    transparent 32%
                ),
                var(--background);
            font-family:
                Inter, system-ui, -apple-system, BlinkMacSystemFont,
                "Segoe UI", sans-serif;
        }

        button,
        input,
        textarea {
            font: inherit;
        }

        .topbar {
            border-bottom: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(12px);
        }

        .navigation,
        .container {
            width: min(1100px, calc(100% - 32px));
            margin: 0 auto;
        }

        .navigation {
            display: flex;
            min-height: 74px;
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

        .navigation-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .container {
            padding: 44px 0 70px;
        }

        .page-header {
            display: flex;
            margin-bottom: 28px;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
        }

        .eyebrow {
            display: inline-flex;
            margin: 0 0 10px;
            padding: 7px 11px;
            border-radius: 999px;
            color: var(--primary-dark);
            background: var(--primary-soft);
            font-size: 0.75rem;
            font-weight: 900;
            letter-spacing: 0.04em;
            text-transform: uppercase;
        }

        h1,
        h2,
        h3,
        p {
            margin-top: 0;
        }

        h1 {
            margin-bottom: 10px;
            font-size: clamp(2rem, 5vw, 3rem);
            letter-spacing: -0.035em;
        }

        .page-description {
            max-width: 680px;
            margin-bottom: 0;
            color: var(--muted);
            line-height: 1.65;
        }

        .button {
            display: inline-flex;
            min-height: 44px;
            padding: 10px 16px;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            cursor: pointer;
            font-weight: 800;
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

        .button-danger {
            border: 1px solid #f1aaa5;
            color: var(--danger);
            background: var(--danger-soft);
        }

        .button-danger:hover {
            color: #ffffff;
            background: var(--danger);
        }

        .success-message {
            margin-bottom: 24px;
            padding: 15px 17px;
            border: 1px solid #a7dec5;
            border-radius: 13px;
            color: #116149;
            background: var(--accent-soft);
            font-weight: 700;
        }

        .card {
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .empty-state {
            padding: 55px 25px;
            color: var(--muted);
            text-align: center;
        }

        .empty-icon {
            display: grid;
            width: 64px;
            height: 64px;
            margin: 0 auto 20px;
            place-items: center;
            border-radius: 20px;
            color: var(--primary);
            background: var(--primary-soft);
            font-size: 1.7rem;
        }

        .empty-state h2 {
            margin-bottom: 10px;
            color: var(--text);
        }

        .empty-state p {
            max-width: 540px;
            margin: 0 auto 22px;
            line-height: 1.6;
        }

        .form-card {
            max-width: 820px;
            margin: 0 auto;
            padding: 34px;
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

        input[type="text"],
        textarea {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 12px;
            outline: none;
            color: var(--text);
            background: #ffffff;
        }

        input[type="text"] {
            min-height: 50px;
        }

        textarea {
            min-height: 115px;
            resize: vertical;
            line-height: 1.55;
        }

        input:focus,
        textarea:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(87, 71, 232, 0.11);
        }

        .checkbox-field {
            display: flex;
            padding: 15px;
            align-items: flex-start;
            gap: 11px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: #fafaff;
        }

        .checkbox-field input {
            width: 18px;
            height: 18px;
            margin-top: 2px;
            accent-color: var(--primary);
        }

        .checkbox-field label {
            margin: 0;
        }

        .field-help {
            margin: 5px 0 0;
            color: var(--muted);
            font-size: 0.8rem;
            font-weight: 400;
            line-height: 1.5;
        }

        .error-message {
            margin: 7px 0 0;
            color: var(--danger);
            font-size: 0.82rem;
            font-weight: 700;
        }

        .form-actions {
            display: flex;
            margin-top: 28px;
            justify-content: flex-end;
            gap: 12px;
            flex-wrap: wrap;
        }

        @media (max-width: 700px) {
            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .navigation {
                padding: 12px 0;
                align-items: flex-start;
                flex-direction: column;
            }

            .navigation-actions {
                width: 100%;
            }

            .form-card {
                padding: 24px 20px;
            }
        }

        @media (max-width: 480px) {
            .form-actions {
                display: grid;
                grid-template-columns: 1fr;
            }

            .form-actions .button {
                width: 100%;
            }
        }

        @stack('styles')
    </style>
</head>

<body>
    <header class="topbar">
        <nav class="navigation" aria-label="Navegación principal">
            <a class="brand" href="{{ route('inicio') }}">
                NexoAprende
            </a>

            <div class="navigation-actions">
                <a
                    class="button button-secondary"
                    href="{{ route(
                        'professional.dashboard'
                    ) }}"
                >
                    Volver al panel profesional
                </a>
            </div>
        </nav>
    </header>

    <main class="container">
        @if (session('success'))
            <div class="success-message" role="status">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>
</body>
</html>
