<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Verifica tu correo | NexoAprende</title>

    <style>
        :root {
            --primary: #5747e8;
            --primary-dark: #4031bd;
            --primary-soft: #eeecff;
            --background: #f5f7fc;
            --surface: #ffffff;
            --text: #182235;
            --muted: #68758a;
            --border: #dfe5ef;
            --success: #16794b;
            --success-soft: #eaf8f1;
        }

        * {
            box-sizing: border-box;
        }

        body {
            display: grid;
            min-height: 100vh;
            margin: 0;
            place-items: center;
            padding: 24px;
            color: var(--text);
            background:
                radial-gradient(
                    circle at top right,
                    #eeecff,
                    transparent 38%
                ),
                var(--background);
            font-family: Arial, Helvetica, sans-serif;
        }

        .card {
            width: min(520px, 100%);
            padding: 40px;
            border: 1px solid var(--border);
            border-radius: 24px;
            background: var(--surface);
            box-shadow: 0 20px 55px rgba(40, 35, 100, 0.1);
            text-align: center;
        }

        .icon {
            display: grid;
            width: 76px;
            height: 76px;
            margin: 0 auto 22px;
            place-items: center;
            border-radius: 22px;
            color: var(--primary);
            background: var(--primary-soft);
            font-size: 2.1rem;
        }

        .brand {
            display: inline-block;
            margin-bottom: 28px;
            color: var(--primary);
            font-size: 1.35rem;
            font-weight: 900;
            text-decoration: none;
        }

        h1 {
            margin: 0 0 14px;
            font-size: 2rem;
        }

        .description {
            margin: 0 0 24px;
            color: var(--muted);
            line-height: 1.7;
        }

        .email {
            color: var(--text);
            font-weight: 900;
        }

        .status {
            margin-bottom: 22px;
            padding: 14px 16px;
            border-radius: 12px;
            color: var(--success);
            background: var(--success-soft);
            line-height: 1.5;
        }

        .primary-button {
            width: 100%;
            padding: 14px 18px;
            border: 0;
            border-radius: 12px;
            color: #ffffff;
            background: var(--primary);
            cursor: pointer;
            font: inherit;
            font-weight: 900;
        }

        .primary-button:hover {
            background: var(--primary-dark);
        }

        .logout-button {
            margin-top: 18px;
            padding: 8px;
            border: 0;
            color: var(--muted);
            background: transparent;
            cursor: pointer;
            font: inherit;
            font-weight: 700;
        }

        .logout-button:hover {
            color: var(--primary);
            text-decoration: underline;
        }

        .help {
            margin: 22px 0 0;
            color: var(--muted);
            font-size: 0.86rem;
            line-height: 1.55;
        }

        @media (max-width: 520px) {
            .card {
                padding: 30px 22px;
            }

            h1 {
                font-size: 1.7rem;
            }
        }
    </style>
</head>

<body>
    <main class="card">
        <a class="brand" href="{{ route('inicio') }}">
            NexoAprende
        </a>

        <div class="icon" aria-hidden="true">
            ✉
        </div>

        <h1>Verifica tu correo electrónico</h1>

        <p class="description">
            Enviamos un enlace de verificación a:

            <span class="email">
                {{ auth()->user()->email }}
            </span>

            <br>

            Abre el mensaje y pulsa el enlace para confirmar que
            el correo te pertenece.
        </p>

        @if (session('status') === 'verification-link-sent')
            <div class="status" role="status">
                Se envió un nuevo enlace de verificación a tu correo.
            </div>
        @endif

        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <button class="primary-button" type="submit">
                Reenviar correo de verificación
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button class="logout-button" type="submit">
                Cerrar sesión
            </button>
        </form>

        <p class="help">
            Si no encuentras el mensaje, revisa la carpeta de correo
            no deseado o espera unos minutos antes de reenviarlo.
        </p>
    </main>
</body>
</html>
