@extends('layouts.app')

@section('styles')
<style>
    
    body {
        background-color: var(--color-bege-claro);
        padding: 0;
        margin: 0;
    }

    .container-fluid.py-3 {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
    }

    h2 {
        color: var(--color-vinho);
        font-weight: bold;
        margin-bottom: 0;
    }

    /* Estilos da barra de pesquisa - PADRÃO VINHO COM TEXTO BEGE CLARO */
    .search-bar {
        background: var(--color-vinho); /* Fundo vinho por padrão */
        border-radius: 20px;
        padding: 6px 16px;
        color: var(--color-bege-claro); /* Texto bege claro por padrão */
        width: 300px;
        display: flex;
        align-items: center;
        border: 2px solid var(--color-vinho); /* Borda vinho por padrão */
        transition: background 0.3s ease, color 0.3s ease, border-color 0.3s ease;
    }

    .search-bar input {
        background: transparent;
        border: none;
        outline: none;
        width: 90%;
        color: var(--color-bege-claro); /* Texto digitado bege claro por padrão */
    }

    .search-bar input::placeholder {
        color: var(--color-bege-claro); /* Placeholder bege claro por padrão */
        opacity: 1;
    }

    .search-bar:hover {
        background: transparent; /* Fundo transparente no hover */
        border-color: var(--color-vinho); /* Borda vinho no hover */
        color: var(--color-vinho); /* Texto vinho no hover */
    }

    .search-bar:hover input {
        color: var(--color-vinho); /* Texto digitado vinho no hover */
    }

    .search-bar:hover input::placeholder {
        color: var(--color-vinho) !important;
        opacity: 1 !important;
    }

    .search-bar .bi-search {
        color: var(--color-bege-claro); /* Ícone bege claro por padrão */
        font-size: 1.2rem;
        margin-left: 8px;
        border: none;
        transition: color 0.3s ease;
    }

    .search-bar:hover .bi-search {
        color: var(--color-vinho); /* Ícone vinho no hover */
    }

    /* Estilos da tabela - VOLTOU PARA O FUNDO BEGE */
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
        border-top: 1px solid rgba(119, 49, 56, 0.1);
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

    .img-thumb {
        width: 80px;
        height: 80px;
        object-fit: cover;
        border: 3px solid var(--color-vinho);
        border-radius: 12px;
        background: var(--color-bege-card-interno); /* Fundo bege para imagem/placeholder */
        padding: 2px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .text-muted.small {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;
        border: 1px dashed var(--color-gray-claro);
        border-radius: 12px;
        text-align: center;
        font-size: 0.75rem;
        color: var(--color-gray-escuro) !important;
        background-color: var(--color-bege-card-interno); /* Fundo bege para placeholder */
        padding: 5px;
    }

    .btn.p-0 {
        color: var(--color-vinho);
        transition: color 0.3s ease, transform 0.2s ease;
    }

    .btn.p-0:hover {
        color: var(--color-vinho);
        transform: scale(1.1);
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
        transition: background 0.3s ease, color 0.3s ease;
    }

    .add-btn:hover {
        background: var(--color-vinho);
        color: var(--color-bege-claro);
    }

    .dropdown .dropdown-toggle {
        color: var(--color-vinho) !important;
        transition: color 0.3s ease;
    }

    .dropdown .dropdown-toggle:hover {
        color: var(--color-vinho);
    }

    .dropdown-menu {
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .dropdown-item {
        color: var(--color-gray-escuro);
    }

    .dropdown-item:hover {
        background-color: var(--color-bege-claro);
        color: var(--color-vinho);
    }

    .dropdown-item.text-danger:hover {
        background-color: var(--color-red);
        color: #fff;
    }

    @media (max-width: 768px) {
        .search-bar {
            width: 100%;
            margin-bottom: 1rem;
        }
        .d-flex.align-items-center.justify-content-between.mb-4 {
            flex-direction: column;
            align-items: flex-start !important;
        }
        .d-flex.align-items-center {
            margin-top: 1rem;
            width: 100%;
            justify-content: space-around;
        }
        .table-responsive {
            margin-top: 1rem;
        }
        .img-thumb {
            width: 50px;
            height: 50px;
            margin-left: 0;
        }
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-3">
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap">
        <h2 class="fw-bold mb-0">{{ __('products.title') }}</h2>
        <div class="d-flex align-items-center" style="gap: 16px;">
            <form action="{{ url()->current() }}" method="GET" class="search-bar" autocomplete="off">
                <input class="search" type="text" name="q" value="{{ request('q') }}" placeholder="{{ __('products.search_placeholder') }}">
                <datalist id="produtos-list">
                    @foreach($products as $produto)
                        <option value="{{ $produto->description }}">{{ $produto->barcode }}</option>
                        <option value="{{ $produto->barcode }}">{{ $produto->description }}</option>
                    @endforeach
                </datalist>
                <button type="submit" style="background: none; border: none; padding: 0;">
                    <i class="bi bi-search"></i>
                </button>
            </form>
            <span class="ms-4 fw-bold" style="color: var(--color-vinho);">
                {{ __('products.current_stock') }}: {{ ($products->currentPage() * $products->perPage() > $products->total()) ? $products->total() : $products->currentPage() * $products->perPage() }}/{{ $products->total() }}
            </span>
            <button type="button" class="btn p-0" title="{{ __('products.print') }}">
                <i class="bi bi-printer fs-4"></i>
            </button>
            <form id="massDeleteForm" action="{{ route('products.massDelete') }}" method="POST" style="display:none;">
                @csrf
                <input type="hidden" name="ids" id="deleteIds">
            </form>
            <button type="button" class="btn p-0" title="{{ __('products.delete') }}" onclick="submitMassDelete()">
                <i class="bi bi-trash fs-4"></i>
            </button>
            <a href="{{ route('products.create') }}" class="btn add-btn" title="{{ __('products.add') }}">
                <i class="bi bi-plus"></i>
            </a>
        </div>
    </div>
    <div id="selected-count" class="mb-2 ms-1" style="color: var(--color-vinho); font-weight: bold; display: none;">
        Selecionados: <span id="selectedValue">0</span>
    </div>

    <div class="table-responsive">
        <table class="table align-middle products-table">
            <thead>
    <tr>
        <th class="text-center" style="width:32px;"></th>
        <th class="text-center">{{ __('products.image') }}</th>
        <th>{{ __('products.name') }}</th>
        <th>{{ __('products.code') }}</th>
        <th class="text-center">{{ __('products.supplier') }}</th>
        <th class="text-center">{{ __('products.price') }}</th>
        <th class="text-center"></th>
    </tr>
</thead>
<tbody>
    @forelse ($products as $product)
    <tr onclick="window.location='{{ route('products.edit', $product->id) }}'" style="cursor:pointer;">
        <td class="text-center"><input type="checkbox" onclick="event.stopPropagation();"></td>
                    <td class="text-center">
                        @php
                            $imgPath = public_path($product->image_url ?? '');
                        @endphp
                        @if (!empty($product->image_url) && file_exists($imgPath))
                            <img src="{{ asset($product->image_url) }}" alt="Imagem do produto" class="img-thumb" loading="lazy">
                        @else
                            <i class="bi bi-image img-thumb" style="font-size: 2rem; padding-top: 15px; padding-bottom: 15px; padding-left: 20px; padding-right: 20px; color: var(--color-vinho-fundo);"></i>
                        @endif
                    </td>
                    <td>{{ $product->description }}</td>
                    <td>{{ $product->barcode }}</td>
                    <td class="text-center">{{ $product->supplier ? $product->supplier->name : __('products.no_supplier') }}</td>
                    <td class="text-center">R$ {{ number_format($product->value, 2, ',', '.') }}</td>
                    <td class="text-center">
                        <div class="dropdown">
                            <i class="bi bi-three-dots-vertical" role="button" id="dropdownMenuButton{{ $product->id }}" data-bs-toggle="dropdown" aria-expanded="false" onclick="event.stopPropagation();"></i>
                            <ul class="dropdown-menu" data-bs-boundary="viewport" aria-labelledby="dropdownMenuButton{{ $product->id }}" onclick="event.stopPropagation();">
                                <li>
                                <a class="dropdown-item" href="">{{ __('products.print') }}</a>
                                </li>
                                <li>
                                    <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ __('products.confirm_delete') }}');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="dropdown-item text-danger" type="submit">{{ __('products.delete') }}</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-4">{{ __('products.no_records') }}</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-center mt-4">
        @if ($products->onFirstPage())
            <button class="btn btn-secondary me-2" disabled>Anterior</button>
        @else
            <a href="{{ $products->previousPageUrl() }}" class="btn btn-primary me-2">Anterior</a>
        @endif
        @if ($products->hasMorePages())
            <a href="{{ $products->nextPageUrl() }}" class="btn btn-primary">Próximo</a>
        @else
            <button class="btn btn-secondary" disabled>Próximo</button>
        @endif
    </div>
    {{-- Links de paginação --}}
    
    
</div>
@endsection

<script>
    // Atualiza o contador de selecionados
    function updateSelectedCount() {
        const checkboxes = document.querySelectorAll('.products-table input[type="checkbox"]');
        const count = Array.from(checkboxes).filter(cb => cb.checked).length;
        document.getElementById('selectedValue').textContent = count;
        document.getElementById('selected-count').style.display = count > 0 ? 'block' : 'none';
    }
    document.addEventListener('DOMContentLoaded', function() {
        const checkboxes = document.querySelectorAll('.products-table input[type="checkbox"]');
        checkboxes.forEach(cb => cb.addEventListener('change', updateSelectedCount));
        updateSelectedCount();
    });

    function submitMassDelete() {
        const checkboxes = document.querySelectorAll('.products-table input[type="checkbox"]');
        const ids = Array.from(checkboxes)
            .map((cb, idx) => cb.checked ? @json($products->items()) [idx].id : null)
            .filter(id => id !== null);
        if (ids.length === 0) {
            alert('Selecione pelo menos um produto para excluir.');
            return;
        }
        if (!confirm('Tem certeza que deseja excluir os produtos selecionados?')) return;
        document.getElementById('deleteIds').value = ids.join(',');
        document.getElementById('massDeleteForm').submit();
    }
</script>

<script>
function renderProductsTable(products) {
    let html = '';
    products.forEach(product => {
        html += `<tr onclick="window.location='${product.edit_url}'" style="cursor:pointer;">`;
        html += `<td class='text-center'><input type='checkbox' onclick='event.stopPropagation();'></td>`;
        html += `<td class='text-center'>`;
        if (product.image_url && product.image_exists) {
            html += `<img src='${product.image_url}' alt='Imagem do produto' class='img-thumb' loading='lazy'>`;
        } else {
            html += `<i class='bi bi-image img-thumb' style='font-size: 2rem; padding-top: 15px; padding-bottom: 15px; padding-left: 20px; padding-right: 20px; color: var(--color-vinho-fundo);'></i>`;
        }
        html += `</td>`;
        html += `<td>${product.description}</td>`;
        html += `<td>${product.barcode}</td>`;
        html += `<td class='text-center'>${product.supplier ? product.supplier.name : 'Sem fornecedor'}</td>`;
        html += `<td class='text-center'>R$ ${parseFloat(product.value).toLocaleString('pt-BR', {minimumFractionDigits: 2})}</td>`;
        html += `<td class='text-center'>`;
        html += `<div class='dropdown'>`;
        html += `<i class='bi bi-three-dots-vertical' role='button' data-bs-toggle='dropdown' aria-expanded='false' onclick='event.stopPropagation();'></i>`;
        html += `<ul class='dropdown-menu' data-bs-boundary='viewport'>`;
        html += `<li><a class='dropdown-item' href='#'>Imprimir</a></li>`;
        html += `<li><form action='/products/${product.id}' method='POST' onsubmit="return confirm('Tem certeza que deseja excluir?');">`;
        html += `@csrf @method('DELETE')`;
        html += `<button class='dropdown-item text-danger' type='submit'>Excluir</button></form></li>`;
        html += `</ul></div></td></tr>`;
    });
    document.querySelector('.products-table tbody').innerHTML = html;
}

// Função para renderizar a paginação
function renderPagination(current, last) {
    let html = '';
    if (last > 1) {
        html += `<div class='d-flex justify-content-center mt-4'>`;
        if (current === 1) {
            html += `<button class='btn btn-secondary me-2' disabled>Anterior</button>`;
        } else {
            html += `<button class='btn btn-primary me-2' onclick='fetchProducts(${current - 1})'>Anterior</button>`;
        }
        if (current < last) {
            html += `<button class='btn btn-primary' onclick='fetchProducts(${current + 1})'>Próximo</button>`;
        } else {
            html += `<button class='btn btn-secondary' disabled>Próximo</button>`;
        }
        html += `</div>`;
    }
    document.getElementById('ajax-pagination').innerHTML = html;
}

// Função para buscar produtos via AJAX
function fetchProducts(page = 1) {
    const q = document.querySelector('.search-bar input[name="q"]').value;
    fetch(`{{ route('products.index') }}?q=${encodeURIComponent(q)}&page=${page}`, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
        .then(res => res.json())
        .then(data => {
            renderProductsTable(data.data);
            renderPagination(data.current_page, data.last_page);
            document.querySelector('.ms-4.fw-bold').textContent = `Estoque atual: ${data.data.length}/${data.total}`;
        });
}

// Evento de busca dinâmica
const searchInput = document.querySelector('.search-bar input[name="q"]');
if (searchInput) {
    searchInput.addEventListener('input', function() {
        fetchProducts(1);
    });
}
// Substituir a paginação tradicional por um container para paginação AJAX
const pagDiv = document.createElement('div');
pagDiv.id = 'ajax-pagination';
document.querySelector('.products-table').after(pagDiv);
// Inicializar com a página atual
// fetchProducts(1);
</script>