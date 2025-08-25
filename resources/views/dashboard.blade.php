@extends('layouts.app')

@include('layouts.css-variables')

@section('content')

<div class="row justify-content-center g-2 dashboard-group" id="dashboard-row" draggable="true">
  <div class="col-md-4">
    <div class="panel" draggable=true>
      <h5>{{ __('dashboard.prod_valid_title') }}</h5>
      <!-- @foreach($lotes_validade_proximas as $lote)
      <li>
        <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
        {{ $lote->batch_code }} - {{ \Carbon\Carbon::parse($lote->expiration_date)->format('d/m/Y') }} <span style="color: var(--color-orange); font-weight: bold;">(Lotes listados)</span>
      </li>
      @endforeach -->
      <ul class="mt-2 scrollable-list">
        @foreach($produtos_lote as $produto)
        <li>
          <i class="bi bi-exclamation-triangle-fill text-warning me-2"></i>
          {{ $produto->description }} - Lote: {{ $produto->batch_code }}
          (Validade: {{ \Carbon\Carbon::parse($produto->expiration_date)->format('d/m/Y') }})
        </li>
        @endforeach
      </ul>
    </div>
  </div>

  <div class="col-md-4">
    <div class="panel" draggable=true>
      <h5>{{ __('dashboard.movement_title') }}</h5>
      @if($movimentacoes->count())
      <ul class="mt-2 scrollable-list">
        @foreach($movimentacoes as $mov)
        <li>
          @if($mov->type === 'inward')
          <i class="bi bi-arrow-up-circle-fill text-success me-1"></i>
          @else
          <i class="bi bi-arrow-down-circle-fill text-danger me-1"></i>
          @endif
          ({{ $mov->quantity }}) - {{ $mov->product->description ?? '-' }}
          <small class="text-muted">({{ \Carbon\Carbon::parse($mov->created_at)->format('d/m/Y H:i') }})</small>
        </li>
        @endforeach

      </ul>
      @else
      <div class="d-flex flex-column align-items-center justify-content-center card-vazio" style="min-height:180px;">
        <i class="bi bi-arrow-left-right" style="font-size: 2.5rem; color: var(--color-vinho);"></i>
        <span class="fw-bold text-center mt-2" style="color: var(--color-vinho);">{{ __('dashboard.no_news') }}</span>
      </div>
      @endif
    </div>
  </div>

  <div class="col-md-4">
    <div class="panel" draggable=true>
      <h5>{{ __('dashboard.alerts_title') }}</h5>
      @if($produtos_vencidos->count() || $produtos_estoque_minimo->count() || $produtos_estoque_baixo->count() || $produtos_estoque_zerado->count() || $lotes_validade_proximas->count() || $produtos_lote->count())
      <ul class="mt-2 scrollable-list">
        @foreach($produtos_vencidos as $produto)
        <li>
          <i class="bi bi-exclamation-circle-fill text-danger me-2"></i>
          {{ $produto->description }} {{ __('dashboard.expired_on') }} {{ \Carbon\Carbon::parse($produto->expiration_date)->format('d/m/Y') }}
        </li>
        @endforeach


        @foreach($produtos_estoque_baixo as $produto)
        <li>
          <i class="bi bi-arrow-down-circle-fill text-danger me-2"></i>
          {{ $produto->description }} <span style="color: var(--color-red); font-weight: bold;">(Estoque Baixo)</span>
        </li>
        @endforeach

        @foreach($produtos_estoque_zerado as $produto)
        <li>
          <i class="bi bi-x-circle-fill text-vinho me-2"></i>
          {{ $produto->description }} <span style="color: var(--color-vinho); font-weight: bold;">(Esgotado)</span>
        </li>
        @endforeach

      </ul>
      @else
      <div class="d-flex flex-column align-items-center justify-content-center card-vazio" style="min-height:180px;">
        <i class="bi bi-exclamation-triangle" style="font-size: 2.5rem; color: var(--color-vinho);"></i>
        <span class="fw-bold text-center mt-2" style="color: var(--color-vinho);">{{ __('dashboard.no_news') }}</span>
      </div>
      @endif
    </div>
  </div>
</div>

<div class="row justify-content-center g-2 dashboard-group" id="dashboard-chart-row" draggable="true">
  <div class="col-12" style="position: relative;">
    <div class="grafico p-4 mb-0" style="height: 250px; display: flex; flex-direction: column; justify-content: flex-start; position: relative;">
      <div class="grafico-toolbar">
        <button class="grafico-btn" data-periodo="ano">{{ __('dashboard.year') }}</button>
        <button class="grafico-btn active" data-periodo="mes">{{ __('dashboard.month') }}</button>
        <button class="grafico-btn" data-periodo="semana">{{ __('dashboard.week') }}</button>
        <button class="grafico-btn" data-periodo="dia">{{ __('dashboard.day') }}</button>
      </div>
      <h5>{{ __('dashboard.sales') }}</h5>
      <div style="flex:1; min-height: 0;">
        <canvas id="vendasTempoChart" style="width:100%; height:180px;"></canvas>
      </div>
    </div>
  </div>
</div>

<style>
  .panel ul.scrollable-list {
    max-height: 150px;
    overflow-y: auto;
    padding-right: 10px;
    list-style: none;
    padding-left: 0;
  }

  .panel ul.scrollable-list li {
    white-space: normal;
    word-wrap: break-word;
    margin-bottom: 7px;
  }

  .panel ul.scrollable-list::-webkit-scrollbar {
    width: 8px;
  }

  .panel ul.scrollable-list::-webkit-scrollbar-track {
    background: var(--color-bege-claro);
    border-radius: 10px;
  }

  .panel ul.scrollable-list::-webkit-scrollbar-thumb {
    background: #888;
    border-radius: 10px;
  }

  .panel ul.scrollable-list::-webkit-scrollbar-thumb:hover {
    background: #555;
  }
</style>

<link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>

@endsection