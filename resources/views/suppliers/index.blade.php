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
  </style>
</head>
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
@endif

<body class="bg-light">
  <div class="container mt-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <h2 class="fw-bold mb-0">Fornecedores</h2>
      <div class="d-flex align-items-center gap-3">
        <form action="{{ route('pesquisa.index') }}" method="GET" class="search-bar">
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Pesquisar por nome ou código...">
          <button type="submit" style="background: none; border: none;">
            <i class="bi bi-search"></i>
          </button>
        </form>
        <span class="ms-4 text-secondary">Estoque atual: </span>
        <!-- <i class="bi bi-trash fs-4 ms-2" title="Excluir" style="cursor:pointer;"></i> -->
        <a href="{{ route('suppliers.create') }}" class="btn btn-primary add-btn ms-2" title="Adicionar">
          <i class="bi bi-plus"></i>
        </a>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table align-middle">
        <thead>
          <tr>
            <th style="width:32px"></th>
            <th>Nome</th>
            <th>Código</th>
            <th>CPF/CNPJ</th>
            <th>Distribuidor</th>
            <th>Contato</th>
            <th>Endereço</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse ($suppliers as $supplier)
          <tr>
            <td><input type="checkbox"></td>
            <td>{{ $supplier->name }}</td>
            <td>{{ $supplier->code }}</td>
            <td>{{ $supplier->document }}</td>
            <td>{{ $supplier->distributor }}</td>
            <td>
              {{ $supplier->fixedphone }}
              <i id="toggleIconC{{ $supplier->id }}" onclick="seemorecontat('{{ $supplier->id }}')" class="bi bi-plus-circle-fill" style="cursor: pointer;"></i>
            </td>
            <td style="display: flex;">
              <p style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">

                @if($supplier->address)
                {{ $supplier->address->place }}, Nº {{ $supplier->address->number }}, {{ $supplier->address->neighborhood }}
                @else
                Não informado
                @endif
              </p>
              <i id="toggleIconA{{ $supplier->id }}" onclick="seemoreaddresses('{{ $supplier->id }}')" class="bi bi-plus-circle-fill" style="cursor: pointer;"></i>
            </td>
          <tr id="addresses{{ $supplier->id }}" style="display: none;">
            <td colspan="7">

              @if($supplier->address)
              <strong>Endereço:</strong> {{ $supplier->address->place  }}, Nº {{ $supplier->address->number  }}, {{ $supplier->address->neighborhood  }} <br>
              <strong>CEP:</strong> {{ $supplier->address->cep }} <br>
              <strong>Cidade:</strong> {{ $supplier->address->city }} - {{ $supplier->address->state }}
              @else
              <strong>Endereço:</strong> Não cadastrado.
              @endif
            </td>
          </tr>
          <tr id="contacts{{ $supplier->id }}" style="display: none;">
            <td colspan="7">
              <strong>Telefone Fixo:</strong> {{ $supplier->fixedphone }} <br>
              <strong>Celular:</strong> {{ $supplier->phone }} <br>
              <strong>Email:</strong> {{ $supplier->email }} <br>
              <strong>Contato 1:</strong> {{ $supplier->contactName1 }} - {{ $supplier->contactPosition1 }} - {{ $supplier->contactNumber1 }} <br>
              <strong>Contato 2:</strong> {{ $supplier->contactName2 }} - {{ $supplier->contactPosition2 }} - {{ $supplier->contactNumber2 }}
            </td>
          </tr>
          </tr>


          <td>
            <div class="dropdown">
              <i class="bi bi-three-dots-vertical dropdown-toggle" role="button" id="dropdownMenuButton{{ $supplier->id }}" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;"></i>
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $supplier->id }}">
                <li>
                  <a class="dropdown-item" href="{{ route('suppliers.edit', $supplier->id) }}">Editar</a>
                </li>
                <li>
                  <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este fornecedor?');">
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
            <td colspan="7" class="text-center text-muted py-4">Nenhum fornecedor cadastrado.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>
</body>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<<script>
  function seemorecontat(id) {
  const contacts = document.getElementById("contacts" + id);
  const icon = document.getElementById('toggleIconC' + id);

  if (contacts.style.display === "none" || contacts.style.display === "") {
  contacts.style.display = "table-row";
  icon.classList.remove('bi-plus-circle-fill');
  icon.classList.add('bi-dash-circle-fill');
  } else {
  contacts.style.display = "none";
  icon.classList.remove('bi-dash-circle-fill');
  icon.classList.add('bi-plus-circle-fill');
  }
  }

  function seemoreaddresses(id) {
  const addresses = document.getElementById("addresses" + id);
  const icon = document.getElementById('toggleIconA' + id);

  if (addresses.style.display === "none" || addresses.style.display === "") {
  addresses.style.display = "table-row";
  icon.classList.remove('bi-plus-circle-fill');
  icon.classList.add('bi-dash-circle-fill');
  } else {
  addresses.style.display = "none";
  icon.classList.remove('bi-dash-circle-fill');
  icon.classList.add('bi-plus-circle-fill');
  }
  }
  </script>


</html>