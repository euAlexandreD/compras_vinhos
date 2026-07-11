@extends('layout.app')

@section('title', 'Meus pedidos')
@section('page-title', 'Meus pedidos')
@section('page-subtitle', 'Histórico dos pedidos realizados')

@section('content')
@vite('resources/css/orders.css')
<section class="orders-list">

    @forelse($orders as $order)

        <article class="order-card">

            <div class="order-header">
                <div>
                    <span>Pedido #{{ $order->id }}</span>
                    <h3>{{ $order->created_at?->format('d/m/Y H:i') }}</h3>
                </div>

                <strong class="status-badge">
                    {{ $order->status->description ?? 'Sem status' }}
                </strong>
            </div>

            <div class="order-info">
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
                <form action="{{ route('repeatOrder', $order->id) }}" method="POST">
                    @csrf

                    <button type="submit">
                        Refazer pedido
                    </button>
                </form>
            </div>

        </article>

    @empty

        <div class="empty-orders">
            <h3>Nenhum pedido encontrado</h3>
            <p>Quando você fizer pedidos, eles aparecerão aqui.</p>
        </div>

    @endforelse

</section>

    {{ $orders->links() }}

@endsection
