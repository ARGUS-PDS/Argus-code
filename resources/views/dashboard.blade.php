<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Dashboard Estoque</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #773138;
    }

    .sidebar {
      background-color: #C6A578;
      height: 100vh;
      padding: 1rem;
      color: #202132;
    }

    .main-content {
      padding: 2rem;
    }

    .btn-dashboard {
      background-color: #C6A578;
      color: #202132;
      border-radius: 15px;
      padding: 1.2rem;
      font-weight: bold;
      width: 100%;
    }

    .btn-dashboard:hover {
      background-color: #C6A578;
    }

    .panel {
      background-color: #C6A578;
      color: #202132;
      border-radius: 15px;
      padding: 1rem;
      height: 250px;
      overflow-y: auto;
    }

    .panel h5 {
      font-weight: bold;
    }

    .dropdown-menu a {
      color: #202132;
      background-color: #C6A578;
    }

    .dropdown-menu a:hover {
      background-color: #000000;
      color: #FFFFFF;
    }

    .dropdown-menu {
      display: none;
    }
  </style>
</head>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-1 sidebar d-flex flex-column align-items-start">
        <i class="bi bi-person-circle me-4"></i> Ana Maria
      </div>

      <div class="col-md-10 main-content">
        <div class="row mb-4">
          <div class="col-md-4">
            <div class="dropdown">
              <button class="btn btn-dashboard dropdown-toggle w-100" onclick="show('dropdown-menu-cadastro')">
                Cadastro
              </button>
              <ul class="dropdown-menu w-100" id="dropdown-menu-cadastro">
                <li><a class="dropdown-item" href="/cadastrar-produto">Cadastro de Produtos</a></li>
                <li><a class="dropdown-item" href="/cadastrar-produto-ean">Cadastro de Produtos via EAN</a></li>
                <li><a class="dropdown-item" href="/cadastrar-fornecedor">Cadastro de Fornecedores</a></li>
                <li><a class="dropdown-item" href="/cadastrar-funcionario">Cadastro de Funcionários</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
            <div class="dropdown">
              <button class="btn btn-dashboard dropdown-toggle w-100" onclick="show('dropdown-menu-estoque')">
                Estoque
              </button>
              <ul class="dropdown-menu w-100" id="dropdown-menu-estoque">
                <li><a class="dropdown-item" href="#">Controle</a></li>
                <li><a class="dropdown-item" href="#">Acompanhamento de Validade</a></li>
                <li><a class="dropdown-item" href="/etiquetas">Etiquetas</a></li>
              </ul>
            </div>
          </div>
          <div class="col-md-4">
            <div class="dropdown">
              <button class="btn btn-dashboard dropdown-toggle w-100" onclick="show('dropdown-menu-pedido')">
                Pedidos
              </button>
              <ul class="dropdown-menu w-100" id="dropdown-menu-pedido">
                <li><a class="dropdown-item" href="#">Envio de Pedido</a></li>
                <li><a class="dropdown-item" href="#">Cotação de Fornecedores</a></li>
              </ul>
            </div>
          </div>
        </div>

        <div class="row g-4">
          <div class="col-md-4">
            <div class="panel">
              <h5>Produto / Validade</h5>
              <ul class="mt-2">
                <li>Produto A - Vence em 3 dias</li>
                <li>Produto B - Vence amanhã</li>
                <li>Produto C - Vence hoje</li>
              </ul>
            </div>
          </div>

          <div class="col-md-4">
            <div class="panel">
              <h5>Entrada / Saída</h5>
              <ul class="mt-2">
                <li>Entrada - Produto D</li>
                <li>Saída - Produto A</li>
                <li>Entrada - Produto E</li>
              </ul>
            </div>
          </div>

          <div class="col-md-4">
            <div class="panel">
              <h5>Alertas</h5>
              <ul class="mt-2">
                <li>Produto C venceu</li>
                <li>Produto F parado há 90 dias</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</body>

<script>
  function show(id) {
    const menu_hidden = document.getElementById(id);
    const display = window.getComputedStyle(menu_hidden).display;
    console.log(display)
    if (display === "none") {
      menu_hidden.style.display = "block"
    } else {
      menu_hidden.style.display = "none"
    }
  }
</script>

</html>