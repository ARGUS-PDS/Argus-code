@extends('layouts.app')


@section('styles')
<style>
    /* Estilos da barra de pesquisa */
    .search-bar {
        background: #773138;
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
        background: rgb(136, 59, 67);
    }

    .search-bar .bi-search {
        color: #ccc;
        font-size: 1.2rem;
        margin-left: 8px;
    }

    .search::placeholder {
        color: #FFFFFF
    }

    /* Estilos da tabela */
    .table th,
    .table td {
        vertical-align: middle;
        /* As cores de fundo da tabela e texto devem vir das variáveis do app.blade.php ou serem ajustadas */
        background: #773138;
        /* Se você quer manter essa cor específica para a tabela de produtos */
        color: #FFFFFF;
    }

    /* Ajustes específicos para o cabeçalho e corpo da tabela, para usar suas cores */
    .table {
        --bs-table-bg: var(--color-vinho-fundo);
        /* Usando variável de cor definida em css-variables */
        --bs-table-color: var(--color-gray-escuro);
        /* Usando variável de cor definida em css-variables */
    }

    .table thead th {
        background: var(--color-vinho);
        /* Cabeçalho da tabela com a cor principal */
        color: var(--color-bege-claro);
        /* Texto do cabeçalho com a cor clara */
        border-bottom: none;
        /* Remover borda inferior do cabeçalho se desejar */
    }

    .table tbody tr:hover {
        background-color: rgba(119, 49, 56, 0.1);
        /* Um leve hover nas linhas, ajustado à sua paleta */
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
        border: 2px solid #773138;
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: #773138;
        background: none;
        cursor: pointer;
        margin-left: 8px;
        transition: background 0.5s;
    }

    .add-btn:hover {
        background: #773138;
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
    }

    /* Removido todos os estilos relacionados a .sidebar, .sideS, .sideL */
</style>
@endsection

@section('content')
<div class="container-fluid py-3"> {{-- Usando container-fluid para largura total e padding --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold mb-0">Produtos</h2>
        <div class="d-flex align-items-center gap-3">
            <form action="{{ route('pesquisa.index') }}" method="GET" class="search-bar">
                <input class="search" type="text" name="q" value="{{ request('q') }}" placeholder="Pesquisar por nome ou código...">
                <button type="submit" style="background: none; border: none; color: #fff;">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <span class="ms-4 text-secondary">Estoque atual: {{ $products->sum('currentStock') }}</span>
            <i class="bi bi-printer fs-4 ms-3" title="Imprimir" style="cursor:pointer; color: var(--color-gray-escuro);"></i> {{-- Use var() para consistência --}}
            <a href="{{ route('products.create') }}" class="btn btn-primary add-btn ms-2" title="Adicionar">
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
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ $product->id }}">
                                <li>
                                    <a class="dropdown-item" href="{{ route('products.edit', $product->id) }}">Editar</a>
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