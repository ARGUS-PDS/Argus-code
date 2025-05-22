<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Lista de Fornecedores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
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
      <h2>Editar Fornecedor</h2>

      <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="first-info" style="display: flex; align-items: center; gap: 10px;">
          <div style="width: 100%;">
            <label class="block font-medium text-red-mine mb-1 bigger">Nome Atual</label>
            <input type="text" name="name" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('name', $supplier->name) }}" required>

            <label class="block bigger font-medium text-red-mine mb-1 mt-3">Código</label>
            <input type="text" name="code" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('code', $supplier->code) }}" required>
          </div>
        </div>



        <div class="d-flex mt-5" style="gap: 15px;">
          <a href="{{ route('suppliers.index') }}" class="btn btn-cancel">Cancelar</a>
          <button type="submit" class="btn btn-send">Salvar</button>
        </div>
      </form>



    </div>
  </div>

</body>

</html>