@extends('layouts.app')

@section('content')

<style>
.img-thumb {
    width: 60px; 
    height: 60px; 
    object-fit: cover; 
    border-radius: 4px; 
}
</style>

<div class="container mt-4" id="frente-container">
    <h2>{{ __('pos.titulo') }}</h2>

    <div class="d-flex justify-content-start mb-3">
        <button class="btn btn-primary" id="nova-venda">{{ __('pos.nova_venda_btn') }}</button>
    </div>

    <div class="row">
        <div class="col-md-8">
            <input type="text" id="barcode" class="form-control mb-3" placeholder="{{ __('pos.placeholder_codigo_barras') }}" autocomplete="off">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>{{ __('pos.foto') }}</th>
                        <th>{{ __('pos.produto') }}</th>
                        <th>{{ __('pos.valor') }}</th>
                        <th>{{ __('pos.quantidade_abreviado') }}</th>
                        <th>{{ __('pos.total') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cart-body"></tbody>
            </table>
        </div>

        <div class="col-md-4">
            <h5>{{ __('pos.pedidos_titulo') }}</h5>
            <ul id="lista-pedidos" class="list-group"></ul>
        </div>
    </div>
</div>

<div id="frente-footer" class="d-flex justify-content-end align-items-center p-3 border-top bg-white position-fixed w-100" style="bottom:0; left:0; z-index: 1000;">
    <h4 class="me-3">{{ __('pos.total') }}: R$ <span id="total">0.00</span></h4>
    <button class="btn btn-success" id="finalizar">{{ __('pos.finalizar_venda_btn') }}</button>
</div>

<style>
</style>

<script>
let pedidos = [];
let pedidoAtual = null;
let contadorPedidos = 1;

function carregarPedidos() {
    const dataSalva = localStorage.getItem('frente_caixa_data');
    const hoje = new Date().toISOString().split('T')[0];

    if (dataSalva === hoje) {
        const dados = JSON.parse(localStorage.getItem('frente_caixa'));
        if (dados) {
            pedidos = dados.pedidos || [];
            contadorPedidos = dados.contadorPedidos || 1;
            pedidoAtual = pedidos.find(p => !p.finalizado) || null;
        }
    } else {
        pedidos = [];
        pedidoAtual = null;
        contadorPedidos = 1;
        localStorage.setItem('frente_caixa_data', hoje);
        salvarPedidos();
    }
}

function salvarPedidos() {
    localStorage.setItem('frente_caixa', JSON.stringify({
        pedidos,
        contadorPedidos
    }));
}

function novaVenda() {
    const novo = {
        id: contadorPedidos,
        itens: [],
        total: 0,
        finalizado: false
    };
    pedidos.push(novo);
    pedidoAtual = novo;
    contadorPedidos++;
    renderPedidos();
    renderCart();
    salvarPedidos();
}

function renderPedidos() {
    const lista = document.getElementById('lista-pedidos');
    lista.innerHTML = '';
    // Exibe apenas pedidos não finalizados
    pedidos.filter(p => !p.finalizado).forEach(p => {
        const ativo = (pedidoAtual && pedidoAtual.id === p.id) ? 'active' : '';
        lista.innerHTML += `
            <li class="list-group-item d-flex justify-content-between align-items-center ${ativo}">
                <span onclick="selecionarPedido(${p.id})" style="cursor:pointer;">
                    {{ __('pos.pedido_numero') }} ${p.id}
                </span>
                <button class="btn btn-sm btn-danger" onclick="apagarPedido(${p.id})">X</button>
            </li>
        `;
    });
}

function apagarPedido(id) {
    const index = pedidos.findIndex(p => p.id === id);
    if (index === -1) return;

    if (!confirm(`{{ __('pos.confirmar_apagar_pedido') }}`.replace(':id', id))) return;

    pedidos.splice(index, 1);

    if (pedidoAtual && pedidoAtual.id === id) {
        const aberto = pedidos.find(p => !p.finalizado) || null;
        pedidoAtual = aberto;
    }

    renderPedidos();
    renderCart();
    salvarPedidos();
}

function selecionarPedido(id) {
    const selecionado = pedidos.find(p => p.id === id);
    if (selecionado) {
        pedidoAtual = selecionado;
        renderCart();
        renderPedidos();
    }
}

function renderCart() {
    const tbody = document.getElementById('cart-body');
    tbody.innerHTML = '';
    if (!pedidoAtual) {
        document.getElementById('total').innerText = '0.00';
        return;
    }

    let total = 0;
    pedidoAtual.itens.forEach((item, index) => {
        const subtotal = item.unit_price * item.quantity;
        total += subtotal;
        tbody.innerHTML += `
            <tr>
                <td class="text-center">
                    ${
                        item.image_url 
                        ? `<img src="${item.image_url}" alt="Produto" class="img-thumb" loading="lazy">`
                        : `<div class="img-thumb d-flex align-items-center justify-content-center" style="background: var(--color-bege-card-interno);">
                            <i class="bi bi-image" style="font-size: 1.5rem; color: var(--color-vinho-fundo);"></i>
                        </div>`
                    }
                </td>
                <td class="descricao-produto">${item.description ?? ''}</td>
                <td>
                    <input type="number" min="0" step="0.01" value="${item.unit_price.toFixed(2)}" onchange="updatePrice(${index}, this.value)">
                </td>
                <td>
                    <input type="number" min="1" value="${item.quantity}" onchange="updateQuantity(${index}, this.value)">
                </td>
                <td>R$ ${(subtotal).toFixed(2)}</td>
                <td><button class="btn btn-sm btn-danger" onclick="removerItem(${index})">X</button></td>
            </tr>
        `;
    });

    pedidoAtual.total = total;
    document.getElementById('total').innerText = total.toFixed(2);
    renderPedidos();
    salvarPedidos();
}

function updateQuantity(index, value) {
    pedidoAtual.itens[index].quantity = parseInt(value);
    renderCart();
}

function updatePrice(index, value) {
    pedidoAtual.itens[index].unit_price = parseFloat(value);
    renderCart();
}

function removerItem(index) {
    pedidoAtual.itens.splice(index, 1);
    renderCart();
}

document.getElementById('barcode').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const codigo = this.value.trim();
        if (!codigo) return;
        if (!pedidoAtual) {
            alert('{{ __('pos.alerta_nenhum_pedido') }}');
            this.value = '';
            return;
        }

        fetch('{{ route("vendas.buscar-produto") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ query: codigo })
        })
        .then(res => res.json())
        .then(produto => {
            if (!produto || !produto.id) {
                alert('{{ __('pos.alerta_produto_nao_encontrado') }}');
                this.value = '';
                return;
            }

            /*
            const existente = pedidoAtual.itens.find(item => item.id === produto.id);
            if (existente) {
                existente.quantity += 1;
            } else {
                pedidoAtual.itens.unshift({
                    id: produto.id,
                    description: produto.description ?? '{{ __('pos.sem_descricao') }}',
                    unit_price: parseFloat(produto.value ?? 0),
                    quantity: 1,
                    image_url: produto.image_url ?? ''
                });
            }
            */

            pedidoAtual.itens.unshift({
                    id: produto.id,
                    description: produto.description ?? '{{ __('pos.sem_descricao') }}',
                    unit_price: parseFloat(produto.value ?? 0),
                    quantity: 1,
                    image_url: produto.image_url ?? ''
                });

            renderCart();
            this.value = '';
        })
        .catch(err => {
            console.error(err);
            alert('{{ __('pos.alerta_erro_servidor') }}');
            this.value = '';
        });
    }
});

