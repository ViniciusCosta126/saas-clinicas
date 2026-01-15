@extends('layout')

@section('main')
    @vite(['resources/css/paginas/criar-conta/index.scss'])
    <section id="criar-conta">
        <div class="container criar-conta">
            <div class="criar-conta-card">
                <div class="header-auth">
                    <h2>Bem-vindo</h2>
                    <p>Crie a conta da sua clínica para começar.</p>
                </div>

                <form class="criar-conta-form" method="POST">
                    @csrf
                    <div class="input-group">
                        <label for="nome_clinica">Nome da Clínica</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-hospital"></i>
                            <input type="text" id="nome_clinica" name="nome_clinica" placeholder="Ex: Clínica Sorriso" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="nome_responsavel">Nome do Responsável</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-user-tie"></i>
                            <input type="text" id="nome_responsavel" name="nome_responsavel" placeholder="Seu nome completo" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="email">E-mail Profissional</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="email@clinica.com" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="password">Senha</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" id="password" name="senha" placeholder="Mínimo 8 caracteres" required>
                        </div>
                    </div>

                    <div class="input-group">
                        <label for="telefone">Telefone / WhatsApp</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-phone"></i>
                            <input type="text" id="telefone" name="telefone" placeholder="(00) 00000-0000" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary-auth">Criar minha conta</button>

                    <div class="extra-links">
                        <span>Já tem conta? <a href="/login">Faça login</a></span>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection