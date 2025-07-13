@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Cadastrar Nova Empresa</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('companies.index') }}" class="btn btn-outline-secondary btn-custom-back">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>

<form action="{{ route('companies.store') }}" method="POST">
    @csrf

    <h4>Dados da Empresa</h4>

    <div class="mb-3">
        <label>CNPJ</label>
        <input type="text" name="cnpj" class="form-control" required maxlength="18" />
    </div>

    <div class="mb-3">
        <label>Razão Social</label>
        <input type="text" name="businessName" class="form-control" required maxlength="50" />
    </div>

    <div class="mb-3">
        <label>Nome Fantasia</label>
        <input type="text" name="tradeName" class="form-control" required maxlength="50" />
    </div>

    <div class="mb-3">
        <label>Inscrição Estadual</label>
        <input type="text" name="stateRegistration" class="form-control" maxlength="15" />
    </div>

    <h4>Endereço</h4>

    <div class="mb-3">
        <label>CEP</label>
        <input type="text" name="cep" class="form-control" required maxlength="8" />
    </div>

    <div class="mb-3">
        <label>Logradouro</label>
        <input type="text" name="place" class="form-control" required maxlength="100" />
    </div>

    <div class="mb-3">
        <label>Número</label>
        <input type="number" name="number" class="form-control" required />
    </div>

    <div class="mb-3">
        <label>Bairro</label>
        <input type="text" name="neighborhood" class="form-control" required maxlength="100" />
    </div>

    <div class="mb-3">
        <label>Cidade</label>
        <input type="text" name="city" class="form-control" required maxlength="100" />
    </div>

    <div class="mb-3">
        <label>Estado</label>
        <input type="text" name="state" class="form-control" required maxlength="2" />
    </div>

    <h4>Usuário Master (Dono da Empresa)</h4>

    <div class="mb-3">
        <label>Nome</label>
        <input type="text" name="user_name" class="form-control" required maxlength="255" />
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input type="email" name="user_email" class="form-control" required maxlength="255" />
    </div>

    <div class="mb-3">
        <label>Senha</label>
        <input type="password" name="user_password" class="form-control" required minlength="6" />
    </div>

    <button type="submit" class="btn btn-success">Salvar Empresa e Usuário</button>
</form>

</div>

<script src="{{ asset('js/empresa.js') }}"></script>

@endsection
