<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Argus</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
    <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    
    @include('layouts.css-variables')
    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="/dashboard" onclick="mostrarTelaCarregando()">
                <img src="{{ asset('images/logo.png') }}" alt="Argus">
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('menu.cadastros') }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/lista-produtos" onclick="mostrarTelaCarregando()">{{__('menu.produtos')}}</a></li>
                            <li><a class="dropdown-item" href="/lista-fornecedores" onclick="mostrarTelaCarregando()">{{__('menu.fornecedores')}}</a></li>
                           <!-- <li><a class="dropdown-item" href="/cadastrar-funcionario" onclick="mostrarTelaCarregando()">{{__('menu.funcionarios')}}</a></li> -->
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('menu.estoque') }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/entrada-saida" onclick="mostrarTelaCarregando()">{{ __('menu.controle_estoque') }}</a></li>
                            <li><a class="dropdown-item" href="#" onclick="mostrarTelaCarregando()">{{ __('menu.acompanhamento_validade') }}</a></li>
                            <li><a class="dropdown-item" href="/etiquetas" onclick="mostrarTelaCarregando()">{{ __('menu.etiquetas') }}</a></li>
                            <li><a class="dropdown-item" href="/detalhamento-lote" onclick="mostrarTelaCarregando()">{{ __('menu.detalhamento_lote') }}</a></li>
                            <li><a class="dropdown-item" href="/vendas" onclick="mostrarTelaCarregando()">{{__('menu.frente_caixa')}}</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">{{ __('menu.pedidos') }}</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="/alerta-estoque" onclick="mostrarTelaCarregando()">{{ __('menu.envio_pedido') }}</a></li>
                            <li><a class="dropdown-item" href="#" onclick="mostrarTelaCarregando()">{{ __('menu.cotacao_fornecedores') }}</a></li>
                            <li><a class="dropdown-item" href="/pedidos-enviados" onclick="mostrarTelaCarregando()">{{ __('menu.historico_pedidos') }}</a></li>
                        </ul>
                    </li>
                </ul>
                
                <div class="navbar-right-items">
                    <div class="user-info position-relative">
                        <button title="Meu perfil" id="userMenuBtn" class="btn btn-user-menu d-flex align-items-center" type="button">
                            @if(Auth::user() && Auth::user()->profile_photo_url)
                                <img src="{{ Auth::user()->profile_photo_url }}"
                                    alt="Foto de perfil"
                                    class="profile-pic-avatar"
                                    style="width: 32px; height: 32px; object-fit: cover; border-radius: 50%;">
                            @else
                                <i class="bi bi-person-circle"></i>
                            @endif
                            <span class="ms-2">{{ Auth::user() ? Auth::user()->name : 'Usuário' }}</span>
                        </button>
                        <div id="userMenuPanel" class="user-menu-panel shadow text-center">
                            <form id="profilePicForm" action="{{ route('profile.upload-photo') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="profile_photo_url" id="profilePicInput" accept="image/*" style="display:none" onchange="document.getElementById('profilePicForm').submit(); mostrarTelaCarregando();">
                                <label for="profilePicInput" style="cursor:pointer; display:inline-block; margin-top: 12px;">
                                    @if(Auth::user() && Auth::user()->profile_photo_url)
                                        <img id="profilePicImg"
                                            src="{{ Auth::user()->profile_photo_url }}"
                                            alt="Foto de perfil"
                                            class="profile-pic-avatar">
                                    @else
                                        <span id="profilePicImg" class="profile-pic-avatar d-flex align-items-center justify-content-center">
                                            <i class="bi bi-person-circle"></i>
                                        </span>
                                    @endif
                                </label>
                            </form>
                            <div class="mt-3 fw-bold" style="font-size: 20px; color: var(--color-bege-claro);">Olá, {{ Auth::user() ? Auth::user()->name : 'Usuário' }}</div>
                            
                            <a href="#"
                                class="d-block align-items-center gap-2 mt-3"
                                style="color: var(--color-bege-claro); font-weight: bold; font-size: 1.1rem; text-decoration: none; background: none; border: none; cursor: pointer;"
                                data-bs-toggle="modal" data-bs-target="#modalAlterarSenha">
                                <i class="bi bi-key-fill nav-icon" style="font-size: 1.5rem; color: var(--color-bege-claro);"></i>
                                <span style="color: var(--color-bege-claro);">Alterar senha</span>
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                    <button type="submit" class="logout-container mt-3">
                                        <i class="bi bi-box-arrow-right nav-icon"></i>
                                        <span>Sair</span>
                                    </button>
                            </form>
                        </div>
                    </div>
                    <div class="d-flex gap-2 align-items-center">
                        @php $current = app()->getLocale(); @endphp

                        <div class="dropdown lang-switch">
                            <button class="btn lang-btn dropdown-toggle" type="button"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                <img class="lang-flag"
                                    src="{{ asset($current == 'pt_BR' ? 'images/brazil.png' : 'images/us.png') }}"
                                    width="20" alt="flag">

                                <span class="lang-label">
                                    {{ $current == 'pt_BR' ? 'Português' : 'English' }}
                                </span>

                                <i class="bi bi-caret-down-fill"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-menu-end">
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                    href="{{ route('lang.switch', 'pt_BR') }}">
                                        <img src="{{ asset('images/brazil.png') }}" width="20" alt="pt"> Português
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item d-flex align-items-center gap-2"
                                    href="{{ route('lang.switch', 'en') }}">
                                        <img src="{{ asset('images/us.png') }}" width="20" alt="en"> English
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main class="main-content">
        @yield('content')
    </main>

    {{-- Modal de Alterar Senha --}}
    <div class="modal fade" id="modalAlterarSenha" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-4 px-3 pb-3 pt-2">
                <div class="modal-header border-0">
                    <h5 class="modal-title fw-bold">Alterar Senha</h5>
                </div>
                <div class="modal-body">
                    <form id="formAlterarSenha" onsubmit="handleChangePassword(event)">
                        @csrf
                        
                        <div class="mb-3">
                            <label class="form-label">Senha Atual</label>
                            <div class="password-container position-relative">
                                <input type="password" name="current_password" class="form-control" required>
                                <i class="bi bi-eye toggle-password" onclick="togglePassword(this)"></i>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nova Senha</label>
                            <div class="password-container position-relative">
                                <input type="password" name="new_password" class="form-control" required minlength="8">
                                <i class="bi bi-eye toggle-password" onclick="togglePassword(this)"></i>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Confirmar Nova Senha</label>
                            <div class="password-container position-relative">
                                <input type="password" name="new_password_confirmation" class="form-control" required minlength="8">
                                <i class="bi bi-eye toggle-password" onclick="togglePassword(this)"></i>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <x-btn-cancelar data-bs-dismiss="modal" />
                            <x-btn-salvar />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    @yield('scripts')
    @include('layouts.carregamento')

    <script>
        // Função para toggle de visibilidade da senha
        function togglePassword(element) {
            const input = element.previousElementSibling;
            if (input.type === 'password') {
                input.type = 'text';
                element.classList.add('active');
                element.classList.remove('bi-eye');
                element.classList.add('bi-eye-slash');
            } else {
                input.type = 'password';
                element.classList.remove('active');
                element.classList.remove('bi-eye-slash');
                element.classList.add('bi-eye');
            }
        }

        // Função para lidar com o envio do formulário de alterar senha
        function handleChangePassword(event) {
            event.preventDefault();
            
            const form = event.target;
            const currentPassword = form.querySelector('[name="current_password"]').value;
            const newPassword = form.querySelector('[name="new_password"]').value;
            const confirmPassword = form.querySelector('[name="new_password_confirmation"]').value;
            
            // Limpa mensagens anteriores
            clearMessages();
            
            // Validações
            if (newPassword.length < 8) {
                showMessage('A nova senha deve ter pelo menos 8 caracteres.', 'danger');
                return;
            }
            
            if (newPassword !== confirmPassword) {
                showMessage('As senhas não coincidem.', 'danger');
                return;
            }
            
            if (newPassword === currentPassword) {
                showMessage('A nova senha deve ser diferente da senha atual.', 'danger');
                return;
            }
            
            // Se passou pelas validações, mostra mensagem de sucesso (simulando)
            showMessage('Senha alterada com sucesso! (Funcionalidade em desenvolvimento)', 'success');
            
            // Limpa o formulário
            form.reset();
            
            // Fecha o modal após 2 segundos
            setTimeout(() => {
                const modal = bootstrap.Modal.getInstance(document.getElementById('modalAlterarSenha'));
                if (modal) {
                    modal.hide();
                }
            }, 2000);
        }

        // Função para mostrar mensagens
        function showMessage(message, type) {
            const modalBody = document.querySelector('#modalAlterarSenha .modal-body');
            const alertDiv = document.createElement('div');
            alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
            alertDiv.innerHTML = `
                <i class="bi bi-${type === 'success' ? 'check-circle-fill' : 'exclamation-triangle-fill'} me-2"></i>
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            
            // Insere a mensagem antes do formulário
            const form = modalBody.querySelector('form');
            modalBody.insertBefore(alertDiv, form);
        }

        // Função para limpar mensagens
        function clearMessages() {
            const alerts = document.querySelectorAll('#modalAlterarSenha .alert');
            alerts.forEach(alert => alert.remove());
        }

        // Limpa mensagens quando o modal é fechado
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('modalAlterarSenha');
            if (modal) {
                modal.addEventListener('hidden.bs.modal', function() {
                    clearMessages();
                    const form = this.querySelector('form');
                    if (form) {
                        form.reset();
                    }
                });
            }

            // Adiciona classe modal-open ao body quando qualquer modal abrir
            const allModals = document.querySelectorAll('.modal');
            allModals.forEach(modal => {
                modal.addEventListener('show.bs.modal', function() {
                    document.body.classList.add('modal-open');
                    
                    // Se for o modal de alterar senha, fecha o modal do usuário
                    if (this.id === 'modalAlterarSenha') {
                        const userMenuPanel = document.getElementById('userMenuPanel');
                        if (userMenuPanel) {
                            userMenuPanel.style.display = 'none';
                        }
                    }
                });
                
                modal.addEventListener('hidden.bs.modal', function() {
                    document.body.classList.remove('modal-open');
                });
            });
        });
    </script>
</body>
</html>