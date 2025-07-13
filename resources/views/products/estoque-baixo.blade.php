@extends('layouts.app')

@section('styles')
<style>
 
    :root {
        --color-vinho: #773138; /* Vinho principal para títulos e botões primários */
        --color-bege-claro: #f8f0e5; /* Bege claro para o fundo da página e elementos secundários */
        --color-gray-claro: #ddd; /* Cinza claro para bordas e elementos sutis */
        --color-gray-escuro: #555; /* Cinza escuro para textos e bordas mais fortes */
        --color-green: #28a745; /* Verde geral para sucesso (mantido para outros usos como WhatsApp) */
        
        --color-table-header: #773138; /* Cor do cabeçalho da tabela de Fornecedores */
        --color-table-row-bg: #f8f0e5; /* Cor de fundo das linhas da tabela */
        --color-input-bg: #fff; /* Fundo dos inputs */
    }

    body {
        padding: 0;
        margin: 0;
        background-color: var(--color-bege-claro); 
    }

    /* Estilo para o título principal da página */
    h2 {
        color: var(--color-vinho); 
        font-weight: bold;
        margin-bottom: 1.5rem;
        text-align: left;
    }

    /* Estilo do botão "Ver Pedidos Enviados"*/
    .btn-primary-header-action { 
        background-color: var(--color-vinho);
        border-color: var(--color-vinho);
        color: #fff;
        border-radius: 8px;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .btn-primary-header-action:hover {
        background-color: rgb(136, 59, 67); 
        border-color: rgb(136, 59, 67);
        color: #fff;
    }

    /* Estilos para os cards de produto */
    .product-card {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        padding: 1.5rem;
        margin-bottom: 1rem; 
        transition: all 0.2s ease-in-out;
    }

    .product-card:hover {
        transform: translateY(-3px); 
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }

    .product-card h5 {
        color: var(--color-vinho); 
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .product-card small {
        color: var(--color-gray-escuro); 
    }

    /* Estilo para o botão "Fazer Pedido" */
    .btn-outline-primary-custom {
        color: var(--color-vinho);
        border-color: var(--color-vinho);
        border-radius: 8px;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .btn-outline-primary-custom:hover {
        background-color: var(--color-vinho);
        color: var(--color-bege-claro);
    }

    /* Estilos para os inputs e labels dentro do formulário de pedido */
    .form-label {
        color: var(--color-gray-escuro);
        font-weight: 600;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid var(--color-gray-claro);
        background-color: var(--color-input-bg); 
        color: var(--color-gray-escuro);
    }

    .form-control:focus {
        border-color: var(--color-vinho);
        box-shadow: 0 0 0 0.25rem rgba(119, 49, 56, 0.25);
        background-color: var(--color-input-bg);
    }

    /* Estilos dos botões de envio (E-mail/WhatsApp) dentro do formulário de pedido */
    .btn-outline-email { /* E-mail */
        color: var(--color-vinho);
        border-color: var(--color-vinho);
        border-radius: 8px;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .btn-outline-email:hover {
        background-color: var(--color-vinho);
        color: #fff;
    }

    .btn-outline-whatsapp { /* WhatsApp */
        color: var(--color-green); /* Usar o verde padrão de sucesso para o WhatsApp */
        border-color: var(--color-green);
        border-radius: 8px;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .btn-outline-whatsapp:hover {
        background-color: var(--color-green);
        color: #fff;
    }

    /* Estilo para o card do formulário de pedido (quando expandido) */
    .card-body-custom {
        padding: 1.5rem;
        background-color: var(--color-bege-claro); 
        border-radius: 0 0 8px 8px; 
        border-top: 1px solid #e0e0e0;
    }
    .card-body-custom h6 {
        color: var(--color-vinho);
        font-weight: bold;
    }

    /* Botões Enviar Pedido / Cancelar */
    .btn-primary-form { /* Estilo para o botão Enviar Pedido */
        background-color: var(--color-vinho);
        border-color: var(--color-vinho);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .btn-primary-form:hover {
        background-color: rgb(136, 59, 67);
        border-color: rgb(136, 59, 67);
    }
    .btn-secondary-form { /* Estilo para o botão Cancelar */
        background-color: var(--color-gray-claro);
        border-color: var(--color-gray-claro);
        color: var(--color-gray-escuro);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .btn-secondary-form:hover {
        background-color: darken(var(--color-gray-claro), 10%);
        border-color: darken(var(--color-gray-claro), 10%);
        color: var(--color-gray-escuro);
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Produtos com Estoque Baixo</h2>
        <a href="{{ route('orders.index') }}" class="btn btn-primary-header-action"> {{-- Agora é vinho --}}
            Ver Pedidos Enviados
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success text-center" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger text-center" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @foreach($produtos as $produto)
        <div class="product-card">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">{{ $produto->description }}</h5>
                    <small>
                        Estoque atual: <strong>{{ $produto->currentStock }}</strong> | Mínimo: {{ $produto->minimumStock }}
                    </small>
                </div>
                <button class="btn btn-outline-primary-custom"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#formPedido{{ $produto->id }}"
                    aria-expanded="false"
                    aria-controls="formPedido{{ $produto->id }}">
                    Fazer Pedido
                </button>
            </div>
            <div class="collapse mt-3" id="formPedido{{ $produto->id }}">
                <div class="card card-body card-body-custom">
                    <h6 class="mb-3">Fazer Pedido</h6>
                    <form action="{{ route('pedido.enviar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                        <div class="mb-3">
                            <label for="quantidade{{ $produto->id }}" class="form-label">Quantidade desejada:</label>
                            <input type="number" name="quantidade" id="quantidade{{ $produto->id }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="prazo{{ $produto->id }}" class="form-label">Prazo de entrega:</label>
                            <input type="text" name="prazo" id="prazo{{ $produto->id }}" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Enviar via:</label>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-email" onclick="setCanalEnvio('{{ $produto->id }}', 'email')">
                                    <i class="fas fa-envelope"></i> E-mail
                                </button>
                                <button type="button" class="btn btn-outline-whatsapp" onclick="setCanalEnvio('{{ $produto->id }}', 'whatsapp')">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </button>
                            </div>
                            <input type="hidden" name="canal_envio" id="canal_envio_input_{{ $produto->id }}" required>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary-form">Enviar Pedido</button>
                            <button type="button" class="btn btn-secondary-form" data-bs-toggle="collapse" data-bs-target="#formPedido{{ $produto->id }}">Cancelar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@if(session('whatsapp_url'))
    <script>
        window.open("{{ session('whatsapp_url') }}", "_blank");
    </script>
@endif

<script>
    function setCanalEnvio(produtoId, canal) {
        document.getElementById(`canal_envio_input_${produtoId}`).value = canal;
    }
</script>
@endsection