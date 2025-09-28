@extends('layouts.app')

@section('styles')
<style>

    body {
        padding: 0;
        margin: 0;
        background-color: var(--color-bege-claro); 
    }

    h2 {
        color: var(--color-vinho); 
        font-weight: bold;
        margin-bottom: 1.5rem;
        text-align: left;
    }

    .btn-primary-header-action { 
        background-color: var(--color-vinho);
        color: var(--color-bege-claro);
        border: 2px solid var(--color-vinho);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        transition: background-color 0.3s, color 0.3s, border-color 0.3s, transform 0.2s !important;
    }
    .btn-primary-header-action:hover {
        background-color: var(--color-bege-claro);
        color: var(--color-vinho);
        border: 2px solid var(--color-vinho);
        transform: translateY(-2px) !important;
    }

    .product-card {
        background-color: var(--color-vinho-fundo);
        border: 1px solid var(--color-vinho-fundo);
        border-radius: 8px;
        box-shadow: 0 2px 4px var(--color-shadow);
        padding: 1.5rem;
        margin-bottom: 1rem; 
        transition: all 0.2s ease-in-out;
    }

    .product-card:hover {
        transform: translateY(-3px); 
        box-shadow: 0 2px 4px var(--color-shadow);
    }

    .product-card h5 {
        color: var(--color-vinho); 
        font-weight: bold;
        margin-bottom: 0.5rem;
    }

    .product-card small {
        color: var(--color-gray-escuro); 
    }

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

    .form-label {
        color: var(--color-gray-escuro);
        font-weight: 600;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid  #f8f9fa;
        background-color: #fff; 
        color: var(--color-gray-escuro);
    }

    .form-control:focus {
        border-color: var(--color-vinho);
        box-shadow: 0 0 0 0.25rem var(--color-shadow);
        background-color: #fff;
    }

    .btn-outline-email {
        color: var(--color-vinho);
        border-color: var(--color-vinho);
        border-radius: 8px;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .btn-outline-email:hover {
        background-color: var(--color-vinho);
        color: var(--color-bege-claro);
    }

    .btn-outline-whatsapp {
        color: var(--color-green);
        border-color: var(--color-green);
        border-radius: 8px;
        transition: all 0.3s ease;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .btn-outline-whatsapp:hover {
        background-color: var(--color-green);
        color: var(--color-bege-claro);
    }

    .card-body-custom {
        padding: 1.5rem;
        background-color: var(--color-bege-claro); 
        border-radius: 8px;
        border-color: var(--color-bege-claro);
    }
    .card-body-custom h6 {
        color: var(--color-vinho);
        font-weight: bold;
    }

    .btn-primary-form {
        background-color: var(--color-vinho);
        border: 2px solid var(--color-vinho);
        color: var(--color-bege-claro);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .btn-primary-form:hover {
        background-color: var(--color-bege-claro);
        color: var(--color-vinho);
        border: 2px solid var(--color-vinho);
    }
    .btn-secondary-form {
        background-color: var(--color-bege-claro);
        border: 2px solid var(--color-vinho);
        color: var(--color-vinho);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }
    .btn-secondary-form:hover {
        background-color: var(--color-vinho);
        border: 2px solid var(--color-vinho);
        color: var(--color-bege-claro);
    }

    .btn-selected {
    background-color: var(--color-vinho) !important;
    color: #fff !important;
    border-color: var(--color-vinho) !important;
}

.btn-whatsapp-selected {
    background-color: var(--color-green) !important;
    color: #fff !important;
    border-color: var(--color-green) !important;
}

</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>{{ __('lowstock.produtos_com_estoque_baixo') }}</h2>
        <div class="d-flex align-items-center" style="gap: 16px;">
            <x-search-bar 
                name="q"
                :value="request('q')"
                placeholder="{{ __('lowstock.pesquisar_produto') }}"
                action="{{ route('produtos.esgotando') }}"
            />
            <a href="{{ route('orders.index') }}" class="btn btn-primary-header-action ms-3">{{ __('lowstock.ver_pedidos_enviados') }}</a>
        </div>
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
                        {{ __('lowstock.estoque_atual') }} <strong>{{ $produto->currentStock }}</strong> | {{ __('lowstock.minimo') }} {{ $produto->minimumStock }}
                    </small>
                </div>
                <button class="btn btn-outline-primary-custom"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#formPedido{{ $produto->id }}"
                    aria-expanded="false"
                    aria-controls="formPedido{{ $produto->id }}">
                    {{ __('lowstock.fazer_pedido') }}
                </button>
            </div>
            <div class="collapse mt-3" id="formPedido{{ $produto->id }}">
                <div class="card card-body card-body-custom">
                    <h6 class="mb-3">{{ __('lowstock.fazer_pedido') }}</h6>
                    <form action="{{ route('pedido.enviar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                        <div class="mb-3">
                            <label for="quantidade{{ $produto->id }}" class="form-label">{{ __('lowstock.quantidade_desejada') }}</label>
                            <input type="number" name="quantidade" id="quantidade{{ $produto->id }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="prazo{{ $produto->id }}" class="form-label">{{ __('lowstock.prazo_de_entrega') }}</label>
                            <div class="d-flex gap-2">
                                <input type="number" name="prazo_valor" id="prazo_valor{{ $produto->id }}" class="form-control" min="1" required placeholder="{{ __('lowstock.exemplo_prazo') }}">
                                <select name="prazo_unidade" id="prazo_unidade{{ $produto->id }}" class="form-control" required>
                                    <option value="" disabled selected>{{ __('lowstock.selecione') }}</option>
                                    <option value="dia(s)">{{ __('lowstock.dia_s') }}</option>
                                    <option value="semana(s)">{{ __('lowstock.semana_s') }}</option>
                                    <option value="mês(es)">{{ __('lowstock.mes_es') }}</option>
                                </select>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">{{ __('lowstock.enviar_via') }}</label>
                            <div class="d-flex gap-2">
                                <button type="button" class="btn btn-outline-email" onclick="setCanalEnvio('{{ $produto->id }}', 'email')">
                                    <i class="fas fa-envelope"></i> {{ __('lowstock.email') }}
                                </button>
                                <button type="button" class="btn btn-outline-whatsapp" onclick="setCanalEnvio('{{ $produto->id }}', 'whatsapp')">
                                    <i class="fab fa-whatsapp"></i> {{ __('lowstock.whatsapp') }}
                                </button>
                            </div>
                            <input type="hidden" name="canal_envio" id="canal_envio_input_{{ $produto->id }}" required>
                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <button type="submit" class="btn btn-primary-form" onclick="mostrarTelaCarregando()">{{ __('lowstock.enviar_pedido') }}</button>
                            <button type="button" class="btn btn-secondary-form" data-bs-toggle="collapse" data-bs-target="#formPedido{{ $produto->id }}">{{ __('lowstock.cancelar') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @include('layouts.carregamento')

    <x-paginacao :paginator="$produtos" />
</div>

@if(session('whatsapp_url'))
    <script>
        window.open("{{ session('whatsapp_url') }}", "_blank");
    </script>
@endif

<script>
    function setCanalEnvio(produtoId, canal) {
        const hiddenInput = document.getElementById(`canal_envio_input_${produtoId}`);
        hiddenInput.value = canal;

        const emailBtn = document.querySelector(`#formPedido${produtoId} .btn-outline-email`);
        const whatsappBtn = document.querySelector(`#formPedido${produtoId} .btn-outline-whatsapp`);
        emailBtn.classList.remove('btn-selected');
        whatsappBtn.classList.remove('btn-whatsapp-selected');

        if (canal === 'email') {
            emailBtn.classList.add('btn-selected');
        } else if (canal === 'whatsapp') {
            whatsappBtn.classList.add('btn-whatsapp-selected');
        }
    }
</script>
@endsection