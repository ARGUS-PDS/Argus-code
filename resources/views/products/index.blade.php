<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Lista de Produtos</title>
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

    .sidebar {
      background-color: #C6A578;
      height: 100vh;
      padding: 1rem;
      color: #202132;
      width: 100%;
    }

    .sideL {
      width: 92%
    }

    .sideS {
      width: 8%;
    }

    a {
      color: inherit;
      text-decoration: none;
    }

    a:hover {
      color: inherit;
      text-decoration: underline;
      /* Se quiser sublinhar no hover */
    }
  </style>
</head>

<body class="bg-light">
  <div class="">
    <div style="display: flex;">
      <div class="sideS">
        <div class="col-md-1 sidebar d-flex flex-column align-items-start">
          <span><i class="bi bi-person-circle me-2"></i> {{ Auth::user()->name }}</span>
          <a href="/dashboard" style="margin-top: 10px;"><span><i class="bi bi-house-door-fill me-2"></i>Dashboard</span></a>
        </div>
      </div>

      <div class="sideL p-3 mt-2">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h2 class="fw-bold mb-0">Produtos</h2>
          <div class="d-flex align-items-center gap-3">
            <form action="{{ route('pesquisa.index') }}" method="GET" class="search-bar">
              <input type="text" name="q" value="{{ request('q') }}" placeholder="Pesquisar por nome ou código...">
              <button type="submit" style="background: none; border: none;">
                <i class="bi bi-search"></i>
              </button>
            </form>
            <span class="ms-4 text-secondary">Estoque atual: {{ $products->sum('currentStock') }}</span>
            <i class="bi bi-printer fs-4 ms-3" title="Imprimir" style="cursor:pointer;"></i>
            <!-- <i class="bi bi-trash fs-4 ms-2" title="Excluir" style="cursor:pointer;"></i> -->
            <a href="{{ route('products.create') }}" class="btn btn-primary add-btn ms-2" title="Adicionar">
              <i class="bi bi-plus"></i>
            </a>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table align-middle">
            <thead>
              <tr>
                <th style="width:32px"></th>
                <th>Imagem</th>
                <th>Nome</th>
                <th>Fornecedor</th>
                <th>Código</th>
                <th>Estoque</th>
                <th>Preço</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              @forelse ($products as $product)
              <tr>
                <td><input type="checkbox"></td>
                <td>
                  @if ($product->image_url)
                  <img src="{{ asset($product->image_url) }}" alt="Imagem do produto" class="img-thumb">
                  @else
                  <span class="text-muted small">Sem imagem</span>
                  @endif
                </td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->supplier ? $product->supplier->name : 'Sem fornecedor' }}</td>
                <td>{{ $product->code }}</td>
                <td>{{ $product->currentStock }}</td>
                <td>R$ {{ number_format($product->value, 2, ',', '.') }}</td>
                <td>
                  <div class="dropdown">
                    <i class="bi bi-three-dots-vertical dropdown-toggle" role="button" id="dropdownMenuButton{{ $product->id }}" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;"></i>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $product->id }}">
                      <li>
                        <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">Editar</a>
                      </li>
                      <li>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                          @csrf
                          @method('DELETE')
                          <button class="dropdown-item text-danger" type="submit">Excluir</button>
                        </form>
                      </li>
                    </ul>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="text-center text-muted py-4">Nenhum produto cadastrado.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</html>