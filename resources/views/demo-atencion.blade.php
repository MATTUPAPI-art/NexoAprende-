<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Actividad de atención visual</title>

    <style>
        :root {
            --primary: #4f46e5;
            --primary-dark: #3730a3;
            --secondary: #eef2ff;
            --text: #1f2937;
            --muted: #64748b;
            --background: #f8fafc;
            --surface: #ffffff;
            --border: #dbe3ef;
            --success: #15803d;
            --success-background: #dcfce7;
            --danger: #b91c1c;
            --danger-background: #fee2e2;
            --warning-background: #fff7ed;
            --warning-border: #fdba74;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            font-family:
                Inter, ui-sans-serif, system-ui, -apple-system,
                BlinkMacSystemFont, "Segoe UI", sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, #e0e7ff, transparent 35%),
                var(--background);
        }

        button {
            font: inherit;
        }

        .container {
            width: min(960px, calc(100% - 32px));
            margin: 0 auto;
            padding: 40px 0;
        }

        .header {
            margin-bottom: 24px;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 12px;
            border-radius: 999px;
            color: var(--primary-dark);
            background: var(--secondary);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.06em;
        }

        h1,
        h2,
        h3,
        p {
            margin-top: 0;
        }

        h1 {
            margin-bottom: 10px;
            font-size: clamp(30px, 5vw, 48px);
            line-height: 1.05;
        }

        .subtitle {
            max-width: 700px;
            margin-bottom: 0;
            color: var(--muted);
            font-size: 18px;
            line-height: 1.6;
        }

        .notice {
            padding: 16px 18px;
            margin-bottom: 24px;
            border: 1px solid var(--warning-border);
            border-radius: 14px;
            background: var(--warning-background);
            line-height: 1.5;
        }

        .panel {
            padding: clamp(20px, 4vw, 36px);
            border: 1px solid var(--border);
            border-radius: 24px;
            background: var(--surface);
            box-shadow: 0 20px 50px rgba(15, 23, 42, 0.08);
        }

        .activity-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 10px;
        }

        .eyebrow {
            margin-bottom: 6px;
            color: var(--primary);
            font-size: 13px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        h2 {
            margin-bottom: 0;
            font-size: clamp(22px, 4vw, 32px);
        }

        .instructions {
            margin-bottom: 22px;
            color: var(--muted);
            line-height: 1.6;
        }

        .primary-button,
        .secondary-button {
            min-height: 46px;
            padding: 11px 20px;
            border-radius: 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .primary-button {
            flex-shrink: 0;
            border: 2px solid var(--primary);
            color: #ffffff;
            background: var(--primary);
        }

        .primary-button:hover {
            background: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        .secondary-button {
            border: 2px solid var(--primary);
            color: var(--primary-dark);
            background: #ffffff;
        }

        .primary-button:focus-visible,
        .secondary-button:focus-visible,
        .card:focus-visible {
            outline: 4px solid #c7d2fe;
            outline-offset: 3px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .stat {
            padding: 14px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: #f8fafc;
            text-align: center;
        }

        .stat-label {
            display: block;
            margin-bottom: 4px;
            color: var(--muted);
            font-size: 13px;
            font-weight: 700;
        }

        .stat-value {
            font-size: 22px;
            font-weight: 900;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            min-height: 260px;
        }

        .empty-state {
            grid-column: 1 / -1;
            display: grid;
            place-items: center;
            min-height: 260px;
            padding: 24px;
            border: 2px dashed var(--border);
            border-radius: 18px;
            color: var(--muted);
            text-align: center;
        }

        .card {
            position: relative;
            display: grid;
            place-items: center;
            min-height: 120px;
            border: 3px solid var(--border);
            border-radius: 18px;
            background: #ffffff;
            cursor: pointer;
            transition:
                transform 150ms ease,
                border-color 150ms ease,
                background 150ms ease;
        }

        .card:hover:not(:disabled) {
            transform: translateY(-3px);
            border-color: var(--primary);
        }

        .card:disabled {
            cursor: default;
            opacity: 1;
        }

        .symbol {
            font-size: clamp(42px, 7vw, 64px);
            line-height: 1;
        }

        .marker {
            position: absolute;
            top: 8px;
            right: 10px;
            display: grid;
            place-items: center;
            width: 30px;
            height: 30px;
            border-radius: 999px;
            font-size: 20px;
            font-weight: 900;
        }

        .card.correct {
            border-color: var(--success);
            background: var(--success-background);
        }

        .card.correct .marker {
            color: #ffffff;
            background: var(--success);
        }

        .card.error {
            border-color: var(--danger);
            background: var(--danger-background);
            animation: shake 240ms linear;
        }

        .card.error .marker {
            color: #ffffff;
            background: var(--danger);
        }

        .result {
            margin-top: 24px;
            padding: 22px;
            border: 2px solid var(--success);
            border-radius: 18px;
            background: var(--success-background);
        }

        .result h3 {
            margin-bottom: 8px;
            color: var(--success);
        }

        .result p {
            line-height: 1.6;
        }

        .result-note {
            color: #475569;
            font-size: 14px;
        }

        .footer {
            margin-top: 18px;
            color: var(--muted);
            font-size: 14px;
            text-align: center;
        }

        [hidden] {
            display: none !important;
        }

        @keyframes shake {
            0%, 100% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-5px);
            }

            75% {
                transform: translateX(5px);
            }
        }

        @media (max-width: 650px) {
            .container {
                width: min(100% - 20px, 960px);
                padding: 20px 0;
            }

            .activity-header {
                align-items: stretch;
                flex-direction: column;
            }

            .grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }

            .card {
                min-height: 95px;
            }
        }
    </style>
</head>

<body>
    <main class="container">
        <header class="header">
            <span class="badge">DEMO PROVISIONAL</span>

            <h1>Actividad de atención visual</h1>

            <p class="subtitle">
                Una demostración inicial de la plataforma de apoyo
                educativo infantil para realizar actividades breves
                y registrar el desempeño de cada sesión.
            </p>
        </header>

        <aside class="notice">
            <strong>Importante:</strong>
            esta actividad es educativa y complementaria.
            No diagnostica TDAH, dislexia ni ninguna otra condición.
        </aside>

        <section class="panel">
            <div class="activity-header">
                <div>
                    <p class="eyebrow">Objetivo: atención selectiva</p>

                    <h2>
                        Encuentra todos los perros
                        <span aria-hidden="true">🐶</span>
                    </h2>
                </div>

                <button
                    id="startButton"
                    class="primary-button"
                    type="button"
                >
                    Comenzar
                </button>
            </div>

            <p class="instructions">
                Selecciona únicamente los perros. Los animales están
                representados mediante símbolos para que el resultado
                no dependa exclusivamente del color.
            </p>

            <section
                class="stats"
                aria-label="Resultados actuales"
                aria-live="polite"
            >
                <div class="stat">
                    <span class="stat-label">Aciertos</span>
                    <span id="correctValue" class="stat-value">0 / 4</span>
                </div>

                <div class="stat">
                    <span class="stat-label">Errores</span>
                    <span id="errorValue" class="stat-value">0</span>
                </div>

                <div class="stat">
                    <span class="stat-label">Tiempo</span>
                    <span id="timeValue" class="stat-value">0 s</span>
                </div>
            </section>

            <div
                id="gameGrid"
                class="grid"
                aria-label="Animales de la actividad"
            >
                <div class="empty-state">
                    Presiona “Comenzar” para iniciar la actividad.
                </div>
            </div>

            <section
                id="resultPanel"
                class="result"
                aria-live="polite"
                hidden
            >
                <h3>Actividad completada</h3>

                <p id="resultText"></p>

                <p class="result-note">
                    Este resultado describe únicamente esta sesión
                    y no constituye una evaluación clínica.
                </p>

                <button
                    id="restartButton"
                    class="secondary-button"
                    type="button"
                >
                    Realizar nuevamente
                </button>
            </section>
        </section>

        <footer class="footer">
            Avance funcional provisional — Proyecto Integrador II
        </footer>
    </main>

    <script>
        const animals = [
            { symbol: '🐶', label: 'Perro', target: true },
            { symbol: '🐶', label: 'Perro', target: true },
            { symbol: '🐶', label: 'Perro', target: true },
            { symbol: '🐶', label: 'Perro', target: true },
            { symbol: '🐱', label: 'Gato', target: false },
            { symbol: '🐰', label: 'Conejo', target: false },
            { symbol: '🐼', label: 'Panda', target: false },
            { symbol: '🐸', label: 'Rana', target: false },
            { symbol: '🦊', label: 'Zorro', target: false },
            { symbol: '🐵', label: 'Mono', target: false },
            { symbol: '🐯', label: 'Tigre', target: false },
            { symbol: '🐨', label: 'Koala', target: false }
        ];

        const totalTargets = animals.filter(
            animal => animal.target
        ).length;

        const startButton = document.getElementById('startButton');
        const restartButton = document.getElementById('restartButton');
        const gameGrid = document.getElementById('gameGrid');
        const correctValue = document.getElementById('correctValue');
        const errorValue = document.getElementById('errorValue');
        const timeValue = document.getElementById('timeValue');
        const resultPanel = document.getElementById('resultPanel');
        const resultText = document.getElementById('resultText');

        let correctAnswers = 0;
        let errors = 0;
        let seconds = 0;
        let timer = null;
        let gameActive = false;

        function shuffle(items) {
            const shuffled = [...items];

            for (let index = shuffled.length - 1; index > 0; index--) {
                const randomIndex = Math.floor(
                    Math.random() * (index + 1)
                );

                [shuffled[index], shuffled[randomIndex]] = [
                    shuffled[randomIndex],
                    shuffled[index]
                ];
            }

            return shuffled;
        }

        function updateStats() {
            correctValue.textContent =
                `${correctAnswers} / ${totalTargets}`;

            errorValue.textContent = errors;
            timeValue.textContent = `${seconds} s`;
        }

        function createCard(animal) {
            const button = document.createElement('button');
            const symbol = document.createElement('span');
            const marker = document.createElement('span');

            button.type = 'button';
            button.className = 'card';
            button.setAttribute(
                'aria-label',
                `Seleccionar ${animal.label}`
            );

            symbol.className = 'symbol';
            symbol.textContent = animal.symbol;
            symbol.setAttribute('aria-hidden', 'true');

            marker.className = 'marker';
            marker.setAttribute('aria-hidden', 'true');

            button.append(symbol, marker);

            button.addEventListener('click', () => {
                selectCard(button, marker, animal);
            });

            return button;
        }

        function selectCard(button, marker, animal) {
            if (!gameActive || button.dataset.resolved === 'true') {
                return;
            }

            if (animal.target) {
                button.dataset.resolved = 'true';
                button.disabled = true;
                button.classList.add('correct');
                marker.textContent = '✓';
                correctAnswers++;
            } else {
                errors++;
                button.disabled = true;
                button.classList.add('error');
                marker.textContent = '×';

                window.setTimeout(() => {
                    button.classList.remove('error');
                    marker.textContent = '';
                    button.disabled = false;
                }, 550);
            }

            updateStats();

            if (correctAnswers === totalTargets) {
                finishGame();
            }
        }

        function startGame() {
            window.clearInterval(timer);

            correctAnswers = 0;
            errors = 0;
            seconds = 0;
            gameActive = true;

            resultPanel.hidden = true;
            gameGrid.replaceChildren();

            shuffle(animals).forEach(animal => {
                gameGrid.appendChild(createCard(animal));
            });

            startButton.textContent = 'Reiniciar';
            updateStats();

            timer = window.setInterval(() => {
                seconds++;
                updateStats();
            }, 1000);
        }

        function finishGame() {
            gameActive = false;
            window.clearInterval(timer);

            resultText.textContent =
                `Encontraste los ${totalTargets} perros con ` +
                `${errors} error(es) en ${seconds} segundo(s).`;

            resultPanel.hidden = false;

            resultPanel.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }

        startButton.addEventListener('click', startGame);
        restartButton.addEventListener('click', startGame);
    </script>
</body>
</html>
