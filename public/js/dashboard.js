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