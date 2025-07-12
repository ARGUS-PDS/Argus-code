document.getElementById("cep").addEventListener("blur", function () {
    const cep = this.value.replace(/\D/g, "");
    if (cep.length === 8) {
        fetch(`https://viacep.com.br/ws/${cep}/json/`)
            .then((response) => response.json())
            .then((data) => {
                if (!data.erro) {
                    document.getElementById("logradouro").value =
                        data.logradouro || "";
                    document.getElementById("bairro").value = data.bairro || "";
                    document.getElementById("cidade").value =
                        data.localidade || "";
                    document.getElementById("estado").value = data.uf || "";
                } else {
                    alert("CEP não encontrado.");
                }
            })
            .catch(() => {
                alert("Erro ao buscar o CEP.");
            });
    }
});

function validarCPF(cpf) {
    cpf = cpf.replace(/[^\d]+/g, "");
    if (cpf.length !== 11 || /^(\d)\1+$/.test(cpf)) return false;

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

// Usando jQuery para o evento blur do CPF
// Verifique se o jQuery está realmente carregado antes de usar $
if (typeof jQuery != "undefined") {
    $("#cpf").on("blur", function () {
        const cpf = $(this).val();
        const status = validarCPF(cpf);
        $("#cpf-status").text(status ? "" : "CPF inválido");
    });
} else {
    // Fallback para JavaScript puro se jQuery não estiver disponível
    document.getElementById("cpf").addEventListener("blur", function () {
        const cpf = this.value;
        const status = validarCPF(cpf);
        document.getElementById("cpf-status").textContent = status
            ? ""
            : "CPF inválido";
    });
}
