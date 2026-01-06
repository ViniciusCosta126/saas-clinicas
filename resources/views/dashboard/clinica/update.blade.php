@extends('dashboard.layout')

@section('content')
@vite(['resources/css/dashboard/clinica/update.scss'])

<div class="dashboard-main">
    <x-titulo-dash titulo="Editar Clínica" subtitulo="Atualize as informações cadastrais e de contato."/>

    @if(session('success'))
        <div class="alert-success">
            <i class="fa-solid fa-circle-check"></i>
            {{ session('success') }}
        </div>
    @endif

    <div class="card-container">
        <form action="{{ route('clinica.update', $clinica->id) }}" method="POST" class="edit-form">
            @csrf
            @method('PUT')

            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="nome_clinica">Nome da Clínica</label>
                    <div class="input-wrapper @error('nome_clinica') input-error @enderror">
                        <i class="fa-solid fa-hospital"></i>
                        <input type="text" name="nome_clinica" id="nome_clinica" value="{{ old('nome_clinica', $clinica->nome_clinica) }}">
                    </div>
                    @error('nome_clinica')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="nome_responsavel">Responsável Técnico</label>
                    <div class="input-wrapper @error('nome_responsavel') input-error @enderror">
                        <i class="fa-solid fa-user-tie"></i>
                        <input type="text" name="nome_responsavel" id="nome_responsavel" value="{{ old('nome_responsavel', $clinica->nome_responsavel) }}">
                    </div>
                    @error('nome_responsavel')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone / WhatsApp</label>
                    <div class="input-wrapper @error('telefone') input-error @enderror">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $clinica->telefone) }}" maxlength="11">
                    </div>
                    @error('telefone')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label for="email">E-mail Corporativo</label>
                    <div class="input-wrapper @error('email') input-error @enderror">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" name="email" id="email" value="{{ old('email', $clinica->email) }}">
                    </div>
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('clinica.index') }}" class="btn-cancel">Cancelar</a>
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-check"></i> Salvar Alterações
                </button>
            </div>
        </form>
    </div>
</div>
@endsection