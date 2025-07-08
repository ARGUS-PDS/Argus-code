<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Argus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    @include('layouts.css-variables')
    
    <!-- Favicon -->
    <link rel="icon" href="{{ asset('images/favicon-light.png') }}" type="image/png">
    
    @yield('styles')

    <style>
        body {
            background-color: var(--color-bege-claro);
            overflow-x: hidden;
        }

        .navbar {
            background-color: var(--color-bege-claro);
            padding: 0.5rem 0 0.5rem 2rem;
            box-shadow: 0 3px 8px rgba(119, 49, 56, 0.5);
            transform: translateY(-10px);
            border-radius: 15px;
            position: relative;
            z-index: 1100;     
        }

        .navbar-brand {
            margin-right: 0 !important;
        }

        .navbar-brand img {
            height: 40px;
            margin-left: 10px;
        }
        
        .navbar-collapse {
            background-color: var(--color-bege-claro);
            padding: 0.5rem 2rem;
            height: 57px;
            margin-left: 50px;
            margin-right: -10px;
            margin-bottom: -8px;
            box-shadow: 0 8px 8px rgba(0,0,0,0.1);
            flex-grow: 1;
            border-radius: 15px 15px 15px 15px;
        }

        .navbar-nav .nav-link {
            color: var(--color-gray-escuro);
            font-weight: 500;
            font-size: 1.1rem;
            padding: 0.5rem 1rem !important;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        
        .navbar-nav .dropdown-toggle:hover,
        .navbar-nav .dropdown:hover > .dropdown-toggle {
            background-color: var(--color-vinho-fundo);
            color: var(--color-vinho);
        }


        


        .dropdown-menu {
            background-color: var(--color-bege-claro);
            border: none;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-radius: 12px;
            padding: 0.75rem;
            margin-top: 0;
        }

        .dropdown-header {
            font-size: 0.75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--color-vinho-fundo);
            padding: 0.75rem 1rem 0.25rem;
        }

        .dropdown-item {
            color: var(--color-gray-escuro);
            font-weight: 500;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .dropdown-item:hover,
        .dropdown-item:focus,
        .dropdown-item.active {
            background-color: var(--color-vinho-fundo);
            color: var(--color-vinho);
        }

        .dropdown-item.special-link {
            font-weight: bold;
        }

        .dropdown-item.special-link:hover {
            background-color: var(--color-vinho-fundo);
        }

        @media (min-width: 992px) {
            .navbar-nav .dropdown:hover .dropdown-menu {
                display: block;
                margin-top: 0;
            }
        }
        
        .navbar-right-items {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .navbar-right-items .nav-icon {
            font-size: 1.5rem;
            color: var(--color-gray-escuro);
        }
        
        .navbar-right-items .nav-icon:hover {
            color: var(--color-vinho);
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            color: var(--color-gray-escuro);
            font-weight: 500;
        }
        
        .user-info .bi-person-circle {
            font-size: 1.8rem;
        }

        .main-content {
            padding: 2rem;
        }

        .lang-btn{
            background:transparent;
            border:none;
            display:inline-flex;
            align-items:center;
            gap:.17rem;
            padding:0;                    
            cursor:pointer;
        }

        .lang-btn .bi{    
            font-size:.75rem;
            transition:transform .3s;
        }

        .lang-label{
            max-width:0; 
            opacity:0;
            overflow:hidden;
            white-space:nowrap;
            transition:max-width .3s ease, opacity .3s ease;
        }

        .lang-flag{
            transition:transform .3s ease;
        }


        .lang-btn:hover  .lang-label,
        .lang-btn:focus  .lang-label{
            max-width:5.5rem;
            opacity:1;
        }

        .lang-btn:hover  .lang-flag,
        .lang-btn:focus  .lang-flag{
            transform:translateX(-4px);
        }

        .lang-btn:hover  .bi,
        .lang-btn:focus  .bi{
            transform:rotate(180deg);
        }
        

        .lang-btn.dropdown-toggle::after{
            display:none;
        }

        .lang-btn .bi{
            margin-left:0.25rem;
            transition:transform .3s;
        }


        .lang-btn:hover  .bi,
        .lang-btn:focus  .bi{
            transform:rotate(180deg);
        }

        .btn-user-menu {
            border: none;
            padding: 2px 6px;
            transition: background 0.08s, border-radius 0.08s;
        }

        .btn-user-menu:hover{
            background: var(--color-vinho-fundo);
            border-radius: 16px;
            outline: none;
        }

        .btn-user-menu:focus {
            border-radius: 16px;
            outline: none;
        }

        .user-menu-panel {
            display: none;
            position: absolute;
            top: 45px;
            right: 0;
            min-width: 320px;
            min-height: 220px;
            background: var(--color-vinho);
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            padding: 20px 18px 14px 18px;
            z-index: 2000;
        }

        .profile-pic-avatar {
            width: 80px;
            height: 80px;
            border-radius: 100%;
            background: var(--color-bege-claro);
            color: var(--color-black);
            object-fit: cover;

            .bi-person-circle{
                font-size: 72px;
            }
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard">
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
                            <li><a class="dropdown-item" href="/lista-produtos">{{__('menu.produtos')}}</a></li>
                            <li><a class="dropdown-item" href="/cadastrar-produto-ean">{{__('menu.ean')}}</a></li>
                            <li><a class="dropdown-item" href="/lista-fornecedores">{{__('menu.fornecedores')}}</a></li>
                            <li><a class="dropdown-item" href="/cadastrar-funcionario">{{__('menu.funcionarios')}}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('menu.estoque') }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">{{ __('menu.controle_estoque') }}</a></li>
                            <li><a class="dropdown-item" href="/entrada-saida">{{ __('menu.entrada_saida') }}</a></li>
                            <li><a class="dropdown-item" href="#">{{ __('menu.acompanhamento_validade') }}</a></li>
                            <li><a class="dropdown-item" href="/etiquetas">{{ __('menu.etiquetas') }}</a></li>
                            <li><a class="dropdown-item" href="/detalhamento-lote">{{ __('menu.detalhamento_lote') }}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('menu.pedidos') }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">{{ __('menu.envio_pedido') }}</a></li>
                            <li><a class="dropdown-item" href="#">{{ __('menu.cotacao_fornecedores') }}</a></li>
                            <li><a class="dropdown-item" href="#">{{ __('menu.historico_pedidos') }}</a></li>
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
                        </div>
                    <!--da pra colocar aqui a engrenagem e o negocio de ajuda-->
                    </div>
                    <div class="d-flex gap-2">
@php  $current = app()->getLocale();  @endphp

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
    <script>
    const btn = document.getElementById('userMenuBtn');
    const panel = document.getElementById('userMenuPanel');
    const profilePicInput = document.getElementById('profilePicInput');
    let profilePicImg = document.getElementById('profilePicImg');
    btn.addEventListener('click', function(e) {
        e.stopPropagation();
        if (panel.style.display === 'block') {
            panel.style.display = 'none';
            btn.blur();
        } else {
            panel.style.display = 'block';
        }
    });
    document.addEventListener('click', function(e) {
        if (!panel.contains(e.target) && e.target !== btn) {
            panel.style.display = 'none';
            btn.blur();
        }
    });
    if(profilePicInput && profilePicImg) {
        profilePicInput.addEventListener('change', function(e) {
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    // Troca para <img> se for span
                    if(profilePicImg.tagName.toLowerCase() === 'span') {
                        const newImg = document.createElement('img');
                        newImg.id = 'profilePicImg';
                        newImg.className = 'profile-pic-avatar';
                        newImg.alt = 'Foto de perfil';
                        newImg.src = e.target.result;
                        profilePicImg.parentNode.replaceChild(newImg, profilePicImg);
                        profilePicImg = newImg;
                    } else {
                        profilePicImg.src = e.target.result;
                    }
                }
                reader.readAsDataURL(this.files[0]);
            }
        });
    }
    </script>
</body>
</html> 