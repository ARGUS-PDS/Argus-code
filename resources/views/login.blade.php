<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Login - Argus</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

      <!-- Favicon para tema claro -->
    <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">

    <!-- Favicon para tema escuro -->
    <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
    
    @include('layouts.css-variables')

</head>
<style>
    html {
        height: 100%;
        width: 100%;
    }

    * {
        font-family: -apple-system, "Segoe UI", Roboto, "Helvetica Neue", "Noto Sans", "Liberation Sans", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"
    }

    body {
        background: var(--color-bege-claro);
        height: 98%;
    }

    .d-flex {
        display: flex;
    }

    .column {
        flex-direction: column;
    }

    .d-column {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .align-items-center {
        justify-content: center;
        align-items: center;
    }

    .p-4 {
        padding: 1.5rem;
    }

    .card {
        background:var(--color-vinho);
        border-radius: 8px;
    }

    .text-center {
        text-align: center;
    }

    .title {
        font-size: 25px;
        color: var(--color-white);
    }

    .mb-3 {
        margin-bottom: 15px;
    }

    .input {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .form-control {
        height: 30px;
        width: 85%;
        border-radius: 5px;
        border: none;
    }

    .form-label {
        margin: 5px;
        width: 85%;
        color:var(--color-white);
    }

    .image {
        aspect-ratio: 10/5;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    input:focus {
        outline: none;
    }

    .gap {
        gap: 25px;
    }

    .btn-send {
        padding: 10px 50px;
        background: var(--color-black);
        border: none;
        color: var(--color-white);
        font-size: 18px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
    }

    .btn-send:hover {
        transition: .8s;
        background: var(--color-vinho-claro);
        transform: scale(1.08, 1.08);
        /*border: 1px solid red;*/
        letter-spacing: 2px;
    }

    .eyes {
        max-height: 20px;
        margin-left: -35px;
    }

    .input-eyes {
        display: flex;
        align-items: center;
        width: 85%;
    }

    #password {
        width: 100%;
        margin-left: -2px;
    }
</style>

<body class="d-flex column align-items-center justify-content-center gap">

    <div class="image">
        <img src="{{ asset('images/logo.png') }}" alt="Logo">
    </div>
    <div class="card p-4" style="width: 100%; max-width: 400px;">
        <div>
            <h4 class="title text-center" style="margin: 0 0 20px 0;">Faça Login no Argus!</h4>

            @if ($errors->any())
            <div class="alert alert-danger">
                {{ $errors->first() }}
            </div>
            @endif

            <form method="POST" action="/login">
                @csrf
                <div class="d-column">
                    <div class="input mb-3">
                        <label for="email" class="form-label center">E-mail</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}" required autofocus>
                    </div>

                    <div class="input mb-3">
                        <label for="password" class="form-label center">Senha</label>
                        <div class="input-eyes">
                            <input type="password" class="form-control" name="password" id="password" required>
                            <img onclick="togglePassword()" class="eyes" src="{{ asset('images/openeye.png') }}" alt="eye" style="cursor: pointer;">
                        </div>
                    </div>
                    <div class="input mb-3">
                        <label for="cartao_seg" class="form-label center">Final do cartão de segurança</label>
                        <input type="text" class="form-control" name="cartao_seg" id="cartao_seg" maxlength="4" required pattern="\d{4}" placeholder="Ex: 0000">
                    </div>
                </div>

                <div class="d-flex align-items-center">
                    <button type="submit" class="btn-send">Entrar</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("password");
            const eyeIcon = passwordInput.nextElementSibling;

            const openEye = "{{ asset('images/openeye.png') }}";
            const closedEye = "{{ asset('images/closedeye.png') }}";

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIcon.src = closedEye;
            } else {
                passwordInput.type = "password";
                eyeIcon.src = openEye;
            }
        }
    </script>


</body>

</html>