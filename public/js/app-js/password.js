// Variáveis globais para controle de validação
let isPasswordValid = false;
let doPasswordsMatch = false;

// Controlar o backdrop personalizado
const modal = document.getElementById("modalAlterarSenha");
const backdrop = document.getElementById("modalBackdrop");

// Função para mostrar o toast de sucesso
function showToast(message = window.translations.password_generated) {
    const toast = document.getElementById('passwordSuccessToast');
    const toastMessage = document.getElementById('toastMessage');
    
    toastMessage.textContent = message;
    toast.classList.add('show');
    
    // Auto-esconder após 5 segundos
    setTimeout(() => {
        hideToast();
    }, 5000);
}

// Função para esconder o toast
function hideToast() {
    const toast = document.getElementById('passwordSuccessToast');
    toast.classList.remove('show');
}

// Inicialização quando o modal é aberto
if (modal) {
    modal.addEventListener("show.bs.modal", function() {
        document.body.classList.add("modal-open");
        if (backdrop) backdrop.classList.add("show");
    });

    modal.addEventListener("hidden.bs.modal", function() {
        document.body.classList.remove("modal-open");
        if (backdrop) backdrop.classList.remove("show");
    });
}

// Função para atualizar o estado do botão de envio
function updateSubmitButton() {
    const submitButton = document.getElementById("submitButton");
    if (submitButton) {
        submitButton.disabled = !(isPasswordValid && doPasswordsMatch);
    }
}

// Função para alternar a visibilidade da senha
function togglePassword(iconElement) {
    const input = iconElement.parentElement.querySelector("input");
    if (input.type === "password") {
        input.type = "text";
        iconElement.classList.replace("bi-eye", "bi-eye-slash");
    } else {
        input.type = "password";
        iconElement.classList.replace("bi-eye-slash", "bi-eye");
    }
}

// Função para verificar a força da senha
function checkPasswordStrength() {
    const password = document.getElementById("new_password").value;
    const hasMinLength = password.length >= 8;
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password);

    // Atualizar os requisitos
    updateRequirement("lengthReq", hasMinLength);
    updateRequirement("uppercaseReq", hasUpperCase);
    updateRequirement("lowercaseReq", hasLowerCase);
    updateRequirement("numberReq", hasNumber);
    updateRequirement("specialReq", hasSpecialChar);

    // Calcular força da senha
    const strength = (hasMinLength + hasUpperCase + hasLowerCase + hasNumber + hasSpecialChar) * 20;
    const strengthBar = document.getElementById("passwordStrengthBar");
    const feedbackElement = document.getElementById("passwordFeedback");

    if (strengthBar) strengthBar.style.width = strength + "%";

    if (feedbackElement) {
        if (strength < 40) {
            feedbackElement.textContent = window.translations.password_strength_weak;
            feedbackElement.className = "password-feedback weak";
            if (strengthBar) strengthBar.className = "progress-bar bg-danger";
        } else if (strength < 100) {
            feedbackElement.textContent = window.translations.password_strength_medium;
            feedbackElement.className = "password-feedback medium";
            if (strengthBar) strengthBar.className = "progress-bar bg-warning";
        } else {
            feedbackElement.textContent = window.translations.password_strength_strong;
            feedbackElement.className = "password-feedback strong";
            if (strengthBar) strengthBar.className = "progress-bar bg-success";
        }
    }

    isPasswordValid = hasMinLength && hasUpperCase && hasLowerCase && hasNumber && hasSpecialChar;

    // Ativar/desativar a classe de validação para a transição
    const container = document.getElementById("newPasswordContainer");
    if (container) {
        if (password.length > 0) {
            container.classList.add("validating");
        } else {
            container.classList.remove("validating");
        }
    }

    // Atualizar o ícone de validação
    const validationIcon = document.getElementById("new_password_validation");
    if (validationIcon) {
        validationIcon.innerHTML = "";

        if (password.length === 0) {
            // Campo vazio - não mostrar ícone
        } else if (isPasswordValid) {
            validationIcon.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
        } else {
            validationIcon.innerHTML = '<i class="bi bi-x-circle-fill text-danger"></i>';
        }
    }

    // Verificar também se as senhas coincidem quando a senha principal é alterada
    checkPasswordMatch();

    // Atualizar o botão de envio
    updateSubmitButton();
}

// Função para atualizar o visual dos requisitos
function updateRequirement(elementId, isValid) {
    const element = document.getElementById(elementId);
    if (element) {
        const icon = element.querySelector("i");
        if (isValid) {
            element.classList.remove("invalid");
            element.classList.add("valid");
            icon.classList.remove("bi-x-circle");
            icon.classList.add("bi-check-circle");
        } else {
            element.classList.remove("valid");
            element.classList.add("invalid");
            icon.classList.remove("bi-check-circle");
            icon.classList.add("bi-x-circle");
        }
    }
}

