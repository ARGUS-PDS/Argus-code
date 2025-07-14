<!DOCTYPE html>
<html lang="pt-BR">
@include('layouts.css-variables') {{-- Garante que suas variáveis CSS globais sejam carregadas --}}

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ isset($product) ? 'Editar Produto' : 'Cadastrar Produto' }}</title>
    <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
    <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            background-color: var(--color-bege-claro);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            /* Fonte mais moderna */
            color: var(--color-gray-escuro);
        }

        .container-card {
            background-color: var(--color-bege-card-interno);
            border-radius: 18px;
            /* Mais arredondado */
            padding: 35px 40px;
            /* Mais padding */
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            /* Sombra mais pronunciada e suave */
            margin: 40px auto;
            max-width: 960px;
            /* Um pouco mais largo */
            border: 1px solid var(--color-gray-claro);
            /* Borda sutil para definir o card */
        }

        .header-section {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            /* Mais espaçamento */
            padding-bottom: 15px;
            /* Espaço antes da linha divisória */
            border-bottom: 1px solid var(--color-gray-claro);
            /* Linha divisória suave */
            flex-wrap: wrap;
        }

        .header-section h2 {
            /* h2 para o título principal */
            color: var(--color-vinho);
            font-weight: bold;
            font-size: 2.2rem;
            /* Tamanho ajustado para h2 */
            margin-bottom: 0;
            line-height: 1.2;
        }

        .btn-voltar {
            background-color: var(--color-vinho);
            color: var(--color-bege-claro);
            border: none;
            border-radius: 10px;
            /* Mais arredondado */
            padding: 10px 18px;
            /* Mais padding */
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 7px;
            /* Mais espaço no ícone */
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-voltar:hover {
            background-color: var(--bs-btn-hover-bg);
            transform: translateY(-2px);
            /* Efeito de levitar */
        }

        .section-title {
            color: var(--color-vinho);
            font-weight: bold;
            font-size: 1.6rem;
            /* Títulos de seção um pouco maiores */
            margin-bottom: 25px;
            /* Mais espaçamento */
            padding-bottom: 8px;
            border-bottom: 2px solid var(--color-vinho);
        }

        .form-group {
            margin-bottom: 25px;
            /* Mais espaçamento entre os grupos */
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
            /* Mais padding */
            border: 1px solid var(--color-gray-claro);
            border-radius: 10px;
            /* Mais arredondado */
            font-size: 1rem;
            color: var(--color-gray-escuro);
            background-color: var(--color-white);
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--color-vinho);
            box-shadow: 0 0 0 0.25rem var(--color-vinho-fundo-transparente);
            /* Sombra mais espessa */
            outline: none;
        }

        /* Estilos específicos para o upload de imagem */
        .image-upload-container {
            border: 2px dashed var(--color-gray-medio);
            /* Borda tracejada mais visível */
            border-radius: 12px;
            padding: 20px;
            /* Mais padding */
            background-color: var(--color-white);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 180px;
            /* Altura mínima para o container de imagem */
            text-align: center;
            transition: border-color 0.3s ease;
        }

        .image-upload-container:hover {
            border-color: var(--color-vinho);
            /* Destaca no hover */
        }

        .image-upload-container .form-label {
            font-weight: bold;
            color: var(--color-vinho);
        }

        .image-preview-area {
            margin-top: 15px;
        }

        .image-preview {
            max-width: 120px;
            /* Imagem um pouco maior */
            max-height: 120px;
            border-radius: 12px;
            object-fit: cover;
            border: 3px solid var(--color-vinho);
            /* Borda mais espessa */
            padding: 3px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .image-placeholder-text {
            color: var(--color-gray-escuro);
            font-size: 0.9rem;
            margin-top: 10px;
        }

        .additional-info-card,
        .stock-card {
            background-color: var(--color-white);
            /* Fundo branco dentro dos cards */
            border: 1px solid var(--color-gray-claro);
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            /* Sombra mais leve */
            margin-top: 25px;
            /* Espaçamento entre os cards */
        }

        .additional-info-card .section-title,
        .stock-card .section-title {
            font-size: 1.3rem;
            /* Títulos menores dentro dos cards */
            margin-bottom: 15px;
            border-bottom: 1px solid var(--color-gray-claro);
            padding-bottom: 8px;
        }

        .additional-info-card .form-label,
        .stock-card .form-label {
            font-size: 0.9rem;
            font-weight: 500;
        }

        /* Estilo para o toggle de Situação */
        .toggle-switch {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-top: 15px;
            cursor: pointer;
        }

        .toggle-switch input[type="checkbox"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .toggle-switch .slider {
            width: 50px;
            /* Slider maior */
            height: 26px;
            /* Slider maior */
            background-color: var(--color-gray-medio);
            border-radius: 26px;
            position: relative;
            transition: background-color 0.3s;
        }

        .toggle-switch .slider:before {
            content: "";
            position: absolute;
            width: 22px;
            /* Thumb maior */
            height: 22px;
            /* Thumb maior */
            border-radius: 50%;
            background-color: var(--color-white);
            top: 2px;
            left: 2px;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s;
        }

        .toggle-switch input:checked+.slider {
            background-color: var(--color-green);
        }

        .toggle-switch input:checked+.slider:before {
            transform: translateX(24px);
            /* Posição do thumb maior */
        }

        .toggle-switch .status-text {
            font-weight: bold;
            color: var(--color-vinho);
            transition: color 0.3s;
            font-size: 1rem;
        }

        .toggle-switch input:checked~.status-text {
            color: var(--color-green);
        }

        /* Botões de ação */
        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 20px;
            /* Mais espaço entre os botões */
            margin-top: 40px;
            /* Mais espaçamento */
            padding-top: 25px;
            border-top: 1px solid var(--color-gray-claro);
        }

        .btn-cancel {
            background-color:var(--color-red);
            color: var(--color-white);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            /* Mais padding */
            font-size: 1.05rem;
            text-decoration: none;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-cancel:hover {
            background-color: #c82333;
            transform: translateY(-2px);
        }

        .btn-send {
            background-color: var(--color-vinho);
            color: var(--color-bege-claro);
            border: none;
            border-radius: 10px;
            padding: 12px 25px;
            font-size: 1.05rem;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .btn-send:hover {
            background-color: var(--bs-btn-hover-bg);
            transform: translateY(-2px);
        }

        /* Alertas de validação (Bootstrap) */
        .alert {
            border-radius: 10px;
            font-size: 0.95rem;
            margin-bottom: 25px;
        }

        /* Responsividade */
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

            .section-title {
                font-size: 1.4rem;
                margin-bottom: 20px;
            }

            .form-group {
                margin-bottom: 20px;
            }

            .image-upload-container {
                min-height: 150px;
                padding: 15px;
            }

            .image-preview {
                max-width: 100px;
                max-height: 100px;
            }

            .toggle-switch .slider {
                width: 40px;
                height: 20px;
            }

            .toggle-switch .slider:before {
                width: 16px;
                height: 16px;
                transform: translateX(20px);
            }

            .form-actions {
                flex-direction: column;
                align-items: stretch;
                gap: 15px;
                margin-top: 30px;
            }

            .btn-cancel,
            .btn-send {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="container-card">
        <div class="header-section">
            <h2 class="text-2xl">
                {{ isset($product) ? 'Editar Produto' : 'Cadastrar Produto' }}
            </h2>
            <a href="/lista-produtos" class="btn-voltar">
                <i class="bi bi-arrow-left"></i> Voltar
            </a>
        </div>

        @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
        @endif

        <form class="row g-4" action="{{ isset($product) ? route('products.update', $product->id) : route('cadastrar-produto.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @if(isset($product))
            @method('PUT')
            @endif

            <div class="col-12">
                <h3 class="section-title">Dados do Produto</h3>
            </div>

            <div class="col-md-3">
                <div class="image-upload-container">
                    <label for="image_url" class="form-label mb-2">Imagem do Produto</label>
                    <input type="file" name="image_url" id="image_url" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <div class="image-preview-area">
                        @if(isset($product) && $product->image_url)
                        <img id="preview" src="{{ asset($product->image_url) }}" alt="Imagem atual" class="image-preview">
                        <div id="placeholder" class="image-placeholder-text">Imagem atual</div>
                        @else
                        <img id="preview" src="#" alt="Pré-visualização" class="image-preview d-none">
                        <div id="placeholder" class="image-placeholder-text">Nenhuma imagem selecionada</div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row g-4">
                    <div class="col-md-6 form-group">
                        <label for="description" class="form-label">Nome</label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="Esmalte vermelho da marca Anita 8ml" value="{{ isset($product) ? $product->description : '' }}" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="barcode" class="form-label">Código de barra</label>
                        <input name="barcode" type="text" id="barcode" class="form-control" placeholder="Ex: 00608473184014" value="{{ isset($product) ? $product->barcode : '' }}" required>
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="code" class="form-label">Descrição</label>
                        <input type="text" name="code" id="code" class="form-control" placeholder="Ex: esmalte_vermelho_anita" value="{{ isset($product) ? $product->code : '' }}">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="expiration_date" class="form-label">Data de validade</label>
                        <input name="expiration_date" type="date" id="expiration_date" class="form-control" value="{{ isset($product) ? $product->expiration_date : '' }}">
                    </div>
                </div>
            </div>

            <div class="col-md-4 form-group">
                <label for="value" class="form-label">Valor (R$)</label>
                <input name="value" type="number" step="0.01" inputmode="decimal" class="form-control" placeholder="R$" value="{{ isset($product) ? $product->value : '' }}">
            </div>

            <div class="col-md-4 form-group">
                <label for="profit" class="form-label">Lucro (R$)</label>
                <input name="profit" type="number" step="0.01" inputmode="decimal" class="form-control" placeholder="R$" value="{{ isset($product) ? $product->profit : '' }}">
            </div>

            <div class="col-md-4 form-group">
                <label for="supplierId" class="form-label">Fornecedor</label>
                <select name="supplierId" id="supplierId" class="form-select">
                    <option value="">Selecione um fornecedor</option>
                    @foreach ($suppliers as $supplier)
                    <option value="{{ $supplier->id }}" {{ isset($product) && $product->supplierId == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6">
                <div class="additional-info-card">
                    <h4 class="section-title" style="margin-top: 0;">Informações Adicionais</h4>
                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label for="brand" class="form-label">Marca</label>
                            <input name="brand" type="text" id="brand" class="form-control" placeholder="Ex: Anita" value="{{ isset($product) ? $product->brand : '' }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="model" class="form-label">Modelo</label>
                            <input name="model" type="text" id="model" class="form-control" placeholder="Ex: Carnaval" value="{{ isset($product) ? $product->model : '' }}">
                        </div>
                    </div>
                </div>
            </div>

            @if (!isset($product))
            <div class="col-md-6">
                <div class="stock-card">
                    <h4 class="section-title" style="margin-top: 0;">Estoque</h4>
                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label for="currentStock" class="form-label">Estoque Atual</label>
                            <input name="currentStock" type="number" id="currentStock" class="form-control" placeholder="Ex: 40" value="{{ isset($product) ? $product->currentStock : '' }}">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="minimumStock" class="form-label">Estoque Mínimo</label>
                            <input name="minimumStock" type="number" id="minimumStock" class="form-control" placeholder="Ex: 150" value="{{ isset($product) ? $product->minimumStock : '' }}">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-12 d-flex justify-content-between align-items-center mt-4">
                <div class="form-group mb-0"> {{-- Removido margin-bottom do form-group para alinhamento --}}
                    <label class="form-label">Situação</label>
                    <label class="toggle-switch">
                        <input type="checkbox" name="status" value="1" {{ isset($product) ? ($product->status ? 'checked' : '') : 'checked' }} onchange="updateStatusText(this)">
                        <span class="slider"></span>
                        <span class="status-text" id="statusText">{{ isset($product) ? ($product->status ? 'Ativo' : 'Inativo') : 'Ativo' }}</span>
                    </label>
                </div>
                <div class="form-actions">
                    <a href="/lista-produtos" class="btn btn-cancel">Cancelar</a>
                    <button type="submit" class="btn btn-send">{{ isset($product) ? 'Atualizar' : 'Salvar' }}</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder');
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                };
                reader.readAsDataURL(event.target.files[0]);
            } else {
                preview.src = '#';
                preview.classList.add('d-none');
                placeholder.classList.remove('d-none');
            }
        }

        function updateStatusText(checkbox) {
            const statusText = document.getElementById('statusText');
            if (checkbox.checked) {
                statusText.textContent = 'Ativo';
            } else {
                statusText.textContent = 'Inativo';
            }
        }

        // Garante que o texto de status inicial esteja correto ao carregar a página
        document.addEventListener('DOMContentLoaded', function() {
            const statusCheckbox = document.querySelector('.toggle-switch input[name="status"]');
            if (statusCheckbox) {
                updateStatusText(statusCheckbox);
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>