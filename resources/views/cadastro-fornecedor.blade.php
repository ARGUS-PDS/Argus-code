<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Cadastrar Fornecedor</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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

    <div class="d-flex tabs-nav">
      <div class="tab-item active" data-tab="dados">Dados iniciais</div>
      <div class="tab-item" data-tab="endereco">Endereço</div>
      <div class="tab-item" data-tab="contato">Contato</div>
    </div>

    <form id="formFornecedor">
      <div class="tab-section active" id="dados">
        <div class="row mb-3">
            <div class="col-md-4">
              <label for="codigo" class="form-label">Código</label>
              <input type="text" class="form-control" id="codigo" required>
            </div>  

            <div class="col-md-2">
                <label for="tipo_pessoa" class="form-label">Tipo da Pessoa</label>
                <select id="tipo_pessoa" class="form-select" required>
                  <option selected disabled>Selecione</option>
                  <option value="Física">Física</option>
                  <option value="Jurídica">Jurídica</option>
                </select>
              </div>
          
            <div class="col-md-4">
              <label id="label-doc" for="documento" class="form-label">CPF/CNPJ</label>
              <input type="text" class="form-control" id="documento" required>
            </div>
          
          </div>
          
          <div class="row mb-3">
            <div class="col-md-5">
                <label for="nome_fantasia" class="form-label">Nome Fantasia</label>
                <input type="text" class="form-control" id="nome_fantasia" required>
              </div>
            
            <div class="col-md-5">
              <label for="distribuidora" class="form-label">Distribuidora</label>
              <input type="text" class="form-control" id="distribuidora" required>
            </div>
          </div>
      </div>

<div class="tab-section" id="endereco">
    <div class="row mb-3">
      <div class="col-md-4">
        <label for="cep" class="form-label">CEP</label>
        <input type="text" class="form-control" id="cep">
      </div>
    </div>
  
    <div class="row mb-3">
        <div class="col-md-8">
          <label for="logradouro" class="form-label">Endereço</label>
          <input type="text" class="form-control" id="logradouro">
        </div>
        <div class="col-md-4">
          <label for="numero" class="form-label">Número</label>
          <input type="text" class="form-control" id="numero">
        </div>
    </div>
  
    <div class="row mb-3">
      <div class="col-md-4">
        <label for="bairro" class="form-label">Bairro</label>
        <input type="text" class="form-control" id="bairro">
      </div>
      <div class="col-md-4">
        <label for="cidade" class="form-label">Cidade</label>
        <input type="text" class="form-control" id="cidade">
      </div>
      <div class="col-md-4">
        <label for="estado" class="form-label">Estado</label>
        <select id="estado" class="form-select">
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
  </div>

      <div class="tab-section" id="contato">
        <div class="row mb-8">
          <div class="col-md-4">
            <label for="telefone_fixo" class="form-label">Telefone fixo</label>
            <input type="tel" class="form-control" id="telefone_fixo">
          </div>
          <div class="col-md-4">
            <label for="celular" class="form-label">Celular</label>
            <input type="tel" class="form-control" id="celular">
          </div>
          <div class="col-md-4">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email">
          </div>
        </div>
        <div class="row mb-8">
            <div class="col-md-4">
                <label for="contato1" class="form-label">Contato 1</label>
                <input type="text" class="form-control" id="contato1">
            </div>
            <div class="col-md-4">
                <label for="nome1" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome1">
            </div>
            <div class="col-md-4">
                <label for="cargo1" class="form-label">Cargo</label>
                <select id="cargo1" class="form-select">
                    <option selected disabled>Selecione</option>
                    <option value="comprador">Comprador</option>
                    <option value="gerente">Gerente</option>
                    <option value="financeiro">Financeiro</option>
                    <option value="diretor">Diretor</option>
                    <option value="representante">Representante</option>
                    <option value="outro">Outro</option>
                </select>
            </div>
        </div>
        <div class="row mb-8">
            <div class="col-md-4">
                <label for="contato2" class="form-label">Contato 2</label>
                <input type="text" class="form-control" id="contato2">
            </div>
            <div class="col-md-4">
                <label for="nome2" class="form-label">Nome</label>
                <input type="text" class="form-control" id="nome2">
            </div>
            <div class="col-md-4">
                <label for="cargo2" class="form-label">Cargo</label>
                <select id="cargo2" class="form-select">
                    <option selected disabled>Selecione</option>
                    <option value="comprador">Comprador</option>
                    <option value="gerente">Gerente</option>
                    <option value="financeiro">Financeiro</option>
                    <option value="diretor">Diretor</option>
                    <option value="representante">Representante</option>
                    <option value="outro">Outro</option>
                </select>
            </div>
        </div>
      </div>

      <div class="d-flex justify-content-end mt-4 gap-2">
        <button type="reset" class="btn btn-secondary">Cancelar</button>
        <button type="submit" class="btn btn-primary">Salvar</button>
      </div>
    </form>
  </div>

  <script>
    document.getElementById('tipo_pessoa').addEventListener('change', function () {
  const tipo = this.value;
  const label = document.getElementById('label-doc');
  const input = document.getElementById('documento');
  input.value = '';
  if (tipo === 'Física') {
    label.textContent = 'CPF';
    input.setAttribute('placeholder', 'Digite o CPF');
  } else if (tipo === 'Jurídica') {
    label.textContent = 'CNPJ';
    input.setAttribute('placeholder', 'Digite o CNPJ');
  }
});

document.getElementById('documento').addEventListener('blur', function () {
  const tipo = document.getElementById('tipo_pessoa').value;
  const valor = this.value.replace(/\D/g, '');

  if (tipo === 'Jurídica') {
    if (valor.length === 14) {
      fetch(`https://brasilapi.com.br/api/cnpj/v1/${valor}`)
        .then(res => {
          if (!res.ok) throw new Error('CNPJ inválido');
          return res.json();
        })
        .then(data => {
          console.log('CNPJ válido:', data);
          if (data.nome_fantasia) {
            document.getElementById('nome_fantasia').value = data.nome_fantasia;
          }
        })
        .catch(() => {
          alert('CNPJ inválido ou não encontrado');
        });
    } else {
      alert('CNPJ deve conter 14 dígitos.');
    }
  } else if (tipo === 'Física') {
    if (!validarCPF(valor)) {
      alert('CPF inválido');
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


    document.getElementById('cep').addEventListener('blur', function () {
    const cep = this.value.replace(/\D/g, '');
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then(response => response.json())
        .then(data => {
            if (!data.erro) {
            document.getElementById('logradouro').value = data.logradouro || '';
            document.getElementById('bairro').value = data.bairro || '';
            document.getElementById('cidade').value = data.localidade || '';
            document.getElementById('estado').value = data.uf || '';
            } else {
            alert('CEP não encontrado.');
            }
        })
        .catch(() => {
            alert('Erro ao buscar o CEP.');
        });
    }
    });
    
    const tabs = document.querySelectorAll(".tab-item");
    const sections = document.querySelectorAll(".tab-section");

    tabs.forEach(tab => {
      tab.addEventListener("click", () => {
        tabs.forEach(t => t.classList.remove("active"));
        tab.classList.add("active");

        sections.forEach(section => {
          section.classList.remove("active");
          if (section.id === tab.dataset.tab) {
            section.classList.add("active");
          }
        });
      });
    });

    document.getElementById('formFornecedor').addEventListener('submit', function (e) {
      e.preventDefault();
      alert("Fornecedor cadastrado com sucesso!");
    });
  </script>

</body>
</html>
