@extends('layouts.app')

@include('layouts.css-variables')

@section('content')


<div class="row justify-content-center g-2 dashboard-group" id="dashboard-row" draggable="true">
  <div class="col-md-4">
     <div class="panel" draggable=true>
      <h5>{{ __('dashboard.prod_valid_title') }}</h5>
      @if($produtos_validade->count())
        <ul class="mt-2">
          @foreach($produtos_validade as $produto)
            <li>{{ $produto->description }} - Vence em {{ \Carbon\Carbon::parse($produto->expiration_date)->diffInDays(now()) }} dias ({{ \Carbon\Carbon::parse($produto->expiration_date)->format('d/m/Y') }})</li>
          @endforeach
        </ul>
      @else
        <div class="d-flex flex-column align-items-center justify-content-center card-vazio" style="min-height:180px;">
          <i class="bi bi-calendar-x" style="font-size: 2.5rem; color: var(--color-vinho);"></i>
          <span class="fw-bold text-center mt-2" style="color: var(--color-vinho);">Nenhuma novidade por aqui</span>
        </div>
      @endif
     </div>
  </div>

  <div class="col-md-4">
     <div class="panel" draggable=true>
      <h5>{{ __('dashboard.movement_title') }}</h5>
      @if($movimentacoes->count())
        <ul class="mt-2">
          @foreach($movimentacoes as $mov)
            <li>{{ ucfirst($mov->type) }} ({{ $mov->quantity }}) - {{ $mov->product->description ?? '-' }}</li>
          @endforeach
        </ul>
      @else
        <div class="d-flex flex-column align-items-center justify-content-center card-vazio" style="min-height:180px;">
          <i class="bi bi-arrow-left-right" style="font-size: 2.5rem; color: var(--color-vinho);"></i>
          <span class="fw-bold text-center mt-2" style="color: var(--color-vinho);">Nenhuma novidade por aqui</span>
        </div>
      @endif
     </div>
  </div>

  <div class="col-md-4">
     <div class="panel" draggable=true>
     <h5>{{ __('dashboard.alerts_title') }}</h5>
     @if($produtos_vencidos->count())
       <ul class="mt-2">
         @foreach($produtos_vencidos as $produto)
           <li>{{ $produto->description }} venceu em {{ \Carbon\Carbon::parse($produto->expiration_date)->format('d/m/Y') }}</li>
         @endforeach
       </ul>
     @else
       <div class="d-flex flex-column align-items-center justify-content-center card-vazio" style="min-height:180px;">
         <i class="bi bi-exclamation-triangle" style="font-size: 2.5rem; color: var(--color-vinho);"></i>
         <span class="fw-bold text-center mt-2" style="color: var(--color-vinho);">Nenhuma novidade por aqui</span>
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
      <h5>Vendas</h5>
      <div style="flex:1; min-height: 0;">
        <canvas id="vendasTempoChart" style="width:100%; height:180px;"></canvas>
      </div>
    </div>
  </div>
</div>
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">


<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('js/dashboard.js') }}"></script>

@endsection