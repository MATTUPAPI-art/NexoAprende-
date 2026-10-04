<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Completa la historia | NexoAprende</title>

    <style>
        :root {
            --primary: #5747e8;
            --primary-dark: #4031bd;
            --primary-soft: #efedff;
            --accent: #e87924;
            --accent-soft: #fff2e8;
            --success: #16805d;
            --success-soft: #e8f7f1;
            --danger: #b42318;
            --danger-soft: #fff0ef;
            --background: #f6f7fc;
            --surface: #ffffff;
            --text: #182235;
            --muted: #68758a;
            --border: #dfe5ef;
            --shadow: 0 18px 45px rgba(31, 45, 78, 0.1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            background:
                radial-gradient(
                    circle at top right,
                    #fff0df 0,
                    transparent 30%
                ),
                radial-gradient(
                    circle at bottom left,
                    #ece9ff 0,
                    transparent 32%
                ),
                var(--background);
            color: var(--text);
            font-family: Arial, Helvetica, sans-serif;
        }

        button,
        a {
            font: inherit;
        }

        .topbar {
            border-bottom: 1px solid var(--border);
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(12px);
        }

        .nav,
        .container {
            width: min(1100px, calc(100% - 32px));
            margin: 0 auto;
        }

        .nav {
            display: flex;
            min-height: 74px;
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

        .back-link {
            padding: 10px 14px;
            border-radius: 10px;
            color: var(--primary-dark);
            background: var(--primary-soft);
            font-weight: 800;
            text-decoration: none;
        }

        .container {
            padding: 38px 0 70px;
        }

        .hero {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 25px;
            align-items: center;
            margin-bottom: 24px;
            padding: 28px;
            border-radius: 24px;
            background: linear-gradient(135deg, #5747e8, #4031bd);
            color: #ffffff;
            box-shadow: var(--shadow);
        }

        .eyebrow {
            margin: 0 0 8px;
            color: #e6e3ff;
            font-size: 0.8rem;
            font-weight: 900;
            letter-spacing: 0.08em;
            text-transform: uppercase;
        }

        .hero h1 {
            margin: 0 0 10px;
            font-size: clamp(2rem, 5vw, 3.3rem);
        }

        .hero-description {
            max-width: 680px;
            margin: 0;
            color: #e8e5ff;
            line-height: 1.6;
        }

        .hero-icon {
            display: grid;
            width: 100px;
            height: 100px;
            place-items: center;
            border-radius: 28px;
            background: rgba(255, 255, 255, 0.16);
            font-size: 3.4rem;
        }

        .statistics {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        .stat {
            padding: 17px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .stat span {
            display: block;
            margin-bottom: 7px;
            color: var(--muted);
            font-size: 0.78rem;
            font-weight: 900;
            text-transform: uppercase;
        }

        .stat strong {
            color: var(--primary-dark);
            font-size: 1.35rem;
        }

        .progress-track {
            height: 12px;
            margin-bottom: 24px;
            overflow: hidden;
            border-radius: 999px;
            background: #e6e9f1;
        }

        .progress-bar {
            width: 20%;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, var(--accent), #f6b94a);
            transition: width 0.4s ease;
        }

        .game-grid {
            display: grid;
            grid-template-columns: 0.75fr 1.25fr;
            gap: 22px;
            align-items: start;
        }

        .card {
            border: 1px solid var(--border);
            border-radius: 22px;
            background: var(--surface);
            box-shadow: var(--shadow);
        }

        .story-card {
            position: sticky;
            top: 22px;
            padding: 26px;
        }

        .story-card h2 {
            margin: 0 0 16px;
            font-size: 1.25rem;
        }

        .illustration {
            display: grid;
            min-height: 180px;
            margin-bottom: 20px;
            place-items: center;
            border-radius: 18px;
            background:
                linear-gradient(
                    145deg,
                    var(--accent-soft),
                    #fff9e8
                );
            font-size: 5rem;
        }

        .story-text {
            margin: 0;
            color: var(--muted);
            font-size: 1rem;
            line-height: 1.8;
        }

        .completed-sentence {
            color: var(--text);
            font-weight: 700;
        }

        .activity-card {
            padding: 30px;
        }

        .step-label {
            display: inline-flex;
            margin-bottom: 18px;
            padding: 7px 11px;
            border-radius: 999px;
            color: var(--primary-dark);
            background: var(--primary-soft);
            font-size: 0.8rem;
            font-weight: 900;
        }

        .instruction {
            margin: 0 0 8px;
            color: var(--muted);
            font-weight: 700;
        }

        .sentence {
            min-height: 125px;
            margin: 0 0 25px;
            padding: 24px;
            border: 2px dashed #d8d2ff;
            border-radius: 18px;
            background: #faf9ff;
            font-size: clamp(1.35rem, 3vw, 1.8rem);
            font-weight: 800;
            line-height: 1.55;
        }

        .blank-word {
            display: inline-block;
            min-width: 125px;
            padding: 0 8px 4px;
            border-bottom: 4px solid var(--accent);
            color: var(--accent);
            text-align: center;
        }

        .options {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 13px;
        }

        .option-button {
            min-height: 62px;
            padding: 14px;
            border: 2px solid var(--border);
            border-radius: 15px;
            background: var(--surface);
            color: var(--text);
            cursor: pointer;
            font-size: 1.05rem;
            font-weight: 900;
            transition:
                border-color 0.2s,
                background 0.2s,
                transform 0.2s;
        }

        .option-button:hover:not(:disabled),
        .option-button:focus-visible:not(:disabled) {
            border-color: var(--primary);
            background: var(--primary-soft);
            transform: translateY(-2px);
        }

        .option-button.correct {
            border-color: var(--success);
            background: var(--success-soft);
            color: var(--success);
        }

        .option-button.incorrect {
            border-color: var(--danger);
            background: var(--danger-soft);
            color: var(--danger);
        }

        .option-button:disabled {
            cursor: not-allowed;
        }

        .feedback {
            min-height: 52px;
            margin-top: 20px;
            padding: 14px 16px;
            border-radius: 14px;
            color: var(--muted);
            background: #f6f7fa;
            font-weight: 800;
            line-height: 1.5;
        }

        .feedback.success {
            color: var(--success);
            background: var(--success-soft);
        }

        .feedback.error {
            color: var(--danger);
            background: var(--danger-soft);
        }

        .result {
            display: none;
            padding: 34px;
            text-align: center;
        }

        .result.visible {
            display: block;
        }

        .result-icon {
            display: grid;
            width: 92px;
            height: 92px;
            margin: 0 auto 20px;
            place-items: center;
            border-radius: 50%;
            background: var(--success-soft);
            font-size: 3rem;
        }

        .result h2 {
            margin: 0 0 12px;
            font-size: 2rem;
        }

        .result p {
            margin: 0 auto 24px;
            max-width: 560px;
            color: var(--muted);
            line-height: 1.7;
        }

        .result-actions {
            display: flex;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .primary-button,
        .secondary-button {
            display: inline-flex;
            min-height: 48px;
            align-items: center;
            justify-content: center;
            padding: 12px 18px;
            border: 0;
            border-radius: 12px;
            cursor: pointer;
            font-weight: 900;
            text-decoration: none;
        }

        .primary-button {
            background: var(--primary);
            color: #ffffff;
        }

        .secondary-button {
            background: var(--primary-soft);
            color: var(--primary-dark);
        }

        .privacy-notice {
            margin-top: 22px;
            padding: 17px;
            border-left: 4px solid var(--primary);
            border-radius: 12px;
            background: var(--primary-soft);
            color: var(--primary-dark);
            line-height: 1.6;
        }

        @media (max-width: 820px) {
            .game-grid {
                grid-template-columns: 1fr;
            }

            .story-card {
                position: static;
            }

            .statistics {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .hero {
                grid-template-columns: 1fr;
            }

            .hero-icon {
                display: none;
            }

            .options {
                grid-template-columns: 1fr;
            }

            .activity-card {
                padding: 21px;
            }

            .sentence {
                padding: 19px;
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

            <a class="back-link" href="{{ route('dashboard') }}">
                ← Volver al panel
            </a>
        </nav>
    </header>

    <main class="container">
        <section class="hero">
            <div>
                <p class="eyebrow">Lectura · Nivel 1</p>

                <h1>Completa la historia</h1>

                <p class="hero-description">
                    Lee cada oración y elige la palabra que completa
                    correctamente la aventura de Luna.
                </p>
            </div>

            <div class="hero-icon" aria-hidden="true">
                📖
            </div>
        </section>

        <section class="statistics" aria-label="Estado de la actividad">
            <article class="stat">
                <span>Perfil</span>
                <strong>{{ $childProfile->name }}</strong>
            </article>

            <article class="stat">
                <span>Pregunta</span>
                <strong id="question-counter">1 / 5</strong>
            </article>

            <article class="stat">
                <span>Aciertos</span>
                <strong id="correct-counter">0</strong>
            </article>

            <article class="stat">
                <span>Tiempo</span>
                <strong><span id="timer">0</span> s</strong>
            </article>
        </section>

        <div
            class="progress-track"
            role="progressbar"
            aria-label="Progreso de la actividad"
            aria-valuemin="0"
            aria-valuemax="5"
            aria-valuenow="1"
        >
            <div class="progress-bar" id="progress-bar"></div>
        </div>

        <section class="game-grid" id="game">
            <aside class="card story-card">
                <h2>La aventura de Luna</h2>

                <div class="illustration" id="illustration" aria-hidden="true">
                    🔑
                </div>

                <p class="story-text" id="story-text">
                    La historia aparecerá aquí a medida que completes
                    correctamente cada oración.
                </p>
            </aside>

            <article class="card activity-card">
                <span class="step-label" id="step-label">
                    Parte 1 de 5
                </span>

                <p class="instruction">
                    Selecciona la palabra correcta:
                </p>

                <p class="sentence" id="sentence"></p>

                <div class="options" id="options"></div>

                <div
                    class="feedback"
                    id="feedback"
                    aria-live="polite"
                >
                    Lee con calma antes de responder.
                </div>
            </article>
        </section>

        <section class="card result" id="result">
            <div class="result-icon" aria-hidden="true">
                ⭐
            </div>

            <h2>¡Historia completada!</h2>

            <p id="result-text"></p>

            <div class="result-actions">
                <button
                    class="primary-button"
                    id="restart-button"
                    type="button"
                >
                    Jugar otra vez
                </button>

                <a
                    class="secondary-button"
                    href="{{ route(
                        'child-profiles.progress',
                        $childProfile
                    ) }}"
                >
                    Ver progreso
                </a>

                <a
                    class="secondary-button"
                    href="{{ route('dashboard') }}"
                >
                    Volver al panel
                </a>
            </div>
        </section>

        <aside class="privacy-notice">
            Esta actividad registra resultados educativos descriptivos.
            No constituye una evaluación clínica ni un diagnóstico.
        </aside>
    </main>

    <script>
        const questions = [
            {
                sentence: 'Luna encontró una ___ pequeña junto al árbol.',
                answer: 'llave',
                options: ['nube', 'llave', 'cuchara'],
                completed:
                    'Luna encontró una llave pequeña junto al árbol.',
                icon: '🔑'
            },
            {
                sentence: 'La llave abría una caja de ___.',
                answer: 'madera',
                options: ['cristal', 'madera', 'papel'],
                completed:
                    'La llave abría una caja de madera.',
                icon: '📦'
            },
            {
                sentence:
                    'Dentro había un mapa con un camino hacia el ___.',
                answer: 'jardín',
                options: ['jardín', 'techo', 'río'],
                completed:
                    'Dentro había un mapa con un camino hacia el jardín.',
                icon: '🗺️'
            },
            {
                sentence:
                    'Luna siguió las flechas y encontró semillas de ___.',
                answer: 'girasol',
                options: ['piedra', 'girasol', 'nieve'],
                completed:
                    'Luna siguió las flechas y encontró semillas de girasol.',
                icon: '🌻'
            },
            {
                sentence:
                    'Las plantó y cada mañana las regó con ___.',
                answer: 'agua',
                options: ['arena', 'agua', 'pintura'],
                completed:
                    'Las plantó y cada mañana las regó con agua.',
                icon: '💧'
            }
        ];

        const sentenceElement = document.getElementById('sentence');
        const optionsElement = document.getElementById('options');
        const feedbackElement = document.getElementById('feedback');
        const questionCounter = document.getElementById(
            'question-counter'
        );
        const correctCounter = document.getElementById(
            'correct-counter'
        );
        const progressBar = document.getElementById('progress-bar');
        const progressTrack = document.querySelector(
            '.progress-track'
        );
        const stepLabel = document.getElementById('step-label');
        const storyText = document.getElementById('story-text');
        const illustration = document.getElementById('illustration');
        const game = document.getElementById('game');
        const result = document.getElementById('result');
        const resultText = document.getElementById('result-text');
        const timerElement = document.getElementById('timer');
        const restartButton = document.getElementById(
            'restart-button'
        );

        let currentQuestion = 0;
        let correctAnswers = 0;
        let errors = 0;
        let seconds = 0;
        let completedSentences = [];
        let saved = false;

        const timer = window.setInterval(() => {
            seconds++;
            timerElement.textContent = seconds;
        }, 1000);

        function renderQuestion() {
            const question = questions[currentQuestion];

            questionCounter.textContent =
                `${currentQuestion + 1} / ${questions.length}`;

            correctCounter.textContent = correctAnswers;

            stepLabel.textContent =
                `Parte ${currentQuestion + 1} de ${questions.length}`;

            progressBar.style.width =
                `${((currentQuestion + 1) / questions.length) * 100}%`;

            progressTrack.setAttribute(
                'aria-valuenow',
                currentQuestion + 1
            );

            illustration.textContent = question.icon;

            const sentenceParts = question.sentence.split('___');

            sentenceElement.innerHTML = '';

            sentenceElement.append(
                document.createTextNode(sentenceParts[0])
            );

            const blank = document.createElement('span');
            blank.className = 'blank-word';
            blank.textContent = '______';
            sentenceElement.append(blank);

            sentenceElement.append(
                document.createTextNode(sentenceParts[1])
            );

            optionsElement.innerHTML = '';

            question.options.forEach((option) => {
                const button = document.createElement('button');

                button.type = 'button';
                button.className = 'option-button';
                button.textContent = option;

                button.addEventListener('click', () => {
                    checkAnswer(button, option);
                });

                optionsElement.append(button);
            });

            feedbackElement.className = 'feedback';
            feedbackElement.textContent =
                'Lee con calma antes de responder.';
        }

        function checkAnswer(button, selectedOption) {
            const question = questions[currentQuestion];

            if (selectedOption !== question.answer) {
                errors++;
                button.disabled = true;
                button.classList.add('incorrect');

                feedbackElement.className = 'feedback error';
                feedbackElement.textContent =
                    'Esa palabra no completa la idea. Intenta otra vez.';

                return;
            }

            correctAnswers++;
            correctCounter.textContent = correctAnswers;

            button.classList.add('correct');

            document
                .querySelectorAll('.option-button')
                .forEach((optionButton) => {
                    optionButton.disabled = true;
                });

            feedbackElement.className = 'feedback success';
            feedbackElement.textContent =
                '¡Muy bien! La oración tiene sentido.';

            completedSentences.push(question.completed);

            storyText.innerHTML = completedSentences
                .map((sentence) => {
                    return `<span class="completed-sentence">
                        ${sentence}
                    </span>`;
                })
                .join(' ');

            window.setTimeout(() => {
                currentQuestion++;

                if (currentQuestion < questions.length) {
                    renderQuestion();
                    return;
                }

                finishActivity();
            }, 850);
        }

        async function finishActivity() {
            window.clearInterval(timer);

            game.style.display = 'none';
            result.classList.add('visible');

            resultText.textContent =
                `Completaste las ${questions.length} oraciones ` +
                `con ${errors} errores en ${seconds} segundos. ` +
                'Tu resultado se está guardando.';

            await saveResult();
        }

        async function saveResult() {
            if (saved) {
                return;
            }

            saved = true;

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
                            child_profile_id:
                                {{ $childProfile->id }},
                            activity_code: 'reading-story',
                            correct_answers: correctAnswers,
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

                resultText.textContent =
                    `Completaste las ${questions.length} oraciones ` +
                    `con ${errors} errores en ${seconds} segundos. ` +
                    'Tu resultado fue guardado correctamente.';
            } catch (error) {
                console.error('Error al guardar:', error);

                resultText.textContent =
                    `Completaste las ${questions.length} oraciones ` +
                    `con ${errors} errores en ${seconds} segundos. ` +
                    'No fue posible guardar el resultado.';
            }
        }

        restartButton.addEventListener('click', () => {
            window.location.reload();
        });

        renderQuestion();
    </script>
</body>
</html>
