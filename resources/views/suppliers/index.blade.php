@extends('layouts.app') 

@section('styles')
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

        --bs-alert-bg-success: #d4edda;
        --bs-alert-border-success: #c3e6cb;
        --bs-alert-color-success: #155724;

        --bs-alert-bg-danger: #f8d7da;
        --bs-alert-border-danger: #f5c6cb;
        --bs-alert-color-danger: #721c24;

        --gradient-start: #eecac0; 
        --gradient-end: #773138;   
    }

    body {
        background-color: var(--color-bege-claro);
        padding: 0;
        margin: 0;
    }

    .search-bar {
        background: var(--color-vinho);
        border-radius: 20px;
        padding: 6px 16px;
        width: 300px;
        display: flex;
        align-items: center;
    }

    .search-bar input {
        background: transparent;
        border: none;
        color: #fff;
        outline: none;
        width: 90%;
    }

    .search-bar input::placeholder {
        color: rgba(255, 255, 255, 0.7);
    }

    .search-bar:hover {
        background: rgb(136, 59, 67);
    }

    .search-bar .bi-search {
        color: #fff;
        font-size: 1.2rem;
        margin-left: 8px;
    }

    .table thead th {
        background: var(--color-vinho);
        color: var(--color-bege-claro);
        border-bottom: none;
    }

    .table tbody tr:hover {
        background-color: rgba(119, 49, 56, 0.1);
    }

    .table-responsive {
        border-radius: 15px;
        overflow: hidden;
    }

    .img-thumb {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border: 2px solid #198754;
        border-radius: 8px;
        background: #fff;
    }

    .add-btn {
        border: 2px solid var(--color-vinho);
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--color-vinho);
        background: none;
        cursor: pointer;
        margin-left: 8px;
        transition: background 0.5s, color 0.5s;
    }

    .add-btn:hover {
        background: var(--color-vinho);
        color: var(--color-bege-claro);
    }

    .menu-dot {
        font-size: 1.5rem;
        color: var(--color-gray-escuro);
        cursor: pointer;
        text-align: center;
    }

    .bi-plus-circle-fill,
    .bi-dash-circle-fill {
        color: var(--color-vinho);
        margin-left: 5px;
    }

    td p {
        margin-bottom: 0;
    }
</style>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
@endif

<div class="container-fluid py-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold mb-0">Fornecedores</h2>
        <div class="d-flex align-items-center gap-3">
            <form action="{{ route('pesquisa.index') }}" method="GET" class="search-bar">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Pesquisar por nome ou código...">
                <button type="submit" style="background: none; border: none; color: #fff;">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <span class="ms-4 text-secondary">Estoque atual: </span>
            <a href="{{ route('suppliers.create') }}" class="btn btn-primary add-btn ms-2" title="Adicionar">
                <i class="bi bi-plus"></i>
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width:32px"></th>
                    <th>Nome</th>
                    <th>Código</th>
                    <th>CPF/CNPJ</th>
                    <th>Distribuidor</th>
                    <th>Contato</th>
                    <th>Endereço</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                <tr>
                    <td><input type="checkbox"></td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->code }}</td>
                    <td>{{ $supplier->document }}</td>
                    <td>{{ $supplier->distributor }}</td>
                    <td>
                        {{ $supplier->fixedphone }}
                        <i id="toggleIconC{{ $supplier->id }}" onclick="seemorecontat('{{ $supplier->id }}')" class="bi bi-plus-circle-fill" style="cursor: pointer;"></i>
                    </td>
                    <td style="display: flex; align-items: center;">
                        <p style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                            @if($supplier->address)
                            {{ $supplier->address->place }}, Nº {{ $supplier->address->number }}, {{ $supplier->address->neighborhood }}
                            @else
                            Não informado
                            @endif
                        </p>
                        <i id="toggleIconA{{ $supplier->id }}" onclick="seemoreaddresses('{{ $supplier->id }}')" class="bi bi-plus-circle-fill" style="cursor: pointer;"></i>
                    </td>
                    <td>
                        <div class="dropdown">
                            <i class="bi bi-three-dots-vertical dropdown-toggle" role="button" id="dropdownMenuButton{{ $supplier->id }}" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer; color: var(--color-gray-escuro);"></i>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $supplier->id }}">
                                <li>
                                    <a class="dropdown-item" href="{{ route('suppliers.edit', $supplier->id) }}">Editar</a>
                                </li>
                                <li>
                                    <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este fornecedor?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit">Excluir</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                <tr id="addresses{{ $supplier->id }}" style="display: none;">
                    <td colspan="8">
                        @if($supplier->address)
                        <strong>Endereço:</strong> {{ $supplier->address->place }}, Nº {{ $supplier->address->number }}, {{ $supplier->address->neighborhood }} <br>
                        <strong>CEP:</strong> {{ $supplier->address->cep }} <br>
                        <strong>Cidade:</strong> {{ $supplier->address->city }} - {{ $supplier->address->state }}
                        @else
                        <strong>Endereço:</strong> Não cadastrado.
                        @endif
                    </td>
                </tr>
                <tr id="contacts{{ $supplier->id }}" style="display: none;">
                    <td colspan="8">
                        <strong>Telefone Fixo:</strong> {{ $supplier->fixedphone }} <br>
                        <strong>Celular:</strong> {{ $supplier->phone }} <br>
                        <strong>Email:</strong> {{ $supplier->email }} <br>
                        <strong>Contato 1:</strong> {{ $supplier->contactName1 }} - {{ $supplier->contactPosition1 }} - {{ $supplier->contactNumber1 }} <br>
                        <strong>Contato 2:</strong> {{ $supplier->contactName2 }} - {{ $supplier->contactPosition2 }} - {{ $supplier->contactNumber2 }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Nenhum fornecedor cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


<script>
    function seemorecontat(id) {
        const contacts = document.getElementById("contacts" + id);
        const icon = document.getElementById('toggleIconC' + id);

        if (contacts.style.display === "none" || contacts.style.display === "") {
            contacts.style.display = "table-row";
            icon.classList.remove('bi-plus-circle-fill');
            icon.classList.add('bi-dash-circle-fill');
        } else {
            contacts.style.display = "none";
            icon.classList.remove('bi-dash-circle-fill');
            icon.classList.add('bi-plus-circle-fill');
        }
    }

    function seemoreaddresses(id) {
        const addresses = document.getElementById("addresses" + id);
        const icon = document.getElementById('toggleIconA' + id);

        if (addresses.style.display === "none" || addresses.style.display === "") {
            addresses.style.display = "table-row";
            icon.classList.remove('bi-plus-circle-fill');
            icon.classList.add('bi-dash-circle-fill');
        } else {
            addresses.style.display = "none";
            icon.classList.remove('bi-dash-circle-fill');
            icon.classList.add('bi-plus-circle-fill');
        }
    }
</script>
@endsection