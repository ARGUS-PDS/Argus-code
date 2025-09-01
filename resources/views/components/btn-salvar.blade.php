<button type="submit" class="btn-salvar">{{ __('buttons.save') }}</button>
<style>
.btn-salvar {
    background-color: var(--color-bege-claro);
    color: var(--color-vinho);
    border: 2px solid var(--color-vinho);
    border-radius: 10px;
    padding: 10px 18px;
    font-size: 0.95rem;
    text-decoration: none;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s, transform 0.2s;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    margin-left: 8px;
    display: inline-block;
}

.btn-salvar:hover {
    background-color: var(--color-vinho);
    color: var(--color-bege-claro);
    border: 2px solid var(--color-vinho);
    transform: translateY(-2px);
}
</style>
