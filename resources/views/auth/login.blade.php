@extends('layout.auth')

@section('title', 'Login - Catálogo de Vinhos')

@section('content')
<div class="auth-page">

    <section class="auth-banner">
        <div class="banner-overlay">
            <h1>Catálogo de Vinhos</h1>
            <p>Organize, descubra e gerencie sua seleção de vinhos.</p>
        </div>
    </section>

    <section class="auth-content">
        <div class="login-card">
            <div class="login-header">
                <div class="logo">🍷</div>
                <h2>Bem-vindo</h2>
                <p>Acesse sua adega digital</p>
            </div>

            @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('loginSubmit') }}">
                @csrf

                <div class="form-group">
                    <label for="email">E-mail</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="seu@email.com"
                        required
                        autofocus
                    >
                </div>

                <div class="form-group">
                    <label for="password">Senha</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Sua senha"
                        required
                    >
                </div>

                <div class="form-options">
                    <label>
                        <input type="checkbox" name="remember">
                        Lembrar-me
                    </label>

                    <a href="#">Esqueceu a senha?</a>
                </div>

                <button type="submit">Entrar</button>
            </form>
        </div>
    </section>

</div>
@endsection
