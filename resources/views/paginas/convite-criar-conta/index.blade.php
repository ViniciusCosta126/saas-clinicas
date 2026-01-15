@extends('layout')

@section('main')
    @vite(['resources/css/paginas/criar-conta/index.scss'])
    <section id="criar-conta">
        <div class="container criar-conta">
            <div class="criar-conta-card">
                <div class="header-auth">
                    <i class="fa-solid fa-envelope-open-text" style="font-size: 2rem; color: #38bdf8; margin-bottom: 15px;"></i>
                    <h2>Quase lá!</h2>
                    <p>Complete seus dados para ingressar na <br><strong>{{ \App\Helpers\ClinicaHelper::getNomeClinica($convite->clinica_id) }}</strong></p>
                </div>

                <form class="criar-conta-form" method="POST" action="{{ route('usuarios.criar-conta.invite', $convite->id) }}">
                    @csrf
                    
                    <div class="input-group">
                        <label for="password">Defina sua Senha</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" id="password" name="senha" placeholder="Mínimo 8 caracteres" required autofocus>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="telefone">Telefone / WhatsApp</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="cpf">Seu CPF</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-id-card"></i>
                            <input type="text" id="cpf" name="cpf" placeholder="000.000.000-00" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-auth">Concluir meu Cadastro</button>

                    <div class="extra-links">
                        <span>Já possui acesso? <a href="/login">Faça login</a></span>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection