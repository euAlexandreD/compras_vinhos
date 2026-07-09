@extends('layout.app')

@section('title', 'Catálogo de Vinhos')
@section('page-title', 'Catálogo de Vinhos')
@section('page-subtitle', 'Visualize e organize sua seleção de vinhos')


@section('content')
<div class="topbar">

    <div class="topbar-logo">
        <h2>🍷 Wine Catalog</h2>
    </div>
    <div class="topbar-actions">
        @if(!empty(session('user.name')))
            <span class="user-name">
                Olá, {{ session('user.name') }}
            </span>
            <a href="{{ route('logout') }}" class="btn-logout">
                🚪 Sair
            </a>
        @else
            <a href="{{ route('login') }}" class="btn-topbar">
                Entrar
            </a>
        @endif

    </div>

</div>

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

                     <div class="wine-meta">
                        <span>Valor</span>
                        <strong>R$ {{ number_format($product->price, 2, ',', '.') }} un.</strong>
                    </div>

                   <div class="card-actions-row">
                        <div class="quantity-control">
                            <button type="button" onclick="decreaseQty({{ $product->id }})">−</button>

                            <input
                                type="number"
                                id="qty-{{ $product->id }}"
                                name="products[{{ $product->id }}]"
                                value="0"
                                readonly
                            >

                            <button type="button" onclick="increaseQty({{ $product->id }})">+</button>
                        </div>

                        <a href="{{ route('editProduct', $product->id) }}" class="btn-edit">
                            Editar
                        </a>
                    </div>
            </article>
        @endforeach
    </section>
</form>

<button type="button" class="floating-cart-btn" onclick="document.getElementById('cartForm').submit()">
    Adicionar ao carrinho
</button>


<div class="pagination">
    {{ $products->links() }}
</div>
<script>
    function increaseQty(id) {
        const input = document.getElementById('qty-' + id);
        let value = parseInt(input.value || 0);

        input.value = value + 1;
    }

    function decreaseQty(id) {
        const input = document.getElementById('qty-' + id);
        let value = parseInt(input.value || 0);

        if (value > 0) {
            input.value = value - 1;
        }
    }
</script>
@endsection
