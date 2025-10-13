@extends('layouts.app')
@include('layouts.css-variables')

@section('styles')
<link href="https://fonts.googleapis.com/css2?family=Libre+Barcode+39&display=swap" rel="stylesheet" />

<style>
.container-card {
  background-color: var(--color-bege-card-interno);
  border-radius: 18px;
  padding: 35px 40px;
  box-shadow: 0 10px 25px var(--color-shadow);
  border: 1px solid var(--color-gray-claro);
  margin-top: 40px;
  margin-bottom: 80px;
  margin-left: auto;
  margin-right: auto;
  max-width: 960px;
  width: 95%;
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

.form-add-card {
  background-color: var(--color-vinho);
  border: 1px solid var(--color-vinho-fundo);
  border-radius: 12px;
  box-shadow: 0 4px 12px var(--color-shadow);
  padding: 25px;
  margin-bottom: 25px;
}

.form-add-card .form-control {
  border-radius: 10px;
  border: 1px solid var(--color-bege-medio);
  padding: 10px 15px;
  flex-grow: 1;
}

.form-add-card .form-control:focus {
  border-color: var(--color-bege-claro);
  box-shadow: 0 0 0 0.25rem var(--color-bege-claro-fundo);
}

.form-add-card .btn-primary {
  background-color: var(--color-vinho);
  color: var(--color-bege-claro);
  border-radius: 10px;
  padding: 10px 20px;
  border: 2px solid var(--color-bege-claro);
  transition: background-color 0.3s ease, transform 0.2s ease;
}

.form-add-card .btn-primary:hover {
  background-color: var(--color-bege-claro);
  transform: translateY(-2px);
  border: 2px solid var(--color-bege-claro);
  color: var(--color-vinho);
}

.form-add-card .col-form-label {
  color: var(--color-bege-claro);
  font-weight: 600;
  white-space: nowrap;
  margin-right: 10px;
}

.alert {
  border-radius: 10px;
  padding: 15px 20px;
  font-size: 1rem;
  margin-bottom: 20px;
}

.alert-danger {
  background-color: var(--color-bege-card-interno);
  color: var(--color-vinho-claro);
  border-color: var(--color-bege-claro);
}

.action-buttons {
  margin-top: 30px;
  margin-bottom: 20px;
  display: flex;
  justify-content: flex-start;
  gap: 15px;
}

.action-buttons .btn-outline-danger {
  background-color: transparent;
  border: 2px solid var(--color-vinho);
  color: var(--color-vinho);
  transition: all 0.3s ease;
  border-radius: 10px;
}

.action-buttons .btn-outline-danger:hover {
  background-color: var(--color-vinho);
  border: 2px solid var(--color-vinho);
  transform: translateY(-2px);
  color: var(--color-bege-claro);
}

.action-buttons .btn-success {
  background-color: var(--color-vinho);
  border: 2px solid var(--color-vinho);
  color: var(--color-bege-card-interno);
  border-radius: 10px;
  transition: all 0.3s ease;
}

.action-buttons .btn-success:hover {
  background-color: var(--color-bege-claro);
  color: var(--color-vinho);
  border: 2px solid var(--color-vinho);
  transform: translateY(-2px);
}

.etiquetas-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 20px;
  padding: 20px 0;
  justify-content: center;
}

.etiqueta {
  background-color: var(--color-vinho);
  border: 1px solid var(--color-vinho-fundo);
  border-radius: 8px;
  padding: 15px;
  text-align: center;
  box-shadow: 0 2px 8px var(--color-shadow);
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  align-items: center;
  min-height: 150px;
  transition: transform 0.2s ease, box-shadow 0.2s ease;
  position: relative;
}

.etiqueta:hover {
  transform: translateY(-3px);
  box-shadow: 0 4px 12px var(--color-shadow);
}

.etiqueta h3 {
  font-size: 1.1rem;
  font-weight: bold;
  color: var(--color-bege-claro);
  margin-bottom: 10px;
  white-space: normal;
  overflow: visible;
  text-overflow: initial;
  display: block;
  -webkit-line-clamp: initial;
  -webkit-box-orient: vertical;
  line-clamp: initial;
  max-height: none;
  line-height: 1.4em;
}

.etiqueta .preco-barcode {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-top: 10px;
}

.etiqueta .preco {
  font-size: 1.3rem;
  font-weight: bold;
  color: var(--color-bege-claro);
  margin-bottom: 5px;
}

.etiqueta .barcode {
  width: 100%;
  height: 40px;
  display: flex;
  justify-content: center;
  align-items: center;
  overflow: hidden;
}

.etiqueta .barcode img {
  display: block;
  width: 90%;
  max-width: 150px;
  height: auto;
  object-fit: contain;
}

