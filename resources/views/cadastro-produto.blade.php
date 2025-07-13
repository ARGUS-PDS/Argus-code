<?php


?>

<!DOCTYPE html>
<html lang="pt-BR">
  
@include('layouts.css-variables')

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastrar Produto</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
  
</head>

    <link rel="stylesheet" href="{{ asset('css/cadastro-produto.css') }}">


<body class="flex items-center justify-center min-h-screen bg-beige">
  <div class="bg-beige w-full p-mine">
    <div class="back">
      <div>
        <a href="/dashboard" class="d-flex align-center">
          <img class="image" src="{{ asset('images/left-arrow.png') }}" alt="Logo">
          <h3 class="font-semibold">DASHBOARD</h3>
        </a>
      </div>
      <img class="logo" src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>
    <h1 class="text-2xl font-semibold mb-2 text-red-mine">Cadastrar Produto</h1>



    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
      <ul class="list-disc ml-5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <form class="grid grid-cols-1 md:grid-cols-2 gap-6" action="{{ route('cadastrar-produto.store') }}" method="POST" enctype="multipart/form-data">
      @csrf

      <div class="first-info">

        <div style="width: 30%;">
          <input
            type="file"
            name="image_url"
            class="w-full border border-gray-300 rounded-md p-2"
            accept="image/*"
            onchange="previewImage(event)"
            required>
          <div class="mt-2">
            <img id="preview" src="#" alt="Pré-visualização" class="hidden rounded-md" style="max-height: 150px;">
            <div id="placeholder" class="text-gray-500">Nenhuma imagem selecionada</div>
          </div>
        </div>

        <div style="width: 80%;">
          <label class="block font-medium text-red-mine mb-1 bigger">Código</label>
          <input type="text" name="code" class="w-full border border-gray-300 rounded-md p-2" placeholder="Ex: esmalte_vermelho_anita" style="margin-bottom: 1.5em;" required>

          <label class="block bigger font-medium text-red-mine mb-1">Descrição</label>
          <input type="text" name="description" class="w-full border border-gray-300 rounded-md p-2" placeholder="Esmalte vermelho da marca Anita 8ml" required>
        </div>
      </div>


      <div class="gap-6">
        <label class="block bigger font-medium text-red-mine mb-1">Código de barra</label>
        <input name="barcode" type="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Ex: 00608473184014" style="margin-bottom: 1.5em;" required>
        <label class="block bigger font-medium text-red-mine mb-1">Data de validade</label>
        <input name="expiration_date" type="date" class="w-full border border-gray-300 rounded-md p-2" required>
      </div>

      <div class="d-flex" style="gap: 15px">
        <div>
          <label class="block bigger font-medium text-red-mine mb-1">Valor</label>
          <input name="value" type="number" class="w-full border border-gray-300 rounded-md p-2" placeholder="R$">
        </div>
        <!-- <div>
          <label class="block bigger font-medium text-red-mine mb-1">Valor de compra</label>
          <input name="value" type="number" class="w-full border border-gray-300 rounded-md p-2" placeholder="R$">
        </div> -->
        <div>
          <label class="block bigger font-medium text-red-mine mb-1">Lucro</label>
          <input name="profit" type="number" class="w-full border border-gray-300 rounded-md p-2" placeholder="R$" required>
        </div>
      </div>

      <div>
        <label class="block bigger font-medium text-red-mine mb-1">Fornecedor</label>
        <select name="supplierId" class="w-full border border-gray-300 rounded-md p-2" required>
          <option value="">Selecione um fornecedor</option>
          @foreach ($suppliers as $supplier)
          <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
          @endforeach
        </select>
      </div>


      <div class="border-mine p-stock">
        <label class="block bigger font-medium text-red-mine mb-1">Informações Adicionais</label>
        <div class="d-flex justify-around" style="gap: 15px; margin-bottom: 15px">
          <div>
            <label class="block text-sm font-medium text-red-mine mb-1">Marca</label>
            <input name="brand" type="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Ex: Anita">
          </div>
          <div>
            <label class="block text-sm font-medium text-red-mine mb-1">Modelo</label>
            <input name="model" type="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Ex: Carnaval">
          </div>
        </div>
      </div>

      <div class="border-mine p-stock">
        <label class="block bigger font-medium text-red-mine mb-1">Estoque</label>
        <div class="d-flex justify-around" style="gap: 15px">
          <div>
            <label class="block text-sm font-medium text-red-mine mb-1">Estoque Atual</label>
            <input name="currentStock" type="number" class="w-full border border-gray-300 rounded-md p-2" placeholder="Ex: 40" required>
          </div>
          <div>
            <label class="block text-sm font-medium text-red-mine mb-1">Estoque Mínimo</label>
            <input name="minimumStock" type="number" class="w-full border border-gray-300 rounded-md p-2" placeholder="Ex: 150" required>
          </div>
        </div>
      </div>
      <div>

      </div>
      <div class="flex justify-between align-center" style="padding: 0 60px;">
        <div class="col-span-1 md:col-span-2">
          <label class="block text-sm font-medium text-red-mine mb-1">Situação</label>
          <label class="inline-flex items-center cursor-pointer" onclick="show()">
            <input type="checkbox" class="sr-only peer" name="status" value="1" checked>
            <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-black-500 rounded-full peer dark:bg-red-700 peer-checked:bg-green-700 transition-all"></div>
            <span class="ml-3 text-sm text-red-700 peer-checked:text-green-700 bold" id="active">Ativo</span>
          </label>
        </div>
        <div class="d-flex" style="gap: 15px">
          <button class="btn btn-cancel">Cancelar</button>
          <button class="btn btn-send ">Salvar</button>
        </div>
      </div>
    </form>
  </div>
</body>
    <script src="{{ asset('js/cadastro-produto.js') }}"></script>
</html>