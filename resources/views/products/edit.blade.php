<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Lista de Produtos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Favicon para tema claro -->
  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">

  <!-- Favicon para tema escuro -->
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
  
  <style>
    .search-bar {
      background: #46585c;
      border-radius: 20px;
      padding: 6px 16px;
      color: #fff;
      width: 300px;
      display: flex;
      align-items: center;
    }

    .search-bar input {
      background: transparent;
      border: none;
      color: #fff;
      outline: none;
      width: 90%;
    }

    .search-bar .bi-search {
      color: #b1b1b1;
      font-size: 1.2rem;
      margin-left: 8px;
    }

    .table th,
    .table td {
      vertical-align: middle;
      background: #f9f9f9;
    }

    .img-thumb {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border: 2px solid #198754;
      border-radius: 8px;
      background: #fff;
    }

    .add-btn {
      border: 2px solid #198754;
      border-radius: 50%;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: #198754;
      background: none;
      cursor: pointer;
      margin-left: 8px;
      transition: background 0.2s;
    }

    .add-btn:hover {
      background: #e7f6ee;
    }

    .menu-dot {
      font-size: 1.5rem;
      color: #767676;
      cursor: pointer;
      text-align: center;
    }

    .img-thumb {
      width: 150px;
      height: 100px;
      object-fit: cover;
      border: black;
      border-radius: 8px;
      background: #fff;
    }
  </style>
</head>

<body class="bg-light">
  <div>
    <div class="container">
      <h2>Editar Produto</h2>

      <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="first-info" style="display: flex; align-items: center; gap: 10px;">
          <div style="width: 30%;">
            <label class="block font-medium text-red-mine mb-1 bigger">Imagem Atual</label>
            @if ($product->image_url)
            <img src="{{ asset('storage/' . $product->image_url) }}" alt="Imagem do Produto" class="img-thumb">
            @endif
            <input type="file" name="image_url" class="w-full border border-gray-300 rounded-md p-2" accept="image/*">
            <small class="text-muted">Deixe em branco para manter a imagem atual</small>
          </div>

          <div style="width: 70%;">
            <label class="block font-medium text-red-mine mb-1 bigger">Código</label>
            <input type="text" name="code" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('code', $product->code) }}" required>

            <label class="block bigger font-medium text-red-mine mb-1 mt-3">Descrição</label>
            <input type="text" name="description" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('description', $product->description) }}" required>
          </div>
        </div>

        <div class="gap-6 mt-4">
          <label class="block bigger font-medium text-red-mine mb-1">Código de barra</label>
          <input name="barcode" type="text" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('barcode', $product->barcode) }}" required>

          <label class="block bigger font-medium text-red-mine mb-1 mt-3">Data de validade</label>
          <input name="expiration_date" type="date" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('expiration_date', $product->expiration_date) }}" required>
        </div>

        <div class="d-flex" style="gap: 15px; margin-top: 15px;">
          <div>
            <label class="block bigger font-medium text-red-mine mb-1">Valor</label>
            <input name="value" type="number" step="0.01" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('value', $product->value) }}">
          </div>
          <div>
            <label class="block bigger font-medium text-red-mine mb-1">Lucro</label>
            <input name="profit" type="number" step="0.01" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('profit', $product->profit) }}" required>
          </div>
        </div>

        <div class="mt-4">
          <label class="block bigger font-medium text-red-mine mb-1">Fornecedor</label>
          <select name="supplierId" class="w-full border border-gray-300 rounded-md p-2" required>
            <option value="">Selecione um fornecedor</option>
            @foreach ($suppliers as $supplier)
            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="border-mine p-stock mt-4">
          <label class="block bigger font-medium text-red-mine mb-1">Informações Adicionais</label>
          <div class="d-flex justify-around" style="gap: 15px; margin-bottom: 15px">
            <div>
              <label class="block text-sm font-medium text-red-mine mb-1">Marca</label>
              <input name="brand" type="text" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('brand', $product->brand) }}">
            </div>
            <div>
              <label class="block text-sm font-medium text-red-mine mb-1">Modelo</label>
              <input name="model" type="text" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('model', $product->model) }}">
            </div>
          </div>
        </div>

        <div class="border-mine p-stock mt-4">
          <label class="block bigger font-medium text-red-mine mb-1">Estoque</label>
          <div class="d-flex justify-around" style="gap: 15px">
            <div>
              <label class="block text-sm font-medium text-red-mine mb-1">Estoque Atual</label>
              <input name="currentStock" type="number" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('currentStock', $product->currentStock) }}" required>
            </div>
            <div>
              <label class="block text-sm font-medium text-red-mine mb-1">Estoque Mínimo</label>
              <input name="minimumStock" type="number" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('minimumStock', $product->minimumStock) }}" required>
            </div>
          </div>
        </div>

        <div class="mt-4">
          <label class="block text-sm font-medium text-red-mine mb-1">Situação</label>
          <label class="inline-flex items-center cursor-pointer" onclick="show()">
            <input type="checkbox" class="sr-only peer" name="status" value="1" {{ old('status', $product->status) ? 'checked' : '' }}>
            <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-black-500 rounded-full peer dark:bg-red-700 peer-checked:bg-green-700 transition-all"></div>
            <span class="ml-3 text-sm text-red-700 peer-checked:text-green-700 bold" id="active">{{ old('status', $product->status) ? 'Ativo' : 'Inativo' }}</span>
          </label>
        </div>

        <div class="d-flex mt-5" style="gap: 15px;">
          <a href="{{ route('products.index') }}" class="btn btn-cancel">Cancelar</a>
          <button type="submit" class="btn btn-send">Salvar</button>
        </div>
      </form>

      <script>
        function show() {
          const checkbox = document.querySelector('input[name="status"]');
          const statusElement = document.getElementById("active");

          if (checkbox.checked) {
            statusElement.textContent = "Ativo";
          } else {
            statusElement.textContent = "Inativo";
          }
        }
      </script>

    </div>
  </div>

</body>

</html>