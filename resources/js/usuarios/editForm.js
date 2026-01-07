window.editUser = function(button) {
    const id = button.getAttribute('data-id');
    const nome = button.getAttribute('data-nome');
    const email = button.getAttribute('data-email');
    const role = button.getAttribute('data-role');
    const cpf = button.getAttribute('data-cpf');
    const telefone = button.getAttribute('data-telefone');
    
    document.getElementById('edit_nome').value = nome;
    document.getElementById('edit_email').value = email;
    document.getElementById('edit_role').value = role;
    document.getElementById('edit_cpf').value = cpf; 
    document.getElementById('edit_telefone').value = telefone;  
    
    const form = document.getElementById('formEditUser');
    form.action = `/usuarios/update/${id}`;

    openModal('modalEditUser');
}