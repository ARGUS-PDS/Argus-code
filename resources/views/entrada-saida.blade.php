@extends('layouts.app')

@include('layouts.css-variables')

@section('content')

<style>
  .entrada-saida-titulo {
    color: var(--color-vinho);
    font-weight: bold;
    font-size: 2.2rem;
    margin-bottom: 0.5rem;
  }

  .entrada-saida-pesquisa .input-group {
    box-shadow: 0 2px 10px var(--color-vinho-fundo);
    border-radius: 12px;
  }

  .entrada-saida-pesquisa input {
    border-radius: 12px 0 0 12px !important;
    border: 1.5px solid var(--color-vinho-fundo);
    font-size: 1.1rem;
  }

  .entrada-saida-pesquisa button {
    border-radius: 0 12px 12px 0 !important;
    background: var(--color-vinho);
    color: var(--color-bege-claro);
    border: none;
  }

  .entrada-saida-pesquisa button:hover {
    background: var(--color-vinho-fundo);
  }

  .painel-resumo {
    background: var(--color-vinho);
    color: var(--color-bege-claro);
    border: none;
    min-height: unset;
    padding: 1.2rem 1rem;
    border-radius: 15px;
  }

  .painel-resumo strong {
    color: var(--color-bege-claro);
  }

  .painel-resumo .text-muted {
    color: var(--color-bege-claro) !important;
    opacity: 0.7;
  }

  .table {
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 1px 1px 2px var(--color-vinho-fundo);
  }

  .table thead {
    background: var(--color-bege-claro);
    color: var(--color-vinho);
    font-weight: bold;
  }

  .table tbody tr {
    background: var(--color-bege-claro);
    color: var(--color-vinho);
    transition: background 0.2s;
  }

  .table tbody tr:hover {
    background: var(--color-vinho-fundo);
    color: var(--color-bege-claro);
  }

  .btn-primary {
    background: var(--color-vinho-fundo);
    color: var(--color-bege-claro);
    border: 2px solid var(--color-vinho);
    border-radius: 12px;
    font-weight: 600;
    transition: background 0.2s, color 0.2s;
  }

  .btn-primary:hover {
    background: var(--color-bege-claro);
    color: var(--color-vinho);
    border: 2px solid var(--color-vinho);
  }

  .btn-outline-danger {
    border-radius: 8px;
  }


  /* modal */
  .modal-content {
    background: var(--color-bege-claro);
    border-radius: 18px;
    border: none;
    box-shadow: 0 2px 16px var(--color-vinho-fundo);
    margin: 100px 0;
  }

  .modal-header {
    border-bottom: none;
    background: var(--color-bege-claro);
  }

  .modal-title {
    color: var(--color-vinho);
    font-weight: bold;
  }

  .btn-close {
    filter: invert(40%) sepia(20%) saturate(400%) hue-rotate(320deg);
  }

  .modal-body label,
  .modal-body .form-label {
    color: var(--color-vinho);
    font-weight: 500;
  }

  .modal-body .form-control,
  .modal-body .form-select {
    border-radius: 10px;
    border: 1.5px solid var(--color-vinho-fundo);
    font-size: 1.05rem;
  }

  .modal-footer,
  .modal-body .d-flex {
    border-top: none;
  }

  .btn-outline-primary {
    border-radius: 10px;
    color: var(--color-vinho);
    border: 1.5px solid var(--color-vinho);
    background: transparent;
    font-weight: 600;
  }

  .btn-outline-primary:hover {
    background: var(--color-vinho);
    color: var(--color-bege-claro);
  }
</style>
<link rel="stylesheet" href="{{ asset('css/entrada-saida.css') }}">


<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="entrada-saida-titulo">Movimentação de estoque</h2>
    <button class="btn btn-primary px-4" data-bs-toggle="modal" data-bs-target="#modalLancamento" onclick="abrirModalNovo()">+ Novo lançamento</button>
  </div>

  <div class="mb-4 entrada-saida-pesquisa" style="max-width: 350px;">
    <div class="input-group shadow-sm">
      <input type="text" class="form-control rounded-start" placeholder="Pesquisa..." aria-label="Pesquisar produto">
      <button class="btn btn-secondary rounded-end" type="button">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </div>

  <h5 class="mb-3" style="color: var(--color-vinho); font-weight: bold;">Produto x</h5>

  <div class="row">
    <div class="col-lg-9 mb-4">
      <table class="table text-center align-middle" id="tabelaMovimentacoes">
        <thead>
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
      <div class="painel-resumo text-center">
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
          @csrf
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
              <label for="custo" class="form-label">Custo</label>
              <input type="text" class="form-control" id="custo">
            </div>
          </div>

          <div class="mb-4">
            <label for="observacao" class="form-label">Observação</label>
            <input type="text" class="form-control" id="observacao">
          </div>

          <div class="mb-4">
            <select name="productId" class="w-full border border-gray-300 rounded-md p-2" required>
              <option value="">Selecione um produto</option>
              @foreach ($products as $product)
              <option value="{{ $product->id }}">{{ $product->description }}</option>
              @endforeach
            </select>
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
<script src="{{ asset('js/entrada-saida.js') }}"></script>

<script>
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

    let entradaQtd = 0,
      entradaValor = 0;
    let saidaQtd = 0,
      saidaValor = 0;
    let estoqueAtual = 0,
      estoqueValor = 0;

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
</script>
<script src="{{ asset('js/entrada-saida.js') }}"></script>


@endsection