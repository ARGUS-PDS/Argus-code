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
        <form method="POST" action="{{ route('movimentacao.store') }}" id="formLancamento">
          @csrf

          <div class="row mb-3">
            <div class="col">
              <label for="tipo" class="form-label">Tipo*</label>
              <select class="form-select" name="type" id="tipo" required onchange="atualizarDataTipo()">
                <option selected disabled>Selecione...</option>
                <option value="inward">Entrada</option>
                <option value="outward">Saída</option>
              </select>
            </div>
            <div class="col">
              <label for="data" class="form-label">Data*</label>
              <input type="date" class="form-control" name="date" id="data" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label for="quantidade" class="form-label">Quantidade*</label>
              <input type="number" class="form-control" name="quantity" id="quantidade" required>
            </div>
            <div class="col">
              <label for="custo" class="form-label">Custo*</label>
              <input type="text" class="form-control" name="cost" id="custo" required>
            </div>
          </div>

          <div class="mb-3">
            <label for="observacao" class="form-label">Observação</label>
            <input type="text" class="form-control" name="note" id="observacao">
          </div>

          <div class="mb-3">
            <select name="product_id" class="form-select" required>
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

<script>
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    const formData = new FormData(form);
    const response = await fetch(form.action, {
      method: 'POST',
      body: formData,
      headers: {
        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
      },
    });

    if (response.ok) {
      alert('Movimentação salva com sucesso!');
      window.location.reload(); // ou feche o modal e atualize a tabela
    } else {
      alert('Erro ao salvar movimentação.');
    }
  });
</script>

@endsection