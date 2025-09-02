@extends('layouts.app') 

@include('layouts.css-variables')

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
        text-align: left;
    }

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
        background-color: var(--color-vinho); 
        color: var(--color-white);
    }

    .table-custom th,
    .table-custom td {
        padding: 12px 15px;
        border-bottom: 1px solid var(--color-bege);
        border-right: 1px solid var(--color-bege);
        text-align: left;
        color: var(--color-gray-escuro); 
    }

    .table-custom thead th {
        color: var(--color-white); 
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
        background-color: var(--color-bege);
    }
    .table-custom tbody tr:nth-child(even) {
        background-color: var(--color-white);
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
        <h2 class="m-0">{{ __('order.pedidos_enviados') }}</h2> 
        <x-btn-voltar url="{{ route('produtos.esgotando') }}" />
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
                    <th>{{ __('order.data') }}</th>
                    <th>{{ __('order.produto') }}</th>
                    <th>{{ __('order.fornecedor') }}</th>
                    <th>{{ __('order.quantidade') }}</th>
                    <th>{{ __('order.prazo') }}</th>
                    <th>{{ __('order.canal') }}</th>
                    <th>{{ __('order.mensagem') }}</th>
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
                        <td colspan="7" class="text-center">{{ __('order.nenhum_pedido_enviado') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@endsection