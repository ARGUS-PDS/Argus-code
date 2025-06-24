<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Movimentação de estoque</title>

  <!-- Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

  @include('layouts.css-variables')
  
</head>
<body>

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="mb-0">Movimentação de estoque</h2>
    <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modalLancamento" onclick="abrirModalNovo()">+ Novo lançamento</button>
  </div>

  <div class="mb-4" style="max-width: 350px;">
    <div class="input-group shadow-sm">
      <input type="text" class="form-control rounded-start" placeholder="Pesquisa..." aria-label="Pesquisar produto">
      <button class="btn btn-secondary rounded-end" type="button">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </div>

  <h5 class="mb-3 text-primary">Produto x</h5>

  <div class="row">
    <div class="col-lg-9 mb-4">
      <table class="table text-center align-middle shadow-sm" id="tabelaMovimentacoes">
        <thead class="table-light">
          <tr>
            <th>Data</th>
            <th>Movimentação</th>
            <th>Valor</th>
            <th>Tipo</th>
            <th>Observação</th>
            <th></th>
          </tr>
        </thead>
        <tbody></tbody>
      </table>
    </div>

    <div class="col-lg-3">
      <div class="border p-3 rounded shadow-sm text-center" id="painelResumo">
        <p class="mb-2"><strong>Entradas:</strong> 0 <span class="text-muted">(R$0,00)</span></p>
        <p class="mb-2"><strong>Estoque atual:</strong> 0 <span class="text-muted">(R$0,00)</span></p>
        <p class="mb-0"><strong>Saída:</strong> 0 <span class="text-muted">(R$0,00)</span></p>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalLancamento" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 px-3 pb-3 pt-2">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold" id="tituloModal">Lançamento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <form id="formLancamento">
          <input type="hidden" id="editIndex">

          <div class="row mb-3">
            <div class="col">
              <label for="tipo" class="form-label">Tipo*</label>
              <select class="form-select" id="tipo" required onchange="atualizarDataTipo()">
                <option selected disabled>Selecione...</option>
                <option value="entrada">Entrada</option>
                <option value="saida">Saída</option>
                <option value="balanco">Balanço</option>
              </select>
            </div>
            <div class="col">
              <label for="data" class="form-label">Data*</label>
              <input type="date" class="form-control" id="data" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label for="quantidade" class="form-label">Quantidade*</label>
              <input type="number" class="form-control" id="quantidade" required>
            </div>
            <div class="col">
              <label for="custo" class="form-label">Custo*</label>
              <input type="text" class="form-control" id="custo" required>
            </div>
          </div>

          <div class="mb-4">
            <label for="observacao" class="form-label">Observação</label>
            <input type="text" class="form-control" id="observacao">
          </div>

          <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-outline-primary me-2" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary px-4">Salvar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
  const movimentacoes = [];
  const form = document.getElementById('formLancamento');
  const modal = new bootstrap.Modal(document.getElementById('modalLancamento'));

  document.addEventListener('DOMContentLoaded', () => {
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
    const nova = {
      data: document.getElementById('data').value,
      quantidade: parseInt(document.getElementById('quantidade').value),
      custo: parseFloat(document.getElementById('custo').value.replace('R$', '').replace(',', '.')),
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

    document.getElementById('painelResumo').innerHTML = `
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
</script>

</body>
</html>