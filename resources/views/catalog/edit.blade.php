@extends('layout.app')

@section('title', 'Editar vinho')
@section('page-title', 'Editar vinho')
@section('page-subtitle', 'Altere as informações do vinho')

@section('content')

@vite('resources/css/create.css')

<form class="wine-form" action="" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="form-card">

        <div class="card-title">
            Informações Gerais
        </div>

        <div class="grid-2">

            <div class="form-group">
                <label>Nome do vinho</label>
                <input type="text" name="name_wine" value="{{ old('name_wine', $product->name_wine) }}">
            </div>

            <div class="form-group">
                <label>Tipo</label>
                <input type="text" name="type" value="{{ old('type', $product->type) }}">
            </div>

            <div class="form-group">
                <label>Vinícola</label>
                <input type="text" name="winery" value="{{ old('winery', $product->winery) }}">
            </div>

            <div class="form-group">
                <label>País</label>
                <input type="text" name="country" value="{{ old('country', $product->country) }}">
            </div>

            <div class="form-group">
                <label>Região</label>
                <input type="text" name="region" value="{{ old('region', $product->region) }}">
            </div>

            <div class="form-group">
                <label>Uva</label>
                <input type="text" name="grape" value="{{ old('grape', $product->grape) }}">
            </div>

            <div class="form-group">
                <label>Safra</label>
                <input type="number" name="harvest" value="{{ old('harvest', $product->harvest) }}">
            </div>

            <div class="form-group">
                <label>Volume (ml)</label>
                <input type="text" name="volume" value="{{ old('volume', $product->volume) }}">
            </div>

            <div class="form-group">
                <label>Teor Alcoólico (%)</label>
                <input type="text" name="alcohol_content" value="{{ old('alcohol_content', $product->alcohol_content) }}">
            </div>

            <div class="form-group">
                <label>Temperatura</label>
                <input type="text" name="temperature" value="{{ old('temperature', $product->temperature) }}">
            </div>

            <div class="form-group">
                <label>Código</label>
                <input type="text" name="code" value="{{ old('code', $product->code) }}">
            </div>

            <div class="form-group">
                <label>Quantidade</label>
                <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}">
            </div>

            <div class="form-group">
                <label>Preço</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}">
            </div>

            <div class="form-group">
                <label>Imagem</label>
                <input type="file" name="image">
            </div>

        </div>

        <div class="form-group">
            <label>Observações</label>
            <textarea name="observation" rows="5">{{ old('observation', $product->observation) }}</textarea>
        </div>

    </div>

    <div class="form-actions">
        <a href="{{ route('index') }}" class="btn-secondary">
            Cancelar
        </a>

        <button type="submit" class="btn-primary">
            Salvar alterações
        </button>
    </div>

</form>

@endsection
