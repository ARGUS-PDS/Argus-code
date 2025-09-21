// Funções de interface do usuário
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