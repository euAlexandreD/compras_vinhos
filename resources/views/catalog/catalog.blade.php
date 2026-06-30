@extends('layout.app')

@section('title', 'Catálogo de Vinhos')
@section('page-title', 'Catálogo de Vinhos')
@section('page-subtitle', 'Visualize e organize sua seleção de vinhos')

@section('content')

<section class="catalog-toolbar">
    <div class="filters">
        <input type="text" placeholder="Buscar por nome, uva ou safra...">

        <select>
            <option>Todos os tipos</option>
            <option>Tinto</option>
            <option>Branco</option>
            <option>Rosé</option>
            <option>Espumante</option>
        </select>

        <select>
            <option>Todas as safras</option>
            <option>2024</option>
            <option>2023</option>
            <option>2022</option>
            <option>2021</option>
        </select>
    </div>

    <button>+ Novo vinho</button>
</section>

<section class="catalog-grid">

    <article class="wine-card">
        <div class="wine-image">
            🍷
            <span class="tag">Tinto</span>
        </div>

        <div class="wine-info">
            <h3>Cabernet Sauvignon Reserva</h3>
            <p>Serra Gaúcha • Safra 2020</p>

            <div class="wine-meta">
                <span>Uva</span>
                <strong>Cabernet</strong>
            </div>

            <div class="wine-meta">
                <span>Estoque</span>
                <strong>12 un.</strong>
            </div>

            <div class="wine-actions">
                <a href="#">Ver detalhes</a>
                <button>Editar</button>
            </div>
        </div>
    </article>

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
