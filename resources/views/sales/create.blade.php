@extends('layouts.app')

@section('content')

<style>
.img-thumb {
    width: 60px; 
    height: 60px; 
    object-fit: cover; 
    border-radius: 4px; 
}

.btn-pedidos{
    color: var(--color-bege-claro);
    background-color: var(--color-vinho);
    border: 2px solid var(--color-vinho);
}

.btn-pedidos:hover{
    color: var(--color-vinho);
    background-color: var(--color-bege-claro);
    border: 2px solid var(--color-vinho);
}

#lista-pedidos {
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
    padding: 0;
    margin: 0;
}

#lista-pedidos .list-group-item {
    background-color: var(--color-bege-claro);
    color: var(--color-vinho);
    border: 2px solid var(--color-vinho);
    border-radius: 8px;
    margin-bottom: 10px;
    position: relative;
    padding-top: 1.5rem;
    cursor: pointer;
    width: 150px;
    height: 100px;
    justify-content: center;
    align-items: center;
    text-align: center;
    font-weight: bold;
}

#lista-pedidos .list-group-item .pedido-content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    flex: 1;
    font-size: 1rem;
}

#lista-pedidos .list-group-item.active {
    background-color: var(--color-vinho);
    color: var(--color-bege-claro);
}

/* botão X no canto superior direito */
#lista-pedidos .list-group-item button {
    position: absolute;
    top: 6px;
    right: 6px;
    background: transparent;
    border: none;
    color: var(--color-vinho);
    font-size: 0.9rem;
    font-weight: bold;
    line-height: 1;
    cursor: pointer;
}

#lista-pedidos .list-group-item.active button {
    color: var(--color-bege-claro);
}

.produto-destaque {
    border-radius: 8px;
    padding: 12px;
    box-shadow: 0 2px 6px var(--color-shadow);
}

.destaque-img {
    width: 100%;
    aspect-ratio: 1 / 1;
    object-fit: cover;
    border-radius: 8px;
}

#frente-layout {
    display: flex;
    gap: 16px;
}

.destaque-col {
    flex: 2;
}

.produtos-col {
    flex: 3;
}

.pedidos-col {
    flex: 0 0 150px;
}

.destaque-inner {
    border-radius: 6px;
    padding: 12px;
    display: flex;
    align-items: center;
    gap: 12px;
}

#destaque-nome {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-word;
}

.table td.descricao-produto {
    flex-direction: column;
    justify-content: center;
    height: 100%;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 2;
    overflow: hidden;
    text-overflow: ellipsis;
    word-break: break-word; 
}

.table-container {
    position: relative;
}

.table {
    position: relative;
    z-index: 10;
    border-collapse: separate;
    border-spacing: 0;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 4px 16px var(--color-shadow);
    background: var(--color-bege-card-interno);
    margin: 16px 0;
}

.cart-empty {
    position: absolute;
    top: 180px;
    left: 0;
    right: 0;
    bottom: 0;
    display: none;
    opacity: 0.08;
    pointer-events: none;
    z-index: 0;
}

.cart-empty img {
    max-width: 40%;
    height: auto;
    filter: grayscale(100%);
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

.table tbody tr:last-child td {
    border-bottom: none !important;
}

.table th.col-valor,
.table td .col-valor {
    width: 80px;
}

.table th.col-qtd,
.table td .col-qtd {
    width: 60px;
}

.table th.col-x,
.table td .col-x {
    width: 60px;
}

.table th.col-photo,
.table td .col-photo{
    width: 85px;
}

.table th.col-name,
.table td .col-name{
    width: 100px;
}

.table th.col-value,
.table td .col-value{
    width: 90px;
}

.table td input {
    width: 80px;
    border: 1px solid var(--color-vinho-fundo);
    border-radius: 6px;
}

#finalizar {
    color: var(--color-vinho);
    background-color: var(--color-bege-claro);
    border: 2px solid var(--color-vinho);
    font-weight: bold;
}

#finalizar:hover {
    color: var(--color-bege-claro);
    background-color: var(--color-vinho);
    border: 2px solid var(--color-bege-claro);
}

.table td button.btn-danger {
    color: var(--color-bege-claro);
    background-color: var(--color-vinho);
    border: none;
}

.table td button.btn-danger:hover {
    color: var(--color-bege-claro);
    background-color: var(--color-vinho-fundo);
}

