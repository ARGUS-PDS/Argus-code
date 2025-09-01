<a href="{{ url()->previous() }}" class="btn-voltar">
    <i class="bi bi-arrow-left"></i> {{ __('buttons.back') }}
</a>
<style>
.btn-voltar {
    background-color: var(--color-vinho) !important;
    color: var(--color-bege-claro) !important;
    border: 2px solid var(--color-vinho) !important;
    border-radius: 10px !important;
    padding: 10px 18px !important;
    font-size: 0.95rem !important;
    text-decoration: none !important;
    transition: background-color 0.3s, color 0.3s, border-color 0.3s, transform 0.2s !important;
    box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
}
.btn-voltar:hover {
    background-color: transparent !important;
    color: var(--color-vinho) !important;
    border: 2px solid var(--color-vinho) !important;
    transform: translateY(-2px) !important;
}
</style>
