const container = document.getElementById("container");
const btnEntrar = document.getElementById("entrar");
const btnRegistrar = document.getElementById("registrar");

const userEmailLogin = document.getElementById("user_email_login");
const userEmailContato = document.getElementById("user_email_contato");
const loginErrorContainer = document.getElementById("login-error-container");
const contatoErrorContainer = document.getElementById(
    "contato-error-container"
);

// Elementos do modal
const emailRecuperar = document.getElementById("emailRecuperar");
const modalErrorContainer = document.getElementById("modal-error-container");
const modalSenhaVencidaForm = document.getElementById("modalSenhaVencidaForm");

// Elementos do cartão de segurança
const cartaoSeg = document.getElementById("cartao_seg");
const cartaoSegError = document.getElementById("cartao_seg_error");
const cartaoRecuperar = document.getElementById("cartaoRecuperar");
const cartaoRecuperarError = document.getElementById("cartaoRecuperar_error");
const loginSubmitBtn = document.getElementById("loginSubmitBtn");
const modalSubmitBtn = document.getElementById("modalSubmitBtn");

// Botão de submit do formulário de contato
const contatoSubmitBtn = document.querySelector(
    ".formulario-container.registro .botao-input"
);

document.addEventListener("DOMContentLoaded", function () {
    if (window.contatoEnviado) {
        mostrarToastContato();
    }
});

function mostrarToastContato() {
    const toast = document.querySelector(".container-toast");
    if (!toast) return;

    toast.classList.add("show");

    // Auto-esconder após 5 segundos
    setTimeout(() => {
        fecharToastContato();
    }, 5000);
}

function fecharToastContato() {
    const toast = document.querySelector(".container-toast");
    if (!toast) return;

    toast.classList.remove("show");
}

// Fechar toast ao pressionar ESC
document.addEventListener("keydown", function (e) {
    if (e.key === "Escape") {
        fecharToastContato();
    }
});

// ========== FUNÇÕES DE VALIDAÇÃO DE FORMULÁRIO ==========

// Função para verificar se todos os campos do formulário de login estão válidos
function checkLoginFormValidity() {
    const loginEmail = document.getElementById("user_email_login").value.trim();
    const loginPassword = document.getElementById("password").value;
    const loginCard = document.getElementById("cartao_seg").value.trim();

    const isLoginValid =
        isValidEmail(loginEmail) &&
        loginPassword.length >= 8 &&
        isValidCard(loginCard);

    return isLoginValid;
}

// Função para verificar se todos os campos do formulário de contato estão válidos
function checkContatoFormValidity() {
    const contatoNome = document
        .querySelector('input[name="nome"]')
        .value.trim();
    const contatoEmpresa = document
        .querySelector('input[name="empresa"]')
        .value.trim();
    const contatoEmail = document
        .getElementById("user_email_contato")
        .value.trim();
    const contatoWhatsapp = document.getElementById("whatsapp").value.trim();
    const contatoPlano = document.querySelector('select[name="plano"]').value;

    const isContatoValid =
        validarNome(contatoNome).valido &&
        validarEmpresa(contatoEmpresa).valido &&
        isValidEmail(contatoEmail) &&
        validarWhatsapp(contatoWhatsapp).valido &&
        contatoPlano !== "";

    return isContatoValid;
}

// Função para atualizar o estado do botão de login
function updateLoginButtonState() {
    const isLoginValid = checkLoginFormValidity();
    if (loginSubmitBtn) {
        loginSubmitBtn.disabled = !isLoginValid;
    }
}

// Função para atualizar o estado do botão de contato
function updateContatoButtonState() {
    const isContatoValid = checkContatoFormValidity();
    if (contatoSubmitBtn) {
        contatoSubmitBtn.disabled = !isContatoValid;
    }
}

