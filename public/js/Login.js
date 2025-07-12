const container = document.getElementById('container');
const btnEntrar = document.getElementById('entrar');
const btnRegistrar = document.getElementById('registrar');

btnRegistrar.addEventListener('click', () => {
  container.classList.add('active');
});

btnEntrar.addEventListener('click', () => {
  container.classList.remove('active');
});