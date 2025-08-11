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
    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard" onclick="mostrarTelaCarregando()">
                <img src="{{ asset('images/logo.png') }}" alt="Argus">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('menu.cadastros') }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/lista-produtos" onclick="mostrarTelaCarregando()">{{__('menu.produtos')}}</a></li>
                            <li><a class="dropdown-item" href="/lista-fornecedores" onclick="mostrarTelaCarregando()">{{__('menu.fornecedores')}}</a></li>
                            <li><a class="dropdown-item" href="/cadastrar-funcionario" onclick="mostrarTelaCarregando()">{{__('menu.funcionarios')}}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('menu.estoque') }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/entrada-saida" onclick="mostrarTelaCarregando()">{{ __('menu.controle_estoque') }}</a></li>
                            <li><a class="dropdown-item" href="#" onclick="mostrarTelaCarregando()">{{ __('menu.acompanhamento_validade') }}</a></li>
                            <li><a class="dropdown-item" href="/etiquetas" onclick="mostrarTelaCarregando()">{{ __('menu.etiquetas') }}</a></li>
                            <li><a class="dropdown-item" href="/detalhamento-lote" onclick="mostrarTelaCarregando()">{{ __('menu.detalhamento_lote') }}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('menu.pedidos') }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/alerta-estoque" onclick="mostrarTelaCarregando()">{{ __('menu.envio_pedido') }}</a></li>
                            <li><a class="dropdown-item" href="#" onclick="mostrarTelaCarregando()">{{ __('menu.cotacao_fornecedores') }}</a></li>
                            <li><a class="dropdown-item" href="/pedidos-enviados" onclick="mostrarTelaCarregando()">{{ __('menu.historico_pedidos') }}</a></li>
                        </ul>
                    </li>
                </ul>
                
                <div class="navbar-right-items">
                    <a href="#"><i class="bi bi-info-circle-fill nav-icon"></i></a>
                    <div class="user-info position-relative">
                        <button title="Meu perfil" id="userMenuBtn" class="btn btn-user-menu d-flex align-items-center" type="button">
                            @if(Auth::user() && Auth::user()->profile_photo_url)
                                <img src="{{ Auth::user()->profile_photo_url }}"
                                    alt="Foto de perfil"
                                    class="profile-pic-avatar"
                                    style="width: 32px; height: 32px; object-fit: cover; border-radius: 50%;">
                            @else
                                <i class="bi bi-person-circle"></i>
                            @endif
                            <span class="ms-2">{{ Auth::user() ? Auth::user()->name : 'Usuário' }}</span>
                        </button>
                        <div id="userMenuPanel" class="user-menu-panel shadow text-center">
                            <form id="profilePicForm" enctype="multipart/form-data">
                                <input type="file" id="profilePicInput" accept="image/*" style="display:none">
                                <label for="profilePicInput" style="cursor:pointer; display:inline-block; margin-top: 12px;">
                                    @if(Auth::user() && Auth::user()->profile_photo_url)
                                        <img id="profilePicImg"
                                            src="{{ Auth::user()->profile_photo_url }}"
                                            alt="Foto de perfil"
                                            class="profile-pic-avatar">
                                    @else
                                        <span id="profilePicImg" class="profile-pic-avatar d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-circle"></i>
                                        </span>
                                    @endif
                                </label>
                            </form>
                            <div class="mt-3 fw-bold" style="font-size: 20px; color: var(--color-bege-claro);">Olá, {{ Auth::user() ? Auth::user()->name : 'Usuário' }}</div>
                            <a href="{{ route('logout') }}"
                                class="logout-container d-inline-flex align-items-center gap-2 mt-3"
                                style="color: var(--color-bege-claro); font-weight: bold; font-size: 1.1rem; text-decoration: none; background: none; border: none; cursor: pointer;"
                                title="Sair"
                                onclick="event.preventDefault(); mostrarTelaCarregando(); document.getElementById('logout-form').submit();">
                                <i class="bi bi-box-arrow-right nav-icon" style="font-size: 1.5rem; color: var(--color-bege-claro);"></i>
                                <span style="color: var(--color-bege-claro);">Sair</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                        @php $current = app()->getLocale(); @endphp

                        <div class="dropdown lang-switch">
                            <button class="btn lang-btn dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="lang-flag"
                                    src="{{ asset($current == 'pt_BR' ? 'images/brazil.png' : 'images/us.png') }}"
                                    width="20" alt="flag">

                                <span class="lang-label">
                                    {{ $current == 'pt_BR' ? 'Português' : 'English' }}
                                </span>

                                <i class="bi bi-caret-down-fill"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                    href="{{ route('lang.switch', 'pt_BR') }}">
                                        <img src="{{ asset('images/brazil.png') }}" width="20" alt="pt"> Português
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                    href="{{ route('lang.switch', 'en') }}">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @include('layouts.carregamento')
</body>
</html>