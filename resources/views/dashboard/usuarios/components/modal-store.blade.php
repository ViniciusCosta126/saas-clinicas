<x-modal-global id="criarNovoUsuario" title="Adicionar um novo usuario">
    <form action="{{ route('usuarios.invites.store') }}" method="POST" class="invite-form">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <div class="input-wrapper @error('nome') input-error @enderror">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="nome" id="nome" placeholder="Ex: João Silva" value="{{ old('nome') }}">
                </div>
                @error('nome') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">E-mail de Convite</label>
                <div class="input-wrapper @error('email') input-error @enderror">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" id="email" placeholder="email@exemplo.com"
                        value="{{ old('email') }}">
                </div>
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label for="role">Função no Sistema</label>
                <div class="input-wrapper @error('role') input-error @enderror">
                    <i class="fa-solid fa-briefcase"></i>
                    <select name="role" id="role">
                        <option value="" disabled selected>Selecione uma função...</option>
                        <option value="admin">Administrador</option>
                        <option value="profissional">Profissional / Médico</option>
                        <option value="recepcao">Recepção</option>
                        <option value="financeiro">Financeiro</option>
                    </select>
                </div>
                @error('role') <span class="error-message">{{ $message }}</span> @enderror
            </div>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Enviar Convite
            </button>
        </div>
    </form>
</x-modal-global>