@extends('layouts.app') 

@section('styles')
<style>
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
        color: var(--color-white);
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
        color: var(--color-white);
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
        border: 2px solid var(--color-green);
        border-radius: 8px;
        background: var(--color-white);
    }

    td p {
        margin-bottom: 0;
    }

    .dropdown-item, .tres-pontos{
        z-index: 1000;
    }

</style>
@endsection

@section('content')
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="{{ __('suppliers.close') }}"></button>
</div>
@endif

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
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width:32px"></th>
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
                            {{ __('suppliers.not_informed') }}
                            @endif
                        </p>
                        <i id="toggleIconA{{ $supplier->id }}" onclick="seemoreaddresses('{{ $supplier->id }}')" class="bi bi-plus-circle-fill" style="cursor: pointer;"></i>
                    </td>
                    <td>
                        <x-btn-tres-pontos class="tres-pontos" id="dropdownMenuButton{{ $supplier->id }}">
                            <li>
                                <a class="dropdown-item" href="{{ route('suppliers.edit', $supplier->id) }}">{{ __('suppliers.edit') }}</a>
                            </li>
                            <li>
                                <form action="{{ route('suppliers.destroy', $supplier->id) }}" method="POST" onsubmit="return confirm('{{ __('suppliers.confirm_delete') }}');">
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