@extends('layout')

@section('main')
    @vite(['resources/css/paginas/login/index.scss'])
    <section id="login">
        <div class="container login">
            <div class="login-card">
                <h2>Bem Vindo</h2>
                <p>Insira sua conta para continuar</p>
                <form class="login-form" method="post">
                    @csrf
                    <div class="input-group">
                        <i class="fas fa-envelope input-icon"></i>
                        <input type="email" id="email" placeholder="Email" name="email" required>
                    </div>

                    <div class="input-group">
                        <i class="fas fa-lock input-icon"></i>
                        <input type="password" id="password" name="senha" placeholder="Senha" required>
                    </div>

                    <button type="submit">Entrar</button>

                    <div class="extra-links">
                        <a href="/criar-conta">Criar conta</a>
                        <a href="#">Esqueceu sua senha?</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection