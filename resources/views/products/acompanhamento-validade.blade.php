@extends('layouts.app')

@section('styles')
<style>
.container {
    margin-top: 20px;
}

h2 {
    color: #773138;
    font-weight: bold;
    margin-bottom: 15px;
}

#produtoInput {
    border-radius: 8px;
    border: 1px solid #ccc;
}
#buscarBtn {
    background-color: #773138;
    color: #f8f0e5;
    border: none;
}
#buscarBtn:hover {
    background-color: #77313880;
}

.table-bordered {
    border-radius: 12px;
    overflow: hidden;
}
.table-bordered th {
    background-color: #773138;
    color: #f8f0e5;
    border: none;
}
.table-bordered td {
    border-top: 1px solid #ddd;
}
.table-bordered tbody tr:hover {
    background-color: rgba(119, 49, 56, 0.1);
}

/* Modal */
#modalProdutos .modal-content {
    border-radius: 12px;
}
#modalProdutos .modal-header {
    background-color: #773138;
    color: #f8f0e5;
    border-bottom: none;
}
#modalProdutos .btn-close {
    filter: invert(1);
}
#modalProdutos table {
    border-radius: 12px;
    overflow: hidden;
}
#modalProdutos table th {
    background-color: #773138;
    color: #f8f0e5;
}
#modalProdutos table tbody tr:hover {
    background-color: rgba(119, 49, 56, 0.1);
    cursor: pointer;
}
</style>
@endsection

@section('content')

{{-- Modal de mensagens globais --}}
@include('components.alert-modal')

<div class="container">
    <h2>Acompanhamento de Validade</h2>

    <input type="text" id="produtoInput" placeholder="Pesquise o produto..." class="form-control mb-2">

    <button id="buscarBtn" class="btn btn-primary mb-3">Buscar</button>

    <table class="table table-bordered" id="tabelaLotes">
        <thead>
            <tr>
                <th>Lote</th>
                <th>Produto</th>
                <th>Validade</th>
                <th>Data de Entrada</th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>

<div class="modal fade" id="modalProdutos" tabindex="-1" aria-labelledby="modalProdutosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProdutosLabel">Selecione um Produto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <table class="table table-hover" id="tabelaProdutos">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Código</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script>
$(document).ready(function() {
    const produtoInput = $("#produtoInput");
    const tabelaLotes = $("#tabelaLotes tbody");
    const modalProdutos = new bootstrap.Modal(document.getElementById('modalProdutos'));

    produtoInput.dblclick(function() {
        modalProdutos.show();

        $.get("{{ route('products.lista') }}", function(data) {
            const tbody = $("#tabelaProdutos tbody");
            tbody.empty();
            data.forEach(prod => {
                const tr = $("<tr>").css("cursor","pointer")
                                     .html(`<td>${prod.description}</td><td>${prod.code || "-"}</td>`)
                                     .click(function() {
                                        produtoInput.val(prod.description); 
                                        modalProdutos.hide();
                                        carregarLotes(prod.description);
                                    });
                tbody.append(tr);
            });
        });
    });

    function carregarLotes(produto) {
        tabelaLotes.empty();
        $.ajax({
            url: "{{ route('validade.buscar') }}",
            method: "POST",
            data: {
                produto: produto,
                _token: "{{ csrf_token() }}"
            },
            success: function(res) {
                if(res.success) {
                    res.data.forEach(item => {
                        const tr = $("<tr>").html(`
                            <td>${item.batch_code}</td>
                            <td>${item.produto}</td>
                            <td>${item.data_validade}</td>
                            <td>${item.data_entrada}</td>
                        `);
                        tabelaLotes.append(tr);
                    });
                } else {
                    alert(res.message || "Nenhum lote encontrado.");
                }
            },
            error: function() {
                alert("Erro ao buscar lotes.");
            }
        });
    }

        $("#buscarBtn").click(function() {
        const nomeProduto = produtoInput.val().trim();
        if(nomeProduto === "") return;
        carregarLotes(nomeProduto);
    });
});
</script>
@endsection
