<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhamento de Lote</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-3">
           <i class="bi bi-arrow-left"></i> Voltar
       </a>
        <h2 class="mb-4">Detalhamento de Lote</h2>

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="lote" class="form-label">Lote</label>
                    <div class="input-group">
                        <input type="text" name="lote" id="lote" class="form-control" placeholder="Digite o número do lote">
                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="produto" class="form-label">Produto</label>
                    <input type="text" name="produto" id="produto" class="form-control" placeholder="Nome do produto" disabled>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="data_validade" class="form-label">Data de Validade</label>
                    <input type="date" name="data_validade" id="data_validade" class="form-control" disabled>
                </div>

                <div class="col-md-6">
                    <label for="data_entrada" class="form-label">Data de Entrada</label>
                    <input type="date" name="data_entrada" id="data_entrada" class="form-control" disabled>
                </div>
            </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
