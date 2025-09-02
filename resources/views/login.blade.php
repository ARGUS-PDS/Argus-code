<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login & Registro</title>
  <link rel="stylesheet" href="style.css" />
  <link rel="icon" href="imagens/imagem.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
</head>


@include('layouts.css-variables')
@yield('styles')

<body>
  <div class="container" id="container">
    <!-- Painel de Login -->
    <div class="formulario-container logar">
      <form method="POST" action="/login">
        @csrf
        <h1>Entrar</h1>

        <div class="error-container" id="login-error-container">
          @error('email')
          <div class="alert alert-danger">{{ $message }}</div>
          @enderror
          @error('cartao_seg')
          <div class="alert alert-danger">{{ $message }}</div>
          @enderror
        </div>

        <input type="email" id="user_email_login" name="email" placeholder="Email" required autofocus />
        <span class="email-error" style="color: #c62828; font-size: 12px; display: none;"></span>

        <div class="password-container">
          <input type="password" id="password" name="password" placeholder="Senha" required minlength="8" />
          <i class="toggle-password fas fa-eye" onclick="togglePassword('password', this)"></i>
        </div>

        <div class="password-container">
          <input type="password" name="cartao_seg" id="cartao_seg" placeholder="Final do cartão de segurança" required pattern="\d{4}" />
          <i class="toggle-password fas fa-eye" onclick="togglePassword('cartao_seg', this)"></i>
        </div>

        <a href="#" onclick="abrirModal()">Sua senha venceu?</a>
        <button onclick="mostrarTelaCarregando()" class="botao-input" type="submit">Entrar</button>
      </form>
    </div>

    <!-- Painel de Registro / Contato -->
    <div class="formulario-container registro">
      <form method="POST" action="{{ route('contato.enviar') }}">
        @csrf
        <h1>Entre em contato</h1>

        <div class="error-container" id="contato-error-container"></div>

        <input type="text" name="nome" placeholder="Seu Nome" required value="" />
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
          <p>Entre em contato conosco agora e simplifique sua gestão de estoque de maneira inteligente!</p>
          <button class="botao-input hidden" id="registrar">Registrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal de Suporte -->
  <div id="modal-suporte" class="modal" style="display: {{ $errors->any() && old('email') ? 'flex' : (session('contato_enviado') ? 'flex' : 'none') }}">
    <div class="modal-content formulario-container">
      <span class="close" onclick="fecharModal()">&times;</span>
      <h2>Solicitar Suporte</h2>
      <form method="POST" action="{{ route('senha.vencida') }}">
        <div class="error-container">
          @if(session('contato_enviado'))
          <div class="alert alert-success">Solicitação enviada com sucesso!</div>
          @endif
          @if ($errors->suporte->any())
          @foreach ($errors->suporte->all() as $error)
          <div class="alert alert-danger">{{ $error }}</div>
          @endforeach
          @endif
        </div>
        @csrf
        <input type="email" name="email" placeholder="Seu Email" required>
        <input type="text" name="cartao_seg" placeholder="Final do cartão de segurança" required pattern="\d{4}">
        <button class="botao-input" type="submit">Enviar</button>
      </form>
    </div>
  </div>


  <script>
  @if($errors - > suporte - > any() || session('contato_enviado'))
  document.getElementById("modal-suporte").style.display = "flex";
  @endif
  </script>


  <script src="https://unpkg.com/vanilla-masker/build/vanilla-masker.min.js"></script>

  <script>
  VMasker(document.querySelector("input[name='whatsapp']")).maskPattern("(99) 99999-9999");
  </script>

  <script>
  window.contatoEnviado = <?php echo json_encode(session('contato_enviado', false)); ?>;
  </script>

  <script>
  @if($errors -> suporte -> any() || session('contato_enviado'))
  document.getElementById("modal-suporte").style.display = "flex";
  @endif
  </script>

  <script>
  function abrirModal() {
    document.getElementById("modal-suporte").style.display = "flex";
  }

  function fecharModal() {
    document.getElementById("modal-suporte").style.display = "none";
  }


  window.onclick = function(event) {
    let modal = document.getElementById("modal-suporte");
    if (event.target == modal) {
      fecharModal();
    }
  }
  </script>

  <script src="{{ asset('js/login.js') }}"></script>

  @include('layouts.carregamento')
</body>

</html>