@extends('layout')

@section('main')
    @vite(['resources/css/paginas/login/index.scss'])
    <section id="login">
        <div class="container login">
            <div class="login-card">
                <div class="header-auth">
                    <h2>Bem-vindo</h2>
                    <p>Acesse sua conta para continuar</p>
                </div>

                <form class="login-form" method="POST">
                    @csrf
                    
                    <div class="input-group">
                        <label for="email">E-mail</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-envelope"></i>
                            <input type="email" id="email" name="email" placeholder="seu@email.com" required autofocus>
                        </div>
                        @error('email') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <div class="input-group">
                        <label for="password">Senha</label>
                        <div class="input-wrapper">
                            <i class="fa-solid fa-lock"></i>
                            <input type="password" id="password" name="password" placeholder="Sua senha" required>
                        </div>
                        @error('password') <span class="error-message">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="btn-primary-auth">Entrar no Sistema</button>

                    <div class="extra-links">
                        <a href="/criar-conta">Não tem conta? <strong>Cadastre-se</strong></a>
                        <a href="#" class="forgot-password">Esqueceu sua senha?</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
@endsection