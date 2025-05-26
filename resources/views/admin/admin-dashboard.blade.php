<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Painel do Administrador - Argus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Favicon para tema claro -->
  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">

  <!-- Favicon para tema escuro -->
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">

</head>
<body class="bg-light vh-100 d-flex flex-column justify-content-center align-items-center">

    <div class="card shadow p-5 text-center" style="max-width: 500px; width: 100%;">
        <h2 class="mb-4">Argon</h2>
        <p class="mb-4">Painel exclusivo da equipe Argon.</p>

        <div class="d-grid gap-3">
            <a href="{{ route('admin.cartao') }}" class="btn btn-primary">Gerar Cartão de Segurança</a>
            <a href="/logout" class="btn btn-danger">Sair</a>
        </div>
    </div>

</body>
</html>
