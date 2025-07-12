document.getElementById("zip_code").addEventListener("blur", function () {
    const cep = this.value.replace(/\D/g, "");
    const url = `https://viacep.com.br/ws/${cep}/json/`;
    if (cep.length === 8) {
        fetch(url)
            .then((res) => res.json())
            .then((data) => {
                const place = document.getElementById("place");
                const neighborhood = document.getElementById("neighborhood");
                const city = document.getElementById("city");
                const number = document.getElementById("number");
                const state = document.getElementById("state");
                if (!data.erro) {
                    place.value = data.logradouro || "";
                    neighborhood.value = data.bairro || "";
                    city.value = data.localidade || "";
                    number.value = data.complemento || "";
                    state.value = data.uf || "";
                } else {
                    alert("CEP não encontrado.");
                }
            });
    } else if (cep.length > 0) {
        alert("CEP inválido. Deve conter 8 dígitos.");
    }
});

document.getElementById("type").addEventListener("change", function () {
    const type = this.value;
    const label = document.getElementById("label-doc");
    const input = document.getElementById("cpf_cnpj");
    input.value = "";
    if (type === "FISICA") {
        label.textContent = "CPF";
        input.setAttribute("placeholder", "Digite o CPF");
        input.maxLength = 11;
    } else if (type === "JURIDICA") {
        label.textContent = "CNPJ";
        input.setAttribute("placeholder", "Digite o CNPJ");
        input.maxLength = 14;
    }
});

let isDocumentValid = false;

document.getElementById("cpf_cnpj").addEventListener("blur", async function () {
    const type = document.getElementById("type").value;
    const value = this.value.replace(/\D/g, "");

    if (type === "JURIDICA") {
        if (value.length === 14) {
            try {
                const res = await fetch(
                    `https://brasilapi.com.br/api/cnpj/v1/${value}`
                );
                if (!res.ok) throw new Error("CNPJ inválido");
                const data = await res.json();
                console.log("CNPJ válido:", data);
                if (data.nome_fantasia) {
                    document.getElementById("trade_name").value =
                        data.nome_fantasia;
                }
                isDocumentValid = true;
            } catch (error) {
                alert("CNPJ inválido ou não encontrado");
                isDocumentValid = false;
            }
        } else {
            alert("CNPJ deve conter 14 dígitos.");
            isDocumentValid = false;
        }
    } else if (type === "FISICA") {
        if (validarCPF(value)) {
            isDocumentValid = true;
        } else {
            alert("CPF inválido");
            isDocumentValid = false;
        }
    }
});

function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, "");
    if (cpf.length !== 11 || /^(\d)\1{10}$/.test(cpf)) return false;

    let soma = 0;
    for (let i = 0; i < 9; i++) soma += parseInt(cpf.charAt(i)) * (10 - i);
    let resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    if (resto !== parseInt(cpf.charAt(9))) return false;

    soma = 0;
    for (let i = 0; i < 10; i++) soma += parseInt(cpf.charAt(i)) * (11 - i);
    resto = (soma * 10) % 11;
    if (resto === 10 || resto === 11) resto = 0;
    return resto === parseInt(cpf.charAt(10));
}

document.querySelectorAll(".tab-item").forEach((tab) => {
    tab.addEventListener("click", () => {
        document
            .querySelectorAll(".tab-item")
            .forEach((item) => item.classList.remove("active"));
        document
            .querySelectorAll(".tab-section")
            .forEach((section) => section.classList.remove("active"));

        tab.classList.add("active");
        document.getElementById(tab.dataset.tab).classList.add("active");
    });
});

document
    .getElementById("formFornecedor")
    .addEventListener("submit", function (e) {
        if (!isDocumentValid) {
            e.preventDefault();
            alert("CPF ou CNPJ inválido. Verifique antes de salvar.");
        }
    });
