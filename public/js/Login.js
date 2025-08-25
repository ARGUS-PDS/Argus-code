const container = document.getElementById("container");
const btnEntrar = document.getElementById("entrar");
const btnRegistrar = document.getElementById("registrar");

const userEmailLogin = document.getElementById("user_email_login");
const userEmailContato = document.getElementById("user_email_contato");
const loginErrorContainer = document.getElementById("login-error-container");
const contatoErrorContainer = document.getElementById(
    "contato-error-container"
);

function isValidEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailPattern.test(email);
}

function showError(container, message) {
    container.innerHTML = `
                <div class="alert alert-danger">
                    ${message}
                </div>
            `;
}

function clearError(container) {
    container.innerHTML = "";
}

function setupRealTimeValidation(input, errorContainer, isLogin = true) {
    let timeout = null;

    input.addEventListener("input", function () {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            const email = input.value.trim();

            if (email === "") {
                clearError(errorContainer);
                input.classList.remove("input-error");
                input.classList.remove("input-success");
                return;
            }

            if (!isValidEmail(email)) {
                showError(
                    errorContainer,
                    "Por favor, insira um e-mail válido (ex: exemplo@dominio.com)."
                );
                input.classList.add("input-error");
                input.classList.remove("input-success");

                if (!isLogin) {
                    container.classList.add("active");
                }
            } else {
                clearError(errorContainer);
                input.classList.remove("input-error");
                input.classList.add("input-success");
            }
        }, 800);
    });

    input.addEventListener("blur", function () {
        const email = input.value.trim();

        if (email === "") {
            clearError(errorContainer);
            input.classList.remove("input-error");
            input.classList.remove("input-success");
            return;
        }

        if (!isValidEmail(email)) {
            showError(
                errorContainer,
                "Por favor, insira um e-mail válido (ex: exemplo@dominio.com)."
            );
            input.classList.add("input-error");
            input.classList.remove("input-success");

            if (!isLogin) {
                container.classList.add("active");
            }
        } else {
            clearError(errorContainer);
            input.classList.remove("input-error");
            input.classList.add("input-success");
        }
    });
}

document.addEventListener("DOMContentLoaded", function () {
    const whatsappInput = document.getElementById("whatsapp");
    whatsappInput.addEventListener("input", function (e) {
        let value = e.target.value.replace(/\D/g, "");
        if (value.length > 2) {
            value = `(${value.substring(0, 2)}) ${value.substring(2)}`;
        }
        if (value.length > 10) {
            value = `${value.substring(0, 10)}-${value.substring(10, 14)}`;
        }
        e.target.value = value;
    });

    setupRealTimeValidation(userEmailLogin, loginErrorContainer, true);
    setupRealTimeValidation(userEmailContato, contatoErrorContainer, false);

    btnRegistrar.addEventListener("click", () =>
        container.classList.add("active")
    );
    btnEntrar.addEventListener("click", () =>
        container.classList.remove("active")
    );

    const toast = document.getElementById("toast-contato");
    if (window.contatoEnviado) {
        toast.classList.add("show");
        setTimeout(() => {
            toast.classList.remove("show");
        }, 4000);
    }
});

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