#frente-footer{
    background: var(--color-vinho) !important;
    color: var(--color-bege-claro);
    border-radius: 10px 10px 0 0;
}

#frente-footer h4{
    color: var(--color-bege-claro);
}

/* Modal */
#modalProdutos .modal-content {
    border-radius: 12px;
}
#modalProdutos .modal-header {
    background-color: var(--color-bege-claro);
    color: var(--color-vinho);
    border-bottom: none;
}
#modalProdutos .btn-close {
    color: var(--color-vinho);
}
#modalProdutos table {
    border-radius: 12px;
    overflow: hidden;
}
#modalProdutos table th {
    background-color: var(--color-vinho);
    color: var(--color-bege-claro);
}
#modalProdutos table tbody tr:hover {
    background-color: var(--color-shadow);
    cursor: pointer;
}

.modalSugestao{
    margin-top: 50px;
    padding-bottom: 50px;
}


</style>

<div class="row" id="frente-layout">
    <!-- Coluna da esquerda: produto em destaque -->
    <div class="col destaque-col">
        <div id="produto-destaque" class="produto-destaque d-flex flex-column">
            <!-- Linha da imagem e nome -->
            <div class="d-flex align-items-center mb-2">
                <!-- Imagem ou ícone -->
                <div id="destaque-img-container" class="img-thumb d-flex align-items-center justify-content-center me-3" style="width: 200px; height: 200px; border-radius: 8px; background: var(--color-vinho-fundo);">
                    <i class="bi bi-image" style="font-size: 60px; color: var(--color-bege-claro);"></i>
                </div>

                <!-- Nome do produto -->
                <h4 id="destaque-nome" class="fw-bold mb-0"></h4>
            </div>

            
        </div>
    </div>

    <!-- Coluna do meio: lista de produtos -->
    <div class="col produtos-col">
        <input type="text" id="barcode" class="form-control mb-3" placeholder="{{ __('tracking.search_placeholder') }}" autocomplete="off">
        <div class="table-container">
            <div id="cart-empty" class="cart-empty d-flex align-items-center justify-content-center">
                <img src="{{ asset('images/logo.png') }}" alt="Argus">
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th class="col-photo">{{ __('pos.foto') }}</th>
                        <th class="col-name">{{ __('pos.produto') }}</th>
                        <th class="col-valor">{{ __('pos.valor') }}</th>
                        <th class="col-qtd">{{ __('pos.quantidade_abreviado') }}</th>
                        <th class="col-value">{{ __('pos.total') }}</th>
                        <th class="col-x"></th>
                    </tr>
                </thead>
                <tbody id="cart-body"></tbody>
            </table>
        </div>
    </div>

    <!-- Coluna da direita: pedidos -->
    <div class="col pedidos-col d-flex flex-column align-items-end">
        <button class="btn btn-primary mb-2 w-100 btn-pedidos" id="nova-venda">{{ __('pos.nova_venda_btn') }}</button>
        <ul id="lista-pedidos" class="list-group w-100"></ul>
    </div>
</div>

<div id="frente-footer" class="d-flex justify-content-end align-items-center p-3 border-top position-fixed w-100" style="bottom:0; left:0; z-index: 1000;">
    <h4 class="me-3">{{ __('pos.total') }}: R$ <span id="total">0.00</span></h4>
    <button class="btn btn-success" id="finalizar">{{ __('pos.finalizar_venda_btn') }}</button>
</div>

<div class="modal modalSugestao fade" id="modalProdutos" tabindex="-1" aria-labelledby="modalProdutosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalProdutosLabel">Selecionar Produto</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
      </div>
      <div class="modal-body">
        <table class="table table-hover" id="tabelaProdutos">
          <thead>
            <tr>
              <th>Nome</th>
              <th>Código de Barras</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
        <div id="loadingProdutos" class="text-center my-3" style="display:none;">
            <div class="spinner-border text-danger" role="status">
                <span class="visually-hidden">Carregando...</span>
            </div>
            <p class="mt-2" style="color: var(--color-vinho); font-weight: bold;">Carregando produtos...</p>
        </div>
      </div>
    </div>
  </div>
</div>

