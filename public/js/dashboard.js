document.addEventListener('DOMContentLoaded', function () {
    Chart.register(ChartDataLabels);

    let draggedGroup = null;
    const dashboardRow = document.getElementById('dashboard-row');
    const chartRow = document.getElementById('dashboard-chart-row');
    const dashboardGroups = document.querySelectorAll('.dashboard-group');

    // ... Funções de salvar/restaurar ordem (saveGroupOrder, restoreGroupOrder, saveCardsOrder, restoreCardsOrder) ...
    // Essas funções não têm strings em hardcode que precisem de tradução.
    
    function saveGroupOrder() {
        const container = document.body;
        const groups = Array.from(document.querySelectorAll('.dashboard-group'));
        const order = groups.map(g => g.id);
        localStorage.setItem('dashboard:group-order', JSON.stringify(order));
    }

    function restoreGroupOrder() {
        const containerParent = document.querySelector('#dashboard-row').parentNode; // parent of first group
        const saved = localStorage.getItem('dashboard:group-order');
        if (!saved) return;
        try {
            const order = JSON.parse(saved);
            order.forEach(groupId => {
                const el = document.getElementById(groupId);
                if (el && el.parentNode === containerParent) {
                    containerParent.appendChild(el);
                }
            });
        } catch (e) {}
    }

    function saveCardsOrder() {
        const row = document.getElementById('dashboard-row');
        if (!row) return;
        const cards = Array.from(row.querySelectorAll('.col-md-4'));
        const order = cards.map(c => c.id || c.dataset.cardId).filter(Boolean);
        localStorage.setItem('dashboard:cards-order', JSON.stringify(order));
    }

    function restoreCardsOrder() {
        const row = document.getElementById('dashboard-row');
        const saved = localStorage.getItem('dashboard:cards-order');
        if (!row || !saved) return;
        try {
            const order = JSON.parse(saved);
            order.forEach(cardId => {
                const el = document.getElementById(cardId);
                if (el && el.parentNode === row) {
                    row.appendChild(el);
                }
            });
        } catch (e) {}
    }

    restoreGroupOrder();
    restoreCardsOrder();

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
                saveGroupOrder();
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
                saveCardsOrder();
            }
        });
        card.addEventListener('dragend', function () {
            card.classList.remove('drag-over');
        });
    });


    //variáveis CSS
    // Função para obter as cores baseadas no modo atual
    function getChartColors() {
        const rootStyles = getComputedStyle(document.documentElement);
        const isDarkMode = document.body.classList.contains('dark-mode');

        let vinho, vinhoFundo, begeClaro, begeClaroFundo, branco;

        if (isDarkMode) {
            vinho = rootStyles.getPropertyValue('--color-bege-claro').trim();
            vinhoFundo = rootStyles.getPropertyValue('--color-bege-claro-fundo').trim();
            begeClaro = rootStyles.getPropertyValue('--color-vinho').trim();
            begeClaroFundo = rootStyles.getPropertyValue('--color-vinho-fundo').trim();
            branco = rootStyles.getPropertyValue('--color-black').trim();
        } else {
            vinho = rootStyles.getPropertyValue('--color-vinho').trim();
            vinhoFundo = rootStyles.getPropertyValue('--color-vinho-fundo').trim();
            begeClaro = rootStyles.getPropertyValue('--color-bege-claro').trim();
            begeClaroFundo = rootStyles.getPropertyValue('--color-bege-claro-fundo').trim();
            branco = rootStyles.getPropertyValue('--color-white').trim();
        }

        return { vinho, vinhoFundo, begeClaro, begeClaroFundo, branco };
    }

    // Obtém as cores iniciais
    const colors = getChartColors();
    let { vinho, vinhoFundo, begeClaro, begeClaroFundo, branco } = colors;


    // cria o gráfico vazio logo no início
    const ctxTempo = document.getElementById('vendasTempoChart').getContext('2d');
    const vendasTempoChart = new Chart(ctxTempo, {
        type: 'line',
        data: {
            labels: [],
            datasets: [{
                // TRADUÇÃO: 'Vendas (R$)'
                label: i18n.sales.salesLabel,
                data: [],
                borderColor: vinho,
                backgroundColor: vinhoFundo,
                tension: 0.4,
                fill: true,
                pointBackgroundColor: vinho,
                pointBorderColor: begeClaro,
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
                    top: 50,
                    right: 70,
                    bottom: 5,
                    left: 50
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
                            // TRADUÇÃO: 'R$ '
                            return i18n.sales.currencyLabel + context.parsed.y.toLocaleString('pt-BR', {
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
                        // TRADUÇÃO: 'R$ '
                        return i18n.sales.currencyLabel + value.toLocaleString('pt-BR', {
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

        const btnAtivo = document.querySelector(`[data-periodo="${periodo}"]`);
        if (btnAtivo) {
            // TRADUÇÃO: 'Carregando...'
            btnAtivo.innerHTML = i18n.sales.loading + '...';
            btnAtivo.disabled = true;
        }

        fetch(`/dashboard/vendas?periodo=${periodo}`)
            .then(res => res.json())
            .then(dados => {
                if (dados.length === 0) {
                    // TRADUÇÃO: 'Nenhuma venda'
                    vendasTempoChart.data.labels = [i18n.sales.noSales];
                    vendasTempoChart.data.datasets[0].data = [0];
                    vendasTempoChart.update();
                    return;
                }

                const labels = dados.map(d => d.label);
                const valores = dados.map(d => d.total);

                vendasTempoChart.data.labels = labels;
                vendasTempoChart.data.datasets[0].data = valores;

                vendasTempoChart.options.scales.y.ticks.callback = function(value) {
                    // TRADUÇÃO: 'R$ '
                    return i18n.sales.currencyLabel + value.toLocaleString('pt-BR');
                };

                vendasTempoChart.update('active');
            })
            .catch(error => {
                console.error('Erro ao carregar dados:', error);
                // TRADUÇÃO: 'Erro ao carregar'
                vendasTempoChart.data.labels = [i18n.sales.loadingError];
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
        // TRADUÇÃO: Obtém labels do objeto i18n
        return i18n.sales.periodLabels[periodo] || periodo;
    }
    carregarDados('mes');

    // Função para atualizar as cores do gráfico
    function updateChartColors() {
        const newColors = getChartColors();

        // Atualiza as variáveis globais
        vinho = newColors.vinho;
        vinhoFundo = newColors.vinhoFundo;
        begeClaro = newColors.begeClaro;
        begeClaroFundo = newColors.begeClaroFundo;
        branco = newColors.branco;

        // Atualiza as cores do gráfico
        if (vendasTempoChart) {
            vendasTempoChart.data.datasets[0].borderColor = vinho;
            vendasTempoChart.data.datasets[0].backgroundColor = vinhoFundo;
            vendasTempoChart.data.datasets[0].pointBackgroundColor = vinho;
            vendasTempoChart.data.datasets[0].pointBorderColor = begeClaro;
            vendasTempoChart.options.plugins.tooltip.backgroundColor = begeClaro;
            vendasTempoChart.options.plugins.tooltip.titleColor = vinho;
            vendasTempoChart.options.plugins.tooltip.bodyColor = vinho;
            vendasTempoChart.options.plugins.tooltip.borderColor = begeClaroFundo;
            vendasTempoChart.options.scales.x.ticks.color = vinho;
            vendasTempoChart.options.scales.y.ticks.color = vinho;
            vendasTempoChart.options.scales.x.grid.color = begeClaroFundo;
            vendasTempoChart.options.scales.y.grid.color = begeClaroFundo;
            vendasTempoChart.update();
        }
    }

    // Listener para mudanças no dark mode
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(function(mutation) {
            if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                updateChartColors();
            }
        });
    });

    // Observa mudanças na classe do body
    observer.observe(document.body, {
        attributes: true,
        attributeFilter: ['class']
    });

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