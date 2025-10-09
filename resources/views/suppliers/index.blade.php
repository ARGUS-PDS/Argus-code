@extends('layouts.app') 

@section('styles')
<style>
    body {
        background-color: var(--color-bege-claro);
        padding: 0;
        margin: 0;
    }

    h2 {
        color: var(--color-vinho);
        font-weight: bold;
        margin-bottom: 0;
    }

    .search-bar {
        background: var(--color-vinho);
        border: 2px solid var(--color-vinho);
        border-radius: 20px;
        padding: 6px 16px;
        width: 300px;
        display: flex;
        align-items: center;
        transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }

    .search-bar input {
        background: transparent;
        border: none;
        color: var(--color-bege-claro);
        outline: none;
        width: 90%;
    }

    .search-bar input::placeholder {
        color: var(--color-bege-claro);
    }

    .search-bar:hover {
        background: var(--color-bege-claro) !important;
        color: var(--color-vinho) !important;
    }

    .search-bar:hover input {
        color: var(--color-vinho) !important;
    }
        
    .search-bar:hover input::placeholder {
        color: var(--color-vinho) !important;
        opacity: 1 !important;
    }

    .search-bar .bi-search {
        color: var(--color-bege-claro);
        font-size: 1.2rem;
        margin-left: 8px;
        transition: color 0.3s ease;
    }

    .search-bar:hover .bi-search {
        color: var(--color-vinho);
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
        overflow: visible;
    }

    .img-thumb {
        width: 40px;
        height: 40px;
        object-fit: cover;
        border: 2px solid var(--color-green);
        border-radius: 8px;
        background: var(--color-white);
    }

    .dropdown-item, .tres-pontos{
        z-index: 1000;
    }
    
    .table {
        border-collapse: separate;
        border-spacing: 0;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        background: var(--color-bege-card-interno); /* Fundo bege para a tabela */
        margin: 16px 0;
    }

    .table th {
        vertical-align: middle;
        background: var(--color-vinho);
        color: var(--color-bege-claro);
        border-bottom: none;
        padding: 1rem 1rem;
    }

    .table td {
        vertical-align: middle;
        background: transparent;
        color: var(--color-vinho);
        border-top: none;
        padding: 0.75rem 1rem;
    }

    .table thead th:first-child {
        border-top-left-radius: 12px;
    }

    .table thead th:last-child {
        border-top-right-radius: 12px;
    }

    .table tbody tr:last-child td:first-child {
        border-bottom-left-radius: 12px;
    }

    .table tbody tr:last-child td:last-child {
        border-bottom-right-radius: 12px;
    }

    .table tbody tr:hover {
        background-color: rgba(119, 49, 56, 0.1);
    }

    .table tbody tr:last-child td {
        border-bottom: none !important;
    }

    .bi-plus-circle-fill, .bi-dash-circle-fill{
        cursor: pointer;
    }

    .confirm-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: var(--color-shadow);
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(3px);
        visibility: hidden;
        opacity: 0;
        transition: opacity 0.25s ease, visibility 0.25s;
        z-index: 1000;
        }

        .confirm-overlay.active {
        visibility: visible;
        opacity: 1;
        }

        .confirm-box {
        background-color: var(--color-bege-claro);
        border-radius: 14px;
        padding: 1.8rem;
        max-width: 360px;
        width: 90%;
        text-align: center;
        box-shadow: 0 8px 24px var(--color-shadow);
        }

        .confirm-title {
        color: var(--color-vinho);
        font-size: 1.3rem;
        font-weight: 600;
        margin-bottom: 0.6rem;
        }

        .confirm-message {
        color: var(--color-vinho-fundo);
        margin-bottom: 1.5rem;
        }

        .confirm-buttons {
        display: flex;
        justify-content: center;
        gap: 0.8rem;
        }

        .btn-cancelar,
        .btn-confirmar {
        padding: 0.5rem 1.3rem;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        cursor: pointer;
        transition: 0.2s;
        }

        .btn-cancelar {
        background-color: var(--color-vinho);
        color: var(--color-bege-claro);
        border: 2px solid var(--color-vinho);
        }

        .btn-cancelar:hover {
        background-color: var(--color-bege-claro);
        color: var(--color-vinho);
        border: 2px solid var(--color-vinho);
        }

        .btn-confirmar {
        background-color: var(--color-bege-claro);
        color: var(--color-vinho);
        border: 2px solid var(--color-vinho);
        }

        .btn-confirmar:hover {
        background-color: var(--color-vinho);
        color: var(--color-bege-claro);
        border: 2px solid var(--color-vinho);
        }


</style>
@endsection

@section('content')

