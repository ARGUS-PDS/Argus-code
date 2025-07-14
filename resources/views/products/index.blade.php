@extends('layouts.app')


@section('styles')
<style>
    /* Estilos da barra de pesquisa */
    .search-bar {
        background: transparent;
        border-radius: 20px;
        padding: 6px 16px;
        color: var(--color-vinho);
        width: 300px;
        display: flex;
        align-items: center;
        border: 2px solid var(--color-vinho);
    }

    .search-bar input {
        background: transparent;
        border: none;
        outline: none;
        width: 90%;
    }

    .search-bar:hover {
        background: var(--color-vinho);
        color: var(--color-bege);
    }

    .search-bar:hover .bi-search{
        color: var(--color-bege-claro);
    }

    .search-bar .bi-search {
        color: var(--color-vinho);
        font-size: 1.2rem;
        margin-left: 8px;
        border: none
    }

    .search::placeholder {
        color:var(--color-vinho);
    }

    .search-bar:hover input.search::placeholder {
        color: var(--color-bege-claro) !important;
        opacity: 1 !important;
    }

    /* Estilos da tabela */
    .table th {
        vertical-align: middle;
        background: var(--color-vinho);
        color: var(--color-bege-claro);
        border-bottom: none;
    }

    .table td {
        vertical-align: middle;
        background: transparent;
        color: var(--color-vinho);
    }

    /* Ajustes específicos para o cabeçalho e corpo da tabela, para usar suas cores */
    .table {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px var(--color-vinho-fundo);
        background: var(--color-bege-claro);
        margin: 16px 0;
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


    .img-thumb {
        width: 40px;
        height: 40px;
        margin-left: 20px;
        object-fit: cover;
        border: 2px solid #198754;
        border-radius: 8px;
        background: #fff;
    }

    .add-btn {
        border: 2px solid  var(--color-vinho);
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
        transition: background 0.5s;
    }

    .add-btn:hover {
        background: var(--color-vinho);
        color: #fff;
        /* O texto fica branco quando o fundo do botão fica escuro no hover */
    }

    .menu-dot {
        font-size: 1.5rem;
        color: #767676;
        cursor: pointer;
        text-align: center;
    }

    .table-responsive {
        margin: 0;
        padding: 0;
        overflow-x: auto;
        /* Remover overflow-y e overflow: visible daqui */
    }

    .table-responsive,
    .table,
    .container-fluid,
    body {
        overflow: visible !important;
    }

    /* Removido todos os estilos relacionados a .sidebar, .sideS, .sideL */
</style>
@endsection

@section('content')
<div class="container-fluid py-3"> {{-- Usando container-fluid para largura total e padding --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold mb-0" style="color: var(--color-vinho);">Produtos</h2>
        <div class="d-flex align-items-center" style="gap: 16px;">
            <form action="{{ url()->current() }}" method="GET" class="search-bar" autocomplete="off">
                <input class="search" type="text" name="q" value="{{ request('q') }}" placeholder="Pesquisar por nome ou código de barras..." list="produtos-list">
                <datalist id="produtos-list">
                    @foreach($products as $produto)
                        <option value="{{ $produto->description }}">{{ $produto->barcode }}</option>
                        <option value="{{ $produto->barcode }}">{{ $produto->description }}</option>
                    @endforeach
                </datalist>
                <button type="submit" style="background: none; border: none; color: #fff;">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <span class="ms-4" style="color: var(--color-vinho-fundo);">Estoque atual: {{ $products->sum('currentStock') }}</span>
            <button type="button" class="btn p-0" title="Imprimir" style="background:none; border:none; color: var(--color-vinho);">
                <i class="bi bi-printer fs-4"></i>
            </button>
            <button type="button" class="btn p-0" title="Excluir" style="background:none; border:none; color: var(--color-vinho);">
                <i class="bi bi-trash fs-4"></i>
            </button>
            <a href="{{ route('products.create') }}" class="btn add-btn d-flex align-items-center justify-content-center p-0" title="Adicionar" style="width: 36px; height: 36px;">
                <i class="bi bi-plus"></i>
            </a>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table align-middle">
            <thead>
                <tr>
                    <th style="width:32px;"></th>
                    <th>Imagem</th>
                    <th>Nome</th>
                    <th>Fornecedor</th>
                    <th>Código</th>
                    <th>Estoque</th>
                    <th>Preço</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td><input type="checkbox"></td>
                    <td>
                        @if ($product->image_url)
                        <img src="{{ asset($product->image_url) }}" alt="Imagem do produto" class="img-thumb">
                        @else
                        <span class="text-muted small">Sem imagem</span>
                        @endif
                    </td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->supplier ? $product->supplier->name : 'Sem fornecedor' }}</td>
                    <td>{{ $product->code }}</td>
                    <td>{{ $product->currentStock }}</td>
                    <td>R$ {{ number_format($product->value, 2, ',', '.') }}</td>
                    <td>
                        <div class="dropdown">
                            <i class="bi bi-three-dots-vertical dropdown-toggle" role="button" id="dropdownMenuButton{{ $product->id }}" data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer; color: var(--color-gray-escuro);"></i> {{-- Use var() para consistência --}}
                            <ul class="dropdown-menu" data-bs-boundary="viewport" aria-labelledby="dropdownMenuButton{{ $product->id }}">
                                <li>
                                    <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">Editar</a>
                                </li>
                                 <li>
                                    <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">Imprimir</a>
                                </li>
                                <li>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir este produto?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit">Excluir</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-muted py-4">Nenhum produto cadastrado.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection