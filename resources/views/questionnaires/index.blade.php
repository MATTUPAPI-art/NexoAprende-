@extends('questionnaires.layout')

@section('title', 'Mis cuestionarios')

@push('styles')
    .questionnaire-grid {
        display: grid;
        grid-template-columns: repeat(
            auto-fit,
            minmax(280px, 1fr)
        );
        gap: 18px;
    }

    .questionnaire-card {
        display: flex;
        min-height: 260px;
        padding: 24px;
        justify-content: space-between;
        flex-direction: column;
    }

    .questionnaire-header {
        display: flex;
        margin-bottom: 18px;
        align-items: flex-start;
        justify-content: space-between;
        gap: 15px;
    }

    .status {
        display: inline-flex;
        padding: 6px 9px;
        border-radius: 999px;
        font-size: 0.72rem;
        font-weight: 900;
        white-space: nowrap;
    }

    .status-active {
        color: #116149;
        background: var(--accent-soft);
    }

    .status-inactive {
        color: #73510d;
        background: #fff5d9;
    }

    .questionnaire-card h2 {
        margin-bottom: 10px;
        font-size: 1.25rem;
    }

    .questionnaire-description {
        display: -webkit-box;
        overflow: hidden;
        margin-bottom: 20px;
        color: var(--muted);
        line-height: 1.55;
        -webkit-box-orient: vertical;
        -webkit-line-clamp: 3;
    }

    .questionnaire-metrics {
        display: flex;
        margin-bottom: 20px;
        gap: 10px;
        flex-wrap: wrap;
    }

    .metric {
        padding: 8px 10px;
        border-radius: 10px;
        color: var(--primary-dark);
        background: var(--primary-soft);
        font-size: 0.8rem;
        font-weight: 800;
    }

    .card-actions {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 10px;
    }

    .delete-form {
        margin: 0;
    }

    .delete-form .button {
        width: 100%;
    }
@endpush

@section('content')
    <header class="page-header">
        <div>
            <p class="eyebrow">Herramientas profesionales</p>

            <h1>Mis cuestionarios</h1>

            <p class="page-description">
                Crea instrumentos personalizados para recopilar
                información educativa y realizar un seguimiento
                descriptivo de los perfiles autorizados.
            </p>
        </div>

        <a
            class="button button-primary"
            href="{{ route(
                'professional.questionnaires.create'
            ) }}"
        >
            + Crear cuestionario
        </a>
    </header>

    @if ($questionnaires->isEmpty())
        <section class="card empty-state">
            <div class="empty-icon" aria-hidden="true">
                ?
            </div>

            <h2>Todavía no tienes cuestionarios</h2>

            <p>
                Comienza creando un cuestionario y después agrega
                preguntas escritas, de opción única o de selección
                múltiple.
            </p>

            <a
                class="button button-primary"
                href="{{ route(
                    'professional.questionnaires.create'
                ) }}"
            >
                Crear primer cuestionario
            </a>
        </section>
    @else
        <section
            class="questionnaire-grid"
            aria-label="Cuestionarios creados"
        >
            @foreach ($questionnaires as $questionnaire)
                <article class="card questionnaire-card">
                    <div>
                        <div class="questionnaire-header">
                            <h2>{{ $questionnaire->title }}</h2>

                            <span
                                class="
                                    status
                                    {{ $questionnaire->is_active
                                        ? 'status-active'
                                        : 'status-inactive' }}
                                "
                            >
                                {{ $questionnaire->is_active
                                    ? 'Activo'
                                    : 'Borrador' }}
                            </span>
                        </div>

                        <p class="questionnaire-description">
                            {{ $questionnaire->description
                                ?: 'Sin descripción registrada.' }}
                        </p>

                        <div class="questionnaire-metrics">
                            <span class="metric">
                                {{ $questionnaire->questions_count }}
                                {{ $questionnaire->questions_count === 1
                                    ? 'pregunta'
                                    : 'preguntas' }}
                            </span>

                            <span class="metric">
                                Creado el
                                {{ $questionnaire->created_at
                                    ->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>

                    <div class="card-actions">
                        <a
                            class="button button-secondary"
                            href="{{ route(
                                'professional.questionnaires.edit',
                                $questionnaire
                            ) }}"
                        >
                            Editar y agregar preguntas
                        </a>

                        <form
                            class="delete-form"
                            method="POST"
                            action="{{ route(
                                'professional.questionnaires.destroy',
                                $questionnaire
                            ) }}"
                            onsubmit="
                                return confirm(
                                    '¿Eliminar este cuestionario?'
                                );
                            "
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                class="button button-danger"
                                type="submit"
                                aria-label="Eliminar cuestionario"
                            >
                                Eliminar
                            </button>
                        </form>
                    </div>
                </article>
            @endforeach
        </section>
    @endif
@endsection
