<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Argus</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  @include('layouts.css-variables')

  <style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
  }

  .navbar {
    z-index: 1070;
  }

  .navbar-logo{
    box-shadow: 0 10px 25px var(--color-shadow);
  }

  .navbar-nav .dropdown-menu {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    z-index: 1021;
    min-width: 200px;
    background-color: var(--color-bege-claro);
    border: none;
    box-shadow: 0 10px 25px var(--color-shadow);
    border-radius: 12px;
    padding: 0.75rem;
    margin-top: 0;
  }

  .navbar-nav .dropdown-menu.show {
    display: block;
  }

  .navbar-nav .dropdown-item {
    color: var(--color-gray-escuro);
    font-weight: 500;
    padding: 0.6rem 1rem;
    border-radius: 8px;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .lang-btn {
    color: var(--color-gray-escuro);
    font-weight: 500;
    padding: 0.4rem 0.7rem;
    border-radius: 16px;
    transition: all 0.2s ease;
    text-decoration: none;
  }

  .navbar-nav .dropdown-item:hover,
  .navbar-nav .dropdown-item:focus,
  .lang-btn:hover,
  .lang-btn:focus,
  .lang-switch .dropdown-item:hover,
  .lang-switch .dropdown-item:focus {
    background-color: var(--color-vinho-fundo) !important;
    color: var(--color-vinho) !important;
    transform: translateX(4px);
  }

  .user-menu-panel {
    z-index: 2000;
  }

  .user-menu-panel .d-flex {
    align-items: center;
    justify-content: center;
  }

  @media (max-width: 991.98px) {

    .navbar-nav .dropdown-menu,
    .lang-switch .dropdown-menu {
      position: static;
      float: none;
      width: auto;
      margin-top: 0;
      background-color: var(--color-bege-claro);
      border: 0;
      box-shadow: none;
    }
  }

  .lang-switch .dropdown-menu {
    display: none !important;
    position: absolute !important;
    top: 100% !important;
    right: 0 !important;
    z-index: 1022 !important;
    min-width: 200px !important;
    background-color: var(--color-bege-claro) !important;
    border: none !important;
    box-shadow: 0 10px 25px var(--color-shadow) !important;
    border-radius: 12px !important;
    padding: 0.75rem !important;
    margin-top: 0 !important;
  }

  .lang-switch .dropdown-menu.show {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
  }

  .lang-switch .dropdown-menu.show,
  .lang-switch .dropdown.show .dropdown-menu {
    display: block !important;
    visibility: visible !important;
    opacity: 1 !important;
    position: absolute !important;
    top: 100% !important;
    right: 0 !important;
    z-index: 1022 !important;
    pointer-events: auto !important;
  }

  .toggle-switch {
    position: relative;
    width: 40px;
    height: 20px;
  }

  .toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
  }

  .slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: var(--color-bege-claro);
    transition: 0.4s;
    border-radius: 20px;
  }

  .slider:before {
    position: absolute;
    content: "";
    height: 14px;
    width: 14px;
    left: 2px;
    bottom: 3px;
    background-color: var(--color-vinho);
    transition: 0.4s;
    border-radius: 50%;
  }

  input:checked+.slider {
    background-color: var(--color-bege-claro);
  }

  input:checked+.slider:before {
    transform: translateX(20px);
  }

  .change-password {
    color: var(--color-bege-claro) !important;
    padding-top: 20px;
    font-size: 1.1rem;
    text-decoration: none;
    background: none;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    border-radius: 50px;
  }

  .change-password i {
    color: var(--color-bege-claro) !important;
  }

  .change-password:hover,
  .toggle-switch {
    transform: translateY(-2px);
  }

  #modalAlterarSenha {
    z-index: 1060;
  }

  #modalAlterarSenha .modal-dialog {
    max-width: 800px;
    width: 90%;
    margin: 100px auto;
    display: flex;
    align-items: center;
  }

  #modalAlterarSenha .modal-content {
    background: var(--color-bege-claro);
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 10px 30px var(--color-shadow);
    border: none;
    transform: scale(0.9);
    transition: transform 0.3s ease;
    display: flex;
    width: 100%;
  }

  #modalAlterarSenha.show .modal-content {
    transform: translateY(0) scale(1);
  }

  #modalAlterarSenha .modal-header {
    background: linear-gradient(to right, #490006, #773138);
    color: #fff;
    border-bottom: none;
    padding: 15px 20px;
    position: relative;
    margin-bottom: 24px;
    z-index: 1061;
  }

  #modalAlterarSenha .modal-title {
    color: #fff;
    font-weight: 600;
    font-size: 18px;
  }

  #modalAlterarSenha .btn-close {
    filter: invert(1);
    opacity: 0.8;
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    font-size: 24px;
    border: none;
    color: white;
    cursor: pointer;
  }

  #modalAlterarSenha .btn-close:hover {
    opacity: 1;
  }

  #modalAlterarSenha .modal-body {
    padding: 25px;
    flex: 1;
  }

  #modalAlterarSenha .form-label {
    font-weight: 600;
    color: #490006;
    margin-bottom: 10px;
    display: block;
    font-size: 1rem;
  }

  #modalAlterarSenha .form-control {
    background-color: #fff;
    border: 2px solid #ddd;
    padding: 14px 16px;
    font-size: 16px;
    border-radius: 10px;
    width: 100%;
    outline: none;
    transition: all 0.3s ease;
    margin-bottom: 20px;
    box-shadow: 0 4px 10px rgba(73, 0, 6, 0.08);
  }

  #modalAlterarSenha .form-control:focus {
    outline: none;
    border-color: #490006;
    box-shadow: 0 0 0 3px rgba(73, 0, 6, 0.25), 0 5px 15px rgba(73, 0, 6, 0.15);
    transform: translateY(-2px);
  }

  #modalAlterarSenha .form-control.is-valid {
    border-color: #2e7d32;
    box-shadow: 0 0 0 3px rgba(46, 125, 50, 0.2);
  }

  #modalAlterarSenha .form-control.is-invalid {
    border-color: #c62828;
    box-shadow: 0 0 0 3px rgba(198, 40, 40, 0.2);
  }

  #modalAlterarSenha .btn-custom {
    border-radius: 10px;
    padding: 12px 24px;
    font-weight: 600;
    transition: all 0.3s ease;
    font-size: 16px;
  }

  #modalAlterarSenha .btn-secondary {
    background-color: #6c757d;
    border: none;
    color: white;
  }

  #modalAlterarSenha .btn-secondary:hover {
    background-color: #5a6268;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
  }

  #modalAlterarSenha .btn-primary {
    background: linear-gradient(to right, #490006, #773138);
    border: none;
    color: white;
  }

  #modalAlterarSenha .btn-primary:hover {
    background: linear-gradient(to right, #3a0004, #662a30);
    transform: translateY(-2px);
    box-shadow: 0 6px 12px rgba(73, 0, 6, 0.25);
  }

  #modalAlterarSenha .btn-primary:disabled {
    background: #cccccc;
    transform: none;
    cursor: not-allowed;
    box-shadow: none;
  }

  .password-container {
    position: relative;
  }

  .password-container input {
    padding-right: 100px;
    transition: padding-right 0.3s ease;
  }

  .toggle-password,
  .generate-password,
  .validation-icon {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #555;
    z-index: 5;
    transition: right 0.3s ease, opacity 0.3s ease;
    font-size: 18px;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background-color: rgba(255, 255, 255, 0.8);
  }

  .toggle-password:hover,
  .generate-password:hover {
    color: #490006;
    background-color: rgba(73, 0, 6, 0.1);
  }

  .toggle-password {
    right: 15px;
  }

  .generate-password {
    right: 45px;
  }

  .validation-icon {
    right: 15px;
    opacity: 0;
    pointer-events: none;
  }

  .password-container.validating .toggle-password {
    right: 45px;
  }

  .password-container.validating .generate-password {
    right: 75px;
  }

  .password-container.validating .validation-icon {
    right: 15px;
    opacity: 1;
  }

  .password-container.single-icon input {
    padding-right: 45px;
  }

  .password-container.single-icon .toggle-password {
    right: 15px;
  }

  .password-strength {
    margin-top: 8px;
  }

  .progress {
    height: 10px;
    border-radius: 5px;
    background-color: #eee;
    box-shadow: inset 0 1px 2px var(--color-shadow);
  }

  .progress-bar {
    transition: width 0.3s ease;
    border-radius: 5px;
  }

  .password-feedback {
    font-size: 0.9rem;
    margin-top: 8px;
    color: #333;
    font-weight: 500;
  }

  .password-requirements {
    margin-top: 15px;
    font-size: 0.85rem;
    background-color: rgba(73, 0, 6, 0.05);
    padding: 12px 15px;
    border-radius: 8px;
    border-left: 4px solid #490006;
  }

  .requirement {
    display: flex;
    align-items: center;
    margin-bottom: 6px;
  }

  .requirement.valid {
    color: #2e7d32;
  }

  .requirement.invalid {
    color: #757575;
  }

  .requirement i {
    margin-right: 8px;
    font-size: 14px;
  }

  .password-match-feedback {
    font-size: 0.85rem;
    margin-top: 8px;
    padding: 8px 12px;
    border-radius: 6px;
    display: none;
    font-weight: 500;
  }

  .password-match-feedback.valid {
    background-color: rgba(46, 125, 50, 0.1);
    color: #2e7d32;
    display: block;
    border-left: 3px solid #2e7d32;
  }

  .password-match-feedback.invalid {
    background-color: rgba(198, 40, 40, 0.1);
    color: #c62828;
    display: block;
    border-left: 3px solid #c62828;
  }

  .password-toast {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    min-width: 300px;
    background: white;
    border-left: 5px solid #28a745;
    border-radius: 8px;
    box-shadow: 0 4px 20px var(--color-shadow);
    padding: 16px;
    display: flex;
    align-items: center;
    transform: translateX(400px);
    opacity: 0;
    transition: transform 0.4s ease, opacity 0.4s ease;
  }

  .password-toast.show {
    transform: translateX(0);
    opacity: 1;
  }

  .toast-icon {
    font-size: 24px;
    color: #28a745;
    margin-right: 12px;
  }

  .toast-content {
    flex: 1;
  }

  .toast-title {
    font-weight: 600;
    color: var(--color-gray-escuro);
    margin-bottom: 4px;
  }

  .toast-message {
    color: #6c757d;
    font-size: 14px;
  }

  .toast-close {
    background: none;
    border: none;
    font-size: 18px;
    color: #6c757d;
    cursor: pointer;
    margin-left: 10px;
  }

  .form-text {
    color: #666;
    font-size: 0.85rem;
    margin-top: 8px;
  }

  #modalAlterarSenha .password-feedback {
    font-weight: 600;
    color: #222;
  }

  #modalAlterarSenha .progress-bar.bg-danger {
    background-color: #b71c1c !important;
  }

  #modalAlterarSenha .progress-bar.bg-warning {
    background-color: #f57f17 !important;
  }

  #modalAlterarSenha .progress-bar.bg-success {
    background-color: #2e7d32 !important;
  }

  #modalAlterarSenha .password-feedback.weak {
    color: #b71c1c;
  }

  #modalAlterarSenha .password-feedback.medium {
    color: #f57f17;
  }

  #modalAlterarSenha .password-feedback.strong {
    color: #2e7d32;
  }

  body.modal-open {
    overflow: hidden;
  }

  .modal-backdrop-blur {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    backdrop-filter: blur(10px);
    background-color: rgba(73, 0, 6, 0.7);
    z-index: 1060;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
  }

  .modal-backdrop-blur.show {
    opacity: 1;
    visibility: visible;
  }

  @media (max-width: 992px) {
    #modalAlterarSenha .modal-dialog {
      max-width: 500px;
      margin-top: 120px;
    }
  }

  @media (max-width: 768px) {
    #modalAlterarSenha .modal-dialog {
      margin: 20px;
    }

    #modalAlterarSenha .d-flex {
      flex-direction: column;
      gap: 10px;
    }

    #modalAlterarSenha .btn {
      width: 100%;
    }
  }
  </style>

  @yield('styles')
