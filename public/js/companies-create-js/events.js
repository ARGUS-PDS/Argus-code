// Função para verificar se todos os campos obrigatórios estão preenchidos
function checkRequiredFields() {
    for (const field in requiredFieldsState) {
        if (!requiredFieldsState[field]) {
            console.log(`Campo inválido: ${field}`, requiredFieldsState[field]);
            return false;
        }
    }
    return true;
}

// Função para verificar se todas as validações estão ok
function isFormValid() {
    const allValid =
        isCnpjValid &&
        isCepValid &&
        isEmailValid &&
        isPasswordValid &&
        doPasswordsMatch &&
        checkRequiredFields();

    console.log("Validações:", {
        isCnpjValid,
        isCepValid,
        isEmailValid,
        isPasswordValid,
        doPasswordsMatch,
        requiredFields: checkRequiredFields(),
        allValid,
    });

    return allValid;
}

// Função para atualizar o estado do botão de submit
function updateSubmitButton() {
    const submitButton = document.getElementById("submitButton");
    if (isFormValid()) {
        submitButton.disabled = false;
        submitButton.classList.remove("btn-disabled");
        submitButton.classList.add("btn-enabled");
    } else {
        submitButton.disabled = true;
        submitButton.classList.add("btn-disabled");
        submitButton.classList.remove("btn-enabled");
    }
}

// Função para validar o campo estado
function validateState() {
    const stateInput = document.getElementById("state");
    stateInput.classList.remove("is-valid", "is-invalid");

    if (stateInput.value) {
        stateInput.classList.add("is-valid");
        updateFieldState("state", true);
    } else {
        stateInput.classList.add("is-invalid");
        updateFieldState("state", false);
    }
}

// Função para validar inscrição estadual
function validateStateRegistration() {
    const ieInput = document.getElementById("stateRegistration");
    ieInput.classList.remove("is-valid", "is-invalid");

    if (ieInput.value.trim()) {
        ieInput.classList.add("is-valid");
        updateFieldState("stateRegistration", true);
    } else {
        ieInput.classList.add("is-invalid");
        updateFieldState("stateRegistration", false);
    }
}

// Função para validar campo obrigatório genérico
function validateFieldRequired(fieldElement, fieldId) {
    fieldElement.classList.remove("is-valid", "is-invalid");
    const isValid = fieldElement.value.trim().length > 0;

    if (isValid) {
        fieldElement.classList.add("is-valid");
    } else {
        fieldElement.classList.add("is-invalid");
    }

    updateFieldState(fieldId, isValid);
    updateSubmitButton();
}

// Função para validar campo em tempo real com debounce
function setupRealTimeValidation(
    fieldId,
    validationFn,
    delay = VALIDATION_DELAY
) {
    const field = document.getElementById(fieldId);
    if (!field) return;

    field.addEventListener("input", function () {
        // Limpa timeout anterior
        const timeoutVar = fieldId + "InputTimeout";
        if (window[timeoutVar]) {
            clearTimeout(window[timeoutVar]);
        }

        // Formatação básica e atualização visual imediata
        this.classList.remove("is-valid", "is-invalid");
        const hasValue = this.value.trim().length > 0;

        if (hasValue) {
            this.classList.add("is-valid");
        }

        updateFieldState(fieldId, hasValue);
        updateSubmitButton();

        // Agenda validação completa após o delay
        window[timeoutVar] = setTimeout(() => {
            validationFn(false); // false = não forçar validação completa
        }, delay);
    });

    // Mantém o blur para validação forçada
    field.addEventListener("blur", function () {
        validationFn(true); // true = forçar validação completa
    });
}

// Função para monitorar modificações do usuário nos campos auto-preenchidos
function setupAutoFillMonitoring() {
    const autoFillFields = [
        "businessName",
        "tradeName",
        "place",
        "neighborhood",
        "city",
        "state",
    ];

    autoFillFields.forEach((fieldId) => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener("input", function () {
                // Remove a flag de auto-preenchido se o usuário modificar
                if (this.dataset.autoFilled === "true") {
                    this.dataset.autoFilled = "false";
                }

                // Validação básica em tempo real
                validateFieldRequired(this, fieldId);
            });
        }
    });
}

// Função para configurar limpeza automática de campos relacionados
function setupAutoClearFields() {
    // Quando CNPJ é alterado significativamente, limpa campos da empresa
    document.getElementById("cnpj").addEventListener("input", function () {
        const cnpjDigits = this.value.replace(/\D/g, "");
        if (cnpjDigits.length < 14) {
            clearCompanyFields();
        }
    });

    // Quando CEP é alterado significativamente, limpa campos de endereço
    document.getElementById("cep").addEventListener("input", function () {
        const cepDigits = this.value.replace(/\D/g, "");
        if (cepDigits.length < 8) {
            clearAddressFields();
        }
    });
}

