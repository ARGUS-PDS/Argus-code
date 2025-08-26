<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Gerar Cartão de Segurança - Argus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">

    <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">

    <style>
        :root {
            --color-vinho: #773138; 
            --color-bege-claro: #f8f0e5; 
            --color-bege-card-interno: #fcf5ee;
            --color-gray-claro: #ddd;
            --color-gray-escuro: #555;
            --color-green: #28a745;
            --color-table-header-bg: #773138;
            --color-table-header-text: #fff;
            --color-table-row-bg: #fdfaf7;
            --color-border: #e0e0e0;

            /* Sobrescrevendo variáveis Bootstrap para cores dos botões e componentes */
            --bs-primary: var(--color-vinho);
            --bs-secondary: var(--color-gray-escuro);

            /* Cores dos botões */
            --bs-btn-bg: var(--bs-primary);
            --bs-btn-border-color: var(--bs-primary);
            --bs-btn-hover-bg: #5f282e;
            --bs-btn-hover-border-color: #5f282e;
            --bs-btn-active-bg: #471e23;
            --bs-btn-active-border-color: #471e23;
            --bs-btn-color: #fff;

            /* Ajustes para botões de alerta/perigo */
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

            /* Cores para o degradê do fundo */
            --gradient-start: #eecac0;
            --gradient-end: #773138;   
        }

        body {
            background: linear-gradient(to right, var(--gradient-start), var(--gradient-end)) !important;
            font-family: Arial, sans-serif; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px; 
        }

        .container {
            background-color: var(--color-bege-card-interno);
            border-radius: 16px;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
            padding: 40px;
            max-width: 700px; 
            width: 100%;
        }

        h3 {
            color: var(--color-vinho); 
            font-weight: bold;
            font-size: 2rem; 
            margin-bottom: 30px; 
        }

        .form-label {
            color: var(--color-gray-escuro); 
            font-weight: 600;
        }

        .form-select,
        .form-control { 
            border-radius: 8px; 
            border: 1px solid var(--color-border);
            padding: 0.75rem 1rem;
            color: var(--color-gray-escuro);
        }

        .form-select:focus,
        .form-control:focus {
            border-color: var(--color-vinho); 
            box-shadow: 0 0 0 0.25rem rgba(119, 49, 56, 0.25); 
        }

        .btn {
            border-radius: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            font-size: 0.9rem; 
        }

        .btn-primary {
            background-color: var(--color-vinho) !important;
            border-color: var(--color-vinho) !important;
            color: #fff !important;
        }

        .btn-primary:hover {
            background-color: #5f282e !important;
            border-color: #5f282e !important;
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.2);
        }

        /* Estilo para o cartão de segurança gerado */
        #cartao-seguranca {
            border-radius: 16px;
            border: 2px solid var(--color-vinho) !important; 
            background-color: #e8d1b9; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            color: var(--color-vinho); 
            padding: 25px; 
            margin-top: 40px; 
            width: 380px; 
            height: auto; 
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        #cartao-seguranca h5 {
            color: var(--color-vinho) !important;
            font-size: 1.3rem; 
            margin-bottom: 10px; 
        }

        #cartao-seguranca p {
            color: var(--color-gray-escuro); 
            margin-bottom: 5px; 
            font-size: 0.9rem; 
        }
        
        #cartao-seguranca strong {
            color: var(--color-vinho); /
        }

        /* Botão de imprimir no cartão */
        #cartao-seguranca .btn-dark {
            background-color: var(--color-vinho) !important; 
            border-color: var(--color-vinho) !important;
            color: #fff !important;
            margin-top: 15px; 
            padding: 0.5rem 1rem; 
            font-size: 0.85rem; 
        }

        #cartao-seguranca .btn-dark:hover {
            background-color: #5f282e !important;
            border-color: #5f282e !important;
        }

        /* Estilos para alertas */
        .alert-success {
            background-color: var(--bs-alert-bg-success) !important;
            border-color: var(--bs-alert-border-success) !important;
            color: var(--bs-alert-color-success) !important;
            border-radius: 8px;
            margin-bottom: 20px; 
        }

        .alert-danger {
            background-color: var(--bs-alert-bg-danger) !important;
            border-color: var(--bs-alert-border-danger) !important;
            color: var(--bs-alert-color-danger) !important;
            border-radius: 8px;
            margin-bottom: 20px; 
        }

        .btn-voltar{
            position: fixed;
            margin-left: 510px;
            margin-bottom: 0;
        }

        .btn-bottomm{
            display: flex;
        }

        /* Estilos de impressão */
        @media print {
            body * {
                visibility: hidden !important;
            }
            #cartao-seguranca, #cartao-seguranca * {
                visibility: visible !important;
            }
            #cartao-seguranca {
                position: absolute !important;
                left: 0;
                top: 0;
                right: 0;
                margin: auto;
                box-shadow: none !important;
                page-break-before: always;
                width: auto !important; 
                height: auto !important;
            }
            #cartao-seguranca .btn { 
                display: none !important;
            }
            button {
                display: none !important;
            }
        }

        
    </style>

</head>
<body class="p-4">

    <div class="container">
        <h3 class="mb-4">Gerar Cartão de Segurança</h3>
        

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.gerarCartao') }}">
            @csrf

            <div class="mb-3">
                <label for="user_id" class="form-label">Usuário</label>
                <select class="form-select" name="user_id" id="user_id" required>
                    <option value="">-- Selecione --</option>
                    @foreach ($usuarios as $usuario)
                        <option value="{{ $usuario->id }}">{{ $usuario->name }} ({{ $usuario->email }})</option>
                    @endforeach
                </select>
            </div>

        <div class="btn-bottom">
            <x-btn-voltar/>
            <button type="submit" class="btn btn-primary">Gerar Cartão</button>
        </div>
        </form>

        @if (session('cartao'))
        <div id="cartao-seguranca" class="card mt-5 p-4 text-center mx-auto">
                <h5 class="mb-2">Cartão de Segurança Argus</h5>
                <p><strong>User:</strong> {{ \App\Models\User::find(session('user_id'))->name }}</p>
                <p><strong>Número do cartão:</strong> {{ session('cartao') }}</p>
                <p><strong>Validade:</strong> {{ \Carbon\Carbon::now()->addMonth()->format('d/m/Y') }}</p>
                <button class="btn btn-dark mt-2" onclick="window.print()">Imprimir Cartão</button>
            </div>
        @endif

    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>