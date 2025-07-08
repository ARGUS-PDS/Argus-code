@extends('layouts.app')

@section('styles')
<style>
    /* Estilo para o botão "Voltar" */
    .btn-outline-secondary {
        color: var(--color-vinho);
        border-color: var(--color-vinho);
        transition: all 0.3s ease;
    }

    .btn-outline-secondary:hover {
        background-color: var(--color-vinho);
        color: var(--color-bege-claro);
    }

    /* Estilo para o título H2 */
    h2 {
        color: var(--color-vinho);
        font-weight: bold;
    }

    /* Estilos para os fieldsets (cartões) */
    fieldset {
        background-color: #fff; /* Fundo branco para o fieldset */
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    legend {
        font-size: 1.25rem;
        font-weight: bold;
        color: var(--color-vinho);
        padding: 0 0.5rem;
        width: auto;
        border-bottom: none;
        margin-left: -0.5rem;
    }

    /* Estilo para os inputs */
    .form-control, .input-group-text {
        border-radius: 8px;
        border: 1px solid var(--color-gray-claro);
        background-color: #fff; /* Fundo branco padrão para inputs editáveis */
        color: var(--color-gray-escuro);
    }

    .form-control:focus {
        border-color: var(--color-vinho);
        box-shadow: 0 0 0 0.25rem rgba(119, 49, 56, 0.25);
        background-color: #fff;
    }

    /* --- ALTERAÇÃO AQUI: Estilo para campos desabilitados --- */
    .form-control:disabled, .form-control[readonly] {
        background-color: #e9ecef; /* Cinza claro suave, padrão Bootstrap */
        opacity: 1; /* Garante opacidade total */
        color: var(--color-gray-escuro); /* Cor do texto normal para leitura */
        border-color: #ced4da; /* Borda um pouco mais escura para contraste */
    }

    .input-group-text {
        background-color: var(--color-bege-claro); /* Fundo bege claro para o ícone de busca */
        color: var(--color-vinho);
        border-left: none;
    }

    /* Ajuste para o campo de data, que pode ter uma aparência diferente */
    input[type="date"].form-control {
        appearance: none;
        -webkit-appearance: none;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
    <h2 class="mb-4">Detalhamento de Lote</h2>

    <fieldset class="border p-3">
        <legend class="w-auto px-2">Informações do Lote</legend>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="lote" class="form-label">Lote</label>
                <div class="input-group">
                    <input type="text" name="lote" id="lote" class="form-control" placeholder="Digite o número do lote">
                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
            </div>

            <div class="col-md-6">
                <label for="produto" class="form-label">Produto</label>
                <input type="text" name="produto" id="produto" class="form-control" placeholder="Nome do produto" disabled>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label for="data_validade" class="form-label">Data de Validade</label>
                <input type="date" name="data_validade" id="data_validade" class="form-control" disabled>
            </div>

            <div class="col-md-6">
                <label for="data_entrada" class="form-label">Data de Entrada</label>
                <input type="date" name="data_entrada" id="data_entrada" class="form-control" disabled>
            </div>
        </div>
    </fieldset>
</div>
@endsection