// Inicializar a validação visual dos campos
function initializeValidation() {
    // Validar todos os campos ao carregar a página
    const allFields = [
        "cnpj",
        "businessName",
        "tradeName",
        "stateRegistration",
        "cep",
        "place",
        "number",
        "neighborhood",
        "city",
        "state",
        "user_name",
        "user_email",
        "user_password",
        "user_password_confirmation",
    ];

    allFields.forEach((field) => {
        const element = document.getElementById(field);
        if (element) {
            element.classList.remove("is-invalid", "is-valid");
            if (element.value.trim()) {
                element.classList.add("is-valid");
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

    // Validar inscrição estadual
    validateStateRegistration();

    // Atualizar botão de submit
    updateSubmitButton();
}

// Função para lidar com o submit do formulário
async function handleFormSubmit(e) {
    e.preventDefault();

    console.log("Iniciando validação do formulário...");

    // Forçar validação de todos os campos
    validateStateRegistration();
    validateState();

    // Validar campos de texto obrigatórios
    const textFields = [
        "businessName",
        "tradeName",
        "stateRegistration",
        "place",
        "number",
        "neighborhood",
        "city",
        "user_name",
    ];

    textFields.forEach((field) => {
        const element = document.getElementById(field);
        validateFieldRequired(element, field);
    });

    // Validar senha
    checkPasswordStrength(document.getElementById("user_password").value);
    checkPasswordMatch();

    // Validações de API (forçadas)
    const apiValidations = [];
    apiValidations.push(validateCNPJ(true));
    apiValidations.push(validateCEP(true));
    apiValidations.push(validateEmail(true));

    try {
        await Promise.all(apiValidations);
    } catch (error) {
        console.error("Erro nas validações assíncronas:", error);
    }

    // Verificar se o formulário está válido após todas as validações
    if (!isFormValid()) {
        showJsError(
            "Por favor, preencha todos os campos obrigatórios corretamente."
        );

        // Rolar até o primeiro campo inválido
        const firstInvalid = document.querySelector(".is-invalid");
        if (firstInvalid) {
            firstInvalid.scrollIntoView({
                behavior: "smooth",
                block: "center",
            });
            firstInvalid.focus();
        }
        return;
    }

    console.log("Formulário válido, submetendo...");
    mostrarTelaCarregando();
    e.target.submit();
}

// Atribuição de eventos e inicialização
document.addEventListener("DOMContentLoaded", function () {
    // Configura validação em tempo real para campos críticos
    setupRealTimeValidation("cnpj", validateCNPJ, 1000);
    setupRealTimeValidation("cep", validateCEP, 1000);
    setupRealTimeValidation("user_email", validateEmail, 700);

    // Monitora campos auto-preenchidos
    setupAutoFillMonitoring();

    // Configura limpeza automática de campos relacionados
    setupAutoClearFields();

    // Formatação automática mantida
    document.getElementById("cnpj").addEventListener("input", function () {
        this.value = formatCNPJ(this.value);
    });

    document.getElementById("cep").addEventListener("input", function () {
        this.value = formatCEP(this.value);
    });

    document
        .getElementById("stateRegistration")
        .addEventListener("input", function () {
            this.value = formatStateRegistration(this.value);
            validateFieldRequired(this, "stateRegistration");
        });

    document.getElementById("user_name").addEventListener("input", function () {
        this.value = formatName(this.value);
        validateFieldRequired(this, "user_name");
    });

    // Validação do campo número
    document.getElementById("number").addEventListener("input", function () {
        formatNumber(this);
        validateFieldRequired(this, "number");
    });

    // Configura validação para outros campos obrigatórios
    const requiredFields = [
        "businessName",
        "tradeName",
        "stateRegistration",
        "place",
        "number",
        "neighborhood",
        "city",
        "state",
    ];

    requiredFields.forEach((field) => {
        document.getElementById(field).addEventListener("input", function () {
            validateFieldRequired(this, field);
        });
    });

    // Listener para o campo de estado
    document.getElementById("state").addEventListener("change", function () {
        validateState();
    });

    // Validação de senha em tempo real
    document
        .getElementById("user_password")
        .addEventListener("input", function () {
            checkPasswordStrength(this.value);
            validateFieldRequired(this, "user_password");
        });

    document
        .getElementById("user_password_confirmation")
        .addEventListener("input", function () {
            checkPasswordMatch();
            validateFieldRequired(this, "user_password_confirmation");
        });

    // Inicializar a validação
    initializeValidation();

    // Modificar o evento de submit do formulário
    document
        .getElementById("companyForm")
        .addEventListener("submit", handleFormSubmit);

    // Adicionar evento para o botão de gerar senha (caso não esteja presente)
    const generatePasswordBtn = document.querySelector(".generate-password");
    if (generatePasswordBtn) {
        generatePasswordBtn.addEventListener("click", generateStrongPassword);
    }

    // Adicionar eventos para os toggle de password
    document.querySelectorAll(".toggle-password").forEach((icon) => {
        icon.addEventListener("click", function () {
            const inputId = this.closest(".password-container").querySelector(
                "input"
            ).id;
            togglePassword(inputId, this);
        });
    });
});

// Função auxiliar para mostrar loading (se não existir em utils.js)
function mostrarTelaCarregando() {
    const loadingElement = document.querySelector(".loading-screen");
    if (loadingElement) {
        loadingElement.style.display = "flex";
    }
}

// Função auxiliar para esconder loading (se não existir em utils.js)
function esconderTelaCarregando() {
    const loadingElement = document.querySelector(".loading-screen");
    if (loadingElement) {
        loadingElement.style.display = "none";
    }
}

// Adicionar tratamento de erro global para promises não capturadas
window.addEventListener("unhandledrejection", function (event) {
    console.error("Promise rejeitada não capturada:", event.reason);
    showJsError("Ocorreu um erro inesperado. Tente novamente.");
});

// Adicionar tratamento de erro global
window.addEventListener("error", function (event) {
    console.error("Erro global:", event.error);
    showJsError(
        "Ocorreu um erro inesperado. Atualize a página e tente novamente."
    );
});
