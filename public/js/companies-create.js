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

    async function validateCEP() {
        const cepInput = document.getElementById("cep");
        const cepStatus = document.getElementById("cepStatus");
        const cep = cepInput.value;

        cepStatus.className = "validation-status d-none";
        isCepValid = false;

        if (!cep.trim()) {
            showJsError("Por favor, informe o CEP.");
            cepInput.focus();
            return;
        }

        if (!isValidCEPFormat(cep)) {
            showJsError("Formato de CEP inválido. Use o formato: 00000-000");
            cepStatus.innerHTML =
                '<i class="bi bi-x-circle validation-icon"></i> Formato inválido';
            cepStatus.className = "validation-status invalid";
            cepInput.focus();
            return;
        }

        cepStatus.innerHTML =
            '<div class="validation-loading"></div> Buscando endereço...';
        cepStatus.className = "validation-status";

        if (cepApiTimeout) {
            clearTimeout(cepApiTimeout);
        }

        const timeoutPromise = new Promise((_, reject) => {
            cepApiTimeout = setTimeout(
                () => reject(new Error("Tempo excedido na consulta do CEP")),
                10000
            );
        });

        try {
            const cepNumbers = cep.replace(/\D/g, "");
            const apiPromise = fetch(
                `https://viacep.com.br/ws/${cepNumbers}/json/`
            );

            const res = await Promise.race([apiPromise, timeoutPromise]);

            if (!res.ok) throw new Error("CEP não encontrado");

            const data = await res.json();

            if (data.erro) {
                throw new Error("CEP não encontrado");
            }

            document.getElementById("place").value = data.logradouro || "";
            document.getElementById("neighborhood").value = data.bairro || "";
            document.getElementById("city").value = data.localidade || "";
            document.getElementById("state").value = data.uf || "";

            cepStatus.innerHTML =
                '<i class="bi bi-check-circle validation-icon"></i> CEP válido';
            cepStatus.className = "validation-status valid";
            isCepValid = true;
        } catch (error) {
            console.error("Erro na validação do CEP:", error);

            if (error.message.includes("Tempo excedido")) {
                showJsError(
                    "A consulta ao CEP está demorando muito. Você pode continuar, mas verifique o endereço manualmente."
                );
                cepStatus.innerHTML =
                    '<i class="bi bi-exclamation-triangle validation-icon"></i> Verifique manualmente (timeout)';
                cepStatus.className = "validation-status";
                isCepValid = true;
            } else {
                showJsError(
                    "CEP não encontrado. Verifique ou preencha o endereço manualmente."
                );
                cepStatus.innerHTML =
                    '<i class="bi bi-exclamation-triangle validation-icon"></i> CEP não encontrado';
                cepStatus.className = "validation-status";
                isCepValid = true;
            }
        } finally {
            clearTimeout(cepApiTimeout);
        }
    }

    function validarNumero(input) {
        if (input.value < 0) {
            input.value = 0;
        }
    }

    function validarNome(input) {
        input.value = input.value.replace(/[^A-Za-zÀ-ÿ\s]/g, '');
    }

    async function validateEmail() {
        const emailInput = document.getElementById("user_email");
        const emailStatus = document.getElementById("emailStatus");
        const email = emailInput.value.trim();

        emailStatus.className = "validation-status d-none";
        isEmailValid = false;

        if (!email) {
            showJsError("Por favor, informe o e-mail.");
            emailInput.focus();
            emailStatus.innerHTML =
                '<i class="bi bi-x-circle validation-icon"></i> O e-mail é obrigatório';
            emailStatus.className = "validation-status invalid";
            return;
        }

        if (!isValidEmailFormat(email)) {
            showJsError(
                "Formato de e-mail inválido. Use o formato: exemplo@dominio.com"
            );
            emailStatus.innerHTML =
                '<i class="bi bi-x-circle validation-icon"></i> Formato de e-mail inválido';
            emailStatus.className = "validation-status invalid";
            emailInput.focus();
            return;
        }

        emailStatus.innerHTML =
            '<div class="validation-loading"></div> Verificando disponibilidade...';
        emailStatus.className = "validation-status";

        const apiPromise = fetch(`/check-email?email=${encodeURIComponent(email)}`);
        const timeoutPromise = new Promise((_, reject) =>
            setTimeout(() => reject(new Error("Tempo limite excedido")), 5000)
        );

        try {
            const res = await Promise.race([apiPromise, timeoutPromise]);

            if (!res.ok) {
                if (res.status === 409) {
                    const data = await res.json();
                    const errorMessage = data.message || "E-mail já em uso";
                    showJsError(errorMessage);
                    emailStatus.innerHTML =
                        '<i class="bi bi-x-circle validation-icon"></i> ' +
                        errorMessage;
                    emailStatus.className = "validation-status invalid";
                    emailInput.focus();
                    return;
                }
                throw new Error("Erro ao verificar e-mail");
            }

            const data = await res.json();
            if (data.available) {
                emailStatus.innerHTML =
                    '<i class="bi bi-check-circle validation-icon"></i> E-mail disponível';
                emailStatus.className = "validation-status valid";
                isEmailValid = true;
            }
        } catch (err) {
            console.error("Erro na validação do e-mail:", err);
            const errorMessage = err.message.includes("Tempo limite excedido")
                ? "A verificação está demorando muito. Você pode continuar, mas verifique posteriormente."
                : "Erro ao verificar e-mail. Tente novamente.";

            showJsError(errorMessage);
            emailStatus.innerHTML =
                '<i class="bi bi-exclamation-triangle validation-icon"></i> Erro na verificação';
            emailStatus.className = "validation-status";
        }
    }

    document.getElementById("cnpj").addEventListener("input", function () {
        this.value = formatCNPJ(this.value);
    });

    document.getElementById("cep").addEventListener("input", function () {
        this.value = formatCEP(this.value);
    });

    document.getElementById("cnpj").addEventListener("blur", async function () {
        const cnpjInput = this;
        const cnpjStatus = document.getElementById("cnpjStatus");
        const cnpj = cnpjInput.value;

        cnpjStatus.className = "validation-status d-none";
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
            cnpjStatus.className = "validation-status invalid";
            cnpjInput.focus();
            return;
        }

        if (!isValidCNPJ(cnpj)) {
            showJsError("CNPJ inválido. Verifique os dígitos.");
            cnpjStatus.innerHTML =
                '<i class="bi bi-x-circle validation-icon"></i> CNPJ inválido';
            cnpjStatus.className = "validation-status invalid";
            cnpjInput.focus();
            return;
        }

        cnpjStatus.innerHTML =
            '<div class="validation-loading"></div> Validando CNPJ na Receita Federal...';
        cnpjStatus.className = "validation-status";

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

            if (data.cep) {
                const formattedCep = formatCEP(data.cep.replace(/\D/g, ""));
                document.getElementById("cep").value = formattedCep;
                await validateCEP();
            } else {
                document.getElementById("cep").value = "";
            }

            document.getElementById("place").value = data.logradouro || "";
            document.getElementById("neighborhood").value = data.bairro || "";
            document.getElementById("city").value = data.municipio || "";
            document.getElementById("state").value = data.uf || "";

            cnpjStatus.innerHTML =
                '<i class="bi bi-check-circle validation-icon"></i> CNPJ válido';
            cnpjStatus.className = "validation-status valid";
            isCnpjValid = true;
        } catch (error) {
            console.error("Erro na validação do CNPJ:", error);

            if (error.message.includes("Tempo excedido")) {
                showJsError(
                    "A consulta ao CNPJ está demorando muito. Você pode continuar, mas verifique os dados manualmente."
                );
                cnpjStatus.innerHTML =
                    '<i class="bi bi-exclamation-triangle validation-icon"></i> Verifique manualmente (timeout)';
                cnpjStatus.className = "validation-status";
                isCnpjValid = true;
            } else {
                showJsError(
                    "CNPJ não encontrado na base oficial. Verifique ou preencha os dados manualmente."
                );
                cnpjStatus.innerHTML =
                    '<i class="bi bi-exclamation-triangle validation-icon"></i> CNPJ não encontrado - verifique';
                cnpjStatus.className = "validation-status";
                isCnpjValid = true;
            }
        } finally {
            clearTimeout(cnpjApiTimeout);
        }
    });

    document.getElementById("cep").addEventListener("blur", validateCEP);

    document.getElementById("user_email").addEventListener("input", function () {
        clearTimeout(emailCheckTimeout);
        emailCheckTimeout = setTimeout(validateEmail, 700); 
    });

    document.getElementById("user_email").addEventListener("blur", validateEmail);

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
        if (!isCepValid) {
            e.preventDefault();
            showJsError("CEP inválido. Verifique antes de salvar.");
            document.getElementById("cep").focus();
            return;
        }
        if (!isEmailValid) {
            e.preventDefault();
            showJsError("E-mail inválido ou já em uso. Verifique antes de salvar.");
            document.getElementById("user_email").focus();
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

// Função para gerar senha forte
function generateStrongPassword() {
    const length = 12;
    const uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    const lowercase = 'abcdefghijklmnopqrstuvwxyz';
    const numbers = '0123456789';
    const symbols = '!@#$%^&*()_+-=[]{}|;:,.<>?';
    
    let password = '';
    password += uppercase[Math.floor(Math.random() * uppercase.length)];
    password += lowercase[Math.floor(Math.random() * lowercase.length)];
    password += numbers[Math.floor(Math.random() * numbers.length)];
    password += symbols[Math.floor(Math.random() * symbols.length)];
    
    const allChars = uppercase + lowercase + numbers + symbols;
    for (let i = password.length; i < length; i++) {
        password += allChars[Math.floor(Math.random() * allChars.length)];
    }
    
    password = password.split('').sort(() => Math.random() - 0.5).join('');
    
    // Atualiza o campo de senha
    const passwordField = document.getElementById('user_password');
    passwordField.value = password;
    passwordField.dispatchEvent(new Event('input'));
    
    // Atualiza o campo de confirmação de senha
    const confirmField = document.getElementById('user_password_confirmation');
    confirmField.value = password;
    confirmField.dispatchEvent(new Event('input'));
    
    showJsError("Senha forte gerada com sucesso!", 3000);
}