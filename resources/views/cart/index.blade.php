@extends('layout.app')

@section('title', 'Carrinho')

@section('page-title', 'Meu Carrinho')
@section('page-subtitle', 'Revise os produtos antes de finalizar o pedido')

@section('content')

@if(session('success'))
    <div class="mb-5 rounded-xl border-l-4 border-success bg-green-50 px-4 py-3 text-sm text-green-800">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-5 rounded-xl bg-red-50 px-4 py-3 text-sm text-danger">
        {{ session('error') }}
    </div>
@endif

@if(empty($cart))

    <div class="rounded-2xl bg-surface p-10 text-center shadow-sm sm:p-20">
        <div class="mb-4 text-6xl">🍷</div>
        <h2 class="text-xl font-medium text-ink">Seu carrinho está vazio</h2>
        <p class="mt-2 text-muted">Adicione alguns vinhos ao carrinho.</p>

        <a
            href="{{ route('index') }}"
            class="mt-6 inline-flex h-12 items-center rounded-xl bg-primary px-6 font-medium text-white"
        >
            Ir ao catálogo
        </a>
    </div>

@else

<div class="flex flex-col gap-6 md:grid md:grid-cols-[1fr_360px] md:items-start">

    <div class="flex flex-col gap-3">

        @php($total = 0)

        @foreach($cart as $item)

            @php($subtotal = $item['price'] * $item['quantity'])
            @php($total += $subtotal)

            <div class="flex flex-col gap-3 rounded-2xl bg-surface p-4 shadow-sm sm:flex-row sm:items-center sm:gap-4 sm:p-5">

                <div class="flex items-center gap-3 sm:flex-1">
                    <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-xl bg-primary-light text-2xl">
                        🍷
                    </div>

                    <div class="min-w-0">
                        <h3 class="truncate font-medium text-ink">{{ $item['name'] }}</h3>
                        <span class="text-sm text-muted">
                            Quantidade: <strong class="text-ink">{{ $item['quantity'] }}</strong>
                        </span>
                    </div>
                </div>

                <div class="flex items-center justify-between gap-4 border-t border-border pt-3 sm:border-0 sm:pt-0">
                    <div class="text-left sm:text-center">
                        <small class="block text-xs text-muted">Unitário</small>
                        <strong class="text-primary">R$ {{ number_format($item['price'], 2, ',', '.') }}</strong>
                    </div>

                    <div class="text-left sm:text-center">
                        <small class="block text-xs text-muted">Subtotal</small>
                        <strong class="text-primary">R$ {{ number_format($subtotal, 2, ',', '.') }}</strong>
                    </div>

                    <form action="{{ route('cart.remove') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">

                        <button type="submit" class="rounded-lg bg-primary-light px-3 py-2 text-sm font-medium text-primary">
                            Remover
                        </button>
                    </form>
                </div>

            </div>

        @endforeach

    </div>

    <div class="rounded-2xl bg-surface p-5 shadow-sm sm:p-6 md:sticky md:top-24">

        <h3 class="mb-5 text-lg font-medium text-ink">Resumo do Pedido</h3>

        <div class="mb-6 flex items-center justify-between">
            <span class="text-muted">Total</span>
            <strong class="text-xl text-primary">R$ {{ number_format($total, 2, ',', '.') }}</strong>
        </div>

        <form action="{{ route('checkout') }}" method="get">
            @csrf

            <button class="mb-3 h-12 w-full rounded-xl bg-primary font-medium text-white transition-colors hover:bg-primary-dark">
                Finalizar Pedido
            </button>
        </form>

        <a href="{{ route('index') }}" class="block text-center text-sm text-primary">
            Continuar comprando
        </a>
    </div>

</div>

@endif

@endsection
