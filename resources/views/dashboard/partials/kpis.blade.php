@props(['profissionais'])
<div class="kpi-row">
    <div class="kpi-card">128 Pacientes</div>
    <div class="kpi-card">32 Consultas Hoje</div>
    <div class="kpi-card">R$ 24.580</div>
    <div class="kpi-card">{{ $profissionais }} {{ $profissionais > 1 ? 'Profissionais' : 'Profissional' }}</div>
</div>
