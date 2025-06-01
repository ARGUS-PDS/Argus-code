@extends('layouts.app')

@section('content')
<div class="row g-4">
  <div class="col-md-4">
    <div class="dropdown mb-2">
      <button class="btn btn-dashboard dropdown-toggle w-100" onclick="show('dropdown-menu-cadastro')">
        Cadastro
      </button>
      <ul class="dropdown-menu w-100" id="dropdown-menu-cadastro">
        <li><a class="dropdown-item" href="/lista-produtos">Cadastro de Produtos</a></li>
        <li><a class="dropdown-item" href="/cadastrar-produto-ean">Cadastro de Produtos via EAN</a></li>
        <li><a class="dropdown-item" href="/lista-fornecedores">Cadastro de Fornecedores</a></li>
        <li><a class="dropdown-item" href="/cadastrar-funcionario">Cadastro de Funcionários</a></li>
      </ul>
    </div>
    <div class="panel">
      <h5>Produto / Validade</h5>
      <ul class="mt-2">
        <li>Produto A - Vence em 3 dias</li>
        <li>Produto B - Vence amanhã</li>
        <li>Produto C - Vence hoje</li>
      </ul>
    </div>
  </div>

  <div class="col-md-4">
    <div class="dropdown mb-2">
      <button class="btn btn-dashboard dropdown-toggle w-100" onclick="show('dropdown-menu-estoque')">
        Estoque
      </button>
      <ul class="dropdown-menu w-100" id="dropdown-menu-estoque">
        <li><a class="dropdown-item" href="#">Controle de Estoque</a></li>
        <li><a class="dropdown-item" href="#">Acompanhamento de Validade</a></li>
        <li><a class="dropdown-item" href="/etiquetas">Etiquetas</a></li>
        <li><a class="dropdown-item" href="/detalhamento-lote">Detalhamento de Lote</a></li>
      </ul>
    </div>
    <div class="panel">
      <h5>Entrada / Saída</h5>
      <ul class="mt-2">
        <li>Entrada - Produto D</li>
        <li>Saída - Produto A</li>
        <li>Entrada - Produto E</li>
      </ul>
    </div>
  </div>

  <div class="col-md-4">
    <div class="dropdown mb-2">
      <button class="btn btn-dashboard dropdown-toggle w-100" onclick="show('dropdown-menu-pedido')">
        Pedidos
      </button>
      <ul class="dropdown-menu w-100" id="dropdown-menu-pedido">
        <li><a class="dropdown-item" href="#">Envio de Pedido</a></li>
        <li><a class="dropdown-item" href="#">Cotação de Fornecedores</a></li>
        <li><a class="dropdown-item" href="#">Histórico de Pedidos</a></li>
      </ul>
    </div>
    <div class="panel">
      <h5>Alertas</h5>
      <ul class="mt-2">
        <li>Produto C venceu</li>
        <li>Produto F parado há 90 dias</li>
      </ul>
    </div>
  </div>
</div>

<style>
  .panel {
    background-color: #d2a87d;
    color: #202132;
    border-radius: 15px;
    padding: 1rem;
    height: 250px;
    overflow-y: auto;
  }

  .panel h5 {
    font-weight: bold;
  }

  .btn-dashboard {
    background-color: #d2a87d;
    color: #202132;
    border-radius: 15px;
    padding: 0.8rem;
    font-weight: bold;
    width: 100%;
    text-align: left;
    border: none;
    transition: all 0.3s ease;
  }

  .btn-dashboard:hover {
    background-color: #8d6b48;
    color: #FFFFFF;
  }

  .dropdown-menu {
    background-color: #d2a87d;
    border: 1px solid rgba(141, 107, 72, 0.2);
    border-radius: 10px;
    margin-top: 5px;
    padding: 0.5rem;
    box-shadow: 0 2px 4px rgba(0,0,0,0.05);
  }

  .dropdown-menu a {
    color: #202132;
    background-color: transparent;
    padding: 0.5rem 1rem;
    border-radius: 5px;
    transition: all 0.3s ease;
  }

  .dropdown-menu a:hover {
    background-color: #8d6b48;
    color: #FFFFFF;
  }
</style>

<script>
  function show(id) {
    const menu_hidden = document.getElementById(id);
    const display = window.getComputedStyle(menu_hidden).display;
    if (display === "none") {
      menu_hidden.style.display = "block"
    } else {
      menu_hidden.style.display = "none"
    }
  }
</script>
@endsection