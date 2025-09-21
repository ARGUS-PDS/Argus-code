<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <title>Cadastrar Nova Empresa - Argus Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">

  @include('layouts.css-variables')
  <link rel="stylesheet" href="{{ asset('css/companies-create.css') }}">
</head>

<body>
  <div class="container-card">
    <div class="header-section">
      <h2>Cadastrar Nova Empresa</h2>
      <x-btn-voltar />
    </div>

    <div class="required-note">
      <span class="text-danger">*</span> Campos obrigatórios
    </div>

    @if ($errors->any())
    <div class="alert alert-custom alert-danger-custom alert-show">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    <div id="jsErrorContainer" class="alert alert-custom alert-danger-custom d-none">
      <i class="bi bi-exclamation-triangle-fill me-2"></i>
      <span id="jsErrorMessage"></span>
    </div>

    <form action="{{ route('companies.store') }}" id="companyForm" method="POST">
      @csrf

      {{-- Dados da Empresa --}}
      <div class="section-card">
        <h4 class="card-title">Dados da Empresa</h4>
        <div class="row g-3">
          <div class="col-md-6">
            <label for="cnpj" class="form-label required">CNPJ</label>
            <input type="text" name="cnpj" id="cnpj" class="form-control" required maxlength="18" placeholder="00.000.000/0000-00" />
            <div id="cnpjStatus" class="validation-status d-none"></div>
          </div>
          <div class="col-md-6">
            <label for="businessName" class="form-label required">Razão Social</label>
            <input type="text" name="businessName" id="businessName" class="form-control" required maxlength="50" />
          </div>
          <div class="col-md-6">
            <label for="tradeName" class="form-label required">Nome Fantasia</label>
            <input type="text" name="tradeName" id="tradeName" class="form-control" required maxlength="50" />
          </div>
          <div class="col-md-6">
            <label for="stateRegistration" class="form-label required">Inscrição Estadual</label>
            <input type="text" name="stateRegistration" id="stateRegistration" class="form-control" maxlength="15" />
          </div>
        </div>
      </div>

      {{-- Endereço --}}
      <div class="section-card">
        <h4 class="card-title">Endereço</h4>
        <div class="row g-3">
          <div class="col-md-6">
            <label for="cep" class="form-label required">CEP</label>
            <input type="text" name="cep" id="cep" class="form-control" required maxlength="9" placeholder="00000-000">
            <div id="cepStatus" class="validation-status d-none"></div>
          </div>
          <div class="col-md-6">
            <label for="place" class="form-label required">Logradouro</label>
            <input type="text" name="place" id="place" class="form-control" required maxlength="100" />
          </div>
          <div class="col-md-6">
            <label for="number" class="form-label required">Número</label>
            <input type="number" name="number" id="number" class="form-control" required min="0" oninput="validarNumero(this)" />
            <small class="text-muted">Apenas valores positivos</small>
          </div>
          <div class=" col-md-6">
            <label for="details" class="form-label">Complemento</label>
            <input type="text" name="details" id="details" class="form-control" maxlength="50" placeholder="Opcional" />
          </div>
          <div class="col-md-6">
            <label for="neighborhood" class="form-label required">Bairro</label>
            <input type="text" name="neighborhood" id="neighborhood" class="form-control" required maxlength="100" />
          </div>
          <div class="col-md-6">
            <label for="city" class="form-label required">Cidade</label>
            <input type="text" name="city" id="city" class="form-control" required maxlength="100" />
          </div>
          <div class="col-md-6">
            <label for="state" class="form-label required">Estado</label>
            <select name="state" id="state" class="form-select" required>
              <option value="">Selecione um estado</option>
              <option value="AC">Acre</option>
              <option value="AL">Alagoas</option>
              <option value="AP">Amapá</option>
              <option value="AM">Amazonas</option>
              <option value="BA">Bahia</option>
              <option value="CE">Ceará</option>
              <option value="DF">Distrito Federal</option>
              <option value="ES">Espírito Santo</option>
              <option value="GO">Goiás</option>
              <option value="MA">Maranhão</option>
              <option value="MT">Mato Grosso</option>
              <option value="MS">Mato Grosso do Sul</option>
              <option value="MG">Minas Gerais</option>
              <option value="PA">Pará</option>
              <option value="PB">Paraíba</option>
              <option value="PR">Paraná</option>
              <option value="PE">Pernambuco</option>
              <option value="PI">Piauí</option>
              <option value="RJ">Rio de Janeiro</option>
              <option value="RN">Rio Grande do Norte</option>
              <option value="RS">Rio Grande do Sul</option>
              <option value="RO">Rondônia</option>
              <option value="RR">Roraima</option>
              <option value="SC">Santa Catarina</option>
              <option value="SP">São Paulo</option>
              <option value="SE">Sergipe</option>
              <option value="TO">Tocantins</option>
            </select>
          </div>
        </div>
      </div>

      {{-- Usuário Master --}}
      <div class="section-card">
        <h4 class="card-title">Usuário Master (Dono da Empresa)</h4>
        <div class="row g-3">
          <div class="col-md-6">
            <label for="user_name" class="form-label required">Nome</label>
            <input type="text" name="user_name" id="user_name" class="form-control" required maxlength="255" />
            <small class="text-muted">Apenas letras são permitidas</small>
          </div>
          <div class="col-md-6">
            <label for="user_email" class="form-label required">Email</label>
            <input type="email" name="user_email" id="user_email" class="form-control" required maxlength="255" placeholder="exemplo@gmail.com" />
            <div id="emailStatus" class="validation-status d-none"></div>
          </div>

          <div class="col-md-6">
            <label for="user_password" class="form-label required">Senha</label>
            <div class="password-container">
              <input type="password" name="user_password" id="user_password" class="form-control" required minlength="8" />
              <i class="toggle-password fas fa-eye" onclick="togglePassword('user_password', this)"></i>
              <button type="button" class="generate-password" title="Gerar senha forte" onclick="generateStrongPassword()">
                <i class=" fas fa-sync-alt"></i>
              </button>
            </div>
            <div class="password-strength">
              <div class="progress">
                <div class="progress-bar" role="progressbar" style="width: 0%" id="passwordStrengthBar"></div>
              </div>
              <div class="password-feedback" id="passwordFeedback">Força da senha: muito fraca</div>
            </div>
            <div class="password-requirements">
              <div class="requirement invalid" id="lengthReq"><i class="bi bi-x-circle"></i><span>Mínimo de 8 caracteres</span></div>
              <div class="requirement invalid" id="uppercaseReq"><i class="bi bi-x-circle"></i><span>Pelo menos uma letra maiúscula</span></div>
              <div class="requirement invalid" id="lowercaseReq"><i class="bi bi-x-circle"></i><span>Pelo menos uma letra minúscula</span></div>
              <div class="requirement invalid" id="numberReq"><i class="bi bi-x-circle"></i><span>Pelo menos um número</span></div>
              <div class="requirement invalid" id="specialReq"><i class="bi bi-x-circle"></i><span>Pelo menos um caractere especial (!@#$%^&* etc.)</span></div>
            </div>
          </div>

          <div class="col-md-6">
            <label for="user_password_confirmation" class="form-label required">Confirmar Senha</label>
            <div class="password-container">
              <input type="password" name="user_password_confirmation" id="user_password_confirmation" class="form-control" required minlength="8" />
              <i class="toggle-password fas fa-eye" onclick="togglePassword('user_password_confirmation', this)"></i>
            </div>
            <div class="password-match-feedback invalid" id="passwordMatchFeedback">As senhas não coincidem</div>
          </div>
        </div>
      </div>

      <div class="action-buttons">
        <button type="submit" class="btn btn-primary">Salvar Empresa e Usuário</button>
      </div>
    </form>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="{{ asset('js/companies-create.js') }}"></script>

</body>

</html>