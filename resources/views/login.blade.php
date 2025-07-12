<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login & Registro</title>
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="imagens/imagem.png" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css/Login.css') }}">
    <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
    <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
</head>

<body>
    <div class="container" id="container">
        <div class="formulario-container logar">
            <form method="POST" action="/login">
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
            <form>
                <h1>Entre em contato</h1>
                <input type="text" placeholder="Nome" required />
                <input type="email" placeholder="Email" required />
                <input 
                    type="tel" 
                    id="whatsapp" 
                    name="whatsapp" 
                    placeholder="(00) 00000-0000" 
                    pattern="^\(\d{2}\) \d{5}-\d{4}$" 
                    required 
                    title="Digite um número de WhatsApp válido. Ex: (99) 99999-9999"
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
                    <h1>Olá, Amigo!</h1>
                    <p>Cadastre-se agora e simplifique sua gestão de estoque de maneira inteligente!</p>
                    <button class="botao-input hidden" id="registrar">Registrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/Login.js') }}"></script>
</body>
</html>