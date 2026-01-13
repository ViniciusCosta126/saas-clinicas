@props(['usuarios'])
<x-modal-global id="criarNovoProfissional" title="Adicionar um novo profissional">
    <form action="{{ route('profissionais.store') }}" method="POST" class="invite-form">
        @csrf
        <div class="form-grid">
            <div class="form-group full-width">
                <label for="user_id">Usuario</label>
                <div class="input-wrapper @error('user_id') input-error @enderror">
                    <i class="fa-solid fa-briefcase"></i>
                    <select name="user_id" id="user_id">
                        <option value="" disabled selected>Selecione um usuario...</option>
                        @foreach ($usuarios as $usuario )
                        <option 
                            value="{{ $usuario->id }}"
                            data-clinica="{{ \App\Helpers\ClinicaHelper::getNomeClinica($usuario->clinica_id) }}"
                            data-clinica_id="{{ $usuario->clinica_id }}"
                            data-email="{{ $usuario->email }}"
                            data-nome="{{ $usuario->name }}"
                            {{ old('user_id') == $usuario->id ? 'selected' : '' }}
                        >
                            {{ $usuario->name }}
                        </option>
                        @endforeach
                    </select>   
                </div>
                @error('role') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group full-width">
                <label for="clinica_nome">Clinica</label>
                <div class="input-wrapper @error('clinica_nome') input-erro @enderror">
                    <i class="fa-solid fa-house"></i>
                    <input readonly type="text" name="clinica_nome" id="clinica_nome" value="">
                    <input hidden type="text" name="clinica_id" id="clinica_id" value="">
                </div>
            </div>
            <div class="form-group">
                <label for="nome">Nome Completo</label>
                <div class="input-wrapper @error('nome') input-error @enderror">
                    <i class="fa-solid fa-user"></i>
                    <input readonly type="text" name="nome" id="nome" placeholder="Ex: João Silva" value="{{ old('nome') }}">
                </div>
                @error('nome') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="email">E-mail do usuario</label>
                <div class="input-wrapper @error('email') input-error @enderror">
                    <i class="fa-solid fa-envelope"></i>
                    <input readonly type="email" name="email" id="email" placeholder="email@exemplo.com"
                        value="{{ old('email') }}">
                </div>
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="especialidade">Especialidade</label>
                <div class="input-wrapper @error('especialidade') input-error @enderror">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="especialidade" id="especialidade" placeholder=""
                        value="{{ old('especialidade') }}">
                </div>
                @error('especialidade') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group">
                <label for="preco_sessao">Preço Sessão</label>
                <div class="input-wrapper @error('preco_sessao') input-error @enderror">
                    <i class="fa-solid fa-dollar-sign"></i>
                    <input type="number" step="0.01" min="0" name="preco_sessao" id="preco_sessao" placeholder="50.00"
                        value="{{ old('preco_sessao') }}">
                </div>
                @error('preco_sessao') <span class="error-message">{{ $message }}</span> @enderror
            </div>

        </div>
        <div class="form-actions">
            <button type="submit" class="btn-submit">
                <i class="fa-solid fa-paper-plane"></i> Criar profissional
            </button>
        </div>
    </form>
</x-modal-global>