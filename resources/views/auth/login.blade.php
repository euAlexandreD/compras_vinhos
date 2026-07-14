@extends('layout.auth')

@section('title', 'Login - Catálogo de Vinhos')

@section('content')
<div class="flex min-h-screen flex-col md:flex-row">

    <section
        class="relative flex h-56 flex-shrink-0 items-end bg-cover bg-center p-6 sm:h-64 md:h-auto md:w-1/2 md:p-16"
        style="background-image: linear-gradient(rgba(20,5,8,.45), rgba(20,5,8,.8)), url('{{ asset('assets/vinho_login.jpg') }}');"
    >
        <div class="max-w-md text-white">
            <h1 class="text-2xl font-light tracking-wide sm:text-3xl md:text-5xl">
                Catálogo de Vinhos
            </h1>
            <p class="mt-2 hidden text-base text-white/85 sm:block md:mt-4 md:text-lg">
                Organize, descubra e gerencie sua seleção de vinhos.
            </p>
        </div>
    </section>

    <section class="flex flex-1 items-center justify-center px-4 pb-10 md:p-10">
        <div class="-mt-6 w-full max-w-md rounded-t-3xl bg-surface p-6 shadow-xl sm:p-8 md:mt-0 md:rounded-2xl">
            <div class="mb-7 text-center">
                <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-primary text-2xl text-white">
                    🍷
                </div>
                <h2 class="text-2xl font-medium text-ink">Bem-vindo</h2>
                <p class="mt-1 text-sm text-muted">Acesse sua adega digital</p>
            </div>

            @if ($errors->any())
                <div class="mb-5 rounded-xl bg-red-50 px-4 py-3 text-sm text-danger">
                    {{ $errors->first() }}
                </div>
            @endif

            @if (session('loginError'))
                <div class="mb-5 rounded-xl bg-red-50 px-4 py-3 text-sm text-danger">
                    {{ session('loginError') }}
                </div>
            @endif

            <form method="POST" action="{{ route('loginSubmit') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="username" class="mb-1.5 block text-sm text-ink/80">Seu Nome</label>
                    <input
                        type="text"
                        id="username"
                        name="username"
                        value="{{ old('username') }}"
                        placeholder="seu nome..."
                        required
                        autofocus
                        class="h-12 w-full rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
                    >
                </div>

                <div>
                    <label for="password" class="mb-1.5 block text-sm text-ink/80">Senha</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Sua senha"
                        required
                        class="h-12 w-full rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
                    >
                </div>

                <div class="flex items-center justify-between pt-1 text-sm">
                    <label class="flex items-center gap-2 text-ink/70">
                        <input type="checkbox" name="remember" class="h-4 w-4 rounded border-border text-primary focus:ring-primary/30">
                        Lembrar-me
                    </label>

                    <a href="#" class="text-primary">Esqueceu a senha?</a>
                </div>

                <div class="flex items-center justify-between text-sm">
                    <span class="text-ink/70">Ainda não tem cadastro?</span>
                    <a href="{{ route('newUser') }}" class="font-medium text-primary">Cadastre-se aqui</a>
                </div>

                <button
                    type="submit"
                    class="mt-2 h-12 w-full rounded-xl bg-primary text-base font-medium text-white transition-colors hover:bg-primary-dark"
                >
                    Entrar
                </button>
            </form>
        </div>
    </section>

</div>
@endsection