// Configurar validação em tempo real para todos os campos
function setupRealTimeFormValidation() {
    // Campos do formulário de login
    const loginFields = ["user_email_login", "password", "cartao_seg"];

    // Campos do formulário de contato
    const contatoFields = ["nome", "empresa", "user_email_contato", "whatsapp"];

    // Adicionar listeners para campos de login
    loginFields.forEach((fieldId) => {
        const field = document.getElementById(fieldId);
        if (field) {
            field.addEventListener("input", updateLoginButtonState);
            field.addEventListener("blur", updateLoginButtonState);
        }
    });

    // Adicionar listeners para campos de contato
    contatoFields.forEach((fieldId) => {
        const field =
            fieldId === "nome" || fieldId === "empresa"
                ? document.querySelector(`input[name="${fieldId}"]`)
                : document.getElementById(fieldId);

        if (field) {
            field.addEventListener("input", updateContatoButtonState);
            field.addEventListener("blur", updateContatoButtonState);
        }
    });

    // Listener para o select do plano
    const planoSelect = document.querySelector('select[name="plano"]');
    if (planoSelect) {
        planoSelect.addEventListener("change", function () {
            updateContatoButtonState();
            if (this.value !== "") {
                this.classList.add("input-success");
                this.classList.remove("input-error");
            } else {
                this.classList.remove("input-success");
                this.classList.add("input-error");
            }
        });
    }
}

// Função modificada para mostrar tela de carregamento apenas se válido
function mostrarTelaCarregando(event) {
    if (event) {
        event.preventDefault();
    }

    const isLoginForm =
        event && event.target && event.target.id === "loginForm";
    const isContatoForm =
        event &&
        event.target &&
        event.target.closest(".formulario-container.registro form");

    if (
        (isLoginForm && !checkLoginFormValidity()) ||
        (isContatoForm && !checkContatoFormValidity())
    ) {
        console.log("Formulário inválido - carregamento não iniciado");
        return false;
    }

    const carregamento = document.querySelector(".carregamento");
    if (carregamento) {
        carregamento.style.display = "flex";

        setTimeout(() => {
            if (isLoginForm) {
                document.getElementById("loginForm").submit();
            } else if (isContatoForm) {
                document
                    .querySelector(".formulario-container.registro form")
                    .submit();
            }
        }, 1000);
    }

    return true;
}

// ========== FUNÇÕES EXISTENTES (ATUALIZADAS) ==========

// Funções para controle do modal
function abrirModal() {
    // Resetar o formulário e limpar erros antes de abrir
    document.getElementById("modalSenhaVencidaForm").reset();
    clearModalError();
    emailRecuperar.classList.remove("input-error");
    emailRecuperar.classList.remove("input-success");
    cartaoRecuperar.classList.remove("input-error");
    cartaoRecuperar.classList.remove("input-success");
    cartaoRecuperarError.style.display = "none";
    modalSubmitBtn.disabled = true;

    document
        .getElementById("modalSenhaVencida")
        .classList.remove("hidden-modal");
    document.getElementById("modalBackdrop").classList.remove("hidden-modal");

    setTimeout(() => {
        document.getElementById("modalSenhaVencida").classList.add("show");
        document.getElementById("modalBackdrop").classList.add("show");
    }, 10);
}

function fecharModal() {
    document.getElementById("modalSenhaVencida").classList.remove("show");
    document.getElementById("modalBackdrop").classList.remove("show");

    setTimeout(() => {
        document
            .getElementById("modalSenhaVencida")
            .classList.add("hidden-modal");
        document.getElementById("modalBackdrop").classList.add("hidden-modal");

        // Resetar o formulário do modal para limpar os campos
        document.getElementById("modalSenhaVencidaForm").reset();

        // Limpar mensagens de erro e estilos
        clearModalError();
        emailRecuperar.classList.remove("input-error");
        emailRecuperar.classList.remove("input-success");
        cartaoRecuperar.classList.remove("input-error");
        cartaoRecuperar.classList.remove("input-success");
        cartaoRecuperarError.style.display = "none";
        modalSubmitBtn.disabled = true;
    }, 300);
}

// Adicionar evento de clique ao link
document
    .getElementById("senhaVencidaLink")
    .addEventListener("click", function (e) {
        e.preventDefault();
        abrirModal();
    });

// Fechar modal ao clicar no backdrop
document.getElementById("modalBackdrop").addEventListener("click", fecharModal);

