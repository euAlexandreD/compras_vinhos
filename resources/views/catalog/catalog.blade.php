@extends('layout.app')

@section('title', 'Catálogo de Vinhos')
@section('page-title', 'Catálogo de Vinhos')
@section('page-subtitle', 'Visualize e organize sua seleção de vinhos')

@section('content')

<section class="catalog-toolbar">
    <div class="filters">
        <input type="text" placeholder="Buscar por nome, uva ou safra...">
        <button type="submit">&#128269 Pesquisar</button>
    </div>

    <button onclick="window.location='{{ route('newWine') }}'">+ Novo vinho</button>
</section>

<section class="catalog-grid">

@foreach ($products as $product)
 <article class="wine-card">
        <div class="wine-image">
            🍷
            <span class="tag">{{ $product['type'] }}</span>
        </div>

        <div class="wine-info">
            <h3>{{ $product['name_wine'] }}</h3>
            <p>{{ $product['country'] }} • Safra {{ $product['harvest'] }}</p>

            <div class="wine-meta">
                <span>Uva</span>
                <strong>{{ $product['grape'] }}</strong>
            </div>

            <div class="wine-meta">
                <span>Estoque</span>
                <strong>{{ $product['quantity'] }} un.</strong>
            </div>

            <div class="wine-actions">
                <a href="#">Ver detalhes</a>
                <button>Editar</button>
            </div>
        </div>
    </article>
@endforeach

    <article class="wine-card">
        <div class="wine-image">
            🍇
            <span class="tag">Tinto</span>
        </div>

        <div class="wine-info">
            <h3>Merlot Premium</h3>
            <p>Campanha Gaúcha • Safra 2019</p>

            <div class="wine-meta">
                <span>Uva</span>
                <strong>Merlot</strong>
            </div>

            <div class="wine-meta">
                <span>Estoque</span>
                <strong>8 un.</strong>
            </div>

            <div class="wine-actions">
                <a href="#">Ver detalhes</a>
                <button>Editar</button>
            </div>
        </div>
    </article>

    <article class="wine-card">
        <div class="wine-image light">
            🥂
            <span class="tag">Branco</span>
        </div>

        <div class="wine-info">
            <h3>Chardonnay Seleção</h3>
            <p>Vale dos Vinhedos • Safra 2021</p>

            <div class="wine-meta">
                <span>Uva</span>
                <strong>Chardonnay</strong>
            </div>

            <div class="wine-meta">
                <span>Estoque</span>
                <strong>15 un.</strong>
            </div>

            <div class="wine-actions">
                <a href="#">Ver detalhes</a>
                <button>Editar</button>
            </div>
        </div>
    </article>

</section>

@endsection
