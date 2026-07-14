@extends('layout.app')

@section('title', 'Gerenciar Perfis')

@section('page-title', 'Gerenciar Perfis')
@section('page-subtitle', 'Veja, edite e gerencie os cargos de todos os usuários')

@section('content')

<div class="rounded-2xl bg-surface p-4 shadow-sm sm:p-6">

    <div class="mb-5 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="text-lg font-medium text-primary">Usuários</div>

        <a
            href="{{ route('newUser') }}"
            class="flex h-11 items-center justify-center rounded-xl bg-primary px-5 text-sm font-semibold text-white sm:inline-flex"
        >
            + Novo usuário
        </a>
    </div>

    <form action="{{ route('profiles') }}" method="GET" class="mb-5 flex flex-col gap-2 sm:flex-row">
        <input
            type="text"
            name="search"
            placeholder="Buscar por nome ou e-mail..."
            value="{{ request('search') }}"
            class="h-12 w-full flex-1 rounded-xl border border-border bg-surface px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
        >
        <button type="submit" class="h-12 flex-shrink-0 rounded-xl bg-ink/10 px-6 text-sm font-semibold text-ink">
            Buscar
        </button>
    </form>

    {{-- Cards: mobile only --}}
    <div class="flex flex-col gap-3 sm:hidden">
        @foreach ($users as $user)
            <div class="rounded-xl border border-border p-4">
                <div class="mb-2">
                    <div class="font-medium text-ink">{{ $user->username }}</div>
                    <div class="text-sm text-muted">{{ $user->lastname }}</div>
                </div>

                <div class="mb-3 truncate text-sm text-ink/70">{{ $user->email }}</div>

                <div class="mb-3 flex flex-wrap gap-1.5">
                    @foreach ($user->roles as $role)
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $role->name === 'Admin' ? 'bg-primary-light text-primary' : 'bg-ink/5 text-ink/70' }}">
                            {{ $role->name }}
                        </span>
                    @endforeach
                </div>

                <div class="flex gap-2">
                    <a
                        href="{{ route('perfil') }}"
                        class="flex h-10 flex-1 items-center justify-center rounded-lg border border-border text-sm text-ink/80"
                    >
                        Editar
                    </a>
                    <button
                        type="button"
                        class="flex h-10 flex-1 items-center justify-center rounded-lg border border-red-200 text-sm text-danger"
                    >
                        Excluir
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Tabela: sm e acima --}}
    <div class="hidden overflow-x-auto rounded-xl border border-border sm:block">
        <table class="w-full border-collapse text-[15px]">
            <thead>
                <tr>
                    <th class="border-b border-border bg-bg px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-muted">Nome</th>
                    <th class="border-b border-border bg-bg px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-muted">E-mail</th>
                    <th class="border-b border-border bg-bg px-5 py-3.5 text-left text-xs font-semibold uppercase tracking-wide text-muted">Cargos</th>
                    <th class="border-b border-border bg-bg px-5 py-3.5 text-right text-xs font-semibold uppercase tracking-wide text-muted">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="hover:bg-bg/60">
                    <td class="border-b border-border px-5 py-4">
                        <div class="font-medium text-ink">{{ $user->username }}</div>
                        <div class="text-sm text-muted">{{ $user->lastname }}</div>
                    </td>
                    <td class="border-b border-border px-5 py-4 text-ink/80">{{ $user->email }}</td>
                    <td class="border-b border-border px-5 py-4">
                        <div class="flex flex-wrap gap-1.5">
                            @foreach ($user->roles as $role)
                                <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold {{ $role->name === 'Admin' ? 'bg-primary-light text-primary' : 'bg-ink/5 text-ink/70' }}">
                                    {{ $role->name }}
                                </span>
                            @endforeach
                        </div>
                    </td>
                    <td class="border-b border-border px-5 py-4">
                        <div class="flex justify-end gap-2">
                            <a
                                href="{{ route('perfil') }}"
                                class="flex h-9 items-center justify-center rounded-lg border border-border px-3.5 text-sm text-ink/80 hover:border-primary hover:text-primary"
                                title="Editar"
                            >
                                Editar
                            </a>
                            <button
                                type="button"
                                class="flex h-9 items-center justify-center rounded-lg border border-border px-3.5 text-sm text-ink/80 hover:border-danger hover:text-danger"
                                title="Excluir"
                            >
                                Excluir
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</div>

@endsection
