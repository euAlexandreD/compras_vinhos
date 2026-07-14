@extends('layout.app')

@section('title', 'Meu perfil')

@section('page-title', 'Meu perfil')
@section('page-subtitle', 'Veja seu perfil ou faça alguma alteração')

@section('content')

<form action="{{ route('editUserSubmit') }}" method="POST" class="flex flex-col gap-5 sm:max-w-2xl">

    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">

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
                    value="{{ old('username', $user->username) }}"
                    class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
                >
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Sobrenome</label>
                <input
                    type="text"
                    name="lastname"
                    value="{{ old('lastname', $user->lastname) }}"
                    class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
                >
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">E-mail</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
                >
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Telefone</label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
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

        <button
            type="submit"
            class="flex h-12 items-center justify-center rounded-xl bg-primary px-6 text-sm font-medium text-white hover:bg-primary-dark"
        >
            Salvar usuário
        </button>

    </div>

</form>

<form action="{{ route('updateRoles', $user->id) }}" method="POST" class="mt-5 flex flex-col gap-5 sm:max-w-2xl">
    @csrf

    <div class="rounded-2xl bg-surface p-5 shadow-sm sm:p-6">

        <div class="mb-5 text-lg font-medium text-primary">
            Cargos
        </div>

        @can('manageRoles', \App\Models\User::class)
            <div class="mb-5 flex flex-col gap-2.5">
                @foreach ($roles as $role)
                    <label class="flex items-center gap-3 rounded-xl border border-border px-4 py-3 text-[15px] text-ink/80 has-[:checked]:border-primary has-[:checked]:bg-primary-light has-[:checked]:text-primary">
                        <input
                            name="roles[]"
                            type="checkbox"
                            value="{{ $role->id }}"
                            @checked($user->roles->pluck('id')->contains($role->id))
                            class="h-5 w-5 rounded border-border text-primary focus:ring-primary/30"
                        >
                        <span>{{ $role->name }}</span>
                    </label>
                @endforeach
            </div>
        @endcan

        <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
            <button
                type="submit"
                class="flex h-12 items-center justify-center rounded-xl bg-primary px-6 text-sm font-medium text-white hover:bg-primary-dark"
            >
                Salvar Cargo
            </button>
        </div>

    </div>
</form>
@endsection
