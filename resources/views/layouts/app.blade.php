<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Argus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
    <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    @include('layouts.css-variables')
    
    <style>
        .navbar-nav .dropdown-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            min-width: 200px;
            background-color: var(--color-bege-claro);
            border: none;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            border-radius: 12px;
            padding: 0.75rem;
            margin-top: 0;
        }
        
        .navbar-nav .dropdown-menu.show {
            display: block;
        }
        
        .navbar-nav .dropdown-item{
            color: var(--color-gray-escuro);
            font-weight: 500;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .lang-btn{
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
        .lang-switch .dropdown-item:focus  {
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
            z-index: 99999 !important;
            min-width: 200px !important;
            background-color: var(--color-bege-claro) !important;
            border: none !important;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
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
            z-index: 99999 !important;
            pointer-events: auto !important;
        }

        
        /* Toggle Switch */
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
            top: 0; left: 0; right: 0; bottom: 0;
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

        input:checked + .slider {
            background-color: var(--color-bege-claro);
        }

        input:checked + .slider:before {
            transform: translateX(20px);
        }
        
        .change-password{
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

        .change-password:hover, .toggle-switch {
            transform: translateY(-2px);
        }
    </style>
    
    @yield('styles')
</head>

<body>
    {{-- Modal de mensagens globais --}}
    @include('components.alert-modal')

    <nav class="navbar navbar-expand-lg navbar-dark">
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
                            <!-- <li><a class="dropdown-item" href="/cadastrar-funcionario" onclick="mostrarTelaCarregando()">{{ __('menu.funcionarios') }}</a></li> -->
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
                            <li><a class="dropdown-item" href="#" onclick="mostrarTelaCarregando()">{{ __('menu.cotacao_fornecedores') }}</a></li>
                            <li><a class="dropdown-item" href="/pedidos-enviados" onclick="mostrarTelaCarregando()">{{ __('menu.historico_pedidos') }}</a></li>
                        </ul>
                    </li>
                </ul>
                
                <div class="navbar-right-items">
                    <div class="user-info position-relative">
                        <button title="{{ __('menu.meu_perfil') }}" id="userMenuBtn" class="btn btn-user-menu d-flex align-items-center" type="button">
                            @if(Auth::user() && Auth::user()->profile_photo_url)
                                <img src="{{ Auth::user()->profile_photo_url }}"
                                    alt="{{ __('menu.foto_perfil') }}"
                                    class="profile-pic-avatar"
                                    style="width: 32px; height: 32px; object-fit: cover; border-radius: 50%;">
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
                                        <img id="profilePicImg"
                                            src="{{ Auth::user()->profile_photo_url }}"
                                            alt="{{ __('menu.foto_perfil') }}"
                                            class="profile-pic-avatar">
                                    @else
                                        <span id="profilePicImg" class="profile-pic-avatar d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-circle"></i>
                                        </span>
                                    @endif
                                </label>
                            </form>
                            <div class="mt-3 fw-bold" style="font-size: 20px; color: var(--color-bege-claro);">{{ __('menu.ola_usuario', ['name' => Auth::user() ? Auth::user()->name : __('menu.usuario')]) }}</div>
                            
                            <a href="#"
                                class="change-password d-block align-items-center gap-2 mt-3"
                                data-bs-toggle="modal" data-bs-target="#modalAlterarSenha"
                                onclick="document.getElementById('userMenuPanel').style.display = 'none';">
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
                            <button class="btn lang-btn dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="lang-flag"
                                    src="{{ asset($current == 'en' ? 'images/us.png' : 'images/brazil.png') }}"
                                    width="20" alt="flag">

                                <span class="lang-label">
                                    {{ $current == 'en' ? 'English' : 'Português' }}
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

    {{-- Modal de Alterar Senha --}}
    <div class="modal fade" id="modalAlterarSenha" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 px-3 pb-3 pt-2">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">{{ __('menu.alterar_senha') }}</h5>
                </div>
                <div class="modal-body">
                    <form id="formAlterarSenha" action="{{ route('change-password') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">{{ __('menu.senha_atual') }}</label>
                            <div class="password-container position-relative">
                                <input type="password" name="current_password" class="form-control" required>
                                <i class="bi bi-eye toggle-password" onclick="togglePassword(this)"></i>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('menu.nova_senha') }}</label>
                            <div class="password-container position-relative">
                                <input type="password" name="new_password" class="form-control" required minlength="8">
                                <i class="bi bi-eye toggle-password" onclick="togglePassword(this)"></i>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ __('menu.confirmar_nova_senha') }}</label>
                            <div class="password-container position-relative">
                                <input type="password" name="new_password_confirmation" class="form-control" required minlength="8">
                                <i class="bi bi-eye toggle-password" onclick="togglePassword(this)"></i>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <x-btn-cancelar data-bs-dismiss="modal" />
                            <x-btn-salvar />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    
    <script>
       function toggleDarkMode(checkbox) {
            if(checkbox.checked) {
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
