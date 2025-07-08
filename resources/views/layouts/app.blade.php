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
                    <a href="#"><i class="bi bi-gear-fill nav-icon"></i></a>
                    <div class="user-info">
                        <i class="bi bi-person-circle"></i>
                        <span>{{ Auth::user()->name }}</span>
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
</body>
</html> 