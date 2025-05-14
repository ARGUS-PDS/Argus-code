<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login - Argus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light d-flex align-items-center justify-content-center vh-100">

    <div class="card shadow p-4" style="width: 100%; max-width: 400px;">
        <h4 class="mb-3 text-center">Login no Argus</h4>

        @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="/login">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required autofocus>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" class="form-control" name="password" id="password" required>
            </div>

            <div class="mb-3">
                <label for="cartao_seg" class="form-label">Final do cartão de segurança</label>
                <input type="text" class="form-control" name="cartao_seg" id="cartao_seg" maxlength="2" required pattern="\d{2}" placeholder="Ex: 42">
            </div>

            <button type="submit" class="btn btn-primary w-100">Entrar</button>
        </form>
    </div>

</body>
</html>
