<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @include('layouts.css-variables')
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            background-color: var(--color-bege-claro);
            color: var(--color-vinho);
            font-family: Arial, sans-serif;
        }

        header {
            width: 100%;
            padding: 0 60px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            top: 0;
            left: 0;
            background-color: var(--color-vinho);
            box-shadow: 0 2px 6px var(--color-shadow);
            z-index: 100;
            border-radius: 0 0 16px 16px;
        }

        section:not(.plans){
            padding-bottom: 50px;
        }

        .menu-logo {
            width: 70px;
            height: auto;
        }

        .btn-login {
            background-color: var(--color-bege-claro);
            color: var(--color-vinho);
            border: 2px solid var(--color-bege-claro);
            border-radius: 25px;
            padding: 10px 22px;
            font-weight: 500;
            cursor: pointer;
            transition: background-color border 0.3s ease;
            text-decoration: none;
        }

        .btn-login:hover {
            background-color: var(--color-bege-medio);
            color: var(--color-vinho);
            border: 2px solid var(--color-bege-medio);
        }

        .logo-text {
            max-width: 700px;
            margin: 0 auto 50px auto;
            font-size: 20px;
        }

        /* section de apresentacao */

        .presentition {
            margin-top: 120px;
            display: flex;
            justify-content: center;
            text-align: left;
        }

        .presentition-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 60px;
            max-width: 1200px;
            width: 100%;
        }

        .presentition-left {
            flex: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .presentiation-text{
            max-width: 700px;
            margin: 0 auto 20px auto;
            font-size: 25px;
            text-align: justify;
        }

        .presentition-right {
            flex: 1;
            display: flex;
            justify-content: center;
        }

        .illustration {
            max-width: 100%;
            height: auto;
            border-radius: 16px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        }

        .logo-section {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .logo2 {
            display: block;
            margin: 0 auto 50px auto;
            max-width: auto;
            height: auto;
        }

        .topics {
            display: flex;
            justify-content: center;
            align-items: flex-start;
            gap: 60px;
            flex-wrap: wrap;
        }

        .topic {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 20px;
            font-weight: bold;
        }

        .check {
            font-size: 21px;
            font-weight: bold;
        }

        .btn-group {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 40px;
        }

        .btn-group .btn-scroll {
            margin: 0;
        }

        .btn-scroll-plans {
            margin: 0 auto 0 auto;
            background-color: var(--color-vinho);
            color: var(--color-bege-claro);
            border: 2px solid var(--color-vinho);
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 18px;
            text-decoration: none;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-scroll-plans:hover {
            background-color: var(--color-bege-claro);
            color: var(--color-vinho);
            border: 2px solid var(--color-vinho);
        }

        .btn-scroll-start {
            margin: 0 auto 0 auto;
            background-color: var(--color-bege-claro);
            color: var(--color-vinho);
            border: 2px solid var(--color-vinho);
            padding: 12px 28px;
            border-radius: 30px;
            font-weight: bold;
            font-size: 18px;
            text-decoration: none;
            transition: all 0.3s ease;
            text-align: center;
        }

        .btn-scroll-start:hover {
            background-color: var(--color-vinho);
            color: var(--color-bege-claro);
            border: 2px solid var(--color-vinho);
        }

        /* section de planos */

        .plans {
            background: var(--color-vinho);
            padding-top: 25px;
            padding-bottom: 25px;
        }

        .plan-card {
            background-color: var(--color-bege-claro);
            color: var(--color-vinho);
            border-radius: 16px;
            padding: 40px 30px;
            box-shadow: 0 4px 12px var(--color-shadow);
            max-width: 350px;
            margin: 0 auto;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .plan-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 8px 18px var(--color-shadow);
        }

        .plan-name {
            font-size: 30px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        .plan-description {
            list-style: none;
            padding: 0;
            margin: 0 0 25px 0;
            text-align: center;
        }

        .plan-description li {
            position: relative;
            padding-left: 0;
            margin-bottom: 10px;
            font-size: 18px;
            line-height: 1.5;
        }

        .plan-description li::before {
            content: "✔";
            color: var(--color-vinho);
            margin-right: 8px;
            font-weight: bold;
        }

        .plan-price {
            display: flex;
            justify-content: center;
            align-items: baseline;
            gap: 8px;
            font-size: 25px;
            font-weight: bold;
            color: var(--color-vinho);
        }

        .plan-price span {
            font-size: 18px;
            color: var(--color-vinho-fundo);
        }

        /* section da equipe */
        
        .team {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 50px;
            margin-top: 40px;
        }
        
        .member {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .member img {
            width: 160px;
            height: 160px;
            object-fit: cover;
            border-radius: 50%;
            border: 4px solid var(--color-vinho);
            box-shadow: 0 4px 8px var(--color-shadow);
            transition: transform 0.3s ease;
        }

        .member img:hover {
            transform: scale(1.05);
        }

        .team-title {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 25px;
            margin-top: 25px;
            color: var(--color-vinho);
            justify-content: center;
            text-align: center;
        } 

        /*section de como começar*/

        .start {
            background-color: var(--color-bege-claro);
            color: var(--color-vinho);
            padding: 40px 10px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
        }

        .start-container {
            max-width: 700px;
        }

        .start-title {
            font-size: 42px;
            font-weight: bold;
            margin-bottom: 25px;
            color: var(--color-vinho);
        }

        .start-steps {
            list-style: decimal;
            text-align: left;
            margin: 0 auto 40px auto;
            padding-left: 20px;
            max-width: 500px;
            font-size: 22px;
            line-height: 1.6;
        }

        .start-steps li {
            margin-bottom: 15px;
        }

        .btn-login-start {
            background-color: var(--color-vinho);
            color: var(--color-bege-claro);
            border: 2px solid var(--color-vinho);
            border-radius: 25px;
            padding: 10px 22px;
            cursor: pointer;
            transition: all 0.4s ease;
            text-decoration: none;
            font-size: 24px;
        }

        .btn-login-start:hover {
            background-color: var(--color-bege-claro);
            color: var(--color-vinho);
            border: 2px solid var(--color-vinho);
        }


        /*section rodape*/

        .footer {
            background-color: var(--color-vinho);
            color: var(--color-bege-claro);
            text-align: center;
            padding: 40px 20px;
            border-radius: 16px 16px 0 0;
            box-shadow: 0 -2px 8px var(--color-shadow);
            margin-top: 30px;
        }

        .footer-text {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .footer-contact {
            font-size: 16px;
        }

        .footer-link {
            color: var(--color-bege-claro);
            text-decoration: underline;
            transition: color 0.3s ease;
        }

        .footer-link:hover {
            color: var(--color-bege-medio);
        }

        /*menuzinho lateral*/

        .side-panel {
        position: fixed;
        top: 50%;
        right: 0;
        transform: translateY(-50%);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 15px;
        background-color: var(--color-vinho-fundo);
        padding: 10px 10px 10px 10px;
        border-radius: 20px 0 0 20px;
        box-shadow: 0 4px 12px var(--colo-shadow);
        z-index: 100;
    }

    .panel-btn {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 20px;
        color: var(--color-bege-claro);
        transition: transform 0.2s ease, color 0.3s ease;
    }

    .flag {
        width: 26px;
        height: 26px;
        border-radius: 50%;
        transition: transform 0.2s ease, border-color 0.3s ease;
    }

</style>
</head>

<body>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <header>
        <img id="navbar-logo" class="menu-logo" src="{{ asset('images/favicon-dark.png') }}" alt="{{ __('menu.argus') }}">
        <a href="{{ route('login') }}" class="btn-login">Login</a>
    </header>
    

    <section class="presentition">
        <div class="presentition-content">
            <div class="presentition-left">
                
                <img src="{{ asset('images/logo2.png') }}" alt="Logo do projeto" class="logo2">

                <p class="presentiation-text">
                    Pensado pra quem busca praticidade e eficiência, o sistema oferece uma gestão de estoque completa e intuitiva. Com ele, é possível acompanhar produtos, entradas, saídas e relatórios em tempo real, garantindo mais controle e menos preocupações. Um jeito simples de organizar seu negócio e manter tudo sob controle, sem complicações.
                </p>

                <div class="topics">
                    <div class="topic">
                        <span class="check">✔</span>
                        <p>Qualidade</p>
                    </div>
                    <div class="topic">
                        <span class="check">✔</span>
                        <p>Facilidade</p>
                    </div>
                    <div class="topic">
                        <span class="check">✔</span>
                        <p>Inteligência</p>
                    </div>
                </div>

                <div class="btn-group">
                    <a href="#plans" class="btn-scroll-plans">Conheça o plano</a>
                    <a href="#start" class="btn-scroll-start">Quero começar!</a>
                </div>
            </div>

            <div class="presentition-right">
                <img src="{{ asset('images/mulher-alegre.jpg') }}"class="illustration">
            </div>
        </div>
    </section>

    <section class="argon">
        <h2 class="team-title">Equipe Argon</h2>

        <div class="team">
            <div class="member">
                <img title="Ana Maria Costa" src="{{ asset('images/Ana Maria.jpeg') }}">
            </div>
            <div class="member">
                <img title="Felipe Witkowsky" src="{{ asset('images/Felipe.jpeg') }}">
            </div>
            <div class="member">
                <img title="Gabriel Luna" src="{{ asset('images/Gabriel.jpeg') }}">
            </div>
            <div class="member">
                <img title="Gustavo Emiliano" src="{{ asset('images/Gustavo.jpeg') }}">
            </div>
            <div class="member">
                <img title="Isabela Crestane" src="{{ asset('images/Isabela.jpg') }}">
            </div>
            <div class="member">
                <img title="Brenda Giron" src="{{ asset('images/Brenda.jpg') }}">
            </div>
        </div>
    </section>

    <section class="plans" id="plans">
        <div class="plans-container">
            <div class="plan-card">
                <h3 class="plan-name">Plano base</h3>

                <ul class="plan-description">
                    <li>Controle de estoque</li>
                    <li>Envio automatizado para fornecedores</li>
                    <li>Emissão de etiquetas</li>
                    <li>Controle de entrada e saída</li>
                    <li>Ponto de venda (PDV)</li>
                </ul>

                <div class="plan-price">
                    <strong>R$ 19,90</strong><span>mensais</span>
                </div>
            </div>
        </div>
    </section>

    <section class="start" id="start">
        <div class="start-container">
            <h2 class="start-title">Comece agora!</h2>

            <ol class="start-steps">
                <li>Clique no botão <strong>“Login”</strong> no topo da página.</li>
                <li>Selecione a opção <strong>“Registrar”</strong> caso ainda não tenha uma conta.</li>
                <li>Preencha as informações solicitadas e entre em contato conosco para concluir o cadastro.</li>
                <li>Pronto! Assim que sua conta for ativada, você já pode acessar o sistema normalmente.</li>
            </ol>
            <a href="{{ route('login') }}" class="btn-login-start">Login</a>
        </div>
    </section>

    <div class="side-panel">
        <button id="themeToggle" class="panel-btn" onchange="toggleDarkMode(this)">
            <i class="bi bi-moon-fill"></i>
        </button>

        <button id="langToggle" class="panel-btn">
            <img id="flagIcon" class="flag" src="{{ asset('images/brazil.png') }}" alt="BR">
        </button>
    </div>
    
    <footer class="footer">
        <div class="footer-container">
            <p class="footer-text">
                © 2025 <strong>Equipe Argon</strong> — Todos os direitos reservados.
            </p>
            <p class="footer-contact">
                Contato: <a href="mailto:contato@argon.com" class="footer-link">contato@argon.com</a>
            </p>
        </div>
    </footer>

    <script>
        const themeBtn = document.getElementById('themeToggle');
        const langBtn = document.getElementById('langToggle');
        const flagIcon = document.getElementById('flagIcon');
        const body = document.body;
        const logo = document.getElementById('navbar-logo');

        let darkMode = localStorage.getItem('theme') === 'dark';
        let isPT = true;

        themeBtn.innerHTML = darkMode ? '<i class="bi bi-sun-fill"></i>' : '<i class="bi bi-moon-fill"></i>';
        body.classList.toggle('dark-mode', darkMode);

        themeBtn.addEventListener('click', () => {
            darkMode = !darkMode;
            body.classList.toggle('dark-mode', darkMode);
            themeBtn.innerHTML = darkMode ? '<i class="bi bi-sun-fill"></i>' : '<i class="bi bi-moon-fill"></i>';
            localStorage.setItem('theme', darkMode ? 'dark' : 'light');

            if (logo) {
                logo.src = darkMode 
                    ? "{{ asset('images/favicon-light.png') }}" 
                    : "{{ asset('images/favicon-dark.png') }}";
            }
        });

        langBtn.addEventListener('click', () => {
            isPT = !isPT;
            flagIcon.src = isPT
                ? '{{ asset('images/brazil.png') }}'
                : '{{ asset('images/us.png') }}';
            flagIcon.alt = isPT ? 'BR' : 'US';
        });
    </script>
</body>
</html>
