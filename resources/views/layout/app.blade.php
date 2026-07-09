<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Catálogo de Vinhos')</title>

    @vite(['resources/css/dashboard.css'])
</head>
<body>

<div class="app">

    <aside class="sidebar">
        <div class="brand">
            <div class="brand-icon">🍷</div>
            <div>
                <h1>WineCatalog</h1>
                <span>Adega digital</span>
            </div>
        </div>

        <nav class="menu">
            <a href="{{ route('index') }}" class="active">Catalogo</a>

            @if (!empty(session('user.name')))
                <a href="{{ route('orders') }}">Pedidos</a>
                <a href="{{ route('perfil') }}">Meu perfil</a>
                <a href="{{ route('myOrders') }}">Ultimos pedidos</a>
                <a href="{{ route('cart') }}">Meu carrinho</a>
                @can('listUsers', \App\Models\User::class)
                    <a href="{{ route('profiles') }}">Ver Perfis</a>
                @endcan
            @endif
        </nav>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <h2>@yield('page-title', 'Dashboard')</h2>
                <p>@yield('page-subtitle', 'Visão geral do seu catálogo de vinhos')</p>
            </div>

        </header>

        @yield('content')
    </main>

</div>

</body>
</html>
