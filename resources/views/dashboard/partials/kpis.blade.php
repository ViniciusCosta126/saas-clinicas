@props(['profissionais', 'pacientes', 'agendamentos'])
<div class="kpi-row">
    <div class="kpi-card">{{ $pacientes }} Pacientes</div>
    <div class="kpi-card">{{ $agendamentos }} {{ $agendamentos > 1 ? 'Consultas' : "Consulta"}} Hoje</div>
    <div class="kpi-card">R$ 24.580</div>
    <div class="kpi-card">{{ $profissionais }} {{ $profissionais > 1 ? 'Profissionais' : 'Profissional' }}</div>
</div>