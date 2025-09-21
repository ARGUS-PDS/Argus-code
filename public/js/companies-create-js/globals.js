// Variáveis globais de estado
let isCnpjValid = false;
let isPasswordValid = false;
let doPasswordsMatch = false;
let isEmailValid = false;
let isCepValid = false;

// Timeouts para APIs
let cnpjApiTimeout = null;
let cepApiTimeout = null;
let emailCheckTimeout = null;

// Estado dos campos obrigatórios
let requiredFieldsState = {
    cnpj: false,
    businessName: false,
    tradeName: false,
    cep: false,
    place: false,
    number: false,
    neighborhood: false,
    city: false,
    state: false,
    user_name: false,
    user_email: false,
    user_password: false,
    user_password_confirmation: false
};