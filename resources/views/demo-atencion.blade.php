<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>NexoAprende</title>

    <style>
        :root {
            --primary: #5746e8;
            --primary-dark: #4032b7;
            --primary-light: #eeecff;
            --text: #182033;
            --muted: #64748b;
            --background: #f6f7fb;
            --surface: #ffffff;
            --border: #dfe5ef;
            --success: #15803d;
            --success-light: #dcfce7;
            --danger: #b91c1c;
            --danger-light: #fee2e2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            color: var(--text);
            background: var(--background);
            font-family:
                Inter, system-ui, -apple-system, BlinkMacSystemFont,
                "Segoe UI", sans-serif;
        }

        button {
            font: inherit;
        }

        [hidden] {
            display: none !important;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 74px;
            padding: 0 max(24px, calc((100% - 1040px) / 2));
            border-bottom: 1px solid var(--border);
            background: var(--surface);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 10px;
            border: 0;
            color: var(--text);
            background: transparent;
            font-size: 20px;
            font-weight: 900;
            cursor: pointer;
        }

        .brand-icon {
            display: grid;
            place-items: center;
            width: 38px;
            height: 38px;
            border-radius: 12px;
            color: #ffffff;
            background: var(--primary);
        }

        .navigation {
            display: flex;
            gap: 8px;
        }

        .nav-button {
            padding: 9px 13px;
            border: 0;
            border-radius: 10px;
            color: var(--muted);
            background: transparent;
            font-weight: 700;
            cursor: pointer;
        }

        .nav-button:hover {
            color: var(--primary);
            background: var(--primary-light);
        }

        .nav-button:disabled {
            cursor: default;
            opacity: 0.45;
        }

        .container {
            width: min(1040px, calc(100% - 32px));
            margin: 0 auto;
            padding: 46px 0;
        }

        .hero {
            max-width: 700px;
            margin-bottom: 30px;
        }

        .small-title {
            margin: 0 0 9px;
            color: var(--primary);
            font-size: 13px;
            font-weight: 900;
            letter-spacing: 0.08em;
        }

        h1,
        h2,
        h3,
        p {
            margin-top: 0;
        }

        h1 {
            margin-bottom: 12px;
            font-size: clamp(32px, 5vw, 52px);
            line-height: 1.08;
        }

        .hero-text {
            margin-bottom: 0;
            color: var(--muted);
            font-size: 18px;
            line-height: 1.6;
        }

        .activity-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
        }

        .activity-card {
            position: relative;
            display: flex;
            min-height: 290px;
            padding: 24px;
            border: 1px solid var(--border);
            border-radius: 22px;
            background: var(--surface);
            flex-direction: column;
            box-shadow: 0 14px 35px rgba(15, 23, 42, 0.06);
        }

        .activity-card.available {
            border: 2px solid var(--primary);
        }

        .activity-card.locked {
            opacity: 0.7;
        }

        .activity-icon {
            display: grid;
            place-items: center;
            width: 62px;
            height: 62px;
            margin-bottom: 22px;
            border-radius: 18px;
            background: var(--primary-light);
            font-size: 31px;
        }

        .activity-card h2 {
            margin-bottom: 10px;
            font-size: 23px;
        }

        .activity-card p {
            margin-bottom: 22px;
            color: var(--muted);
            line-height: 1.55;
        }

        .card-status {
            position: absolute;
            top: 20px;
            right: 20px;
            padding: 6px 9px;
            border-radius: 999px;
            color: var(--primary-dark);
            background: var(--primary-light);
            font-size: 11px;
            font-weight: 900;
        }

        .primary-button,
        .secondary-button,
        .back-button {
            min-height: 46px;
            border-radius: 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .primary-button {
            width: 100%;
            padding: 11px 18px;
            margin-top: auto;
            border: 2px solid var(--primary);
            color: #ffffff;
            background: var(--primary);
        }

        .primary-button:hover {
            border-color: var(--primary-dark);
            background: var(--primary-dark);
        }

        .secondary-button {
            padding: 10px 16px;
            border: 2px solid var(--primary);
            color: var(--primary-dark);
            background: #ffffff;
        }

        .locked-button {
            width: 100%;
            min-height: 46px;
            padding: 10px 16px;
            margin-top: auto;
            border: 1px solid var(--border);
            border-radius: 12px;
            color: var(--muted);
            background: #f8fafc;
            font-weight: 800;
            cursor: not-allowed;
        }

        .family-note {
            margin-top: 24px;
            padding: 17px 20px;
            border: 1px solid #f5d48c;
            border-radius: 15px;
            background: #fffbeb;
            color: #5f4b1d;
            line-height: 1.55;
        }

        .back-button {
            padding: 8px 12px;
            margin-bottom: 18px;
            border: 0;
            color: var(--primary-dark);
            background: transparent;
        }

        .back-button:hover {
            background: var(--primary-light);
        }

        .game-panel {
            padding: clamp(22px, 4vw, 38px);
            border: 1px solid var(--border);
            border-radius: 24px;
            background: var(--surface);
            box-shadow: 0 18px 45px rgba(15, 23, 42, 0.08);
        }

        .game-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 18px;
        }

        .game-heading {
            max-width: 680px;
        }

        .game-heading h1 {
            margin-bottom: 10px;
            font-size: clamp(28px, 4vw, 42px);
        }

        .game-description {
            margin-bottom: 0;
            color: var(--muted);
            font-size: 17px;
            line-height: 1.6;
        }

        .start-button {
            width: auto;
            min-width: 140px;
            flex-shrink: 0;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin: 24px 0;
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
            font-size: 23px;
            font-weight: 900;
        }

        .game-grid {
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
            padding: 25px;
            border: 2px dashed var(--border);
            border-radius: 18px;
            color: var(--muted);
            text-align: center;
        }

        .animal-card {
            position: relative;
            display: grid;
            place-items: center;
            min-height: 120px;
            border: 3px solid var(--border);
            border-radius: 18px;
            background: #ffffff;
            cursor: pointer;
            transition: 150ms ease;
        }

        .animal-card:hover:not(:disabled) {
            border-color: var(--primary);
            transform: translateY(-3px);
        }

        .animal-card:disabled {
            cursor: default;
            opacity: 1;
        }

        .animal-symbol {
            font-size: clamp(43px, 7vw, 65px);
            line-height: 1;
        }

        .marker {
            position: absolute;
            top: 8px;
            right: 9px;
            display: grid;
            place-items: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            color: #ffffff;
            font-size: 19px;
            font-weight: 900;
        }

        .animal-card.correct {
            border-color: var(--success);
            background: var(--success-light);
        }

        .animal-card.correct .marker {
            background: var(--success);
        }

        .animal-card.error {
            border-color: var(--danger);
            background: var(--danger-light);
        }

        .animal-card.error .marker {
            background: var(--danger);
        }

        .result-panel {
            margin-top: 24px;
            padding: 22px;
            border: 2px solid var(--success);
            border-radius: 18px;
            background: var(--success-light);
        }

        .result-panel h2 {
            margin-bottom: 8px;
            color: var(--success);
        }

        .result-panel p {
            line-height: 1.55;
        }

        .result-actions {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .result-actions .primary-button {
            width: auto;
            margin-top: 0;
        }

        .safety-note {
            margin-top: 25px;
            color: var(--muted);
            font-size: 13px;
            text-align: center;
        }

        button:focus-visible {
            outline: 4px solid #c7d2fe;
            outline-offset: 3px;
        }

        @media (max-width: 760px) {
            .activity-list {
                grid-template-columns: 1fr;
            }

            .activity-card {
                min-height: 250px;
            }

            .game-header {
                flex-direction: column;
            }

            .start-button {
                width: 100%;
            }

            .game-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 10px;
            }

            .animal-card {
                min-height: 95px;
            }
        }

        @media (max-width: 520px) {
            .topbar {
                padding: 0 14px;
            }

            .navigation .nav-button:disabled {
                display: none;
            }

            .container {
                width: min(100% - 20px, 1040px);
                padding: 25px 0;
            }

            .stats {
                gap: 7px;
            }

            .stat {
                padding: 11px 5px;
            }

            .stat-value {
                font-size: 19px;
            }
        }
    </style>
