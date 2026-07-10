@extends('layout.app')

@section('title', 'Gerenciar Perfis')

@section('page-title', 'Gerenciar Perfis')
@section('page-subtitle', 'Veja, edite e gerencie os cargos de todos os usuários')

@section('content')
@vite('resources/css/list_users.css')

<div class="form-card">

    <div class="card-title-row">
        <div class="card-title">Usuários</div>

        <a href="{{ route('newUser') }}" class="primary">
            + Novo usuário
        </a>
    </div>

    <form action="{{ route('profiles') }}" method="GET" class="search-bar">
        <input
            type="text"
            name="search"
            placeholder="Buscar por nome ou e-mail..."
            value="{{ request('search') }}"
        >
        <button type="submit" class="secondary">
            Buscar
        </button>
    </form>

    <div class="table-wrapper">
        <table class="profiles-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Cargos</th>
                    <th class="actions-col">Ações</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr>
                    <td>
                        <div class="user-name">{{ $user->username }}</div>
                        <div class="user-sub">{{ $user->lastname }}</div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <div class="badges">
                            @foreach ($user->roles as $role)
                                <span class="{{ $role->name === 'Admin' ? 'badge-admin' : 'badge-cliente' }}">{{ $role->name }}</span>
                            @endforeach
                        </div>
                    </td>
                    <td class="actions-col">
                        <div class="row-actions">
                            <a href="{{ route('perfil') }}" class="icon-btn" title="Editar">
                                Editar
                            </a>
                            <button type="button" class="icon-btn danger" title="Excluir">
                                Excluir
                            </button>
                        </div>
                    </td>
                </tr>

                @endforeach
                {{-- @empty --}}
                {{--
                <tr>
                    <td colspan="4">
                        <div class="empty-state">
                            Nenhum usuário encontrado.
                        </div>
                    </td>
                </tr>
                --}}
                {{-- @endforelse --}}
            </tbody>
        </table>
    </div>

    {{-- Paginação (ajuste conforme seu controller) --}}
    {{-- <div class="pagination-wrapper">
        {{ $users->links() }}
    </div> --}}

</div>

@endsection
