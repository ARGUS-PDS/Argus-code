<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <title>Etiquetas para Gôndola</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&display=swap" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">

<style>
  body {
    font-family: Arial, sans-serif;
    padding: 20px;
    background-color: #f8f9fa;
  }

  .etiquetas {
    display: flex;
    flex-wrap: wrap;
    gap: 15px;
    justify-content: center;
  }

  .etiqueta {
    width: 90mm;
    height: 30mm;
    border: 3px solid #212529;
    padding: 10px;
    box-sizing: border-box;
    font-size: 14px;
    background-color: #fff;
    border-radius: 8px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    box-shadow: 0 2px 6px rgb(0 0 0 / 0.1);
    transition: transform 0.2s ease-in-out;
  }

  .etiqueta:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgb(0 0 0 / 0.2);
  }

  .etiqueta h3 {
    margin: 0 0 5px;
    font-size: 16px;
    white-space: normal;
    word-wrap: break-word;
    color: #212529;
  }

  .preco-barcode {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: 5px;
  }

  .preco {
    font-size: 26px;
    font-weight: 700;
    white-space: nowrap;
    color: #198754; 
  }

  .barcode {
    font-family: 'Libre Barcode 39', cursive;
    font-size: 14px;
    line-height: 16px;
    margin-left: 10px;
    max-width: 120px;
    overflow: hidden;
  }

   .image {
    max-height: 20px;
  }

    .back {
    width: 100%;
    padding-bottom: 10px;
    display: flex;
    justify-content: space-between;
  }

@page {
  size: A4;
  margin: 6mm;
}

@media print {
  body, html {
    margin: 0;
    padding: 0;
    width: 210mm;
    height: 297mm;
  }

  form, button, h2, a {
    display: none !important;
  }

  .container {
    width: 200mm !important;
    margin: 0 auto !important;   
    padding: 0 !important;
  }
  .etiquetas {
    display: flex !important;
    flex-wrap: wrap !important;
    gap: 4mm !important;
    width: 200mm !important;
    justify-content: center !important;  
    align-items: flex-start !important;
  }
  .etiqueta {
    flex: 0 0 98mm !important;   
    max-width: 98mm !important;
    height: 38mm !important;
    margin: 0 !important;
    box-sizing: border-box !important;
    border: 2px solid #000 !important;
  }

  .etiqueta h3 {
    margin: 0 !important;
    font-size: 16px !important;
    word-wrap: break-word !important;
  }

  .preco-barcode {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    margin-top: 5px !important;
  }

  .preco {
    font-size: 40px !important;
    font-weight: bold !important;
    white-space: nowrap !important;
  }

  .barcode img {
    height: 22px !important;
    max-width: 120px !important;
    margin-left: 10px !important;
  }

}


</style>

</head>
<body>

<div class="container">
    <a href="{{ url()->previous() }}" class="btn btn-outline-secondary mb-3">
      <i class="bi bi-arrow-left"></i> Voltar
    </a>
  <h2 class="mb-4 text-center">Gera Etiquetas</h2>

  @if(session('error'))
    <div class="alert alert-danger text-center" role="alert">
      {{ session('error') }}
    </div>
  @endif

  <form method="POST" action="{{ route('etiquetas.adicionar') }}" class="row g-3 justify-content-center mb-4">
    @csrf
    <div class="col-auto">
      <label for="codigo" class="col-form-label">Código de Barras (GTIN):</label>
    </div>
    <div class="col-auto">
      <input type="text" name="codigo" id="codigo" class="form-control" required autofocus />
    </div>
    <div class="col-auto">
      <button type="submit" class="btn btn-primary">Adicionar</button>
    </div>
  </form>

  @if(!empty($etiquetas))
    <div class="text-center mb-3">
      <a href="{{ route('etiquetas.limpar') }}" class="btn btn-outline-danger me-2">Limpar</a>
      <button onclick="window.print()" class="btn btn-success">Imprimir</button>
    </div>
  @endif

  <div class="etiquetas">
    @foreach ($etiquetas as $et)
      <div class="etiqueta">
        <h3 title="{{ $et['nome'] }}">{{ $et['nome'] }}</h3>
        <div class="preco-barcode">
          <div class="preco">R$ {{ $et['preco'] }}</div>
          <div class="barcode">
            <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($et['codigo'], 'C128') }}" style="height:20px; max-width:120px;" />
          </div>
        </div>
      </div>
    @endforeach
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>