</head>

<body>
  {{-- Modal de mensagens globais --}}
  @include('components.alert-modal')

  <nav class="navbar navbar-expand-lg navbar-dark navbar-logo">
    <div class="container-fluid">
      <a class="navbar-brand" href="/dashboard" onclick="mostrarTelaCarregando()">
        <img src="{{ asset('images/logo.png') }}" alt="{{ __('menu.argus') }}">
      </a>

      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav me-auto mb-2 mb-lg-0">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('menu.cadastros') }}</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/lista-produtos" onclick="mostrarTelaCarregando()">{{ __('menu.produtos') }}</a></li>
              <li><a class="dropdown-item" href="/lista-fornecedores" onclick="mostrarTelaCarregando()">{{ __('menu.fornecedores') }}</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('menu.estoque') }}</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/entrada-saida" onclick="mostrarTelaCarregando()">{{ __('menu.controle_estoque') }}</a></li>
              <li><a class="dropdown-item" href="/acompanhamento-validade" onclick="mostrarTelaCarregando()">{{ __('menu.acompanhamento_validade') }}</a></li>
              <li><a class="dropdown-item" href="/etiquetas" onclick="mostrarTelaCarregando()">{{ __('menu.etiquetas') }}</a></li>
              <li><a class="dropdown-item" href="/detalhamento-lote" onclick="mostrarTelaCarregando()">{{ __('menu.detalhamento_lote') }}</a></li>
              <li><a class="dropdown-item" href="/vendas" onclick="mostrarTelaCarregando()">{{ __('menu.frente_caixa') }}</a></li>
            </ul>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('menu.pedidos') }}</a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="/alerta-estoque" onclick="mostrarTelaCarregando()">{{ __('menu.envio_pedido') }}</a></li>
              <!--<li><a class="dropdown-item" href="#" onclick="mostrarTelaCarregando()">*{{ __('menu.cotacao_fornecedores') }}</a></li> -->
              <li><a class="dropdown-item" href="/pedidos-enviados" onclick="mostrarTelaCarregando()">{{ __('menu.historico_pedidos') }}</a></li>
            </ul>
          </li>
        </ul>

        <div class="navbar-right-items">
          <div class="user-info position-relative">
            <button title="{{ __('menu.meu_perfil') }}" id="userMenuBtn" class="btn btn-user-menu d-flex align-items-center" type="button">
              @if(Auth::user() && Auth::user()->profile_photo_url)
              <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ __('menu.foto_perfil') }}" class="profile-pic-avatar" style="width: 32px; height: 32px; object-fit: cover; border-radius: 50%;">
              @else
              <i class="bi bi-person-circle"></i>
              @endif
              <span class="ms-2">{{ Auth::user() ? Auth::user()->name : __('menu.usuario') }}</span>
            </button>
            <div id="userMenuPanel" class="user-menu-panel shadow text-center">
              <form id="profilePicForm" action="{{ route('profile.upload-photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="file" name="profile_photo_url" id="profilePicInput" accept="image/*" style="display:none" onchange="document.getElementById('profilePicForm').submit(); mostrarTelaCarregando();">
                <label for="profilePicInput" style="cursor:pointer; display:inline-block; margin-top: 12px;">
                  @if(Auth::user() && Auth::user()->profile_photo_url)
                  <img id="profilePicImg" src="{{ Auth::user()->profile_photo_url }}" alt="{{ __('menu.foto_perfil') }}" class="profile-pic-avatar">
                  @else
                  <span id="profilePicImg" class="profile-pic-avatar d-flex align-items-center justify-content-center">
                    <i class="bi bi-person-circle"></i>
                  </span>
                  @endif
                </label>
              </form>
              <div class="mt-3 fw-bold" style="font-size: 20px; color: var(--color-bege-claro);">{{ __('menu.ola_usuario', ['name' => Auth::user() ? Auth::user()->name : __('menu.usuario')]) }}</div>

              <a href="#" class="change-password d-block align-items-center gap-2 mt-3" data-bs-toggle="modal" data-bs-target="#modalAlterarSenha" onclick="document.getElementById('userMenuPanel').style.display = 'none';">
                <i class="bi bi-key-fill nav-icon" style="font-size: 1.5rem; color: var(--color-bege-claro);"></i>
                <span style="color: var(--color-bege-claro);">{{ __('menu.alterar_senha') }}</span>
              </a>

              <div class="d-flex align-items-center gap-2 mt-3">
                <span style="color: var(--color-bege-claro); font-size: 1.1rem;">{{ __('menu.darkmode')}}</span>
                <label class="toggle-switch mb-0">
                  <input type="checkbox" id="darkModeToggle" onchange="toggleDarkMode(this)">
                  <span class="slider"></span>
                </label>
              </div>

              <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout-container mt-3">
                  <i class="bi bi-box-arrow-right nav-icon"></i>
                  <span>{{ __('menu.sair') }}</span>
                </button>
              </form>
            </div>
          </div>
          <div class="d-flex gap-2 align-items-center">
            @php $current = app()->getLocale(); @endphp

            <div class="dropdown lang-switch">
              <button class="btn lang-btn dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="lang-flag" src="{{ asset($current == 'en' ? 'images/us.png' : 'images/brazil.png') }}" width="20" alt="flag">
                <span class="lang-label">
                  {{ $current == 'en' ? 'English' : 'Português' }}
                </span>
                <i class="bi bi-caret-down-fill"></i>
              </button>

              <ul class="dropdown-menu dropdown-menu-end">
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('lang.switch', 'pt_BR') }}">
                    <img src="{{ asset('images/brazil.png') }}" width="20" alt="pt"> Português
                  </a>
                </li>
                <li>
                  <a class="dropdown-item d-flex align-items-center gap-2" href="{{ route('lang.switch', 'en') }}">
                    <img src="{{ asset('images/us.png') }}" width="20" alt="en"> English
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <main class="main-content">
    @yield('content')
  </main>

  <!-- Efeito de blur no fundo -->
  <div class="modal-backdrop-blur" id="modalBackdrop"></div>

  <!-- Toast de sucesso para senha gerada -->
  <div class="password-toast" id="passwordSuccessToast">
    <i class="bi bi-check-circle-fill toast-icon"></i>
    <div class="toast-content">
      <div class="toast-title">Sucesso!</div>
      <div class="toast-message" id="toastMessage">Senha forte gerada com sucesso!</div>
    </div>
    <button class="toast-close" onclick="hideToast()">
      <i class="bi bi-x"></i>
    </button>
  </div>

  <!-- Modal de Alterar Senha -->
  <div class="modal fade" id="modalAlterarSenha" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title fw-bold">Alterar Senha</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="formAlterarSenha" action="{{ route('change-password') }}" method="POST">
            @csrf
            <div class="mb-3">
              <label class="form-label">Senha Atual</label>
              <div class="password-container single-icon position-relative">
                <input type="password" name="current_password" class="form-control"  maxlength="20" required>
                <i class="bi bi-eye toggle-password" onclick="togglePassword(this)"></i>
              </div>
            </div>

            <div class="mb-3">
              <label class="form-label">Nova Senha</label>
              <div class="password-container position-relative" id="newPasswordContainer">
                <input type="password" name="new_password" id="new_password" class="form-control" required minlength="8" maxlength="20" oninput="checkPasswordStrength()">
                <i class="bi bi-eye toggle-password" onclick="togglePassword(this)"></i>
                <button type="button" class="generate-password" title="Gerar senha forte" onclick="generateStrongPassword()">
                  <i class="bi bi-arrow-repeat"></i>
                </button>
                <span class="validation-icon" id="new_password_validation"></span>
              </div>
              <div class="password-strength">
                <div class="progress">
                  <div class="progress-bar" role="progressbar" style="width: 0%" id="passwordStrengthBar"></div>
                </div>
                <div class="password-feedback" id="passwordFeedback">Força da senha: muito fraca</div>
              </div>
              <div class="password-requirements">
                <div class="requirement invalid" id="lengthReq"><i class="bi bi-x-circle"></i><span>Mínimo de 8 caracteres</span></div>
                <div class="requirement invalid" id="uppercaseReq"><i class="bi bi-x-circle"></i><span>Pelo menos uma letra maiúscula</span></div>
                <div class="requirement invalid" id="lowercaseReq"><i class="bi bi-x-circle"></i><span>Pelo menos uma letra minúscula</span></div>
                <div class="requirement invalid" id="numberReq"><i class="bi bi-x-circle"></i><span>Pelo menos um número</span></div>
                <div class="requirement invalid" id="specialReq"><i class="bi bi-x-circle"></i><span>Pelo menos um caractere especial (!@#$%^&* etc.)</span></div>
              </div>
              <small id="passwordHelp" class="form-text text-muted">A senha deve atender a todos os requisitos acima</small>
            </div>

            <div class="mb-3">
              <label class="form-label">Confirmar Nova Senha</label>
              <div class="password-container position-relative" id="confirmPasswordContainer">
                <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required minlength="8" maxlength="20" oninput="checkPasswordMatch()">
                <i class="bi bi-eye toggle-password" onclick="togglePassword(this)"></i>
                <span class="validation-icon" id="confirm_password_validation"></span>
              </div>
              <div class="password-match-feedback invalid" id="passwordMatchFeedback">As senhas não coincidem</div>
            </div>

            <div class="d-flex justify-content-end gap-2">
              <button type="button" class="btn btn-secondary btn-custom" data-bs-dismiss="modal">Cancelar</button>
              <button type="submit" class="btn btn-primary btn-custom" id="submitButton" disabled>Salvar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/app-js/app.js') }}"></script>
  <script src="{{ asset('js/app-js/password.js') }}"></script>

  <script>
  function toggleDarkMode(checkbox) {
    if (checkbox.checked) {
      document.body.classList.add('dark-mode');
      localStorage.setItem('darkMode', 'true');
    } else {
      document.body.classList.remove('dark-mode');
      localStorage.setItem('darkMode', 'false');
    }
  }

  window.addEventListener('DOMContentLoaded', () => {
    const darkMode = localStorage.getItem('darkMode') === 'true';
    const toggle = document.getElementById('darkModeToggle');
    toggle.checked = darkMode;
    toggleDarkMode(toggle);
  });
  </script>

  @yield('scripts')
  @include('layouts.carregamento')
</body>

</html>