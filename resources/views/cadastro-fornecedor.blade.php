<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Cadastrar Fornecedor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Favicon para tema claro -->
  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">

  <!-- Favicon para tema escuro -->
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
  
  <style>
    .tabs-nav {
      border-bottom: 2px solid #000;
      margin-bottom: 20px;
    }

    .tab-item {
      position: relative;
      cursor: pointer;
      margin-right: 20px;
      font-weight: 500;
    }

    .tab-item.active {
      color: #0d6efd;
    }

    .tab-item.active::after {
      content: '';
      position: absolute;
      bottom: -2px;
      left: 0;
      width: 100%;
      height: 4px;
      background-color: #0d6efd;
    }

    .tab-section {
      display: none;
    }

    .tab-section.active {
      display: block;
    }
  </style>
</head>

<body class="bg-light">

  <div class="container mt-5">
    <h2 class="mb-4">Cadastrar fornecedor</h2>

    @if ($errors->any())
    <div class="alert alert-danger">
      <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
    @endif



    <form id="formFornecedor" method="POST" action="{{ route('cadastrar-fornecedor.store') }}">
      @csrf
      <fieldset class="mb-4">
        <legend>Dados Iniciais</legend>
        <div class="row mb-3">
          <div class="col-md-4">
            <label for="code" class="form-label">Código</label>
            <input type="text" class="form-control" id="code" name="code">
          </div>

          <div class="col-md-2">
            <label for="type" class="form-label">Tipo da Pessoa</label>
            <select id="type" name="type" class="form-select" required>
              <option selected disabled>Selecione</option>
              <option value="FISICA">Física</option>
              <option value="JURIDICA">Jurídica</option>
            </select>
          </div>

          <div class="col-md-4">
            <label id="label-doc" for="cpf_cnpj" class="form-label">CPF/CNPJ</label>
            <input type="text" class="form-control" id="cpf_cnpj" name="document" required>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-5">
            <label for="trade_name" class="form-label">Nome Fantasia</label>
            <input type="text" class="form-control" id="trade_name" name="name" required>
          </div>

          <div class="col-md-5">
            <label for="distributor" class="form-label">Distribuidora</label>
            <input type="text" class="form-control" id="distributor" name="distributor">
          </div>
        </div>
      </fieldset>

      <fieldset class="mb-4">
        <legend>Endereço</legend>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="zip_code" class="form-label">CEP</label>
            <input type="text" class="form-control" id="zip_code" name="address[0][cep]">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-8">
            <label for="place" class="form-label">Logradouro</label>
            <input type="text" class="form-control" id="place" name="address[0][place]">
          </div>
          <div class="col-md-4">
            <label for="number" class="form-label">Número</label>
            <input type="text" class="form-control" id="number" name="address[0][number]">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="neighborhood" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="neighborhood" name="address[0][neighborhood]">
          </div>
          <div class="col-md-4">
            <label for="city" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="city" name="address[0][city]">
          </div>
          <div class="col-md-4">
            <label for="state" class="form-label">Estado</label>
            <select id="state" name="address[0][state]" class="form-select">
              <option selected disabled>Selecione</option>
              <option value="AC">AC</option>
              <option value="AL">AL</option>
              <option value="AP">AP</option>
              <option value="AM">AM</option>
              <option value="BA">BA</option>
              <option value="CE">CE</option>
              <option value="DF">DF</option>
              <option value="ES">ES</option>
              <option value="GO">GO</option>
              <option value="MA">MA</option>
              <option value="MT">MT</option>
              <option value="MS">MS</option>
              <option value="MG">MG</option>
              <option value="PA">PA</option>
              <option value="PB">PB</option>
              <option value="PR">PR</option>
              <option value="PE">PE</option>
              <option value="PI">PI</option>
              <option value="RJ">RJ</option>
              <option value="RN">RN</option>
              <option value="RS">RS</option>
              <option value="RO">RO</option>
              <option value="RR">RR</option>
              <option value="SC">SC</option>
              <option value="SP">SP</option>
              <option value="SE">SE</option>
              <option value="TO">TO</option>
            </select>
          </div>
        </div>
      </fieldset>

      <fieldset class="mb-4">
        <legend>Contato</legend>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="fixedphone" class="form-label">Telefone fixo</label>
            <input type="tel" class="form-control" id="fixedphone" name="fixedphone">
          </div>
          <div class="col-md-4">
            <label for="phone" class="form-label">Celular</label>
            <input type="tel" class="form-control" id="phone" name="phone">
          </div>
          <div class="col-md-4">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="contactNumber1" class="form-label">Contato 1 Telefone</label>
            <input type="text" class="form-control" id="contactNumber1" name="contactNumber1">
          </div>
          <div class="col-md-4">
            <label for="contactName1" class="form-label">Contato 1 Nome</label>
            <input type="text" class="form-control" id="contactName1" name="contactName1">
          </div>
          <div class="col-md-4">
            <label for="contactPosition1" class="form-label">Contato 1 Cargo</label>
            <input type="text" class="form-control" id="contactPosition1" name="contactPosition1">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="contactNumber2" class="form-label">Contato 2 Telefone</label>
            <input type="text" class="form-control" id="contactNumber2" name="contactNumber2">
          </div>
          <div class="col-md-4">
            <label for="contactName2" class="form-label">Contato 2 Nome</label>
            <input type="text" class="form-control" id="contactName2" name="contactName2">
          </div>
          <div class="col-md-4">
            <label for="contactPosition2" class="form-label">Contato 2 Cargo</label>
            <input type="text" class="form-control" id="contactPosition2" name="contactPosition2">
          </div>
        </div>
      </fieldset>

      <div class="d-flex justify-content-end mt-4 gap-2">
        <button type="reset" class="btn btn-secondary">Cancelar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>

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


    document.getElementById('type').addEventListener('change', function() {
      const type = this.value;
      const label = document.getElementById('label-doc');
      const input = document.getElementById('cpf_cnpj');
      input.value = '';
      if (type === 'FISICA') {
        label.textContent = 'CPF';
        input.setAttribute('placeholder', 'Digite o CPF');
        input.maxLength = 11;
      } else if (type === 'JURIDICA') {
        label.textContent = 'CNPJ';
        input.setAttribute('placeholder', 'Digite o CNPJ');
        input.maxLength = 14;
      }
    });

    let isDocumentValid = false;

    document.getElementById('cpf_cnpj').addEventListener('blur', async function() {
      const type = document.getElementById('type').value;
      const value = this.value.replace(/\D/g, '');

      if (type === 'JURIDICA') {
        if (value.length === 14) {
          try {
            const res = await fetch(`https://brasilapi.com.br/api/cnpj/v1/${value}`);
            if (!res.ok) throw new Error('CNPJ inválido');
            const data = await res.json();
            console.log('CNPJ válido:', data);
            if (data.nome_fantasia) {
              document.getElementById('trade_name').value = data.nome_fantasia;
            }
            isDocumentValid = true;
          } catch (error) {
            alert('CNPJ inválido ou não encontrado');
            isDocumentValid = false;
          }
        } else {
          alert('CNPJ deve conter 14 dígitos.');
          isDocumentValid = false;
        }
      } else if (type === 'FISICA') {
        if (validarCPF(value)) {
          isDocumentValid = true;
        } else {
          alert('CPF inválido');
          isDocumentValid = false;
        }
      }
    });


    function validarCPF(cpf) {
      cpf = cpf.replace(/[^\d]+/g, '');
      if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;

      let soma = 0;
      for (let i = 0; i < 9; i++) soma += parseInt(cpf.charAt(i)) * (10 - i);
      let resto = (soma * 10) % 11;
      if (resto === 10 || resto === 11) resto = 0;
      if (resto !== parseInt(cpf.charAt(9))) return false;

      soma = 0;
      for (let i = 0; i < 10; i++) soma += parseInt(cpf.charAt(i)) * (11 - i);
      resto = (soma * 10) % 11;
      if (resto === 10 || resto === 11) resto = 0;
      return resto === parseInt(cpf.charAt(10));
    }

    document.querySelectorAll('.tab-item').forEach(tab => {
      tab.addEventListener('click', () => {
        document.querySelectorAll('.tab-item').forEach(item => item.classList.remove('active'));
        document.querySelectorAll('.tab-section').forEach(section => section.classList.remove('active'));

        tab.classList.add('active');
        document.getElementById(tab.dataset.tab).classList.add('active');
      });
    });

    document.getElementById('formFornecedor').addEventListener('submit', function(e) {
      if (!isDocumentValid) {
        e.preventDefault();
        alert('CPF ou CNPJ inválido. Verifique antes de salvar.');
      }
    });
  </script>

</body>

</html>