// Função para verificar se as senhas coincidem
function checkPasswordMatch() {
    const password = document.getElementById("new_password").value;
    const confirmPassword = document.getElementById("new_password_confirmation").value;
    const matchFeedback = document.getElementById("passwordMatchFeedback");

    // Ativar/desativar a classe de validação para a transição
    const container = document.getElementById("confirmPasswordContainer");
    if (container) {
        if (confirmPassword.length > 0) {
            container.classList.add("validating");
        } else {
            container.classList.remove("validating");
        }
    }

    // Atualizar ícone de validação
    const validationIcon = document.getElementById("confirm_password_validation");
    if (validationIcon) {
        validationIcon.innerHTML = "";

        if (confirmPassword === "") {
            if (matchFeedback) matchFeedback.style.display = "none";
            doPasswordsMatch = false;
        } else if (password === confirmPassword) {
            if (matchFeedback) {
                matchFeedback.textContent = window.translations.password_match;
                matchFeedback.classList.remove("invalid");
                matchFeedback.classList.add("valid");
                matchFeedback.style.display = "block";
            }
            doPasswordsMatch = true;
            validationIcon.innerHTML = '<i class="bi bi-check-circle-fill text-success"></i>';
        } else {
            if (matchFeedback) {
                matchFeedback.textContent = window.translations.password_mismatch;
                matchFeedback.classList.remove("valid");
                matchFeedback.classList.add("invalid");
                matchFeedback.style.display = "block";
            }
            doPasswordsMatch = false;
            validationIcon.innerHTML = '<i class="bi bi-x-circle-fill text-danger"></i>';
        }
    }

    // Atualizar o botão de envio
    updateSubmitButton();
}

// Função para gerar uma senha forte
function generateStrongPassword() {
    const length = 12;
    const uppercase = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    const lowercase = "abcdefghijklmnopqrstuvwxyz";
    const numbers = "0123456789";
    const symbols = "!@#$%^&*()_+-=[]{}|;:,.<>?";

    let password = "";
    password += uppercase[Math.floor(Math.random() * uppercase.length)];
    password += lowercase[Math.floor(Math.random() * lowercase.length)];
    password += numbers[Math.floor(Math.random() * numbers.length)];
    password += symbols[Math.floor(Math.random() * symbols.length)];

    const allChars = uppercase + lowercase + numbers + symbols;
    for (let i = password.length; i < length; i++) {
        password += allChars[Math.floor(Math.random() * allChars.length)];
    }

    password = password
        .split("")
        .sort(() => Math.random() - 0.5)
        .join("");

    // Atualiza o campo de senha
    const passwordField = document.getElementById("new_password");
    if (passwordField) {
        passwordField.value = password;
        passwordField.type = "text";
    }

    // Atualiza o campo de confirmação de senha
    const confirmField = document.getElementById("new_password_confirmation");
    if (confirmField) {
        confirmField.value = password;
        confirmField.type = "text";
    }

    // Atualizar os ícones de olho
    const eyeIcons = document.querySelectorAll(".toggle-password");
    eyeIcons.forEach((icon) => {
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    });

    // Atualizar a força da senha
    checkPasswordStrength();

    // Mostrar mensagem de sucesso estilizada
    showToast();
}

// Validar formulário antes de enviar
const formAlterarSenha = document.getElementById("formAlterarSenha");
if (formAlterarSenha) {
    formAlterarSenha.addEventListener("submit", function(e) {
        if (!isPasswordValid || !doPasswordsMatch) {
            e.preventDefault();
            showToast(window.translations.password_invalid);
        }
    });
}

// Inicializar a validação quando o modal for aberto
if (modal) {
    modal.addEventListener("show.bs.modal", function() {
        checkPasswordStrength();
        checkPasswordMatch();
    });
}

// Resetar validação quando o modal for fechado
if (modal) {
    modal.addEventListener("hidden.bs.modal", function() {
        // Limpar campos
        const form = document.getElementById("formAlterarSenha");
        if (form) form.reset();

        // Resetar validação
        const newPasswordContainer = document.getElementById("newPasswordContainer");
        const confirmPasswordContainer = document.getElementById("confirmPasswordContainer");
        const strengthBar = document.getElementById("passwordStrengthBar");
        const feedbackElement = document.getElementById("passwordFeedback");
        const matchFeedback = document.getElementById("passwordMatchFeedback");
        const submitButton = document.getElementById("submitButton");

        if (newPasswordContainer) newPasswordContainer.classList.remove("validating");
        if (confirmPasswordContainer) confirmPasswordContainer.classList.remove("validating");
        if (strengthBar) strengthBar.style.width = "0%";
        if (feedbackElement) {
            feedbackElement.textContent = window.translations.password_strength_very_weak;
            feedbackElement.className = "password-feedback";
        }
        if (matchFeedback) matchFeedback.style.display = "none";
        if (submitButton) submitButton.disabled = true;

        // Limpar ícones de validação
        const newPasswordValidation = document.getElementById("new_password_validation");
        const confirmPasswordValidation = document.getElementById("confirm_password_validation");
        
        if (newPasswordValidation) newPasswordValidation.innerHTML = "";
        if (confirmPasswordValidation) confirmPasswordValidation.innerHTML = "";

        // Resetar requisitos
        document.querySelectorAll(".requirement").forEach((req) => {
            req.classList.remove("valid");
            req.classList.add("invalid");
            const icon = req.querySelector("i");
            if (icon) {
                icon.classList.remove("bi-check-circle");
                icon.classList.add("bi-x-circle");
            }
        });
    });
}
