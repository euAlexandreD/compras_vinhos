@extends('layout.app')

@section('title', 'Pedidos')
@section('page-title', 'Pedidos')
@section('page-subtitle', 'Acompanhe os pedidos realizados no sistema')

@section('content')
@vite('resources/css/orders.css')
<section class="orders-toolbar">
    <form method="GET" action="{{ route('orders') }}" class="orders-filter">
        <input
            type="text"
            name="keyword"
            value="{{ request('keyword') }}"
            placeholder="Buscar por pedido ou cliente..."
        >

        <select name="status_id">
            <option value="">Todos os status</option>

            @foreach($statuses as $status)
                <option value="{{ $status->id }}" @selected(request('status_id') == $status->id)>
                    {{ $status->description }}
                </option>
            @endforeach
        </select>

        <button type="submit">Pesquisar</button>
    </form>
</section>

<section class="orders-list">

    @forelse($orders as $order)

        <article class="order-card">

            <div class="order-header">
                <div>
                    <span>Pedido #{{ $order->id }}</span>
                    <h3>{{ $order->user->username ?? 'Cliente não informado' }}</h3>
                </div>

                <strong class="status-badge">
                    {{ $order->status->description ?? 'Sem status' }}
                </strong>
            </div>

            <div class="order-info">
                <div>
                    <span>Data</span>
                    <strong>{{ $order->created_at?->format('d/m/Y H:i') }}</strong>
                </div>

                <div>
                    <span>Total</span>
                    <strong>R$ {{ number_format($order->total_price, 2, ',', '.') }}</strong>
                </div>

                <div>
                    <span>Itens</span>
                    <strong>{{ $order->items->count() }}</strong>
                </div>
            </div>

            <div class="order-items">
                @foreach($order->items as $item)
                    <div class="order-item">
                        <span>{{ $item->product->name_wine ?? 'Produto removido' }}</span>
                        <strong>{{ $item->quantity }}x</strong>
                    </div>
                @endforeach
            </div>

            <div class="order-actions">
                <a href="#">Ver detalhes</a>
                <button>Atualizar status</button>
            </div>

        </article>

    @empty

        <div class="empty-orders">
            <h3>Nenhum pedido encontrado</h3>
            <p>Os pedidos finalizados aparecerão aqui.</p>
        </div>

    @endforelse

</section>
     <div class="report-filter">
    <form method="GET" action="{{ route('orders.pdf') }}">

        <div class="field">
            <label>Data inicial</label>
            <input
                type="date"
                name="start_date"
                value="{{ request('start_date') }}">
        </div>

        <div class="field">
            <label>Data final</label>
            <input
                type="date"
                name="end_date"
                value="{{ request('end_date') }}">
        </div>

        <button type="submit">
            📄 Gerar PDF
        </button>

        <a href="{{ route('orders') }}" class="clear">
            Limpar filtros
        </a>

    </form>
</div>

    {{ $orders->links() }}

@endsection
