const formBusca = document.getElementById("formBuscaCodigo");
const inputCodigo = document.getElementById("inputCodigo");
const mensagemErro = document.getElementById("mensagemErro");
const formCadastro = document.getElementById("formCadastroProduto");
const imagemProduto = document.getElementById("imagemProduto");

const nomeProduto = document.getElementById("nomeProduto");
const dataValidade = document.getElementById("dataValidade");
const codigoBarra = document.getElementById("codigoBarra");
const valorVenda = document.getElementById("valorVenda");
const valorCompra = document.getElementById("valorCompra");
const lucro = document.getElementById("lucro");
const fornecedor = document.getElementById("fornecedor");
const situacao = document.getElementById("situacao");
const btnCancelar = document.getElementById("btnCancelar");

function limparFormulario() {
    formCadastro.reset();
    codigoBarra.value = "";
    imagemProduto.innerHTML =
        '<span class="text-muted">Imagem do produto</span>';
    formCadastro.classList.add("d-none");
    mensagemErro.classList.add("d-none");
    inputCodigo.value = "";
    inputCodigo.focus();
}

function preencherFormulario(produto, codigo) {
    nomeProduto.value = produto.description || "";
    codigoBarra.value = codigo || "";

    if (produto.thumbnail) {
        imagemProduto.innerHTML = `<img src="${produto.thumbnail}" alt="Imagem do Produto" class="img-fluid rounded" style="max-height:150px;">`;
    } else {
        imagemProduto.innerHTML =
            '<span class="text-muted">Imagem do produto</span>';
    }

    formCadastro.classList.remove("d-none");
}

async function consultarProduto(codigo) {
    mensagemErro.classList.add("d-none");
    try {
        const res = await fetch(
            `https://api.cosmos.bluesoft.com.br/gtins/${codigo}`,
            {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json",
                    "X-Cosmos-Token": "CYPxDw3T-3fmTBDk7bInsg",
                    "User-Agent": "Cosmos-API-Request",
                },
            }
        );
        if (!res.ok) throw new Error("Produto não encontrado");
        const data = await res.json();
        if (data && data.description) {
            preencherFormulario(data, codigo);
        } else {
            throw new Error("Produto não encontrado");
        }
    } catch (error) {
        mensagemErro.textContent = error.message;
        mensagemErro.classList.remove("d-none");
        formCadastro.classList.add("d-none");
    }
}

formBusca.addEventListener("submit", (e) => {
    e.preventDefault();
    const codigo = inputCodigo.value.trim();
    if (codigo.length < 6) {
        mensagemErro.textContent =
            "Informe um código de barras válido (mínimo 6 caracteres).";
        mensagemErro.classList.remove("d-none");
        formCadastro.classList.add("d-none");
        return;
    }
    consultarProduto(codigo);
});

btnCancelar.addEventListener("click", limparFormulario);

formCadastro.addEventListener("submit", (e) => {
    e.preventDefault();
    if (!nomeProduto.value.trim()) {
        nomeProduto.classList.add("is-invalid");
        nomeProduto.focus();
        return;
    } else {
        nomeProduto.classList.remove("is-invalid");
    }
    alert("Produto salvo (implemente a lógica de salvar).");
    limparFormulario();
});

nomeProduto.addEventListener("input", () => {
    if (nomeProduto.classList.contains("is-invalid")) {
        nomeProduto.classList.remove("is-invalid");
    }
});

inputCodigo.focus();
