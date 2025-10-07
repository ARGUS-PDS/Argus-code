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
        box-shadow: 0 4px 8px var(--color-shadow);
        padding: 2rem;
    }

    h2 {
        color: var(--color-vinho);
        font-weight: bold;
        margin-bottom: 1.5rem;
    }

    .card-custom fieldset legend {
        color: var(--color-vinho);
        font-weight: bold;
        border-bottom: 2px solid var(--color-vinho);
        padding-bottom: 0.5rem;
        margin-bottom: 1.5rem;
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
        box-shadow: 0 4px 8px var(--color-shadow);
    }

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

    .btn-secondary {
        background-color: var(--color-gray);
        border-color: var(--color-gray);
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: var(--color-gray-2);
        border-color:var(--color-gray);
    }

    .alert {
        border-radius: 8px;
        font-weight: 500;
    }

    .btn-custom-back {
        background-color: var(--color-bege-claro);
        border: 1px solid var(--color-vinho);
        color: var(--color-vinho);
        border-radius: 8px;
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .btn-custom-back:hover {
        background-color: var(--color-vinho) !important;
        color: var(--color-bege-claro) !important;
        border-color: var(--color-vinho) !important;
    }

    .obrigatorio{
        cursor: pointer;
        color: var(--color-red);
    }
</style>
@endsection


@section('content')

{{-- Modal de mensagens globais --}}
@include('components.alert-modal')

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="m-0">{{ __('suppliersregister.title_create') }}</h2>
        <x-btn-voltar url="{{ route('suppliers.index') }}" />
    </div>

    <div class="card-custom">
        <form id="formFornecedor" method="POST" action="{{ route('suppliers.store') }}">
            @csrf
            <fieldset class="mb-4">
                <legend>{{ __('suppliersregister.fieldset_initial_data') }}</legend>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="code" class="form-label">{{ __('suppliersregister.label_code') }} <span class="obrigatorio" title="Campo obrigatório"> *</span></label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}" maxlength="20" required>
                        <div class="invalid-feedback">O código é obrigatório.</div>
                        <div class="valid-feedback">Código válido!</div>
                    </div>

                    <div class="col-md-2">
                        <label for="type" class="form-label">{{ __('suppliersregister.label_person_type') }}<span class="obrigatorio" title="Campo obrigatório"> *</span></label>
                        <select id="type" name="type" class="form-select" required>
                            <option value="" selected disabled>{{ __('suppliersregister.option_select') }}</option>
                            <option value="FISICA" {{ old('type') == 'FISICA' ? 'selected' : '' }}>{{ __('suppliersregister.option_physical') }}</option>
                            <option value="JURIDICA" {{ old('type') == 'JURIDICA' ? 'selected' : '' }}>{{ __('suppliersregister.option_legal') }}</option>
                        </select>
                        <div class="invalid-feedback">Selecione o tipo da pessoa.</div>
                        <div class="valid-feedback">Tipo válido!</div>
                    </div>

                    <div class="col-md-4">
                        <label id="label-doc" for="cpf_cnpj" class="form-label">{{ __('suppliersregister.label_document') }} <span class="obrigatorio" title="Campo obrigatório"> *</span></label>
                        <input type="text" class="form-control" id="cpf_cnpj" name="document" value="{{ old('document') }}" required>
                        <div class="invalid-feedback">Digite um CPF (11 dígitos) ou CNPJ (14 dígitos) válido.</div>
                        <div class="valid-feedback">Documento válido!</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="trade_name" class="form-label">{{ __('suppliersregister.label_trade_name') }} <span class="obrigatorio" title="Campo obrigatório"> *</span></label>
                        <input type="text" class="form-control" id="trade_name" name="name" value="{{ old('name') }}" maxlength="100" required>
                        <div class="invalid-feedback">Digite um fornecedor válido.</div>
                        <div class="valid-feedback">Fornecedor válido!</div>
                    </div>

                    <div class="col-md-5">
                        <label for="distributor" class="form-label">{{ __('suppliersregister.label_distributor') }}</label>
                        <input type="text" class="form-control" id="distributor" name="distributor" value="{{ old('distributor') }}" maxlength="100">
                        <div class="invalid-feedback">Digite uma distribuidora válida.</div>
                        <div class="valid-feedback">Durtribuidora válida!</div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-4">
                <legend>{{ __('suppliersregister.fieldset_address') }}</legend>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="zip_code" class="form-label">{{ __('suppliersregister.label_zip_code') }} <span class="obrigatorio" title="Campo obrigatório"> *</span></label>
                        <input type="text" class="form-control" id="zip_code" name="address[cep]" value="{{ old('address.cep') }}" required>
                        <div class="invalid-feedback">Digite um CEP válido com 8 dígitos.</div>
                        <div class="valid-feedback">CEP válido!</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="place" class="form-label">{{ __('suppliersregister.label_place') }}<span class="obrigatorio" title="Campo obrigatório"> *</span></label>
                        <input type="text" class="form-control" id="place" name="address[place]" value="{{ old('address.place') }}" required>
                        <div class="invalid-feedback">Digite um logradouro válido.</div>
                        <div class="valid-feedback">Logradouro válido!</div>

                    </div>
                    <div class="col-md-4">
                        <label for="number" class="form-label">{{ __('suppliersregister.label_number') }} <span class="obrigatorio" title="Campo obrigatório"> *</span></label>
                        <input type="number" class="form-control" id="number" name="address[number]" value="{{ old('address.number') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="neighborhood" class="form-label">{{ __('suppliersregister.label_neighborhood') }} <span class="obrigatorio" title="Campo obrigatório"> *</span></label>
                        <input type="text" class="form-control" id="neighborhood" name="address[neighborhood]" value="{{ old('address.neighborhood') }}" required>
                        <div class="invalid-feedback">Digite um bairro válido com apenas letras e espaços.</div>
                        <div class="valid-feedback">Bairro válido!</div>
                    </div>
                    <div class="col-md-4">
                        <label for="city" class="form-label">{{ __('suppliersregister.label_city') }} <span class="obrigatorio" title="Campo obrigatório"> *</span></label>
                        <input type="text" class="form-control" id="city" name="address[city]" value="{{ old('address.city') }}" required>
                        <div class="invalid-feedback">Digite uma cidade válida com apenas letras e espaços.</div>
                        <div class="valid-feedback">Cidade válida!</div>
                    </div>
                    <div class="col-md-4">
                        <label for="state" class="form-label">{{ __('suppliersregister.label_state') }} <span class="obrigatorio" title="Campo obrigatório"> *</span></label>
                        <select id="state" name="address[state]" class="form-select" required>
                            <option value="" selected disabled>{{ __('suppliersregister.option_select') }} </option>
                            <option value="AC" {{ old('address.state') == 'AC' ? 'selected' : '' }}>AC</option>
                            <option value="AL" {{ old('address.state') == 'AL' ? 'selected' : '' }}>AL</option>
                            <option value="AP" {{ old('address.state') == 'AP' ? 'selected' : '' }}>AP</option>
                            <option value="AM" {{ old('address.state') == 'AM' ? 'selected' : '' }}>AM</option>
                            <option value="BA" {{ old('address.state') == 'BA' ? 'selected' : '' }}>BA</option>
                            <option value="CE" {{ old('address.state') == 'CE' ? 'selected' : '' }}>CE</option>
                            <option value="DF" {{ old('address.state') == 'DF' ? 'selected' : '' }}>DF</option>
                            <option value="ES" {{ old('address.state') == 'ES' ? 'selected' : '' }}>ES</option>
                            <option value="GO" {{ old('address.state') == 'GO' ? 'selected' : '' }}>GO</option>
                            <option value="MA" {{ old('address.state') == 'MA' ? 'selected' : '' }}>MA</option>
                            <option value="MT" {{ old('address.state') == 'MT' ? 'selected' : '' }}>MT</option>
                            <option value="MS" {{ old('address.state') == 'MS' ? 'selected' : '' }}>MS</option>
                            <option value="MG" {{ old('address.state') == 'MG' ? 'selected' : '' }}>MG</option>
                            <option value="PA" {{ old('address.state') == 'PA' ? 'selected' : '' }}>PA</option>
                            <option value="PB" {{ old('address.state') == 'PB' ? 'selected' : '' }}>PB</option>
                            <option value="PR" {{ old('address.state') == 'PR' ? 'selected' : '' }}>PR</option>
                            <option value="PE" {{ old('address.state') == 'PE' ? 'selected' : '' }}>PE</option>
                            <option value="PI" {{ old('address.state') == 'PI' ? 'selected' : '' }}>PI</option>
                            <option value="RJ" {{ old('address.state') == 'RJ' ? 'selected' : '' }}>RJ</option>
                            <option value="RN" {{ old('address.state') == 'RN' ? 'selected' : '' }}>RN</option>
                            <option value="RS" {{ old('address.state') == 'RS' ? 'selected' : '' }}>RS</option>
                            <option value="RO" {{ old('address.state') == 'RO' ? 'selected' : '' }}>RO</option>
                            <option value="RR" {{ old('address.state') == 'RR' ? 'selected' : '' }}>RR</option>
                            <option value="SC" {{ old('address.state') == 'SC' ? 'selected' : '' }}>SC</option>
                            <option value="SP" {{ old('address.state') == 'SP' ? 'selected' : '' }}>SP</option>
                            <option value="SE" {{ old('address.state') == 'SE' ? 'selected' : '' }}>SE</option>
                            <option value="TO" {{ old('address.state') == 'TO' ? 'selected' : '' }}>TO</option>
                        </select>
                        <div class="invalid-feedback">Selecione um estado.</div>
                        <div class="valid-feedback">Estado válido!</div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-4">
                <legend>{{ __('suppliersregister.fieldset_contact') }}</legend>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="fixedphone" class="form-label">{{ __('suppliersregister.label_fixed_phone') }}</label>
                        <input type="tel" class="form-control" id="fixedphone" name="fixedphone" value="{{ old('fixedphone') }}">
                        <div class="invalid-feedback">Digite um número de telefone válido (com DDD).</div>
                        <div class="valid-feedback">Telefone válido!</div>                    
                    </div>
                    <div class="col-md-4">
                        <label for="phone" class="form-label">{{ __('suppliersregister.label_phone') }}<span class="obrigatorio" title="Campo obrigatório"> *</span></label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required>
                        <div class="invalid-feedback">Digite um número de telefone válido (com DDD).</div>
                        <div class="valid-feedback">Telefone válido!</div>
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">{{ __('suppliersregister.label_email') }} <span class="obrigatorio" title="Campo obrigatório"> *</span></label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                        <div class="invalid-feedback">Digite um e-mail válido.</div>
                        <div class="valid-feedback">E-mail válido!</div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="contactNumber1" class="form-label">{{ __('suppliersregister.label_contact1_phone') }}</label>
                        <input type="text" class="form-control" id="contactNumber1" name="contactNumber1" value="{{ old('contactNumber1') }}">
                        <div class="invalid-feedback">Digite um número de telefone válido (com DDD).</div>
                        <div class="valid-feedback">Telefone válido!</div>                    
                    </div>
                    <div class="col-md-4">
                        <label for="contactName1" class="form-label">{{ __('suppliersregister.label_contact1_name') }}</label>
                        <input type="text" class="form-control" id="contactName1" name="contactName1" value="{{ old('contactName1') }}">
                        <div class="invalid-feedback">Digite um nome válido.</div>
                        <div class="valid-feedback">Nome válido!</div>
                    </div>
                    <div class="col-md-4">
                        <label for="contactPosition1" class="form-label">{{ __('suppliersregister.label_contact1_position') }}</label>
                        <input type="text" class="form-control" id="contactPosition1" name="contactPosition1" value="{{ old('contactPosition1') }}">
                        <div class="invalid-feedback">Digite um cargo válido.</div>
                        <div class="valid-feedback">Cargo válido!</div>                   
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="contactNumber2" class="form-label">{{ __('suppliersregister.label_contact2_phone') }}</label>
                        <input type="text" class="form-control" id="contactNumber2" name="contactNumber2" value="{{ old('contactNumber2') }}">
                        <div class="invalid-feedback">Digite um número de telefone válido (com DDD).</div>
                        <div class="valid-feedback">Telefone válido!</div>                    
                    </div>
                    <div class="col-md-4">
                        <label for="contactName2" class="form-label">{{ __('suppliersregister.label_contact2_name') }}</label>
                        <input type="text" class="form-control" id="contactName2" name="contactName2" value="{{ old('contactName2') }}">
                        <div class="invalid-feedback">Digite um nome válido.</div>
                        <div class="valid-feedback">Nome válido!</div>                    
                    </div>
                    <div class="col-md-4">
                        <label for="contactPosition2" class="form-label">{{ __('suppliersregister.label_contact2_position') }}</label>
                        <input type="text" class="form-control" id="contactPosition2" name="contactPosition2" value="{{ old('contactPosition2') }}">
                        <div class="invalid-feedback">Digite um cargo válido.</div>
                        <div class="valid-feedback">Cargo válido!</div>
                    </div>
                </div>
            </fieldset>

            <div class="d-flex justify-content-end mt-4 gap-2">
                <x-btn-cancelar href="{{ route('suppliers.index') }}" />
                <x-btn-salvar />
            </div>
        </form>
    </div>
