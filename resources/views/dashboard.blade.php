@extends('layouts.app')

@include('layouts.css-variables')

@section('content')
<div class="row justify-content-center g-2" id="dashboard-row">
  <div class="col-md-4">
     <div class="panel" draggable=true>
       <h5>Produto / Validade</h5>
       <ul class="mt-2">
         <li>Produto A - Vence em 3 dias</li>
         <li>Produto B - Vence amanhã</li>
         <li>Produto C - Vence hoje</li>
       </ul>
     </div>
  </div>

  <div class="col-md-4">
     <div class="panel" draggable=true>
       <h5>Entrada / Saída</h5>
       <ul class="mt-2">
         <li>Entrada - Produto D</li>
         <li>Saída - Produto A</li>
         <li>Entrada - Produto E</li>
       </ul>
     </div>
  </div>

  <div class="col-md-4">
     <div class="panel" draggable=true>
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
    box-shadow: 0 2px 10px rgba(119, 49, 56, 0.5);
    cursor: grab;
    transition: box-shadow 0.2s ease, outline 0.2s ease;
  }

  .panel h5 {
    font-weight: bold;
    color: var(--color-vinho);
  }

  .col-md-4 {
    transition: outline 0.2s ease;
  }

  .panel:hover {
    background-color: var(--color-vinho);
    color: var(--color-bege-claro);

    h5{
      color: var(--color-bege-claro);
    }
  }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
  const row = document.getElementById('dashboard-row');
  let draggedCol = null;

  document.querySelectorAll('.panel').forEach(panel => {
    panel.addEventListener('dragstart', function (e) {
      draggedCol = panel.closest('.col-md-4');
      e.dataTransfer.effectAllowed = 'move';
    });
  });

  document.querySelectorAll('.col-md-4').forEach(col => {
    col.addEventListener('dragover', function (e) {
      e.preventDefault();
      col.style.border = '2px dashed #773138';
    });

    col.addEventListener('dragleave', function () {
      col.style.border = '';
    });

    col.addEventListener('drop', function (e) {
      e.preventDefault();
      col.style.border = '';
      if (draggedCol && draggedCol !== col) {
        const allCols = Array.from(row.children);
        const draggedIndex = allCols.indexOf(draggedCol);
        const targetIndex = allCols.indexOf(col);

        if (draggedIndex < targetIndex) {
          row.insertBefore(draggedCol, col.nextSibling);
        } else {
          row.insertBefore(draggedCol, col);
        }
      }
    });

    col.addEventListener('dragend', function () {
      col.style.border = '';
    });
  });
});
</script>


@endsection