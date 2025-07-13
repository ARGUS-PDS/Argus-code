@extends('layouts.app') 

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/cadastro-funcionario.css') }}">

@endsection

{{-- Conteúdo principal da página --}}
@section('content')
<div class="container mt-4">
    <h3>Cadastro de Funcionário</h3>
    <form id="form-funcionario">

        <fieldset class="border p-3 mb-4">
            <legend class="w-auto">Dados do Funcionário</legend>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="codigo" class="form-label">Código</label>
                    <input type="text" class="form-control" id="codigo" required>
                </div>
                <div class="col-md-6">
                    <label for="nome" class="form-label">Nome Completo</label>
                    <input type="text" class="form-control" id="nome" required>
                </div>
                <div class="col-md-3">
                    <label for="cargo" class="form-label">Cargo</label>
                    <select id="cargo" class="form-select" required>
                        <option selected disabled>Selecione</option>
                        <option value="Gerente">Gerente</option>
                        <option value="Assistente">Assistente</option>
                        <option value="Operador">Operador</option>
                        <option value="Analista">Analista</option>
                        <option value="Estagiário">Estagiário</option>
                    </select>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="turno" class="form-label">Turno</label>
                    <select id="turno" class="form-select" required>
                        <option selected disabled>Selecione</option>
                        <option value="Manhã">Manhã</option>
                        <option value="Tarde">Tarde</option>
                        <option value="Noite">Noite</option>
                        <option value="Integral">Integral</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label d-block">Situação</label>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="situacao" id="situacao_ativo" value="Ativo" required>
                        <label class="form-check-label" for="situacao_ativo">Ativo</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="situacao" id="situacao_demitido" value="Demitido">
                        <label class="form-check-label" for="situacao_demitido">Demitido</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="situacao" id="situacao_afastado" value="Afastado">
                        <label class="form-check-label" for="situacao_afastado">Afastado</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="situacao" id="situacao_transferido" value="Transferido">
                        <label class="form-check-label" for="situacao_transferido">Transferido</label>
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="foto" class="form-label">Foto</label>
                    <input type="file" class="form-control" id="foto" accept="image/*">
                </div>
            </div>
        </fieldset>

        <fieldset class="border p-3 mb-4">
            <legend class="w-auto">Dados Pessoais</legend>
            <div class="row mb-3">
                <div class="col-md-3">
                    <label class="form-label d-block">Sexo</label>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sexo" id="sexo_masculino" value="Masculino" required>
                        <label class="form-check-label" for="sexo_masculino">Masculino</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" name="sexo" id="sexo_feminino" value="Feminino">
                        <label class="form-check-label" for="sexo_feminino">Feminino</label>
                    </div>
                </div>
                <div class="col-md-3">
                    <label for="nascimento" class="form-label">Data de nascimento</label>
                    <input type="date" class="form-control" id="nascimento">
                </div>
                <div class="col-md-3">
                    <label for="cpf" class="form-label">CPF</label>
                    <input type="text" class="form-control" id="cpf">
                    <div id="cpf-status" class="form-text text-danger"></div>
                </div>
                <div class="col-md-3">
                    <label for="rg" class="form-label">RG</label>
                    <input type="text" class="form-control" id="rg">
                </div>
            </div>

            <div class="row g-3 mt-3">
                <div class="col-md-6">
                    <label for="filiacao_mae" class="form-label">Nome da mãe</label>
                    <input type="text" class="form-control" id="filiacao_mae">
                </div>
                <div class="col-md-6">
                    <label for="filiacao_pai" class="form-label">Nome do pai</label>
                    <input type="text" class="form-control" id="filiacao_pai">
                </div>
            </div>

        </fieldset>

        <fieldset class="border p-3 mb-4">
            <legend class="w-auto">Endereço</legend>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="cep" class="form-label">CEP</label>
                    <input type="text" class="form-control" id="cep">
                </div>
                <div class="col-md-5">
                    <label for="logradouro" class="form-label">Rua</label>
                    <input type="text" class="form-control" id="logradouro">
                </div>
                <div class="col-md-4">
                    <label for="numero" class="form-label">Número</label>
                    <input type="text" class="form-control" id="numero">
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <label for="bairro" class="form-label">Bairro</label>
                    <input type="text" class="form-control" id="bairro">
                </div>
                <div class="col-md-5">
                    <label for="cidade" class="form-label">Cidade</label>
                    <input type="text" class="form-control" id="cidade">
                </div>
                <div class="col-md-3">
                    <label for="estado" class="form-label">Estado</label>
                    <input type="text" class="form-control" id="estado">
                </div>
            </div>
        </fieldset>

        <div class="text-end mb-4"> 
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </form>
</div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script> {{-- Certifique-se que o jQuery está sendo carregado, seu script usa $ --}}
    <script src="{{ asset('js/cadastro-funcionario.js') }}"></script>
