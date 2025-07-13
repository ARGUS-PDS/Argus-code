@extends('layouts.app')

@section('styles')
<style>
    /* Estilos da barra de pesquisa */
    .search-bar {
        background: var(--color-vinho);
        /* Usando sua variável de cor vinho */
        border-radius: 20px;
        padding: 6px 16px;
        color: #fff;
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

    .search-bar:hover {
        /* Adicionado hover para o search-bar */
        background: rgb(136, 59, 67);
        /* Um tom um pouco mais claro de vinho no hover */
    }

    .search-bar .bi-search {
        color: #ccc;
        /* Alterado para uma cor mais clara para o ícone */
        font-size: 1.2rem;
        margin-left: 8px;
    }

    .search::placeholder {
        color: #FFFFFF
    }

    /* Estilos da tabela */
    /* O background das células do <tbody> ficará branco por padrão do navegador/bootstrap */
    .table thead th {
        background: var(--color-vinho);
        /* Cabeçalho da tabela com a cor principal (vinho) */
        color: var(--color-bege-claro);
        /* Texto do cabeçalho com a cor clara (bege) */
        border-bottom: none;
        /* Remove a borda inferior padrão */
    }

    .table tbody tr:hover {
        background-color: rgba(119, 49, 56, 0.1);
        /* Um leve efeito de hover nas linhas (vinho com transparência) */
    }

    /* Borda arredondada para a tabela */
    .table-responsive {
        border-radius: 15px;
        overflow: hidden;
        /* Garante que as bordas arredondadas sejam visíveis */
    }

    .img-thumb {
        /* Este estilo parece não ser usado em fornecedores, mas mantido se houver imagens futuras */
        width: 40px;
        height: 40px;
        object-fit: cover;
        border: 2px solid #198754;
        border-radius: 8px;
        background: #fff;
    }

    /* Botão Adicionar */
    .add-btn {
        border: 2px solid var(--color-vinho);
        /* Borda com cor vinho */
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--color-vinho);
        /* Ícone com cor vinho */
        background: none;
        cursor: pointer;
        margin-left: 8px;
        transition: background 0.5s, color 0.5s;
        /* Adicionado transition para cor */
    }

    .add-btn:hover {
        background: var(--color-vinho);
        /* Fundo vinho no hover */
        color: var(--color-bege-claro);
        /* Ícone bege claro no hover */
    }

    .menu-dot {
        font-size: 1.5rem;
        color: var(--color-gray-escuro);
        /* Usando variável de cor */
        cursor: pointer;
        text-align: center;
    }

    /* Estilos para os ícones de expandir/recolher informações de contato e endereço */
    .bi-plus-circle-fill,
    .bi-dash-circle-fill {
        color: var(--color-vinho);
        /* Usando a cor vinho para os ícones de ação */
        margin-left: 5px;
        /* Pequena margem para separar do texto */
    }

    /* Estilo para o parágrafo de endereço truncado */
    td p {
        margin-bottom: 0;
        /* Remove a margem inferior padrão de parágrafos dentro de células da tabela */
    }
</style>
@endsection

@section('content')
{{-- Alerta de sucesso (mantido, pois é parte do conteúdo da página) --}}
@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
</div>
@endif

<div class="container-fluid py-3"> {{-- Usando container-fluid para largura total e padding --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold mb-0">Fornecedores</h2>
        <div class="d-flex align-items-center gap-3">
            <form action="{{ route('pesquisa.index') }}" method="GET" class="search-bar">
                <input class="search" type="text" name="q" value="{{ request('q') }}" placeholder="Pesquisar por nome ou código...">
                <button type="submit" style="background: none; border: none; color: #fff;">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <span class="ms-4 text-secondary">Estoque atual: </span> {{-- Você pode querer remover ou ajustar "Estoque atual" aqui --}}
            {{-- <i class="bi bi-trash fs-4 ms-2" title="Excluir" style="cursor:pointer;"></i> --}} {{-- Ícone de lixeira comentado --}}
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
                    <td style="display: flex; align-items: center;"> {{-- Adicionado align-items: center para alinhar o texto e o ícone --}}
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
                            <i class="bi bi-three-dots-vertical dropdown-toggle" role="button" id="dropdownMenuButton{{ $supplier->id }}" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer; color: var(--color-gray-escuro);"></i> {{-- Usando variável de cor --}}
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
                {{-- Linhas expandidas para detalhes de endereço e contato --}}
                <tr id="addresses{{ $supplier->id }}" style="display: none;">
                    <td colspan="8"> {{-- Colspan ajustado para cobrir todas as colunas --}}
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
                    <td colspan="8"> {{-- Colspan ajustado para cobrir todas as colunas --}}
                        <strong>Telefone Fixo:</strong> {{ $supplier->fixedphone }} <br>
                        <strong>Celular:</strong> {{ $supplier->phone }} <br>
                        <strong>Email:</strong> {{ $supplier->email }} <br>
                        <strong>Contato 1:</strong> {{ $supplier->contactName1 }} - {{ $supplier->contactPosition1 }} - {{ $supplier->contactNumber1 }} <br>
                        <strong>Contato 2:</strong> {{ $supplier->contactName2 }} - {{ $supplier->contactPosition2 }} - {{ $supplier->contactNumber2 }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">Nenhum fornecedor cadastrado.</td> {{-- Colspan ajustado --}}
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