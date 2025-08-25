let isCnpjValid = false;

// Consulta CEP via ViaCEP
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
                alert("CEP não encontrado.");
            }
        });
});

// Consulta CNPJ via BrasilAPI
document.getElementById("cnpj").addEventListener("blur", async function () {
    const cnpj = this.value.replace(/\D/g, "");
    if (cnpj.length !== 14) return;
    try {
        const res = await fetch(`https://brasilapi.com.br/api/cnpj/v1/${cnpj}`);
        if (!res.ok) throw new Error("CNPJ inválido");
        const data = await res.json();
        document.getElementById("businessName").value = data.razao_social || "";
        document.getElementById("tradeName").value = data.nome_fantasia || "";
        document.getElementById("cep").value = data.cep || "";
        document.getElementById("place").value = data.logradouro || "";
        document.getElementById("neighborhood").value = data.bairro || "";
        document.getElementById("city").value = data.municipio || "";
        document.getElementById("state").value = data.uf || "";
        isCnpjValid = true;
    } catch {
        alert("CNPJ inválido ou não encontrado.");
        isCnpjValid = false;
    }
});

// Validação no submit
document.getElementById("formEmpresa").addEventListener("submit", function (e) {
    if (!isCnpjValid) {
        e.preventDefault();
        alert("CNPJ inválido. Verifique antes de salvar.");
    }
});

// Toggle senha
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
