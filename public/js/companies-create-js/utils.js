// Funções de formatação
function formatCNPJ(cnpj) {
    cnpj = cnpj.replace(/\D/g, "");
    cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2");
    cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
    cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2");
    cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2");
    return cnpj.substring(0, 18);
}

function formatCEP(cep) {
    cep = cep.replace(/\D/g, "");
    if (cep.length > 5) {
        cep = cep.replace(/^(\d{5})(\d)/, "$1-$2");
    }
    return cep.substring(0, 9);
}

// Função para formatar Inscrição Estadual (permite números, pontos, barras e hífen)
function formatStateRegistration(ie) {
    return ie.replace(/[^\d\.\/\-]/g, "").substring(0, 15);
}

// Função para validar e formatar nome (apenas letras e espaços)
function formatName(name) {
    return name.replace(/[^A-Za-zÀ-ÿ\s]/g, "");
}

// Função para validar o campo número (apenas números e máximo de 10 dígitos)
function formatNumber(input) {
    // Remove caracteres não numéricos
    input.value = input.value.replace(/\D/g, "");

    // Limita a 10 dígitos
    if (input.value.length > 10) {
        input.value = input.value.substring(0, 10);
    }

    // Atualiza o estado do campo
    updateFieldState("number", input.value.length > 0);
    // Atualiza a classe de validação
    input.classList.remove("is-valid", "is-invalid");
    if (input.value.length > 0) {
        input.classList.add("is-valid");
    }
}

// Funções de validação de formato
function isValidCNPJFormat(cnpj) {
    return /^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/.test(cnpj);
}

function isValidCEPFormat(cep) {
    return /^\d{5}-\d{3}$/.test(cep);
}

function isValidEmailFormat(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

// Validação algorítmica do CNPJ
function isValidCNPJ(cnpj) {
    cnpj = cnpj.replace(/[^\d]+/g, "");

    if (cnpj.length !== 14 || /^(\d)\1+$/.test(cnpj)) return false;

    let length = cnpj.length - 2;
    let numbers = cnpj.substring(0, length);
    let digits = cnpj.substring(length);
    let sum = 0;
    let pos = length - 7;

    for (let i = length; i >= 1; i--) {
        sum += numbers.charAt(length - i) * pos--;
        if (pos < 2) pos = 9;
    }

    let result = sum % 11 < 2 ? 0 : 11 - (sum % 11);
    if (result !== parseInt(digits.charAt(0))) return false;

    length = length + 1;
    numbers = cnpj.substring(0, length);
    sum = 0;
    pos = length - 7;

    for (let i = length; i >= 1; i--) {
        sum += numbers.charAt(length - i) * pos--;
        if (pos < 2) pos = 9;
    }

    result = sum % 11 < 2 ? 0 : 11 - (sum % 11);
    if (result !== parseInt(digits.charAt(1))) return false;

    return true;
}

// Validações de campos
function validarNumero(input) {
    if (input.value < 0) {
        input.value = 0;
    }
}

// Atualizar estado do campo
function updateFieldState(fieldName, isValid) {
    requiredFieldsState[fieldName] = isValid;
    updateSubmitButton();
}
