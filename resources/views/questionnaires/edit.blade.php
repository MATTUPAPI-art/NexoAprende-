@extends('questionnaires.layout')

@section('title', 'Editar cuestionario')

@section('content')
    <section class="page-header">
        <div>
            <p class="eyebrow">Gestión de cuestionario</p>

            <h1>Editar cuestionario</h1>

            <p class="page-description">
                Actualiza la información general y revisa las
                preguntas registradas.
            </p>
        </div>

        <a
            class="button button-secondary"
            href="{{ route(
                'professional.questionnaires.index'
            ) }}"
        >
            Volver a cuestionarios
        </a>
    </section>

    @if ($errors->any())
        <div class="error-summary" role="alert">
            <strong>Revisa los datos ingresados:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form
        class="card form-card"
        method="POST"
        action="{{ route(
            'professional.questionnaires.update',
            $questionnaire
        ) }}"
    >
        @csrf
        @method('PUT')

        <div class="field">
            <label for="title">
                Título del cuestionario
            </label>

            <input
                id="title"
                name="title"
                type="text"
                value="{{ old(
                    'title',
                    $questionnaire->title
                ) }}"
                maxlength="120"
                required
                autofocus
                aria-invalid="{{ $errors->has('title')
                    ? 'true'
                    : 'false' }}"
            >

            @error('title')
                <p class="error-message">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="field">
            <label for="description">
                Descripción
            </label>

            <textarea
                id="description"
                name="description"
                maxlength="1000"
                aria-invalid="{{ $errors->has('description')
                    ? 'true'
                    : 'false' }}"
            >{{ old(
                'description',
                $questionnaire->description
            ) }}</textarea>

            @error('description')
                <p class="error-message">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="field">
            <label for="instructions">
                Instrucciones
            </label>

            <textarea
                id="instructions"
                name="instructions"
                maxlength="1500"
                aria-invalid="{{ $errors->has('instructions')
                    ? 'true'
                    : 'false' }}"
            >{{ old(
                'instructions',
                $questionnaire->instructions
            ) }}</textarea>

            @error('instructions')
                <p class="error-message">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="checkbox-field">
            <input
                id="is_active"
                name="is_active"
                type="checkbox"
                value="1"
                @checked(old(
                    'is_active',
                    $questionnaire->is_active
                ))
            >

            <div>
                <label for="is_active">
                    Cuestionario activo
                </label>

                <p class="field-help">
                    Desmarca esta opción para mantener el cuestionario
                    guardado sin dejarlo disponible.
                </p>
            </div>
        </div>

        <div class="form-actions">
            <a
                class="button button-secondary"
                href="{{ route(
                    'professional.questionnaires.index'
                ) }}"
            >
                Cancelar
            </a>

            <button
                class="button button-primary"
                type="submit"
            >
                Guardar cambios
            </button>
        </div>
    </form>

    <section class="questions-section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Contenido</p>

            <h2>Preguntas del cuestionario</h2>

            <p class="page-description">
                Agrega preguntas escritas o con opciones de respuesta.
            </p>
        </div>

        <span class="question-count">
            {{ $questionnaire->questions->count() }}
            {{ $questionnaire->questions->count() === 1
                ? 'pregunta'
                : 'preguntas' }}
        </span>
    </div>

    <form
        class="card question-editor new-question"
        method="POST"
        action="{{ route(
            'professional.questionnaires.questions.store',
            $questionnaire
        ) }}"
    >
        @csrf

        <h3>Agregar una pregunta</h3>

        <div class="field">
            <label for="new_question_text">
                Texto de la pregunta
            </label>

            <textarea
                id="new_question_text"
                name="question_text"
                maxlength="1000"
                required
            >{{ old('question_text') }}</textarea>

            @error('question_text')
                <p class="error-message">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="question-grid">
            <div class="field">
                <label for="new_question_type">
                    Tipo de pregunta
                </label>

                <select
                    id="new_question_type"
                    name="question_type"
                    required
                >
                    <option value="written">
                        Respuesta escrita
                    </option>

                    <option
                        value="single_choice"
                        @selected(
                            old('question_type')
                            === 'single_choice'
                        )
                    >
                        Selección única
                    </option>

                    <option
                        value="multiple_choice"
                        @selected(
                            old('question_type')
                            === 'multiple_choice'
                        )
                    >
                        Selección múltiple
                    </option>
                </select>
            </div>

            <div class="field">
                <label>Configuración</label>

                <div class="checkbox-field compact-checkbox">
                    <input
                        id="new_is_required"
                        name="is_required"
                        type="checkbox"
                        value="1"
                        @checked(old('is_required', true))
                    >

                    <label for="new_is_required">
                        Respuesta obligatoria
                    </label>
                </div>
            </div>
        </div>

        <fieldset class="options-fieldset">
            <legend>Opciones de respuesta</legend>

            <p class="field-help">
                Para selección única o múltiple debes completar
                por lo menos dos opciones. En preguntas escritas
                estas opciones serán ignoradas.
            </p>

            <div class="options-grid">
                @for ($index = 0; $index < 4; $index++)
                    <div class="field">
                        <label
                            for="new_option_{{ $index }}"
                        >
                            Opción {{ $index + 1 }}
                        </label>

                        <input
                            id="new_option_{{ $index }}"
                            name="options[]"
                            type="text"
                            value="{{ old(
                                "options.{$index}"
                            ) }}"
                            maxlength="255"
                        >
                    </div>
                @endfor
            </div>

            @error('options')
                <p class="error-message">
                    {{ $message }}
                </p>
            @enderror

            @error('options.*')
                <p class="error-message">
                    {{ $message }}
                </p>
            @enderror
        </fieldset>

        <div class="form-actions">
            <button
                class="button button-primary"
                type="submit"
            >
                Agregar pregunta
            </button>
        </div>
    </form>

    <div class="existing-questions">
        @forelse ($questionnaire->questions as $question)
            <article class="card question-card">
                <div class="question-header">
                    <span class="question-position">
                        Pregunta {{ $question->position }}
                    </span>

                    <span class="question-type">
                        @switch($question->question_type)
                            @case('single_choice')
                                Selección única
                                @break

                            @case('multiple_choice')
                                Selección múltiple
                                @break

                            @default
                                Respuesta escrita
                        @endswitch
                    </span>
                </div>

                <form
                    method="POST"
                    action="{{ route(
                        'professional.questionnaires.questions.update',
                        [
                            $questionnaire,
                            $question,
                        ]
                    ) }}"
                >
                    @csrf
                    @method('PUT')

                    <div class="field">
                        <label
                            for="question_text_{{ $question->id }}"
                        >
                            Texto de la pregunta
                        </label>

                        <textarea
                            id="question_text_{{ $question->id }}"
                            name="question_text"
                            maxlength="1000"
                            required
                        >{{ $question->question_text }}</textarea>
                    </div>

                    <div class="question-grid">
                        <div class="field">
                            <label
                                for="question_type_{{ $question->id }}"
                            >
                                Tipo de pregunta
                            </label>

                            <select
                                id="question_type_{{ $question->id }}"
                                name="question_type"
                                required
                            >
                                <option
                                    value="written"
                                    @selected(
                                        $question->question_type
                                        === 'written'
                                    )
                                >
                                    Respuesta escrita
                                </option>

                                <option
                                    value="single_choice"
                                    @selected(
                                        $question->question_type
                                        === 'single_choice'
                                    )
                                >
                                    Selección única
                                </option>

                                <option
                                    value="multiple_choice"
                                    @selected(
                                        $question->question_type
                                        === 'multiple_choice'
                                    )
                                >
                                    Selección múltiple
                                </option>
                            </select>
                        </div>

                        <div class="field">
                            <label>Configuración</label>

                            <div
                                class="checkbox-field compact-checkbox"
                            >
                                <input
                                    id="required_{{ $question->id }}"
                                    name="is_required"
                                    type="checkbox"
                                    value="1"
                                    @checked(
                                        $question->is_required
                                    )
                                >

                                <label
                                    for="required_{{ $question->id }}"
                                >
                                    Respuesta obligatoria
                                </label>
                            </div>
                        </div>
                    </div>

                    <fieldset class="options-fieldset">
                        <legend>Opciones de respuesta</legend>

                        <p class="field-help">
                            Completa al menos dos opciones cuando
                            utilices selección única o múltiple.
                        </p>

                        <div class="options-grid">
                            @php
                                $optionCount = max(
                                    4,
                                    $question->options->count()
                                );
                            @endphp

                            @for (
                                $index = 0;
                                $index < $optionCount;
                                $index++
                            )
                                @php
                                    $option = $question
                                        ->options
                                        ->get($index);
                                @endphp

                                <div class="field">
                                    <label
                                        for="option_{{ $question->id }}_{{ $index }}"
                                    >
                                        Opción {{ $index + 1 }}
                                    </label>

                                    <input
                                        id="option_{{ $question->id }}_{{ $index }}"
                                        name="options[]"
                                        type="text"
                                        value="{{ $option?->option_text }}"
                                        maxlength="255"
                                    >
                                </div>
                            @endfor
                        </div>
                    </fieldset>

                    <div class="question-actions">
                        <button
                            class="button button-primary"
                            type="submit"
                        >
                            Guardar pregunta
                        </button>
                    </div>
                </form>

                <form
                    class="delete-question-form"
                    method="POST"
                    action="{{ route(
                        'professional.questionnaires.questions.destroy',
                        [
                            $questionnaire,
                            $question,
                        ]
                    ) }}"
                    onsubmit="return confirm(
                        '¿Seguro que deseas eliminar esta pregunta?'
                    )"
                >
                    @csrf
                    @method('DELETE')

                    <button
                        class="button button-danger"
                        type="submit"
                    >
                        Eliminar pregunta
                    </button>
                </form>
            </article>
        @empty
            <div class="card empty-state">
                <div class="empty-icon" aria-hidden="true">
                    ?
                </div>

                <h2>Todavía no hay preguntas</h2>

                <p>
                    Utiliza el formulario superior para agregar
                    la primera pregunta del cuestionario.
                </p>
            </div>
        @endforelse
    </div>
