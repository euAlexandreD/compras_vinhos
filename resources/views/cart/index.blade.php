@extends('layout.app')

@section('title', 'Carrinho')

@section('page-title', 'Meu Carrinho')
@section('page-subtitle', 'Revise os produtos antes de finalizar o pedido')

@section('content')
@vite('resources/css/cart.css')
@if(session('success'))

<div class="alert-success">
    {{ session('success') }}
</div>

@endif

@if(session('error'))

<div class="alert-error">
    {{ session('error') }}
</div>

@endif

@if(empty($cart))

<div class="empty-cart">

    <div class="empty-icon">
        🍷
    </div>

    <h2>Seu carrinho está vazio</h2>

    <p>
        Adicione alguns vinhos ao carrinho.
    </p>

    <a href="{{ route('index') }}" class="btn-primary">
        Ir ao catálogo
    </a>

</div>

@else

<div class="cart-container">

    <div class="cart-items">

        @php($total = 0)

        @foreach($cart as $item)

        @php($subtotal = $item['price'] * $item['quantity'])

        @php($total += $subtotal)

        <div class="cart-item">

            <div class="cart-image">
                🍷
            </div>

            <div class="cart-info">

                <h3>{{ $item['name'] }}</h3>

                <span>
                    Quantidade:
                    <strong>{{ $item['quantity'] }}</strong>
                </span>

            </div>

            <div class="cart-price">

                <small>Unitário</small>

                <strong>
                    R$ {{ number_format($item['price'],2,',','.') }}
                </strong>

            </div>

            <div class="cart-price">

                <small>Subtotal</small>

                <strong>
                    R$ {{ number_format($subtotal,2,',','.') }}
                </strong>

            </div>

        </div>

        @endforeach

    </div>

    <div class="cart-summary">

        <h3>Resumo do Pedido</h3>

        <div class="summary-row">
            <span>Total</span>

            <strong>
                R$ {{ number_format($total,2,',','.') }}
            </strong>
        </div>

        <form action="{{ route('checkout') }}" method="get">

            @csrf

            <button class="checkout-btn">
                Finalizar Pedido
            </button>

        </form>

        <a href="{{ route('index') }}" class="continue-shopping">
            Continuar comprando
        </a>
</div>
  <form action="{{ route('cart.remove') }}" method="POST">
    @csrf

    <input type="hidden" name="product_id" value="{{ $item['id'] }}">

    <button type="submit" class="remove-btn">
        Remover itens do carrinho
    </button>
</form>
    </div>

@endif

@endsection
