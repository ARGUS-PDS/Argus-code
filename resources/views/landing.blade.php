<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ __('landpage.title') }}</title>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="{{ asset('css/landpage.css') }}">
  <link rel="icon" href="{{ asset('images/favicon-light.png') }}" media="(prefers-color-scheme: light)" type="image/png">
  <link rel="icon" href="{{ asset('images/favicon-dark.png') }}" media="(prefers-color-scheme: dark)" type="image/png">
</head>

<body>
  <nav class="navbar">
    <div class="navbar-container">
      <img class="logo" src="{{ asset('images/logo.png') }}" alt="logo">

      <!-- Botão para menu mobile -->
      <button class="mobile-menu-btn" id="mobile-menu-btn">
        <i class="fas fa-bars"></i>
      </button>

      <!-- Links de navegação -->
      <div class="nav-links" id="nav-links">
        <a href="#home">{{ __('landpage.home') }}</a>
        <a href="#planos">{{ __('landpage.plans') }}</a>
        <a href="#features">{{ __('landpage.features') }}</a>
        <a href="#parceiros">{{ __('landpage.partners') }}</a>
        <a href="#sobre">{{ __('landpage.about') }}</a>
        <a href="#equipe">{{ __('landpage.team') }}</a>
      </div>

      <!-- Botões e seletor de idioma -->
      <div class="nav-actions">
        <a href="{{ route('login') }}" class="btn-outline">{{ __('landpage.login') }}</a>

        @php $current = app()->getLocale(); @endphp
        <div class="lang-switch">
          <button class="lang-btn" id="lang-btn">
            <img class="lang-flag" src="{{ asset($current == 'en' ? 'images/us.png' : 'images/brazil.png') }}" width="20" alt="flag">
            <span class="lang-label">
              {{ $current == 'en' ? 'English' : 'Português' }}
            </span>
            <i class="fas fa-caret-down"></i>
          </button>

          <div class="lang-dropdown" id="lang-dropdown">
            <a class="lang-option" href="{{ route('lang.switch', 'pt_BR') }}">
              <img src="{{ asset('images/brazil.png') }}" width="20" alt="pt">
              Português
            </a>
            <a class="lang-option" href="{{ route('lang.switch', 'en') }}">
              <img src="{{ asset('images/us.png') }}" width="20" alt="en">
              English
            </a>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <section class="hero" id="home">
    <img src="{{ asset('images/landpage-hero.png') }}" alt="Estoque organizado" class="hero-bg">
    <div class="hero-content">
      <h1>{{ __('landpage.hero_title') }} <span>ARGUS</span></h1>
      <p>{{ __('landpage.hero_subtitle') }}</p>
      <a href="#planos" class="btn">{{ __('landpage.see_plans') }}</a>
    </div>
  </section>

  <section class="planos" id="planos">
    <h2 data-aos="fade-up" data-aos-duration="800">{{ __('landpage.our_plans') }}</h2>
    <p class="section-subtitle" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
      {{ __('landpage.plans_description') }}
    </p>
    <div class="cards-container">
      <div class="card" data-aos="fade-up" data-aos-delay="100" data-aos-duration="800">
        <h3>{{ __('landpage.basic_plan') }}</h3>
        <div class="preco">R$ 19,90<span>/mês</span></div>
        <div class="periodo">{{ __('landpage.ideal_for_small_business') }}</div>
        <ul>
          <li>{{ __('landpage.feature_stock_control') }}</li>
          <li>{{ __('landpage.feature_automated_supplier') }}</li>
          <li>{{ __('landpage.feature_label_emission') }}</li>
          <li>{{ __('landpage.feature_in_out_control') }}</li>
          <li>{{ __('landpage.feature_pos') }}</li>
        </ul>
        <a class="btn-plano" href="{{ route('login') }}?plano=basico">{{ __('landpage.subscribe') }}</a>
      </div>

      <div class="card em-desenvolvimento" data-aos="fade-up" data-aos-delay="200" data-aos-duration="800">
        <h3>{{ __('landpage.professional_plan') }}</h3>
        <div class="em-dev-content">
          <i class="fas fa-question-circle"></i>
          <h4>{{ __('landpage.plan_under_development') }}</h4>
          <p>{{ __('landpage.plan_development_description') }}</p>
          <a href="#" class="btn-plano em-dev-btn">{{ __('landpage.learn_more') }}</a>
        </div>
      </div>

      <div class="card em-desenvolvimento" data-aos="fade-up" data-aos-delay="300" data-aos-duration="800">
        <h3>{{ __('landpage.enterprise_plan') }}</h3>
        <div class="em-dev-content">
          <i class="fas fa-question-circle"></i>
          <h4>{{ __('landpage.plan_under_development') }}</h4>
          <p>{{ __('landpage.plan_development_description') }}</p>
          <a href="#" class="btn-plano em-dev-btn">{{ __('landpage.learn_more') }}</a>
        </div>
      </div>
    </div>
  </section>

  <div class="modal" id="dev-modal">
    <div class="modal-content">
      <span class="close-modal" id="close-modal">&times;</span>
      <i class="fas fa-exclamation-triangle"></i>
      <h3>{{ __('landpage.plan_under_development') }}</h3>
      <p>{{ __('landpage.modal_development_text1') }}</p>
      <p>{{ __('landpage.modal_development_text2') }}</p>
      <a href="mailto:argontechsolut@gmail.com?subject=Informações%20sobre%20plano%20em%20desenvolvimento" class="btn" id="contact-btn">
        {{ __('landpage.contact_us') }}
      </a>
    </div>
  </div>

  <section class="features" id="features">
    <div class="features-container">
      <h2 data-aos="fade-up" data-aos-duration="800">{{ __('landpage.our_features') }}</h2>
      <p class="section-subtitle" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
        {{ __('landpage.features_description') }}
      </p>

      <div class="features-grid">
        <div class="feature-item" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-icon">
            <i class="fas fa-boxes"></i>
          </div>
          <h3>{{ __('landpage.feature1_title') }}</h3>
          <p>{{ __('landpage.feature1_description') }}</p>
        </div>

        <div class="feature-item" data-aos="fade-up" data-aos-delay="200">
          <div class="feature-icon">
            <i class="fas fa-chart-line"></i>
          </div>
          <h3>{{ __('landpage.feature2_title') }}</h3>
          <p>{{ __('landpage.feature2_description') }}</p>
        </div>

        <div class="feature-item" data-aos="fade-up" data-aos-delay="300">
          <div class="feature-icon">
            <i class="fas fa-bell"></i>
          </div>
          <h3>{{ __('landpage.feature3_title') }}</h3>
          <p>{{ __('landpage.feature3_description') }}</p>
        </div>

        <div class="feature-item" data-aos="fade-up" data-aos-delay="100">
          <div class="feature-icon">
            <i class="fas fa-paper-plane"></i>
          </div>
          <h3>{{ __('landpage.feature4_title') }}</h3>
          <p>{{ __('landpage.feature4_description') }}</p>
        </div>

        <div class="feature-item" data-aos="fade-up" data-aos-delay="200">
          <div class="feature-icon">
            <i class="fas fa-tags"></i>
          </div>
          <h3>{{ __('landpage.feature5_title') }}</h3>
          <p>{{ __('landpage.feature5_description') }}</p>
        </div>

        <div class="feature-item" data-aos="fade-up" data-aos-delay="300">
          <div class="feature-icon">
            <i class="fas fa-lock"></i>
          </div>
          <h3>{{ __('landpage.feature6_title') }}</h3>
          <p>{{ __('landpage.feature6_description') }}</p>
        </div>
      </div>
    </div>
  </section>

  <section class="parceiros" id="parceiros">
    <div class="parceiros-container">
      <h2 data-aos="fade-up" data-aos-duration="800">{{ __('landpage.our_partners') }}</h2>
      <p class="section-subtitle" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
        {{ __('landpage.partners_description') }}
      </p>

      <div class="carrossel-parceiros">
        <div class="carrossel-track">
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa1.png') }}" alt="Empresa 1">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa2.png') }}" alt="Empresa 2">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa3.png') }}" alt="Empresa 3">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa1.png') }}" alt="Empresa 1">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa2.png') }}" alt="Empresa 2">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa3.png') }}" alt="Empresa 3">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa1.png') }}" alt="Empresa 1">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa2.png') }}" alt="Empresa 2">
          </div>

          <div class="carrossel-item">
            <img src="{{ asset('images/empresa3.png') }}" alt="Empresa 3">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa1.png') }}" alt="Empresa 1">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa2.png') }}" alt="Empresa 2">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa3.png') }}" alt="Empresa 3">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa1.png') }}" alt="Empresa 1">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa2.png') }}" alt="Empresa 2">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa3.png') }}" alt="Empresa 3">
          </div>
          <div class="carrossel-item">
            <img src="{{ asset('images/empresa1.png') }}" alt="Empresa 1">
          </div>
        </div>
      </div>

      <div class="carrossel-controls">
        <button class="carrossel-btn" id="play-pause-btn">
          <i class="fas fa-pause"></i>
        </button>
      </div>
    </div>
  </section>

  <section class="sobre-nos" id="sobre">
    <div class="sobre-container" data-aos="fade-up" data-aos-duration="1000">
      <h2>{{ __('landpage.about_us') }}</h2>
      <p>{{ __('landpage.about_text1') }}</p>
      <p>{{ __('landpage.about_text2') }}</p>
      <p>{{ __('landpage.about_text3') }}</p>
    </div>
  </section>

  <section class="equipe" id="equipe">
    <div class="container">
      <h2>{{ __('landpage.our_team') }}</h2>

      <div class="integrante">
        <div class="integrante-img">
          <img src="{{ asset('images/ana.jpeg') }}" alt="Ana Maria Costa Lima">
        </div>
        <div class="integrante-info">
          <h3>Ana Maria Costa Lima</h3>
          <span class="cargo">{{ __('landpage.role_developer') }}</span>
          <p>{{ __('landpage.ana_description') }}</p>
          <div class="social-links">
            <a href="https://www.linkedin.com/in/anamaria-costalima/"><i class="fab fa-linkedin"></i></a>
            <a href="https://github.com/Anawk"><i class="fab fa-github"></i></a>
          </div>
        </div>
      </div>

      <div class="integrante">
        <div class="integrante-img">
          <img src="{{ asset('images/brenda.jpg') }}" alt="Brenda Giron Barbosa">
        </div>
        <div class="integrante-info">
          <h3>Brenda Giron Barbosa</h3>
          <span class="cargo">{{ __('landpage.role_developer') }}</span>
          <p>{{ __('landpage.brenda_description') }}</p>
          <div class="social-links">
            <a href="https://www.linkedin.com/in/brenda-giron/"><i class="fab fa-linkedin"></i></a>
            <a href="https://github.com/brendagiron"><i class="fab fa-github"></i></a>
          </div>
        </div>
      </div>

      <div class="integrante">
        <div class="integrante-img">
          <img src="{{ asset('images/felipe.jpeg') }}" alt="Felipe Witkowsky Conelheiro">
        </div>
        <div class="integrante-info">
          <h3>Felipe Witkowsky Conelheiro</h3>
          <span class="cargo">{{ __('landpage.role_developer') }}</span>
          <p>{{ __('landpage.felipe_description') }}</p>
          <div class="social-links">
            <a href="#"><i class="fab fa-linkedin"></i></a>
            <a href="https://github.com/feehzinhowit"><i class="fab fa-github"></i></a>
          </div>
        </div>
      </div>

      <div class="integrante">
        <div class="integrante-img">
          <img src="{{ asset('images/gabriel.jpeg') }}" alt="Gabriel Luna Maia">
        </div>
        <div class="integrante-info">
          <h3>Gabriel Lua Maia</h3>
          <span class="cargo">{{ __('landpage.role_developer') }}</span>
          <p>{{ __('landpage.gabriel_description') }}</p>
          <div class="social-links">
            <a href="https://www.linkedin.com/in/gabriel-luna-2b20972a8/"><i class="fab fa-linkedin"></i></a>
            <a href="https://github.com/Gabriellluna"><i class="fab fa-github"></i></a>
          </div>
        </div>
      </div>

      <div class="integrante">
        <div class="integrante-img">
          <img src="{{ asset('images/gustavo.jpeg') }}" alt="Gustavo Emiliano de Jesus dos Santos">
        </div>
        <div class="integrante-info">
          <h3>Gustavo Emiliano de Jesus dos Santos</h3>
          <span class="cargo">{{ __('landpage.role_developer') }}</span>
          <p>{{ __('landpage.gustavo_description') }}</p>
          <div class="social-links">
            <a href="https://www.linkedin.com/in/gustavo-emiliano-936341294/"><i class="fab fa-linkedin"></i></a>
            <a href="https://github.com/GustavoEmiliano"><i class="fab fa-github"></i></a>
          </div>
        </div>
      </div>

      <div class="integrante">
        <div class="integrante-img">
          <img src="{{ asset('images/isabela.jpg') }}" alt="Isabela Crestane Cantaruti">
        </div>
        <div class="integrante-info">
          <h3>Isabela Crestane Cantaruti</h3>
          <span class="cargo">{{ __('landpage.role_developer') }}</span>
          <p>{{ __('landpage.isabela_description') }}</p>
          <div class="social-links">
            <a href="https://www.linkedin.com/in/isabela-crestane-7a1358304/"><i class="fab fa-linkedin"></i></a>
            <a href="https://github.com/isacrestane"><i class="fab fa-github"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <footer>
    <div class="footer-logo">ARGUS</div>
    <div class="footer-links">
      <a href="#home">{{ __('landpage.home') }}</a>
      <a href="#planos">{{ __('landpage.plans') }}</a>
      <a href="#features">{{ __('landpage.features') }}</a>
      <a href="#parceiros">{{ __('landpage.partners') }}</a>
      <a href="#sobre">{{ __('landpage.about') }}</a>
      <a href="#equipe">{{ __('landpage.team') }}</a>
      <a href="#" id="terms-link">{{ __('landpage.terms_of_use') }}</a>
      <a href="#" id="privacy-link">{{ __('landpage.privacy_policy') }}</a>
    </div>
    <div class="social-links-footer">
      <a href="#"><i class="fab fa-facebook"></i></a>
      <a href="#"><i class="fab fa-twitter"></i></a>
      <a href="#"><i class="fab fa-linkedin"></i></a>
      <a href="#"><i class="fab fa-instagram"></i></a>
      <a href="#"><i class="fab fa-youtube"></i></a>
    </div>
    <p class="copyright">&copy; Copyright 2025 - Argus Sistemas.</p>
    <p class="copyright">{{ __('landpage.all_rights_reserved') }}</p>
  </footer>

  <div class="terms-modal" id="terms-modal">
    <div class="terms-modal-content">
      <span class="close-terms-modal" id="close-terms-modal">&times;</span>
      <div class="terms-header">
        <h2 id="modal-title">{{ __('landpage.terms_of_use') }}</h2>
        <p class="subtitle" id="modal-subtitle">{{ __('landpage.last_update') }}</p>
      </div>
      <div class="terms-body" id="modal-text">
        <h3>{{ __('landpage.terms_section1_title') }}</h3>
        <p>{{ __('landpage.terms_section1_content') }}</p>

        <h3>{{ __('landpage.terms_section2_title') }}</h3>
        <p>{{ __('landpage.terms_section2_content') }}</p>
        <ul>
          <li>{{ __('landpage.terms_section2_item1') }}</li>
          <li>{{ __('landpage.terms_section2_item2') }}</li>
          <li>{{ __('landpage.terms_section2_item3') }}</li>
          <li>{{ __('landpage.terms_section2_item4') }}</li>
        </ul>

        <h3>{{ __('landpage.terms_section3_title') }}</h3>
        <p>{{ __('landpage.terms_section3_content') }}</p>

        <h3>{{ __('landpage.terms_section4_title') }}</h3>
        <p>{{ __('landpage.terms_section4_content') }}</p>

        <h3>{{ __('landpage.terms_section5_title') }}</h3>
        <p>{{ __('landpage.terms_section5_content') }}</p>

        <h3>{{ __('landpage.terms_section6_title') }}</h3>
        <p>{{ __('landpage.terms_section6_content') }}</p>

        <h3>{{ __('landpage.terms_section7_title') }}</h3>
        <p>{{ __('landpage.terms_section7_content') }}</p>
      </div>
      <div class="terms-footer">
        <p>&copy; Copyright 2025 - Argus Sistemas.</p>
        <p>{{ __('landpage.all_rights_reserved') }}</p>
      </div>
    </div>
  </div>

  <script src="{{ asset('js/landpage.js') }}"></script>
  <script src="{{ asset('js/lang-script.js') }}"></script>
  <script>
  window.translations = {
    'terms_of_use': "{{ __('landpage.terms_of_use') }}",
    'privacy_policy': "{{ __('landpage.privacy_policy') }}",
    'last_update': "{{ __('landpage.last_update') }}",
    'contact_us': "{{ __('landpage.contact_us') }}",
    'privacy_content': `{!! __('landpage.privacy_content') !!}`
  };
  </script>
</body>

</html>