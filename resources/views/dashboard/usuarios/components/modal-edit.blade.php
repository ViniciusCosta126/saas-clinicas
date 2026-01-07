<x-modal-global id="modalEditUser" title="Editar Informações do Usuário">
    <form id="formEditUser" method="POST" class="invite-form">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="edit_nome">Nome Completo</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="name" id="edit_nome" placeholder="Nome do usuário">
                </div>
            </div>

            <div class="form-group">
                <label for="edit_email">E-mail</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" id="edit_email" placeholder="email@exemplo.com">
                </div>
            </div>

            <div class="form-group">
                <label for="edit_telefone">Telefone</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" name="telefone" id="edit_telefone" placeholder="1699999999">
                </div>
            </div>

            <div class="form-group">
                <label for="edit_cpf">Cpf</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" name="cpf" id="edit_cpf" placeholder="11111111111">
                </div>
            </div>

            <div class="form-group full-width">
                <label for="edit_role">Função no Sistema</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-briefcase"></i>
                    <select name="role" id="edit_role">
                        <option value="admin">Administrador</option>
                        <option value="profissional">Profissional / Médico</option>
                        <option value="recepcao">Recepção</option>
                        <option value="financeiro">Financeiro</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-check"></i> Salvar Alterações
            </button>
        </div>
    </form>
</x-modal-global>