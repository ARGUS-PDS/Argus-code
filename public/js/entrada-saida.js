  const movimentacoes = [];
  const form = document.getElementById('formLancamento');
  let modal;
  document.addEventListener('DOMContentLoaded', () => {
    modal = new bootstrap.Modal(document.getElementById('modalLancamento'));
    const hoje = new Date().toISOString().split('T')[0];
    document.getElementById('data').value = hoje;
  });

  function atualizarDataTipo() {
    const tipo = document.getElementById('tipo').value;
    const dataInput = document.getElementById('data');
    const hoje = new Date().toISOString().split('T')[0];

    if (tipo === 'balanco') {
      dataInput.value = hoje;
      dataInput.readOnly = true;
    } else {
      dataInput.readOnly = false;
    }
  }

  function abrirModalNovo() {
    form.reset();
    document.getElementById('editIndex').value = '';
    document.getElementById('tituloModal').innerText = 'Lançamento';
    document.getElementById('data').value = new Date().toISOString().split('T')[0];
    modal.show();
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    const index = document.getElementById('editIndex').value;
    let custoInput = document.getElementById('custo').value.replace('R$', '').replace(',', '.');
    let custo = parseFloat(custoInput);
    if (isNaN(custo)) custo = 0;
    const nova = {
      data: document.getElementById('data').value,
      quantidade: parseInt(document.getElementById('quantidade').value),
      custo: custo,
      tipo: document.getElementById('tipo').value,
      observacao: document.getElementById('observacao').value || '-'
    };

    if (index !== '') {
      movimentacoes[index] = nova;
    } else {
      movimentacoes.push(nova);
    }

    atualizarTabela();
    modal.hide();
  });

  function atualizarTabela() {
    const tbody = document.querySelector('#tabelaMovimentacoes tbody');
    tbody.innerHTML = '';

    let entradaQtd = 0, entradaValor = 0;
    let saidaQtd = 0, saidaValor = 0;
    let estoqueAtual = 0, estoqueValor = 0;

    movimentacoes.forEach((mov, index) => {
      let cor = '';
      if (mov.tipo === 'entrada') cor = 'rgba(13, 202, 240, 0.15)';
      else if (mov.tipo === 'saida') cor = 'rgba(220, 53, 69, 0.15)';
      else if (mov.tipo === 'balanco') cor = 'rgba(255, 193, 7, 0.15)';

      const row = document.createElement('tr');
      row.style.backgroundColor = cor;
      row.style.cursor = 'pointer';
      row.onclick = () => editarMovimentacao(index);

      row.innerHTML = `
        <td>${formatarData(mov.data)}</td>
        <td>${mov.quantidade}</td>
        <td>R$${mov.custo.toFixed(2).replace('.', ',')}</td>
        <td>${capitalize(mov.tipo)}</td>
        <td>${mov.observacao}</td>
        <td><button class="btn btn-outline-danger btn-sm" onclick="event.stopPropagation(); excluir(${index})"><i class="bi bi-trash"></i></button></td>
      `;

      tbody.appendChild(row);

      if (mov.tipo === 'entrada') {
        entradaQtd += mov.quantidade;
        entradaValor += mov.quantidade * mov.custo;
        estoqueAtual += mov.quantidade;
        estoqueValor += mov.quantidade * mov.custo;
      } else if (mov.tipo === 'saida') {
        saidaQtd += mov.quantidade;
        saidaValor += mov.quantidade * mov.custo;
        estoqueAtual -= mov.quantidade;
        estoqueValor -= mov.quantidade * mov.custo;
      } else if (mov.tipo === 'balanco') {
        estoqueAtual = mov.quantidade;
        estoqueValor = mov.quantidade * mov.custo;
      }
    });

    document.querySelector('.painel-resumo').innerHTML = `
      <p class="mb-2"><strong>Entradas:</strong> ${entradaQtd} <span class="text-muted">(R$${entradaValor.toFixed(2).replace('.', ',')})</span></p>
      <p class="mb-2"><strong>Estoque atual:</strong> ${estoqueAtual} <span class="text-muted">(R$${estoqueValor.toFixed(2).replace('.', ',')})</span></p>
      <p class="mb-0"><strong>Saída:</strong> ${saidaQtd} <span class="text-muted">(R$${saidaValor.toFixed(2).replace('.', ',')})</span></p>
    `;
  }

  function editarMovimentacao(index) {
    const mov = movimentacoes[index];
    document.getElementById('editIndex').value = index;
    document.getElementById('tipo').value = mov.tipo;
    document.getElementById('data').value = mov.data;
    document.getElementById('quantidade').value = mov.quantidade;
    document.getElementById('custo').value = mov.custo;
    document.getElementById('observacao').value = mov.observacao === '-' ? '' : mov.observacao;
    atualizarDataTipo();
    document.getElementById('tituloModal').innerText = 'Editar movimentação';
    modal.show();
  }

  function excluir(index) {
    movimentacoes.splice(index, 1);
    atualizarTabela();
  }

  function formatarData(data) {
    const [ano, mes, dia] = data.split('-');
    return `${dia}/${mes}/${ano}`;
  }

  function capitalize(texto) {
    return texto.charAt(0).toUpperCase() + texto.slice(1);
  }