@extends('layouts.app')

@section('content')
<div class="container mt-4" id="frente-container">
    <h2>Frente de Caixa</h2>

    <!-- Botão Nova Venda -->
    <div class="d-flex justify-content-start mb-3">
        <button class="btn btn-primary" id="nova-venda">Nova Venda</button>
    </div>

    <div class="row">
        <!-- Área principal da venda -->
        <div class="col-md-8">
            <input type="text" id="barcode" class="form-control mb-3" placeholder="Escaneie ou digite o código de barras">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Produto</th>
                        <th>Valor</th>
                        <th>Qtd</th>
                        <th>Total</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="cart-body"></tbody>
            </table>
        </div>

        <!-- Sidebar com lista de pedidos -->
        <div class="col-md-4">
            <h5>Pedidos em aberto</h5>
            <ul id="lista-pedidos" class="list-group"></ul>
        </div>
    </div>
</div>

<!-- rodape -->
<div id="frente-footer" class="d-flex justify-content-end align-items-center p-3 border-top bg-white position-fixed w-100" style="bottom:0; left:0; z-index: 1000;">
    <h4 class="me-3">Total: R$ <span id="total">0.00</span></h4>
    <button class="btn btn-success" id="finalizar">Finalizar Venda</button>
</div>

<style>
    body {
        padding-bottom: 80px; /* Espaço para o rodapé fixo não cobrir a tabela */
    }
</style>

<script>
let pedidos = [];
let pedidoAtual = null;
let contadorPedidos = 1;

// =======================
// Persistência por dia
// =======================
function carregarPedidos() {
    const dataSalva = localStorage.getItem('frente_caixa_data');
    const hoje = new Date().toISOString().split('T')[0];

    if (dataSalva === hoje) {
        const dados = JSON.parse(localStorage.getItem('frente_caixa'));
        if (dados) {
            pedidos = dados.pedidos || [];
            contadorPedidos = dados.contadorPedidos || 1;
            // Seleciona último pedido não finalizado
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

// =======================
// Funções principais
// =======================
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
    pedidos.forEach(p => {
        if (!p.finalizado) {
            const ativo = (pedidoAtual && pedidoAtual.id === p.id) ? 'active' : '';
            lista.innerHTML += `
                <li class="list-group-item ${ativo}" onclick="selecionarPedido(${p.id})">
                    Pedido ${p.id}
                </li>
            `;
        }
    });
}

function selecionarPedido(id) {
    const selecionado = pedidos.find(p => p.id === id);
    if (selecionado && !selecionado.finalizado) {
        pedidoAtual = selecionado;
        renderCart();
        renderPedidos();
    }
}

function renderCart() {
    const tbody = document.getElementById('cart-body');
    tbody.innerHTML = '';
    if (!pedidoAtual) return;

    let total = 0;
    pedidoAtual.itens.forEach((item, index) => {
        const subtotal = item.unit_price * item.quantity;
        total += subtotal;
        tbody.innerHTML += `
            <tr>
                <td><img src="${item.image_url ?? ''}" alt="" width="50"></td>
                <td>${item.description}</td>
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

// =======================
// Código de barras
// =======================
document.getElementById('barcode').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        const codigo = this.value.trim();
        if (!codigo || !pedidoAtual) return;

        fetch('{{ route("vendas.buscar-produto") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ barcode: codigo })
        })
        .then(res => res.json())
        .then(produto => {
            const existente = pedidoAtual.itens.find(item => item.id === produto.id);
            if (existente) {
                existente.quantity += 1;
            } else {
                pedidoAtual.itens.push({
                    id: produto.id,
                    description: produto.description,
                    unit_price: parseFloat(produto.value),
                    quantity: 1,
                    image_url: produto.image_url
                });
            }
            renderCart();
            this.value = '';
        })
        .catch(err => alert('Produto não encontrado.'));
    }
});

// =======================
// Finalizar venda
// =======================
document.getElementById('finalizar').addEventListener('click', () => {
    if (!pedidoAtual) {
        alert('Nenhum pedido selecionado!');
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
            alert('Venda registrada com sucesso!');
            pedidoAtual.finalizado = true;

            // Seleciona próximo pedido aberto ou cria novo
            const aberto = pedidos.find(p => !p.finalizado);
            if (!aberto) {
                novaVenda();
            } else {
                pedidoAtual = aberto;
            }

            renderPedidos();
            renderCart();
        } else {
            alert('Erro ao registrar venda: ' + res.error);
        }
    })
    .catch(err => alert('Erro no servidor.'));
});

// =======================
// Inicialização
// =======================
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
