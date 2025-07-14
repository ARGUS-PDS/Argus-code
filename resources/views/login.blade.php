<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login & Registro</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="imagens/imagem.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
    <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
</head>

<script src="https://unpkg.com/vanilla-masker/build/vanilla-masker.min.js"></script>
<script>
    VMasker(document.querySelector("input[name='whatsapp']")).maskPattern("(99) 99999-9999");
</script>

<body>
    <div class="container" id="container">
        <div class="formulario-container logar">
                @if(session('success_contato'))
                    <div id="mensagem-enviada" class="mt-3 text-success fw-bold">
                        <strong><i class="fas fa-check-circle me-2"></i>Contato registrado!</strong>
                    </div>
                @endif
                <br>
            <form method="POST" action="/login" onsubmit="mostrarTelaCarregando()">
                @csrf
                <h1>Entrar</h1>
                <input type="email" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus />
                
                <div class="password-container">
                    <input type="password" id="password" name="password" placeholder="Senha" required minlength="8" />
                    <i class="toggle-password fas fa-eye" onclick="togglePassword('password', this)"></i>
                </div>

                <div class="password-container">
                    <input type="password" name="cartao_seg" id="cartao_seg" placeholder="Final do cartão de segurança" required pattern="\d{4}" />
                    <i class="toggle-password fas fa-eye" onclick="togglePassword('cartao_seg', this)"></i>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                @endif
                
                <a href="#">Sua senha venceu?</a>
                <button class="botao-input">Entrar</button>
            </form>
        </div>


        <div class="formulario-container registro">
            <form method="POST" action="{{ route('contato.enviar') }}">
                @csrf
                <h1>Entre em contato</h1>

                <input type="text" name="nome" placeholder="Seu Nome" required />
                <input type="text" name="empresa" placeholder="Sua Empresa" required />
                <input type="email" name="email" placeholder="Email para contato" required />
                <input 
                    type="tel" 
                    name="whatsapp" 
                    placeholder="(00)00000-0000"
                    required
                >
                <button class="botao-input">Enviar</button>
            </form>
        </div>

        <div class="container-alternativo">
            <div class="alternativo">
                <div class="painel-alternativo painel-esquerdo">
                    <h1>Bem-vindo de volta!</h1>
                    <p>Para se manter conectado, faça login com suas informações pessoais.</p>
                    <button class="botao-input hidden" id="entrar">Entrar</button>
                </div>
                <div class="painel-alternativo painel-direito">
                    <h1>Olá!</h1>
                    <p>Entre em contato conosco agora e simplifique sua gestão de estoque de maneira inteligente!</p>
                    <button class="botao-input hidden" id="registrar">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/login.js') }}"></script>
    <script>
            document.addEventListener("DOMContentLoaded", function () {
                const mensagem = document.getElementById("mensagem-enviada");
                if (mensagem) {
                    setTimeout(() => {
                        mensagem.remove();
                    }, 4000); 
                }
            });
    </script>

    @include('layouts.carregamento')
</body>
</html>