@extends('layouts.app')

@include('layouts.css-variables')

@section('styles')
<style>

    body {
        background-color: var(--color-bege-claro);
        padding: 0;
        margin: 0;
    }

    .container.py-4 {
        padding-top: 1.5rem !important;
        padding-bottom: 1.5rem !important;
    }

    .card-custom {
        background-color: var(--color-bege-card-interno);
        border-radius: 15px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
        padding: 2rem;
        margin-top: 2rem; /* Espaçamento entre o título h2 e o card */
    }

    h2 { /* Título principal da página */
        color: var(--color-vinho);
        font-weight: bold;
        margin-bottom: 0; /* Removendo margem inferior do h2 para controlar espaçamento pelo card-custom */
    }

    .card-custom fieldset {
        border: none;
        padding: 0;
        margin: 0;
    }

    .card-custom fieldset legend {
        color: var(--color-vinho);
        font-weight: bold;
        border-bottom: 2px solid var(--color-vinho);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
        width: 100%; /* Ocupa a largura total */
        display: block; /* Garante que se comporte como um bloco para o width: 100% */
        float: none;
    }

    .form-label {
        color: var(--color-gray-escuro);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-control, .form-select {
        border-radius: 8px;
        border: 1px solid var(--color-gray-claro);
        padding: 0.75rem 1rem;
        color: var(--color-gray-escuro);
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--color-vinho);
        box-shadow: 0 0 0 0.25rem rgba(119, 49, 56, 0.25);
    }

    /* Estilo para o botão "Salvar" (btn-primary) */
    .btn-primary {
        background-color: var(--color-vinho);
        border-color: var(--color-vinho);
        color: var(--color-white);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: var(--bs-btn-hover-bg);
        border-color: var(--bs-btn-hover-border-color);
    }

    /* Estilo para o botão "Cancelar" (btn-secondary) */
    .btn-secondary {
        background-color: var(--color-gray);
        border-color: var(--color-gray);
        color: var(--color-white);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: var(--color-gray-2); /* Cinza mais escuro para hover */
        border-color: var(--color-gray-3);
    }

    /* Estilos para radio buttons e checkboxes */
    .form-check-input:checked {
        background-color: var(--color-vinho);
        border-color: var(--color-vinho);
    }
    .form-check-input:focus {
        border-color: var(--color-vinho);
        box-shadow: 0 0 0 0.25rem rgba(119, 49, 56, 0.25);
    }
</style>
@endsection

{{-- Conteúdo principal da página --}}
@section('content')
<div class="container py-4">
    <h2 class="m-0">Cadastro de Funcionário</h2>

    {{-- Adicionar alerts de feedback se houver necessidade (erros/sucesso) --}}
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

    <div class="card-custom">
        <form id="form-funcionario">

            <fieldset class="mb-4">
                <legend>Dados do Funcionário</legend>
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

            <fieldset class="mb-4">
                <legend>Dados Pessoais</legend>
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

            <fieldset class="mb-4">
                <legend>Endereço</legend>

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

            <div class="d-flex justify-content-end mt-4 gap-2">
                <x-btn-cancelar href="{{ route('dashboard') }}" />
                <x-btn-salvar />
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cpf').mask('000.000.000-00', { reverse: true });
        $('#rg').mask('00.000.000-0');
        $('#cep').mask('00000-000');

        // Validação de CPF (exemplo básico)
        $('#cpf').on('blur', function() {
            var cpf = $(this).val().replace(/\D/g, '');
            if (cpf.length === 11) {
                // Implementar lógica de validação de CPF mais robusta se necessário
                $('#cpf-status').text('');
            } else {
                $('#cpf-status').text('CPF inválido.');
            }
        });

        // Autocompletar CEP
        $('#cep').on('blur', function() {
            var cep = $(this).val().replace(/\D/g, '');
            if (cep != "") {
                var validacep = /^[0-9]{8}$/;
                if(validacep.test(cep)) {
                    $("#logradouro").val("...");
                    $("#bairro").val("...");
                    $("#cidade").val("...");
                    $("#estado").val("...");

                    $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                        if (!("erro" in dados)) {
                            $("#logradouro").val(dados.logradouro);
                            $("#bairro").val(dados.bairro);
                            $("#cidade").val(dados.localidade);
                            $("#estado").val(dados.uf);
                        } else {
                            alert("CEP não encontrado.");
                            $("#logradouro").val("");
                            $("#bairro").val("");
                            $("#cidade").val("");
                            $("#estado").val("");
                        }
                    });
                } else {
                    alert("Formato de CEP inválido.");
                    $("#logradouro").val("");
                    $("#bairro").val("");
                    $("#cidade").val("");
                    $("#estado").val("");
                }
            } else {
                $("#logradouro").val("");
                $("#bairro").val("");
                $("#cidade").val("");
                $("#estado").val("");
            }
        });
    });
</script>
@endsection