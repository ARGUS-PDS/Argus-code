@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/entrada-saida.css') }}">

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="entrada-saida-titulo mb-0">Entrada e saida</h2>
    @if($produtoSelecionado)
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalLancamento">+ Novo lançamento</button>
    @endif
  </div>

  {{-- Pesquisa de produto --}}
  <form method="GET" class="mb-4 entrada-saida-pesquisa" style="max-width: 350px;">
    <div class="input-group">
      <input type="text" name="produto" class="form-control" placeholder="Pesquisar produto..." value="{{ request('produto') }}" list="produtos-list">
      <datalist id="produtos-list">
        @foreach($products as $produto)
          <option value="{{ $produto->description }}">
        @endforeach
      </datalist>
      <button class="btn btn-secondary" type="submit">
        <i class="bi bi-search"></i>
      </button>
    </div>
  </form>

  @if($produtoSelecionado)
    <div class="mb-3">
      <h4 class="text-wine mb-0">{{ $produtoSelecionado->description }}</h4>
    </div>
  @endif

  @if($produtoSelecionado)
    <div class="row">
      <div class="col-lg-9 mb-4">
        @if(count($movimentacoes))
          <table class="table text-center align-middle" id="tabelaMovimentacoes">
            <thead>
              <tr>
                <th>Data</th>
                <th>Quantidade</th>
                <th>Valor</th>
                <th>Tipo</th>
                <th>Observação</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($movimentacoes as $mov)
              <tr>
                <td>{{ \Carbon\Carbon::parse($mov->date)->format('d/m/Y') }}</td>
                <td>{{ $mov->quantity }}</td>
                <td>R${{ number_format($mov->cost, 2, ',', '.') }}</td>
                <td>{{ ucfirst($mov->type) }}</td>
                <td>{{ $mov->note ?? '-' }}</td>
                <td>
                  <button class="btn btn-sm btn-outline-danger delete-movimentacao" data-id="{{ $mov->id }}" title="Excluir">
                    <i class="bi bi-trash"></i>
                  </button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <div class="alert alert-warning">Nenhuma movimentação encontrada para este produto.</div>
        @endif
      </div>
      <div class="col-lg-3">
        <div class="painel-resumo text-center">
          <p class="mb-2">
            <strong>Entradas:</strong> {{ $entradas_qtd }} (R$ {{ number_format($entradas_valor, 2, ',', '.') }})
          </p>
          <p class="mb-2">
            <strong>Saídas:</strong> {{ $saidas_qtd }} (R$ {{ number_format($saidas_valor, 2, ',', '.') }})
          </p>
          <p class="mb-2">
            <strong>Estoque atual:</strong> {{ $estoque_atual }}
          </p>
          <p class="mb-0">
            <strong>Lucro:</strong>
            <span style="color: {{ $lucro < 0 ? 'red' : 'green' }}">
              R$ {{ number_format($lucro, 2, ',', '.') }}
            </span>
          </p>
        </div>
      </div>
    </div>
  @elseif(request('produto'))
    <div class="alert alert-danger">Produto não encontrado.</div>
  @else
    <div class="alert alert-info">Pesquise um produto para ver suas movimentações.</div>
  @endif
</div>

{{-- Modal --}}
@if($produtoSelecionado)
<div class="modal fade" id="modalLancamento" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 px-3 pb-3 pt-2">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">Novo Lançamento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('movimentacao.store') }}" method="POST">
          @csrf
          <input type="hidden" name="product_id" value="{{ $produtoSelecionado->id }}">

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Tipo*</label>
              <select class="form-select" name="type" required>
                <option value="" disabled selected>Selecione...</option>
                <option value="entrada">Entrada</option>
                <option value="saida">Saída</option>
                <option value="balanco">Balanço</option>
              </select>
            </div>
            <div class="col">
              <label class="form-label">Data*</label>
              <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Quantidade*</label>
              <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="col">
              <label class="form-label">Custo*</label>
              <input type="number" name="cost" class="form-control" step="0.01" min="0" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">Observação</label>
            <input type="text" name="note" class="form-control">
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
@endif

@endsection

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Botão de excluir
    document.querySelectorAll('.delete-movimentacao').forEach(button => {
        button.addEventListener('click', function(e) {
            const movimentacaoId = this.dataset.id;
            
            if (confirm('Tem certeza que deseja excluir esta movimentação?')) {
                excluirMovimentacao(movimentacaoId);
            }
        });
    });

    function excluirMovimentacao(id) {
        fetch(`/movimentacoes/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Erro ao excluir movimentação');
            }
        })
        .catch(error => {
            console.error('Erro:', error);
            alert('Erro ao excluir movimentação');
        });
    }
});
</script>