</div>

<script src="{{ asset('js/supplier-create-js/utils.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
<script>
    $(document).ready(function() {
        $('#cpf_cnpj').mask('000.000.000-00', {
            reverse: true
        });

        $('#type').change(function() {
            var type = $(this).val();
            var docLabel = $('#label-doc');
            var docInput = $('#cpf_cnpj');

            if (type === 'FISICA') {
                docLabel.text('{{ __('suppliersregister.label_cpf') }}');
                docInput.mask('000.000.000-00', {
                    reverse: true
                });
            } else if (type === 'JURIDICA') {
                docLabel.text('{{ __('suppliersregister.label_cnpj') }}');
                docInput.mask('00.000.000/0000-00', {
                    reverse: true
                });
            } else {
                docLabel.text('{{ __('suppliersregister.label_document') }}');
                docInput.unmask();
            }
            docInput.val('');
        });

        $('#zip_code').mask('00000-000');
        $('#fixedphone').mask('(00) 0000-0000');
        $('#phone').mask('(00) 00000-0000');
        $('#contactNumber1').mask('(00) 00000-0000');
        $('#contactNumber2').mask('(00) 00000-0000');

        $('#zip_code').blur(function() {
            var cep = $(this).val().replace(/\D/g, '');
            if (cep != "") {
                var validacep = /^[0-9]{8}$/;
                if (validacep.test(cep)) {
                    $("#place").val("...");
                    $("#neighborhood").val("...");
                    $("#city").val("...");
                    $("#state").val("...");

                    $.getJSON("https://viacep.com.br/ws/" + cep + "/json/?callback=?", function(dados) {
                        if (!("erro" in dados)) {
                            $("#place").val(dados.logradouro);
                            $("#neighborhood").val(dados.bairro);
                            $("#city").val(dados.localidade);
                            $("#state").val(dados.uf).change();
                        } else {
                            alert('{{ __('suppliersregister.alert_zip_code_not_found') }}');
                            $("#place").val("");
                            $("#neighborhood").val("");
                            $("#city").val("");
                            $("#state").val("Selecione");
                        }
                    });
                } else {
                    alert('{{ __('suppliersregister.alert_invalid_zip_code_format') }}');
                    $("#place").val("");
                    $("#neighborhood").val("");
                    $("#city").val("");
                    $("#state").val("Selecione");
                }
            } else {
                $("#place").val("");
                $("#neighborhood").val("");
                $("#city").val("");
                $("#state").val("Selecione");
            }
        });
    });
</script>
@endsection