</section>

    <section class="card danger-zone">
        <div>
            <h2>Eliminar cuestionario</h2>

            <p>
                Esta acción eliminará también todas sus preguntas
                y opciones de forma permanente.
            </p>
        </div>

        <form
            method="POST"
            action="{{ route(
                'professional.questionnaires.destroy',
                $questionnaire
            ) }}"
            onsubmit="return confirm(
                '¿Seguro que deseas eliminar este cuestionario?'
            )"
        >
            @csrf
            @method('DELETE')

            <button
                class="button button-danger"
                type="submit"
            >
                Eliminar cuestionario
            </button>
        </form>
    </section>
@endsection

@push('styles')
    .error-summary {
        max-width: 820px;
        margin: 0 auto 22px;
        padding: 16px 18px;
        border: 1px solid #f2b8b5;
        border-radius: 14px;
        color: var(--danger);
        background: var(--danger-soft);
    }

    .error-summary strong {
        display: block;
        margin-bottom: 8px;
    }

    .error-summary ul {
        margin: 0;
        padding-left: 20px;
    }

    .questions-section {
        max-width: 820px;
        margin: 44px auto 0;
    }

    .section-heading {
        display: flex;
        margin-bottom: 20px;
        align-items: flex-end;
        justify-content: space-between;
        gap: 20px;
    }

    .section-heading h2 {
        margin-bottom: 8px;
    }

    .question-count {
        flex: 0 0 auto;
        padding: 8px 12px;
        border-radius: 999px;
        color: var(--primary-dark);
        background: var(--primary-soft);
        font-size: 0.82rem;
        font-weight: 900;
    }

    .question-card {
        margin-bottom: 16px;
        padding: 24px;
    }

    .question-header {
        display: flex;
        margin-bottom: 14px;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
    }

    .question-position,
    .question-type {
        font-size: 0.78rem;
        font-weight: 900;
        text-transform: uppercase;
    }

    .question-position {
        color: var(--primary);
    }

    .question-type {
        color: var(--muted);
    }

    .question-card h3 {
        margin-bottom: 10px;
        line-height: 1.45;
    }

    .requirement {
        margin-bottom: 16px;
        color: var(--muted);
        font-size: 0.85rem;
        font-weight: 700;
    }

    .option-list {
        margin: 0;
        padding-left: 26px;
        color: var(--text);
        line-height: 1.8;
    }

    .empty-options {
        margin: 0;
        padding: 12px 14px;
        border-radius: 10px;
        color: var(--danger);
        background: var(--danger-soft);
        font-size: 0.88rem;
        font-weight: 700;
    }

    .danger-zone {
        display: flex;
        max-width: 820px;
        margin: 34px auto 0;
        padding: 24px;
        align-items: center;
        justify-content: space-between;
        gap: 22px;
        border-color: #f2b8b5;
    }

    .danger-zone h2 {
        margin-bottom: 7px;
        color: var(--danger);
        font-size: 1.15rem;
    }

    .danger-zone p {
        margin: 0;
        color: var(--muted);
        line-height: 1.55;
    }

    @media (max-width: 700px) {
        .section-heading,
        .danger-zone {
            align-items: flex-start;
            flex-direction: column;
        }

        .danger-zone form,
        .danger-zone .button {
            width: 100%;
        }
    }
        .question-editor {
        margin-bottom: 26px;
        padding: 26px;
    }

    .question-editor h3 {
        margin-bottom: 22px;
    }

    .new-question {
        border-color: #c9c2ff;
    }

    .question-grid,
    .options-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0 18px;
    }

    select {
        width: 100%;
        min-height: 50px;
        padding: 12px 14px;
        border: 1px solid var(--border);
        border-radius: 12px;
        outline: none;
        color: var(--text);
        background: #ffffff;
        font: inherit;
    }

    select:focus {
        border-color: var(--primary);
        box-shadow: 0 0 0 4px rgba(87, 71, 232, 0.11);
    }

    .compact-checkbox {
        min-height: 50px;
        align-items: center;
    }

    .compact-checkbox input {
        flex: 0 0 auto;
        margin: 0;
    }

    .options-fieldset {
        margin: 5px 0 0;
        padding: 20px;
        border: 1px solid var(--border);
        border-radius: 14px;
        background: #fafaff;
    }

    .options-fieldset legend {
        padding: 0 8px;
        font-weight: 900;
    }

    .options-fieldset > .field-help {
        margin-bottom: 18px;
    }

    .options-grid .field {
        margin-bottom: 14px;
    }

    .existing-questions {
        margin-top: 24px;
    }

    .question-actions {
        display: flex;
        margin-top: 22px;
        justify-content: flex-end;
    }

    .delete-question-form {
        display: flex;
        margin-top: 14px;
        padding-top: 14px;
        justify-content: flex-end;
        border-top: 1px solid var(--border);
    }

    @media (max-width: 700px) {
        .question-grid,
        .options-grid {
            grid-template-columns: 1fr;
        }

        .question-actions,
        .delete-question-form {
            display: grid;
            grid-template-columns: 1fr;
        }

        .question-actions .button,
        .delete-question-form .button {
            width: 100%;
        }
    }
@endpush
