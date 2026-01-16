<x-modal-global id="modalCriarAgendamento" title="Novo Agendamento">
    <form action="{{ route('agendamento.store') }}" method="POST" class="invite-form">
        @csrf
        <input type="hidden" name="paciente_id" id="paciente_id" value="">
        <input type="hidden" name="clinica_id" id="clinica_id" value="{{ auth()->user()->clinica->id }}">
        <input type="hidden" name="profissional_id" id="profissional_id" value="{{ auth()->user()->profissional->id }}">

        <div class="form-grid">
            <div class="form-group full-width">
                <label for="nome_paciente">Paciente</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" id="nome_paciente" readonly placeholder="Paciente selecionado...">
                </div>
            </div>

            <div class="form-group">
                <label for="status">Status Inicial</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-circle-info"></i>
                    <select name="status" id="status">
                        <option value="agendado">Agendado</option>
                        <option value="confirmado">Confirmado</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="data">Data do Agendamento</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-calendar-day"></i>
                    <input type="date" name="data" id="data_agendamento" required onchange="buscarHorariosLivres()">
                </div>
            </div>

            <div class="form-group">
                <label for="horario_inicio">Horários Disponíveis</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-clock"></i>
                    <select name="horario_inicio" id="horario_inicio" required onchange="definirHorarioFim()">
                        <option value="">Selecione uma data primeiro</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="horario_fim">Término (1h de duração)</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-stopwatch"></i>
                    <input type="time" name="horario_fim" id="horario_fim" readonly style="background: #f8fafc;">
                </div>
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Criar agendamento
            </button>
        </div>
    </form>
</x-modal-global>