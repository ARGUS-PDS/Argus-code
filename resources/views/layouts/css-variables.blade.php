<style>
:root {
  --color-bege-card-interno: #fcf5ee;
  --color-bege-claro: #f8f0e5;
  --color-bege-claro-fundo: rgba(248, 240, 229, 0.5);
  --color-bege-medio: #C6A578;
  --color-bege-escuro: #8d6b48;

  --color-vinho: #773138;
  --color-vinho-claro: #490006;
  --color-vinho-fundo: rgba(119, 49, 56, 0.5);
  --color-vinho-fundo-transparente: rgba(119, 49, 56, 0.1);

  --bs-btn-hover-bg: #5f282e;
  --bs-alert-bg-success: #d4edda;
  --bs-alert-border-success: #c3e6cb;
  --bs-alert-bg-danger: #f8d7da;
  --bs-alert-border-danger: #f5c6cb;

  --color-white: #FFFFFF;
  --color-black: #000000;
  --color-gray: #767676;
  --color-gray-2: #5a6268;
  --color-gray-3: #545b62;
  --color-gray-claro: #f8f9fa;
  --color-gray-medio: #aaa;
  --color-gray-escuro: #202132;
  --color-border-table: rgba(221, 221, 221, 0.5);

  --color-shadow:rgba(0, 0, 0, 0.1);



  --color-green: #198754;
  --color-blue: #0d6efd;
  --color-red: #dc3545;

}

.dark-mode {
  --color-bege-card-interno: #490006;
  --color-bege-claro: #773138;
  --color-bege-claro-fundo: rgba(119, 49, 56, 0.5);
  --color-bege-medio: rgb(90, 36, 42);
  --color-bege-escuro: rgb(56, 0, 5);

  --color-vinho: #f8f0e5;
  --color-vinho-claro: #fcf5ee;
  --color-vinho-fundo: rgba(248, 240, 229, 0.5);
  --color-vinho-fundo-transparente: rgba(248, 240, 229, 0.1);

  --bs-btn-hover-bg: #f8f0e5;
  --bs-alert-bg-success: #d4edda;
  --bs-alert-border-success: #c3e6cb;
  --bs-alert-bg-danger: #f8d7da;
  --bs-alert-border-danger: #f5c6cb;

  --color-white: #000000;
  --color-black: #ffffff;
  --color-gray: #767676;
  --color-gray-2: #5a6268;
  --color-gray-3: #545b62;
  --color-gray-claro:  #202132;
  --color-gray-medio: #aaa;
  --color-gray-escuro: #f8f9fa;
  --color-border-table: rgba(221, 221, 221, 0.5);

  --color-shadow:rgba(255, 255, 255, 0.1);


  --color-green:rgb(72, 223, 152);
  --color-blue:rgb(71, 145, 255);
  --color-red:rgb(255, 97, 113);

  /* Manter inputs com cores claras no dark mode */
  --bs-body-bg: #ffffff;
  --bs-body-color: #000000;
  --bs-border-color: #ced4da;
}

/* Estilos específicos para inputs no dark mode - excluindo barra de pesquisa */
.dark-mode .form-control:not(.search-bar input),
.dark-mode .form-select,
.dark-mode input[type="text"]:not(.search-bar input),
.dark-mode input[type="number"],
.dark-mode input[type="email"],
.dark-mode input[type="password"],
.dark-mode input[type="tel"],
.dark-mode input[type="date"],
.dark-mode textarea,
.dark-mode select {
  background-color: #ffffff !important;
  color: #000000 !important;
  border-color: #ced4da !important;
}

.dark-mode .form-control:focus:not(.search-bar input),
.dark-mode .form-select:focus,
.dark-mode input:focus:not(.search-bar input),
.dark-mode textarea:focus,
.dark-mode select:focus {
  background-color: #ffffff !important;
  color: #000000 !important;
  border-color: #773138 !important;
  box-shadow: 0 0 0 0.2rem rgba(119, 49, 56, 0.25) !important;
}

.dark-mode .form-control::placeholder:not(.search-bar input),
.dark-mode input::placeholder:not(.search-bar input),
.dark-mode textarea::placeholder {
  color: #6c757d !important;
}
</style>