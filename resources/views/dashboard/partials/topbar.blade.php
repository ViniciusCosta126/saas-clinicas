<header class="topbar">
    <div class="topbar-left">
        <h2 class="clinic-name">{{ auth()->user()->clinica->nome_clinica }}</h2>
    </div>

    <div class="topbar-right">
        <button class="btn-icon">
            <i class="fa-regular fa-bell"></i>
            <span class="badge"></span>
        </button>

        <div class="user-menu" tabindex="0">
            <div class="user-info">
                <span class="user-name">{{ auth()->user()->name }}</span>
                <span class="user-role">{{ auth()->user()->role }}</span>
            </div>
            <img src="https://placehold.co/38x38" alt="Avatar" class="user-avatar">
            <i class="fa-solid fa-chevron-down user-dropdown-icon"></i>

            <div class="topbar-user-dropdown">
                <a href="#"><i class="fa-regular fa-user"></i> Meu Perfil</a>
                <a href="#"><i class="fa-solid fa-hospital"></i> Dados da Clínica</a>
                <hr>
                <a href="#" class="logout"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</a>
            </div>
        </div>
    </div>
</header>