function isValidEmail(email) {
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
    return emailPattern.test(email);
}

function isValidCard(cardNumber) {
    const cardPattern = /^\d{4}$/;
    return cardPattern.test(cardNumber);
}

// Função para validar o campo nome
function validarNome(nome) {
    // Remove espaços extras no início e fim
    nome = nome.trim();

    // Verifica se está vazio
    if (nome === "") {
        return { valido: false, mensagem: "O nome é obrigatório." };
    }

    // Verifica o comprimento (máximo 100 caracteres)
    if (nome.length > 100) {
        return {
            valido: false,
            mensagem: "O nome deve ter no máximo 100 caracteres.",
        };
    }

    // Verifica se contém apenas letras, espaços e caracteres acentuados
    const regex = /^[A-Za-zÀ-ÖØ-öø-ÿ\s]+$/;
    if (!regex.test(nome)) {
        return {
            valido: false,
            mensagem: "O nome deve conter apenas letras e espaços.",
        };
    }

    return { valido: true, mensagem: "" };
}

// Função para validar o campo empresa
function validarEmpresa(empresa) {
    // Remove espaços extras no início e fim
    empresa = empresa.trim();

    // Verifica se está vazio
    if (empresa === "") {
        return { valido: false, mensagem: "O nome da empresa é obrigatório." };
    }

    // Verifica o comprimento (máximo 150 caracteres)
    if (empresa.length > 150) {
        return {
            valido: false,
            mensagem: "O nome da empresa deve ter no máximo 150 caracteres.",
        };
    }

    // Verifica se contém caracteres válidos (letras, números, espaços e alguns caracteres especiais)
    const regex = /^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s\-&.,'()]+$/;
    if (!regex.test(empresa)) {
        return {
            valido: false,
            mensagem: "O nome da empresa contém caracteres inválidos.",
        };
    }

    return { valido: true, mensagem: "" };
}

// Função para validar o campo WhatsApp
function validarWhatsapp(whatsapp) {
    // Remove todos os caracteres não numéricos
    const numeros = whatsapp.replace(/\D/g, "");

    // Verifica se está vazio
    if (numeros === "") {
        return {
            valido: false,
            mensagem: "O número de WhatsApp é obrigatório.",
        };
    }

    // Verifica se tem 11 dígitos (formato brasileiro com DDD)
    if (numeros.length !== 11) {
        return {
            valido: false,
            mensagem: "O número de WhatsApp deve ter 11 dígitos (com DDD).",
        };
    }

    // Verifica se o DDD é válido (números entre 11 e 99)
    const ddd = numeros.substring(0, 2);
    if (ddd < 11 || ddd > 99) {
        return { valido: false, mensagem: "DDD inválido." };
    }

    return { valido: true, mensagem: "" };
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

function showModalError(message) {
    setTimeout(() => {
        modalErrorContainer.innerHTML = `
          <div class="alert alert-danger">
            ${message}
          </div>
        `;
    }, 300);
}

function clearModalError() {
    modalErrorContainer.innerHTML = "";
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
                // Atualizar estado do botão
                if (isLogin) {
                    updateLoginButtonState();
                } else {
                    updateContatoButtonState();
                }
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

            // Atualizar estado do botão
            if (isLogin) {
                updateLoginButtonState();
            } else {
                updateContatoButtonState();
            }
        }, 800);
    });

    input.addEventListener("blur", function () {
        const email = input.value.trim();

        if (email === "") {
            clearError(errorContainer);
            input.classList.remove("input-error");
            input.classList.remove("input-success");
            // Atualizar estado do botão
            if (isLogin) {
                updateLoginButtonState();
            } else {
                updateContatoButtonState();
            }
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

        // Atualizar estado do botão
        if (isLogin) {
            updateLoginButtonState();
        } else {
            updateContatoButtonState();
        }
    });
}

