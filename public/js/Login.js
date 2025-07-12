const container = document.getElementById('container');
const btnEntrar = document.getElementById('entrar');
const btnRegistrar = document.getElementById('registrar');

btnRegistrar.addEventListener('click', () => {
  container.classList.add('active');
});

btnEntrar.addEventListener('click', () => {
  container.classList.remove('active');
});


document.getElementById('whatsapp').addEventListener('input', function (e) {
  let value = e.target.value.replace(/\D/g, '');
  if (value.length > 2) {
    value = `(${value.substring(0, 2)}) ${value.substring(2)}`;
  }
  if (value.length > 10) {
    value = `${value.substring(0, 10)}-${value.substring(10, 14)}`;
  }
  e.target.value = value;
});