let isCnpjValid = false;

document.querySelector("input[name='cep']").addEventListener("blur", function () {
    const cep = this.value.replace(/\D/g, "");
    const url = `https://viacep.com.br/ws/${cep}/json/`;

    if (cep.length === 8) {
        fetch(url)
            .then(res => res.json())
            .then(data => {
                if (!data.erro) {
                    document.querySelector("input[name='place']").value = data.logradouro || "";
                    document.querySelector("input[name='neighborhood']").value = data.bairro || "";
                    document.querySelector("input[name='city']").value = data.localidade || "";
                    document.querySelector("input[name='number']").value = data.complemento || "";
                    document.querySelector("input[name='state']").value = data.uf || "";
                } else {
                    alert("CEP não encontrado.");
                }
            });
    } else if (cep.length > 0) {
        alert("CEP inválido. Deve conter 8 dígitos.");
    }
});

document.querySelector("input[name='cnpj']").addEventListener("blur", async function () {
    const cnpj = this.value.replace(/\D/g, "");

    if (cnpj.length === 14) {
        try {
            const res = await fetch(`https://brasilapi.com.br/api/cnpj/v1/${cnpj}`);
            if (!res.ok) throw new Error("CNPJ inválido");

            const data = await res.json();

            document.querySelector("input[name='businessName']").value = data.razao_social || "";
            document.querySelector("input[name='tradeName']").value = data.nome_fantasia || "";
            document.querySelector("input[name='cep']").value = data.cep?.replace("-", "") || "";
            document.querySelector("input[name='place']").value = data.logradouro || "";
            document.querySelector("input[name='neighborhood']").value = data.bairro || "";
            document.querySelector("input[name='city']").value = data.municipio || "";
            document.querySelector("input[name='state']").value = data.uf || "";
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

document.getElementById("formEmpresa").addEventListener("submit", function (e) {
    if (!isCnpjValid) {
        e.preventDefault();
        alert("CNPJ inválido. Verifique antes de salvar.");
    }
});
