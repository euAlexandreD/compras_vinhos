@extends('layout.app')

@section('title', 'Catálogo de Vinhos')
@section('page-title', 'Catálogo de Vinhos')
@section('page-subtitle', 'Visualize e organize sua seleção de vinhos')

@section('content')

<section class="sticky top-16 z-30 -mx-4 mb-4 bg-bg/95 px-4 py-3 backdrop-blur sm:static sm:mx-0 sm:mb-6 sm:bg-transparent sm:px-0 sm:py-0 sm:backdrop-blur-none">
    <div class="flex flex-col gap-2 sm:flex-row sm:items-center">
        <form method="GET" action="{{ route('index') }}" class="flex flex-1 gap-2">
            <input
                type="text"
                name="keyword"
                value="{{ request('keyword') }}"
                placeholder="Buscar por nome, uva ou safra..."
                class="h-12 w-full flex-1 rounded-xl border border-border bg-surface px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
            >

            <button type="submit" class="flex h-12 w-12 flex-shrink-0 items-center justify-center rounded-xl bg-primary text-lg text-white">
                🔍
            </button>
        </form>

        @can('addNewWine', \App\Models\User::class)
            <a
                href="{{ route('newWine') }}"
                class="flex h-12 flex-shrink-0 items-center justify-center rounded-xl bg-secondary px-5 text-sm font-semibold text-white"
            >
                + Novo vinho
            </a>
        @endcan
    </div>
</section>

@if(!empty(session('user.name')))
<form id="cartForm" action="{{ route('addToCart') }}" method="POST">
    @csrf
@else
<div>
@endif

    <section class="grid grid-cols-2 gap-3 pb-24 sm:grid-cols-3 sm:gap-4 sm:pb-0 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6">
        @foreach ($products as $product)
            <article class="flex flex-col overflow-hidden rounded-2xl bg-surface shadow-sm ring-1 ring-black/5 transition hover:shadow-md">
                <div class="relative aspect-[3/4] w-full overflow-hidden bg-gradient-to-b from-primary/90 to-primary-dark">
                    @if ($product->primaryImage)
                        <img
                            src="{{ asset('storage/' . $product->primaryImage->path) }}"
                            alt="{{ $product->name_wine }}"
                            loading="lazy"
                            decoding="async"
                            class="h-full w-full object-cover"
                        >
                    @else
                        <span class="flex h-full items-center justify-center text-4xl">🍷</span>
                    @endif

                    <span class="absolute left-2 top-2 rounded-full bg-white/25 px-2.5 py-1 text-[11px] font-medium leading-none text-white backdrop-blur-sm">
                        {{ $product->type }}
                    </span>

                    @can('editWine', \App\Models\User::class)
                        <a
                            href="{{ route('editProduct', $product->id) }}"
                            class="absolute right-2 top-2 flex h-7 w-7 items-center justify-center rounded-full bg-white/90 text-sm text-primary shadow"
                            title="Editar vinho"
                        >
                            ✎
                        </a>
                    @endcan
                </div>

                <div class="flex flex-1 flex-col gap-2 p-3">
                    <h3 class="truncate text-[14.5px] font-semibold leading-tight text-ink">
                        {{ $product->name_wine }}
                    </h3>

                    <p class="truncate text-xs text-muted">
                        {{ $product->country }} • Safra {{ $product->harvest }}
                    </p>

                    <div class="grid grid-cols-2 gap-2 border-t border-border pt-2">
                        <div class="min-w-0">
                            <span class="block text-[10.5px] uppercase tracking-wide text-muted">Uva</span>
                            <strong class="block truncate text-[12.5px] font-semibold text-ink">{{ $product->grape }}</strong>
                        </div>

                        <div class="min-w-0">
                            <span class="block text-[10.5px] uppercase tracking-wide text-muted">Estoque</span>
                            <strong class="block truncate text-[12.5px] font-semibold text-ink">{{ $product->quantity }} un.</strong>
                        </div>
                    </div>

                    <div class="flex items-baseline gap-1">
                        <strong class="text-[17px] text-primary">R$ {{ number_format($product->price, 2, ',', '.') }}</strong>
                        <span class="text-[11.5px] text-muted">/un.</span>
                    </div>

                    @if(!empty(session('user.name')))
                        <div class="mt-auto flex items-center gap-1.5 pt-1">
                            <button
                                type="button"
                                onclick="decreaseQty({{ $product->id }})"
                                class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-primary text-base leading-none text-white"
                            >
                                −
                            </button>

                            <input
                                type="number"
                                id="qty-{{ $product->id }}"
                                name="products[{{ $product->id }}]"
                                value="0"
                                readonly
                                class="h-8 w-full min-w-0 rounded-lg border border-border text-center text-[13px] font-semibold"
                            >

                            <button
                                type="button"
                                onclick="increaseQty({{ $product->id }})"
                                class="flex h-8 w-8 flex-shrink-0 items-center justify-center rounded-lg bg-primary text-base leading-none text-white"
                            >
                                +
                            </button>
                        </div>
                    @else
                        <a
                            href="{{ route('login') }}"
                            class="mt-auto block rounded-lg bg-primary-light py-2 text-center text-[13px] font-semibold text-primary"
                        >
                            Entrar para comprar
                        </a>
                    @endif
                </div>
            </article>
        @endforeach
    </section>

@if(!empty(session('user.name')))
</form>

<div class="fixed inset-x-0 bottom-0 z-30 border-t border-border bg-surface/95 p-3 backdrop-blur sm:static sm:mt-6 sm:flex sm:justify-end sm:border-0 sm:bg-transparent sm:p-0 sm:backdrop-blur-none" style="padding-bottom: max(0.75rem, env(safe-area-inset-bottom));">
    <button
        type="button"
        onclick="document.getElementById('cartForm').submit()"
        class="block w-full rounded-xl bg-primary py-3.5 text-center text-base font-medium text-white shadow-lg sm:inline-block sm:w-auto sm:px-8"
    >
        Adicionar ao carrinho
    </button>
</div>
@else
</div>
@endif

<div class="mt-6">
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
