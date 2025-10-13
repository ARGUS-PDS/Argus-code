// Funções de API para CEP, CNPJ e Email

// Função para preenchimento automático do endereço
function autoFillAddress(data) {
    const fieldsToAutoFill = [
        { id: "place", value: data.logradouro },
        { id: "neighborhood", value: data.bairro },
        { id: "city", value: data.localidade },
        { id: "state", value: data.uf },
    ];

    fieldsToAutoFill.forEach((field) => {
        const element = document.getElementById(field.id);
        // Só preenche se estiver vazio ou se o valor atual for igual ao anterior da API
        if (
            element &&
            (!element.value || element.dataset.autoFilled === "true")
        ) {
            element.value = field.value || "";
            element.dataset.autoFilled = "true";
            element.classList.add("is-valid");
            updateFieldState(field.id, true);
        }
    });
}

// Função para preenchimento automático dos dados da empresa
function autoFillCompanyData(data) {
    const fieldsToAutoFill = [
        { id: "businessName", value: data.razao_social },
        { id: "tradeName", value: data.nome_fantasia },
    ];

    fieldsToAutoFill.forEach((field) => {
        const element = document.getElementById(field.id);
        if (
            element &&
            (!element.value || element.dataset.autoFilled === "true")
        ) {
            element.value = field.value || "";
            element.dataset.autoFilled = "true";
            element.classList.add("is-valid");
            updateFieldState(field.id, true);
        }
    });

    // Preenche CEP se estiver disponível - SEMPRE atualiza quando o CNPJ mudar
    if (data.cep) {
        const formattedCep = formatCEP(data.cep.replace(/\D/g, ""));
        const cepField = document.getElementById("cep");
        cepField.value = formattedCep;
        cepField.dataset.autoFilled = "true";

        // Dispara validação do CEP após um breve delay
        setTimeout(() => validateCEP(true), 2000);
    }

    // Preenche outros campos de endereço se disponíveis
    if (data.logradouro && !document.getElementById("place").value) {
        document.getElementById("place").value = data.logradouro;
        document.getElementById("place").dataset.autoFilled = "true";
        document.getElementById("place").classList.add("is-valid");
        updateFieldState("place", true);
    }

    if (data.bairro && !document.getElementById("neighborhood").value) {
        document.getElementById("neighborhood").value = data.bairro;
        document.getElementById("neighborhood").dataset.autoFilled = "true";
        document.getElementById("neighborhood").classList.add("is-valid");
        updateFieldState("neighborhood", true);
    }

    if (data.municipio && !document.getElementById("city").value) {
        document.getElementById("city").value = data.municipio;
        document.getElementById("city").dataset.autoFilled = "true";
        document.getElementById("city").classList.add("is-valid");
        updateFieldState("city", true);
    }

    if (data.uf && !document.getElementById("state").value) {
        document.getElementById("state").value = data.uf;
        document.getElementById("state").classList.add("is-valid");
        updateFieldState("state", true);
    }
}

// Função para tratamento de erro do CEP
function handleCEPError(error, cepStatus, cepInput) {
    if (error.message.includes("Tempo excedido")) {
        showJsError(
            "A consulta ao CEP está demorando muito. Você pode continuar, mas verifique o endereço manualmente."
        );
        cepStatus.innerHTML =
            '<i class="bi bi-exclamation-triangle validation-icon"></i> Verifique manualmente (timeout)';
        cepStatus.className = "validation-status warning";
        isCepValid = true;
        cepInput.classList.add("is-valid");
        updateFieldState("cep", true);
    } else {
        showJsError(
            "CEP não encontrado. Verifique ou preencha o endereço manualmente."
        );
        cepStatus.innerHTML =
            '<i class="bi bi-exclamation-triangle validation-icon"></i> CEP não encontrado';
        cepStatus.className = "validation-status warning";
        isCepValid = true;
        cepInput.classList.add("is-valid");
        updateFieldState("cep", true);
    }
}

async function validateCEP(forceValidation = false) {
    return new Promise(async (resolve) => {
        const cepInput = document.getElementById("cep");
        const cepStatus = document.getElementById("cepStatus");
        const cep = cepInput.value.replace(/\D/g, "");

        // Só valida se tiver 8 dígitos ou se for forçada a validação
        if (cep.length !== 8 && !forceValidation) {
            cepInput.classList.remove("is-valid", "is-invalid");
            cepStatus.className = "validation-status d-none";
            isCepValid = false;
            updateFieldState("cep", false);
            updateSubmitButton();
            resolve();
            return;
        }

        cepInput.classList.remove("is-valid", "is-invalid");
        cepStatus.className = "validation-status d-none";
        isCepValid = false;
        updateFieldState("cep", false);

        if (!cep.trim()) {
            if (forceValidation) {
                showJsError("Por favor, informe o CEP.");
                cepInput.focus();
                cepInput.classList.add("is-invalid");
            }
            updateSubmitButton();
            resolve();
            return;
        }

        if (!isValidCEPFormat(cepInput.value)) {
            if (forceValidation) {
                showJsError(
                    "Formato de CEP inválido. Use o formato: 00000-000"
                );
                cepStatus.innerHTML =
                    '<i class="bi bi-x-circle validation-icon"></i> Formato inválido';
                cepStatus.className = "validation-status invalid";
                cepInput.classList.add("is-invalid");
                cepInput.focus();
            }
            updateSubmitButton();
            resolve();
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

            // Preenche automaticamente apenas se estiver vazio ou se o usuário não tiver modificado
            autoFillAddress(data);

            cepStatus.innerHTML =
                '<i class="bi bi-check-circle validation-icon"></i> CEP válido';
            cepStatus.className = "validation-status valid";
            isCepValid = true;
            cepInput.classList.add("is-valid");
            updateFieldState("cep", true);
        } catch (error) {
            console.error("Erro na validação do CEP:", error);
            handleCEPError(error, cepStatus, cepInput);
        } finally {
            clearTimeout(cepApiTimeout);
            updateSubmitButton();
            resolve();
        }
    });
}

