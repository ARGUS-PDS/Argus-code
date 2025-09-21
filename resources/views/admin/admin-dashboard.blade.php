<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Painel do Administrador - Argus</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">

  <style>
  :root {
    --color-vinho: #773138;
    --color-bege-claro: #f8f0e5;
    --color-gray-claro: #ddd;
    --color-gray-escuro: #555;
    --color-green: #28a745;
    --color-table-header-bg: #773138;
    --color-table-header-text: #fff;
    --color-table-row-bg: #fdfaf7;
    --color-border: #e0e0e0;

    --bs-primary: var(--color-vinho);
    --bs-secondary: var(--color-gray-escuro);

    --bs-btn-bg: var(--bs-primary);
    --bs-btn-border-color: var(--bs-primary);
    --bs-btn-hover-bg: #5f282e;
    --bs-btn-hover-border-color: #5f282e;
    --bs-btn-active-bg: #471e23;
    --bs-btn-active-border-color: #471e23;
    --bs-btn-color: #fff;

    --bs-danger: #dc3545;
    --bs-btn-danger-bg: var(--bs-danger);
    --bs-btn-danger-border-color: var(--bs-danger);
    --bs-btn-danger-hover-bg: #c82333;
    --bs-btn-danger-hover-border-color: #bd2130;

    --gradient-start: #eecac0;
    --gradient-end: #773138;

    --color-card-bg: #fef6f0;
  }

  body {
    background: linear-gradient(to right, var(--gradient-start), var(--gradient-end)) !important;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 1rem;
  }

  .card {
    background-color: var(--color-card-bg);
    border: none;
    border-radius: 16px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
    overflow: hidden;
    width: 100%;
    max-width: 500px;
    padding: 2rem;
  }

  h2 {
    color: var(--color-vinho);
    font-weight: bold;
    font-size: 2.2rem;
    margin-bottom: 1rem;
  }

  p {
    color: var(--color-gray-escuro);
    font-size: 1rem;
    margin-bottom: 1.5rem;
  }

  .btn {
    border-radius: 10px;
    padding: 0.8rem 1.5rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    transition: all 0.3s ease;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
  }

  .btn-primary {
    background-color: var(--color-vinho) !important;
    border-color: var(--color-vinho) !important;
    color: #fff !important;
  }

  .btn-primary:hover {
    background-color: #5f282e !important;
    border-color: #5f282e !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
  }

  .btn-danger {
    background-color: var(--bs-danger) !important;
    border-color: var(--bs-danger) !important;
    color: #fff !important;
  }

  .btn-danger:hover {
    background-color: #c82333 !important;
    border-color: #bd2130 !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
  }

  .d-grid.gap-3 {
    gap: 1.2rem !important;
    margin-top: 2rem;
  }

  /* Media Queries para responsividade */
  @media (max-width: 576px) {
    .card {
      padding: 1.5rem;
      border-radius: 12px;
    }

    h2 {
      font-size: 1.8rem;
    }

    p {
      font-size: 0.95rem;
    }

    .btn {
      padding: 0.7rem 1.2rem;
      font-size: 0.9rem;
    }
  }

  @media (max-width: 400px) {
    .card {
      padding: 1.2rem;
    }

    h2 {
      font-size: 1.6rem;
    }

    .btn {
      padding: 0.6rem 1rem;
      font-size: 0.85rem;
    }

    .d-grid.gap-3 {
      gap: 1rem !important;
    }
  }

  @media (min-width: 1200px) {
    .card {
      max-width: 550px;
      padding: 2.5rem;
    }

    h2 {
      font-size: 2.5rem;
    }

    p {
      font-size: 1.1rem;
    }
  }
  </style>
</head>

<body>
  <div class="card text-center">
    <h2 class="mb-3">Argon</h2>
    <p class="mb-4">Painel exclusivo da equipe Argon.</p>

    <div class="d-grid gap-3">
      <a href="{{ route('admin.cartao') }}" class="btn btn-primary">Gerar Cartão de Segurança</a>
      <a href="{{ route('companies.create') }}" class="btn btn-primary">Cadastrar Empresa</a>
      <a href="{{ route('companies.index') }}" class="btn btn-primary">Lista de Empresas</a>
      <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Sair</button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>