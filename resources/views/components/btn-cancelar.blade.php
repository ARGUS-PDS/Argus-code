@props(['href' => '#'])

@if(isset($attributes['data-bs-dismiss']))
    <button type="button" class="btn-cancelar" {{ $attributes }}>
        Cancelar
    </button>
@else
    <a href="{{ $href }}" class="btn-cancelar" {{ $attributes }}>
        Cancelar
    </a>
@endif

<style>
.btn-cancelar {
    background-color: var(--color-vinho);
    color: var(--color-bege-claro);
    border: 2px solid var(--color-vinho);
    border-radius: 10px;
    padding: 10px 18px;
    font-size: 0.95rem;
    text-decoration: none;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s, transform 0.2s;
    margin-right: 8px;
    display: inline-block;
    cursor: pointer;
}

.btn-cancelar:hover {
    background-color: transparent;
    color: var(--color-vinho);
    border: 2px solid var(--color-vinho);
    transform: translateY(-2px);
}
</style> 