@props(['usuarios'])
<x-modal-global id="criarNovoPaciente" title="Adicionar um novo paciente">
    <form action="{{ route('profissionais.store') }}" method="POST" class="invite-form">
        @csrf
        <div class="form-grid">
            <div class="form-group full-width">
                <label for="nome">Nome Completo</label>
                <div class="input-wrapper @error('nome') input-error @enderror">
                    <i class="fa-solid fa-user"></i>
                    <input readonly type="text" name="nome" id="nome" placeholder="Ex: João Silva" value="{{ old('nome') }}">
                </div>
                @error('nome') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label for="email">E-mail do paciente</label>
                <div class="input-wrapper @error('email') input-error @enderror">
                    <i class="fa-solid fa-envelope"></i>
                    <input readonly type="email" name="email" id="email" placeholder="email@exemplo.com"
                        value="{{ old('email') }}">
                </div>
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label for="telefone">Telefone</label>
                <div class="input-wrapper @error('telefone') input-error @enderror">
                    <i class="fa-solid fa-phone"></i>
                    <input type="text" name="telefone" id="telefone" placeholder=""
                        value="{{ old('telefone') }}">
                </div>
                @error('telefone') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label for="aniversario">Aniversario</label>
                <div class="input-wrapper @error('aniversario') input-error @enderror">
                    <i class="fa-solid fa-calendar"></i>
                    <input type="date" name="aniversario" id="aniversario" placeholder="50.00"
                        value="{{ old('aniversario') }}">
                </div>
                @error('aniversario') <span class="error-message">{{ $message }}</span> @enderror
            </div>

        </div>
        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Criar Paciente
            </button>
        </div>
    </form>
</x-modal-global>