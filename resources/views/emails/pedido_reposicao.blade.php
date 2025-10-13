<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Pedido de Reposição - Argus</title>
  <style>
  body {
    font-family: Arial, sans-serif;
    color: #333;
    background: #ffffff;
    margin: 0;
    padding: 0;
  }

  .container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #eee;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  }

  h1 {
    color: #2b6cb0;
    font-size: 20px;
    margin-bottom: 8px;
  }

  .field {
    margin: 12px 0;
    padding: 8px 0;
    border-bottom: 1px solid #f0f0f0;
  }

  .label {
    color: #555;
    font-weight: 600;
    display: block;
    margin-bottom: 4px;
  }

  .value {
    color: #111;
    font-size: 15px;
  }

  .alert {
    margin-top: 18px;
    padding: 12px;
    background: #fff8f8;
    border-left: 4px solid #490006;
    border-radius: 4px;
  }

  .alert-title {
    color: #490006;
    font-weight: 600;
    margin-bottom: 6px;
  }

  .priority {
    margin-top: 18px;
    padding: 12px;
    background: #f0f7ff;
    border-left: 4px solid #2b6cb0;
    border-radius: 4px;
  }

  .priority-title {
    color: #2b6cb0;
    font-weight: 600;
    margin-bottom: 6px;
  }

  footer {
    margin-top: 24px;
    font-size: 12px;
    color: #777;
    border-top: 1px solid #eee;
    padding-top: 16px;
  }

  @media only screen and (max-width: 480px) {
    .container {
      margin: 10px;
      padding: 15px;
    }

    footer {
      width: auto !important;
    }
  }
  </style>
</head>

<body>
  <div class="container">
    <h1>📦 Pedido de Reposição</h1>

    <p>Olá, <strong>{{ $fornecedor_nome }}</strong>!</p>
    <p>Gostaríamos de solicitar a reposição do seguinte produto em nosso estoque.</p>

    <div class="field">
      <span class="label">Produto</span>
      <div class="value">{{ $produto_descricao }}</div>
    </div>

    <div class="field">
      <span class="label">Código</span>
      <div class="value">{{ $produto_codigo }}</div>
    </div>

    <div class="field">
      <span class="label">Barcode</span>
      <div class="value">{{ $produto_barcode }}</div>
    </div>

    @if($produto_marca && $produto_marca != 'N/A')
    <div class="field">
      <span class="label">Marca</span>
      <div class="value">{{ $produto_marca }}</div>
    </div>
    @endif

    <div class="field">
      <span class="label">Quantidade Solicitada</span>
      <div class="value" style="font-size: 18px; font-weight: bold; color: #2b6cb0;">{{ $quantidade }} unidades</div>
    </div>

    <div class="field">
      <span class="label">Prazo de Entrega Sugerido</span>
      <div class="value" style="font-weight: bold;">{{ $prazo }}</div>
    </div>

    <div class="priority">
      <div class="priority-title">Informações de Contato</div>
      <div>
        <strong>Responsável:</strong> {{ $nome_usuario }}<br>
        <strong>E-mail:</strong> {{ $email_usuario }}
      </div>
    </div>

    <p style="margin-top:18px;">
      <a href="mailto:{{ $email_usuario }}" style="color: #2b6cb0; text-decoration: none; font-weight: 600;">↳ Responder a este pedido</a>
    </p>

    <footer>
      📧 Este é um pedido de reposição gerado automaticamente pelo sistema Argus.<br>
      <img src="https://i.imgur.com/zPNz2fY.jpeg" alt="Argus" style="margin-top:12px; max-width:150px;">
    </footer>
  </div>
</body>

</html>