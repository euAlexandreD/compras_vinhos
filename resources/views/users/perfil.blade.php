@extends('layout.app')

@section('title', 'Meu perfil')

@section('page-title', 'Meu perfil')
@section('page-subtitle', 'Veja seu perfil ou faça alguma alteração')

@section('content')
@vite('resources/css/createUser.css')

<form action="{{ route('editUserSubmit') }}" method="POST" class="wine-form">

    @csrf
    <input type="hidden" name="user_id" value="{{ $user->id }}">
    <div class="form-card">

        <div class="card-title">
            Informações pessoais
        </div>

        <div class="grid-2">

            <div class="form-group">
                <label>Nome</label>
                <input
                    type="text"
                    name="username"
                    value="{{ old('username', $user->username) }}"
                >
            </div>

            <div class="form-group">
                <label>Sobrenome</label>
                <input
                    type="text"
                    name="lastname"
                    value="{{ old('lastname', $user->lastname) }}"
                >
            </div>

            <div class="form-group">
                <label>E-mail</label>
                <input
                    type="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                >
            </div>

            <div class="form-group">
                <label>Telefone</label>
                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone', $user->phone) }}"
                >
            </div>

        </div>

    </div>

    <div class="form-card">

        <div class="card-title">
            Segurança
        </div>

        <div class="grid-2">

            <div class="form-group">
                <label>Senha</label>
                <input
                    type="password"
                    name="password"
                >
            </div>
        </div>

    </div>

    <div class="form-card">

        <div class="form-buttons">

            <a href="" class="secondary">
                Cancelar
            </a>

            <button class="primary" type="submit">
                Salvar usuário
            </button>

        </div>

    </div>

</form>

<form action="{{ route('updateRoles', $user->id) }}" method="POST" class="wine-form">
    @csrf

    <div class="form-card">

        <div class="card-title">
            Cargos
        </div>
 @can('manageRoles', \App\Models\User::class)
        <div class="roles-list">
            @foreach ($roles as $role)
                <label class="role-checkbox">
                    <input
                        name="roles[]"
                        type="checkbox"
                        value="{{ $role->id }}"
                        @checked($user->roles->pluck('id')->contains($role->id))
                    >
                    <span>{{ $role->name }}</span>
                </label>
            @endforeach
        </div>
@endcan
        <div class="form-buttons">
            <button class="primary" type="submit">
                Salvar Cargo
            </button>
        </div>

    </div>
</form>
@endsection