<div id="posConfirmModal" class="confirm-overlay">
    <div class="confirm-box">
        <h3 class="confirm-title">Aviso</h3>
        <p class="confirm-message">Mensagem</p>
        <div class="confirm-buttons">
            <button id="posCancel" class="btn-cancelar">Fechar</button>
            <button id="posConfirm" class="btn-confirmar">Confirmar</button>
        </div>
    </div>
    <style>
    .confirm-overlay { position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: var(--color-shadow); display: flex; align-items: center; justify-content: center; backdrop-filter: blur(3px); visibility: hidden; opacity: 0; transition: opacity 0.25s ease, visibility 0.25s; z-index: 1100; }
    .confirm-overlay.active { visibility: visible; opacity: 1; }
    .confirm-box { background-color: var(--color-bege-claro); border-radius: 14px; padding: 1.8rem; max-width: 360px; width: 90%; text-align: center; box-shadow: 0 8px 24px var(--color-shadow); }
    .confirm-title { color: var(--color-vinho); font-size: 1.3rem; font-weight: 600; margin-bottom: 0.6rem; }
    .confirm-message { color: var(--color-vinho-fundo); margin-bottom: 1.5rem; }
    .confirm-buttons { display: flex; justify-content: center; gap: 0.8rem; }
    .btn-cancelar, .btn-confirmar { padding: 0.5rem 1.3rem; border-radius: 8px; border: none; font-weight: 600; cursor: pointer; transition: 0.2s; }
    .btn-cancelar { background-color: var(--color-vinho); color: var(--color-bege-claro); border: 2px solid var(--color-vinho); }
    .btn-cancelar:hover { background-color: var(--color-bege-claro); color: var(--color-vinho); border: 2px solid var(--color-vinho); }
    .btn-confirmar { background-color: var(--color-bege-claro); color: var(--color-vinho); border: 2px solid var(--color-vinho); }
    .btn-confirmar:hover { background-color: var(--color-vinho); color: var(--color-bege-claro); border: 2px solid var(--color-vinho); }
    </style>
</div>

<div id="loadingMessage" 
     style="display:none; position:fixed; top:0; left:0; width:100%; height:100%;
            background:rgba(255,255,255,0.8); z-index:9999; 
            text-align:center; padding-top:20%; font-weight:bold; color:var(--color-vinho);">
    <div class="spinner-border text-danger" role="status">
        <span class="visually-hidden">Carregando...</span>
    </div>
    <p class="mt-3">Carregando produto, aguarde...</p>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const inputPesquisa = document.getElementById("barcode");
    const modalElement = document.getElementById("modalProdutos");
    const modalProdutos = new bootstrap.Modal(modalElement);
    const tbody = document.querySelector("#tabelaProdutos tbody");
    const loading = document.getElementById("loadingProdutos");

    inputPesquisa.addEventListener("dblclick", function() {
        modalProdutos.show();
        tbody.innerHTML = "";
        loading.style.display = "block";

        fetch("{{ route('products.lista') }}")
            .then(res => res.json())
            .then(data => {
                loading.style.display = "none";
                if (!data.length) {
                    tbody.innerHTML = `<tr><td colspan="2" class="text-center text-muted">Nenhum produto encontrado.</td></tr>`;
                    return;
                }

                data.forEach(prod => {
                    const tr = document.createElement("tr");
                    tr.style.cursor = "pointer";
                    tr.innerHTML = `<td>${prod.description}</td><td>${prod.barcode || "-"}</td>`;
                    tr.addEventListener("click", () => {
                        inputPesquisa.value = prod.barcode;
                        modalProdutos.hide();
                        inputPesquisa.focus();
                    });
                    tbody.appendChild(tr);
                });
            })
            .catch(() => {
                loading.style.display = "none";
                tbody.innerHTML = `<tr><td colspan="2" class="text-center text-danger">Erro ao carregar produtos.</td></tr>`;
            });
    });
});
</script>


<script>
function abrirConfirmacaoPDV(mensagem) {
    return new Promise((resolve) => {
        const modal = document.getElementById('posConfirmModal');
        const messageEl = modal.querySelector('.confirm-message');
        const btnConfirm = document.getElementById('posConfirm');
        const btnCancel = document.getElementById('posCancel');
        modal.querySelector('.confirm-title').textContent = 'Confirmar ação';
        messageEl.textContent = mensagem;
        modal.classList.add('active');
        btnConfirm.style.display = '';
        btnCancel.textContent = 'Cancelar';

        const cleanup = () => {
            btnConfirm.onclick = null;
            btnCancel.onclick = null;
            modal.classList.remove('active');
        };
        btnConfirm.onclick = () => { cleanup(); resolve(true); };
        btnCancel.onclick = () => { cleanup(); resolve(false); };
    });
}

