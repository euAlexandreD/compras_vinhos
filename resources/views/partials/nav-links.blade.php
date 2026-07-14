@php
    $linkClass ??= 'block rounded-lg px-3 py-2.5 text-[15px] font-medium text-ink/80 transition-colors hover:bg-primary-light hover:text-primary';
    $activeClass ??= 'bg-primary-light text-primary';
@endphp

<a href="{{ route('index') }}" class="{{ $linkClass }} {{ request()->routeIs('index') ? $activeClass : '' }}">
    Catálogo
</a>

@if (!empty(session('user.name')))
    @can('viewOrders', \App\Models\User::class)
        <a href="{{ route('orders') }}" class="{{ $linkClass }} {{ request()->routeIs('orders') ? $activeClass : '' }}">
            Pedidos
        </a>
    @endcan

    <a href="{{ route('perfil') }}" class="{{ $linkClass }} {{ request()->routeIs('perfil') ? $activeClass : '' }}">
        Meu perfil
    </a>

    <a href="{{ route('myOrders') }}" class="{{ $linkClass }} {{ request()->routeIs('myOrders') ? $activeClass : '' }}">
        Últimos pedidos
    </a>

    <a href="{{ route('cart') }}" class="{{ $linkClass }} {{ request()->routeIs('cart') ? $activeClass : '' }}">
        Meu carrinho
    </a>

    @can('listUsers', \App\Models\User::class)
        <a href="{{ route('profiles') }}" class="{{ $linkClass }} {{ request()->routeIs('profiles') ? $activeClass : '' }}">
            Ver perfis
        </a>
    @endcan
@endif
