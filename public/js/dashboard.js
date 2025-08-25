document.addEventListener('DOMContentLoaded', function () {
  Chart.register(ChartDataLabels);
  
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
  const begeClaroFundo = rootStyles.getPropertyValue('--color-bege-claro-fundo').trim();
  const branco = rootStyles.getPropertyValue('--color-white').trim();;

  // cria o gráfico vazio logo no início
  const ctxTempo = document.getElementById('vendasTempoChart').getContext('2d');
  const vendasTempoChart = new Chart(ctxTempo, {
    type: 'line',
    data: {
      labels: [],
      datasets: [{
        label: 'Vendas (R$)',
        data: [],
        borderColor: vinho,
        backgroundColor: vinhoFundo,
        tension: 0.4,
        fill: true,
        pointBackgroundColor: vinho,
        pointBorderColor: branco,
        pointRadius: 8,
        pointHoverRadius: 10,
        pointBorderWidth: 3,
        borderWidth: 4,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,

      layout: {
        padding: {
          top: 30,
          right: 30,
          bottom: 10,
          left: 10
        }
      },

      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: begeClaro,
          titleColor: vinho,
          bodyColor: vinho,
          borderColor: begeClaroFundo,
          borderWidth: 1,
          cornerRadius: 8,
          displayColors: false,
          callbacks: {
            title: function(context) {
              return context[0].label;
            },
            label: function(context) {
              return 'R$ ' + context.parsed.y.toLocaleString('pt-BR', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
              });
            }
          }
        },
        // Plugin personalizado para mostrar valores sempre visíveis
        customCanvasBackgroundColor: {
          beforeDraw: (chart) => {
            const ctx = chart.ctx;
            ctx.save();
            ctx.globalCompositeOperation = 'destination-over';
            ctx.fillStyle = 'transparent';
            ctx.fillRect(0, 0, chart.width, chart.height);
            ctx.restore();
          }
        },
        // Plugin para mostrar valores nos pontos
        datalabels: {
          color: vinho,
          anchor: 'end',
          align: 'top',
          offset: 8,
          font: {
            weight: 'bold',
            size: 11
          },
          formatter: function(value) {
            return 'R$ ' + value.toLocaleString('pt-BR', {
              minimumFractionDigits: 2,
              maximumFractionDigits: 2
            });
          }
        }
      },
      scales: {
        x: { 
          grid: { 
            display: false
          },
          ticks: { 
            color: vinho,
            font: {
              size: 12,
              weight: '600'
            }
          },
          border: {
            display: false
          }
        },
        
        y: {
          display: false,
          beginAtZero: true
        }      
      },
      interaction: {
        intersect: false,
        mode: 'index'
      },
      elements: {
        point: {
          hoverBackgroundColor: vinhoFundo,
          hoverBorderColor: vinho
        }
      }
    }
  });

  const canvas = document.getElementById('vendasTempoChart');

  canvas.addEventListener('mouseenter', () => {
    vendasTempoChart.options.scales.x.ticks.color = begeClaro;
    vendasTempoChart.options.scales.y.ticks.color = begeClaro;

    vendasTempoChart.options.elements.point.hoverBackgroundColor = begeClaroFundo;
    vendasTempoChart.options.elements.point.hoverBorderColor = begeClaro;
    
    vendasTempoChart.options.plugins.datalabels.color = begeClaro;

    vendasTempoChart.data.datasets[0].borderColor = begeClaro; 
    vendasTempoChart.data.datasets[0].backgroundColor = begeClaroFundo; 
    vendasTempoChart.update();
  });


  canvas.addEventListener('mouseleave', () => {
    vendasTempoChart.options.scales.x.ticks.color = vinho;
    vendasTempoChart.options.scales.y.ticks.color = vinho;

    vendasTempoChart.options.elements.point.hoverBackgroundColor = vinhoFundo;
    vendasTempoChart.options.elements.point.hoverBorderColor = vinho;

    vendasTempoChart.options.plugins.datalabels.color = vinho;

    vendasTempoChart.data.datasets[0].borderColor = vinho;
    vendasTempoChart.data.datasets[0].backgroundColor = vinhoFundo;
    vendasTempoChart.update();
  });


  function carregarDados(periodo) {
    // Mostra loading
    const canvas = document.getElementById('vendasTempoChart');
    canvas.style.opacity = '0.5';
    
    // Atualiza texto do botão ativo
    const btnAtivo = document.querySelector(`[data-periodo="${periodo}"]`);
    if (btnAtivo) {
      btnAtivo.innerHTML = '<i class="bi bi-arrow-clockwise spin"></i> Carregando...';
      btnAtivo.disabled = true;
    }

    fetch(`/dashboard/vendas?periodo=${periodo}`)
      .then(res => res.json())
      .then(dados => {
        if (dados.length === 0) {
          vendasTempoChart.data.labels = ['Nenhuma venda'];
          vendasTempoChart.data.datasets[0].data = [0];
          vendasTempoChart.update();
          return;
        }

        const labels = dados.map(d => d.label);
        const valores = dados.map(d => d.total);
  
        vendasTempoChart.data.labels = labels;
        vendasTempoChart.data.datasets[0].data = valores;
        
        vendasTempoChart.options.scales.y.ticks.callback = function(value) {
          return 'R$ ' + value.toLocaleString('pt-BR');
        };
        
        vendasTempoChart.update('active');
      })
      .catch(error => {
        console.error('Erro ao carregar dados:', error);
        vendasTempoChart.data.labels = ['Erro ao carregar'];
        vendasTempoChart.data.datasets[0].data = [0];
        vendasTempoChart.update();
      })
      .finally(() => {
        // Restaura estado normal
        canvas.style.opacity = '1';
        if (btnAtivo) {
          btnAtivo.innerHTML = getPeriodoLabel(periodo);
          btnAtivo.disabled = false;
        }
      });
  }

  // Função para obter o label correto do período
  function getPeriodoLabel(periodo) {
    const labels = {
      'dia': 'Dia',
      //'semana': 'Semana', 
      'mes': 'Mês',
      'ano': 'Ano'
    };
    return labels[periodo] || periodo;
  }
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