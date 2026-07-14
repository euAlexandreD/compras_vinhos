@extends('layout.app')

@section('title', 'Editar vinho')
@section('page-title', 'Editar vinho')
@section('page-subtitle', 'Altere as informações do vinho')

@section('content')

<form action="{{ route('updateProduct', $product->id) }}" method="POST" enctype="multipart/form-data" class="flex flex-col gap-5 sm:max-w-3xl">
    @csrf

    <input type="hidden" name="product_id" value="{{ $product->id }}">

    <div class="rounded-2xl bg-surface p-5 shadow-sm sm:p-6">

        <div class="mb-5 text-lg font-medium text-primary">
            Informações Gerais
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Nome do vinho *</label>
                <input type="text" name="name_wine" value="{{ old('name_wine', $product->name_wine) }}" required class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10">
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Tipo</label>
                <input type="text" name="type" value="{{ old('type', $product->type) }}" class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10">
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Safra</label>
                <input type="number" name="harvest" value="{{ old('harvest', $product->harvest) }}" class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10">
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">País</label>
                <input type="text" name="country" value="{{ old('country', $product->country) }}" class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10">
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Volume (ml)</label>
                <input type="text" name="volume" value="{{ old('volume', $product->volume) }}" class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10">
            </div>

            <div class="flex flex-col gap-1.5 sm:col-span-2">
                <label class="text-sm text-ink/70">Descrição</label>
                <textarea name="observation" rows="5" class="rounded-xl border border-border px-4 py-3 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10">{{ old('observation', $product->observation) }}</textarea>
            </div>

        </div>

    </div>

    <div class="rounded-2xl bg-surface p-5 shadow-sm sm:p-6">

        <div class="mb-5 text-lg font-medium text-primary">
            Estoque
        </div>

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Quantidade</label>
                <input type="number" name="quantity" value="{{ old('quantity', $product->quantity) }}" class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10">
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Preço</label>
                <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10">
            </div>

            <div class="flex flex-col gap-1.5">
                <label class="text-sm text-ink/70">Código</label>
                <input type="text" name="code" value="{{ old('code', $product->code) }}" class="h-12 rounded-xl border border-border px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10">
            </div>

        </div>

    </div>

    <div class="rounded-2xl bg-surface p-5 shadow-sm sm:p-6">

        <div class="mb-5 text-lg font-medium text-primary">
            Imagens
        </div>

        @if ($product->images->isNotEmpty())
            <div class="mb-5 grid grid-cols-3 gap-3 sm:grid-cols-4 md:grid-cols-5">
                @foreach ($product->images as $image)
                    <div class="flex flex-col items-center gap-2">
                        <img
                            src="{{ asset('storage/' . $image->path) }}"
                            alt="{{ $product->name_wine }}"
                            class="h-24 w-full rounded-xl border border-border object-cover sm:h-28"
                        >

                        <label class="flex items-center gap-1.5 text-xs text-muted">
                            <input type="checkbox" name="remove_images[]" value="{{ $image->id }}" class="h-4 w-4 rounded border-border text-danger focus:ring-danger/30">
                            Remover
                        </label>
                    </div>
                @endforeach
            </div>
        @endif

        <label class="flex h-40 cursor-pointer flex-col items-center justify-center rounded-2xl border-2 border-dashed border-primary/30 text-center transition-colors hover:border-primary hover:bg-primary-light/40 sm:h-56">
            <input type="file" multiple accept="image/*" hidden name="images[]">

            <div class="mb-3 text-4xl sm:text-5xl">📷</div>
            <h3 class="font-medium text-ink">Adicionar imagens</h3>
            <span class="mt-1 text-sm text-muted">Arraste as imagens ou clique aqui</span>
        </label>

    </div>

    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
        <a href="{{ route('index') }}" class="flex h-12 items-center justify-center rounded-xl bg-ink/10 px-6 text-sm font-medium text-ink">
            Cancelar
        </a>

        <button type="submit" class="flex h-12 items-center justify-center rounded-xl bg-primary px-6 text-sm font-medium text-white hover:bg-primary-dark">
            Salvar alterações
        </button>
    </div>

</form>

@endsection
