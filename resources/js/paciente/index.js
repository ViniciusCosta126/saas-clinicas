window.editPaciente = function (button) {
    openModal('modalEditPaciente');
    const id = button.getAttribute('data-id');
    const nome = button.getAttribute("data-nome")
    const email = button.getAttribute("data-email")
    const telefone = button.getAttribute("data-telefone")
    const aniversario = button.getAttribute("data-aniversario")

    document.getElementById('edit_nome').value = nome;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_telefone').value = telefone;
    document.getElementById('edit_aniversario').value = aniversario;

    const form = document.getElementById('formEditPaciente');
    form.action = `/pacientes/update/${id}`;   
}