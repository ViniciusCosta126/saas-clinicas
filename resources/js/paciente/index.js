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

window.createAgendaento = (button) => {
    openModal('modalCriarAgendamento')
    const id_paciente = button.getAttribute('data-id_paciente');
    const nome_paciente = document.getElementById(`nome_paciente${id_paciente}`).innerHTML

    document.getElementById('paciente_id').value = id_paciente
    document.getElementById("nome_paciente").value = nome_paciente
}


window.buscarHorariosLivres = () => {
    window.buscarHorariosLivres = () => {
        const data = document.getElementById('data_agendamento').value;
        const selectHorario = document.getElementById('horario_inicio');
        const campoFim = document.getElementById('horario_fim');
        const profissionalId = document.getElementById('profissional_id').value;

        if (!data) return;

        selectHorario.innerHTML = '<option>Carregando...</option>';
        campoFim.value = "";

        fetch(`/profissionais/horarios-disponiveis?data=${data}&profissional_id=${profissionalId}`)
            .then(response => response.json())
            .then(horarios => {
                selectHorario.innerHTML = '<option value="">Escolha o horário</option>';

                if (horarios.length === 0) {
                    selectHorario.innerHTML = '<option value="">Nenhum horário disponível</option>';
                    return;
                }

                horarios.forEach(hora => {
                    const option = document.createElement('option');
                    option.value = hora;
                    option.textContent = hora;
                    selectHorario.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Erro ao buscar horários:', error);
                selectHorario.innerHTML = '<option value="">Erro ao carregar</option>';
            });
    }
}

window.definirHorarioFim = () => {
    const inicio = document.getElementById('horario_inicio').value;
    const campoFim = document.getElementById('horario_fim');

    if (inicio) {
        let [hora, minuto] = inicio.split(':');
        let horaFim = (parseInt(hora) + 1).toString().padStart(2, '0');
        campoFim.value = `${horaFim}:${minuto}`;
    }
}

document.addEventListener('DOMContentLoaded', function () {
    const dateInput = document.getElementById('data_agendamento');
    const hoje = new Date().toISOString().split('T')[0];
    dateInput.setAttribute('min', hoje);
});