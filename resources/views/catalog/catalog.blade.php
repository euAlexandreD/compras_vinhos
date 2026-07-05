@extends('layout.app')

@section('title', 'Catálogo de Vinhos')
@section('page-title', 'Catálogo de Vinhos')
@section('page-subtitle', 'Visualize e organize sua seleção de vinhos')

@section('content')

<section class="catalog-toolbar">
    <div class="filters">
        <form method="GET" action="{{ route('index') }}">
            <input  type="text"
                    name="keyword"
                    value="{{ request('keyword') }}"
                    placeholder="Buscar por nome, uva ou safra...">
            <button type="submit">&#128269 Pesquisar</button>
        </form>
    </div>

    <button onclick="window.location='{{ route('newWine') }}'">+ Novo vinho</button>
</section>

<section class="catalog-grid">

@foreach ($products as $product)
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
            <button>Editar</button>
                 <form action="{{ route('addToCart') }}" method="get" class="quantity-form">
                        @csrf

                             <input type="hidden" name="product_id" value="{{ $product->id }}">

                            <input
                                type="number"
                                name="quantity"
                                min="1"
                                value="1"
                            >

                    <button type="submit">
                        Adicionar ao carrinho
                    </button>
                </form>

            </div>
        </div>
    </article>
@endforeach

</section>
<div class="pagination">
    {{ $products->links() }}
</div>

@endsection
