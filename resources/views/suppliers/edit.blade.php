<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Lista de Fornecedores</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
  <style>
    .search-bar {
      background: #46585c;
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

    .search-bar .bi-search {
      color: #b1b1b1;
      font-size: 1.2rem;
      margin-left: 8px;
    }

    .table th,
    .table td {
      vertical-align: middle;
      background: #f9f9f9;
    }

    .img-thumb {
      width: 40px;
      height: 40px;
      object-fit: cover;
      border: 2px solid #198754;
      border-radius: 8px;
      background: #fff;
    }

    .add-btn {
      border: 2px solid #198754;
      border-radius: 50%;
      width: 36px;
      height: 36px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.5rem;
      color: #198754;
      background: none;
      cursor: pointer;
      margin-left: 8px;
      transition: background 0.2s;
    }

    .add-btn:hover {
      background: #e7f6ee;
    }

    .menu-dot {
      font-size: 1.5rem;
      color: #767676;
      cursor: pointer;
      text-align: center;
    }

    .img-thumb {
      width: 150px;
      height: 100px;
      object-fit: cover;
      border: black;
      border-radius: 8px;
      background: #fff;
    }
  </style>
</head>

<body class="bg-light">
  <div>
    <div class="container">
      <h2>Editar Fornecedor</h2>

      <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="first-info" style="display: flex; align-items: center; gap: 10px;">
          <div style="width: 100%;">
            <legend>Dados Iniciais</legend>

            <label class="block font-medium text-red-mine mb-1 bigger">Nome Atual</label>
            <input type="text" name="name" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('name', $supplier->name) }}" required>

            <label class="block bigger font-medium text-red-mine mb-1 mt-3">Código Atual</label>
            <input type="text" name="code" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('code', $supplier->code) }}" required>
            <label class="block bigger font-medium text-red-mine mb-1 mt-3">Distribuidora Atual</label>
            <input type="text" name="distributor" class="w-full border border-gray-300 rounded-md p-2" value="{{ old('distributor', $supplier->distributor) }}" required>

          </div>
        </div>
        <div class="first-info" style="display: flex; align-items: center; gap: 10px;">
          <div style="width: 100%; display: flex; flex-direction: column">
            <legend>Endereço</legend>

            <label for="zip_code" class="block bigger font-medium text-red-mine mb-1 mt-3">CEP Atual</label>
            <input id="zip_code" type="text" name="address[cep]" value="{{ old('supplier->address->cep', optional($supplier->address ?? null)->cep) }}">

            <label class="block bigger font-medium text-red-mine mb-1 mt-3">Logradouro Atual</label>
            <input id="place" type="text" name="address[place]" value="{{ old('address.place', optional($supplier->address ?? null)->place) }}">

            <label class="block bigger font-medium text-red-mine mb-1 mt-3">Número Atual</label>
            <input id="number" type="text" name="address[number]" value="{{ old('address.0.number', optional($supplier->address ?? null)->number) }}">

            <label class="block bigger font-medium text-red-mine mb-1 mt-3">Bairro Atual</label>
            <input id="neighborhood" type="text" name="address[neighborhood]" value="{{ old('address.neighborhood', optional($supplier->address ?? null)->neighborhood) }}">

            <label class="block bigger font-medium text-red-mine mb-1 mt-3">Cidade Atual</label>
            <input id="city" type="text" name="address[city]" value="{{ old('address.city', optional($supplier->address ?? null)->city) }}">

            <label class="block bigger font-medium text-red-mine mb-1 mt-3">Estado Atual</label>
            <input type="text" name="address[state]" value="{{ old('address.state', optional($supplier->address ?? null)->state) }}">

          </div>
        </div>

        <div class="first-info" style="display: flex; align-items: center; gap: 10px;">
          <div style="width: 100%; display: flex; flex-direction: column">
            <legend>Contato</legend>

            <label for="zip_code" class="block bigger font-medium text-red-mine mb-1 mt-3">Telefone Fixo Atual</label>
            <input id="fixedphone" type="text" name="fixedphone" value="{{ old('fixedphone', $supplier->fixedphone) }}">

            <label class=" block bigger font-medium text-red-mine mb-1 mt-3">Celular Atual</label>
            <input id="phone" type="text" name="phone" value="{{ old('phone', $supplier->phone) }}">

            <label class=" block bigger font-medium text-red-mine mb-1 mt-3">E-mail Atual</label>
            <input id="email" type="text" name="email" value="{{ old('email', $supplier->email) }}">

            <label class=" block bigger font-medium text-red-mine mb-1 mt-3">Contato 1 Telefone Atual</label>
            <input id="contactNumber1" type="text" name="contactNumber1" value="{{ old('contactNumber1', $supplier->contactNumber1) }}">

            <label class=" block bigger font-medium text-red-mine mb-1 mt-3">Contato 1 Nome Atual</label>
            <input id="contactName1" type="text" name="contactName1" value="{{ old('contactName1', $supplier->contactName1) }}">

            <label class=" block bigger font-medium text-red-mine mb-1 mt-3">Contato 1 Cargo Atual</label>
            <input id="contactPosition1" type="text" name="contactPosition1" value="{{ old('contactPosition1', $supplier->contactPosition1) }}">

            <label class=" block bigger font-medium text-red-mine mb-1 mt-3">Contato 2 Telefone Atual</label>
            <input id="contactNumber2" type="text" name="contactNumber2" value="{{ old('contactNumber2', $supplier->contactNumber2) }}">

            <label class=" block bigger font-medium text-red-mine mb-1 mt-3">Contato 2 Nome Atual</label>
            <input id="contactName2" type="text" name="contactName2" value="{{ old('contactName2', $supplier->contactName2) }}">

            <label class=" block bigger font-medium text-red-mine mb-1 mt-3">Contato 2 Cargo Atual</label>
            <input id="contactPosition2" type="text" name="contactPosition2" value="{{ old('contactPosition2', $supplier->contactPosition2) }}">

          </div>
        </div>




        <div class="d-flex mt-5" style="gap: 15px;">
          <a href="{{ route('suppliers.index') }}" class="btn btn-cancel">Cancelar</a>
          <button type="submit" class="btn btn-send">Salvar</button>
        </div>
      </form>



    </div>
  </div>

  <script>
    document.getElementById('zip_code').addEventListener('blur', function() {
      const cep = this.value.replace(/\D/g, '');
      const url = `https://viacep.com.br/ws/${cep}/json/`;
      if (cep.length === 8) {
        fetch(url)
          .then(res => res.json())
          .then(data => {
            const place = document.getElementById('place');
            const neighborhood = document.getElementById('neighborhood');
            const city = document.getElementById('city');
            const number = document.getElementById('number');
            const state = document.getElementById('state');
            if (!data.erro) {
              place.value = data.logradouro || '';
              neighborhood.value = data.bairro || '';
              city.value = data.localidade || '';
              number.value = data.complemento || '';
              state.value = data.uf || '';
            } else {
              alert('CEP não encontrado.');
            }
          });
      } else if (cep.length > 0) {
        alert('CEP inválido. Deve conter 8 dígitos.');
      }
    });
  </script>

</body>

</html>