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

window.cancelaAgendamento = (button) => {
    openModal('cancelaAtendimento')
    const id = button.getAttribute('data-id');
    const form = document.getElementById('cancelaAtendimentoForm');
    form.action = `/agendamento/cancelar-agendamento/${id}`;
}

window.confirmarPresenca = (button) => {
    openModal('confirmaPresencaAtendimento')
    const id = button.getAttribute('data-id');
    const form = document.getElementById('confirmaPresencaAtendimentoForm');
    form.action = `/agendamento/altera-status-atendimento/${id}`;
}

window.concluirAgendamento = (button) => {
    openModal('confirmaComparecimentoAtendimento');

    const id = button.getAttribute('data-id');

    document.querySelectorAll('.acaoAgendamentoForm')
        .forEach(form => {
            const acao = form.dataset.acao;
            form.action = `/agendamento/${id}/${acao}`;
        });
};