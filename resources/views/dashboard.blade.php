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

<style>
  .dashboard-group {
    margin-bottom: 1.5rem;
  }
  
  .panel, .grafico {
    background-color: var(--color-bege-claro);
    color: var(--color-gray-escuro);
    border-radius: 15px;
    cursor: grab;
    padding: 1rem;
    height: 250px;
    box-shadow: 0 2px 10px var(--color-vinho-fundo);
    transition: box-shadow 0.2s ease, outline 0.2s ease;
    min-height: 100%;
    min-width: 100%;
  }

  .panel h5, .grafico h5 {
    font-weight: bold;
    color: var(--color-vinho);
  }

  .col-md-4 {
    transition: outline 0.2s ease;
    min-width: 300px;
    min-height: 1px;
  }
  .col-md-4.drag-over {
    outline: 3px dashed var(--color-vinho) !important;
    border-radius: 15px;
    box-shadow: none !important;
    background: none !important;
  }

  .panel:hover {
    background-color: var(--color-vinho);
    color: var(--color-bege-claro);

    h5{
      color: var(--color-bege-claro);
    }
  }

  .grafico:hover{
    background-color: var(--color-vinho);
    color: var(--color-bege-claro);

    h5{
      color: var(--color-bege-claro);
    }

    .grafico-btn{
      color: var(--color-bege-claro) !important;
    }

    .grafico-btn.active{
      color: var(--color-vinho) !important;
      background: var(--color-bege-claro) !important;
    }
  }

  .panel:active {
    box-shadow: 0 2px 10px var(--color-vinho-fundo);
    outline: none;
  }

  .grafico-toolbar {
    position: absolute;
    top: 20px;
    right: 40px;
    display: flex;
    gap: 0.5rem;
    z-index: 2;
  }

  .grafico-btn {
    background: transparent !important;
    color: var(--color-vinho) !important;
    border: none !important;
    font-weight: 600;
    padding: 0.3em 1.2em;
    border-radius: 999px;
    transition: background 0.2s, color 0.2s, border 0.2s;
    cursor: pointer;
    outline: none;
    font-size: 1rem;
  }

  .grafico-toolbar .grafico-btn.active {
    background: var(--color-vinho) !important;
    color: var(--color-bege-claro) !important;
  }

  .grafico-toolbar .grafico-btn {
    color: var(--color-vinho) !important;
    background: transparent !important;
  }

