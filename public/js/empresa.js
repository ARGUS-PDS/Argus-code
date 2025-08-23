let isCnpjValid = false;
let isPasswordValid = false;
let isEmailValid = false;

function togglePassword(inputId, iconElement) {
    const passwordInput = document.getElementById(inputId);

    if (passwordInput.type === "password") {
        passwordInput.type = "text";
        iconElement.classList.replace("fa-eye", "fa-eye-slash");
    } else {
        passwordInput.type = "password";
        iconElement.classList.replace("fa-eye-slash", "fa-eye");
    }
}

document
    .querySelector("input[name='cep']")
    .addEventListener("blur", function () {
        const cep = this.value.replace(/\D/g, "");
        const url = `https://viacep.com.br/ws/${cep}/json/`;

        if (cep.length === 8) {
            fetch(url)
                .then((res) => res.json())
                .then((data) => {
                    if (!data.erro) {
                        document.querySelector("input[name='place']").value =
                            data.logradouro || "";
                        document.querySelector(
                            "input[name='neighborhood']"
                        ).value = data.bairro || "";
                        document.querySelector("input[name='city']").value =
                            data.localidade || "";
                        document.querySelector("input[name='state']").value =
                            data.uf || "";
                        document.querySelector("input[name='number']").focus();
                    } else {
                        alert("CEP não encontrado.");
                    }
                });
        } else if (cep.length > 0) {
            alert("CEP inválido. Deve conter 8 dígitos.");
        }
    });

document
    .querySelector("input[name='cnpj']")
    .addEventListener("blur", async function () {
        const cnpj = this.value.replace(/\D/g, "");

        if (cnpj.length === 14) {
            try {
                const res = await fetch(
                    `https://brasilapi.com.br/api/cnpj/v1/${cnpj}`
                );
                if (!res.ok) throw new Error("CNPJ inválido");

                const data = await res.json();

                document.querySelector("input[name='businessName']").value =
                    data.razao_social || "";
                document.querySelector("input[name='tradeName']").value =
                    data.nome_fantasia || "";
                document.querySelector("input[name='cep']").value =
                    data.cep?.replace("-", "") || "";
                document.querySelector("input[name='place']").value =
                    data.logradouro || "";
                document.querySelector("input[name='neighborhood']").value =
                    data.bairro || "";
                document.querySelector("input[name='city']").value =
                    data.municipio || "";
                document.querySelector("input[name='state']").value =
                    data.uf || "";
                document.querySelector("input[name='number']").focus();

                isCnpjValid = true;
            } catch (error) {
                alert("CNPJ inválido ou não encontrado.");
                isCnpjValid = false;
            }
        } else {
            alert("CNPJ deve conter 14 dígitos.");
            isCnpjValid = false;
        }
    });

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

document.getElementById("user_email").addEventListener("input", function () {
    const email = this.value;
    const emailFeedback = document.getElementById("emailFeedback");

    if (email === "") {
        emailFeedback.style.display = "none";
        isEmailValid = false;
    } else if (validateEmail(email)) {
        emailFeedback.textContent = "Email válido";
        emailFeedback.className = "email-feedback valid";
        isEmailValid = true;
    } else {
        emailFeedback.textContent = "Por favor, insira um email válido";
        emailFeedback.className = "email-feedback invalid";
        isEmailValid = false;
    }
});

function checkPasswordStrength(password) {
    let strength = 0;
    const requirements = {
        hasLength: false,
        hasUppercase: false,
        hasLowercase: false,
        hasNumber: false,
        hasSpecial: false,
    };

    if (password.length >= 8) {
        strength += 20;
        requirements.hasLength = true;
    }

    if (/[A-Z]/.test(password)) {
        strength += 20;
        requirements.hasUppercase = true;
    }

    if (/[a-z]/.test(password)) {
        strength += 20;
        requirements.hasLowercase = true;
    }

    if (/[0-9]/.test(password)) {
        strength += 20;
        requirements.hasNumber = true;
    }

    if (/[^A-Za-z0-9]/.test(password)) {
        strength += 20;
        requirements.hasSpecial = true;
    }

    return { strength, requirements };
}

function updatePasswordUI(strength, requirements) {
    const progressBar = document.querySelector(".progress-bar");
    const feedback = document.getElementById("passwordFeedback");

    progressBar.style.width = `${strength}%`;

    if (strength < 40) {
        progressBar.className = "progress-bar bg-danger";
        feedback.textContent = "Força da senha: muito fraca";
        feedback.className = "password-feedback text-danger";
        isPasswordValid = false;
    } else if (strength < 60) {
        progressBar.className = "progress-bar bg-warning";
        feedback.textContent = "Força da senha: fraca";
        feedback.className = "password-feedback text-warning";
        isPasswordValid = false;
    } else if (strength < 80) {
        progressBar.className = "progress-bar bg-info";
        feedback.textContent = "Força da senha: média";
        feedback.className = "password-feedback text-info";
        isPasswordValid = true;
    } else if (strength < 100) {
        progressBar.className = "progress-bar bg-primary";
        feedback.textContent = "Força da senha: forte";
        feedback.className = "password-feedback text-primary";
        isPasswordValid = true;
    } else {
        progressBar.className = "progress-bar bg-success";
        feedback.textContent = "Força da senha: muito forte";
        feedback.className = "password-feedback text-success";
        isPasswordValid = true;
    }

    document.getElementById("lengthReq").className = requirements.hasLength
        ? "requirement valid"
        : "requirement invalid";
    document.getElementById("lengthReq").querySelector("i").className =
        requirements.hasLength ? "bi bi-check-circle" : "bi bi-x-circle";

    document.getElementById("uppercaseReq").className =
        requirements.hasUppercase ? "requirement valid" : "requirement invalid";
    document.getElementById("uppercaseReq").querySelector("i").className =
        requirements.hasUppercase ? "bi bi-check-circle" : "bi bi-x-circle";

    document.getElementById("lowercaseReq").className =
        requirements.hasLowercase ? "requirement valid" : "requirement invalid";
    document.getElementById("lowercaseReq").querySelector("i").className =
        requirements.hasLowercase ? "bi bi-check-circle" : "bi bi-x-circle";

    document.getElementById("numberReq").className = requirements.hasNumber
        ? "requirement valid"
        : "requirement invalid";
    document.getElementById("numberReq").querySelector("i").className =
        requirements.hasNumber ? "bi bi-check-circle" : "bi bi-x-circle";

    document.getElementById("specialReq").className = requirements.hasSpecial
        ? "requirement valid"
        : "requirement invalid";
    document.getElementById("specialReq").querySelector("i").className =
        requirements.hasSpecial ? "bi bi-check-circle" : "bi bi-x-circle";
}

document.getElementById("user_password").addEventListener("input", function () {
    const password = this.value;
    const { strength, requirements } = checkPasswordStrength(password);
    updatePasswordUI(strength, requirements);
});

document.getElementById("formEmpresa").addEventListener("submit", function (e) {
    if (!isCnpjValid) {
        e.preventDefault();
        alert("CNPJ inválido. Verifique antes de salvar.");
        return;
    }

    const email = document.getElementById("user_email").value;
    if (!validateEmail(email)) {
        e.preventDefault();
        alert("Por favor, insira um email válido.");
        document.getElementById("user_email").focus();
        return;
    }

    const password = document.getElementById("user_password").value;
    const { strength } = checkPasswordStrength(password);

    if (strength < 60) {
        e.preventDefault();
        alert(
            "A senha não atende aos requisitos mínimos de segurança. Por favor, fortaleça sua senha."
        );
        document.getElementById("user_password").focus();
    }
});
