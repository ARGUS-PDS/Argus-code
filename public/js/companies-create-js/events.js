// Função para verificar se todos os campos obrigatórios estão preenchidos
function checkRequiredFields() {
    for (const field in requiredFieldsState) {
        if (!requiredFieldsState[field]) {
            return false;
        }
    }
    return true;
}

// Função para verificar se todas as validações estão ok
function isFormValid() {
    return isCnpjValid && isCepValid && isEmailValid && isPasswordValid && doPasswordsMatch && checkRequiredFields();
}

// Função para atualizar o estado do botão de submit
function updateSubmitButton() {
    const submitButton = document.getElementById('submitButton');
    if (isFormValid()) {
        submitButton.disabled = false;
        submitButton.classList.remove('btn-disabled');
        submitButton.classList.add('btn-enabled');
    } else {
        submitButton.disabled = true;
        submitButton.classList.add('btn-disabled');
        submitButton.classList.remove('btn-enabled');
    }
}

// Função para validar o campo estado
function validateState() {
    const stateInput = document.getElementById("state");
    stateInput.classList.remove('is-valid', 'is-invalid');
    
    if (stateInput.value) {
        stateInput.classList.add('is-valid');
        updateFieldState('state', true);
    } else {
        stateInput.classList.add('is-invalid');
        updateFieldState('state', false);
    }
}

// Inicializar a validação visual dos campos
function initializeValidation() {
    // Validar todos os campos ao carregar a página
    const allFields = [
        'cnpj', 'businessName', 'tradeName', 'cep', 'place', 'number',
        'neighborhood', 'city', 'state', 'user_name', 'user_email',
        'user_password', 'user_password_confirmation'
    ];
    
    allFields.forEach(field => {
        const element = document.getElementById(field);
        if (element) {
            element.classList.remove('is-invalid', 'is-valid');
            if (element.value.trim()) {
                element.classList.add('is-valid');
                updateFieldState(field, true);
            } else {
                updateFieldState(field, false);
            }
        }
    });
    
    // Validar senha se já houver valor
    const password = document.getElementById("user_password").value;
    if (password) {
        checkPasswordStrength(password);
    }
    checkPasswordMatch();
    
    // Validar estado
    validateState();
}

// Atribuição de eventos e inicialização
document.addEventListener("DOMContentLoaded", function () {
    // Formatação automática de campos
    document.getElementById("cnpj").addEventListener("input", function () {
        this.value = formatCNPJ(this.value);
        this.classList.remove('is-valid', 'is-invalid');
        if (this.value.length > 0) {
            this.classList.add('is-valid');
        }
        updateFieldState('cnpj', this.value.length > 0);
    });

    document.getElementById("cep").addEventListener("input", function () {
        this.value = formatCEP(this.value);
        this.classList.remove('is-valid', 'is-invalid');
        if (this.value.length > 0) {
            this.classList.add('is-valid');
        }
        updateFieldState('cep', this.value.length > 0);
    });

    // Novos eventos de formatação
    document.getElementById("stateRegistration").addEventListener("input", function () {
        this.value = formatStateRegistration(this.value);
    });

    document.getElementById("user_name").addEventListener("input", function () {
        this.value = formatName(this.value);
        this.classList.remove('is-valid', 'is-invalid');
        if (this.value.length > 0) {
            this.classList.add('is-valid');
        }
        updateFieldState('user_name', this.value.length > 0);
    });

    // Validação do campo número
    document.getElementById("number").addEventListener("input", function () {
        formatNumber(this);
    });

    // Eventos de blur para validação
    document.getElementById("cnpj").addEventListener("blur", validateCNPJ);
    document.getElementById("cep").addEventListener("blur", validateCEP);
    document.getElementById("user_email").addEventListener("blur", validateEmail);

    // Validação em tempo real do email
    document.getElementById("user_email").addEventListener("input", function () {
        clearTimeout(emailCheckTimeout);
        emailCheckTimeout = setTimeout(validateEmail, 700);
        this.classList.remove('is-valid', 'is-invalid');
        if (this.value.length > 0) {
            this.classList.add('is-valid');
        }
        updateFieldState('user_email', this.value.length > 0);
    });

    // Validação de senha em tempo real
    document.getElementById("user_password").addEventListener("input", function () {
        checkPasswordStrength(this.value);
        this.classList.remove('is-valid', 'is-invalid');
        if (this.value.length > 0) {
            this.classList.add('is-valid');
        }
        updateFieldState('user_password', this.value.length > 0);
    });

    document
        .getElementById("user_password_confirmation")
        .addEventListener("input", function () {
            checkPasswordMatch();
            this.classList.remove('is-valid', 'is-invalid');
            if (this.value.length > 0) {
                this.classList.add('is-valid');
            }
            updateFieldState('user_password_confirmation', this.value.length > 0);
        });

    // Adicionar listeners para campos obrigatórios
    const requiredFields = [
        'businessName', 'tradeName', 'place', 'neighborhood',
        'city'
    ];
    
    requiredFields.forEach(field => {
        document.getElementById(field).addEventListener('input', function() {
            this.classList.remove('is-valid', 'is-invalid');
            if (this.value.trim()) {
                this.classList.add('is-valid');
            }
            updateFieldState(field, this.value.trim().length > 0);
        });
    });
    
    // Listener para o campo de estado
    document.getElementById('state').addEventListener('change', function() {
        validateState();
    });
    
    // Inicializar a validação
    initializeValidation();
    
    // Modificar o evento de submit do formulário
    document.getElementById("companyForm").addEventListener("submit", function (e) {
        // Forçar validação de todos os campos
        validateCNPJ();
        validateCEP();
        validateEmail();
        validateState();
        
        // Validar campos de texto
        const textFields = ['businessName', 'tradeName', 'place', 'number', 'neighborhood', 'city', 'user_name'];
        textFields.forEach(field => {
            const element = document.getElementById(field);
            element.classList.remove('is-invalid', 'is-valid');
            if (element.value.trim()) {
                element.classList.add('is-valid');
                updateFieldState(field, true);
            } else {
                element.classList.add('is-invalid');
                updateFieldState(field, false);
            }
        });
        
        // Validar senha
        checkPasswordStrength(document.getElementById("user_password").value);
        checkPasswordMatch();
        
        if (!isFormValid()) {
            e.preventDefault();
            showJsError("Por favor, preencha todos os campos obrigatórios corretamente.");
            
            // Rolar até o primeiro campo inválido
            const firstInvalid = document.querySelector('.is-invalid');
            if (firstInvalid) {
                firstInvalid.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
            return;
        }
        
        // Mostrar tela de carregamento se tudo estiver válido
        mostrarTelaCarregando();
    });
});