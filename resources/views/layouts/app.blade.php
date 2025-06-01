<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Argus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Favicon para tema claro -->
    <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
    <!-- Favicon para tema escuro -->
    <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
    
    <style>
        body {
            background-color: #713200;
        }

        .sidebar {
            background-color: #d2a87d;
            height: 100vh;
            position: fixed;
            width: 220px;
            padding: 1rem 0.5rem;
            color: #202132;
            overflow-y: auto;
            transition: all 0.3s ease;
        }

        .sidebar.collapsed {
            width: 50px;
        }

        .sidebar.collapsed .menu-title span,
        .sidebar.collapsed .menu-item,
        .sidebar.collapsed .submenu,
        .sidebar.collapsed .user-name {
            display: none;
        }

        .sidebar.collapsed .menu-title {
            padding: 0.5rem 0;
            justify-content: center;
            border-bottom: none;
        }

        .sidebar.collapsed .menu-icon {
            margin: 0;
            font-size: 1.3rem;
        }

        .main-content {
            margin-left: 220px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .main-content.expanded {
            margin-left: 50px;
        }

        .menu-title {
            color: #202132;
            font-size: 1.1rem;
            font-weight: bold;
            padding: 0.5rem 0.5rem;
            margin-top: 1rem;
            border-bottom: 2px solid #8d6b48;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .menu-icon {
            font-size: 1.2rem;
        }

        .menu-item {
            color: #202132;
            text-decoration: none;
            display: block;
            padding: 0.4rem 0.8rem;
            margin: 0.2rem 0;
            border-radius: 5px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .menu-item:hover {
            background-color: #8d6b48;
            color: #FFFFFF;
        }

        .menu-item.active {
            background-color: #8d6b48;
            color: #FFFFFF;
        }

        .submenu {
            padding-left: 1rem;
        }

        .toggle-btn {
            position: absolute;
            right: 7px;
            top: 7px;
            background-color: #d2a87d;
            border: 2px solid #8d6b48;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #202132;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .toggle-btn:hover {
            background-color: #8d6b48;
            color: #FFFFFF;
        }

        .user-info {
            margin-top: 1rem;
            padding: 0.5rem;
        }

        .user-info i {
            font-size: 1.3rem;
        }

        .user-name {
            margin-left: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="sidebar">
                <div class="toggle-btn" onclick="toggleSidebar()">
                    <i class="bi bi-chevron-left"></i>
                </div>
                <div class="user-info d-flex align-items-center">
                    <i class="bi bi-person-circle"></i>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                </div>

                <div class="menu-title">
                    <i class="bi bi-folder-fill menu-icon"></i>
                    <span>Cadastro</span>
                </div>
                <div class="submenu">
                    <a href="/lista-produtos" class="menu-item">Produtos</a>
                    <a href="/cadastrar-produto-ean" class="menu-item">Produtos via EAN</a>
                    <a href="/lista-fornecedores" class="menu-item">Cadastro de Fornecedores</a>
                    <a href="/cadastrar-funcionario" class="menu-item">Cadastro de Funcionários</a>
                </div>

                <div class="menu-title">
                    <i class="bi bi-box-seam-fill menu-icon"></i>
                    <span>Estoque</span>
                </div>
                <div class="submenu">
                    <a href="#" class="menu-item">Controle de Estoque</a>
                    <a href="#" class="menu-item">Acompanhamento de Validade</a>
                    <a href="/etiquetas" class="menu-item">Etiquetas</a>
                    <a href="/detalhamento-lote" class="menu-item">Detalhamento de Lote</a>
                </div>

                <div class="menu-title">
                    <i class="bi bi-cart-fill menu-icon"></i>
                    <span>Pedidos</span>
                </div>
                <div class="submenu">
                    <a href="#" class="menu-item">Envio de Pedido</a>
                    <a href="#" class="menu-item">Cotação de Fornecedores</a>
                    <a href="#" class="menu-item">Histórico de Pedidos</a>
                </div>
            </div>

            <div class="main-content">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function toggleSidebar() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const toggleBtn = document.querySelector('.toggle-btn i');
            
            sidebar.classList.toggle('collapsed');
            mainContent.classList.toggle('expanded');
            
            if (sidebar.classList.contains('collapsed')) {
                toggleBtn.classList.remove('bi-chevron-left');
                toggleBtn.classList.add('bi-chevron-right');
            } else {
                toggleBtn.classList.remove('bi-chevron-right');
                toggleBtn.classList.add('bi-chevron-left');
            }
        }
    </script>
</body>
</html> 