.btn-excluir-etiqueta {
  position: absolute;
  top: 8px;
  right: 8px;
  background: #ff4444;
  color: white;
  border: none;
  border-radius: 50%;
  width: 26px;
  height: 26px;
  font-size: 16px;
  font-weight: bold;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  opacity: 0.9;
  transition: all 0.3s ease;
  z-index: 10;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
}

.btn-excluir-etiqueta:hover {
  opacity: 1;
  background: #cc0000;
  transform: scale(1.1);
}

.modal-confirmacao {
  display: none;
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5);
  z-index: 1000;
  align-items: center;
  justify-content: center;
}

.modal-confirmacao-conteudo {
  background-color: var(--color-bege-card-interno);
  border-radius: 15px;
  padding: 30px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
  max-width: 400px;
  width: 90%;
  text-align: center;
  border: 2px solid var(--color-vinho);
}

.modal-confirmacao h3 {
  color: var(--color-vinho);
  font-size: 1.4rem;
  margin-bottom: 15px;
  font-weight: bold;
}

.modal-confirmacao p {
  color: var(--color-vinho);
  font-size: 1rem;
  margin-bottom: 25px;
  line-height: 1.5;
}

.modal-botoes {
  display: flex;
  justify-content: center;
  gap: 15px;
  margin-top: 20px;
}

.btn-modal {
  padding: 10px 25px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  border: 2px solid;
}

.btn-modal-cancelar {
  background-color: transparent;
  color: var(--color-vinho);
  border-color: var(--color-vinho);
}

.btn-modal-cancelar:hover {
  background-color: var(--color-vinho);
  color: var(--color-bege-claro);
  transform: translateY(-2px);
}

.btn-modal-confirmar {
  background-color: #ff4444;
  color: white;
  border-color: #ff4444;
}

.btn-modal-confirmar:hover {
  background-color: #cc0000;
  border-color: #cc0000;
  transform: translateY(-2px);
}

.modal-confirmacao.mostrar {
  display: flex;
  animation: fadeIn 0.3s ease;
}

.toast-container {
  position: fixed;
  top: 20px;
  right: 20px;
  z-index: 9999;
  max-width: 350px;
}

.toast {
  background: var(--color-bege-card-interno);
  border-left: 4px solid;
  border-radius: 8px;
  padding: 16px 20px;
  margin-bottom: 10px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
  display: flex;
  align-items: center;
  gap: 12px;
  transform: translateX(400px);
  opacity: 0;
  transition: all 0.3s ease;
  border-left-color: var(--color-vinho);
}

.toast.mostrar {
  transform: translateX(0);
  opacity: 1;
}

.toast.sucesso {
  border-left-color: #28a745;
}

.toast.erro {
  border-left-color: #dc3545;
}

.toast-icon {
  font-size: 20px;
  flex-shrink: 0;
}

.toast.sucesso .toast-icon {
  color: #28a745;
}

.toast.erro .toast-icon {
  color: #dc3545;
}

.toast-conteudo {
  flex-grow: 1;
}

.toast-titulo {
  font-weight: 600;
  color: var(--color-vinho);
  margin-bottom: 4px;
  font-size: 1rem;
}

.toast-mensagem {
  color: var(--color-vinho);
  font-size: 0.9rem;
  line-height: 1.4;
}

.toast-fechar {
  background: none;
  border: none;
  font-size: 18px;
  cursor: pointer;
  color: var(--color-vinho);
  opacity: 0.7;
  transition: opacity 0.2s;
  padding: 0;
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
}

.toast-fechar:hover {
  opacity: 1;
}

@keyframes fadeIn {
  from {
    opacity: 0;
  }

  to {
    opacity: 1;
  }
}

@keyframes slideInRight {
  from {
    transform: translateX(400px);
    opacity: 0;
  }

  to {
    transform: translateX(0);
    opacity: 1;
  }
}

@keyframes slideOutRight {
  from {
    transform: translateX(0);
    opacity: 1;
  }

  to {
    transform: translateX(400px);
    opacity: 0;
  }
}

