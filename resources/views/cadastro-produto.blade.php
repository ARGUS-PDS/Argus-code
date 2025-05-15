<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cadastrar Produto</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white p-8 rounded-2xl shadow-md w-full max-w-3xl">
    <h2 class="text-2xl font-semibold mb-6">Cadastrar Produto</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
      <div>
        <div class="w-32 h-32 border-2 border-gray-300 rounded-lg flex items-center justify-center mb-2">
          <span class="text-gray-400 text-sm">Imagem</span>
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Nome</label>
        <input type="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Nome do produto">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Data de validade</label>
        <input type="date" class="w-full border border-gray-300 rounded-md p-2">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Código de barra</label>
        <input type="text" class="w-full border border-gray-300 rounded-md p-2" placeholder="Código">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Valor</label>
        <input type="number" class="w-full border border-gray-300 rounded-md p-2" placeholder="R$">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Valor de compra</label>
        <input type="number" class="w-full border border-gray-300 rounded-md p-2" placeholder="R$">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Lucro</label>
        <input type="number" class="w-full border border-gray-300 rounded-md p-2" placeholder="R$">
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-1">Fornecedor</label>
        <select class="w-full border border-gray-300 rounded-md p-2">
          <option>Selecione</option>
          <option>Fornecedor 1</option>
          <option>Fornecedor 2</option>
        </select>
      </div>

      <div class="col-span-1 md:col-span-2">
        <label class="block text-sm font-medium text-gray-700 mb-1">Situação</label>
        <label class="inline-flex items-center cursor-pointer">
          <input type="checkbox" class="sr-only peer">
          <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-blue-500 rounded-full peer dark:bg-gray-700 peer-checked:bg-green-500 transition-all"></div>
          <span class="ml-3 text-sm text-gray-700 peer-checked:text-green-600">Ativo</span>
        </label>
      </div>
    </div>

    <div class="mt-8 flex justify-end gap-4">
      <button class="px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400">Cancelar</button>
      <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Salvar</button>
    </div>
  </div>
</body>
</html>
