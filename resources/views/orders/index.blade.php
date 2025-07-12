<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Pedidos Enviados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="mb-4">Pedidos Enviados</h2>
    <a href="{{ route('produtos.esgotando') }}" class="btn btn-secondary mb-3">⬅️ Voltar</a>

    <table class="table table-bordered">
        <thead class="table-light">
            <tr>
                <th>Data</th>
                <th>Produto</th>
                <th>Fornecedor</th>
                <th>Quantidade</th>
                <th>Prazo</th>
                <th>Canal</th>
                <th>Mensagem</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pedidos as $pedido)
                <tr>
                    <td>{{ $pedido->created_at->format('d/m/Y H:i') }}</td>
                    <td>{{ $pedido->produto->description ?? '-' }}</td>
                    <td>{{ $pedido->fornecedor->name ?? '-' }}</td>
                    <td>{{ $pedido->quantidade }}</td>
                    <td>{{ $pedido->prazo_entrega }}</td>
                    <td>{{ ucfirst($pedido->canal_envio) }}</td>
                    <td>{{ $pedido->mensagem_enviada }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Nenhum pedido enviado ainda.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
</body>
</html>
