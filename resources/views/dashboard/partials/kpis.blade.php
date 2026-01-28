@props(['profissionais', 'pacientes', 'agendamentos'])
<div class="kpi-row">
    <div class="kpi-card">{{ $pacientes }} Pacientes</div>
    <div class="kpi-card">
        @if ($agendamentos > 1)
            {{ $agendamentos }} Consultas hoje
        @else
            Sem consultas Hoje.
        @endif
    </div>
    <div class="kpi-card">R$ 24.580</div>
    <div class="kpi-card">{{ $profissionais }} {{ $profissionais > 1 ? 'Profissionais' : 'Profissional' }}</div>
</div>