// Configurar validação em tempo real para o cartão de segurança
function setupCardValidation(
    input,
    errorElement,
    submitBtn = null,
    isModal = false
) {
    let timeout = null;

    // Permitir apenas números
    input.addEventListener("input", function (e) {
        // Remove qualquer caractere que não seja número
        this.value = this.value.replace(/\D/g, "");

        // Limita a 4 dígitos
        if (this.value.length > 4) {
            this.value = this.value.slice(0, 4);
        }

        clearTimeout(timeout);

        timeout = setTimeout(() => {
            validateCardInput(input, errorElement, submitBtn, isModal);
            // Atualizar estado do botão apropriado
            if (isModal) {
                // Para o modal, a validação já é tratada internamente
            } else {
                updateLoginButtonState();
            }
        }, 500);
    });

    input.addEventListener("blur", function () {
        validateCardInput(input, errorElement, submitBtn, isModal);
        // Atualizar estado do botão apropriado
        if (isModal) {
            // Para o modal, a validação já é tratada internamente
        } else {
            updateLoginButtonState();
        }
    });

    input.addEventListener("keyup", function () {
        validateCardInput(input, errorElement, submitBtn, isModal);
        // Atualizar estado do botão apropriado
        if (isModal) {
            // Para o modal, a validação já é tratada internamente
        } else {
            updateLoginButtonState();
        }
    });
}

function validateCardInput(input, errorElement, submitBtn, isModal) {
    const cardValue = input.value.trim();

    if (cardValue === "") {
        errorElement.textContent =
            "Por favor, informe os 4 dígitos do cartão de segurança.";
        errorElement.style.display = "block";
        input.classList.add("input-error");
        input.classList.remove("input-success");
        if (submitBtn) submitBtn.disabled = true;
        return false;
    }

    if (!isValidCard(cardValue)) {
        errorElement.textContent =
            "O cartão de segurança deve conter exatamente 4 dígitos numéricos.";
        errorElement.style.display = "block";
        input.classList.add("input-error");
        input.classList.remove("input-success");
        if (submitBtn) submitBtn.disabled = true;
        return false;
    }

    errorElement.style.display = "none";
    input.classList.remove("input-error");
    input.classList.add("input-success");

    // Habilitar o botão de envio se estiver no contexto de um formulário com validação completa
    if (submitBtn) {
        // Verificar se o email também é válido (para o modal)
        if (isModal) {
            const emailInput = document.getElementById("emailRecuperar");
            const isEmailValid = isValidEmail(emailInput.value.trim());
            submitBtn.disabled = !isEmailValid;
        } else {
            submitBtn.disabled = false;
        }
    }

    return true;
}

// validação em tempo real para o email do modal
function setupModalEmailValidation() {
    let timeout = null;

    emailRecuperar.addEventListener("input", function () {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            const email = emailRecuperar.value.trim();

            if (email === "") {
                clearModalError();
                emailRecuperar.classList.remove("input-error");
                emailRecuperar.classList.remove("input-success");
                modalSubmitBtn.disabled = true;
                return;
            }

            if (!isValidEmail(email)) {
                showModalError(
                    "Por favor, insira um e-mail válido (ex: exemplo@dominio.com)."
                );
                emailRecuperar.classList.add("input-error");
                emailRecuperar.classList.remove("input-success");
                modalSubmitBtn.disabled = true;
            } else {
                clearModalError();
                emailRecuperar.classList.remove("input-error");
                emailRecuperar.classList.add("input-success");

                // Habilitar o botão apenas se o cartão também for válido
                const isCardValid = isValidCard(cartaoRecuperar.value.trim());
                modalSubmitBtn.disabled = !isCardValid;
            }
        }, 800);
    });

    emailRecuperar.addEventListener("blur", function () {
        const email = emailRecuperar.value.trim();

        if (email === "") {
            clearModalError();
            emailRecuperar.classList.remove("input-error");
            emailRecuperar.classList.remove("input-success");
            modalSubmitBtn.disabled = true;
            return;
        }

        if (!isValidEmail(email)) {
            showModalError(
                "Por favor, insira um e-mail válido (ex: exemplo@dominio.com)."
            );
            emailRecuperar.classList.add("input-error");
            emailRecuperar.classList.remove("input-success");
            modalSubmitBtn.disabled = true;
        } else {
            clearModalError();
            emailRecuperar.classList.remove("input-error");
            emailRecuperar.classList.add("input-success");

            // Habilitar o botão apenas se o cartão também for válido
            const isCardValid = isValidCard(cartaoRecuperar.value.trim());
            modalSubmitBtn.disabled = !isCardValid;
        }
    });
}