document.getElementById('finalizar').addEventListener('click', () => {
    if (!pedidoAtual) {
        alert('{{ __('pos.alerta_nenhum_pedido') }}');
        return;
    }

    if (pedidoAtual.itens.length === 0) {
        alert('{{ __('pos.alerta_adicionar_produto') }}');
        return;
    }

    fetch('{{ route("vendas.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            total: pedidoAtual.total,
            items: pedidoAtual.itens.map(p => ({
                product_id: p.id,
                quantity: p.quantity,
                unit_price: p.unit_price
            }))
        })
    })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            alert('{{ __('pos.alerta_venda_sucesso') }}');
            pedidoAtual.finalizado = true;

            const aberto = pedidos.find(p => !p.finalizado);
            if (!aberto) {
                novaVenda();
            } else {
                pedidoAtual = aberto;
            }

            renderPedidos();
            renderCart();
        } else {
            alert(`{{ __('pos.alerta_erro_registro') }}: ${res.error}`);
        }
    })
    .catch(err => alert('{{ __('pos.alerta_erro_servidor') }}'));
});

window.onload = () => {
    carregarPedidos();
    if (!pedidoAtual) {
        novaVenda();
    } else {
        renderCart();
        renderPedidos();
    }
};

document.getElementById('nova-venda').addEventListener('click', novaVenda);
</script>
@endsection