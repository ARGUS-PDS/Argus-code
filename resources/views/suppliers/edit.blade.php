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
        margin-top: 2rem;
    }

    h2 {
        color: var(--color-vinho);
        font-weight: bold;
        margin-bottom: 0;
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
        width: 100%;
        display: block;
        float: none;
    }

    .form-label {
        color: var(--color-gray-escuro);
        font-weight: 500;
        margin-bottom: 0.5rem;
    }

    .form-control,
    .form-select {
        border-radius: 8px;
        border: 1px solid var(--color-gray-claro);
        padding: 0.75rem 1rem;
        color: var(--color-gray-escuro);
    }

    .form-control:focus,
    .form-select:focus {
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
        border-color: var(--bs-btn-hover-bg);
    }

    /* Estilo para o botão "Cancelar" (btn-secondary) - aplicando o mesmo estilo do btn-secondary do cadastro-funcionario */
    .btn-secondary {
        background-color: var(--color-gray-3);
        border-color: var(--color-gray-3);
        color: var(--color-white);
        padding: 0.75rem 1.5rem;
        border-radius: 8px;
        font-weight: bold;
        transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-secondary:hover {
        background-color: var(--color-gray-2);
        /* Cinza mais escuro para hover */
        border-color: var(--color-gray-2);
    }

    /* Removendo estilos antigos para os botões "Cancelar" e "Salvar" */
    .btn-cancel,
    .btn-send {
        /* Isso irá sobrescrever seus estilos antigos, se houver */
        /* Remova ou ajuste aqui se você tiver um estilo específico para estes botões que não é o do Bootstrap */
    }
</style>
@endsection

@section('content')
<div class="container py-4">
    <h2 class="m-0">{{ __('editsupplier.title') }}</h2>

    {{-- Alerts de feedback --}}
    @if ($errors->any())
    <div class="alert alert-danger mt-3">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
    @endif

    <div class="card-custom">
        <form action="{{ route('suppliers.update', $supplier->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <fieldset class="mb-4">
                <legend>{{ __('editsupplier.initial_data') }}</legend>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="name" class="form-label">{{ __('editsupplier.current_name') }}</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $supplier->name) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="code" class="form-label">{{ __('editsupplier.current_code') }}</label>
                        <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $supplier->code) }}" required>
                    </div>
                    <div class="col-md-4">
                        <label for="distributor" class="form-label">{{ __('editsupplier.current_distributor') }}</label>
                        <input type="text" name="distributor" id="distributor" class="form-control" value="{{ old('distributor', $supplier->distributor) }}" required>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-4">
                <legend>{{ __('editsupplier.address') }}</legend>
                <div class="row mb-3">
                    <div class="col-md-3">
                        <label for="zip_code" class="form-label">{{ __('editsupplier.current_zip') }}</label>
                        <input id="zip_code" type="text" name="address[cep]" class="form-control" value="{{ old('address.cep', optional($supplier->address ?? null)->cep) }}">
                    </div>
                    <div class="col-md-5">
                        <label for="place" class="form-label">{{ __('editsupplier.current_street') }}</label>
                        <input id="place" type="text" name="address[place]" class="form-control" value="{{ old('address.place', optional($supplier->address ?? null)->place) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="number" class="form-label">{{ __('editsupplier.current_number') }}</label>
                        <input id="number" type="text" name="address[number]" class="form-control" value="{{ old('address.number', optional($supplier->address ?? null)->number) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="neighborhood" class="form-label">{{ __('editsupplier.current_neighborhood') }}</label>
                        <input id="neighborhood" type="text" name="address[neighborhood]" class="form-control" value="{{ old('address.neighborhood', optional($supplier->address ?? null)->neighborhood) }}">
                    </div>
                    <div class="col-md-5">
                        <label for="city" class="form-label">{{ __('editsupplier.current_city') }}</label>
                        <input id="city" type="text" name="address[city]" class="form-control" value="{{ old('address.city', optional($supplier->address ?? null)->city) }}">
                    </div>
                    <div class="col-md-3">
                        <label for="state" class="form-label">{{ __('editsupplier.current_state') }}</label>
                        <input id="state" type="text" name="address[state]" class="form-control" value="{{ old('address.state', optional($supplier->address ?? null)->state) }}">
                    </div>
                </div>
            </fieldset>

            <fieldset class="mb-4">
                <legend>{{ __('editsupplier.contact') }}</legend>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="fixedphone" class="form-label">{{ __('editsupplier.current_fixedphone') }}</label>
                        <input id="fixedphone" type="text" name="fixedphone" class="form-control" value="{{ old('fixedphone', $supplier->fixedphone) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="phone" class="form-label">{{ __('editsupplier.current_mobile') }}</label>
                        <input id="phone" type="text" name="phone" class="form-control" value="{{ old('phone', $supplier->phone) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="email" class="form-label">{{ __('editsupplier.current_email') }}</label>
                        <input id="email" type="email" name="email" class="form-control" value="{{ old('email', $supplier->email) }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="contactNumber1" class="form-label">{{ __('editsupplier.contact1_phone') }}</label>
                        <input id="contactNumber1" type="text" name="contactNumber1" class="form-control" value="{{ old('contactNumber1', $supplier->contactNumber1) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="contactName1" class="form-label">{{ __('editsupplier.contact1_name') }}</label>
                        <input id="contactName1" type="text" name="contactName1" class="form-control" value="{{ old('contactName1', $supplier->contactName1) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="contactPosition1" class="form-label">{{ __('editsupplier.contact1_position') }}</label>
                        <input id="contactPosition1" type="text" name="contactPosition1" class="form-control" value="{{ old('contactPosition1', $supplier->contactPosition1) }}">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <label for="contactNumber2" class="form-label">{{ __('editsupplier.contact2_phone') }}</label>
                        <input id="contactNumber2" type="text" name="contactNumber2" class="form-control" value="{{ old('contactNumber2', $supplier->contactNumber2) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="contactName2" class="form-label">{{ __('editsupplier.contact2_name') }}</label>
                        <input id="contactName2" type="text" name="contactName2" class="form-control" value="{{ old('contactName2', $supplier->contactName2) }}">
                    </div>
                    <div class="col-md-4">
                        <label for="contactPosition2" class="form-label">{{ __('editsupplier.contact2_position') }}</label>
                        <input id="contactPosition2" type="text" name="contactPosition2" class="form-control" value="{{ old('contactPosition2', $supplier->contactPosition2) }}">
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


