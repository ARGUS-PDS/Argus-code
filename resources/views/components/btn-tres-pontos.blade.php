<div class="dropdown">
    <i class="bi bi-three-dots-vertical btn-tres-pontos" role="button" id="{{ $id ?? 'dropdownMenuButton' }}" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.stopPropagation();"></i>
    <ul class="dropdown-menu" data-bs-boundary="viewport" aria-labelledby="{{ $id ?? 'dropdownMenuButton' }}" onclick="event.stopPropagation();">
        {{ $slot }}
    </ul>
</div>
<style>
.btn-tres-pontos {
    color: var(--color-vinho);
    font-size: 1.2rem;
    cursor: pointer;
    text-align: center;
    border-radius: 50%;
    padding: 4px;
    width: 34px;
    height: 34px;
    transition: background 0.3s, color 0.3s, box-shadow 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}
.btn-tres-pontos:hover {
    background: var(--color-vinho);
    color: var(--color-bege-claro);
    box-shadow: 0 2px 5px rgba(0,0,0,0.08);
}
</style> 