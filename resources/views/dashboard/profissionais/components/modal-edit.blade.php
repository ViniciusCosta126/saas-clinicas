<x-modal-global id="modalEditProfissional" title="Editar Informações do Usuário">
    <form id="formEditProfissional" method="POST" class="invite-form">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="edit_preco_sessao">Preço Sessão</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-user"></i>
                    <input type="number" step="0.01" min="0" name="preco_sessao" id="edit_preco_sessao" placeholder="50.00"
                        value="{{ old('preco_sessao') }}">
                </div>
            </div>

            <div class="form-group">
                <label for="edit_especialidade">Especialidade</label>
                <div class="input-wrapper">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" name="especialidade" id="edit_especialidade" placeholder=""
                        value="{{ old('especialidade') }}">
                </div>
            </div>

            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-check"></i> Salvar Alterações
            </button>
        </div>
    </form>
</x-modal-global>