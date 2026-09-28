<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta
        name="description"
        content="Actividad de memoria visual de NexoAprende."
    >
    <title>Encuentra las parejas | NexoAprende</title>

    <style>
        :root {
            --primary: #5746e8;
            --primary-dark: #3f31b6;
            --primary-soft: #efedff;
            --accent: #18a673;
            --accent-soft: #e7f8f1;
            --text: #172033;
            --muted: #64748b;
            --surface: #ffffff;
            --background: #f6f7fc;
            --border: #dfe5ef;
            --danger: #c2415d;
            --shadow: 0 18px 50px rgba(26, 35, 58, 0.1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            color: var(--text);
            background: var(--background);
            font-family: Inter, system-ui, -apple-system, BlinkMacSystemFont,
                "Segoe UI", sans-serif;
        }

        button,
        a {
            font: inherit;
        }

        .topbar {
            border-bottom: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.96);
        }

        .nav,
        .container {
            width: min(1000px, calc(100% - 32px));
            margin: 0 auto;
        }

        .nav {
            display: flex;
            min-height: 72px;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .brand {
            color: var(--primary);
            font-size: 1.25rem;
            font-weight: 900;
            text-decoration: none;
        }

        .back-link {
            padding: 10px 14px;
            border: 1px solid var(--border);
            border-radius: 11px;
            color: var(--text);
            font-weight: 800;
            text-decoration: none;
        }

        .container {
            padding: 48px 0 64px;
        }

        .intro {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 24px;
            margin-bottom: 26px;
        }

        .eyebrow {
            margin: 0 0 10px;
            color: var(--primary);
            font-size: 0.8rem;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0 0 10px;
            font-size: clamp(2rem, 5vw, 3.2rem);
            line-height: 1.05;
        }

        .description {
            max-width: 650px;
            margin: 0;
            color: var(--muted);
            line-height: 1.65;
        }

        .profile-badge {
            flex: 0 0 auto;
            padding: 10px 14px;
            border-radius: 999px;
            color: var(--primary-dark);
            background: var(--primary-soft);
            font-weight: 900;
        }

        .game-card {
            padding: clamp(20px, 4vw, 34px);
            border: 1px solid var(--border);
            border-radius: 24px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .stat {
            padding: 14px;
            border-radius: 14px;
            background: #f3f5fa;
            text-align: center;
        }

        .stat span {
            display: block;
            margin-bottom: 5px;
            color: var(--muted);
            font-size: 0.8rem;
        }

        .stat strong {
            font-size: 1.25rem;
        }

        .message {
            min-height: 28px;
            margin: 0 0 20px;
            color: var(--muted);
            font-weight: 700;
            text-align: center;
        }

        .board {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            max-width: 650px;
            margin: 0 auto;
        }

        .memory-card {
            position: relative;
            min-height: 108px;
            border: 0;
            border-radius: 17px;
            color: #ffffff;
            background: var(--primary);
            box-shadow: 0 8px 18px rgba(87, 70, 232, 0.18);
            cursor: pointer;
            transform-style: preserve-3d;
            transition: transform 0.2s ease, background 0.2s ease;
        }

        .memory-card:hover:not(:disabled) {
            background: var(--primary-dark);
            transform: translateY(-2px);
        }

        .memory-card:focus-visible {
            outline: 4px solid #f0c94a;
            outline-offset: 3px;
        }

        .memory-card:disabled {
            cursor: default;
        }

        .memory-card .front,
        .memory-card .back {
            display: grid;
            position: absolute;
            inset: 0;
            place-items: center;
            border-radius: inherit;
            backface-visibility: hidden;
        }

        .memory-card .front {
            font-size: 2rem;
            font-weight: 900;
        }

        .memory-card .back {
            border: 2px solid var(--primary);
            color: var(--text);
            background: #ffffff;
            font-size: 2.7rem;
            transform: rotateY(180deg);
        }

        .memory-card.flipped,
        .memory-card.matched {
            transform: rotateY(180deg);
        }

        .memory-card.matched .back {
            border-color: var(--accent);
            background: var(--accent-soft);
        }

        .controls {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-top: 26px;
            flex-wrap: wrap;
        }

        .button {
            min-height: 48px;
            padding: 12px 19px;
            border: 0;
            border-radius: 12px;
            font-weight: 900;
            text-decoration: none;
            cursor: pointer;
        }

        .button-primary {
            color: #ffffff;
            background: var(--primary);
        }

        .button-secondary {
            border: 1px solid var(--primary);
            color: var(--primary);
            background: #ffffff;
        }

        .result {
            display: none;
            margin-top: 26px;
            padding: 20px;
            border: 1px solid #9ed8b8;
            border-radius: 16px;
            background: var(--accent-soft);
            text-align: center;
        }

        .result.visible {
            display: block;
        }

        .result h2 {
            margin: 0 0 8px;
        }

        .result p {
            margin: 0;
            line-height: 1.55;
        }

        @media (max-width: 650px) {
            .intro {
                align-items: flex-start;
                flex-direction: column;
            }

            .board {
                grid-template-columns: repeat(3, 1fr);
            }

            .memory-card {
                min-height: 90px;
            }
        }

        @media (max-width: 420px) {
            .stats {
                grid-template-columns: 1fr;
            }

            .board {
                gap: 8px;
            }

            .memory-card {
                min-height: 78px;
            }

            .memory-card .back {
                font-size: 2.1rem;
            }
        }
    </style>
</head>

<body>
    <header class="topbar">
        <nav class="nav" aria-label="Navegación de la actividad">
            <a class="brand" href="{{ route('dashboard') }}">
                NexoAprende
            </a>

            <a class="back-link" href="{{ route('dashboard') }}">
                Volver al panel
            </a>
        </nav>
    </header>

    <main class="container">
        <section class="intro">
            <div>
                <p class="eyebrow">Memoria visual · Nivel 1</p>
                <h1>Encuentra las parejas</h1>
                <p class="description">
                    Voltea dos tarjetas por turno y recuerda dónde está cada
                    figura. La actividad termina cuando encuentres las seis
                    parejas.
                </p>
            </div>

            <span class="profile-badge">
                Jugando: {{ $childProfile->name }}
            </span>
        </section>

        <section class="game-card" aria-labelledby="game-instructions">
            <div class="stats" aria-label="Resultados actuales">
                <div class="stat">
                    <span>Parejas</span>
                    <strong id="pairs">0 / 6</strong>
                </div>

                <div class="stat">
                    <span>Errores</span>
                    <strong id="errors">0</strong>
                </div>

                <div class="stat">
                    <span>Tiempo</span>
                    <strong><span id="time">0</span> s</strong>
                </div>
            </div>

            <p class="message" id="game-instructions" aria-live="polite">
                Pulsa “Comenzar” para mezclar las tarjetas.
            </p>

            <div class="board" id="board" aria-label="Tablero de memoria">
            </div>

            <div class="controls">
                <button
                    class="button button-primary"
                    id="startButton"
                    type="button"
                >
                    Comenzar
                </button>

                <a
                    class="button button-secondary"
                    href="{{ route(
                        'child-profiles.progress',
                        $childProfile
                    ) }}"
                >
                    Ver progreso
                </a>
            </div>

            <div class="result" id="result" role="status">
                <h2>¡Excelente trabajo!</h2>
                <p id="resultText"></p>
            </div>
        </section>
    </main>

    <script>
        const symbols = ['🐶', '🐱', '🐼', '🦊', '🐸', '🐵'];
        const board = document.getElementById('board');
        const pairsText = document.getElementById('pairs');
        const errorsText = document.getElementById('errors');
        const timeText = document.getElementById('time');
        const message = document.getElementById('game-instructions');
        const startButton = document.getElementById('startButton');
        const result = document.getElementById('result');
        const resultText = document.getElementById('resultText');

        let firstCard = null;
        let secondCard = null;
        let boardLocked = true;
        let matchedPairs = 0;
        let errors = 0;
        let seconds = 0;
        let timer = null;
        let gameFinished = false;

        function shuffledCards() {
            return [...symbols, ...symbols]
                .map((symbol, index) => ({
                    symbol,
                    order: Math.random(),
                    id: `${symbol}-${index}`
                }))
                .sort((a, b) => a.order - b.order);
        }

        function renderBoard() {
            board.innerHTML = '';

            shuffledCards().forEach((item, index) => {
                const card = document.createElement('button');
                card.className = 'memory-card';
                card.type = 'button';
                card.dataset.symbol = item.symbol;
                card.dataset.cardId = item.id;
                card.setAttribute(
                    'aria-label',
                    `Tarjeta ${index + 1}, oculta`
                );

                card.innerHTML = `
                    <span class="front" aria-hidden="true">?</span>
                    <span class="back" aria-hidden="true">
                        ${item.symbol}
                    </span>
                `;

                card.addEventListener('click', () => selectCard(card));
                board.appendChild(card);
            });
        }

        function selectCard(card) {
            if (
                boardLocked ||
                card === firstCard ||
                card.classList.contains('matched')
            ) {
                return;
            }

            card.classList.add('flipped');
            card.setAttribute(
                'aria-label',
                `Tarjeta con ${card.dataset.symbol}`
            );

            if (firstCard === null) {
                firstCard = card;
                message.textContent = 'Ahora elige otra tarjeta.';
                return;
            }

            secondCard = card;
            boardLocked = true;

            if (firstCard.dataset.symbol === secondCard.dataset.symbol) {
                window.setTimeout(confirmPair, 350);
            } else {
                errors += 1;
                errorsText.textContent = errors;
                message.textContent = 'No son iguales. ¡Inténtalo otra vez!';
                window.setTimeout(hideCards, 850);
            }
        }

        function confirmPair() {
            firstCard.classList.add('matched');
            secondCard.classList.add('matched');
            firstCard.disabled = true;
            secondCard.disabled = true;

            matchedPairs += 1;
            pairsText.textContent = `${matchedPairs} / 6`;
            message.textContent = '¡Pareja encontrada!';
            resetTurn();

            if (matchedPairs === symbols.length) {
                finishGame();
            }
        }

        function hideCards() {
            firstCard.classList.remove('flipped');
            secondCard.classList.remove('flipped');
            firstCard.setAttribute('aria-label', 'Tarjeta oculta');
            secondCard.setAttribute('aria-label', 'Tarjeta oculta');
            resetTurn();
        }

        function resetTurn() {
            firstCard = null;
            secondCard = null;
            boardLocked = gameFinished;
        }

        function startGame() {
            window.clearInterval(timer);
            firstCard = null;
            secondCard = null;
            matchedPairs = 0;
            errors = 0;
            seconds = 0;
            gameFinished = false;
            boardLocked = false;

            pairsText.textContent = '0 / 6';
            errorsText.textContent = '0';
            timeText.textContent = '0';
            message.textContent = 'Elige dos tarjetas para comenzar.';
            result.classList.remove('visible');
            startButton.textContent = 'Reiniciar';
            renderBoard();

            timer = window.setInterval(() => {
                seconds += 1;
                timeText.textContent = seconds;
            }, 1000);
        }

        async function finishGame() {
            gameFinished = true;
            boardLocked = true;
            window.clearInterval(timer);

            message.textContent = 'Completaste todas las parejas.';
            resultText.textContent =
                `Encontraste 6 parejas con ${errors} errores ` +
                `en ${seconds} segundos.`;
            result.classList.add('visible');

            await saveResult();
        }

        async function saveResult() {
            try {
                const response = await fetch(
                    '{{ route("activity-results.store") }}',
                    {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            child_profile_id: {{ $childProfile->id }},
                            activity_code: 'memory-pairs',
                            correct_answers: 6,
                            errors: errors,
                            duration_seconds: Math.max(seconds, 1),
                            level: 1
                        })
                    }
                );

                const data = await response.json();

                if (!response.ok) {
                    throw new Error(
                        data.message || 'No se pudo guardar.'
                    );
                }

                resultText.textContent +=
                    ' El resultado fue guardado correctamente.';
            } catch (error) {
                console.error('Error al guardar:', error);
                resultText.textContent +=
                    ' No fue posible guardar el resultado.';
            }
        }

        startButton.addEventListener('click', startGame);
        renderBoard();
    </script>
</body>
</html>