function abrirAvisoPDV(mensagem) {
    const modal = document.getElementById('posConfirmModal');
    const messageEl = modal.querySelector('.confirm-message');
    const btnConfirm = document.getElementById('posConfirm');
    const btnCancel = document.getElementById('posCancel');
    modal.querySelector('.confirm-title').textContent = 'Aviso';
    messageEl.textContent = mensagem;
    modal.classList.add('active');
    btnConfirm.style.display = 'none';
    btnCancel.textContent = 'Fechar';
    btnCancel.onclick = () => { modal.classList.remove('active'); };
}

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
    pedidos.filter(p => !p.finalizado).forEach(p => {
        const ativo = (pedidoAtual && pedidoAtual.id === p.id) ? 'active' : '';
        lista.innerHTML += `
            <li class="list-group-item ${ativo}" onclick="selecionarPedido(${p.id})">
                <div class="pedido-content">
                    <span>Pedido</span>
                    <span>${p.id}</span>
                </div>
                <button onclick="apagarPedido(${p.id}); event.stopPropagation()">X</button>
            </li>
        `;
    });
}

function apagarPedido(id) {
    const index = pedidos.findIndex(p => p.id === id);
    if (index === -1) return;

    return abrirConfirmacaoPDV(`{{ __('pos.confirmar_apagar_pedido') }}`.replace(':id', id))
        .then((confirmado) => {
            if (!confirmado) return;

            const pedidoRemovido = pedidos[index];
            pedidos.splice(index, 1);

            if (pedidoAtual && pedidoAtual.id === id) {
                const aberto = pedidos.find(p => !p.finalizado) || null;
                pedidoAtual = aberto;
                if (pedidoAtual && pedidoAtual.itens.length > 0) {
                    const ultimo = pedidoAtual.itens[0];
                    window.produtoEmDestaque = {
                        id: ultimo.id,
                        description: ultimo.description,
                        unit_price: ultimo.unit_price,
                        quantity: ultimo.quantity,
                        image_url: ultimo.image_url || ''
                    };
                } else {
                    window.produtoEmDestaque = null;
                }
                atualizarDestaque();
            }

            if (pedidoRemovido.id === contadorPedidos - 1) {
                contadorPedidos--;
            }

            if (pedidos.length === 0) {
                novaVenda();
                return;
            }

            renderPedidos();
            renderCart();
            salvarPedidos();
        });

    const pedidoRemovido = pedidos[index];
    pedidos.splice(index, 1);

    if (pedidoAtual && pedidoAtual.id === id) {
        const aberto = pedidos.find(p => !p.finalizado) || null;
        pedidoAtual = aberto;
        if (pedidoAtual && pedidoAtual.itens.length > 0) {
            const ultimo = pedidoAtual.itens[0];
            window.produtoEmDestaque = {
                id: ultimo.id,
                description: ultimo.description,
                unit_price: ultimo.unit_price,
                quantity: ultimo.quantity,
                image_url: ultimo.image_url || ''
            };
        } else {
            window.produtoEmDestaque = null;
        }
        atualizarDestaque();
    }

    if (pedidoRemovido.id === contadorPedidos - 1) {
        contadorPedidos--;
    }

    if (pedidos.length === 0) {
        novaVenda();
        return;
    }

    renderPedidos();
    renderCart();
    salvarPedidos();
}


function selecionarPedido(id) {
    const selecionado = pedidos.find(p => p.id === id);
    if (selecionado) {
        pedidoAtual = selecionado;
        if (pedidoAtual.itens.length > 0) {
            const ultimo = pedidoAtual.itens[0];
            window.produtoEmDestaque = {
                id: ultimo.id,
                description: ultimo.description,
                unit_price: ultimo.unit_price,
                quantity: ultimo.quantity,
                image_url: ultimo.image_url || ''
            };
        } else {
            window.produtoEmDestaque = null;
        }
        atualizarDestaque();
        renderCart();
        renderPedidos();
    }
}