<div class="container-fluid py-3">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold mb-0">{{ __('suppliers.title') }}</h2>
        <div class="d-flex align-items-center gap-3">
            <form action="{{ route('pesquisa.index') }}" method="GET" class="search-bar">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('suppliers.search_placeholder') }}">
                <button type="submit" style="background: none; border: none; color: #fff;">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <x-btn-mais href="{{ route('suppliers.create') }}" />
        </div>
    </div>

    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th></th>
                    <th>{{ __('suppliers.name') }}</th>
                    <th>{{ __('suppliers.code') }}</th>
                    <th>{{ __('suppliers.document') }}</th>
                    <th>{{ __('suppliers.distributor') }}</th>
                    <th>{{ __('suppliers.contact') }}</th>
                    <th>{{ __('suppliers.address') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($suppliers as $supplier)
                <tr>
                    <td></td>
                    <td>{{ $supplier->name }}</td>
                    <td>{{ $supplier->code }}</td>
                    <td>{{ $supplier->document }}</td>
                    <td>{{ $supplier->distributor }}</td>
                    <td>
                        {{ $supplier->fixedphone }}
                        <i id="toggleIconC{{ $supplier->id }}" onclick="seemorecontat('{{ $supplier->id }}')" class="bi bi-plus-circle-fill"></i>
                    </td>
                    <td style="display: flex; align-items: center;">
                        <p style="position: relative; max-width: 150px; white-space: nowrap; margin-top: 15px; overflow: hidden; text-overflow: ellipsis;">
                            @if($supplier->address)
                            {{ $supplier->address->place }}, Nº {{ $supplier->address->number }}, {{ $supplier->address->neighborhood }}
                            @else
                            {{ __('suppliers.not_informed') }}
                            @endif
                        </p>
                        <i id="toggleIconA{{ $supplier->id }}" onclick="seemoreaddresses('{{ $supplier->id }}')" class="bi bi-plus-circle-fill"></i>
                    </td>
                    <td>
                        <x-btn-tres-pontos class="tres-pontos" id="dropdownMenuButton{{ $supplier->id }}">
                            <li>
                                <a class="dropdown-item" href="{{ route('suppliers.edit', $supplier->id) }}">{{ __('suppliers.edit') }}</a>
                            </li>
                            <li>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirmarExclusaoCustom(event, this);">
                                    @csrf
                                    @method('DELETE')
                                    <button class="dropdown-item text-danger" type="submit">{{ __('suppliers.delete') }}</button>
                                </form>
                            </li>
                        </x-btn-tres-pontos>
                    </td>
                </tr>
                <tr id="addresses{{ $supplier->id }}" style="display: none;">
                    <td colspan="8">
                        @if($supplier->address)
                        <strong>{{ __('suppliers.address') }}:</strong> {{ $supplier->address->place }}, Nº {{ $supplier->address->number }}, {{ $supplier->address->neighborhood }} <br>
                        <strong>{{ __('suppliers.zip') }}:</strong> {{ $supplier->address->cep }} <br>
                        <strong>{{ __('suppliers.city') }}:</strong> {{ $supplier->address->city }} - {{ $supplier->address->state }}
                        @else
                        <strong>{{ __('suppliers.address') }}:</strong> {{ __('suppliers.not_registered') }}
                        @endif
                    </td>
                </tr>
                <tr id="contacts{{ $supplier->id }}" style="display: none;">
                    <td colspan="8">
                        <strong>{{ __('suppliers.fixed_phone') }}:</strong> {{ $supplier->fixedphone }} <br>
                        <strong>{{ __('suppliers.mobile') }}:</strong> {{ $supplier->phone }} <br>
                        <strong>{{ __('suppliers.email') }}:</strong> {{ $supplier->email }} <br>
                        <strong>{{ __('suppliers.contact1') }}:</strong> {{ $supplier->contactName1 }} - {{ $supplier->contactPosition1 }} - {{ $supplier->contactNumber1 }} <br>
                        <strong>{{ __('suppliers.contact2') }}:</strong> {{ $supplier->contactName2 }} - {{ $supplier->contactPosition2 }} - {{ $supplier->contactNumber2 }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">{{ __('suppliers.no_suppliers') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div id="confirmModal" class="confirm-overlay">
        <div class="confirm-box">
            <h3 class="confirm-title">Confirmar exclusão</h3>
            <p class="confirm-message">Tem certeza que deseja excluir este fornecedor?</p>
            <div class="confirm-buttons">
            <button id="cancelDelete" class="btn-cancelar">Cancelar</button>
            <button id="confirmDelete" class="btn-confirmar">Excluir</button>
            </div>
        </div>
    </div>

    <script>
        let formToDelete = null;

        function confirmarExclusaoCustom(event, form) {
            event.preventDefault();
            formToDelete = form;
            document.getElementById('confirmModal').classList.add('active');
        }

        document.getElementById('cancelDelete').addEventListener('click', () => {
            document.getElementById('confirmModal').classList.remove('active');
        });

        document.getElementById('confirmDelete').addEventListener('click', () => {
            if (formToDelete) formToDelete.submit();
        });
    </script>

    <x-paginacao :paginator="$suppliers" />
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