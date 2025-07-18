@props(['paginator'])
@if ($paginator->lastPage() > 1)
    <div class="d-flex justify-content-center mt-4" style="gap: 8px;">
        @if ($paginator->onFirstPage())
            <button class="btn paginacao-anterior paginacao-disabled" disabled>Anterior</button>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="btn paginacao-anterior">Anterior</a>
        @endif
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="btn paginacao-proximo">Próximo</a>
        @else
            <button class="btn paginacao-proximo paginacao-disabled" disabled>Próximo</button>
        @endif
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

        .paginacao-anterior.paginacao-disabled {
            border: 2px solid var(--color-vinho-fundo) !important;
            color: var(--color-vinho-fundo) !important;
            background: transparent !important;
            opacity: 1 !important;
        }

        .paginacao-proximo.paginacao-disabled {
            border: 2px solid var(--color-vinho-fundo) !important;
            background: transparent !important;
            color: var(--color-vinho-fundo) !important;
            opacity: 1 !important;
        }
    </style>
@endif 