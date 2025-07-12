@extends('layouts.app')

@include('layouts.css-variables')

@section('content')

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


@endsection