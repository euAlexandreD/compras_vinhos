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
            <a href="#" class="active">Dashboard</a>
            <a href="#">Vinhos</a>
            <a href="#">Categorias</a>
            <a href="#">Safras</a>
            <a href="#">Produtores</a>
            <a href="#">Relatórios</a>
        </nav>

        <div class="sidebar-footer">
            <span>Logado como</span>
            <strong>{{ session('user.name') ?? 'Usuário' }}</strong>
        </div>
    </aside>

    <main class="main">
        <header class="topbar">
            <div>
                <h2>@yield('page-title', 'Dashboard')</h2>
                <p>@yield('page-subtitle', 'Visão geral do seu catálogo de vinhos')</p>
            </div>

            <div class="topbar-actions">
                <input type="text" placeholder="Buscar vinho...">
                <button>+ Novo vinho</button>
            </div>
        </header>

        @yield('content')
    </main>

</div>

</body>
</html>
