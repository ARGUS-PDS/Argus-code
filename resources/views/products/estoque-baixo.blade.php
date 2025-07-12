<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Produtos com Estoque Baixo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>

<div class="container my-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Produtos com Estoque Baixo</h2>
        <a href="{{ route('orders.index') }}" class="btn btn-info">
            Ver Pedidos Enviados
        </a>
    </div>

    <ul class="list-group">
    @foreach($produtos as $produto)
        <li class="list-group-item">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">{{ $produto->description }}</h5>
                    <small>
                        Estoque atual: <strong>{{ $produto->currentStock }}</strong> | Mínimo: {{ $produto->minimumStock }}
                    </small>
                </div>
                <button class="btn btn-outline-primary"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#formPedido{{ $produto->id }}"
                    aria-expanded="false"
                    aria-controls="formPedido{{ $produto->id }}">
                    Fazer Pedido
                </button>
            </div>
            <div class="collapse mt-3" id="formPedido{{ $produto->id }}">
                <div class="card card-body">
                    <h6 class="mb-3">Fazer Pedido</h6>
                    <form action="{{ route('pedido.enviar') }}" method="POST">
                        @csrf
                        <input type="hidden" name="produto_id" value="{{ $produto->id }}">
                        <div class="mb-3">
                            <label for="quantidade{{ $produto->id }}" class="form-label">Quantidade desejada:</label>
                            <input type="number" name="quantidade" id="quantidade{{ $produto->id }}" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="prazo{{ $produto->id }}" class="form-label">Prazo de entrega:</label>
                            <input type="text" name="prazo" id="prazo{{ $produto->id }}" class="form-control">
                        </div>
                        <div class="mb-3">
                        <label class="form-label">Enviar via:</label>
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-danger" onclick="setCanalEnvio('{{ $produto->id }}', 'email')">
                                <i class="fas fa-envelope"></i> E-mail
                            </button>
                            <button type="button" class="btn btn-outline-success" onclick="setCanalEnvio('{{ $produto->id }}', 'whatsapp')">
                                <i class="fab fa-whatsapp"></i> WhatsApp
                            </button>
                        </div>
                        <input type="hidden" name="canal_envio" id="canal_envio_input_{{ $produto->id }}" required>
                    </div>

                        <button type="submit" class="btn btn-primary me-2">Enviar Pedido</button>
                        <button type="button" class="btn btn-secondary" data-bs-toggle="collapse" data-bs-target="#formPedido{{ $produto->id }}">Cancelar</button>
                    </form>
                </div>
            </div>
        </li>
    @endforeach
    </ul>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@if(session('whatsapp_url'))
    <script>
        window.open("{{ session('whatsapp_url') }}", "_blank");
    </script>
@endif

<script>
    function setCanalEnvio(produtoId, canal) {
        document.getElementById(`canal_envio_input_${produtoId}`).value = canal;
    }
</script>

</body>
</html>
