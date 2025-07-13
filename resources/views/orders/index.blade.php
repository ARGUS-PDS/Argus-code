@extends('layouts.app') 

@section('styles')
<style>

    :root {
        --color-vinho: #773138;
        --color-bege-claro: #f8f0e5; 
        --color-gray-claro: #ddd;
        --color-gray-escuro: #555;
        --color-green: #28a745;
        --color-table-header-bg: #773138;
        --color-table-header-text: #fff;
        --color-table-row-bg: #fdfaf7; 
        --color-border: #e0e0e0; 

        --bs-secondary: var(--color-vinho);
        --bs-btn-color: var(--color-vinho);
        --bs-btn-border-color: var(--color-vinho);
        --bs-btn-hover-color: var(--color-bege-claro);
        --bs-btn-hover-bg: var(--color-vinho);
        --bs-btn-hover-border-color: var(--color-vinho);
    }

    body {
        padding: 0;
        margin: 0;
        background-color: var(--color-bege-claro); /* Fundo da página */
    }

    /* Estilo para o título principal da página */
    h2 {
        color: var(--color-vinho); 
        font-weight: bold;
        text-align: left;
    }

    /* Ajustes específicos para o botão Voltar */
    .btn-custom-back {
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-outline-secondary.btn-custom-back:hover {
        background-color: var(--color-vinho) !important;
        color: var(--color-bege-claro) !important;
        border-color: var(--color-vinho) !important;
    }

    /* Estilos da Tabela */
    .table-custom {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        background-color: #fff;
    }

    .table-custom thead {
        background-color: var(--color-table-header-bg); 
        color: var(--color-table-header-text);
    }

    .table-custom th,
    .table-custom td {
        padding: 12px 15px;
        border-bottom: 1px solid var(--color-border);
        border-right: 1px solid var(--color-border);
        text-align: left;
        color: var(--color-gray-escuro); 
    }

    .table-custom thead th {
        color: var(--color-table-header-text); 
        font-weight: bold;
    }

    .table-custom th:last-child,
    .table-custom td:last-child {
        border-right: none;
    }

    .table-custom tbody tr:last-child td {
        border-bottom: none;
    }

    .table-custom tbody tr:nth-child(odd) {
        background-color: var(--color-table-row-bg);
    }
    .table-custom tbody tr:nth-child(even) {
        background-color: #ffffff;
    }

    .table-custom tbody tr:hover {
        background-color: rgba(119, 49, 56, 0.05);
    }

    .table-custom td.prazo-column {
        white-space: nowrap;
    }

    .table-custom .text-center {
        text-align: center;
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="m-0">Pedidos Enviados</h2> 
        <a href="{{ route('produtos.esgotando') }}" class="btn btn-outline-secondary btn-custom-back">
            <i class="bi bi-arrow-left"></i> Voltar
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

    <div class="table-responsive">
        <table class="table-custom">
            <thead>
                <tr>
                    <th>Data</th>
                    <th>Produto</th>
                    <th>Fornecedor</th>
                    <th>Quantidade</th>
                    <th>Prazo</th>
                    <th>Canal</th>
                    <th>Mensagem</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pedidos as $pedido)
                    <tr>
                        <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                        <td>{{ $pedido->produto->description ?? '-' }}</td>
                        <td>{{ $pedido->fornecedor->name ?? '-' }}</td>
                        <td>{{ $pedido->quantidade }}</td>
                        <td class="prazo-column">{{ $pedido->prazo_entrega }}</td>
                        <td>{{ ucfirst($pedido->canal_envio) }}</td>
                        <td>{{ $pedido->mensagem_enviada }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">Nenhum pedido enviado ainda.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection