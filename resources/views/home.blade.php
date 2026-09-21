<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <meta
        name="description"
        content="NexoAprende, plataforma web de apoyo educativo infantil y acompañamiento familiar."
    >

    <title>NexoAprende | Apoyo educativo desde el hogar</title>

    <style>
        :root {
            --primary: #5746e8;
            --primary-dark: #3f31b6;
            --primary-light: #efedff;
            --accent: #18a673;
            --accent-light: #e7f8f1;
            --text: #172033;
            --muted: #64748b;
            --background: #f7f8fc;
            --surface: #ffffff;
            --border: #dfe5ef;
            --warning: #fff8e5;
            --warning-border: #f0cf7c;
            --shadow: 0 18px 50px rgba(26, 35, 58, 0.09);
        }

        * {
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            margin: 0;
            color: var(--text);
            background: var(--background);
            font-family:
                Inter, system-ui, -apple-system, BlinkMacSystemFont,
                "Segoe UI", sans-serif;
        }

        a {
            color: inherit;
        }

        .skip-link {
            position: absolute;
            top: -60px;
            left: 18px;
            z-index: 100;
            padding: 10px 14px;
            border-radius: 8px;
            color: #ffffff;
            background: var(--primary-dark);
        }

        .skip-link:focus {
            top: 12px;
        }

        .topbar {
            position: sticky;
            top: 0;
            z-index: 20;
            border-bottom: 1px solid rgba(223, 229, 239, 0.9);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(12px);
        }

        .nav-container,
        .container {
            width: min(1120px, calc(100% - 36px));
            margin: 0 auto;
        }

        .nav-container {
            display: flex;
            min-height: 76px;
            align-items: center;
            justify-content: space-between;
            gap: 28px;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 1.2rem;
            font-weight: 900;
            text-decoration: none;
        }

        .brand-icon {
            display: grid;
            width: 40px;
            height: 40px;
            place-items: center;
            border-radius: 13px;
            color: #ffffff;
            background: var(--primary);
        }

        .navigation {
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .navigation a {
            padding: 9px 11px;
            border-radius: 10px;
            color: var(--muted);
            font-size: 0.94rem;
            font-weight: 700;
            text-decoration: none;
        }

        .navigation a:hover,
        .navigation a:focus-visible {
            color: var(--primary-dark);
            background: var(--primary-light);
        }

        .navigation .nav-cta {
            padding: 11px 16px;
            color: #ffffff;
            background: var(--primary);
        }

        .navigation .nav-cta:hover,
        .navigation .nav-cta:focus-visible {
            color: #ffffff;
            background: var(--primary-dark);
        }

        .hero {
            position: relative;
            overflow: hidden;
            padding: 82px 0 72px;
        }

        .hero::before {
            position: absolute;
            top: -180px;
            right: -140px;
            width: 480px;
            height: 480px;
            border-radius: 50%;
            background: #ebe8ff;
            content: "";
            filter: blur(2px);
        }

        .hero-grid {
            position: relative;
            display: grid;
            grid-template-columns: 1.08fr 0.92fr;
            gap: 58px;
            align-items: center;
        }

        .eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 18px;
            padding: 7px 11px;
            border-radius: 999px;
            color: var(--primary-dark);
            background: var(--primary-light);
            font-size: 0.78rem;
            font-weight: 900;
            letter-spacing: 0.05em;
        }

        h1,
        h2,
        h3,
        p {
            margin-top: 0;
        }

        h1 {
            max-width: 700px;
            margin-bottom: 20px;
            font-size: clamp(2.5rem, 6vw, 4.6rem);
            line-height: 1.02;
            letter-spacing: -0.045em;
        }

        .highlight {
            color: var(--primary);
        }

        .hero-description {
            max-width: 660px;
            margin-bottom: 28px;
            color: var(--muted);
            font-size: clamp(1.05rem, 2vw, 1.2rem);
            line-height: 1.7;
        }

        .hero-actions {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
        }

        .button {
            display: inline-flex;
            min-height: 48px;
            padding: 12px 19px;
            align-items: center;
            justify-content: center;
            border: 2px solid transparent;
            border-radius: 13px;
            font-weight: 850;
            text-decoration: none;
        }

        .button-primary {
            color: #ffffff;
            background: var(--primary);
        }

        .button-primary:hover,
        .button-primary:focus-visible {
            background: var(--primary-dark);
        }

        .button-secondary {
            border-color: var(--border);
            background: var(--surface);
        }

        .button-secondary:hover,
        .button-secondary:focus-visible {
            border-color: var(--primary);
            color: var(--primary-dark);
        }

        .principle {
            display: flex;
            gap: 10px;
            margin-top: 24px;
            align-items: flex-start;
            color: var(--muted);
            font-size: 0.9rem;
            line-height: 1.5;
        }

        .principle-mark {
            display: grid;
            width: 23px;
            height: 23px;
            flex: 0 0 23px;
            place-items: center;
            border-radius: 50%;
            color: var(--accent);
            background: var(--accent-light);
            font-weight: 900;
        }

        .preview-card {
            position: relative;
            padding: 24px;
            border: 1px solid var(--border);
            border-radius: 28px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .preview-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 22px;
        }

        .preview-label {
            color: var(--primary);
            font-size: 0.78rem;
            font-weight: 900;
        }

        .preview-status {
            padding: 6px 9px;
            border-radius: 999px;
            color: var(--accent);
            background: var(--accent-light);
            font-size: 0.72rem;
            font-weight: 900;
        }

        .preview-card h2 {
            margin-bottom: 8px;
            font-size: 1.55rem;
        }

        .preview-card > p {
            color: var(--muted);
            line-height: 1.55;
        }

        .animal-preview {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 10px;
            margin: 22px 0;
        }

        .animal {
            display: grid;
            min-height: 76px;
            place-items: center;
            border: 2px solid var(--border);
            border-radius: 16px;
            background: #fbfcff;
            font-size: 2rem;
        }

        .animal.correct {
            border-color: var(--accent);
            background: var(--accent-light);
        }

        .preview-stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 9px;
        }

        .preview-stat {
            padding: 12px 8px;
            border-radius: 13px;
            background: #f4f6fa;
            text-align: center;
        }

        .preview-stat span {
            display: block;
            color: var(--muted);
            font-size: 0.72rem;
        }

        .preview-stat strong {
            display: block;
            margin-top: 4px;
            font-size: 1.1rem;
        }

        .section {
            padding: 76px 0;
        }

        .section-white {
            background: var(--surface);
        }

        .section-heading {
            max-width: 690px;
            margin-bottom: 34px;
        }

        .section-heading h2 {
            margin-bottom: 12px;
            font-size: clamp(2rem, 4vw, 3rem);
            letter-spacing: -0.03em;
        }

        .section-heading p {
            margin-bottom: 0;
            color: var(--muted);
            font-size: 1.05rem;
            line-height: 1.65;
        }

        .steps,
        .values {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .step,
        .value-card {
            padding: 25px;
            border: 1px solid var(--border);
            border-radius: 20px;
            background: var(--surface);
        }

        .step-number,
        .value-icon {
            display: grid;
            width: 46px;
            height: 46px;
            margin-bottom: 20px;
            place-items: center;
            border-radius: 14px;
            color: var(--primary-dark);
            background: var(--primary-light);
            font-weight: 900;
        }

        .step h3,
        .value-card h3 {
            margin-bottom: 9px;
        }

        .step p,
        .value-card p {
            margin-bottom: 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .activity-feature {
            display: grid;
            grid-template-columns: 0.9fr 1.1fr;
            gap: 42px;
            padding: clamp(25px, 5vw, 48px);
            align-items: center;
            border: 1px solid var(--border);
            border-radius: 28px;
            background: linear-gradient(135deg, #ffffff, #f0eeff);
            box-shadow: var(--shadow);
        }

        .activity-symbol {
            display: grid;
            min-height: 290px;
            place-items: center;
            border-radius: 24px;
            background: var(--primary);
            font-size: clamp(5rem, 14vw, 9rem);
        }

        .activity-copy h2 {
            margin-bottom: 13px;
            font-size: clamp(2rem, 4vw, 3rem);
        }

        .activity-copy p {
            color: var(--muted);
            line-height: 1.65;
        }

        .feature-list {
            display: grid;
            gap: 10px;
            padding: 0;
            margin: 22px 0 26px;
            list-style: none;
        }

        .feature-list li {
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .feature-list li::before {
            display: grid;
            width: 24px;
            height: 24px;
            place-items: center;
            border-radius: 50%;
            color: var(--accent);
            background: var(--accent-light);
            content: "✓";
            font-size: 0.8rem;
            font-weight: 900;
        }

        .family-panel {
            display: grid;
            grid-template-columns: 1.05fr 0.95fr;
            gap: 38px;
            padding: clamp(28px, 5vw, 52px);
            align-items: center;
            border-radius: 28px;
            color: #ffffff;
            background: #172033;
        }

        .family-panel h2 {
            margin-bottom: 13px;
            font-size: clamp(2rem, 4vw, 3rem);
        }

        .family-panel p {
            margin-bottom: 0;
            color: #cbd5e1;
            line-height: 1.7;
        }

        .family-points {
            display: grid;
            gap: 12px;
        }

        .family-point {
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.07);
        }

        .family-point strong {
            display: block;
            margin-bottom: 5px;
        }

        .family-point span {
            color: #cbd5e1;
            font-size: 0.92rem;
            line-height: 1.45;
        }

        .development-note {
            margin-top: 30px;
            padding: 19px 21px;
            border: 1px solid var(--warning-border);
            border-radius: 16px;
            color: #66501c;
            background: var(--warning);
            line-height: 1.6;
        }

        .final-cta {
            padding: 74px 0;
            text-align: center;
        }

        .final-cta h2 {
            margin-bottom: 13px;
            font-size: clamp(2rem, 4vw, 3rem);
        }

        .final-cta p {
            max-width: 660px;
            margin: 0 auto 25px;
            color: var(--muted);
            line-height: 1.65;
        }

        footer {
            padding: 28px 0;
            border-top: 1px solid var(--border);
            background: var(--surface);
        }

        .footer-content {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            color: var(--muted);
            font-size: 0.9rem;
        }

        a:focus-visible,
        button:focus-visible {
            outline: 4px solid #c7d2fe;
            outline-offset: 3px;
        }

        @media (max-width: 860px) {
            .navigation a:not(.nav-cta) {
                display: none;
            }

            .hero {
                padding-top: 54px;
            }

            .hero-grid,
            .activity-feature,
            .family-panel {
                grid-template-columns: 1fr;
            }

            .hero-grid {
                gap: 38px;
            }

            .steps,
            .values {
                grid-template-columns: 1fr;
            }

            .activity-symbol {
                min-height: 220px;
            }
        }

        @media (max-width: 520px) {
            .nav-container,
            .container {
                width: min(100% - 24px, 1120px);
            }

            .brand-icon {
                width: 36px;
                height: 36px;
            }

            .navigation .nav-cta {
                padding: 9px 11px;
                font-size: 0.84rem;
            }

            .hero-actions {
                display: grid;
            }

            .button {
                width: 100%;
            }

            .animal-preview {
                grid-template-columns: repeat(2, 1fr);
            }

            .footer-content {
                flex-direction: column;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            html {
                scroll-behavior: auto;
            }
        }
    </style>
</head>

<body>
    <a class="skip-link" href="#contenido">
        Saltar al contenido principal
    </a>

    <header class="topbar">
        <div class="nav-container">
            <a class="brand" href="{{ route('inicio') }}">
                <span class="brand-icon" aria-hidden="true">✦</span>
                <span>NexoAprende</span>
            </a>

            <nav class="navigation" aria-label="Navegación principal">
                <a href="#como-funciona">Cómo funciona</a>
                <a href="#actividad">Actividad</a>
                <a href="#familias">Para familias</a>
                <a
                    class="nav-cta"
                    href="{{ route('activities.attention') }}"
                >
                    Probar actividad
                </a>
            </nav>
        </div>
    </header>

    <main id="contenido">
        <section class="hero">
            <div class="container hero-grid">
                <div>
                    <p class="eyebrow">
                        <span aria-hidden="true">●</span>
                        APOYO EDUCATIVO DESDE EL HOGAR
                    </p>

                    <h1>
                        Aprender paso a paso,
                        <span class="highlight">acompañados en casa.</span>
                    </h1>

                    <p class="hero-description">
                        NexoAprende reúne actividades breves y resultados
                        comprensibles para facilitar el acompañamiento de
                        niños en edad escolar por parte de sus familias.
                    </p>

                    <div class="hero-actions">
                        <a
                            class="button button-primary"
                            href="{{ route('activities.attention') }}"
                        >
                            Probar actividad de atención
                        </a>

                        <a
                            class="button button-secondary"
                            href="#como-funciona"
                        >
                            Conocer la propuesta
                        </a>
                    </div>

                    <p class="principle">
                        <span class="principle-mark" aria-hidden="true">✓</span>
                        <span>
                            La plataforma brinda apoyo educativo. No realiza
                            diagnósticos ni sustituye la orientación profesional.
                        </span>
                    </p>
                </div>

                <aside class="preview-card" aria-label="Vista previa de actividad">
                    <div class="preview-top">
                        <span class="preview-label">ATENCIÓN VISUAL</span>
                        <span class="preview-status">ACTIVIDAD DISPONIBLE</span>
                    </div>

                    <h2>Encuentra todos los perros</h2>
                    <p>Observa con calma y selecciona los elementos correctos.</p>

                    <div class="animal-preview" aria-hidden="true">
                        <span class="animal correct">🐶</span>
                        <span class="animal">🐱</span>
                        <span class="animal correct">🐶</span>
                        <span class="animal">🐼</span>
                    </div>

                    <div class="preview-stats">
                        <div class="preview-stat">
                            <span>Encontrados</span>
                            <strong>2 / 4</strong>
                        </div>

                        <div class="preview-stat">
                            <span>Errores</span>
                            <strong>1</strong>
                        </div>

                        <div class="preview-stat">
                            <span>Tiempo</span>
                            <strong>12 s</strong>
                        </div>
                    </div>
                </aside>
            </div>
        </section>

        <section id="como-funciona" class="section section-white">
            <div class="container">
                <div class="section-heading">
                    <p class="eyebrow">UNA EXPERIENCIA SENCILLA</p>
                    <h2>¿Cómo funcionará NexoAprende?</h2>
                    <p>
                        El desarrollo será progresivo. El objetivo es que cada
                        función tenga una utilidad clara para el niño y su tutor.
                    </p>
                </div>

                <div class="steps">
                    <article class="step">
                        <span class="step-number">1</span>
                        <h3>El tutor acompaña</h3>
                        <p>
                            El tutor administrará el acceso y seleccionará un
                            perfil infantil sin exponer datos innecesarios.
                        </p>
                    </article>

                    <article class="step">
                        <span class="step-number">2</span>
                        <h3>El niño practica</h3>
                        <p>
                            Realiza actividades breves, con instrucciones claras
                            y retroalimentación respetuosa.
                        </p>
                    </article>

                    <article class="step">
                        <span class="step-number">3</span>
                        <h3>La familia revisa</h3>
                        <p>
                            Consulta aciertos, errores, intentos y duración sin
                            convertir esos resultados en etiquetas clínicas.
                        </p>
                    </article>
                </div>
            </div>
        </section>

        <section id="actividad" class="section">
            <div class="container">
                <div class="activity-feature">
                    <div class="activity-symbol" aria-hidden="true">🎯</div>

                    <div class="activity-copy">
                        <p class="eyebrow">ACTIVIDAD DISPONIBLE</p>
                        <h2>Actividad de atención visual</h2>
                        <p>
                            La primera actividad permite encontrar cuatro perros
                            entre diferentes animales. Al finalizar, el sistema
                            guarda indicadores descriptivos en PostgreSQL.
                        </p>

                        <ul class="feature-list">
                            <li>Registro de aciertos y errores.</li>
                            <li>Medición de duración e intentos.</li>
                            <li>Mensajes motivadores sin competencia.</li>
                            <li>Historial descriptivo de las sesiones.</li>
                        </ul>

                        <a
                            class="button button-primary"
                            href="{{ route('activities.attention') }}"
                        >
                            Iniciar actividad
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <section id="familias" class="section section-white">
            <div class="container">
                <div class="family-panel">
                    <div>
                        <p class="eyebrow">PARA LAS FAMILIAS</p>
                        <h2>Acompañar sin etiquetar</h2>
                        <p>
                            Los resultados describen únicamente lo sucedido
                            durante una actividad. No se mostrarán porcentajes de
                            TDAH, dislexia ni otras condiciones.
                        </p>
                    </div>

                    <div class="family-points">
                        <div class="family-point">
                            <strong>Información comprensible</strong>
                            <span>Resultados concretos y fáciles de interpretar.</span>
                        </div>

                        <div class="family-point">
                            <strong>Privacidad desde el diseño</strong>
                            <span>Solo se solicitarán los datos realmente necesarios.</span>
                        </div>

                        <div class="family-point">
                            <strong>Orientación responsable</strong>
                            <span>Se recomendará apoyo profesional cuando corresponda.</span>
                        </div>
                    </div>
                </div>

                <aside class="development-note">
                    <strong>Empieza con atención visual:</strong>
                    realiza la actividad, guarda el resultado y consulta el
                    historial de las sesiones completadas.
                </aside>
            </div>
        </section>

        <section class="final-cta">
            <div class="container">
                <h2>Comienza a aprender con NexoAprende</h2>
                <p>
                    Prueba la primera actividad y revisa cómo la plataforma
                    registra el desempeño de una sesión de forma descriptiva.
                </p>

                <a
                    class="button button-primary"
                    href="{{ route('activities.attention') }}"
                >
                    Probar ahora
                </a>
            </div>
        </section>
    </main>

    <footer>
        <div class="container footer-content">
            <strong>NexoAprende</strong>
            <span>Aprendizaje, acompañamiento y progreso</span>
        </div>
    </footer>
</body>
</html>
