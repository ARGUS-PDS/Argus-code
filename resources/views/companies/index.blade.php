@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Lista de Empresas</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-custom-back">
        <i class="bi bi-arrow-left"></i> Voltar
    </a>

    <a href="{{ route('companies.create') }}" class="btn btn-primary mb-3">Cadastrar Nova Empresa</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>CNPJ</th>
                <th>Razão Social</th>
                <th>Nome Fantasia</th>
                <th>Inscrição Estadual</th>
                <th>Proprietário</th>
                <th>Endereço</th>
            </tr>
        </thead>
        <tbody>
            @foreach($companies as $company)
                <tr>
                    <td>{{ $company->cnpj }}</td>
                    <td>{{ $company->businessName }}</td>
                    <td>{{ $company->tradeName }}</td>
                    <td>{{ $company->stateRegistration }}</td>
                    <td>{{ $company->owner->name ?? '—' }}</td>
                    <td>
                        {{ $company->address->place ?? '' }}, 
                        {{ $company->address->number ?? '' }} - 
                        {{ $company->address->neighborhood ?? '' }}, 
                        {{ $company->address->city ?? '' }}/{{ $company->address->state ?? '' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection