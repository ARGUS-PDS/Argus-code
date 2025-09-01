@props(['paginator'])

@if ($paginator->lastPage() > 1)
    <div class="d-flex flex-column align-items-center mt-4" style="gap: 8px;">
        <div class="d-flex justify-content-center" style="gap: 8px;">
            @if ($paginator->onFirstPage())
                <button class="btn paginacao-anterior" disabled style="cursor: default;">{{ __('buttons.previous') }}</button>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" class="btn paginacao-anterior">{{ __('buttons.previous') }}</a>
            @endif

            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" class="btn paginacao-proximo">{{ __('buttons.next') }}</a>
            @else
                <button class="btn paginacao-proximo" disabled style="cursor: default;">{{ __('buttons.next') }}</button>
            @endif
        </div>

        <!-- Página atual / total de páginas -->
        <div style="color: var(--color-vinho); font-weight: 600; margin-top: 4px;">
            {{ $paginator->currentPage() }} / {{ $paginator->lastPage() }}
        </div>
    </div>

    <style>
        .paginacao-anterior {
            border: 2px solid var(--color-vinho);
            background: transparent;
            color: var(--color-vinho);
            border-radius: 8px;
            padding: 6px 22px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .paginacao-anterior:hover:not(:disabled) {
            background: var(--color-vinho);
            color: var(--color-bege-claro);
            border: 2px solid var(--color-vinho);
        }

        .paginacao-proximo {
            border: 2px solid var(--color-bege-claro);
            background: var(--color-bege-claro);
            color: var(--color-vinho);
            border-radius: 8px;
            padding: 6px 22px;
            font-weight: 600;
            transition: all 0.2s;
        }

        .paginacao-proximo:hover:not(:disabled) {
            background: var(--color-vinho);
            color: var(--color-bege-claro);
            border: 2px solid var(--color-vinho);
        }

        .paginacao-anterior[disabled]{
            cursor: default !important;
            pointer-events: none;
            border: 2px solid var(--color-vinho);
            color: var(--color-vinho);
            opacity: 1;
        }

        .paginacao-proximo[disabled] {
            cursor: default !important;
            pointer-events: none;
            border: 2px solid var(--color-bege-claro);
            color: var(--color-vinho);
            background: var(--color-bege-claro);
            opacity: 1;
        }
    </style>
@endif