// Configurar validação em tempo real para o campo nome
function setupNomeValidation() {
    const nomeInput = document.querySelector('input[name="nome"]');
    const errorContainer = document.getElementById("contato-error-container");

    let timeout = null;

    nomeInput.addEventListener("input", function () {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            const resultado = validarNome(this.value);

            if (!resultado.valido && this.value !== "") {
                showError(errorContainer, resultado.mensagem);
                this.classList.add("input-error");
                this.classList.remove("input-success");
            } else {
                clearError(errorContainer);
                this.classList.remove("input-error");
                if (this.value !== "") {
                    this.classList.add("input-success");
                } else {
                    this.classList.remove("input-success");
                }
            }

            updateContatoButtonState();
        }, 500);
    });

    nomeInput.addEventListener("blur", function () {
        const resultado = validarNome(this.value);

        if (!resultado.valido && this.value !== "") {
            showError(errorContainer, resultado.mensagem);
            this.classList.add("input-error");
            this.classList.remove("input-success");
        } else if (resultado.valido) {
            clearError(errorContainer);
            this.classList.remove("input-error");
            this.classList.add("input-success");
        } else {
            this.classList.remove("input-error");
            this.classList.remove("input-success");
        }

        updateContatoButtonState();
    });

    // Prevenir que o usuário digite caracteres inválidos
    nomeInput.addEventListener("keypress", function (e) {
        const key = e.key;
        // Permitir apenas letras, espaços e teclas de controle
        if (
            !/^[A-Za-zÀ-ÖØ-öø-ÿ\s]$/.test(key) &&
            key !== "Backspace" &&
            key !== "Delete" &&
            key !== "ArrowLeft" &&
            key !== "ArrowRight" &&
            key !== "Tab"
        ) {
            e.preventDefault();
        }
    });
}

