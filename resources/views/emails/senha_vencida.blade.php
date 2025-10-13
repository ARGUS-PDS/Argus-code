<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Solicitação de Recuperação de Senha - Argus</title>
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
    <h1>🔐 Solicitação de Recuperação de Senha</h1>

    <p>Olá, <strong>Equipe Argus</strong>!</p>
    <p>Um usuário solicitou a recuperação de senha através do sistema.</p>

    <div class="field">
      <span class="label">Data e Hora da Solicitação</span>
      <div class="value">{{ $data_solicitacao }}</div>
    </div>

    <div class="field">
      <span class="label">E-mail do Solicitante</span>
      <div class="value">{{ $email }}</div>
    </div>

    <div class="field">
      <span class="label">Últimos 4 Dígitos do Cartão</span>
      <div class="value">{{ $cartao_seg }}</div>
    </div>

    <div class="alert">
      <div class="alert-title">Ação Necessária</div>
      <div>Entre em contato com o usuário para validar a identidade e proceder com a recuperação de senha.</div>
    </div>

    <div class="priority">
      <div class="priority-title">Prioridade</div>
      <div>Recomenda-se responder em até 24 horas para manter a satisfação do cliente.</div>
    </div>

    <p style="margin-top:18px;">
      <a href="mailto:{{ $email }}" style="color: #2b6cb0; text-decoration: none; font-weight: 600;">↳ Responder por e-mail</a>
    </p>

    <footer>
      🔒 Esta é uma solicitação de recuperação de senha gerada automaticamente pelo sistema.<br>
    </footer>
  </div>
</body>

</html>