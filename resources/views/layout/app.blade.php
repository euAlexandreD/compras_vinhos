<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <title>@yield('title', 'Catálogo de Vinhos')</title>

    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-bg font-sans text-ink antialiased">

<header class="sticky top-0 z-40 border-b border-border bg-surface/95 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-6xl items-center justify-between gap-2 px-4">
        <div class="flex items-center gap-1">
            <button
                type="button"
                onclick="toggleMenu()"
                class="-ml-2 flex h-11 w-11 items-center justify-center rounded-lg text-ink md:hidden"
                aria-label="Abrir menu"
                aria-controls="nav-drawer"
                aria-expanded="false"
                id="menu-toggle-btn"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5M3.75 17.25h16.5" />
                </svg>
            </button>

            <a href="{{ route('index') }}" class="flex items-center gap-2">
                <span class="text-2xl leading-none">🍷</span>
                <span class="text-lg font-semibold tracking-tight text-primary">Wine Catalog</span>
            </a>
        </div>

        <nav class="hidden md:flex md:items-center md:gap-1">
            @include('partials.nav-links', ['linkClass' => 'rounded-lg px-3 py-2 text-sm font-medium text-ink/80 transition-colors hover:bg-primary-light hover:text-primary'])
        </nav>

        <div class="flex items-center gap-1.5">
            @if(!empty(session('user.name')))
                <span class="hidden text-sm text-muted lg:inline">Olá, {{ session('user.name') }}</span>

                <a
                    href="{{ route('cart') }}"
                    class="relative flex h-11 w-11 items-center justify-center rounded-lg text-ink hover:bg-primary-light hover:text-primary"
                    aria-label="Meu carrinho"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 3h1.386c.51 0 .955.343 1.087.836l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 1.994-4.716 2.602-7.217a1.125 1.125 0 00-1.09-1.394H5.106M14.25 17.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm-9 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z" />
                    </svg>

                    @php($cartCount = count(session('cart', [])))
                    @if($cartCount > 0)
                        <span class="absolute -top-0.5 -right-0.5 flex h-5 min-w-5 items-center justify-center rounded-full bg-secondary px-1 text-[11px] font-bold text-white">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>

                <a href="{{ route('logout') }}" class="hidden h-11 items-center rounded-lg px-3 text-sm font-medium text-ink/80 hover:bg-primary-light hover:text-primary sm:inline-flex">
                    Sair
                </a>
            @else
                <a href="{{ route('login') }}" class="inline-flex h-10 items-center rounded-lg bg-primary px-4 text-sm font-medium text-white hover:bg-primary-dark">
                    Entrar
                </a>
            @endif
        </div>
    </div>

    @hasSection('page-title')
        <div class="mx-auto max-w-6xl px-4 pb-4">
            <h1 class="text-xl font-semibold text-ink md:text-2xl">@yield('page-title')</h1>

            @hasSection('page-subtitle')
                <p class="mt-0.5 text-sm text-muted">@yield('page-subtitle')</p>
            @endif
        </div>
    @endif
</header>

<div
    id="nav-backdrop"
    class="fixed inset-0 z-40 hidden bg-black/40 md:hidden"
    onclick="toggleMenu(false)"
></div>

<aside
    id="nav-drawer"
    class="fixed inset-y-0 left-0 z-50 flex w-72 max-w-[80vw] -translate-x-full flex-col gap-1 overflow-y-auto bg-surface p-5 shadow-xl transition-transform duration-200 ease-out md:hidden"
>
    <div class="mb-4 flex items-center justify-between">
        <span class="flex items-center gap-2 font-semibold text-primary">
            <span class="text-xl">🍷</span> Wine Catalog
        </span>

        <button type="button" onclick="toggleMenu(false)" class="flex h-9 w-9 items-center justify-center rounded-lg text-ink" aria-label="Fechar menu">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>

    @include('partials.nav-links')

    @if(!empty(session('user.name')))
        <a href="{{ route('logout') }}" class="mt-2 rounded-lg px-3 py-2.5 text-[15px] font-medium text-danger hover:bg-red-50">
            Sair
        </a>
    @endif
</aside>

<main class="mx-auto max-w-6xl px-4 py-4 md:py-8">
    @yield('content')
</main>

<script>
    function toggleMenu(force) {
        const drawer = document.getElementById('nav-drawer');
        const backdrop = document.getElementById('nav-backdrop');
        const btn = document.getElementById('menu-toggle-btn');
        const open = typeof force === 'boolean' ? force : drawer.classList.contains('-translate-x-full');

        drawer.classList.toggle('-translate-x-full', !open);
        backdrop.classList.toggle('hidden', !open);
        document.body.classList.toggle('overflow-hidden', open);
        btn?.setAttribute('aria-expanded', open ? 'true' : 'false');
    }
</script>

</body>
</html>
