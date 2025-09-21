// Funções para gerenciamento de senhas
function togglePassword(inputId, iconElement) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        iconElement.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        input.type = "password";
        iconElement.classList.replace("fa-eye-slash", "fa-eye");
    }
}

function checkPasswordStrength(password) {
    const hasMinLength = password.length >= 8;
    const hasUpperCase = /[A-Z]/.test(password);
    const hasLowerCase = /[a-z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(
        password
    );

    updateRequirement("lengthReq", hasMinLength);
    updateRequirement("uppercaseReq", hasUpperCase);
    updateRequirement("lowercaseReq", hasLowerCase);
    updateRequirement("numberReq", hasNumber);
    updateRequirement("specialReq", hasSpecialChar);

    const strength =
        (hasMinLength +
            hasUpperCase +
            hasLowerCase +
            hasNumber +
            hasSpecialChar) *
        20;
    const strengthBar = document.getElementById("passwordStrengthBar");
    const feedbackElement = document.getElementById("passwordFeedback");

    strengthBar.style.width = strength + "%";

    if (strength < 40) {
        feedbackElement.textContent = "Força da senha: fraca";
        strengthBar.className = "progress-bar bg-danger";
        feedbackElement.style.color = "#212529bf";
    } else if (strength < 100) {
        feedbackElement.textContent = "Força da senha: média";
        strengthBar.className = "progress-bar bg-warning";
        feedbackElement.style.color = "#212529bf";
    } else {
        feedbackElement.textContent = "Força da senha: forte";
        feedbackElement.style.color = "#198754";
        strengthBar.className = "progress-bar bg-success";
    }

    isPasswordValid =
        hasMinLength &&
        hasUpperCase &&
        hasLowerCase &&
        hasNumber &&
        hasSpecialChar;

    // Atualizar a classe do campo de senha
    const passwordField = document.getElementById("user_password");
    passwordField.classList.remove('is-valid', 'is-invalid');
    if (isPasswordValid) {
        passwordField.classList.add('is-valid');
    } else if (password.length > 0) {
        passwordField.classList.add('is-invalid');
    }

    updateFieldState('user_password', isPasswordValid);

    // Verificar também se as senhas coincidem quando a senha principal é alterada
    checkPasswordMatch();
}

function updateRequirement(elementId, isValid) {
    const element = document.getElementById(elementId);
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

// Função para verificar se as senhas coincidem
function checkPasswordMatch() {
    const password = document.getElementById("user_password").value;
    const confirmPassword = document.getElementById(
        "user_password_confirmation"
    ).value;
    const feedbackElement = document.getElementById("passwordMatchFeedback");

    // Atualizar classes de validação
    const confirmField = document.getElementById("user_password_confirmation");
    confirmField.classList.remove('is-valid', 'is-invalid');

    if (confirmPassword === "") {
        feedbackElement.style.display = "none";
        doPasswordsMatch = false;
        updateFieldState('user_password_confirmation', false);
    } else if (password === confirmPassword) {
        feedbackElement.textContent = "As senhas coincidem";
        feedbackElement.classList.remove("invalid");
        feedbackElement.classList.add("valid");
        feedbackElement.style.display = "block";
        doPasswordsMatch = true;
        confirmField.classList.add('is-valid');
        updateFieldState('user_password_confirmation', true);
    } else {
        feedbackElement.textContent = "As senhas não coincidem";
        feedbackElement.classList.remove("valid");
        feedbackElement.classList.add("invalid");
        feedbackElement.style.display = "block";
        doPasswordsMatch = false;
        confirmField.classList.add('is-invalid');
        updateFieldState('user_password_confirmation', false);
    }
}

// Função para gerar senha forte
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
    const passwordField = document.getElementById("user_password");
    passwordField.value = password;
    passwordField.dispatchEvent(new Event("input"));

    // Atualiza o campo de confirmação de senha
    const confirmField = document.getElementById("user_password_confirmation");
    confirmField.value = password;
    confirmField.dispatchEvent(new Event("input"));

    showJsError("Senha forte gerada com sucesso!", 3000);
}