let isCnpjValid = false;
let isPasswordValid = false;
let doPasswordsMatch = false;
let isEmailValid = false;
let isCepValid = false;
let cnpjApiTimeout = null;
let cepApiTimeout = null;
let emailCheckTimeout = null;

function showJsError(message, duration = 5000) {
    const container = document.getElementById("jsErrorContainer");
    const msg = document.getElementById("jsErrorMessage");
    msg.textContent = message;
    container.classList.remove("d-none");
    setTimeout(() => container.classList.add("alert-show"), 50);
    setTimeout(() => {
        container.classList.remove("alert-show");
        setTimeout(() => container.classList.add("d-none"), 600);
    }, duration);
}

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

    // Calcula a força baseada em quantos critérios foram atendidos
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

    // Atualiza a cor e o texto com base na força
    if (strength < 40) {
        feedbackElement.textContent = "Força da senha: fraca";
        strengthBar.className = "progress-bar bg-danger";
    } else if (strength < 100) {
        feedbackElement.textContent = "Força da senha: média";
        strengthBar.className = "progress-bar bg-warning";
    } else {
        feedbackElement.textContent = "Força da senha: forte";
        feedbackElement.style.color = "#198754"
        strengthBar.className = "progress-bar bg-success";
    }

    // A senha só é válida se atender a TODOS os requisitos
    isPasswordValid =
        hasMinLength &&
        hasUpperCase &&
        hasLowerCase &&
        hasNumber &&
        hasSpecialChar;

    // Verifica se as senhas coincidem
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

function checkPasswordMatch() {
    const password = document.getElementById("user_password").value;
    const confirmPassword = document.getElementById(
        "user_password_confirmation"
    ).value;
    const feedbackElement = document.getElementById("passwordMatchFeedback");

    if (confirmPassword === "") {
        feedbackElement.style.display = "none";
        doPasswordsMatch = false;
    } else if (password === confirmPassword) {
        feedbackElement.textContent = "As senhas coincidem";
        feedbackElement.classList.remove("invalid");
        feedbackElement.classList.add("valid");
        feedbackElement.style.display = "block";
        doPasswordsMatch = true;
    } else {
        feedbackElement.textContent = "As senhas não coincidem";
        feedbackElement.classList.remove("valid");
        feedbackElement.classList.add("invalid");
        feedbackElement.style.display = "block";
        doPasswordsMatch = false;
    }
}

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

    // Atualiza o campo de confirmação de senha
    const confirmField = document.getElementById("user_password_confirmation");
    confirmField.value = password;

    // Dispara eventos de input para atualizar a UI
    passwordField.dispatchEvent(new Event("input"));
    confirmField.dispatchEvent(new Event("input"));

    showJsError("Senha forte gerada com sucesso!", 3000);
}

// Event listeners para validação em tempo real
document.getElementById("user_password").addEventListener("input", function () {
    checkPasswordStrength(this.value);
});

document
    .getElementById("user_password_confirmation")
    .addEventListener("input", function () {
        checkPasswordMatch();
    });

document
    .getElementById("passwordForm")
    .addEventListener("submit", function (e) {
        if (!isPasswordValid) {
            e.preventDefault();
            showJsError("A senha não atende aos requisitos mínimos.");
            return;
        }
        if (!doPasswordsMatch) {
            e.preventDefault();
            showJsError("As senhas não coincidem.");
            return;
        }
        e.preventDefault();
        showJsError("Todas as validações passaram com sucesso!", 3000);
    });

// Inicializar a validação de senha ao carregar a página
document.addEventListener("DOMContentLoaded", function () {
    const password = document.getElementById("user_password").value;
    if (password) {
        checkPasswordStrength(password);
    }
    checkPasswordMatch();
});
