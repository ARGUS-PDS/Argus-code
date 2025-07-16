<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Cadastrar Produto - Busca por Código de Barras</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">

  @include('layouts.css-variables')
  
</head>

<body class="bg-light">

  <div class="container my-5">
    <h2 class="mb-4">Buscar Produto por Código de Barras</h2>

    <form id="formBuscaCodigo" class="form-inline mb-4">
      <div class="form-group mr-2">
        <label for="inputCodigo" class="sr-only">Código de Barras</label>
        <input type="text" id="inputCodigo" class="form-control" placeholder="Digite ou escaneie o código" required minlength="6" />
      </div>
      <button type="submit" class="btn btn-primary">Buscar</button>
    </form>

    <div id="mensagemErro" class="alert alert-danger d-none" role="alert"></div>

    <form id="formCadastroProduto" class="border p-4 bg-white rounded d-none" method="POST" action="{{ route('cadastrar-produto.store') }}" novalidate>
      @csrf
      <h4 class="mb-3">Cadastrar Produto</h4>

      <div class="form-row">
        <div class="col-md-4 text-center mb-3">
          <div id="imagemProduto" class="border rounded p-2" style="min-height:150px; display:flex; align-items:center; justify-content:center;">
            <span class="text-muted">Imagem do produto</span>
          </div>
        </div>
        <div class="col-md-8">
          <div class="form-group">
            <label for="nomeProduto">Nome</label>
            <input name="image_url" type="text" class="form-control" id="nomeProduto" placeholder="Nome do produto" required />
            <div class="invalid-feedback">Por favor, informe o nome do produto.</div>
          </div>
          <div class="form-group">
            <label for="nomeProduto">Código</label>
            <input name="code" type="text" class="form-control" id="nomeProduto" placeholder="Código do produto" required />
            <div class="invalid-feedback">Por favor, informe o código do produto.</div>
          </div>
          <div class="form-group">
            <label name="description" for="nomeProduto">Descrição</label>
            <input type="text" class="form-control" id="nomeProduto" placeholder="descrição do produto" required />
            <div class="invalid-feedback">Por favor, informe a descrição do produto.</div>
          </div>
          <div class="form-group">
            <label for="dataValidade">Data de Validade</label>
            <input name="expiration_date" type="date" class="form-control" id="dataValidade" />
          </div>
          <div class="form-group">
            <label for="codigoBarra">Código de Barras</label>
            <input name="barcode" type="text" class="form-control" id="codigoBarra" readonly />
          </div>
          <div class="form-group">
            <label for="valorVenda">Valor de Venda (R$)</label>
            <input name="value" type="number" class="form-control" id="valorVenda" placeholder="Valor de venda" min="0" step="0.01" />
          </div>
          <!-- <div class="form-group">
            <label for="valorCompra">Valor de Compra (R$)</label>
            <input type="number" class="form-control" id="valorCompra" placeholder="Valor de compra" min="0" step="0.01" />
          </div> -->
          <div class="form-group">
            <label for="lucro">Lucro (R$)</label>
            <input name="profit" type="number" class="form-control" id="lucro" placeholder="Lucro" min="0" step="0.01" />
          </div>
          <div>
            <label class="block bigger font-medium text-red-mine mb-1">Fornecedor</label>
            <select name="supplierId" class="w-full border border-gray-300 rounded-md p-2" required>
              <option value="">Selecione um fornecedor</option>
              @foreach ($suppliers as $supplier)
              <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
              @endforeach
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-red-mine mb-1">Marca</label>
            <input name="brand" type="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Ex: Anita">
          </div>
          <div>
            <label class="block text-sm font-medium text-red-mine mb-1">Modelo</label>
            <input name="model" type="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Ex: Carnaval">
          </div>
        </div>
        <div class="border-mine p-stock">
          <label class="block bigger font-medium text-red-mine mb-1">Estoque</label>
          <div class="d-flex justify-around" style="gap: 15px">
            <div>
              <label class="block text-sm font-medium text-red-mine mb-1">Estoque Atual</label>
              <input name="currentStock" type="number" class="w-full border border-gray-300 rounded-md p-2" placeholder="Ex: 40" required>
            </div>
            <div>
              <label class="block text-sm font-medium text-red-mine mb-1">Estoque Mínimo</label>
              <input name="minimumStock" type="number" class="w-full border border-gray-300 rounded-md p-2" placeholder="Ex: 150" required>
            </div>
          </div>
        </div>
        <div class="form-check mb-3">
          <input name="status" type="checkbox" class="form-check-input" id="situacao" />
          <label class="form-check-label" for="situacao">Ativo</label>
        </div>
        <x-btn-salvar />
        <x-btn-cancelar href="#" id="btnCancelar" />
      </div>
  </div>
  </form>
  </div>

<script src="{{ asset('js/codigo-de-barras.js') }}"></script>

</body>

</html>