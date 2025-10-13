@extends('layouts.app')

@section('title', isset($product) ? 'Editar Produto' : 'Cadastrar Produto')

@section('styles')
<style>
body {
  background-color: var(--color-bege-claro);
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  color: var(--color-gray-escuro);
}

.container-card {
  background-color: var(--color-bege-card-interno);
  border-radius: 18px;
  padding: 35px 40px;
  box-shadow: 0 10px 25px var(--color-shadow);
  margin: 40px auto;
  max-width: 960px;
  border: 1px solid var(--color-gray-claro);
}

.header-section {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 30px;
  padding-bottom: 15px;
  flex-wrap: wrap;
}

.header-section h2 {
  color: var(--color-vinho);
  font-weight: bold;
  font-size: 2.2rem;
  margin-bottom: 0;
  line-height: 1.2;
}

.section-title {
  color: var(--color-vinho);
  font-weight: bold;
  font-size: 1.6rem;
  margin-bottom: 25px;
  padding-bottom: 8px;
  border-bottom: 2px solid var(--color-vinho);
}

.form-group {
  margin-bottom: 25px;
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
  border: 1px solid var(--color-gray-claro);
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

.image-upload-container {
  border: 2px dashed #aaa;
  border-radius: 12px;
  padding: 20px;
  background-color: #ffffff;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 180px;
  text-align: center;
  transition: border-color 0.3s ease;
}

.image-upload-container:hover {
  border-color: #773138;
}

.image-upload-container .form-label {
  font-weight: bold;
  color: #773138;
}

.image-preview-area {
  margin-top: 15px;
  position: relative;
}

.image-preview {
  max-width: 120px;
  max-height: 120px;
  border-radius: 12px;
  object-fit: cover;
  border: 3px solid var(--color-vinho);
  padding: 3px;
  box-shadow: 0 2px 8px var(--color-shadow);
}

.image-placeholder-text {
  color: #202132;
  font-size: 0.9rem;
  margin-top: 10px;
}

.additional-info-card,
.stock-card {
  background-color: #ffffff;
  border: 1px solid #f8f9fa;
  border-radius: 12px;
  padding: 25px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  margin-top: 25px;
}

.additional-info-card .section-title,
.stock-card .section-title {
  font-size: 1.3rem;
  margin-bottom: 15px;
  border-bottom: 1px solid #f8f9fa;
  padding-bottom: 8px;
  color: #773138;
}

.additional-info-card .form-label,
.stock-card .form-label {
  font-size: 0.9rem;
  font-weight: 500;
  color: #202132;
}

.product-toggle-switch {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-top: 15px;
  cursor: pointer;
}

.product-toggle-switch input[type="checkbox"] {
  position: absolute;
  opacity: 0;
  width: 0;
  height: 0;
}

.product-toggle-switch .slider {
  width: 50px;
  height: 26px;
  background-color: var(--color-gray-medio);
  border-radius: 26px;
  position: relative;
  transition: background-color 0.3s;
}

.product-toggle-switch .slider:before {
  content: "";
  position: absolute;
  width: 22px;
  height: 22px;
  border-radius: 50%;
  background-color: var(--color-white);
  top: 2px;
  left: 2px;
  box-shadow: 0 1px 3px var(--color-white);
  transition: transform 0.3s;
}

.product-toggle-switch input:checked+.slider {
  background-color: var(--color-green);
}

.product-toggle-switch input:checked+.slider:before {
  transform: translateX(24px);
}

.product-toggle-switch .status-text {
  font-weight: bold;
  color: var(--color-vinho);
  transition: color 0.3s;
  font-size: 1rem;
}

.product-toggle-switch input:checked~.status-text {
  color: var(--color-green);
}

.alert {
  border-radius: 10px;
  font-size: 0.95rem;
  margin-bottom: 25px;
}

@media (max-width: 768px) {
  .container-card {
    margin: 20px;
    padding: 25px;
    box-shadow: 0 5px 15px var(--color-shadow);
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

  .product-toggle-switch .slider {
    width: 40px;
    height: 20px;
  }

  .product-toggle-switch .slider:before {
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
  position: absolute;
  top: -16px;
  left: 110px;
  z-index: 2;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  padding: 0;
  font-size: 1.3rem;
  line-height: 20px;
  background: var(--color-vinho);
  border: 2px solid var(--color-vinho);
  color: var(--color-bege-claro);
  transition: background-color 0.3s, color 0.3s, border-color 0.3s, transform 0.2s !important;
}

.remove-image-btn:hover {
  background: var(--color-bege-claro);
  border: 2px solid var(--color-vinho);
  color: var(--color-vinho);
  transform: translateY(-2px);
}

.obrigatorio {
  cursor: pointer;
  color: var(--color-red);
}

.api-loading {
  border-color: var(--color-yellow) !important;
  background-color: rgba(255, 193, 7, 0.1) !important;
}

.api-success {
  border-color: var(--color-green) !important;
  background-color: rgba(40, 167, 69, 0.1) !important;
}

.barcode-input-container {
  position: relative;
}

.barcode-spinner {
  position: absolute;
  right: 12px;
  top: 50%;
  transform: translateY(-50%);
}

.api-feedback {
  font-size: 0.875rem;
  margin-top: 5px;
}
</style>
@endsection

@section('content')
<div id="mandatoryAlert" style="
    position: fixed;
    bottom: 20px;
    right: 20px;
    background-color: var(--color-vinho);
    color: var(--color-bege-claro);
    padding: 12px 18px;
    border-radius: 10px;
    box-shadow: 0 4px 12px var(--color-shadow);
    display: none;
    z-index: 9999;
">
  Faltam campos obrigatórios
</div>

{{-- Modal de feedback da API --}}
<div id="apiAlert" class="alert alert-info d-none" style="position: fixed; top: 20px; right: 20px; z-index: 10000; min-width: 300px;">
  <div class="d-flex justify-content-between align-items-center">
    <span id="apiMessage"></span>
    <button type="button" class="btn-close" onclick="document.getElementById('apiAlert').classList.add('d-none')"></button>
  </div>
</div>

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

  <form class="row g-4" action="{{ isset($product) ? route('products.update', $product->id) : route('cadastrar-produto.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
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
        <input type="file" name="image_url" id="image_url" class="form-control" accept=".jpg,.jpeg,.png" onchange="previewImage(event)">
        <input type="hidden" name="image_api_url" id="image_api_url" value="">
        <div class="image-preview-area position-relative">
          <button type="button" id="removeBtn" class="btn-sm remove-image-btn" style="display:none;">&times;</button>
          @if(isset($product) && $product->image_url)
          <img id="preview" src="{{ $product->image_url }}" alt="{{ __('product_register.current_image') }}" class="image-preview">
          <div id="placeholder" class="image-placeholder-text">{{ __('product_register.current_image') }}</div>
          @else
          <img id="preview" src="#" alt="{{ __('product_register.preview') }}" class="image-preview d-none">
          <div id="placeholder" class="image-placeholder-text">{{ __('product_register.no_image_selected') }}</div>
          @endif
          <input type="hidden" name="remove_image" id="remove_image" value="0">
        </div>
        <div class="invalid-feedback">A URL deve terminar com .jpg, .jpeg ou .png</div>
        <div id="validMessage" class="valid-feedback">Imagem válida!</div>
      </div>
    </div>

    <div class="col-md-9">
      <div class="row g-4">
        <div class="col-md-6 form-group">
          <label for="barcode" class="form-label">{{ __('product_register.barcode') }}<span class="obrigatorio" title="Campo obrigatório"> *</span></label>
          <div class="barcode-input-container">
            <input name="barcode" type="text" id="barcode" class="form-control" placeholder="{{ __('product_register.barcode_placeholder') }}" value="{{ isset($product) ? $product->barcode : '' }}" required maxlength="13" pattern="\d{8,13}" autocomplete="off">
            <div id="barcodeSpinner" class="barcode-spinner spinner-border spinner-border-sm d-none" role="status">
              <span class="visually-hidden">Carregando...</span>
            </div>
          </div>
          <div class="invalid-feedback">O código de barras deve ter entre 8 e 13 números.</div>
          <div class="valid-feedback">Código de barras válido!</div>
          <div class="api-feedback text-muted">
            <small>Digite o código e aguarde a consulta automática</small>
          </div>
        </div>

        <div class="col-md-6 form-group">
          <label for="description" class="form-label">{{ __('product_register.name') }}<span class="obrigatorio" title="Campo obrigatório"> *</span></label>
          <input type="text" name="description" id="description" class="form-control" placeholder="{{ __('product_register.name_placeholder') }}" value="{{ isset($product) ? $product->description : '' }}" required maxlength="100" pattern="^(?!\d+$).{1,100}$" title="Não pode ser apenas números">
          <div class="invalid-feedback">O nome não pode conter apenas números.</div>
          <div class="valid-feedback">Nome válido!</div>
        </div>

        <div class="col-md-6 form-group">
          <label for="code" class="form-label">{{ __('product_register.description') }}<span class="obrigatorio" title="Campo obrigatório"> *</span></label>
          <input type="text" name="code" id="code" class="form-control" placeholder="{{ __('product_register.code_placeholder') }}" value="{{ isset($product) ? $product->code : '' }}" required maxlength="20">
          <div class="invalid-feedback">O código é obrigatório.</div>
          <div class="valid-feedback">Código válido!</div>
        </div>

        <div class="col-md-5 form-group">
          <label for="supplierId" class="form-label">{{ __('product_register.supplier') }}<span class="obrigatorio" title="Campo obrigatório"> *</span></label>
          <select name="supplierId" id="supplierId" class="form-select" required>
            <option value="">{{ __('product_register.select_supplier') }}</option>
            @foreach ($suppliers as $supplier)
            <option value="{{ $supplier->id }}" {{ isset($product) && $product->supplierId == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
            @endforeach
          </select>
        </div>

        <div class="col-md-5 form-group">
          <label for="value" class="form-label">{{ __('product_register.sale_value') }}<span class="obrigatorio" title="Campo obrigatório"> *</span></label>
          <input name="value" type="number" step="0.01" inputmode="decimal" class="form-control" placeholder="{{ __('product_register.value_placeholder') }}" value="{{ isset($product) ? $product->value : '' }}" min="0" max="999999.99" required>
          <div class="invalid-feedback">O preço deve ser maior que zero.</div>
          <div class="valid-feedback">Preço válido!</div>
        </div>
      </div>
    </div>

    <div class="col-md-6">
      <div class="additional-info-card">
        <h4 class="section-title" style="margin-top: 0;">{{ __('product_register.additional_info') }}</h4>
        <div class="row g-3">
          <div class="col-md-6 form-group">
            <label for="brand" class="form-label">{{ __('product_register.brand') }}</label>
            <input name="brand" type="text" id="brand" class="form-control" placeholder="{{ __('product_register.brand_placeholder') }}" value="{{ isset($product) ? $product->brand : '' }}" maxlength="50" pattern="^(?!\d+$).{0,50}$" title="Não pode ser apenas números">
            <div class="invalid-feedback">Marca não pode conter apenas números.</div>
            <div class="valid-feedback">Marca válida!</div>
          </div>
          <div class="col-md-6 form-group">
            <label for="model" class="form-label">{{ __('product_register.model') }}</label>
            <input name="model" type="text" id="model" class="form-control" placeholder="{{ __('product_register.model_placeholder') }}" value="{{ isset($product) ? $product->model : '' }}" maxlength="50" pattern="^(?!\d+$).{0,50}$" title="Não pode ser apenas números">
            <div class="invalid-feedback">Modelo não pode conter apenas números.</div>
            <div class="valid-feedback">Modelo válido!</div>
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
            <label for="currentStock" class="form-label">{{ __('product_register.current_stock') }}<span class="obrigatorio" title="Campo obrigatório"> *</span></label>
            <input name="currentStock" type="number" id="currentStock" class="form-control" placeholder="{{ __('product_register.current_stock_placeholder') }}" value="{{ isset($product) ? $product->currentStock : '' }}" min="0" max="999999" required>
            <div class="invalid-feedback">Estoque deve ser igual ou maior que zero.</div>
            <div class="valid-feedback">Estoque válido!</div>
          </div>
          <div class="col-md-6 form-group">
            <label for="minimumStock" class="form-label">{{ __('product_register.minimum_stock') }} <span class="obrigatorio" title="Campo obrigatório"> *</span>
              <x-explanation title="Quantidade mínima do produto a ser mantida em estoque"></x-explanation>
            </label>
            <input name="minimumStock" type="number" id="minimumStock" class="form-control" placeholder="{{ __('product_register.minimum_stock_placeholder') }}" value="{{ isset($product) ? $product->minimumStock : '' }}" min="0" max="999999" required>
            <div class="invalid-feedback">Estoque mínimo deve ser igual ou maior que zero.</div>
            <div class="valid-feedback">Estoque mínimo válido!</div>
          </div>
        </div>
      </div>
    </div>
    @endif

    <div class="col-12 d-flex justify-content-end align-items-center mt-4">
      <div class="form-actions">
        <x-btn-cancelar href="/lista-produtos" />
        <x-btn-salvar />
      </div>
    </div>
  </form>
</div>

<script>
// Variáveis globais
let consultaTimeout = null;
let ultimoCodigoConsultado = '';

// Função para mostrar mensagens da API
function showApiMessage(message, type = 'info') {
  const alert = document.getElementById('apiAlert');
  const messageEl = document.getElementById('apiMessage');

  if (alert && messageEl) {
    messageEl.textContent = message;
    alert.className = `alert alert-${type} d-none`;
    alert.classList.remove('d-none');

    // Auto-esconder após 5 segundos (exceto para erros)
    if (type !== 'danger') {
      setTimeout(() => {
        alert.classList.add('d-none');
      }, 5000);
    }
  }
}

// Função para atualizar visibilidade do botão de remover imagem
function updateRemoveButtonVisibility() {
  const removeBtn = document.getElementById('removeBtn');
  const previewImg = document.getElementById('preview');
  const placeholder = document.getElementById('placeholder');

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

// Função para consultar produto na API Cosmos
async function consultarProdutoCosmos(codigo) {
  if (!codigo || codigo === ultimoCodigoConsultado) return;

  const cleaned = String(codigo).replace(/\D/g, '');
  if (!cleaned || cleaned.length < 6) return;

  // Atualiza UI para estado de carregamento
  const barcodeInput = document.getElementById('barcode');
  const spinner = document.getElementById('barcodeSpinner');

  if (barcodeInput && spinner) {
    barcodeInput.classList.add('api-loading');
    spinner.classList.remove('d-none');
  }

  ultimoCodigoConsultado = cleaned;

  try {
    console.log('Consultando API para código:', cleaned);

    const res = await fetch(`https://api.cosmos.bluesoft.com.br/gtins/${cleaned}`, {
      method: 'GET',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
        'X-Cosmos-Token': 'CYPxDw3T-3fmTBDk7bInsg',
        'User-Agent': 'Cosmos-API-Request'
      },
    });

    console.log('Status da resposta:', res.status);

    if (!res.ok) {
      throw new Error(`Produto não encontrado (${res.status})`);
    }

    const data = await res.json();
    console.log('Dados recebidos:', data);

    // Preenche os campos com os dados da API
    const nameInput = document.getElementById('description');
    const brandInput = document.getElementById('brand');
    const modelInput = document.getElementById('model');
    const previewImg = document.getElementById('preview');

    if (data.description && nameInput) {
      nameInput.value = data.description;
      showApiMessage('Produto encontrado na base de dados!', 'success');
    }

    if (brandInput) {
      const brandCandidate =
        (data.brand && (data.brand.name || data.brand)) ||
        (Array.isArray(data.companies) && data.companies.length > 0 && data.companies[0].name) ||
        null;
      if (brandCandidate) brandInput.value = brandCandidate;
    }

    if (data.thumbnail && previewImg) {
      previewImg.src = data.thumbnail;
      previewImg.classList.remove('d-none');
      updateRemoveButtonVisibility();

      const imageApiInput = document.getElementById('image_api_url');
    if (imageApiInput) {
        imageApiInput.value = data.thumbnail;
    }

    // Limpa o input file para evitar conflito
    document.getElementById('image_url').value = '';
    }
    

    // Atualiza UI para estado de sucesso
    if (barcodeInput) {
      barcodeInput.classList.remove('api-loading');
      barcodeInput.classList.add('api-success');
      setTimeout(() => barcodeInput.classList.remove('api-success'), 2000);
    }

  } catch (error) {
    console.error('Erro na consulta à API:', error);
    showApiMessage('Produto não encontrado na base de dados!', 'warning');

    // Remove estados visuais de carregamento/erro
    const barcodeInput = document.getElementById('barcode');
    if (barcodeInput) {
      barcodeInput.classList.remove('api-loading');
    }
  } finally {
    // Esconde spinner
    const spinner = document.getElementById('barcodeSpinner');
    if (spinner) {
      spinner.classList.add('d-none');
    }
  }
}

// Função para preview de imagem
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

// Validação do formulário
function validateForm(event) {
  const currentStock = parseInt(document.getElementById('currentStock')?.value) || 0;
  const minimumStock = parseInt(document.getElementById('minimumStock')?.value) || 0;
  const onlyDigits = /^\d+$/;
  const maxLen = {
    description: 255,
    barcode: 50,
    code: 255,
    brand: 100,
    model: 100
  };
  const descriptionEl = document.getElementById('description');
  const brandEl = document.getElementById('brand');
  const modelEl = document.getElementById('model');
  const barcodeEl = document.getElementById('barcode');
  const codeEl = document.getElementById('code');

  if (minimumStock > currentStock) {
    event.preventDefault();
    alert('{{ __("product_register.minimum_stock_alert") }}');
    document.getElementById('minimumStock').focus();
    return false;
  }

  if (descriptionEl && onlyDigits.test(descriptionEl.value)) {
    event.preventDefault();
    alert('O nome não pode ser apenas números.');
    descriptionEl.focus();
    return false;
  }
  if (brandEl && brandEl.value && onlyDigits.test(brandEl.value)) {
    event.preventDefault();
    alert('A marca não pode ser apenas números.');
    brandEl.focus();
    return false;
  }
  if (modelEl && modelEl.value && onlyDigits.test(modelEl.value)) {
    event.preventDefault();
    alert('O modelo não pode ser apenas números.');
    modelEl.focus();
    return false;
  }

  if (descriptionEl && descriptionEl.value.length > maxLen.description) {
    event.preventDefault();
    alert(`O nome excede ${maxLen.description} caracteres.`);
    descriptionEl.focus();
    return false;
  }
  if (barcodeEl && barcodeEl.value.length > maxLen.barcode) {
    event.preventDefault();
    alert(`O código de barras excede ${maxLen.barcode} caracteres.`);
    barcodeEl.focus();
    return false;
  }
  if (codeEl && codeEl.value.length > maxLen.code) {
    event.preventDefault();
    alert(`O código excede ${maxLen.code} caracteres.`);
    codeEl.focus();
    return false;
  }
  if (brandEl && brandEl.value.length > maxLen.brand) {
    event.preventDefault();
    alert(`A marca excede ${maxLen.brand} caracteres.`);
    brandEl.focus();
    return false;
  }
  if (modelEl && modelEl.value.length > maxLen.model) {
    event.preventDefault();
    alert(`O modelo excede ${maxLen.model} caracteres.`);
    modelEl.focus();
    return false;
  }

  return true;
}

// Inicialização quando o DOM estiver carregado
document.addEventListener('DOMContentLoaded', function() {
  const barcodeInput = document.getElementById('barcode');
  const removeBtn = document.getElementById('removeBtn');
  const form = document.getElementById('productForm');

  // Configura o campo de código de barras para consulta automática
  if (barcodeInput) {
    barcodeInput.addEventListener('input', function(e) {
      const codigo = e.target.value.trim();

      // Limpa timeout anterior
      if (consultaTimeout) {
        clearTimeout(consultaTimeout);
      }

      // Configura novo timeout (consulta após 1.5 segundos sem digitar)
      if (codigo.length >= 6) {
        consultaTimeout = setTimeout(() => {
          consultarProdutoCosmos(codigo);
        }, 1500);
      }
    });

    // Previne o comportamento padrão do Enter
    barcodeInput.addEventListener('keydown', function(e) {
      if (e.key === 'Enter') {
        e.preventDefault();
        // Não faz nada - impede o submit do formulário
      }
    });
  }

  // Configura o botão de remover imagem
  if (removeBtn) {
    removeBtn.addEventListener('click', function() {
      const previewImg = document.getElementById('preview');
      if (previewImg) {
        previewImg.src = '#';
        previewImg.classList.add('d-none');
      }
      const placeholder = document.getElementById('placeholder');
      if (placeholder) placeholder.classList.remove('d-none');
      removeBtn.style.display = 'none';
      document.getElementById('image_url').value = '';
      document.getElementById('remove_image').value = '1';
    });
  }

  // Validação do formulário
  if (form) {
    form.addEventListener('submit', validateForm);
  }

  // Inicializa visibilidade do botão de remover
  updateRemoveButtonVisibility();
});
</script>
@endsection