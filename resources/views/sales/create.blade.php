@extends('layouts.app')

@section('content')
<div class="container mt-4" id="frente-container" style="display:none;">
    <h2>Frente de caixa</h2>

    <!-- Botões principais -->
    <div class="d-flex justify-content-between mb-3">
        <button class="btn btn-primary" id="nova-venda">Nova Venda</button>
        <button class="btn btn-danger" id="finalizar-caixa">Finalizar Caixa</button>
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

            <div class="text-end mb-3">
                <h4>Total: R$ <span id="total">0.00</span></h4>
                <button class="btn btn-success" id="finalizar">Finalizar Venda</button>
            </div>
        </div>

        <!-- Sidebar com lista de pedidos -->
        <div class="col-md-4">
            <h5>Pedidos em aberto</h5>
            <ul id="lista-pedidos" class="list-group"></ul>
        </div>
    </div>
</div>

<!-- Modal de abertura do Frente de Caixa -->
<div class="modal fade" id="abrirCaixaModal" tabindex="-1" aria-labelledby="abrirCaixaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content p-4 text-center">
      <h4 id="abrirCaixaModalLabel" class="mb-3">Frente de Caixa</h4>
      <p class="mb-4">Deseja abrir o Frente de Caixa?</p>
      <button class="btn btn-success px-4" id="abrirFrenteBtn" data-bs-dismiss="modal">Abrir Frente de Caixa</button>
    </div>
  </div>
</div>

<script>
    let pedidos = [];
    let pedidoAtual = null;
    let caixa = 0;
    let contadorPedidos = 1; // contador para numerar pedidos

    // Criar novo pedido
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
    }

    // Renderizar lista de pedidos na sidebar
    function renderPedidos() {
        const lista = document.getElementById('lista-pedidos');
        lista.innerHTML = '';
        pedidos.forEach(p => {
            const ativo = (pedidoAtual && pedidoAtual.id === p.id) ? 'active' : '';
            lista.innerHTML += `
                <li class="list-group-item ${ativo}" onclick="selecionarPedido(${p.id})">
                    Pedido ${p.id}
                </li>
            `;
        });
    }

    // Selecionar pedido clicando na sidebar
    function selecionarPedido(id) {
        pedidoAtual = pedidos.find(p => p.id === id);
        renderCart();
        renderPedidos();
    }

    // Renderizar carrinho do pedido atual
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
    }

    // Atualizar quantidade
    function updateQuantity(index, value) {
        pedidoAtual.itens[index].quantity = parseInt(value);
        renderCart();
    }

    // Atualizar preço
    function updatePrice(index, value) {
        pedidoAtual.itens[index].unit_price = parseFloat(value);
        renderCart();
    }

    // Remover item
    function removerItem(index) {
        pedidoAtual.itens.splice(index, 1);
        renderCart();
    }

    // Adicionar produto via código de barras
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
                if (produto.currentStock < 1) {
                    alert('Produto sem estoque disponível!');
                    return;
                }

                const existente = pedidoAtual.itens.find(item => item.id === produto.id);
                if (existente) {
                    if (existente.quantity + 1 > produto.currentStock) {
                        alert('Quantidade solicitada maior que o estoque disponível!');
                        return;
                    }
                    existente.quantity += 1;
                } else {
                    pedidoAtual.itens.push({
                        id: produto.id,
                        description: produto.description,
                        unit_price: parseFloat(produto.value),
                        quantity: 1,
                        image_url: produto.image_url,
                        currentStock: produto.currentStock 
                    });
                }

                renderCart();
                this.value = '';
            })
            .catch(err => alert('Produto não encontrado.'));
        }
    });

    // Finalizar venda (pedido atual)
    document.getElementById('finalizar').addEventListener('click', () => {
        if (!pedidoAtual || pedidoAtual.itens.length === 0) {
            alert('Nenhum produto no carrinho!');
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
                caixa += pedidoAtual.total;
                pedidos = pedidos.filter(p => p.id !== pedidoAtual.id);
                pedidoAtual = null;
                renderPedidos();
                renderCart();
            } else {
                alert('Erro ao registrar venda: ' + res.error);
            }

            if (window.vendasTempoChart) {
                const chart = window.vendasTempoChart;
                chart.data.datasets[0].data[chart.data.datasets[0].data.length - 1] += pedidoAtual.total;
                chart.update();
            }

        })
        .catch(err => alert('Erro no servidor.'));
    });

    // Nova venda
    document.getElementById('nova-venda').addEventListener('click', novaVenda);

    // Finalizar caixa
    document.getElementById('finalizar-caixa').addEventListener('click', () => {
        alert(`Caixa finalizado. Total vendido: R$ ${caixa.toFixed(2)}`);
        caixa = 0;
        pedidos = [];
        pedidoAtual = null;
        contadorPedidos = 1; // reseta contagem ao fechar caixa
        renderPedidos();
        renderCart();
    });

    // Abrir modal automaticamente quando entrar na página
    window.onload = () => {
        const modal = new bootstrap.Modal(document.getElementById('abrirCaixaModal'));
        modal.show();

        document.getElementById('abrirFrenteBtn').addEventListener('click', () => {
            document.getElementById('frente-container').style.display = 'block';
            novaVenda(); // já inicia com Pedido 1
        });
    }
</script>
@endsection
