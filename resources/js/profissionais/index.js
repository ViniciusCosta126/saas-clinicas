window.addEventListener("DOMContentLoaded", () => {
    const select = document.getElementById('user_id')
    select.addEventListener('change', function () {
        const selected = this.options[this.selectedIndex];
        document.getElementById('email').value = selected.dataset.email || '';
        document.getElementById('nome').value = selected.dataset.nome || '';
        document.getElementById('clinica_nome').value = selected.dataset.clinica || ''
        document.getElementById("clinica_id").value = selected.dataset.clinica_id || ''
    });

    if (select.value) {
        select.dispatchEvent(new Event('change'));
    }
})