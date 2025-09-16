<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login & Registro</title>
  <link rel="icon" href="imagens/imagem.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>
  <script type="module" src="https://unpkg.com/@splinetool/viewer@1.10.57/build/spline-viewer.js"></script>
</head>

@include('layouts.css-variables')
@yield('styles')


<body>
  <div class="container" id="container">
    <!-- Painel de Login -->
    <div class="formulario-container logar">
      <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf
        <h1>Entrar</h1>

        <div class="error-container" id="login-error-container">
        </div>

        <input type="email" id="user_email_login" name="email" placeholder="Email" required autofocus />
        <span class="email-error" style="color: #c62828; font-size: 12px; display: none;"></span>

        <div class="password-container">
          <input type="password" id="password" name="password" placeholder="Senha" required minlength="8" maxlength="8" />
          <i class="toggle-password fas fa-eye" onclick="togglePassword('password', this)"></i>
        </div>

        <div class="password-container">
          <input type="password" name="cartao_seg" id="cartao_seg" placeholder="Final do cartão de segurança" minlength="4" maxlength="4" required pattern="\d{4}" />
          <i class="toggle-password fas fa-eye" onclick="togglePassword('cartao_seg', this)"></i>
        </div>
        <span class="card-error" id="cartao_seg_error"></span>
        <div class="form-check">
          <input type="checkbox" id="lembrar" name="remember" value="1">
          <label for="lembrar">Lembrar de mim</label>
        </div>

        <button onclick="mostrarTelaCarregando()" class="botao-input" type="submit" id="loginSubmitBtn" disabled>Entrar</button>
        <a href="#" id="senhaVencidaLink">Sua senha venceu?</a>
      </form>
    </div>

    <!-- Painel de Registro / Contato -->
    <div class="formulario-container registro">
      <form method="POST" action="{{ route('contato.enviar') }}">
        @csrf
        <h1>Entre em contato</h1>

        <div class="error-container" id="contato-error-container"></div>

        <input type="text" name="nome" id="nome" placeholder="Seu Nome" required value="" />
        <div class="error-message" id="nome-error"></div>
        <input type="text" name="empresa" placeholder="Sua Empresa" required value="" />
        <input type="email" name="email" id="user_email_contato" placeholder="Email para contato" required value="" />
        <span class="email-error" style="color: #c62828; font-size: 12px; display: none;"></span>

        <input type="tel" name="whatsapp" id="whatsapp" placeholder="(00)00000-0000" required value="">
        <button onclick="mostrarTelaCarregando()" class="botao-input" type="submit">Enviar</button>
      </form>
    </div>
    <!-- Toast -->
    <div id="toast-contato">
      <strong>
        <i class="fas fa-check-circle" style="margin-right: 8px;"></i>Contato registrado!
      </strong>
    </div>
    <!-- Painéis alternativos -->
    <div class="container-alternativo">
      <div class="alternativo">
        <div class="painel-alternativo painel-esquerdo">
          <h1>Bem-vindo de volta!</h1>
          <p>Para se manter conectado, faça login com suas informações pessoais.</p>
          <button class="botao-input hidden" id="entrar">Entrar</button>
        </div>
        <div class="painel-alternativo painel-direito">
          <h1>Olá!</h1>
          <p>Entre em contact conosco agora e simplifique sua gestão de estoque de maneira inteligente!</p>
          <button class="botao-input hidden" id="registrar">Registrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Senha Vencida -->
  <div class="modal hidden-modal" id="modalSenhaVencida">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <!-- Conteúdo do formulário -->
        <div class="modal-body">
          <div class="modal-header">
            <h5 class="modal-title">Entrar em contato com a Argus</h5>
            <button type="button" class="btn-close" onclick="fecharModal()">×</button>
          </div>

          <form method="POST" action="{{ route('user.checkEmail') }}" id="modalSenhaVencidaForm">
            @csrf
            <div class="modal-error-container" id="modal-error-container"></div>

            <div class="mb-3">
              <label for="emailRecuperar" class="form-label">E-mail</label>
              <input type="email" id="emailRecuperar" placeholder="exemplo@dominio.com" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="cartaoRecuperar" class="form-label">Final do Cartão de Segurança</label>
              <input type="text" id="cartaoRecuperar" placeholder="0000" name="cartao_seg" class="form-control" minlength="4" maxlength="4" required pattern="\d{4}">
              <span class="card-error" id="cartaoRecuperar_error"></span>
            </div>
            <div class="d-flex justify-content-end gap-2">
              <button type="button" class="btn btn-secondary" onclick="fecharModal()">Cancelar</button>
              <button type="submit" class="btn btn-danger" id="modalSubmitBtn" disabled>Enviar</button>
            </div>
          </form>
        </div>

        <!-- Container para o robô 3D -->
        <div class="spline-container">
          <spline-viewer url="https://prod.spline.design/WIFTWomq4IIdzwf0/scene.splinecode"></spline-viewer>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-backdrop hidden-modal" id="modalBackdrop"></div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>

  <script>
  VMasker(document.querySelector("input[name='whatsapp']")).maskPattern("(99) 99999-9999");
  </script>

  <script>
  window.contatoEnviado = <?php echo json_encode(session('contato_enviado', false)); ?>;
  </script>

  <script src="{{ asset('js/particulas.js') }}"></script>
  <script src="{{ asset('js/login.js') }}"></script>

  @include('layouts.carregamento')
</body>

</html>