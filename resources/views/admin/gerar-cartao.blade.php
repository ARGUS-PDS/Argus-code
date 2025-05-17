<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Admin - Argus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
@media print {
    body * {
        visibility: hidden !important;
    }
    #cartao-seguranca, #cartao-seguranca * {
        visibility: visible !important;
    }
    #cartao-seguranca {
        position: absolute !important;
        left: 0;
        top: 0;
        right: 0;
        margin: auto;
        box-shadow: none !important;
        page-break-before: always;
    }
    button {
        display: none !important;
    }
}
</style>

<body class="bg-light p-4">

    <div class="container">
        <h3 class="mb-4">Gerar Cartão de Segurança</h3>

            @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

        <form method="POST" action="{{ route('admin.gerarCartao') }}">
            @csrf

            <div class="mb-3">
                <label for="user_id" class="form-label">Usuário</label>
                <select class="form-select" name="user_id" id="user_id" required>
                    <option value="">-- Selecione --</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Gerar Cartão</button>
        </form>

        @if (session('cartao'))
            <div id="cartao-seguranca" class="card mt-5 p-4 text-center mx-auto"
                style="width: 320px; height: 200px; border-radius: 16px; border: 2px solid #490006; background-color: #C6A578; box-shadow: 0 2px 8px rgba(0,0,0,0.1); display: flex; flex-direction: column; justify-content: center;">
                <h5 class="mb-2" style="color: #490006;">Cartão de Segurança Argus</h5>
                <p style="margin-bottom: 4px;"><strong>User:</strong> {{ \App\Models\User::find(session('user_id'))->name }}</p>
                <p style="margin-bottom: 4px;"><strong>Número do cartão:</strong> {{ session('cartao') }}</p>
                <p style="margin-bottom: 4px;"><strong>Validade:</strong> {{ \Carbon\Carbon::now()->addMonth()->format('d/m/Y') }}</p>
                <button class="btn btn-dark mt-2" onclick="window.print()">Imprimir Cartão</button>
            </div>
        @endif

    </div>

</body>
</html>
