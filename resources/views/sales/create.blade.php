@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Nova Venda</h2>

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

<script>
    let carrinho = [];

    function renderCart() {
        const tbody = document.getElementById('cart-body');
        tbody.innerHTML = '';
        let total = 0;

        carrinho.forEach((item, index) => {
            const subtotal = item.unit_price * item.quantity;
            total += subtotal;

            tbody.innerHTML += `
                <tr>
                    <td><img src="${item.image_url ?? ''}" alt="" width="50"></td>
                    <td>${item.description}</td>
                    <td>R$ ${item.unit_price.toFixed(2)}</td>
                    <td>
                        <input type="number" min="1" value="${item.quantity}" onchange="updateQuantity(${index}, this.value)">
                    </td>
                    <td>R$ ${(subtotal).toFixed(2)}</td>
                    <td><button class="btn btn-sm btn-danger" onclick="removerItem(${index})">X</button></td>
                </tr>
            `;
        });

        document.getElementById('total').innerText = total.toFixed(2);
    }

    function updateQuantity(index, value) {
        carrinho[index].quantity = parseInt(value);
        renderCart();
    }

    function removerItem(index) {
        carrinho.splice(index, 1);
        renderCart();
    }

    document.getElementById('barcode').addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const codigo = this.value.trim();
            if (!codigo) return;

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

            const existente = carrinho.find(item => item.id === produto.id);
            if (existente) {
                if (existente.quantity + 1 > produto.currentStock) {
                    alert('Quantidade solicitada maior que o estoque disponível!');
                    return;
                }
                existente.quantity += 1;
            } else {
                carrinho.push({
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

    document.getElementById('finalizar').addEventListener('click', () => {
        if (carrinho.length === 0) {
            alert('Nenhum produto no carrinho!');
            return;
        }

        const total = carrinho.reduce((sum, p) => sum + p.unit_price * p.quantity, 0);

        const items = carrinho.map(p => ({
            product_id: p.id,
            quantity: p.quantity,
            unit_price: p.unit_price
        }));

        fetch('{{ route("vendas.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ total, items })
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                alert('Venda registrada com sucesso!');
                carrinho = [];
                renderCart();
            } else {
                alert('Erro ao registrar venda: ' + res.error);
            }
        })
        .catch(err => alert('Erro no servidor.'));
    });
</script>
@endsection
