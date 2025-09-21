// Funções de API para CEP, CNPJ e Email
async function validateCEP() {
    const cepInput = document.getElementById("cep");
    const cepStatus = document.getElementById("cepStatus");
    const cep = cepInput.value;

    cepInput.classList.remove('is-valid', 'is-invalid');
    cepStatus.className = "validation-status d-none";
    isCepValid = false;
    updateFieldState('cep', false);

    if (!cep.trim()) {
        showJsError("Por favor, informe o CEP.");
        cepInput.focus();
        cepInput.classList.add('is-invalid');
        updateSubmitButton();
        return;
    }

    if (!isValidCEPFormat(cep)) {
        showJsError("Formato de CEP inválido. Use o formato: 00000-000");
        cepStatus.innerHTML =
            '<i class="bi bi-x-circle validation-icon"></i> Formato inválido';
        cepStatus.className = "validation-status invalid";
        cepInput.classList.add('is-invalid');
        cepInput.focus();
        updateSubmitButton();
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

        // Atualizar estados dos campos preenchidos automaticamente
        updateFieldState('place', true);
        updateFieldState('neighborhood', true);
        updateFieldState('city', true);
        updateFieldState('state', true);

        // Adicionar classes de validação nos campos preenchidos
        document.getElementById("place").classList.add('is-valid');
        document.getElementById("neighborhood").classList.add('is-valid');
        document.getElementById("city").classList.add('is-valid');
        document.getElementById("state").classList.add('is-valid');

        cepStatus.innerHTML =
            '<i class="bi bi-check-circle validation-icon"></i> CEP válido';
        cepStatus.className = "validation-status valid";
        isCepValid = true;
        cepInput.classList.add('is-valid');
        updateFieldState('cep', true);
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
            cepInput.classList.add('is-valid');
            updateFieldState('cep', true);
        } else {
            showJsError(
                "CEP não encontrado. Verifique ou preencha o endereço manualmente."
            );
            cepStatus.innerHTML =
                '<i class="bi bi-exclamation-triangle validation-icon"></i> CEP não encontrado';
            cepStatus.className = "validation-status";
            isCepValid = true;
            cepInput.classList.add('is-valid');
            updateFieldState('cep', true);
        }
    } finally {
        clearTimeout(cepApiTimeout);
        updateSubmitButton();
    }
}

async function validateEmail() {
    const emailInput = document.getElementById("user_email");
    const emailStatus = document.getElementById("emailStatus");
    const email = emailInput.value.trim();

    emailInput.classList.remove('is-valid', 'is-invalid');
    emailStatus.className = "validation-status d-none";
    isEmailValid = false;
    updateFieldState('user_email', false);

    if (!email) {
        showJsError("Por favor, informe o e-mail.");
        emailInput.focus();
        emailInput.classList.add('is-invalid');
        emailStatus.innerHTML =
            '<i class="bi bi-x-circle validation-icon"></i> O e-mail é obrigatório';
        emailStatus.className = "validation-status invalid";
        updateSubmitButton();
        return;
    }

    if (!isValidEmailFormat(email)) {
        showJsError(
            "Formato de e-mail inválido. Use o formato: exemplo@dominio.com"
        );
        emailStatus.innerHTML =
            '<i class="bi bi-x-circle validation-icon"></i> Formato de e-mail inválido';
        emailStatus.className = "validation-status invalid";
        emailInput.classList.add('is-invalid');
        emailInput.focus();
        updateSubmitButton();
        return;
    }

    emailStatus.innerHTML =
        '<div class="validation-loading"></div> Verificando disponibilidade...';
    emailStatus.className = "validation-status";

    try {
        const response = await fetch(`/check-email?email=${encodeURIComponent(email)}`);
        const data = await response.json();

        if (!response.ok) {
            if (response.status === 409) {
                showJsError(data.message);
                emailStatus.innerHTML =
                    '<i class="bi bi-x-circle validation-icon"></i> ' +
                    data.message;
                emailStatus.className = "validation-status invalid";
                emailInput.classList.add('is-invalid');
                emailInput.focus();
                updateSubmitButton();
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
            emailInput.classList.add('is-valid');
            updateFieldState('user_email', true);
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
    } finally {
        updateSubmitButton();
    }
}

async function validateCNPJ() {
    const cnpjInput = document.getElementById("cnpj");
    const cnpjStatus = document.getElementById("cnpjStatus");
    const cnpj = cnpjInput.value;

    cnpjInput.classList.remove('is-valid', 'is-invalid');
    cnpjStatus.className = "validation-status d-none";
    isCnpjValid = false;
    updateFieldState('cnpj', false);

    if (!cnpj.trim()) {
        showJsError("Por favor, informe o CNPJ.");
        cnpjInput.focus();
        cnpjInput.classList.add('is-invalid');
        updateSubmitButton();
        return;
    }

    if (!isValidCNPJFormat(cnpj)) {
        showJsError(
            "Formato de CNPJ inválido. Use o formato: 00.000.000/0000-00"
        );
        cnpjStatus.innerHTML =
            '<i class="bi bi-x-circle validation-icon"></i> Formato inválido';
        cnpjStatus.className = "validation-status invalid";
        cnpjInput.classList.add('is-invalid');
        cnpjInput.focus();
        updateSubmitButton();
        return;
    }

    if (!isValidCNPJ(cnpj)) {
        showJsError("CNPJ inválido. Verifique os dígitos.");
        cnpjStatus.innerHTML =
            '<i class="bi bi-x-circle validation-icon"></i> CNPJ inválido';
        cnpjStatus.className = "validation-status invalid";
        cnpjInput.classList.add('is-invalid');
        cnpjInput.focus();
        updateSubmitButton();
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

        // Atualizar estados dos campos preenchidos automaticamente
        updateFieldState('businessName', true);
        updateFieldState('tradeName', true);

        // Adicionar classes de validação nos campos preenchidos
        document.getElementById("businessName").classList.add('is-valid');
        document.getElementById("tradeName").classList.add('is-valid');

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

        // Atualizar estados dos campos preenchidos automaticamente
        updateFieldState('place', true);
        updateFieldState('neighborhood', true);
        updateFieldState('city', true);
        updateFieldState('state', true);

        // Adicionar classes de validação nos campos preenchidos
        document.getElementById("place").classList.add('is-valid');
        document.getElementById("neighborhood").classList.add('is-valid');
        document.getElementById("city").classList.add('is-valid');
        document.getElementById("state").classList.add('is-valid');

        cnpjStatus.innerHTML =
            '<i class="bi bi-check-circle validation-icon"></i> CNPJ válido';
        cnpjStatus.className = "validation-status valid";
        isCnpjValid = true;
        cnpjInput.classList.add('is-valid');
        updateFieldState('cnpj', true);
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
            cnpjInput.classList.add('is-valid');
            updateFieldState('cnpj', true);
        } else {
            showJsError(
                "CNPJ não encontrado na base oficial. Verifique ou preencha os dados manualmente."
            );
            cnpjStatus.innerHTML =
                '<i class="bi bi-exclamation-triangle validation-icon"></i> CNPJ não encontrado - verifique';
            cnpjStatus.className = "validation-status";
            isCnpjValid = true;
            cnpjInput.classList.add('is-valid');
            updateFieldState('cnpj', true);
        }
    } finally {
        clearTimeout(cnpjApiTimeout);
        updateSubmitButton();
    }
}