@media print {

  body,
  html {
    width: 100% !important;
    margin: 0 !important;
    padding: 0 !important;
  }

  .container-card {
    display: block !important;
    border: none !important;
    box-shadow: none !important;
    padding: 0 !important;
    margin: 0 !important;
    width: 100% !important;
    max-width: none !important;
  }

  .header-section,
  .form-add-card,
  .action-buttons,
  .alert,
  .header,
  .nav,
  .footer {
    display: none !important;
  }

  .etiquetas-grid {
    display: grid !important;
    grid-template-columns: repeat(3, 1fr) !important;
    gap: 15px !important;
    page-break-after: always !important;
    width: 100% !important;
  }

  .etiqueta {
    border: 1px solid #000 !important;
    border-radius: 0 !important;
    box-shadow: none !important;
    padding: 10px !important;
    page-break-inside: avoid !important;
    min-height: 120px !important;
    display: block !important;
    width: 100% !important;
  }

  .etiqueta h3,
  .etiqueta .preco,
  .etiqueta .barcode {
    color: #000 !important;
  }

  .etiqueta h3 {
    font-size: 0.9rem !important;
    margin-bottom: 5px !important;
    white-space: normal;
    overflow: visible;
    text-overflow: initial;
    display: block;
    -webkit-line-clamp: initial;
    line-clamp: initial;
    max-height: none;
  }

  .etiqueta .preco {
    font-size: 1.1rem !important;
  }

  .etiqueta .barcode img {
    height: 30px !important;
  }

  .btn-excluir-etiqueta {
    display: none !important;
  }
}

@media (max-width: 768px) {
  .container-card {
    margin-top: 20px;
    margin-bottom: 50px;
    padding: 25px;
    width: calc(100% - 30px);
  }

  .header-section {
    flex-direction: column;
    align-items: flex-start;
    gap: 15px;
  }

  .header-section h2 {
    font-size: 1.8rem;
  }

  .form-add-card .d-flex {
    flex-direction: column;
    align-items: stretch !important;
    gap: 15px;
  }

  .form-add-card .col-form-label {
    margin-right: 0;
    margin-bottom: 5px;
  }

  .form-add-card .form-control {
    width: 100% !important;
  }

  .action-buttons {
    flex-direction: column;
    gap: 10px;
  }

  .etiquetas-grid {
    grid-template-columns: repeat(auto-fill, minmax(130px, 1fr));
    gap: 15px;
  }

  .etiqueta {
    min-height: 130px;
    padding: 10px;
  }

  .etiqueta h3 {
    font-size: 0.95rem;
  }

  .etiqueta .preco {
    font-size: 1.1rem;
  }

  .etiqueta .barcode {
    height: 30px;
  }

  .modal-botoes {
    flex-direction: column;
    gap: 10px;
  }

  .btn-modal {
    width: 100%;
  }

  .toast-container {
    top: 10px;
    right: 10px;
    left: 10px;
    max-width: none;
  }
}
</style>
@endsection

@section('content')
<div class="container-card">
  <div class="header-section">
    <h2>{{ __('labels.titulo_etiquetas') }}</h2>
  </div>

  @if(session('error'))
  <div class="alert alert-danger text-center" role="alert">
    {{ session('error') }}
  </div>
  @endif

  <div class="form-add-card">
    <form method="POST" action="{{ route('etiquetas.adicionar') }}" class="d-flex align-items-center gap-3">
      @csrf
      <label for="codigo" class="col-form-label mb-0">{{ __('labels.codigo_barras_label') }}</label>
      <input type="text" name="codigo" id="codigo" class="form-control" placeholder="{{ __('labels.placeholder_codigo') }}" required autofocus />
      <button type="submit" class="btn btn-primary">{{ __('labels.adicionar_btn') }}</button>
    </form>
  </div>

  @if(!empty($etiquetas))
  <div class="action-buttons">
    <a href="{{ route('etiquetas.limpar') }}" class="btn btn-outline-danger">{{ __('labels.limpar_tudo') }}</a>
    <button onclick="window.print()" class="btn btn-success">{{ __('labels.imprimir_etiquetas') }}</button>
  </div>

  <div class="etiquetas-grid">
    @foreach ($etiquetas as $index => $et)
    <div class="etiqueta" data-index="{{ $index }}">
      <button class="btn-excluir-etiqueta" title="{{ __('labels.excluir_etiqueta') }}">×</button>
      <h3 title="{{ $et['nome'] }}">{{ $et['nome'] }}</h3>
      <div class="preco-barcode">
        <div class="preco">R$ {{ number_format((float) $et['preco'], 2, ',', '.') }}</div>
        <div class="barcode">
          <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($et['codigo'], 'C128', 2, 60, [0,0,0], true) }}" alt="{{ __('labels.alt_codigo_barras') }} {{ $et['codigo'] }}" />
        </div>
      </div>
    </div>
    @endforeach
  </div>
  @endif
</div>

<!-- Modal de Confirmação -->
<div class="modal-confirmacao" id="modalConfirmacao">
  <div class="modal-confirmacao-conteudo">
    <h3>{{ __('labels.excluir_etiqueta') }}</h3>
    <p>{{ __('labels.confirmar_exclusao') }}</p>
    <div class="modal-botoes">
      <button class="btn-modal btn-modal-cancelar" id="btnCancelar">{{ __('labels.cancelar') }}</button>
      <button class="btn-modal btn-modal-confirmar" id="btnConfirmar">{{ __('labels.excluir') }}</button>
    </div>
  </div>
