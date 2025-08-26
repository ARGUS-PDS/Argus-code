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
        box-shadow: 0 0 0 0.25rem rgba(119, 49, 56, 0.25);
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
</style>
@endsection

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="m-0">{{ __('suppliersregister.title_create') }}</h2>
        <x-btn-voltar" />
    </div>

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
        <form id="formFornecedor" method="POST" action="{{ route('suppliers.store') }}">
            @csrf
            <fieldset class="mb-4">
                <legend>{{ __('suppliersregister.fieldset_initial_data') }}</legend>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="code" class="form-label">{{ __('suppliersregister.label_code') }}</label>
                        <input type="text" class="form-control" id="code" name="code" value="{{ old('code') }}">
                    </div>

                    <div class="col-md-2">
                        <label for="type" class="form-label">{{ __('suppliersregister.label_person_type') }}</label>
                        <select id="type" name="type" class="form-select" required>
                            <option value="" selected disabled>{{ __('suppliersregister.option_select') }}</option>
                            <option value="FISICA" {{ old('type') == 'FISICA' ? 'selected' : '' }}>{{ __('suppliersregister.option_physical') }}</option>
                            <option value="JURIDICA" {{ old('type') == 'JURIDICA' ? 'selected' : '' }}>{{ __('suppliersregister.option_legal') }}</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label id="label-doc" for="cpf_cnpj" class="form-label">{{ __('suppliersregister.label_document') }}</label>
                        <input type="text" class="form-control" id="cpf_cnpj" name="document" value="{{ old('document') }}" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-5">
                        <label for="trade_name" class="form-label">{{ __('suppliersregister.label_trade_name') }}</label>
                        <input type="text" class="form-control" id="trade_name" name="name" value="{{ old('name') }}" required>
                    </div>

                    <div class="col-md-5">
                        <label for="distributor" class="form-label">{{ __('suppliersregister.label_distributor') }}</label>
                        <input type="text" class="form-control" id="distributor" name="distributor" value="{{ old('distributor') }}">
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-4">
                <legend>{{ __('suppliersregister.fieldset_address') }}</legend>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="zip_code" class="form-label">{{ __('suppliersregister.label_zip_code') }}</label>
                        <input type="text" class="form-control" id="zip_code" name="address[cep]" value="{{ old('address.cep') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-8">
                        <label for="place" class="form-label">{{ __('suppliersregister.label_place') }}</label>
                        <input type="text" class="form-control" id="place" name="address[place]" value="{{ old('address.place') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="number" class="form-label">{{ __('suppliersregister.label_number') }}</label>
                        <input type="number" class="form-control" id="number" name="address[number]" value="{{ old('address.number') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="neighborhood" class="form-label">{{ __('suppliersregister.label_neighborhood') }}</label>
                        <input type="text" class="form-control" id="neighborhood" name="address[neighborhood]" value="{{ old('address.neighborhood') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="city" class="form-label">{{ __('suppliersregister.label_city') }}</label>
                        <input type="text" class="form-control" id="city" name="address[city]" value="{{ old('address.city') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="state" class="form-label">{{ __('suppliersregister.label_state') }}</label>
                        <select id="state" name="address[state]" class="form-select">
                            <option value="" selected disabled>{{ __('suppliersregister.option_select') }}</option>
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
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-4">
                <legend>{{ __('suppliersregister.fieldset_contact') }}</legend>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="fixedphone" class="form-label">{{ __('suppliersregister.label_fixed_phone') }}</label>
                        <input type="tel" class="form-control" id="fixedphone" name="fixedphone" value="{{ old('fixedphone') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="phone" class="form-label">{{ __('suppliersregister.label_phone') }}</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">{{ __('suppliersregister.label_email') }}</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="contactNumber1" class="form-label">{{ __('suppliersregister.label_contact1_phone') }}</label>
                        <input type="text" class="form-control" id="contactNumber1" name="contactNumber1" value="{{ old('contactNumber1') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="contactName1" class="form-label">{{ __('suppliersregister.label_contact1_name') }}</label>
                        <input type="text" class="form-control" id="contactName1" name="contactName1" value="{{ old('contactName1') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="contactPosition1" class="form-label">{{ __('suppliersregister.label_contact1_position') }}</label>
                        <input type="text" class="form-control" id="contactPosition1" name="contactPosition1" value="{{ old('contactPosition1') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="contactNumber2" class="form-label">{{ __('suppliersregister.label_contact2_phone') }}</label>
                        <input type="text" class="form-control" id="contactNumber2" name="contactNumber2" value="{{ old('contactNumber2') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="contactName2" class="form-label">{{ __('suppliersregister.label_contact2_name') }}</label>
                        <input type="text" class="form-control" id="contactName2" name="contactName2" value="{{ old('contactName2') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="contactPosition2" class="form-label">{{ __('suppliersregister.label_contact2_position') }}</label>
                        <input type="text" class="form-control" id="contactPosition2" name="contactPosition2" value="{{ old('contactPosition2') }}">
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