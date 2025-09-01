let isCnpjValid = false;
let isPasswordValid = false;
let doPasswordsMatch = false;
let isEmailValid = false;
let cnpjApiTimeout = null;

function showJsError(message, duration = 5000) {
    const container = document.getElementById("jsErrorContainer");
    const msg = document.getElementById("jsErrorMessage");
    msg.textContent = message;
    container.classList.remove("d-none");
    setTimeout(() => container.classList.add("alert-show"), 50);
    setTimeout(() => {
        container.classList.remove("alert-show");
        setTimeout(() => container.classList.add("d-none"), 400);
    }, duration);
}

function formatCNPJ(cnpj) {
    cnpj = cnpj.replace(/\D/g, "");
    cnpj = cnpj.replace(/^(\d{2})(\d)/, "$1.$2");
    cnpj = cnpj.replace(/^(\d{2})\.(\d{3})(\d)/, "$1.$2.$3");
    cnpj = cnpj.replace(/\.(\d{3})(\d)/, ".$1/$2");
    cnpj = cnpj.replace(/(\d{4})(\d)/, "$1-$2");
    return cnpj.substring(0, 18);
}

function isValidCNPJFormat(cnpj) {
    return /^\d{2}\.\d{3}\.\d{3}\/\d{4}\-\d{2}$/.test(cnpj);
}

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

document.getElementById("cnpj").addEventListener("input", function () {
    this.value = formatCNPJ(this.value);
});

document.getElementById("cnpj").addEventListener("blur", async function () {
    const cnpjInput = this;
    const cnpjStatus = document.getElementById("cnpjStatus");
    const cnpj = cnpjInput.value;

    cnpjStatus.className = "cnpj-status d-none";
    isCnpjValid = false;

    if (!cnpj.trim()) {
        showJsError("Por favor, informe o CNPJ.");
        cnpjInput.focus();
        return;
    }

    if (!isValidCNPJFormat(cnpj)) {
        showJsError(
            "Formato de CNPJ inválido. Use o formato: 00.000.000/0000-00"
        );
        cnpjStatus.innerHTML =
            '<i class="bi bi-x-circle validation-icon"></i> Formato inválido';
        cnpjStatus.className = "cnpj-status invalid";
        cnpjInput.focus();
        return;
    }

    if (!isValidCNPJ(cnpj)) {
        showJsError("CNPJ inválido. Verifique os dígitos.");
        cnpjStatus.innerHTML =
            '<i class="bi bi-x-circle validation-icon"></i> CNPJ inválido';
        cnpjStatus.className = "cnpj-status invalid";
        cnpjInput.focus();
        return;
    }

    cnpjStatus.innerHTML =
        '<div class="cnpj-loading"></div> Validando CNPJ na Receita Federal...';
    cnpjStatus.className = "cnpj-status";

    if (cnpjApiTimeout) {
        clearTimeout(cnpjApiTimeout);
    }

    const timeoutPromise = new Promise((_, reject) => {
        cnpjApiTimeout = setTimeout(
            () => reject(new Error("Tempo excedido na consulta do CNPJ")),
            10000
        );
    });

    try {
        const cnpjNumbers = cnpj.replace(/\D/g, "");
        const apiPromise = fetch(
            `https://brasilapi.com.br/api/cnpj/v1/${cnpjNumbers}`
        );

        const res = await Promise.race([apiPromise, timeoutPromise]);

        if (!res.ok) throw new Error("CNPJ não encontrado na base de dados");

        const data = await res.json();

        document.getElementById("businessName").value = data.razao_social || "";
        document.getElementById("tradeName").value = data.nome_fantasia || "";
        document.getElementById("cep").value = data.cep
            ? data.cep.replace(/\D/g, "")
            : "";
        document.getElementById("place").value = data.logradouro || "";
        document.getElementById("neighborhood").value = data.bairro || "";
        document.getElementById("city").value = data.municipio || "";
        document.getElementById("state").value = data.uf || "";

        cnpjStatus.innerHTML =
            '<i class="bi bi-check-circle validation-icon"></i> CNPJ válido';
        cnpjStatus.className = "cnpj-status valid";
        isCnpjValid = true;
    } catch (error) {
        console.error("Erro na validação do CNPJ:", error);

        if (error.message.includes("Tempo excedido")) {
            showJsError(
                "A consulta ao CNPJ está demorando muito. Você pode continuar, mas verifique os dados manualmente."
            );
            cnpjStatus.innerHTML =
                '<i class="bi bi-exclamation-triangle validation-icon"></i> Verifique manualmente (timeout)';
            cnpjStatus.className = "cnpj-status";
            isCnpjValid = true;
        } else {
            showJsError(
                "CNPJ não encontrado na base oficial. Verifique ou preencha os dados manualmente."
            );
            cnpjStatus.innerHTML =
                '<i class="bi bi-exclamation-triangle validation-icon"></i> CNPJ não encontrado - verifique';
            cnpjStatus.className = "cnpj-status";
            isCnpjValid = true;
        }
    } finally {
        clearTimeout(cnpjApiTimeout);
    }
});

document.getElementById("cep").addEventListener("blur", function () {
    const cep = this.value.replace(/\D/g, "");
    if (cep.length !== 8) return;

    fetch(`https://viacep.com.br/ws/${cep}/json/`)
        .then((res) => res.json())
        .then((data) => {
            if (!data.erro) {
                document.getElementById("place").value = data.logradouro || "";
                document.getElementById("neighborhood").value =
                    data.bairro || "";
                document.getElementById("city").value = data.localidade || "";
                document.getElementById("state").value = data.uf || "";
            } else {
                showJsError("CEP não encontrado.");
            }
        })
        .catch(() => {
            showJsError("Erro ao consultar CEP.");
        });
});

const userEmail = document.getElementById("user_email");
userEmail.addEventListener("blur", function () {
    const email = this.value.trim();
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailPattern.test(email)) {
        isEmailValid = false;
        showJsError(
            "Por favor, insira um e-mail válido (ex: exemplo@dominio.com)."
        );
        this.focus();
    } else {
        isEmailValid = true;
    }
});

document.getElementById("companyForm").addEventListener("submit", function (e) {
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
    if (!isCnpjValid) {
        e.preventDefault();
        showJsError("CNPJ inválido. Verifique antes de salvar.");
        document.getElementById("cnpj").focus();
        return;
    }
    if (!isEmailValid) {
        e.preventDefault();
        showJsError("Por favor, insira um e-mail válido.");
        userEmail.focus();
        return;
    }
});

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

document.getElementById("user_password").addEventListener("input", function () {
    checkPasswordStrength(this.value);
});

document
    .getElementById("user_password_confirmation")
    .addEventListener("input", function () {
        checkPasswordMatch();
    });

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
    } else if (strength < 80) {
        feedbackElement.textContent = "Força da senha: média";
        strengthBar.className = "progress-bar bg-warning";
    } else {
        feedbackElement.textContent = "Força da senha: forte";
        strengthBar.className = "progress-bar bg-success";
    }
    isPasswordValid =
        hasMinLength &&
        hasUpperCase &&
        hasLowerCase &&
        hasNumber &&
        hasSpecialChar;
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
