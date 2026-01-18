window.prepararAgendamento = (horario, data) => {
    openModal('modalCriarAgendamento');

    const inputData = document.getElementById('data_agendamento');
    const selectHorario = document.getElementById('horario_inicio');

    inputData.value = data;
    selectHorario.innerHTML = '';
    const option = document.createElement('option');
    option.value = horario;
    option.textContent = horario;
    option.selected = true;

    selectHorario.appendChild(option);

    definirHorarioFim();
}
