
window.addEventListener("DOMContentLoaded", () => {
    window.openModal = function (id) {
        const modal = document.getElementById(id);
        modal.classList.remove('closing');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    window.closeModal = function (id) {
        const modal = document.getElementById(id);
        modal.classList.add('closing');
        setTimeout(() => {
            modal.classList.remove('active');
            modal.classList.remove('closing');
            document.body.style.overflow = 'auto';
        }, 200);
    }

    const snacks = document.querySelectorAll('.snack');

    snacks.forEach(snack => {
        setTimeout(() => {
            snack.style.transform = "translateX(120%)";
            snack.style.transition = "0.5s";
            setTimeout(() => snack.remove(), 500);
        }, 5000);
    });
})

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
