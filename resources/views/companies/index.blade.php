<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Empresas - Argus Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
    <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
    
    @include('layouts.css-variables')

    <style>
        body {
            background: linear-gradient(to right, var(--gradient-start), var(--gradient-end)) !important;
            font-family: Arial, sans-serif;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            align-items: center;
            padding: 40px 20px;
        }

        .content-wrapper {
            width: 100%;
            max-width: 960px;
            margin: 0 auto;
            padding: 0;
            padding-top: 20px;
            background-color: transparent;
            border-radius: 0;
            box-shadow: none;
            border: none;
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            flex-wrap: wrap;
            border-bottom: none;
        }

        .header-section h1 {
            color: var(--color-bege-claro);
            font-weight: bold;
            font-size: 2.5rem;
            margin-bottom: 0;
            line-height: 1.2;
        }

        .header-buttons {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .btn-voltar {
            background-color: var(--color-vinho);
            color: var(--color-bege-claro);
            border: none;
            border-radius: 10px;
            padding: 10px 18px;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 7px;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            outline: none !important;
        }

        .btn-voltar:hover {
            background-color: var(--color-vinho-escuro);
            transform: translateY(-2px);
            color: var(--color-bege-claro);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
        }

        .section-card {
            background-color: var(--color-bege-card-interno);
            border: 1px solid var(--color-gray);
            border-radius: 12px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            padding: 25px;
            margin-bottom: 25px;
            overflow-x: auto;
        }

        .table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0 8px;
        }

        .table thead {
            background-color: var(--color-vinho);
            color: var(--color-white);
            font-weight: bold;
            border-radius: 8px;
            overflow: hidden;
        }

        .table thead th {
            padding: 12px 15px;
            border: none;
            text-align: left;
            white-space: nowrap;
        }
        .table thead tr:first-child th:first-child {
            border-top-left-radius: 8px;
        }
        .table thead tr:first-child th:last-child {
            border-top-right-radius: 8px;
        }
        .table thead tr th {
            border-bottom: 2px solid var(--color-vinho-escuro);
        }

        .table tbody {
            background-color: transparent;
        }

        .table tbody tr {
            background-color: var(--color-white);
            transition: background-color 0.2s ease, box-shadow 0.2s ease;
            border: 1px solid var(--color-border-table);
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        }

        .table tbody tr:hover {
            background-color: var(--color-bege-card-interno);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .table tbody td {
            padding: 12px 15px;
            border: none;
            color: var(--color-gray-escuro);
            vertical-align: middle;
            background-color: var(--color-table-row-bg);
            &:first-child { border-bottom-left-radius: 8px; }
            &:last-child { border-bottom-right-radius: 8px; }
        }

        .btn {
            border-radius: 10px;
            padding: 0.6rem 1.4rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            transition: all 0.3s ease;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            font-size: 0.9rem;
            outline: none !important;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .alert {
            border-radius: 10px;
            padding: 15px 20px;
            font-size: 1rem;
            margin-bottom: 20px;
            background-color: var(--bs-alert-bg-danger);
            backdrop-filter: blur(5px);
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        @media (max-width: 768px) {
            body {
                padding: 20px 10px;
                justify-content: flex-start;
            }
            .content-wrapper {
                padding: 0 10px;
            }
            .header-section {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
                margin-bottom: 20px;
            }
            .header-section h1 {
                font-size: 1.8rem;
            }
            .header-buttons {
                flex-direction: column;
                width: 100%;
                gap: 10px;
            }
            .header-buttons .btn {
                width: 100%;
            }
            .section-card {
                padding: 15px;
            }
            .table-responsive {
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
            .table thead th, .table tbody td {
                font-size: 0.85rem;
                padding: 8px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <div class="header-section">
            <h1>Lista de Empresas</h1>
            <div class="header-buttons">
                <x-btn-voltar href="{{ route('admin.dashboard') }}" />
                <x-btn-mais href="{{ route('companies.create') }}" />
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="section-card">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>CNPJ</th>
                            <th>Razão Social</th>
                            <th>Nome Fantasia</th>
                            <th>Inscrição Estadual</th>
                            <th>Proprietário</th>
                            <th>Endereço</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($companies as $company)
                            <tr>
                                <td>{{ $company->cnpj }}</td>
                                <td>{{ $company->businessName }}</td>
                                <td>{{ $company->tradeName }}</td>
                                <td>{{ $company->stateRegistration }}</td>
                                <td>{{ $company->owner->name ?? '—' }}</td>
                                <td>
                                    {{ $company->address->place ?? '' }},
                                    {{ $company->address->number ?? '' }} -
                                    {{ $company->address->neighborhood ?? '' }},
                                    {{ $company->address->city ?? '' }}/{{ $company->address->state ?? '' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>