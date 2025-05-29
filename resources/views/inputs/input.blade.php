<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Importar XML de Nota Fiscal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>
<div class="container my-4">
    <h2 class="mb-4">Importar XML da Nota Fiscal</h2>
    <form method="POST" enctype="multipart/form-data" class="mb-5">
        <div class="mb-3">
            <label for="xmlFile" class="form-label">Selecione o arquivo XML</label>
            <input class="form-control" type="file" name="xml_file" id="xmlFile" accept=".xml" required>
        </div>
        <button type="submit" class="btn btn-primary">Importar</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['xml_file'])) {
        $xmlContent = file_get_contents($_FILES['xml_file']['tmp_name']);

        if (!$xmlContent) {
            echo '<div class="alert alert-danger">Erro ao ler o arquivo.</div>';
            exit;
        }

        try {
            $xml = new SimpleXMLElement($xmlContent);

            $emitente = $xml->NFe->infNFe->emit;
            $destinatario = $xml->NFe->infNFe->dest;
            $total = $xml->NFe->infNFe->total->ICMSTot;
            ?>

            <h3>Dados do Fornecedor (Emitente)</h3>
            <form>
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome</label>
                        <input type="text" class="form-control" readonly value="<?= htmlspecialchars($emitente->xNome) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">CNPJ</label>
                        <input type="text" class="form-control" readonly value="<?= htmlspecialchars($emitente->CNPJ) ?>">
                    </div>
                </div> <div class="row mb-3">
                    <div class="col-md-8">
                        <label class="form-label">Endereço</label>
                        <input type="text" class="form-control" readonly value="<?= htmlspecialchars($emitente->enderEmit->xLgr . ', ' . $emitente->enderEmit->nro . ' - ' . $emitente->enderEmit->xBairro) ?>">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Município</label>
                        <input type="text" class="form-control" readonly value="<?= htmlspecialchars($emitente->enderEmit->xMun) ?>">
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label class="form-label">UF</label>
                        <input type="text" class="form-control" readonly value="<?= htmlspecialchars($emitente->enderEmit->UF) ?>">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">CEP</label>
                        <input type="text" class="form-control" readonly value="<?= htmlspecialchars($emitente->enderEmit->CEP) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefone</label>
                        <input type="text" class="form-control" readonly value="<?= htmlspecialchars($emitente->enderEmit->fone) ?>">
                    </div>
                </div>
            </form>

            <h3>Resumo da Nota</h3>
            <form>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label class="form-label">Destinatário</label>
                        <input type="text" class="form-control" readonly value="<?= htmlspecialchars($destinatario->xNome) ?>">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Valor Total (R$)</label>
                        <input type="text" class="form-control" readonly value="<?= number_format((float)$total->vNF, 2, ',', '.') ?>">
                    </div>
                </div>
            </form>

            <h3>Produtos</h3>
            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Descrição</th>
                            <th>Quantidade</th>
                            <th>Valor Unitário (R$)</th>
                            <th>Lote</th>
                            <th>Validade</th>
                        </tr>
                    </thead>
                    <tbody><?php
                    foreach ($xml->NFe->infNFe->det as $det) {
                        $produto = $det->prod;

                        $descricao = (string) $produto->xProd;
                        $quantidade = (float) $produto->qCom;
                        $valorUnitario = (float) $produto->vUnCom;

                        $lote = '';
                        $validade = '';

                        if (isset($det->prod->detAdProd)) {
                            $detAdProdStr = (string) $det->prod->detAdProd;
                            if (preg_match('/Lote[:\s]*([\w\d\-]+)/i', $detAdProdStr, $matches)) {
                                $lote = $matches[1];
                            }
                            if (preg_match('/Validade[:\s]*([\d\-\/]+)/i', $detAdProdStr, $matches)) {
                                $validade = $matches[1];
                            }
                        }
                        echo "<tr>";
                        echo "<td><input type='text' class='form-control' readonly value='" . htmlspecialchars($descricao) . "'></td>";
                        echo "<td><input type='text' class='form-control' readonly value='" . $quantidade . "'></td>";
                        echo "<td><input type='text' class='form-control' readonly value='" . number_format($valorUnitario, 2, ',', '.') . "'></td>";
                        echo "<td><input type='text' class='form-control' readonly value='" . htmlspecialchars($lote) . "'></td>";
                        echo "<td><input type='text' class='form-control' readonly value='" . htmlspecialchars($validade) . "'></td>";
                        echo "</tr>";
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <?php
        } catch (Exception $e) {
            echo '<div class="alert alert-danger">Erro ao processar o XML: ' . htmlspecialchars($e->getMessage()) . '</div>';
        }
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