function renderCart() {
    const tbody = document.getElementById('cart-body');
    const emptyOverlay = document.getElementById('cart-empty');
    tbody.innerHTML = '';
    if (!pedidoAtual) {
        document.getElementById('total').innerText = '0.00';
        if (emptyOverlay) emptyOverlay.style.display = 'flex';
        window.produtoEmDestaque = null;
        atualizarDestaque();
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
    if (emptyOverlay) {
        if (pedidoAtual.itens.length > 0) {
            emptyOverlay.style.display = 'none';
        } else {
            emptyOverlay.style.display = 'flex';
        }
    }
    if (pedidoAtual.itens.length > 0) {
        const ultimo = pedidoAtual.itens[0];
        window.produtoEmDestaque = {
            id: ultimo.id,
            description: ultimo.description,
            unit_price: ultimo.unit_price,
            quantity: ultimo.quantity,
            image_url: ultimo.image_url || ''
        };
    } else {
        window.produtoEmDestaque = null;
    }
    atualizarDestaque();
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

        if (typeof mostrarTelaCarregando === 'function') {
            try { mostrarTelaCarregando(); } catch(_) {}
        } else {
            const loading = document.getElementById('loadingMessage');
            if (loading) loading.style.display = 'block';
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
            if (typeof esconderTelaCarregando === 'function') {
                try { esconderTelaCarregando(); } catch(_) {}
            } else {
                const loading = document.getElementById('loadingMessage');
                if (loading) loading.style.display = 'none';
            }
            if (!produto || !produto.id) {
                alert('{{ __('pos.alerta_produto_nao_encontrado') }}');
                this.value = '';
                return;
            }

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

            // Atualiza o produto em destaque
            window.produtoEmDestaque = {
                id: produto.id,
                description: produto.description ?? '{{ __('pos.sem_descricao') }}',
                unit_price: parseFloat(produto.value ?? 0),
                quantity: 1,
                image_url: produto.image_url ?? ''
            };

            atualizarDestaque();
            renderCart();
            this.value = '';
            this.focus();

        })
        .catch(err => {
            console.error(err);
            alert('{{ __('pos.alerta_erro_servidor') }}');
            this.value = '';
            if (typeof esconderTelaCarregando === 'function') {
                try { esconderTelaCarregando(); } catch(_) {}
            } else {
                const loading = document.getElementById('loadingMessage');
                if (loading) loading.style.display = 'none';
            }
        });
    }
});

function atualizarDestaque() {
    const container = document.getElementById("destaque-img-container");
    const destaqueNome = document.getElementById("destaque-nome");

    if (window.produtoEmDestaque) {
        const produto = window.produtoEmDestaque;

        // limpa container
        container.innerHTML = "";
        container.style.background = "var(--color-bege-card-interno)";

        if (produto.image_url && produto.image_url.trim() !== "") {
            // adiciona imagem
            const img = document.createElement("img");
            img.src = produto.image_url;
            img.className = "destaque-img";
            img.alt = "Produto";
            img.style.objectFit = "cover";
            container.appendChild(img);
        } else {
            // adiciona ícone
            container.innerHTML = `<i class="bi bi-image" style="font-size: 2rem; color: var(--color-vinho-fundo);"></i>`;
        }

        destaqueNome.textContent = produto.description ?? "—";

    } else {
        container.innerHTML = `<i class="bi bi-image" style="font-size: 2rem; color: var(--color-bege-claro);"></i>`;
        container.style.background = "var(--color-vinho-fundo)";
        destaqueNome.textContent = "";
    }
}
document.getElementById('finalizar').addEventListener('click', () => {
    if (!pedidoAtual) {
        alert('{{ __('pos.alerta_nenhum_pedido') }}');
        return;
    }

    if (pedidoAtual.itens.length === 0) {
        abrirAvisoPDV(`{{ __('pos.alerta_adicionar_produto') }}`);
        return;
    }

    if (window.produtoEmDestaque) {
        pedidoAtual.itens.unshift(window.produtoEmDestaque);
        window.produtoEmDestaque = null;
    }

    if (typeof mostrarTelaCarregando === 'function') { try { mostrarTelaCarregando(); } catch(_) {} }
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
            abrirAvisoPDV('{{ __('pos.alerta_venda_sucesso') }}');
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
    .catch(err => abrirAvisoPDV('{{ __('pos.alerta_erro_servidor') }}'))
    .finally(() => { if (typeof esconderTelaCarregando === 'function') { try { esconderTelaCarregando(); } catch(_) {} } });
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