<aside class="sidebar">
    <div class="sidebar-logo">SaaS Clínicas</div>
    <nav class="sidebar-nav">
        <a href="/dashboard"><i class="fa-solid fa-chart-line"></i>Dashboard</a>

        <a href="#"><i class="fa-solid fa-calendar-days"></i>Agenda</a>

        <a href="#"><i class="fa-solid fa-user-injured"></i>Pacientes</a>

        <a href="#"><i class="fa-solid fa-user-doctor"></i>Profissionais</a>

        <a href="#"><i class="fa-solid fa-money-bill-trend-up"></i>Financeiro</a>

        @if(auth()->user()->hasPermission('config.manage'))
            <a href="{{ route('config.manage') }}"><i class="fa-solid fa-gear"></i>Configurações</a>
        @endif
    </nav>
</aside>