</head>

<body>
    <header class="topbar">
        <button id="brandButton" class="brand" type="button">
            <span class="brand-icon">✦</span>
            <span>NexoAprende</span>
        </button>

        <nav class="navigation" aria-label="Navegación principal">
            <button id="activitiesButton" class="nav-button" type="button">
                Actividades
            </button>

            <button class="nav-button" type="button" disabled>
                Mi progreso
            </button>
        </nav>
    </header>

    <main class="container">
        <section id="menuScreen">
            <div class="hero">
                <p class="small-title">APRENDE A TU RITMO</p>

                <h1>¿Qué quieres practicar hoy?</h1>

                <p class="hero-text">
                    Elige una actividad, diviértete y descubre todo
                    lo que puedes lograr.
                </p>
            </div>

            <div class="activity-list">
                <article class="activity-card available">
                    <span class="card-status">DISPONIBLE</span>
                    <div class="activity-icon" aria-hidden="true">🎯</div>

                    <h2>Atención y concentración</h2>

                    <p>
                        Observa con cuidado, encuentra los elementos
                        correctos y pon a prueba tu atención.
                    </p>

                    <button
                        id="playAttentionButton"
                        class="primary-button"
                        type="button"
                    >
                        Jugar ahora
                    </button>
                </article>

                <article class="activity-card locked">
                    <span class="card-status">Todavia no hay</span>
                    <div class="activity-icon" aria-hidden="true">🧠</div>

                    <h2>Memoria</h2>

                    <p>
                        Recuerda imágenes, encuentra parejas y
                        completa pequeñas secuencias.
                    </p>

                    <button class="locked-button" type="button" disabled>
                        Próximamente
                    </button>
                </article>

                <article class="activity-card locked">
                    <span class="card-status">aun no preparado </span>
                    <div class="activity-icon" aria-hidden="true">📚</div>

                    <h2>Lectura</h2>

                    <p>
                        Relaciona palabras e imágenes y practica
                        con historias breves.
                    </p>

                    <button class="locked-button" type="button" disabled>
                        Próximamente
                    </button>
                </article>
            </div>

            <aside class="family-note">
                <strong>Para las familias:</strong>
                las actividades muestran el resultado de cada sesión
                de forma sencilla, sin realizar diagnósticos.
            </aside>
        </section>

        <section id="gameScreen" hidden>
            <button id="backButton" class="back-button" type="button">
                ← Volver a las actividades
            </button>

            <section class="game-panel">
                <div class="game-header">
                    <div class="game-heading">
                        <p class="small-title">ATENCIÓN Y CONCENTRACIÓN</p>

                        <h1>
                            Encuentra todos los perros
                            <span aria-hidden="true">🐶</span>
                        </h1>

                        <p class="game-description">
                            Este juego corto te ayuda a practicar tu
                            concentración. Observa con calma y demuestra
                            lo atento que eres.
                        </p>
                    </div>

                    <button
                        id="startButton"
                        class="primary-button start-button"
                        type="button"
                    >
                        Comenzar
                    </button>
                </div>

                <section class="stats" aria-live="polite">
                    <div class="stat">
                        <span class="stat-label">Encontrados</span>
                        <span id="correctValue" class="stat-value">0 / 4</span>
                    </div>

                    <div class="stat">
                        <span class="stat-label">Intentos</span>
                        <span id="errorValue" class="stat-value">0</span>
                    </div>

                    <div class="stat">
                        <span class="stat-label">Tiempo</span>
                        <span id="timeValue" class="stat-value">0 s</span>
                    </div>
                </section>

                <div
                    id="gameGrid"
                    class="game-grid"
                    aria-label="Animales de la actividad"
                >
                    <div class="empty-state">
                        Cuando estés listo, presiona “Comenzar”.
                    </div>
                </div>

                <section
                    id="resultPanel"
                    class="result-panel"
                    aria-live="polite"
                    hidden
                >
                    <h2 id="resultTitle">¡Muy bien!</h2>

                    <p id="encouragementText"></p>
                    <p id="resultText"></p>

                    <div class="result-actions">
                        <button
                            id="restartButton"
                            class="primary-button"
                            type="button"
                        >
                            Jugar otra vez
                        </button>

                        <button
                            id="returnButton"
                            class="secondary-button"
                            type="button"
                        >
                            Seguir aprendiendo
                        </button>
                    </div>
                </section>
            </section>

            <p class="safety-note">
                Esta actividad practica habilidades de atención.
                No sustituye la orientación de un profesional.
            </p>
        </section>
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

        const menuScreen = document.getElementById('menuScreen');
        const gameScreen = document.getElementById('gameScreen');
        const brandButton = document.getElementById('brandButton');
        const activitiesButton = document.getElementById('activitiesButton');
        const playAttentionButton =
            document.getElementById('playAttentionButton');
        const backButton = document.getElementById('backButton');
        const returnButton = document.getElementById('returnButton');
        const startButton = document.getElementById('startButton');
        const restartButton = document.getElementById('restartButton');
        const gameGrid = document.getElementById('gameGrid');
        const correctValue = document.getElementById('correctValue');
        const errorValue = document.getElementById('errorValue');
        const timeValue = document.getElementById('timeValue');
        const resultPanel = document.getElementById('resultPanel');
        const resultTitle = document.getElementById('resultTitle');
        const resultText = document.getElementById('resultText');
        const encouragementText =
            document.getElementById('encouragementText');

        let correctAnswers = 0;
        let errors = 0;
        let seconds = 0;
        let timer = null;
        let gameActive = false;

        function showMenu() {
            window.clearInterval(timer);
            gameActive = false;
            gameScreen.hidden = true;
            menuScreen.hidden = false;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        function showGame() {
            menuScreen.hidden = true;
            gameScreen.hidden = false;
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

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

        function createAnimalCard(animal) {
            const button = document.createElement('button');
            const symbol = document.createElement('span');
            const marker = document.createElement('span');

            button.type = 'button';
            button.className = 'animal-card';
            button.setAttribute(
                'aria-label',
                `Seleccionar ${animal.label}`
            );

            symbol.className = 'animal-symbol';
            symbol.textContent = animal.symbol;
            symbol.setAttribute('aria-hidden', 'true');

            marker.className = 'marker';
            marker.setAttribute('aria-hidden', 'true');

            button.append(symbol, marker);

            button.addEventListener('click', () => {
                selectAnimal(button, marker, animal);
            });

            return button;
        }

        function selectAnimal(button, marker, animal) {
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
                }, 500);
            }

            updateStats();

            if (correctAnswers === totalTargets) {
                finishGame();
            }
        }

        function getEncouragement() {
            if (errors === 0) {
                return {
                    title: '¡Excelente trabajo!',
                    message:
                        'Encontraste todos los perros sin equivocarte. ' +
                        '¡Sigue así!'
                };
            }

            if (errors <= 2) {
                return {
                    title: '¡Muy bien!',
                    message:
                        'Estuviste muy atento. Sigue practicando, ' +
                        '¡lo estás logrando!'
                };
            }

            return {
                title: '¡Buen trabajo!',
                message:
                    'Terminaste la actividad. Cada intento cuenta y ' +
                    'puedes volver a intentarlo cuando quieras.'
            };
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
                gameGrid.appendChild(createAnimalCard(animal));
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

            const encouragement = getEncouragement();

            resultTitle.textContent = encouragement.title;
            encouragementText.textContent = encouragement.message;

            resultText.textContent =
                `Completaste la actividad en ${seconds} segundo(s) ` +
                `con ${errors} intento(s) incorrecto(s).`;

            resultPanel.hidden = false;

            resultPanel.scrollIntoView({
                behavior: 'smooth',
                block: 'nearest'
            });
        }

        playAttentionButton.addEventListener('click', showGame);
        brandButton.addEventListener('click', showMenu);
        activitiesButton.addEventListener('click', showMenu);
        backButton.addEventListener('click', showMenu);
        returnButton.addEventListener('click', showMenu);
        startButton.addEventListener('click', startGame);
        restartButton.addEventListener('click', startGame);
    </script>
</body>
</html>
