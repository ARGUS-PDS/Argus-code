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

<!-- Gráfico de vendas por tempo -->
<div class="row justify-content-center g-2 mt-3">
  <div class="col-12" style="position: relative;">
    <div class="grafico p-4 mb-0" style="height: 250px; display: flex; flex-direction: column; justify-content: flex-start; position: relative;">
      <div class="grafico-toolbar">
        <button class="grafico-btn active" data-periodo="mes">Mês</button>
        <button class="grafico-btn" data-periodo="semana">Semana</button>
        <button class="grafico-btn" data-periodo="dia">Dia</button>
      </div>
      <h5>Vendas por Tempo</h5>
      <div style="flex:1; min-height: 0;">
        <canvas id="vendasTempoChart" style="width:100%; height:180px;"></canvas>
      </div>
    </div>
  </div>
</div>

<style>
  .panel, .grafico {
    background-color: var(--color-bege-claro);
    color: var(--color-gray-escuro);
    border-radius: 15px;
    padding: 1rem;
    height: 250px;
    box-shadow: 0 2px 10px var(--color-vinho-fundo);
    transition: box-shadow 0.2s ease, outline 0.2s ease;
    min-height: 100%;
    min-width: 100%;

  }

  .panel{
    cursor: grab;
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

  .grafico-toolbar .grafico-btn {
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
      col.classList.add('drag-over');
    });

    col.addEventListener('dragleave', function () {
      col.classList.remove('drag-over');
    });

    col.addEventListener('drop', function (e) {
      e.preventDefault();
      col.classList.remove('drag-over');
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
      col.classList.remove('drag-over');
    });
  });

  document.querySelectorAll('.grafico-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.grafico-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      // Aqui você pode atualizar os dados do gráfico conforme o período selecionado
      // Exemplo: atualizarGrafico(btn.dataset.periodo);
    });
  });

  // Pega as variáveis CSS
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
        borderColor: vinho,
        backgroundColor: vinho + '22',
        tension: 0.4,
        fill: true,
        pointBackgroundColor: vinho,
        pointBorderColor: begeClaro,
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
          ticks: { color: vinho },
          grid: { color: vinho + '22' }
        },
        x: {
          ticks: { color: vinho },
          grid: { color: vinho + '22' }
        }
      }
    }
  });

  // Hover dinâmico no painel do gráfico
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