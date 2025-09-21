<!DOCTYPE html>
<html lang="pt-BR">
@include('layouts.css-variables')

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
            f
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

        .remove-image-btn {
            z-index: 2;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            padding: 0;
            font-size: 1.3rem;
            line-height: 20px;
            top: -16px;
            left: 110px;
            background: var(--color-vinho);
            border: 2px solid var(--color-vinho);
            color: var(--color-bege-claro);
            position: absolute;
            transition: background-color 0.3s, color 0.3s, border-color 0.3s, transform 0.2s !important;
        }

        .remove-image-btn:hover{
            background: var(--color-bege-claro);
            border: 2px solid var(--color-vinho);
            color: var(--color-vinho);
            transform: translateY(-2px);
        }

    </style>
</head>

<body>
    {{-- Modal de mensagens globais --}}
    @include('components.alert-modal')
    
    <div class="container-card">
        <div class="header-section">
            <h2 class="text-2xl">
                {{ isset($product) ? __('product_register.edit_product') : __('product_register.register_product') }}
            </h2>
            <x-btn-voltar url="{{ route('products.index') }}" />
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
                <h3 class="section-title">{{ __('product_register.product_data') }}</h3>
            </div>

            <div class="col-md-3">
                <div class="image-upload-container">
                    <label for="image_url" class="form-label mb-2">{{ __('product_register.product_image') }}</label>
                    <input type="file" name="image_url" id="image_url" class="form-control" accept="image/*" onchange="previewImage(event)">
                    <div class="image-preview-area position-relative">
                        @if(isset($product) && $product->image_url)
                        <button type="button" id="removeBtn" class="btn-sm remove-image-btn">&times;</button>
                        <img id="preview" src="{{ $product->image_url }}" alt="{{ __('product_register.current_image') }}" class="image-preview">
                        <div id="placeholder" class="image-placeholder-text">{{ __('product_register.current_image') }}</div>
                        @else
                        <img id="preview" src="#" alt="{{ __('product_register.preview') }}" class="image-preview d-none">
                        <div id="placeholder" class="image-placeholder-text">{{ __('product_register.no_image_selected') }}</div>
                        @endif
                        <input type="hidden" name="remove_image" id="remove_image" value="0">
                    </div>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row g-4">
                    <div class="col-md-6 form-group">
                        <label for="description" class="form-label">{{ __('product_register.name') }}</label>
                        <input type="text" name="description" id="description" class="form-control" placeholder="{{ __('product_register.name_placeholder') }}" value="{{ isset($product) ? $product->description : '' }}" required maxlength="255" pattern=".*\D.*" title="Não pode ser apenas números">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="barcode" class="form-label">{{ __('product_register.barcode') }}</label>
                        <input name="barcode" type="text" id="barcode" class="form-control" placeholder="{{ __('product_register.barcode_placeholder') }}" value="{{ isset($product) ? $product->barcode : '' }}" required maxlength="50">
                    </div>

                    <div class="col-md-6 form-group">
                        <label for="code" class="form-label">{{ __('product_register.description') }}</label>
                        <input type="text" name="code" id="code" class="form-control" placeholder="{{ __('product_register.code_placeholder') }}" value="{{ isset($product) ? $product->code : '' }}" maxlength="255">
                    </div>

                    <div class="col-md-5 form-group">
                        <label for="supplierId" class="form-label">{{ __('product_register.supplier') }}</label>
                        <select name="supplierId" id="supplierId" class="form-select">
                            <option value="">{{ __('product_register.select_supplier') }}</option>
                            @foreach ($suppliers as $supplier)
                            <option value="{{ $supplier->id }}" {{ isset($product) && $product->supplierId == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-4 form-group">
                        <label for="value" class="form-label">{{ __('product_register.sale_value') }}</label>
                        <input name="value" type="number" step="0.01" inputmode="decimal" class="form-control" placeholder="{{ __('product_register.value_placeholder') }}" value="{{ isset($product) ? $product->value : '' }}" min="0" max="999999.99">
                    </div>

                </div>
            </div>

            <div class="col-md-6">
                <div class="additional-info-card">
                    <h4 class="section-title" style="margin-top: 0;">{{ __('product_register.additional_info') }}</h4>
                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label for="brand" class="form-label">{{ __('product_register.brand') }}</label>
                            <input name="brand" type="text" id="brand" class="form-control" placeholder="{{ __('product_register.brand_placeholder') }}" value="{{ isset($product) ? $product->brand : '' }}" maxlength="100" pattern=".*\D.*" title="Não pode ser apenas números">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="model" class="form-label">{{ __('product_register.model') }}</label>
                            <input name="model" type="text" id="model" class="form-control" placeholder="{{ __('product_register.model_placeholder') }}" value="{{ isset($product) ? $product->model : '' }}" maxlength="100" pattern=".*\D.*" title="Não pode ser apenas números">
                        </div>
                    </div>
                </div>
            </div>

            @if (!isset($product))
            <div class="col-md-6">
                <div class="stock-card">
                    <h4 class="section-title" style="margin-top: 0;">{{ __('product_register.stock') }}</h4>
                    <div class="row g-3">
                        <div class="col-md-6 form-group">
                            <label for="currentStock" class="form-label">{{ __('product_register.current_stock') }}</label>
                            <input name="currentStock" type="number" id="currentStock" class="form-control" placeholder="{{ __('product_register.current_stock_placeholder') }}" value="{{ isset($product) ? $product->currentStock : '' }}" min="0" max="999999">
                        </div>
                        <div class="col-md-6 form-group">
                            <label for="minimumStock" class="form-label">{{ __('product_register.minimum_stock') }} <x-explanation title="Quantidade mínima do produto a ser mantida em estoque"></x-explanation></label>
                            <input name="minimumStock" type="number" id="minimumStock" class="form-control" placeholder="{{ __('product_register.minimum_stock_placeholder') }}" value="{{ isset($product) ? $product->minimumStock : '' }}" min="0" max="999999">
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <div class="col-12 d-flex justify-content-between align-items-center mt-4">
                <div class="form-group mb-0">
                    <label class="form-label">{{ __('product_register.status') }}</label>
                    <label class="toggle-switch">
                        <input type="checkbox" name="status" value="1" {{ isset($product) ? ($product->status ? 'checked' : '') : 'checked' }} onchange="updateStatusText(this)">
                        <span class="slider"></span>
                        <span class="status-text" id="statusText">{{ isset($product) ? ($product->status ? __('product_register.active') : __('product_register.inactive')) : __('product_register.active') }}</span>
                    </label>
                </div>
                <div class="form-actions">
                    <x-btn-cancelar href="/lista-produtos" />
                    <x-btn-salvar />
                </div>
            </div>
        </form>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(event) {
            const currentStock = parseInt(document.getElementById('currentStock').value) || 0;
            const minimumStock = parseInt(document.getElementById('minimumStock').value) || 0;
            const onlyDigits = /^\d+$/;
            const maxLen = { description: 255, barcode: 50, code: 255, brand: 100, model: 100 };
            const descriptionEl = document.getElementById('description');
            const brandEl = document.getElementById('brand');
            const modelEl = document.getElementById('model');
            const barcodeEl = document.getElementById('barcode');
            const codeEl = document.getElementById('code');

            if (minimumStock > currentStock) {
                event.preventDefault();
                alert('{{ __('product_register.minimum_stock_alert') }}');
                document.getElementById('minimumStock').focus();
                return;
            }

            if (descriptionEl && onlyDigits.test(descriptionEl.value)) {
                event.preventDefault();
                alert('O nome não pode ser apenas números.');
                descriptionEl.focus();
                return;
            }
            if (brandEl && brandEl.value && onlyDigits.test(brandEl.value)) {
                event.preventDefault();
                alert('A marca não pode ser apenas números.');
                brandEl.focus();
                return;
            }
            if (modelEl && modelEl.value && onlyDigits.test(modelEl.value)) {
                event.preventDefault();
                alert('O modelo não pode ser apenas números.');
                modelEl.focus();
                return;
            }

            if (descriptionEl && descriptionEl.value.length > maxLen.description) {
                event.preventDefault();
                alert(`O nome excede ${maxLen.description} caracteres.`);
                descriptionEl.focus();
                return;
            }
            if (barcodeEl && barcodeEl.value.length > maxLen.barcode) {
                event.preventDefault();
                alert(`O código de barras excede ${maxLen.barcode} caracteres.`);
                barcodeEl.focus();
                return;
            }
            if (codeEl && codeEl.value.length > maxLen.code) {
                event.preventDefault();
                alert(`O código excede ${maxLen.code} caracteres.`);
                codeEl.focus();
                return;
            }
            if (brandEl && brandEl.value.length > maxLen.brand) {
                event.preventDefault();
                alert(`A marca excede ${maxLen.brand} caracteres.`);
                brandEl.focus();
                return;
            }
            if (modelEl && modelEl.value.length > maxLen.model) {
                event.preventDefault();
                alert(`O modelo excede ${maxLen.model} caracteres.`);
                modelEl.focus();
                return;
            }
        });

        function previewImage(event) {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder');
            const removeBtn = document.getElementById('removeBtn');
            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    placeholder.classList.add('d-none');
                    removeBtn.style.display = 'block';
                    document.getElementById('remove_image').value = '0';
                };
                reader.readAsDataURL(event.target.files[0]);
            } else {
                preview.src = '#';
                preview.classList.add('d-none');
                placeholder.classList.remove('d-none');
                removeBtn.style.display = 'none';
                document.getElementById('remove_image').value = '0';
            }
        }

        function updateStatusText(checkbox) {
            const statusText = document.getElementById('statusText');
            if (checkbox.checked) {
                statusText.textContent = '{{ __('product_register.active') }}';
            } else {
                statusText.textContent = '{{ __('product_register.inactive') }}';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            const statusCheckbox = document.querySelector('.toggle-switch input[name="status"]');
            if (statusCheckbox) {
                updateStatusText(statusCheckbox);
            }
        });
    </script>

    </script>
    <script>
        // ---- Helpers isolados ----
        function updateStatusText(checkbox) {
            const statusText = document.getElementById('statusText');
            if (!statusText) return;
            statusText.textContent = checkbox.checked ? '{{ __('product_register.active') }}' : '{{ __('product_register.inactive') }}';
        }

        function previewImage(event) {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder');
            const removeBtn = document.getElementById('removeBtn');
            if (!preview || !placeholder || !removeBtn) return;

            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                    document.getElementById('remove_image').value = '0';
                    // Chama a função centralizada para atualizar visibilidade
                    setTimeout(() => {
                        const hasImage = preview.getAttribute('src') && 
                                        preview.getAttribute('src') !== '#' && 
                                        !preview.classList.contains('d-none');
                        removeBtn.style.display = hasImage ? 'block' : 'none';
                        if (hasImage) {
                            placeholder.classList.add('d-none');
                        } else {
                            placeholder.classList.remove('d-none');
                        }
                    }, 10);
                };
                reader.readAsDataURL(event.target.files[0]);
            } else {
                preview.src = '#';
                preview.classList.add('d-none');
                placeholder.classList.remove('d-none');
                removeBtn.style.display = 'none';
                document.getElementById('remove_image').value = '0';
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // ---- Validação estoque ----
            const form = document.querySelector('form');
            const currentStockEl = document.getElementById('currentStock');
            const minimumStockEl = document.getElementById('minimumStock');

            if (form && currentStockEl && minimumStockEl) {
                form.addEventListener('submit', function(event) {
                    const currentStock = parseInt(currentStockEl.value) || 0;
                    const minimumStock = parseInt(minimumStockEl.value) || 0;
                    if (minimumStock > currentStock) {
                        event.preventDefault();
                        alert('{{ __('product_register.minimum_stock_alert') }}');
                        minimumStockEl.focus();
                    }
                });
            }

            // ---- Status toggle ----
            const statusCheckbox = document.querySelector('.toggle-switch input[name="status"]');
            if (statusCheckbox) updateStatusText(statusCheckbox);

            // ---- Campos / imagem ----
            const barcodeInput = document.getElementById('barcode');
            const nameInput = document.getElementById('description');
            const codeInput = document.getElementById('code');
            const brandInput = document.getElementById('brand');
            const modelInput = document.getElementById('model');
            const imageInput = document.getElementById('image_url');
            const previewImg = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder');
            const removeBtn = document.getElementById('removeBtn');

            // Função para gerenciar visibilidade do botão X
            function updateRemoveButtonVisibility() {
                if (!removeBtn || !previewImg) return;
                
                const hasImage = previewImg.getAttribute('src') && 
                                previewImg.getAttribute('src') !== '#' && 
                                !previewImg.classList.contains('d-none');
                
                removeBtn.style.display = hasImage ? 'block' : 'none';
                
                if (hasImage && placeholder) {
                    placeholder.classList.add('d-none');
                } else if (placeholder) {
                    placeholder.classList.remove('d-none');
                }
            }

            // Atualiza visibilidade no carregamento
            updateRemoveButtonVisibility();


            // Consulta Cosmos ao pressionar Enter no barcode
            async function consultarProdutoCosmos(codigo) {
                if (!codigo) return;
                // Mantém apenas dígitos (remover espaços/letras acidentais)
                const cleaned = String(codigo).replace(/\D/g, '');
                if (!cleaned || cleaned.length < 6) return;
                if (barcodeInput && barcodeInput.value !== cleaned) {
                    barcodeInput.value = cleaned;
                }
                try {
                    const res = await fetch(`https://api.cosmos.bluesoft.com.br/gtins/${cleaned}`, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            Accept: 'application/json',
                            'X-Cosmos-Token': 'CYPxDw3T-3fmTBDk7bInsg',
                            'User-Agent': 'Cosmos-API-Request',
                        },
                    });
                    if (!res.ok) return;
                    const data = await res.json();
                    if (!data) return;

                    if (data.description && nameInput) {
                        nameInput.value = data.description;
                    }
                    if (brandInput) {
                        const brandCandidate =
                            (data.brand && (data.brand.name || data.brand)) ||
                            (Array.isArray(data.companies) && data.companies.length > 0 && (data.companies[0].name || data.companies[0].fantasy_name)) ||
                            (data.manufacturer && data.manufacturer.name) ||
                            (data.owner && data.owner.name) ||
                            null;
                        if (brandCandidate) brandInput.value = brandCandidate;
                    }
                    if (data.gpc && modelInput && data.gpc.description) modelInput.value = data.gpc.description;

                    if (data.thumbnail && previewImg) {
                        previewImg.src = data.thumbnail;
                        previewImg.classList.remove('d-none');
                        updateRemoveButtonVisibility();
                    }
                } catch (e) {
                }
            }

            if (barcodeInput) {
                // Dispara consulta ao pressionar Enter (muitos leitores disparam Enter ao final)
                barcodeInput.addEventListener('keydown', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        consultarProdutoCosmos(barcodeInput.value.trim());
                    }
                });

                // Dispara ao sair do campo (para leitores que não enviam Enter)
                barcodeInput.addEventListener('blur', function() {
                    const codigo = (barcodeInput.value || '').replace(/\D/g, '');
                    if (codigo && codigo.length >= 6) {
                        consultarProdutoCosmos(codigo);
                    }
                });

                // Dispara após colar um valor
                barcodeInput.addEventListener('paste', function() {
                    setTimeout(() => {
                        const codigo = (barcodeInput.value || '').replace(/\D/g, '');
                        if (codigo && codigo.length >= 6) {
                            consultarProdutoCosmos(codigo);
                        }
                    }, 50);
                });

                // Dispara durante a digitação com debounce (para quem digita manualmente)
                let debounceTimer;
                barcodeInput.addEventListener('input', function() {
                    clearTimeout(debounceTimer);
                    const codigo = (barcodeInput.value || '').replace(/\D/g, '');
                    if (!codigo || codigo.length < 6) return;
                    debounceTimer = setTimeout(() => {
                        consultarProdutoCosmos(codigo);
                    }, 500);
                });
            }

            // Clique no "X" para remover imagem
            if (removeBtn) {
                removeBtn.addEventListener('click', function() {
                    if (previewImg) {
                        previewImg.src = '#';
                        previewImg.classList.add('d-none');
                    }
                    if (placeholder) {
                        placeholder.textContent = 'Nenhuma imagem selecionada';
                    }
                    if (imageInput) imageInput.value = '';
                    document.getElementById('remove_image').value = '1';
                    updateRemoveButtonVisibility();
                });
            }
        });
    </script>

    <script>
        function removeImage() {
            const preview = document.getElementById('preview');
            const placeholder = document.getElementById('placeholder');
            const removeBtn = document.getElementById('removeBtn');
            preview.src = '#';
            preview.classList.add('d-none');
            placeholder.textContent = 'Nenhuma imagem selecionada';
            placeholder.classList.remove('d-none');
            removeBtn.style.display = 'none';
            document.getElementById('image_url').value = '';
            document.getElementById('remove_image').value = '1';
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>