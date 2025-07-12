@extends('layouts.app')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('css/etiquetas.css') }}">

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