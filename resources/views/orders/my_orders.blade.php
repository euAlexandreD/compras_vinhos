@extends('layout.app')

@section('title', 'Meus pedidos')
@section('page-title', 'Meus pedidos')
@section('page-subtitle', 'Histórico dos pedidos realizados')

@section('content')

<section class="flex flex-col gap-3">

    @forelse($orders as $order)

        <article class="rounded-2xl bg-surface p-4 shadow-sm sm:p-5">

            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <span class="text-xs text-muted">Pedido #{{ $order->id }}</span>
                    <h3 class="mt-0.5 text-lg font-medium text-ink">{{ $order->created_at?->format('d/m/Y H:i') }}</h3>
                </div>

                <strong class="rounded-full bg-primary-light px-3 py-1.5 text-xs font-semibold text-primary">
                    {{ $order->status->description ?? 'Sem status' }}
                </strong>
            </div>

            <div class="my-4 grid grid-cols-2 gap-2 border-y border-border py-3">
                <div>
                    <span class="block text-xs text-muted">Total</span>
                    <strong class="text-sm text-ink">R$ {{ number_format($order->total_price, 2, ',', '.') }}</strong>
                </div>

                <div>
                    <span class="block text-xs text-muted">Itens</span>
                    <strong class="text-sm text-ink">{{ $order->items->count() }}</strong>
                </div>
            </div>

            <div class="flex flex-col gap-1.5">
                @foreach($order->items as $item)
                    <div class="flex items-center justify-between gap-3 rounded-lg bg-bg px-3 py-2 text-sm">
                        <span class="truncate text-ink/80">{{ $item->product->name_wine ?? 'Produto removido' }}</span>
                        <strong class="flex-shrink-0 text-ink">{{ $item->quantity }}x</strong>
                    </div>
                @endforeach
            </div>

            <div class="mt-4 border-t border-border pt-4">
                <form action="{{ route('repeatOrder', $order->id) }}" method="POST">
                    @csrf

                    <button type="submit" class="h-11 w-full rounded-xl bg-primary text-sm font-medium text-white sm:w-auto sm:px-6">
                        Refazer pedido
                    </button>
                </form>
            </div>

        </article>

    @empty

        <div class="rounded-2xl bg-surface p-10 text-center shadow-sm sm:p-16">
            <h3 class="text-lg font-medium text-ink">Nenhum pedido encontrado</h3>
            <p class="mt-2 text-muted">Quando você fizer pedidos, eles aparecerão aqui.</p>
        </div>

    @endforelse

</section>

<div class="mt-6">
    {{ $orders->links() }}
</div>

@endsection
