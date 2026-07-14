@extends('layout.app')

@section('title', 'Novo usuário')

@section('page-title', 'Novo usuário')
@section('page-subtitle', 'Cadastre um novo usuário para acessar o sistema')

@section('content')

<form action="{{ route('newUserSubmit') }}" method="POST" class="flex flex-col gap-5 sm:max-w-2xl">

    @csrf

    <div class="rounded-2xl bg-surface p-5 shadow-sm sm:p-6">

        <div class="mb-5 text-lg font-medium text-primary">
            Informações pessoais
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Nome</label>
                <input
                    type="text"
                    name="username"
                    value="{{ old('username') }}"
                    required
                    class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
                >
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Sobrenome</label>
                <input
                    type="text"
                    name="lastname"
                    value="{{ old('lastname') }}"
                    required
                    class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
                >
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">E-mail</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
                >
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Telefone</label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    required
                    class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
                >
            </div>

        </div>

    </div>

    <div class="rounded-2xl bg-surface p-5 shadow-sm sm:p-6">

        <div class="mb-5 text-lg font-medium text-primary">
            Segurança
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Senha</label>
                <input
                    type="password"
                    name="password"
                    required
                    class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
                >
            </div>

        </div>

    </div>

    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

        <a
            href=""
            class="flex h-12 items-center justify-center rounded-xl bg-ink/10 px-6 text-sm font-medium text-ink"
        >
            Cancelar
        </a>

        <button class="flex h-12 items-center justify-center rounded-xl bg-primary px-6 text-sm font-medium text-white hover:bg-primary-dark">
            Salvar usuário
        </button>

    </div>

</form>

@endsection
