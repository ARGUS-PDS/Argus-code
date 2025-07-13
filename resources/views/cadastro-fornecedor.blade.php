<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Cadastrar Fornecedor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">

  @include('layouts.css-variables')
  
    <link rel="stylesheet" href="{{ asset('css/cadastro-fornecedor.css') }}">

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
            <input type="text" class="form-control" id="zip_code" name="address[cep]">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-8">
            <label for="place" class="form-label">Logradouro</label>
            <input type="text" class="form-control" id="place" name="address[place]">
          </div>
          <div class="col-md-4">
            <label for="number" class="form-label">Número</label>
            <input type="number" class="form-control" id="number" name="address[number]">
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label for="neighborhood" class="form-label">Bairro</label>
            <input type="text" class="form-control" id="neighborhood" name="address[neighborhood]">
          </div>
          <div class="col-md-4">
            <label for="city" class="form-label">Cidade</label>
            <input type="text" class="form-control" id="city" name="address[city]">
          </div>
          <div class="col-md-4">
            <label for="state" class="form-label">Estado</label>
            <select id="state" name="address[state]" class="form-select">
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

      <script src="{{ asset('js/cadastro-fornecedor.js') }}"></script>


</body>

</html>