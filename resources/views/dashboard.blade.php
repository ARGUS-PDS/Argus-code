@extends('layouts.app')

@section('content')
<div class="row g-4">
  <div class="col-md-4">
     <div class="panel">
       <h5>Produto / Validade</h5>
       <ul class="mt-2">
         <li>Produto A - Vence em 3 dias</li>
         <li>Produto B - Vence amanhã</li>
         <li>Produto C - Vence hoje</li>
       </ul>
     </div>
  </div>

  <div class="col-md-4">
     <div class="panel">
       <h5>Entrada / Saída</h5>
       <ul class="mt-2">
         <li>Entrada - Produto D</li>
         <li>Saída - Produto A</li>
         <li>Entrada - Produto E</li>
       </ul>
     </div>
  </div>

  <div class="col-md-4">
     <div class="panel">
       <h5>Alertas</h5>
       <ul class="mt-2">
         <li>Produto C venceu</li>
         <li>Produto F parado há 90 dias</li>
       </ul>
     </div>
  </div>
</div>

<style>
  .panel {
    background-color: var(--color-bege-claro);
    color: var(--color-gray-escuro);
    border-radius: 15px;
    padding: 1rem;
    height: 250px;
    overflow-y: auto;
    box-shadow: 0 2px 10px rgba(0,0,0,0.08);
  }

  .panel h5 {
    font-weight: bold;
    color: var(--color-vinho);
  }
</style>
@endsection