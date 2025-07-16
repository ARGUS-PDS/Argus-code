<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Nova Empresa - Argus Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
    <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
    <style>
        /* Variáveis de Cores (Centralizadas para este template de admin) */
        :root {
            --color-vinho: #773138;
            --color-bege-claro: #f8f0e5;
            --color-bege-card-interno: #fcf5ee; /* Fundo dos cards internos */
            --color-gray-claro: #ddd;
            --color-gray-medio: #aaa;
            --color-gray-escuro: #555;
            --color-vinho-fundo-transparente: rgba(119, 49, 56, 0.25);

            /* Cores para o degradê do fundo */
            --gradient-start: #eecac0;
            --gradient-end: #773138;

            /* Sobrescrevendo variáveis Bootstrap para cores dos botões e componentes */
            --bs-primary: var(--color-vinho);
            --bs-secondary: var(--color-gray-escuro);
            --bs-btn-bg: var(--bs-primary);
            --bs-btn-border-color: var(--bs-primary);
            --bs-btn-hover-bg: #5f282e;
            --bs-btn-hover-border-color: #5f282e;
            --bs-btn-active-bg: #471e23;
            --bs-btn-active-border-color: #471e23;
            --bs-btn-color: #fff;
            --bs-danger: #dc3545;
            --bs-btn-danger-bg: var(--bs-danger);
            --bs-btn-danger-border-color: var(--bs-danger);
            --bs-btn-danger-hover-bg: #c82333;
            --bs-btn-danger-hover-border-color: #bd2130;

            /* Cores para alertas */
            --bs-alert-bg-success: #d4edda;
            --bs-alert-border-success: #c3e6cb;
            --bs-alert-color-success: #155724;
            --bs-alert-bg-danger: #f8d7da;
            --bs-alert-border-danger: #f5c6cb;
            --bs-alert-color-danger: #721c24;
        }

        /* Estilos do Body com Degradê e Centralização */
        body {
            background: linear-gradient(to right, var(--gradient-start), var(--gradient-end)) !important;
            font-family: Arial, sans-serif;
            min-height: 100vh; /* Garante que o degradê ocupe a altura total da viewport */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Centraliza verticalmente */
            align-items: center; /* Centraliza horizontalmente */
            padding: 40px 20px; /* Aumenta o padding superior e inferior do body */
        }

        /* Container principal - o "card" que engloba tudo nesta tela */
        .container-card {
            background-color: var(--color-bege-card-interno);
            border-radius: 18px;
            padding: 35px 40px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            margin: 0 auto;
            max-width: 960px; /* Ajustado de volta para 960px */
            width: 95%; /* Garante que ocupe a largura máxima permitida */
            border: 1px solid var(--color-gray-claro);
        }

        /* Seção do cabeçalho (título e botão voltar) */
        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--color-gray-claro);
            flex-wrap: wrap; /* Permite quebrar linha em telas menores */
        }

        .header-section h2 {
            color: var(--color-vinho);
            font-weight: bold;
            font-size: 2.2rem;
            margin-bottom: 0;
            line-height: 1.2;
        }

        .btn-voltar {
            background-color: var(--color-vinho); /* Cor do botão Voltar */
            color: var(--color-bege-claro);
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-voltar:hover {
            background-color: #5f282e;
            transform: translateY(-2px);
            color: var(--color-bege-claro);
        }

        /* Estilo para os sub-cards (agrupamentos de campos) */
        .section-card {
            background-color: #fff; /* Fundo branco para se destacar no bege do container principal */
            border: 1px solid var(--color-gray-claro);
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            padding: 25px;
            margin-bottom: 25px;
        }

        .section-card .card-title {
            color: var(--color-vinho);
            font-weight: bold;
            font-size: 1.3rem;
            margin-bottom: 20px;
            padding-bottom: 8px;
            border-bottom: 1px solid var(--color-gray-claro);
        }

        /* Estilo para os labels dos formulários */
        .form-label {
            display: block;
            color: var(--color-vinho); /* Cor vinho para os labels */
            font-weight: 600;
            margin-bottom: 8px;
            font-size: 0.95rem;
        }

        /* Estilo padrão para inputs e selects */
        .form-control, .form-select {
            width: 100%;
            padding: 12px 18px;
            border: 1px solid var(--color-gray-medio);
            border-radius: 10px;
            font-size: 1rem;
            color: var(--color-gray-escuro);
            background-color: #fff;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--color-vinho);
            box-shadow: 0 0 0 0.25rem var(--color-vinho-fundo-transparente);
            outline: none;
        }

        /* Estilo para campos desabilitados/somente leitura */
        .form-control:disabled, .form-control[readonly] {
            background-color: #f0f0f0;
            opacity: 1;
            color: var(--color-gray-escuro);
            border-color: var(--color-gray-claro);
            cursor: not-allowed;
        }

        /* Estilos para botões de ação */
        .action-buttons {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end; /* Alinha à direita */
            gap: 15px;
        }

        /* Botão "Salvar Empresa e Usuário" - Usando btn-primary para ser vinho */
        .btn-primary {
            background-color: var(--bs-primary) !important;
            border-color: var(--bs-primary) !important;
            color: var(--bs-btn-color) !important;
            border-radius: 10px;
            padding: 10px 20px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-primary:hover {
            background-color: var(--bs-btn-hover-bg) !important;
            border-color: var(--bs-btn-hover-border-color) !important;
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.15);
        }

        /* Estilos para alertas */
        .alert {
            border-radius: 10px;
            padding: 15px 20px;
            font-size: 1rem;
            margin-bottom: 20px;
        }

        .alert-success {
            background-color: var(--bs-alert-bg-success) !important;
            color: var(--bs-alert-color-success) !important;
            border-color: var(--bs-alert-border-success) !important;
        }

        .alert-danger {
            background-color: var(--bs-alert-bg-danger) !important;
            color: var(--bs-alert-color-danger) !important;
            border-color: var(--bs-alert-border-danger) !important;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .container-card {
                padding: 25px;
                margin-left: 15px;
                margin-right: 15px;
                width: calc(100% - 30px);
            }
            .header-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                margin-bottom: 20px;
            }
            .header-section h2 {
                font-size: 1.8rem;
            }
            .section-card {
                padding: 20px;
                margin-bottom: 20px;
            }
            .section-card .card-title {
                font-size: 1.2rem;
                margin-bottom: 15px;
            }
            .form-label {
                font-size: 0.9rem;
            }
            .form-control, .form-select {
                padding: 10px 15px;
            }
            .action-buttons {
                justify-content: center; /* Centraliza botões em mobile */
                flex-direction: column; /* Empilha botões em mobile */
                gap: 10px;
            }
            .action-buttons .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container-card">
        <div class="header-section">
            <h2>Cadastrar Nova Empresa</h2>
            <x-btn-voltar href="{{ route('companies.index') }}" />
        </div>

        {{-- Exibição de mensagens de sucesso --}}
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Exibição de erros de validação --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('companies.store') }}" method="POST">
            @csrf

            <div class="section-card">
                <h4 class="card-title">Dados da Empresa</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="cnpj" class="form-label">CNPJ</label>
                        <input type="text" name="cnpj" id="cnpj" class="form-control" required maxlength="18" />
                    </div>

                    <div class="col-md-6">
                        <label for="businessName" class="form-label">Razão Social</label>
                        <input type="text" name="businessName" id="businessName" class="form-control" required maxlength="50" />
                    </div>

                    <div class="col-md-6">
                        <label for="tradeName" class="form-label">Nome Fantasia</label>
                        <input type="text" name="tradeName" id="tradeName" class="form-control" required maxlength="50" />
                    </div>

                    <div class="col-md-6">
                        <label for="stateRegistration" class="form-label">Inscrição Estadual</label>
                        <input type="text" name="stateRegistration" id="stateRegistration" class="form-control" maxlength="15" />
                    </div>
                </div>
            </div>

            <div class="section-card">
                <h4 class="card-title">Endereço</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="cep" class="form-label">CEP</label>
                        <input type="text" name="cep" id="cep" class="form-control" required maxlength="8" />
                    </div>

                    <div class="col-md-6">
                        <label for="place" class="form-label">Logradouro</label>
                        <input type="text" name="place" id="place" class="form-control" required maxlength="100" />
                    </div>

                    <div class="col-md-6">
                        <label for="number" class="form-label">Número</label>
                        <input type="number" name="number" id="number" class="form-control" required />
                    </div>

                    <div class="col-md-6">
                        <label for="neighborhood" class="form-label">Bairro</label>
                        <input type="text" name="neighborhood" id="neighborhood" class="form-control" required maxlength="100" />
                    </div>

                    <div class="col-md-6">
                        <label for="city" class="form-label">Cidade</label>
                        <input type="text" name="city" id="city" class="form-control" required maxlength="100" />
                    </div>

                    <div class="col-md-6">
                        <label for="state" class="form-label">Estado</label>
                        <input type="text" name="state" id="state" class="form-control" required maxlength="2" />
                    </div>
                </div>
            </div>

            <div class="section-card">
                <h4 class="card-title">Usuário Master (Dono da Empresa)</h4>
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="user_name" class="form-label">Nome</label>
                        <input type="text" name="user_name" id="user_name" class="form-control" required maxlength="255" />
                    </div>

                    <div class="col-md-6">
                        <label for="user_email" class="form-label">Email</label>
                        <input type="email" name="user_email" id="user_email" class="form-control" required maxlength="255" />
                    </div>

                    <div class="col-md-6">
                        <label for="user_password" class="form-label">Senha</label>
                        <input type="password" name="user_password" id="user_password" class="form-control" required minlength="6" />
                    </div>
                </div>
            </div>

            <div class="action-buttons">
                <button type="submit" class="btn btn-primary">Salvar Empresa e Usuário</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/empresa.js') }}"></script>
</body>
</html>