async function validateEmail(forceValidation = false) {
    return new Promise(async (resolve) => {
        const emailInput = document.getElementById("user_email");
        const emailStatus = document.getElementById("emailStatus");
        const email = emailInput.value.trim();

        emailInput.classList.remove("is-valid", "is-invalid");
        emailStatus.className = "validation-status d-none";
        isEmailValid = false;
        updateFieldState("user_email", false);

        if (!email) {
            if (forceValidation) {
                showJsError("Por favor, informe o e-mail.");
                emailInput.focus();
                emailInput.classList.add("is-invalid");
                emailStatus.innerHTML =
                    '<i class="bi bi-x-circle validation-icon"></i> O e-mail é obrigatório';
                emailStatus.className = "validation-status invalid";
            }
            updateSubmitButton();
            resolve();
            return;
        }

        if (!isValidEmailFormat(email)) {
            if (forceValidation) {
                showJsError(
                    "Formato de e-mail inválido. Use o formato: exemplo@dominio.com"
                );
                emailStatus.innerHTML =
                    '<i class="bi bi-x-circle validation-icon"></i> Formato de e-mail inválido';
                emailStatus.className = "validation-status invalid";
                emailInput.classList.add("is-invalid");
                emailInput.focus();
            }
            updateSubmitButton();
            resolve();
            return;
        }

        // Se não for forçada, só valida o formato e marca como válido para não bloquear o formulário
        if (!forceValidation) {
            emailStatus.innerHTML =
                '<i class="bi bi-check-circle validation-icon"></i> Formato válido';
            emailStatus.className = "validation-status valid";
            isEmailValid = true;
            emailInput.classList.add("is-valid");
            updateFieldState("user_email", true);
            updateSubmitButton();
            resolve();
            return;
        }

        // Se for forçada, faz a verificação de disponibilidade
        emailStatus.innerHTML =
            '<div class="validation-loading"></div> Verificando disponibilidade...';
        emailStatus.className = "validation-status";

        try {
            const response = await fetch(
                `/check-email?email=${encodeURIComponent(email)}`
            );
            const data = await response.json();

            if (!response.ok) {
                if (response.status === 409) {
                    showJsError(data.message);
                    emailStatus.innerHTML =
                        '<i class="bi bi-x-circle validation-icon"></i> ' +
                        data.message;
                    emailStatus.className = "validation-status invalid";
                    emailInput.classList.add("is-invalid");
                    emailInput.focus();
                    updateSubmitButton();
                    resolve();
                    return;
                }
                throw new Error("Erro ao verificar e-mail");
            }

            if (data.available) {
                emailStatus.innerHTML =
                    '<i class="bi bi-check-circle validation-icon"></i> ' +
                    data.message;
                emailStatus.className = "validation-status valid";
                isEmailValid = true;
                emailInput.classList.add("is-valid");
                updateFieldState("user_email", true);
            }
        } catch (err) {
            console.error("Erro na validação do e-mail:", err);
            const errorMessage = err.message.includes("Tempo limite excedido")
                ? "A verificação está demorando muito. Você pode continuar, mas verifique posteriormente."
                : "Erro ao verificar e-mail. Tente novamente.";

            showJsError(errorMessage);
            emailStatus.innerHTML =
                '<i class="bi bi-exclamation-triangle validation-icon"></i> Erro na verificação';
            emailStatus.className = "validation-status warning";
            // Em caso de erro, consideramos válido para não bloquear o usuário, mas não marcamos como válido visualmente
            isEmailValid = true;
            emailInput.classList.add("is-valid");
            updateFieldState("user_email", true);
        } finally {
            updateSubmitButton();
            resolve();
        }
    });
}

