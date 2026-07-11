@extends('layout.app')

@section('title', 'Editar vinho')
@section('page-title', 'Editar vinho')
@section('page-subtitle', 'Altere as informações do vinho')

@section('content')

@vite('resources/css/create.css')

<form class="wine-form" action="{{ route('updateProduct', $product->id) }}" method="POST" enctype="multipart/form-data">
    @csrf

    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="form-card">

        <div class="card-title">
            Informações Gerais
        </div>

        <div class="grid-2">

            <div class="form-group">
                <label>Nome do vinho *</label>
                <input type="text" name="name_wine" value="{{ old('name_wine', $product->name_wine) }}" required>
            </div>

            <div class="form-group">
                <label>Tipo</label>
                <input type="text" name="type" value="{{ old('type', $product->type) }}">
            </div>

            <div class="form-group">
                <label>Safra</label>
                <input type="number" name="harvest" value="{{ old('harvest', $product->harvest) }}">
            </div>

            <div class="form-group">
                <label>País</label>
                <input type="text" name="country" value="{{ old('country', $product->country) }}">
            </div>

            <div class="form-group">
                <label>Volume (ml)</label>
                <input type="text" name="volume" value="{{ old('volume', $product->volume) }}">
            </div>

            <div class="form-group full">
                <label>Descrição</label>
                <textarea name="observation" rows="5">{{ old('observation', $product->observation) }}</textarea>
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
                <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}">
            </div>

            <div class="form-group">
                <label>Preço</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}">
            </div>

            <div class="form-group">
                <label>Código</label>
                <input type="text" name="code" value="{{ old('code', $product->code) }}">
            </div>

        </div>

    </div>

    <div class="form-card">

        <div class="card-title">
            Imagens
        </div>

        @if ($product->images->isNotEmpty())
            <div class="image-gallery">
                @foreach ($product->images as $image)
                    <div class="image-thumb">
                        <img src="{{ asset('storage/' . $image->path) }}" alt="{{ $product->name_wine }}">
                        <label class="image-remove">
                            <input type="checkbox" name="remove_images[]" value="{{ $image->id }}">
                            Remover
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

        <label class="upload-box">
            <input type="file" multiple accept="image/*" hidden name="images[]">

            <div class="upload-icon">📷</div>
            <h3>Adicionar imagens</h3>
            <span>Arraste as imagens ou clique aqui</span>
        </label>

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
