<aside class="sidebar">
    <div class="sidebar-logo">Lumina</div>
    <nav class="sidebar-nav">
        <a href="/dashboard"><i class="fa-solid fa-chart-line"></i>Dashboard</a>

        <a href="{{ route("agendamento.index") }}"><i class="fa-solid fa-calendar-days"></i>Agenda</a>
        @if(auth()->user()->hasPermission('pacientes.manage'))
            <a href="{{ route('pacientes.index') }}"><i class="fa-solid fa-user-injured"></i>Pacientes</a>
        @endif

        @if(auth()->user()->hasPermission('profissionais.manage'))
            <a href="{{ route('profissionais.index') }}"><i class="fa-solid fa-user-doctor"></i>Profissionais</a>
        @endif
        <a href="#"><i class="fa-solid fa-money-bill-trend-up"></i>Financeiro</a>

        @if(auth()->user()->hasPermission('config.manage'))
            <a href="{{ route('config.manage') }}"><i class="fa-solid fa-gear"></i>Configurações</a>
        @endif

        @if(auth()->user()->hasPermission('usuarios'))
            <a href="{{ route('usuarios.index') }}"><i class="fa-solid fa-user"></i>Usuarios</a>
        @endif
    </nav>
</aside>