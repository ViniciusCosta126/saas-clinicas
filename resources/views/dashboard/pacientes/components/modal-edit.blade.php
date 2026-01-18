@props(['usuarios'])
<x-modal-global id="modalEditPaciente" title="Editar paciente">
    <form action="{{ route('pacientes.store') }}" method="POST" class="invite-form" id="formEditPaciente">
        @csrf
        @method('PUT')
        <input type="text" name="clinica_id" id="clinica_id" hidden value="{{ auth()->user()->clinica->id }}">
        <div class="form-grid">
            <div class="form-group full-width">
                <label for="edit_nome">Nome Completo</label>
                <div class="input-wrapper @error('nome') input-error @enderror">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="nome" id="edit_nome" placeholder="Ex: João Silva" value="{{ old('nome') }}">
                </div>
                @error('nome') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label for="edit_email">E-mail do paciente</label>
                <div class="input-wrapper @error('email') input-error @enderror">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" id="edit_email" placeholder="email@exemplo.com"
                        value="{{ old('email') }}">
                </div>
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label for="edit_telefone">Telefone</label>
                <div class="input-wrapper @error('telefone') input-error @enderror">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" name="telefone" id="edit_telefone" placeholder=""
                        value="{{ old('telefone') }}">
                </div>
                @error('telefone') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label for="edit_aniversario">Aniversario</label>
                <div class="input-wrapper @error('aniversario') input-error @enderror">
                    <i class="fa-solid fa-calendar"></i>
                    <input type="date" name="aniversario" id="edit_aniversario" placeholder="50.00"
                        value="{{ old('aniversario') }}">
                </div>
                @error('aniversario') <span class="error-message">{{ $message }}</span> @enderror
            </div>

        </div>
        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Salvar Paciente
            </button>
        </div>
    </form>
</x-modal-global>