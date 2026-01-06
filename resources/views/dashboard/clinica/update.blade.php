@extends('dashboard.layout')

@section('content')
@vite(['resources/css/dashboard/clinica/update.scss'])
<div class="dashboard-main">
    <header class="page-header">
        <div class="header-info">
            <h1>Editar Clínica</h1>
            <p>Atualize as informações cadastrais e de contato.</p>
        </div>
    </header>

    <div class="card-container">
        <form action="{{ route('clinica.update', $clinica->id) }}" method="POST" class="edit-form">
            @csrf
            @method('PUT')
            <div class="form-grid">
                <div class="form-group full-width">
                    <label for="nome_clinica">Nome da Clínica</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-hospital"></i>
                        <input type="text" name="nome_clinica" id="nome_clinica" value="{{ old('nome_clinica', $clinica->nome_clinica) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="nome_responsavel">Responsável Técnico</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user-tie"></i>
                        <input type="text" name="nome_responsavel" id="nome_responsavel" value="{{ old('nome_responsavel', $clinica->nome_responsavel) }}" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="telefone">Telefone / WhatsApp</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-phone"></i>
                        <input type="text" name="telefone" id="telefone" value="{{ old('telefone', $clinica->telefone) }}" maxlength="11" required>
                    </div>
                </div>

                <div class="form-group full-width">
                    <label for="email">E-mail Corporativo</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-envelope"></i>
                        <input type="email" name="email" id="email" value="{{ old('email', $clinica->email) }}" required>
                    </div>
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