{{-- Scripts JS no final do corpo para melhor performance --}}



<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>


<script>
    $(document).ready(function() {
        // Máscaras para telefones (se aplicável, ajuste conforme o formato desejado)
        $('#fixedphone').mask('(00) 0000-0000');
        $('#phone').mask('(00) 00000-0000');
        $('#contactNumber1').mask('(00) 00000-0000');
        $('#contactNumber2').mask('(00) 00000-0000');
        $('#zip_code').mask('00000-000');

        // Autocompletar CEP
        document.getElementById('zip_code').addEventListener('blur', function() {
            const cep = this.value.replace(/\D/g, '');
            const url = `https://viacep.com.br/ws/${cep}/json/`;

            const placeInput = document.getElementById('place');
            const neighborhoodInput = document.getElementById('neighborhood');
            const cityInput = document.getElementById('city');
            const numberInput = document.getElementById('number');
            const stateInput = document.getElementById('state');

            // Limpa os campos antes de buscar
            placeInput.value = '';
            neighborhoodInput.value = '';
            cityInput.value = '';
            numberInput.value = ''; // O número geralmente não vem do CEP, mas do complemento, que pode ser usado aqui
            stateInput.value = '';

            if (cep.length === 8) {
                fetch(url)
                    .then(res => res.json())
                    .then(data => {
                        if (!("erro" in data)) {
                            placeInput.value = data.logradouro || '';
                            neighborhoodInput.value = data.bairro || '';
                            cityInput.value = data.localidade || '';
                            stateInput.value = data.uf || '';
                            // O campo 'numero' é geralmente preenchido manualmente ou por 'complemento' do viaCEP,
                            // mas o campo 'complemento' pode não ser o número da rua.
                            // numberInput.value = data.complemento || ''; // Descomente se o complemento for o número
                        } else {
                            alert('CEP não encontrado.');
                        }
                    })
                    .catch(error => {
                        console.error('Erro ao buscar CEP:', error);
                        alert('Erro ao buscar CEP. Tente novamente.');
                    });
            } else if (cep.length > 0) {
                alert('CEP inválido. Deve conter 8 dígitos.');
            }
        });
    });
</script>
@endsection