async function validateCNPJ(forceValidation = false) {
    return new Promise(async (resolve) => {
        const cnpjInput = document.getElementById("cnpj");
        const cnpjStatus = document.getElementById("cnpjStatus");
        const cnpj = cnpjInput.value.replace(/\D/g, "");

        // Só valida se tiver 14 dígitos ou se for forçada a validação
        if (cnpj.length !== 14 && !forceValidation) {
            cnpjInput.classList.remove("is-valid", "is-invalid");
            cnpjStatus.className = "validation-status d-none";
            isCnpjValid = false;
            updateFieldState("cnpj", false);
            updateSubmitButton();
            resolve();
            return;
        }

        cnpjInput.classList.remove("is-valid", "is-invalid");
        cnpjStatus.className = "validation-status d-none";
        isCnpjValid = false;
        updateFieldState("cnpj", false);

        if (!cnpj.trim()) {
            if (forceValidation) {
                showJsError("Por favor, informe o CNPJ.");
                cnpjInput.focus();
                cnpjInput.classList.add("is-invalid");
            }
            updateSubmitButton();
            resolve();
            return;
        }

        if (!isValidCNPJFormat(cnpjInput.value)) {
            if (forceValidation) {
                showJsError(
                    "Formato de CNPJ inválido. Use o formato: 00.000.000/0000-00"
                );
                cnpjStatus.innerHTML =
                    '<i class="bi bi-x-circle validation-icon"></i> Formato inválido';
                cnpjStatus.className = "validation-status invalid";
                cnpjInput.classList.add("is-invalid");
                cnpjInput.focus();
            }
            updateSubmitButton();
            resolve();
            return;
        }

        if (!isValidCNPJ(cnpj)) {
            if (forceValidation) {
                showJsError("CNPJ inválido. Verifique os dígitos.");
                cnpjStatus.innerHTML =
                    '<i class="bi bi-x-circle validation-icon"></i> CNPJ inválido';
                cnpjStatus.className = "validation-status invalid";
                cnpjInput.classList.add("is-invalid");
                cnpjInput.focus();
            }
            updateSubmitButton();
            resolve();
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

            if (!res.ok)
                throw new Error("CNPJ não encontrado na base de dados");

            const data = await res.json();

            // Preenche automaticamente os dados da empresa
            autoFillCompanyData(data);

            cnpjStatus.innerHTML =
                '<i class="bi bi-check-circle validation-icon"></i> CNPJ válido';
            cnpjStatus.className = "validation-status valid";
            isCnpjValid = true;
            cnpjInput.classList.add("is-valid");
            updateFieldState("cnpj", true);
        } catch (error) {
            console.error("Erro na validação do CNPJ:", error);

            if (error.message.includes("Tempo excedido")) {
                showJsError(
                    "A consulta ao CNPJ está demorando muito. Você pode continuar, mas verifique os dados manualmente."
                );
                cnpjStatus.innerHTML =
                    '<i class="bi bi-exclamation-triangle validation-icon"></i> Verifique manualmente (timeout)';
                cnpjStatus.className = "validation-status warning";
                isCnpjValid = true;
                cnpjInput.classList.add("is-valid");
                updateFieldState("cnpj", true);
            } else {
                showJsError(
                    "CNPJ não encontrado na base oficial. Verifique ou preencha os dados manualmente."
                );
                cnpjStatus.innerHTML =
                    '<i class="bi bi-exclamation-triangle validation-icon"></i> CNPJ não encontrado - verifique';
                cnpjStatus.className = "validation-status warning";
                isCnpjValid = true;
                cnpjInput.classList.add("is-valid");
                updateFieldState("cnpj", true);
            }
        } finally {
            clearTimeout(cnpjApiTimeout);
            updateSubmitButton();
            resolve();
        }
    });
}

// Função para limpar campos de endereço quando o CEP é alterado
function clearAddressFields() {
    const addressFields = ["place", "neighborhood", "city", "state"];

    addressFields.forEach((fieldId) => {
        const field = document.getElementById(fieldId);
        if (field && field.dataset.autoFilled === "true") {
            field.value = "";
            field.dataset.autoFilled = "false";
            field.classList.remove("is-valid");
            updateFieldState(fieldId, false);
        }
    });
}

// Função para limpar campos da empresa quando o CNPJ é alterado
function clearCompanyFields() {
    const companyFields = ["businessName", "tradeName"];

    companyFields.forEach((fieldId) => {
        const field = document.getElementById(fieldId);
        if (field && field.dataset.autoFilled === "true") {
            field.value = "";
            field.dataset.autoFilled = "false";
            field.classList.remove("is-valid");
            updateFieldState(fieldId, false);
        }
    });

    // Também limpa o CEP se foi preenchido automaticamente
    const cepField = document.getElementById("cep");
    if (cepField && cepField.dataset.autoFilled === "true") {
        cepField.value = "";
        cepField.dataset.autoFilled = "false";
        cepField.classList.remove("is-valid");
        updateFieldState("cep", false);
        clearAddressFields();
    }
}

// Função para validar formato básico antes de chamar a API
function validateBasicFormat(fieldType, value) {
    switch (fieldType) {
        case "cnpj":
            return value.replace(/\D/g, "").length === 14;
        case "cep":
            return value.replace(/\D/g, "").length === 8;
        case "email":
            return isValidEmailFormat(value);
        default:
            return true;
    }
}
