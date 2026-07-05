@extends('layout.app')

@section('title', 'Catálogo de Vinhos')
@section('page-title', 'Catálogo de Vinhos')
@section('page-subtitle', 'Visualize e organize sua seleção de vinhos')

@section('content')

<section class="catalog-toolbar">
    <div class="filters">
        <form method="GET" action="{{ route('index') }}">
            <input
                type="text"
                name="keyword"
                value="{{ request('keyword') }}"
                placeholder="Buscar por nome, uva ou safra..."
            >

            <button type="submit">🔍 Pesquisar</button>
        </form>
    </div>

    <button onclick="window.location='{{ route('newWine') }}'">
        + Novo vinho
    </button>
</section>


<form id="cartForm" action="{{ route('addToCart') }}" method="POST">
    @csrf

    <section class="catalog-grid">

        @forelse ($products as $product)

            <article class="wine-card">
                <div class="wine-image">
                    🍷
                    <span class="tag">{{ $product->type }}</span>
                </div>

                <div class="wine-info">
                    <h3>{{ $product->name_wine }}</h3>
                    <p>{{ $product->country }} • Safra {{ $product->harvest }}</p>

                    <div class="wine-meta">
                        <span>Uva</span>
                        <strong>{{ $product->grape }}</strong>
                    </div>

                    <div class="wine-meta">
                        <span>Estoque</span>
                        <strong>{{ $product->quantity }} un.</strong>
                    </div>

                    <div class="wine-actions">
                        <a href="#">Ver detalhes</a>
                        <button type="button">Editar</button>
                    </div>

                    <label class="select-wine">
                        <input
                            type="checkbox"
                            name="products[]"
                            value="{{ $product->id }}"
                        >
                        Selecionar
                    </label>
                </div>
            </article>

        @empty

            <p>Nenhum vinho encontrado.</p>

        @endforelse

    </section>

    {{-- <div class="catalog-cart-action">
        <button type="submit">
            Adicionar selecionados ao carrinho
        </button>
    </div> --}}
</form>
<div class="catalog-cart-action">
    <button type="button" onclick="document.getElementById('cartForm').submit()">
        Adicionar selecionados ao carrinho
    </button>
</div>

<div class="pagination">
    {{ $products->links() }}
</div>

@endsection
