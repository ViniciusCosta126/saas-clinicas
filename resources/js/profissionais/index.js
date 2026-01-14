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

window.editUser = function (button) {
     openModal('modalEditProfissional');
    const id = button.getAttribute('data-id');
    const preco = button.getAttribute('data-preco_sessao');
    const precoNumero = parseFloat(preco);


    const especialidade = button.getAttribute('data-especialidade');

    document.getElementById('edit_preco_sessao').value = isNaN(precoNumero) ? 0.00 : precoNumero;
    document.getElementById('edit_especialidade').value = especialidade;

    const form = document.getElementById('formEditProfissional');
    form.action = `/profissionais/update/${id}`;

   
}