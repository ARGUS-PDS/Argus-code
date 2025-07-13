@extends('layouts.app')

@include('layouts.css-variables')

@section('content')


<div class="row justify-content-center g-2 dashboard-group" id="dashboard-row" draggable="true">
  <div class="col-md-4">
     <div class="panel" draggable=true>
      <h5>{{ __('dashboard.prod_valid_title') }}</h5>
       <ul class="mt-2">
         <li>Produto A - Vence em 3 dias</li>
         <li>Produto B - Vence amanhã</li>
         <li>Produto C - Vence hoje</li>
       </ul>
     </div>
  </div>

  <div class="col-md-4">
     <div class="panel" draggable=true>
      <h5>{{ __('dashboard.movement_title') }}</h5>
       <ul class="mt-2">
         <li>Entrada - Produto D</li>
         <li>Saída - Produto A</li>
         <li>Entrada - Produto E</li>
       </ul>
     </div>
  </div>

  <div class="col-md-4">
     <div class="panel" draggable=true>
     <h5>{{ __('dashboard.alerts_title') }}</h5>
     <ul class="mt-2">
         <li>Produto C venceu</li>
         <li>Produto F parado há 90 dias</li>
       </ul>
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