</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
  let draggedGroup = null;
  const dashboardRow = document.getElementById('dashboard-row');
  const chartRow = document.getElementById('dashboard-chart-row');
  const dashboardGroups = document.querySelectorAll('.dashboard-group');

  dashboardGroups.forEach(group => {
    group.addEventListener('dragstart', function (e) {
      draggedGroup = group;
      e.dataTransfer.effectAllowed = 'move';
    });
    group.addEventListener('dragover', function (e) {
      e.preventDefault();
      group.classList.add('drag-over');
    });
    group.addEventListener('dragleave', function () {
      group.classList.remove('drag-over');
    });
    group.addEventListener('drop', function (e) {
      e.preventDefault();
      group.classList.remove('drag-over');
      if (draggedGroup && draggedGroup !== group) {
        if (group.nextSibling === draggedGroup) {
          group.parentNode.insertBefore(draggedGroup, group);
        } else {
          group.parentNode.insertBefore(draggedGroup, group.nextSibling);
        }
      }
    });
    group.addEventListener('dragend', function () {
      group.classList.remove('drag-over');
    });
  });


  let draggedCard = null;
  const cards = document.querySelectorAll('#dashboard-row .col-md-4');
  cards.forEach(card => {
    card.setAttribute('draggable', 'true');
    card.addEventListener('dragstart', function (e) {
      draggedCard = card;
      e.dataTransfer.effectAllowed = 'move';
    });
    card.addEventListener('dragover', function (e) {
      e.preventDefault();
      card.classList.add('drag-over');
    });
    card.addEventListener('dragleave', function () {
      card.classList.remove('drag-over');
    });
    card.addEventListener('drop', function (e) {
      e.preventDefault();
      card.classList.remove('drag-over');
      if (draggedCard && draggedCard !== card) {
        const parent = card.parentNode;
        const cardsArr = Array.from(parent.children).filter(c => c.classList.contains('col-md-4'));
        const draggedIndex = cardsArr.indexOf(draggedCard);
        const targetIndex = cardsArr.indexOf(card);
        if (draggedIndex < targetIndex) {
          parent.insertBefore(draggedCard, card.nextSibling);
        } else {
          parent.insertBefore(draggedCard, card);
        }
      }
    });
    card.addEventListener('dragend', function () {
      card.classList.remove('drag-over');
    });
  });

  document.querySelectorAll('.grafico-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.grafico-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
    });
  });

  //variáveis CSS
  const rootStyles = getComputedStyle(document.documentElement);
  const vinho = rootStyles.getPropertyValue('--color-vinho').trim();
  const vinhoFundo = rootStyles.getPropertyValue('--color-vinho-fundo').trim();
  const begeClaro = rootStyles.getPropertyValue('--color-bege-claro').trim();
  const branco = rootStyles.getPropertyValue('--color-white').trim();;


  const ctxTempo = document.getElementById('vendasTempoChart').getContext('2d');
  const vendasTempoChart = new Chart(ctxTempo, {
    type: 'line',
    data: {
      labels: ['08h', '09h', '10h', '11h', '12h', '13h', '14h', '15h', '16h', '17h'],
      datasets: [{
        label: 'Vendas',
        data: [2, 5, 8, 6, 10, 7, 12, 9, 4, 6],
        borderColor: 'rgba(119,49,56,1)',
        backgroundColor: 'rgba(119,49,56,0.1)',
        tension: 0.4,
        fill: true,
        pointBackgroundColor: 'rgba(119,49,56,1)',
        pointBorderColor: 'rgba(119,49,56,0.1)',
        pointRadius: 5,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: { display: false },
      },
      scales: {
        y: {
          beginAtZero: true,
          ticks: { color: 'rgba(119,49,56,1)' },
          grid: { color: 'rgba(119,49,56,0.1)' }
        },
        x: {
          ticks: { color: 'rgba(119,49,56,1)' },
          grid: { color: 'rgba(119,49,56,0.1)' }
        }
      }
    }
  });

  
  const graficoPanel = document.querySelector('.grafico');
  graficoPanel.addEventListener('mouseenter', () => {
    vendasTempoChart.data.datasets[0].borderColor = begeClaro;
    vendasTempoChart.data.datasets[0].backgroundColor = begeClaro + '22';
    vendasTempoChart.data.datasets[0].pointBackgroundColor = begeClaro;
    vendasTempoChart.options.scales.x.ticks.color = branco;
    vendasTempoChart.options.scales.y.ticks.color = branco;
    vendasTempoChart.options.scales.x.grid.color = begeClaro + '22';
    vendasTempoChart.options.scales.y.grid.color = begeClaro + '22';

    vendasTempoChart.update();
  });
  graficoPanel.addEventListener('mouseleave', () => {
    vendasTempoChart.data.datasets[0].borderColor = vinho;
    vendasTempoChart.data.datasets[0].backgroundColor = vinho + '22';
    vendasTempoChart.data.datasets[0].pointBackgroundColor = vinho;
    vendasTempoChart.data.datasets[0].pointBorderColor = begeClaro;
    vendasTempoChart.options.scales.x.ticks.color = vinho;
    vendasTempoChart.options.scales.y.ticks.color = vinho;
    vendasTempoChart.options.scales.x.grid.color = vinho + '22';
    vendasTempoChart.options.scales.y.grid.color = vinho + '22';

    vendasTempoChart.update();
  });
});
</script>

@endsection