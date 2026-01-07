@extends('layout')

@section('main')
    @vite(['resources/css/paginas/criar-conta/index.scss'])
    <section id="criar-conta">
        <div class="container criar-conta">
            <div class="criar-conta-card">
                <h2>Bem Vindo</h2>
                <p>Insira seus dados para ingressar na clinica: {{ \App\Helpers\ClinicaHelper::getNomeClinica($convite->clinica_id) }}</p>
                <form class="criar-conta-form" method="POST" action="{{ route('usuarios.criar-conta.invite',$convite->id) }}">
                    @csrf
                    <div class="input-group">
                        <input type="password" id="password" name="senha" placeholder="Senha" required>
                    </div>

                    <div class="input-group">
                        <input type="text" id="telefone" name="telefone" placeholder="Telefone" required>
                    </div>
                    <div class="input-group">
                        <input type="text" id="telefone" name="cpf" placeholder="Cpf" required>
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