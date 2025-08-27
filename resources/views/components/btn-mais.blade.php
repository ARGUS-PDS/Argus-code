<a href="{{ $href }}" class="btn-mais" title="Adicionar">
    <i class="bi bi-plus"></i>
</a>
<style>
.btn-mais {
    background-color: var(--color-vinho);
    color: var(--color-bege-claro);
    border: 2px solid var(--color-vinho);
    border-radius: 50%;
    width: 42px;
    height: 42px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    text-decoration: none;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s, transform 0.2s;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.btn-mais:hover {
    background-color: transparent;
    color: var(--color-vinho);
    border: 2px solid var(--color-vinho);
    transform: translateY(-2px);
}
</style> 