// Configurar validação em tempo real para o campo empresa
function setupEmpresaValidation() {
    const empresaInput = document.querySelector('input[name="empresa"]');
    const errorContainer = document.getElementById("contato-error-container");

    let timeout = null;

    empresaInput.addEventListener("input", function () {
        clearTimeout(timeout);

        timeout = setTimeout(() => {
            const resultado = validarEmpresa(this.value);

            if (!resultado.valido && this.value !== "") {
                showError(errorContainer, resultado.mensagem);
                this.classList.add("input-error");
                this.classList.remove("input-success");
            } else {
                clearError(errorContainer);
                this.classList.remove("input-error");
                if (this.value !== "") {
                    this.classList.add("input-success");
                } else {
                    this.classList.remove("input-success");
                }
            }

            updateContatoButtonState();
        }, 500);
    });

    empresaInput.addEventListener("blur", function () {
        const resultado = validarEmpresa(this.value);

        if (!resultado.valido && this.value !== "") {
            showError(errorContainer, resultado.mensagem);
            this.classList.add("input-error");
            this.classList.remove("input-success");
        } else if (resultado.valido) {
            clearError(errorContainer);
            this.classList.remove("input-error");
            this.classList.add("input-success");
        } else {
            this.classList.remove("input-error");
            this.classList.remove("input-success");
        }

        updateContatoButtonState();
    });

    // Prevenir caracteres inválidos
    empresaInput.addEventListener("keypress", function (e) {
        const key = e.key;
        // Permitir letras, números, espaços e os caracteres especiais: hífen, &, ponto, vírgula, apóstrofe, parênteses
        if (
            !/^[A-Za-zÀ-ÖØ-öø-ÿ0-9\s\-&.,'()]$/.test(key) &&
            key !== "Backspace" &&
            key !== "Delete" &&
            key !== "ArrowLeft" &&
            key !== "ArrowRight" &&
            key !== "Tab"
        ) {
            e.preventDefault();
        }
    });
}

// Configurar validação em tempo real para o campo WhatsApp
function setupWhatsappValidation() {
    const whatsappInput = document.getElementById("whatsapp");
    const errorContainer = document.getElementById("contato-error-container");

    let timeout = null;

    whatsappInput.addEventListener("input", function () {
        clearTimeout(timeout);

        // Aplicar máscara
        let value = this.value.replace(/\D/g, "");
        if (value.length > 2) {
            value = `(${value.substring(0, 2)}) ${value.substring(2)}`;
        }
        if (value.length > 10) {
            value = `${value.substring(0, 10)}-${value.substring(10, 15)}`;
        }
        this.value = value;

        timeout = setTimeout(() => {
            const resultado = validarWhatsapp(this.value);

            if (!resultado.valido && this.value !== "") {
                showError(errorContainer, resultado.mensagem);
                this.classList.add("input-error");
                this.classList.remove("input-success");
            } else {
                clearError(errorContainer);
                this.classList.remove("input-error");
                if (this.value !== "") {
                    this.classList.add("input-success");
                } else {
                    this.classList.remove("input-success");
                }
            }

            updateContatoButtonState();
        }, 500);
    });

    whatsappInput.addEventListener("blur", function () {
        const resultado = validarWhatsapp(this.value);

        if (!resultado.valido && this.value !== "") {
            showError(errorContainer, resultado.mensagem);
            this.classList.add("input-error");
            this.classList.remove("input-success");
        } else if (resultado.valido) {
            clearError(errorContainer);
            this.classList.remove("input-error");
            this.classList.add("input-success");
        } else {
            this.classList.remove("input-error");
            this.classList.remove("input-success");
        }

        updateContatoButtonState();
    });

    // Permitir apenas números e teclas de controle
    whatsappInput.addEventListener("keypress", function (e) {
        const key = e.key;
        if (
            !/^\d$/.test(key) &&
            key !== "Backspace" &&
            key !== "Delete" &&
            key !== "ArrowLeft" &&
            key !== "ArrowRight" &&
            key !== "Tab"
        ) {
            e.preventDefault();
        }
    });
}

// Impedir envio do formulário se o email for inválido
modalSenhaVencidaForm.addEventListener("submit", function (e) {
    const email = emailRecuperar.value.trim();
    const card = cartaoRecuperar.value.trim();

    if (!isValidEmail(email)) {
        e.preventDefault();
        showModalError("Por favor, insira um e-mail válido antes de enviar.");
        emailRecuperar.classList.add("input-error");
        emailRecuperar.focus();
        return;
    }

    if (!isValidCard(card)) {
        e.preventDefault();
        showModalError(
            "Por favor, insira um cartão de segurança válido antes de enviar."
        );
        cartaoRecuperar.classList.add("input-error");
        cartaoRecuperar.focus();
    }
});

// Impedir envio do formulário de login se o cartão for inválido
document.getElementById("loginForm").addEventListener("submit", function (e) {
    const card = cartaoSeg.value.trim();

    if (!isValidCard(card)) {
        e.preventDefault();
        cartaoSegError.textContent =
            "Por favor, insira um cartão de segurança válido antes de enviar.";
        cartaoSegError.style.display = "block";
        cartaoSeg.classList.add("input-error");
        cartaoSeg.focus();
    }
});

// Impedir envio do formulário de contato se algum campo for inválido
document
    .querySelector(".formulario-container.registro form")
    .addEventListener("submit", function (e) {
        const nomeInput = document.querySelector('input[name="nome"]');
        const empresaInput = document.querySelector('input[name="empresa"]');
        const whatsappInput = document.getElementById("whatsapp");
        const emailInput = document.getElementById("user_email_contato");
        const errorContainer = document.getElementById(
            "contato-error-container"
        );

        const resultadoNome = validarNome(nomeInput.value);
        const resultadoEmpresa = validarEmpresa(empresaInput.value);
        const resultadoWhatsapp = validarWhatsapp(whatsappInput.value);
        const resultadoEmail = isValidEmail(emailInput.value.trim());

        let temErro = false;
        let mensagemErro = "";

        if (!resultadoNome.valido) {
            mensagemErro = resultadoNome.mensagem;
            nomeInput.classList.add("input-error");
            nomeInput.focus();
            temErro = true;
        } else if (!resultadoEmpresa.valido) {
            mensagemErro = resultadoEmpresa.mensagem;
            empresaInput.classList.add("input-error");
            if (!temErro) empresaInput.focus();
            temErro = true;
        } else if (!resultadoWhatsapp.valido) {
            mensagemErro = resultadoWhatsapp.mensagem;
            whatsappInput.classList.add("input-error");
            if (!temErro) whatsappInput.focus();
            temErro = true;
        } else if (!resultadoEmail) {
            mensagemErro =
                "Por favor, insira um e-mail válido (ex: exemplo@dominio.com).";
            emailInput.classList.add("input-error");
            if (!temErro) emailInput.focus();
            temErro = true;
        }

        if (temErro) {
            e.preventDefault();
            showError(errorContainer, mensagemErro);
        }
    });

document.addEventListener("DOMContentLoaded", function () {
    setupRealTimeValidation(userEmailLogin, loginErrorContainer, true);
    setupRealTimeValidation(userEmailContato, contatoErrorContainer, false);
    setupModalEmailValidation();
    setupCardValidation(cartaoSeg, cartaoSegError, loginSubmitBtn, false);
    setupCardValidation(
        cartaoRecuperar,
        cartaoRecuperarError,
        modalSubmitBtn,
        true
    );
    setupNomeValidation();
    setupEmpresaValidation();
    setupWhatsappValidation();

    setupRealTimeFormValidation();

    // Configurar event listeners para os formulários
    document
        .getElementById("loginForm")
        .addEventListener("submit", mostrarTelaCarregando);
    document
        .querySelector(".formulario-container.registro form")
        .addEventListener("submit", mostrarTelaCarregando);

    // Inicializar estado dos botões
    updateLoginButtonState();
    updateContatoButtonState();

    btnRegistrar.addEventListener("click", () =>
        container.classList.add("active")
    );
    btnEntrar.addEventListener("click", () =>
        container.classList.remove("active")
    );

    // --- Selecionar automaticamente o plano vindo da landpage ---
    function stripAccents(str) {
        return str
            .normalize("NFD")
            .replace(/[\u0300-\u036f]/g, "")
            .toLowerCase()
            .trim();
    }

    const urlParams = new URLSearchParams(window.location.search);
    const planoParamRaw = urlParams.get("plano");

    if (planoParamRaw) {
        const planoParam = stripAccents(planoParamRaw);
        const selectPlano = document.querySelector('select[name="plano"]');

        if (selectPlano) {
            let opcaoEncontrada = Array.from(selectPlano.options).find(
                (opt) => {
                    const val = stripAccents(opt.value || "");
                    const txt = stripAccents(opt.textContent || "");
                    return val.includes(planoParam) || txt.includes(planoParam);
                }
            );

            if (!opcaoEncontrada) {
                const novaOpcao = document.createElement("option");
                novaOpcao.value = planoParamRaw;
                novaOpcao.textContent =
                    planoParamRaw.charAt(0).toUpperCase() +
                    planoParamRaw.slice(1);
                selectPlano.appendChild(novaOpcao);
                opcaoEncontrada = novaOpcao;
            }

            selectPlano.value = opcaoEncontrada.value;
            selectPlano.classList.add("input-success");
            selectPlano.focus();

            // Abre o painel de contato automaticamente
            container.classList.add("active");

            // Rolagem suave até o formulário
            const registroForm = document.querySelector(
                ".formulario-container.registro"
            );
            if (registroForm)
                registroForm.scrollIntoView({
                    behavior: "smooth",
                    block: "center",
                });

            // Remove ?plano da URL
            const url = new URL(window.location);
            url.searchParams.delete("plano");
            window.history.replaceState({}, document.title, url.toString());
        } else {
            container.classList.add("active");
        }
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
