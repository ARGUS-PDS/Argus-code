<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Novo Interesse - Argus</title>
  <style>
  body {
    font-family: Arial, sans-serif;
    color: #333;
    background: #ffffff;
  }

  .container {
    max-width: 600px;
    margin: 20px auto;
    padding: 20px;
    border: 1px solid #eee;
    border-radius: 8px;
  }

  h1 {
    color: #2b6cb0;
    font-size: 20px;
    margin-bottom: 8px;
  }

  .field {
    margin: 8px 0;
  }

  .label {
    color: #555;
    font-weight: 600;
    display: block;
    margin-bottom: 4px;
  }

  .value {
    color: #111;
  }

  .cta {
    margin-top: 18px;
    padding: 12px;
    background: #490006;
    color: #fff;
    display: inline-block;
    border-radius: 6px;
    text-decoration: none;
  }

  footer {
    width: 100vh;
    margin-top: 18px;
    font-size: 12px;
    color: #777;
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
    <h1>📩 Novo interesse no {{ $plano }}</h1>

    <p>Olá, <strong>Equipe Argus</strong>!</p>
    <p>Um potencial cliente demonstrou interesse no plano <strong>{{ $plano }}</strong>.</p>

    <div class="field">
      <span class="label">Nome</span>
      <div class="value">{{ $nome }}</div>
    </div>

    <div class="field">
      <span class="label">Empresa</span>
      <div class="value">{{ $empresa }}</div>
    </div>

    <div class="field">
      <span class="label">E-mail</span>
      <div class="value">{{ $email }}</div>
    </div>

    <div class="field">
      <span class="label">WhatsApp</span>
      <div class="value">{{ $whatsapp }}</div>
    </div>

    <p style="margin-top:14px;">
      <a class="cta" href="mailto:{{ $email }}">Responder por e-mail</a>
    </p>

    <footer>
      💡 Sugestão: entre em contato dentro de 24h para melhor conversão.<br>
    </footer>
  </div>
</body>

</html>