@extends('layouts.app')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&display=swap" rel="stylesheet" />
<style>
    body {
        padding: 0;
        margin: 0;
        background-color: var(--color-bege-claro);
    }

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

    /* Estilo para o título H2 (principal da página) */
    h2 {
        color: var(--color-vinho);
        font-weight: bold;
        margin-bottom: 1.5rem; /* Espaçamento abaixo do H2 */
        text-align: left; /* Alinha o título H2 à esquerda */
    }

    /* Estilos para o card de formulário */
    .form-card {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
        /* Removido display:flex, align-items, justify-content do .form-card
           para centralizar o formulário interno com margin: auto */
        text-align: center; /* Centraliza o conteúdo (formulário) se for um bloco */
    }

    /* Estilo para inputs */
    .form-control {
        border-radius: 8px;
        border: 1px solid var(--color-gray-claro) !important; /* !important para forçar a borda */
        background-color: #fff !important; /* !important para forçar o fundo branco */
        color: var(--color-gray-escuro) !important; /* !important para forçar a cor do texto */
    }

    .form-control:focus {
        border-color: var(--color-vinho) !important;
        box-shadow: 0 0 0 0.25rem rgba(119, 49, 56, 0.25) !important;
        background-color: #fff !important;
    }

    /* Estilo para botões primários (Adicionar) */
    .btn-primary {
        background-color: var(--color-vinho);
        border-color: var(--color-vinho);
        transition: background-color 0.3s ease, border-color 0.3s ease;
        border-radius: 8px;
    }

    .btn-primary:hover {
        background-color: rgb(136, 59, 67);
        border-color: rgb(136, 59, 67);
    }

    /* Estilo para o botão Limpar (danger) */
    .btn-outline-danger {
        color: var(--color-vinho);
        border-color: var(--color-vinho);
        border-radius: 8px;
    }
    .btn-outline-danger:hover {
        background-color: var(--color-vinho);
        color: #fff;
    }

    /* Estilo para o botão Imprimir (success) */
    .btn-success {
        background-color: var(--color-green);
        border-color: var(--color-green);
        border-radius: 8px;
    }
    .btn-success:hover {
        background-color: darken(var(--color-green), 10%);
        border-color: darken(var(--color-green), 10%);
    }

    /* Estilos das Etiquetas */
    .etiquetas {
        display: flex;
        flex-wrap: wrap;
        gap: 15px;
        justify-content: center;
    }

    .etiqueta {
        width: 90mm;
        height: 30mm;
        border: 3px solid var(--color-gray-escuro);
        padding: 10px;
        box-sizing: border-box;
        font-size: 14px;
        background-color: #fff;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
        transition: transform 0.2s ease-in-out;
    }

    .etiqueta:hover {
        transform: scale(1.05);
        box-shadow: 0 4px 12px rgb(0 0 0 / 0.2);
    }

    .etiqueta h3 {
        margin: 0 0 5px;
        font-size: 16px;
        white-space: normal;
        word-wrap: break-word;
        color: var(--color-gray-escuro);
    }

    .preco-barcode {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 5px;
    }

    .preco {
        font-size: 26px;
        font-weight: 700;
        white-space: nowrap;
        color: var(--color-green);
    }

    .barcode {
        font-family: 'Libre Barcode 39', cursive;
        font-size: 14px;
        line-height: 16px;
        margin-left: 10px;
        max-width: 120px;
        overflow: hidden;
    }

    .image {
        max-height: 20px;
    }

    .back {
        width: 100%;
        padding-bottom: 10px;
        display: flex;
        justify-content: space-between;
    }

    /* Estilos para impressão (mantidos como estão) */
    @page {
        size: A4;
        margin: 6mm;
    }

    @media print {
        body, html {
            margin: 0;
            padding: 0;
            width: 210mm;
            height: 297mm;
        }

        form, button, h2, a {
            display: none !important;
        }

        .container {
            width: 200mm !important;
            margin: 0 auto !important;
            padding: 0 !important;
        }
        .etiquetas {
            display: flex !important;
            flex-wrap: wrap !important;
            gap: 4mm !important;
            width: 200mm !important;
            justify-content: center !important;
            align-items: flex-start !important;
        }
        .etiqueta {
            flex: 0 0 98mm !important;
            max-width: 98mm !important;
            height: 38mm !important;
            margin: 0 !important;
            box-sizing: border-box !important;
            border: 2px solid #000 !important;
        }

        .etiqueta h3 {
            margin: 0 !important;
            font-size: 16px !important;
            word-wrap: break-word !important;
        }

        .preco-barcode {
            display: flex !important;
            align-items: center !important;
            justify-content: space-between !important;
            margin-top: 5px !important;
        }

        .preco {
            font-size: 40px !important;
            font-weight: bold !important;
            white-space: nowrap !important;
        }

        .barcode img {
            height: 22px !important;
            max-width: 120px !important;
            margin-left: 10px !important;
        }
    }
</style>
@endsection

@section('content')
<div class="container mt-4">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-3">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>
    <h2 class="mb-4">Gerar Etiquetas para Produtos</h2>

    @if(session('error'))
        <div class="alert alert-danger text-center" role="alert">
            {{ session('error') }}
        </div>
    @endif

    <div class="form-card">
        <form method="POST" action="{{ route('etiquetas.adicionar') }}" class="d-flex align-items-center gap-3 justify-content-center">
            @csrf
            <label for="codigo" class="col-form-label mb-0">Código de Barras (GTIN):</label>
            <input type="text" name="codigo" id="codigo" class="form-control" style="width: 250px;" required autofocus /> {{-- Largura fixa para testar --}}
            <button type="submit" class="btn btn-primary">Adicionar</button>
        </form>
    </div>

    @if(!empty($etiquetas))
        <div class="text-start mt-4">
            <a href="{{ route('etiquetas.limpar') }}" class="btn btn-outline-danger me-2">Limpar</a>
            <button onclick="window.print()" class="btn btn-success">Imprimir</button>
        </div>
    @endif

    <div class="etiquetas">
        @foreach ($etiquetas as $et)
            <div class="etiqueta">
                <h3 title="{{ $et['nome'] }}">{{ $et['nome'] }}</h3>
                <div class="preco-barcode">
                    <div class="preco">R$ {{ $et['preco'] }}</div>
                    <div class="barcode">
                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($et['codigo'], 'C128') }}" style="height:20px; max-width:120px;" />
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection