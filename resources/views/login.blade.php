<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ __('login.title') }}</title>
  <link rel="icon" href="imagens/imagem.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="stylesheet" href="{{ asset('css/login.css') }}">
  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <script src="https://unpkg.com/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>
  <script type="module" src="https://unpkg.com/@splinetool/viewer@1.10.57/build/spline-viewer.js"></script>

</head>

@include('layouts.css-variables')
@yield('styles')

<body>

  @php $current = app()->getLocale(); @endphp
  <div class="lang-selector-container">
    <div class="lang-selector">
      <a href="{{ route('lang.switch', 'pt_BR') }}" class="lang-flag-container pt">
        <img src="{{ asset('images/brazil.png') }}" alt="pt" class="flag">
        <span class="lang-label">Português</span>
      </a>
      <span class="lang-separator">|</span>
      <a href="{{ route('lang.switch', 'en') }}" class="lang-flag-container en">
        <img src="{{ asset('images/us.png') }}" alt="en" class="flag">
        <span class="lang-label">English</span>
      </a>
    </div>
  </div>


  <div class="container" id="container">

    <div class="formulario-container logar">

      <form method="POST" action="{{ route('login') }}" id="loginForm">
        @csrf
        <h1 style="margin-bottom: 20px;">{{ __('login.sign_in') }}</h1>

        <div id="loginMessage" class="card text-bg-danger mb-3 mt-3" style="display:none; max-width: 400px; margin: 0 auto;">
          <div class="card-body d-flex align-items-center gap-2">
            <i class="fas fa-exclamation-circle"></i>
            <span id="loginMessageText"></span>
          </div>
        </div>

        <div class="error-container" id="login-error-container">
        </div>

        <input type="email" id="user_email_login" name="email" placeholder="{{ __('login.email') }}" required autofocus maxlength="80" />
        <span class="email-error" style="color: #c62828; font-size: 12px; display: none;"></span>

        <div class="password-container">
          <input type="password" id="password" name="password" placeholder="{{ __('login.password') }}" required minlength="8" maxlength="20" />
          <i class="toggle-password fas fa-eye" onclick="togglePassword('password', this)"></i>
        </div>

        <div class="password-container">
          <input type="password" name="cartao_seg" id="cartao_seg" placeholder="{{ __('login.card_last_digits') }}" minlength="4" maxlength="4" required pattern="\d{4}" />
          <i class="toggle-password fas fa-eye" onclick="togglePassword('cartao_seg', this)"></i>
        </div>
        <span class="card-error" id="cartao_seg_error"></span>
        <div class="form-check">
          <input type="checkbox" id="lembrar" name="remember" value="1">
          <label for="lembrar">{{ __('login.remember_me') }}</label>
        </div>

        <button onclick="mostrarTelaCarregando()" class="botao-input" type="submit" id="loginSubmitBtn" disabled>{{ __('login.sign_in') }}</button>
        <a href="#" id="senhaVencidaLink">{{ __('login.password_expired') }}</a>
      </form>
    </div>

    <div class="formulario-container registro">
      <form method="POST" action="{{ route('contato.enviar') }}">
        @csrf
        <h1>{{ __('login.contact_us') }}</h1>

        <div class="error-container" id="contato-error-container"></div>

        <input type="text" name="nome" id="nome" placeholder="{{ __('login.your_name') }}" required value="" />
        <div class="error-message" id="nome-error"></div>
        <input type="text" name="empresa" placeholder="{{ __('login.your_company') }}" required value="" />
        <input type="email" name="email" id="user_email_contato" placeholder="{{ __('login.email_for_contact') }}" required value="" />
        <span class="email-error" style="color: #c62828; font-size: 12px; display: none;"></span>

        <input type="tel" name="whatsapp" id="whatsapp" placeholder="{{ __('login.whatsapp') }}" required value="">
        <select name="plano" required class="form-select">
          <option value="" disabled selected>{{ __('login.select_plan') }}</option>
          <option value="Plano Básico">{{ __('login.basic_plan') }}</option>
        </select>

        <button onclick="mostrarTelaCarregando()" class="botao-input" type="submit">{{ __('login.send') }}</button>

      </form>
    </div>

    <div id="toast-contato">
      <strong>
        <i class="fas fa-check-circle" style="margin-right: 8px;"></i>{{ __('login.contact_registered') }}
      </strong>
    </div>

    <div class="container-alternativo">
      <div class="alternativo">
        <div class="painel-alternativo painel-esquerdo">
          <h1>{{ __('login.welcome_back') }}</h1>
          <p>{{ __('login.login_description') }}</p>
          <button class="botao-input hidden" id="entrar">{{ __('login.sign_in') }}</button>
        </div>
        <div class="painel-alternativo painel-direito">
          <h1>{{ __('login.hello') }}</h1>
          <p>{{ __('login.contact_description') }}</p>
          <button class="botao-input hidden" id="registrar">{{ __('login.register') }}</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal hidden-modal" id="modalSenhaVencida">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">

        <div class="modal-body">
          <div class="modal-header">
            <h5 class="modal-title">{{ __('login.contact_argus') }}</h5>
            <button type="button" class="btn-close" onclick="fecharModal()">×</button>
          </div>

          <form method="POST" action="{{ route('user.checkEmail') }}" id="modalSenhaVencidaForm">
            @csrf
            <div class="modal-error-container" id="modal-error-container"></div>

            <div class="mb-3">
              <label for="emailRecuperar" class="form-label">{{ __('login.email') }}</label>
              <input type="email" id="emailRecuperar" placeholder="{{ __('login.example_email') }}" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="cartaoRecuperar" class="form-label">{{ __('login.card_last_digits') }}</label>
              <input type="text" id="cartaoRecuperar" placeholder="0000" name="cartao_seg" class="form-control" minlength="4" maxlength="4" required pattern="\d{4}">
              <span class="card-error" id="cartaoRecuperar_error"></span>
            </div>
            <div class="d-flex justify-content-end gap-2">
              <button type="button" class="btn btn-secondary" onclick="fecharModal()">{{ __('login.cancel') }}</button>
              <button type="submit" class="btn btn-danger" id="modalSubmitBtn" disabled>{{ __('login.send') }}</button>
            </div>
          </form>
        </div>

        <div class="spline-container">
          <spline-viewer url="https://prod.spline.design/WIFTWomq4IIdzwf0/scene.splinecode"></spline-viewer>
        </div>
      </div>
    </div>
  </div>

  <div class="modal-backdrop hidden-modal" id="modalBackdrop"></div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://unpkg.com/vanilla-masker@1.1.1/build/vanilla-masker.min.js"></script>

  @if(session('error'))
  <script>
  document.addEventListener("DOMContentLoaded", function() {
    var msgDiv = document.getElementById('loginMessage');
    var msgText = document.getElementById('loginMessageText');
    msgText.textContent = "{{ session('error') }}";
    msgDiv.style.display = "flex";
  });
  </script>
  @endif

  <script>
  VMasker(document.querySelector("input[name='whatsapp']")).maskPattern("(99) 99999-9999");
  </script>

  <script>
  window.contatoEnviado = <?php echo json_encode(session('contato_enviado', false)); ?>;
  </script>

  <script src="{{ asset('js/login.js') }}"></script>

  @include('layouts.carregamento')
</body>

</html>