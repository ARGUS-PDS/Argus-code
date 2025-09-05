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
        cursor: pointer;
    }

    .input-group .form-control {
        border-right: none;
        border-radius: 10px 0 0 10px;
    }

    .lot-list {
        margin-top: 25px;
    }

    .lot-item {
        background: var(--color-bege-card-interno);
        border: 1px solid var(--color-gray-claro);
        border-radius: 12px;
        padding: 15px 20px;
        margin-bottom: 12px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .lot-info {
        display: flex;
        flex-direction: column;
        font-size: 0.95rem;
    }

    .lot-info span {
        margin: 2px 0;
    }

    .btn-delete {
        background: none;
        border: none;
        color: var(--color-vinho);
        font-size: 1.4rem;
        cursor: pointer;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .btn-delete:hover {
        transform: scale(1.1);
        color: #b30000;
    }
</style>
@endsection

@section('content')
<div class="container-card">
    <div class="header-section">
        <h2>{{ __('lots.detalhamento_lote') }}</h2>
    </div>

    <div class="section-card">
        <h3 class="card-title">{{ __('lots.informacoes_lote') }}</h3>

        <div class="row g-4">
            <div class="col-md-6">
                <label for="lote" class="form-label">{{ __('lots.lote') }}</label>
                <div class="input-group">
                    <input type="text" name="lote" id="lote" class="form-control" placeholder="{{ __('lots.digite_numero_lote') }}">
                    <span class="input-group-text">
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

        <!-- Lista de lotes -->
        <div id="lotList" class="lot-list"></div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchBtn = document.querySelector(".input-group-text");
        const loteInput = document.getElementById("lote");
        const lotList = document.getElementById("lotList");

        searchBtn.addEventListener("click", function() {
            let lote = loteInput.value.trim();

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
                        if (data.all) {
                            lotList.innerHTML = "";

                            data.data.forEach(item => {
                                let lotItem = document.createElement("div");
                                lotItem.classList.add("lot-item");

                                lotItem.innerHTML = `
                                    <div class="lot-info">
                                        <span><strong>Lote:</strong> ${item.lote}</span>
                                        <span><strong>Produto:</strong> ${item.produto}</span>
                                        <span><strong>Validade:</strong> ${item.data_validade}</span>
                                        <span><strong>Entrada:</strong> ${item.data_entrada}</span>
                                    </div>
                                    <form action="/batches/${item.id}" method="POST" onsubmit="return confirm('Tem certeza que deseja excluir?');">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <button class="btn-delete" type="submit">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                `;

                                lotList.appendChild(lotItem);
                            });
                        } else {
                            document.getElementById("produto").value = data.data.produto;
                            document.getElementById("data_validade").value = data.data.data_validade.split(" ")[0];
                            document.getElementById("data_entrada").value = data.data.data_entrada.split(" ")[0];
                        }
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error("Erro:", error);
                    alert("Nenhum lote existente!");
                });
        });
    });
</script>
@endsection