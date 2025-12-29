@extends('layout')

@section('main')
    @vite(['resources/css/paginas/criar-conta/index.scss'])
    <section id="criar-conta">
        <div class="container criar-conta">
            <div class="criar-conta-card">
                <h2>Bem Vindo</h2>
                <p>Insira seus dados para criar a conta da sua clinica</p>
                <form class="criar-conta-form">
                    <div class="input-group">
                        <input type="email" id="email" placeholder="Email" required>
                    </div>

                    <div class="input-group">
                        <input type="password" id="password" placeholder="Senha" required>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" placeholder="Nome clinica" required>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" placeholder="Nome do Responsavel" required>
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" placeholder="Telefone" required>
                    </div>

                    <button type="submit">Criar conta</button>

                    <div class="extra-links">
                        <a href="/login">Ja tem conta? Faça login</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection