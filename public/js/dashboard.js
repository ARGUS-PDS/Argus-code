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
  

  //variáveis CSS
  const rootStyles = getComputedStyle(document.documentElement);
  const vinho = rootStyles.getPropertyValue('--color-vinho').trim();
  const vinhoFundo = rootStyles.getPropertyValue('--color-vinho-fundo').trim();
  const begeClaro = rootStyles.getPropertyValue('--color-bege-claro').trim();
  const branco = rootStyles.getPropertyValue('--color-white').trim();;

  // cria o gráfico vazio logo no início
  const ctxTempo = document.getElementById('vendasTempoChart').getContext('2d');
  const vendasTempoChart = new Chart(ctxTempo, {
    type: 'line',
    data: {
      labels: [], // começa vazio
      datasets: [{
        label: 'Vendas',
        data: [],
        borderColor: vinho,
        backgroundColor: vinhoFundo,
        tension: 0.4,
        fill: true,
        pointBackgroundColor: vinho,
        pointBorderColor: vinhoFundo,
        pointRadius: 5,
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: { display: false }
      },
      scales: {
        x: { 
          grid: { display: false },
          ticks: { stepSize: 1, color: vinho }  
        },
        
        y: {
          beginAtZero: true,
          ticks: { stepSize: 1, color: vinho },
          suggestedMax: 5,
          grid: { display: false }
        }      
      }
    }
  });

  const canvas = document.getElementById('vendasTempoChart');

canvas.addEventListener('mouseenter', () => {
  vendasTempoChart.options.scales.x.ticks.color = begeClaro;
  vendasTempoChart.options.scales.y.ticks.color = begeClaro;
  vendasTempoChart.update();
});

canvas.addEventListener('mouseleave', () => {
  vendasTempoChart.options.scales.x.ticks.color = vinho;
  vendasTempoChart.options.scales.y.ticks.color = vinho;
  vendasTempoChart.update();
});


  function carregarDados(periodo) {
    fetch(`/dashboard/vendas?periodo=${periodo}`)
      .then(res => res.json())
      .then(dados => {
        const labels = dados.map(d => d.label);
        const valores = dados.map(d => d.total);
  
        vendasTempoChart.data.labels = labels;
        vendasTempoChart.data.datasets[0].data = valores;
        vendasTempoChart.update();
      });
  }
  
  // quando a página carrega, já busca "mes" como padrão
  carregarDados('mes');
  
  // clique nos botões
  document.querySelectorAll('.grafico-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.grafico-btn').forEach(b => b.classList.remove('active'));
      btn.classList.add('active');
      const periodo = btn.dataset.periodo;
      carregarDados(periodo);
    });
  });  
});