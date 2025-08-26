@extends('layouts.app')

@include('layouts.css-variables')

@section('styles')
<style>
    body {
        padding: 0;
        background-color: var(--color-bege-claro);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: var(--color-gray-escuro);
    }

    .container-card {
        background-color: var(--color-bege-card-interno);
        border-radius: 18px;
        padding: 35px 40px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        margin: 0 auto;
        max-width: 960px;
        border: 1px solid var(--color-gray-claro);
    }

    .header-section {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        padding-bottom: 15px;
        border-bottom: 1px solid var(--color-gray-claro);
        flex-wrap: wrap;
    }

    .header-section h2 {
        color: var(--color-vinho);
        font-weight: bold;
        font-size: 2.2rem;
        margin-bottom: 0;
        line-height: 1.2;
    }

    .btn-voltar {
        background-color: var(--color-vinho);
        color: var(--color-bege-claro);
        border: none;
        border-radius: 10px;
        padding: 10px 18px;
        font-size: 0.95rem;
        display: flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
        transition: background-color 0.3s ease, transform 0.2s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .btn-voltar:hover {
        background-color: var(--bs-btn-hover-bg);
        transform: translateY(-2px);
        color: var(--color-bege-claro);
    }

    .section-card {
        background-color: #fff;
        border: 1px solid var(--color-gray-claro);
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        padding: 25px;
        margin-bottom: 25px;
    }

    .section-card .card-title {
        color: var(--color-vinho);
        font-weight: bold;
        font-size: 1.3rem;
        margin-bottom: 20px;
        padding-bottom: 8px;
        border-bottom: 1px solid var(--color-gray-claro);
    }

    .form-label {
        display: block;
        color: var(--color-vinho);
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    .form-control,
    .form-select {
        width: 100%;
        padding: 12px 18px;
        border: 1px solid var(--color-gray-medio);
        border-radius: 10px;
        font-size: 1rem;
        color: var(--color-gray-escuro);
        background-color: var(--color-white);
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus,
    .form-select:focus {
        border-color: var(--color-vinho);
        box-shadow: 0 0 0 0.25rem var(--color-vinho-fundo-transparente);
        outline: none;
    }

    .form-control:disabled,
    .form-control[readonly] {
        background-color: var(--color-bege-card-interno);
        opacity: 1;
        color: var(--color-gray-escuro);
        border-color: var(--color-gray-claro);
        cursor: not-allowed;
    }

    .input-group-text {
        background-color: var(--color-bege-card-interno);
        color: var(--color-vinho);
        border: 1px solid var(--color-gray-medio);
        border-left: none;
        border-radius: 0 10px 10px 0;
        padding: 0 15px;
        display: flex;
        align-items: center;
    }

    .input-group .form-control {
        border-right: none;
        border-radius: 10px 0 0 10px;
    }

    input[type="date"].form-control {
        appearance: none;
        -webkit-appearance: none;
    }

    @media (max-width: 768px) {
        .container-card {
            margin: 20px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .header-section {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
            margin-bottom: 20px;
        }

        .header-section h2 {
            font-size: 1.8rem;
        }

        .section-card {
            padding: 20px;
            margin-bottom: 20px;
        }

        .section-card .card-title {
            font-size: 1.2rem;
            margin-bottom: 15px;
        }

        .form-label {
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            padding: 10px 15px;
        }
    }
</style>
@endsection

@section('content')
<div class="container-card">
    <div class="header-section">
        <h2>{{ __('lots.detalhamento_lote') }}</h2>
        <x-btn-voltar/>
    </div>

    <div class="section-card">
        <h3 class="card-title">{{ __('lots.informacoes_lote') }}</h3>

        <div class="row g-4">
            <div class="col-md-6">
                <label for="lote" class="form-label">{{ __('lots.lote') }}</label>
                <div class="input-group">
                    <input type="text" name="lote" id="lote" class="form-control" placeholder="{{ __('lots.digite_numero_lote') }}">
                    <span class="input-group-text" style="cursor: pointer;">
                        <i class="bi bi-search"></i>
                    </span>
                </div>
            </div>

            <div class="col-md-6">
                <label for="produto" class="form-label">{{ __('lots.produto') }}</label>
                <input type="text" name="produto" id="produto" class="form-control" placeholder="{{ __('lots.nome_produto') }}" disabled>
            </div>

            <div class="col-md-6">
                <label for="data_validade" class="form-label">{{ __('lots.data_validade') }}</label>
                <input type="date" name="data_validade" id="data_validade" class="form-control" disabled>
            </div>

            <div class="col-md-6">
                <label for="data_entrada" class="form-label">{{ __('lots.data_entrada') }}</label>
                <input type="date" name="data_entrada" id="data_entrada" class="form-control" disabled>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchBtn = document.querySelector(".input-group-text");
        const loteInput = document.getElementById("lote");

        searchBtn.addEventListener("click", function() {
            let lote = loteInput.value.trim();

            if (!lote) {
                alert("Digite o código do lote!");
                return;
            }

            fetch("{{ route('batches.buscar') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({
                        batch_code: lote
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById("produto").value = data.data.produto;
                        document.getElementById("data_validade").value = data.data.data_validade.split(" ")[0];
                        document.getElementById("data_entrada").value = data.data.data_entrada.split(" ")[0];
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error("Erro:", error);
                    alert("Erro ao buscar o lote!");
                });
        });
    });
</script>
@endsection