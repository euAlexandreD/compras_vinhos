@extends('layout.app')

@section('title', 'Novo usuário')

@section('page-title', 'Novo usuário')
@section('page-subtitle', 'Cadastre um novo usuário para acessar o sistema')

@section('content')
@vite('resources/css/createUser.css')

<form action="{{ route('newUserSubmit') }}" method="POST" class="wine-form">

    @csrf

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
                    value="{{ old('username') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>Sobrenome</label>

                <input
                    type="text"
                    name="lastname"
                    value="{{ old('lastname') }}"
                    required
                >
            </div>

            <div class="form-group">
                <label>E-mail</label>

                <input
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                >
            </div>

             <div class="form-group">
                <label>Telefone</label>

                <input
                    type="text"
                    name="phone"
                    value="{{ old('phone') }}"
                    required
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
                    required
                >
            </div>

        </div>

    </div>

    <div class="form-card">

        <div class="card-title">
            Permissões
        </div>

        <div class="grid-2">

            <div class="form-group">

                <label>Perfil</label>

                <select name="role">

                    <option value="admin">
                        Administrador
                    </option>

                    <option value="user">
                        Usuário
                    </option>

                </select>

            </div>

            <div class="form-group">

                <label>Status</label>

                <select name="status">

                    <option value="1">
                        Ativo
                    </option>

                    <option value="0">
                        Inativo
                    </option>

                </select>

            </div>

        </div>

    </div>

    <div class="form-buttons">

        <a href="" class="secondary">
            Cancelar
        </a>

        <button class="primary">
            Salvar usuário
        </button>

    </div>

</form>

@endsection
