@extends('questionnaires.layout')

@section('title', 'Crear cuestionario')

@section('content')
    <section class="page-header">
        <div>
            <p class="eyebrow">Herramienta profesional</p>

            <h1>Crear cuestionario</h1>

            <p class="page-description">
                Crea un cuestionario de acompañamiento educativo.
                Después podrás agregar y organizar sus preguntas.
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
            'professional.questionnaires.store'
        ) }}"
    >
        @csrf

        <div class="field">
            <label for="title">
                Título del cuestionario
            </label>

            <input
                id="title"
                name="title"
                type="text"
                value="{{ old('title') }}"
                maxlength="120"
                required
                autofocus
                aria-invalid="{{ $errors->has('title')
                    ? 'true'
                    : 'false' }}"
            >

            <p class="field-help">
                Utiliza un título breve que identifique el propósito
                del cuestionario.
            </p>

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
            >{{ old('description') }}</textarea>

            <p class="field-help">
                Explica brevemente qué información busca recopilar.
            </p>

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
            >{{ old('instructions') }}</textarea>

            <p class="field-help">
                Indica cómo debe responderse el cuestionario.
            </p>

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
                @checked(old('is_active', true))
            >

            <div>
                <label for="is_active">
                    Cuestionario activo
                </label>

                <p class="field-help">
                    Los cuestionarios activos estarán disponibles
                    para su uso cuando se habilite su asignación.
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
                Crear cuestionario
            </button>
        </div>
    </form>
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
@endpush
