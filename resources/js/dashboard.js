
window.addEventListener("DOMContentLoaded", () => {
    document.querySelector('.user-menu').addEventListener('click', function (e) {
        this.classList.toggle('active');
        // Impede que o clique feche imediatamente se clicar dentro do menu
        e.stopPropagation();
    });
    window.onclick = function () {
        document.querySelector('.user-menu').classList.remove('active');
    }
})
