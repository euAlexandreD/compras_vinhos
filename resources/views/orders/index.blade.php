@extends('layout.app')

@section('title', 'Pedidos')
@section('page-title', 'Pedidos')
@section('page-subtitle', 'Acompanhe os pedidos realizados no sistema')

@section('content')

<section class="mb-5 rounded-2xl bg-surface p-4 shadow-sm sm:p-5">
    <form method="GET" action="{{ route('orders') }}" class="flex flex-col gap-2 sm:flex-row">
        <input
            type="text"
            name="keyword"
            value="{{ request('keyword') }}"
            placeholder="Buscar por pedido ou cliente..."
            class="h-12 w-full flex-1 rounded-xl border border-border bg-surface px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
        >

        <select
            name="status_id"
            class="h-12 w-full rounded-xl border border-border bg-surface px-4 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10 sm:w-56"
        >
            <option value="">Todos os status</option>

            @foreach($statuses as $status)
                <option value="{{ $status->id }}" @selected(request('status_id') == $status->id)>
                    {{ $status->description }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="h-12 flex-shrink-0 rounded-xl bg-primary px-6 font-medium text-white">
            Pesquisar
        </button>
    </form>
</section>

<section class="flex flex-col gap-3">

    @forelse($orders as $order)

        <article class="rounded-2xl bg-surface p-4 shadow-sm sm:p-5">

            <div class="flex flex-wrap items-start justify-between gap-3">
                <div>
                    <span class="text-xs text-muted">Pedido #{{ $order->id }}</span>
                    <h3 class="mt-0.5 text-lg font-medium text-ink">{{ $order->user->username ?? 'Cliente não informado' }}</h3>
                </div>

                <strong class="rounded-full bg-primary-light px-3 py-1.5 text-xs font-semibold text-primary">
                    {{ $order->status->description ?? 'Sem status' }}
                </strong>
            </div>

            <div class="my-4 grid grid-cols-3 gap-2 border-y border-border py-3">
                <div>
                    <span class="block text-xs text-muted">Data</span>
                    <strong class="text-sm text-ink">{{ $order->created_at?->format('d/m/Y H:i') }}</strong>
                </div>

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

            <div class="mt-4 flex flex-col gap-2 border-t border-border pt-4 sm:flex-row sm:items-center sm:justify-between">
                <a href="#" class="text-sm font-medium text-primary">Ver detalhes</a>

                <button class="h-10 rounded-lg bg-primary px-4 text-sm font-medium text-white">
                    Atualizar status
                </button>
            </div>

        </article>

    @empty

        <div class="rounded-2xl bg-surface p-10 text-center shadow-sm sm:p-16">
            <h3 class="text-lg font-medium text-ink">Nenhum pedido encontrado</h3>
            <p class="mt-2 text-muted">Os pedidos finalizados aparecerão aqui.</p>
        </div>

    @endforelse

</section>

<section class="mt-6 rounded-2xl bg-surface p-4 shadow-sm sm:p-5">
    <div class="mb-4 text-lg font-medium text-primary">Relatórios</div>

    <form method="GET" action="{{ route('orders.pdf') }}" class="flex flex-col gap-3 sm:flex-row sm:flex-wrap sm:items-end">
        <div class="flex flex-col gap-1.5">
            <label class="text-sm font-semibold text-ink/70">Data inicial</label>
            <input
                type="date"
                name="start_date"
                value="{{ request('start_date') }}"
                class="h-11 rounded-xl border border-border px-3 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
            >
        </div>

        <div class="flex flex-col gap-1.5">
            <label class="text-sm font-semibold text-ink/70">Data final</label>
            <input
                type="date"
                name="end_date"
                value="{{ request('end_date') }}"
                class="h-11 rounded-xl border border-border px-3 text-base outline-none focus:border-primary focus:ring-4 focus:ring-primary/10"
            >
        </div>

        <button
            type="submit"
            formaction="{{ route('orders.pdf') }}"
            class="h-11 rounded-xl bg-primary px-6 text-sm font-semibold text-white"
        >
            📄 Vendas por cliente
        </button>

        <button
            type="submit"
            formaction="{{ route('orders.bottlesPdf') }}"
            class="h-11 rounded-xl bg-secondary px-6 text-sm font-semibold text-white"
        >
            🍷 Garrafas pedidas
        </button>

        <a
            href="{{ route('orders') }}"
            class="flex h-11 items-center justify-center rounded-xl bg-ink/10 px-6 text-sm font-semibold text-ink"
        >
            Limpar filtros
        </a>
    </form>
</section>

<div class="mt-6">
    {{ $orders->links() }}
</div>

@endsection
