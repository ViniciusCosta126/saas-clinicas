@extends('dashboard.layout')

@section('content')
    @vite(['resources/css/dashboard/meu-perfil/index.scss'])
    <div class="dashboard-main">
        <x-titulo-dash titulo="Meu Perfil" subtitulo="Gerencie suas informações pessoais e de segurança." />

        <div class="profile-grid">
            <div class="profile-card profile-sidebar">
                <div class="profile-avatar-wrapper">
                    <img src="{{ auth()->user()->profile_photo }}" alt="Foto de Perfil" class="user-avatar">
                    <button class="btn-change-photo"><i class="fa-solid fa-camera"></i></button>
                </div>
                <div class="profile-bio">
                    <h3>{{ auth()->user()->name }}</h3>
                    <span>{{ auth()->user()->role ?? 'Administrador' }}</span>
                    <p class="clinic-tag"><i class="fa-solid fa-hospital"></i>
                        {{ auth()->user()->clinica->nome_clinica ?? 'Sem Nome' }}</p>
                </div>
            </div>

            <div class="profile-content">
                <div class="profile-card">
                    <div class="card-header">
                        <h4><i class="fa-solid fa-user-gear"></i> Dados Pessoais</h4>
                    </div>
                    <form action="{{ route('update-meu-perfil') }}" class="profile-form" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="form-group">
                                <label>Nome Completo</label>
                                <input type="text" name="name" value="{{ auth()->user()->name }}">
                            </div>
                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" name="email" value="{{ auth()->user()->email }}">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <label>Telefone</label>
                                <input type="text" name="telefone" placeholder="(11) 99999-9999"
                                    value="{{ auth()->user()->telefone }}">
                            </div>
                            <div class="form-group">
                                <label>CPF</label>
                                <input type="text" name="cpf" placeholder="000.000.000-00"
                                    value="{{ auth()->user()->cpf }}">
                            </div>
                        </div>
                        <button type="submit" class="btn-save">Salvar Alterações</button>
                    </form>
                </div>

                <div class="profile-card mt-4">
                    <div class="card-header">
                        <h4><i class="fa-solid fa-lock"></i> Segurança</h4>
                    </div>
                    <form action="{{ route('update-senha') }}" method="POST" class="profile-form">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group" style="flex: 100%;">
                                <label>Senha Atual</label>
                                <input type="password" name="current_password" required>
                                @error('current_password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label>Nova Senha</label>
                                <input type="password" name="password" placeholder="Mínimo 8 caracteres" required>
                                @error('password') <span class="text-danger">{{ $message }}</span> @enderror
                            </div>
                            <div class="form-group">
                                <label>Confirmar Senha</label>
                                <input type="password" name="password_confirmation" required>
                            </div>
                        </div>
                        <button type="submit" class="btn-outline">Atualizar Senha</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection