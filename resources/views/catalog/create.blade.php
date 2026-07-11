@extends('layout.app')

@section('title', 'Novo vinho')

@section('page-title', 'Novo vinho')
@section('page-subtitle', 'Cadastre um novo rótulo para seu catálogo')

@section('content')
@vite('resources/css/create.css')

<form class="wine-form" action="{{ route('newWineSubmit') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="form-card">

        <div class="card-title">
            Informações Gerais
        </div>

        <div class="grid-2">

            <div class="form-group">
                <label>Nome do vinho *</label>
                <input type="text" name="name_wine" required>
            </div>

            <div class="form-group">
                <label>Tipo</label>
                <input type="text" name="type">
            </div>

            <div class="form-group">
                <label>Safra</label>
                <input type="number" name="harvest">
            </div>

            <div class="form-group">
                <label>País</label>
                <input type="text" name="country">
            </div>

            <div class="form-group">
                <label>Volume</label>
                <input type="text" placeholder="750 ml" name="volume">
            </div>

            <div class="form-group full">
                <label>Descrição</label>
                <textarea rows="5" name="observation"></textarea>
            </div>

        </div>

    </div>

    <div class="form-card">

        <div class="card-title">
            Estoque
        </div>

        <div class="grid-3">

            <div class="form-group">
                <label>Quantidade</label>
                <input type="number" name="quantity">
            </div>

            <div class="form-group">
                <label>Valor</label>
                <input type="number" name="price">
            </div>

            <div class="form-group">
                <label>Código</label>
                <input type="text" name="code">
            </div>

        </div>

    </div>

    <div class="form-card">

        <div class="card-title">
            Imagens
        </div>

        <label class="upload-box">

            <input type="file" multiple accept="image/*" hidden name="images[]">

            <div class="upload-icon">
                📷
            </div>

            <h3>Enviar imagens</h3>

            <span>
                Arraste as imagens ou clique aqui
            </span>

        </label>

    </div>

    <div class="form-buttons">

        <a href="{{ route('index') }}" class="secondary">
            Cancelar
        </a>

        <button class="primary" type="submit">
            Salvar vinho
        </button>

    </div>

</form>

@endsection