</div>

<!-- Container para Toasts -->
<div class="toast-container" id="toastContainer"></div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
  const urlParams = new URLSearchParams(window.location.search);
  const produto = urlParams.get('produto');
  const produtos = urlParams.get('produtos');

  // Elementos do modal
  const modalConfirmacao = document.getElementById('modalConfirmacao');
  const btnCancelar = document.getElementById('btnCancelar');
  const btnConfirmar = document.getElementById('btnConfirmar');
  const toastContainer = document.getElementById('toastContainer');

  let etiquetaParaExcluir = null;
  let indexParaExcluir = null;

  if (produto && document.querySelector('.etiqueta')) {
    setTimeout(function() {
      window.print();
    }, 500);
  }

  if (produtos && document.querySelector('.etiqueta')) {
    setTimeout(function() {
      window.print();
    }, 500);
  }

  // Função para mostrar toast
  function mostrarToast(titulo, mensagem, tipo = 'sucesso') {
    const toast = document.createElement('div');
    toast.className = `toast ${tipo}`;
    toast.innerHTML = `
      <div class="toast-icon">
        ${tipo === 'sucesso' ? '✓' : '✕'}
      </div>
      <div class="toast-conteudo">
        <div class="toast-titulo">${titulo}</div>
        <div class="toast-mensagem">${mensagem}</div>
      </div>
      <button class="toast-fechar">×</button>
    `;

    toastContainer.appendChild(toast);

    // Usar requestAnimationFrame para garantir que o DOM foi atualizado
    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        toast.classList.add('mostrar');
      });
    });

    // Configurar fechamento
    const btnFechar = toast.querySelector('.toast-fechar');
    btnFechar.addEventListener('click', () => {
      fecharToast(toast);
    });

    // Auto-remover após 5 segundos
    setTimeout(() => {
      if (toast.parentNode) {
        fecharToast(toast);
      }
    }, 5000);
  }

  function fecharToast(toast) {
    toast.classList.remove('mostrar');
    setTimeout(() => {
      if (toast.parentNode) {
        toast.parentNode.removeChild(toast);
      }
    }, 300);
  }

  // Funções para controlar o modal
  function mostrarModal(etiqueta, index) {
    etiquetaParaExcluir = etiqueta;
    indexParaExcluir = index;
    modalConfirmacao.classList.add('mostrar');
  }

  function fecharModal() {
    modalConfirmacao.classList.remove('mostrar');
    etiquetaParaExcluir = null;
    indexParaExcluir = null;
  }

  function excluirEtiqueta() {
    if (etiquetaParaExcluir && indexParaExcluir !== null) {
      fetch('{{ route("etiquetas.excluir") }}', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
          },
          body: JSON.stringify({
            index: indexParaExcluir
          })
        })
        .then(response => {
          if (!response.ok) {
            throw new Error('Erro na rede');
          }
          return response.json();
        })
        .then(data => {
          if (data.success) {
            etiquetaParaExcluir.remove();

            // Atualiza os índices das etiquetas restantes
            document.querySelectorAll('.etiqueta').forEach((et, newIndex) => {
              et.setAttribute('data-index', newIndex);
            });

            // Mostra toast de sucesso
            mostrarToast(
              '{{ __("labels.sucesso") }}',
              '{{ __("labels.etiqueta_excluida_sucesso") }}',
              'sucesso'
            );
          } else {
            mostrarToast(
              '{{ __("labels.erro") }}',
              '{{ __("labels.erro_excluir_etiqueta") }}',
              'erro'
            );
          }
        })
        .catch(error => {
          console.error('Erro:', error);
          mostrarToast(
            '{{ __("labels.erro") }}',
            '{{ __("labels.erro_desconhecido") }}',
            'erro'
          );
        })
        .finally(() => {
          fecharModal();
        });
    }
  }

  // Event listeners
  document.querySelectorAll('.btn-excluir-etiqueta').forEach(button => {
    button.addEventListener('click', function() {
      const etiqueta = this.closest('.etiqueta');
      const index = etiqueta.getAttribute('data-index');
      mostrarModal(etiqueta, index);
    });
  });

  btnCancelar.addEventListener('click', fecharModal);
  btnConfirmar.addEventListener('click', excluirEtiqueta);

  // Fechar modal ao clicar fora dele
  modalConfirmacao.addEventListener('click', function(e) {
    if (e.target === modalConfirmacao) {
      fecharModal();
    }
  });

  // Fechar modal com tecla ESC
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape' && modalConfirmacao.classList.contains('mostrar')) {
      fecharModal();
    }
  });
});
</script>
@endsection