@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="{{ asset('css/entrada-saida.css') }}">

<div class="container py-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2 class="entrada-saida-titulo mb-0">{{ __('stock_movement.title') }}</h2>
    @if($produtoSelecionado)
    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalLancamento">+ {{ __('stock_movement.new_entry') }}</button>
    @endif
  </div>

  {{-- Pesquisa de produto --}}
  <x-search-bar
    name="produto"
    :datalist-options="collect($products->take(5))->map(fn($produto) => [
        'value' => $produto->description,
        'label' => $produto->barcode
    ])->toArray()"
    :value="request('produto')"
    placeholder="{{ __('stock_movement.search_placeholder') }}" />

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
            <th>{{ __('stock_movement.date') }}</th>
            <th>{{ __('stock_movement.quantity') }}</th>
            <th>{{ __('stock_movement.value') }}</th>
            <th>{{ __('stock_movement.type') }}</th>
            <th>{{ __('stock_movement.note') }}</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @foreach ($movimentacoes as $mov)
          <tr>
            <td>{{ \Carbon\Carbon::parse($mov->date)->format('d/m/Y') }}</td>
            <td>{{ $mov->quantity }}</td>
            <td>R${{ number_format($mov->cost, 2, ',', '.') }}</td>
            <td style="color: {{ $mov->type == 'inward' ? 'green' : ($mov->type == 'outward' ? 'red' : 'blue') }}">
              {{ $mov->type == 'inward' ? __('stock_movement.inward') : ($mov->type == 'outward' ? __('stock_movement.outward') : __('stock_movement.balance')) }}
            </td>
            <td>{{ $mov->note ?? '-' }}</td>
            <td>
              <form action="{{ route('movimentacao.destroy', $mov->id) }}" method="POST" onsubmit="return confirm('{{ __('stock_movement.confirm_delete') }}');">
                @csrf
                @method('DELETE')

                <button class="btn btn-sm btn-outline-danger delete-movimentacao" data-id="{{ $mov->id }}" title="{{ __('stock_movement.delete') }}">
                  <i class="bi bi-trash"></i>
                </button>
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <x-paginacao :paginator="$movimentacoes" />
      @else
      <div class="alert alert-warning">{{ __('stock_movement.no_records') }}</div>
      @endif
    </div>
    <div class="col-lg-3">
      <div class="painel-resumo text-center">
        <p class="mb-2">
          <strong>{{ __('stock_movement.inward') }}:</strong> {{ $entradas_qtd }} (R$ {{ number_format($entradas_valor, 2, ',', '.') }})
        </p>
        <p class="mb-2">
          <strong>{{ __('stock_movement.outward') }}:</strong> {{ $saidas_qtd }} (R$ {{ number_format($saidas_valor, 2, ',', '.') }})
        </p>
        <p class="mb-2">
          <strong>{{ __('stock_movement.current_stock') }}:</strong> {{ $estoque_atual }}
        </p>
        <!--
        <p class="mb-0">
          <strong>{{ __('stock_movement.profit') }}:</strong>
          <span style="color: {{ $lucro < 0 ? 'red' : 'green' }}; font-weight: bold">
            R$ {{ number_format($lucro, 2, ',', '.') }}
          </span>
        </p>
        -->
      </div>
    </div>
  </div>
  @elseif(request('produto'))
  <div class="alert alert-danger">{{ __('stock_movement.product_not_found') }}</div>
  @else
  <div class="alert alert-info">{{ __('stock_movement.search_message') }}</div>
  @endif
</div>

{{-- Modal --}}
@if($produtoSelecionado)
<div class="modal fade" id="modalLancamento" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content rounded-4 px-3 pb-3 pt-2">
      <div class="modal-header border-0">
        <h5 class="modal-title fw-bold">{{ __('stock_movement.modal_title') }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <form action="{{ route('movimentacao.store') }}" method="POST">
          @csrf
          <input type="hidden" name="product_id" value="{{ $produtoSelecionado->id }}">

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">{{ __('stock_movement.type_label') }}</label>
              <select class="form-select" name="type" required>
                <option value="" disabled selected>{{ __('stock_movement.select') }}</option>
                <option value="inward">{{ __('stock_movement.inward') }}</option>
                <option value="outward">{{ __('stock_movement.outward') }}</option>
                <option value="balance">{{ __('stock_movement.balance') }}</option>
              </select>
            </div>
            <div class="col">
              <label class="form-label">{{ __('stock_movement.date_label') }}</label>
              <input type="date" name="date" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">{{ __('stock_movement.quantity_label') }}</label>
              <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="col">
              <label class="form-label">{{ __('stock_movement.cost_label') }}</label>
              <input type="number" name="cost" class="form-control" step="0.01" min="0" required>
            </div>
          </div>

          <div class="mb-3">
            <label class="form-label">{{ __('stock_movement.note_label') }}</label>
            <input type="text" name="note" class="form-control">
          </div>

          <div class="mb-3">
            <label class="form-label">{{ __('stock_movement.batch_label') }}</label>
            <select name="batch_id" class="form-select">
              <option value="" disabled selected>{{ __('stock_movement.select_batch') }}</option>
              @foreach($batches as $lote)
              <option value="{{ $lote->id }}">
                Cód.: {{ $lote->batch_code }} - Val.: {{ $lote->expiration_date }}
              </option>
              @endforeach
            </select>
          </div>

          <div class="d-flex justify-content-end">
            <x-btn-cancelar href="#" data-bs-dismiss="modal" />
            <x-btn-salvar />
          </div>
        </form>
      </div>
    </div>
  </div>
  <script>
    function batch() {
      console.log("clique")
    }
  </script>
</div>
@endif

@endsection