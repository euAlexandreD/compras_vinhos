<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório de Pedidos</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #2b1b1b;
            font-size: 12px;
        }

        h1 {
            color: #7b1428;
            margin-bottom: 20px;
        }

        h2 {
            color: #7b1428;
            margin-top: 30px;
        }

        .client {
            margin-bottom: 35px;
            page-break-inside: avoid;
        }

        .summary {
            margin-bottom: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 7px;
        }

        th {
            background: #7b1428;
            color: #fff;
        }

        .total {
            text-align: right;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <h1>Relatório de Pedidos por Cliente</h1>
@if($startDate || $endDate)
    <p>
        <strong>Período:</strong>
        {{ $startDate ? date('d/m/Y', strtotime($startDate)) : 'Início' }}
        até
        {{ $endDate ? date('d/m/Y', strtotime($endDate)) : 'Hoje' }}
    </p>
@endif
@foreach($users as $user)

    <div class="client">
        <h2>{{ $user->username }} {{ $user->lastname }}</h2>

        <div class="summary">
            <strong>E-mail:</strong> {{ $user->email }} <br>
            <strong>Total de pedidos:</strong> {{ $user->orders->count() }} <br>
            <strong>Total comprado:</strong>
            R$ {{ number_format($user->orders->sum('total_price'), 2, ',', '.') }}
        </div>

        @foreach($user->orders as $order)

            <h3>Pedido #{{ $order->id }}</h3>

            <p>
                <strong>Data:</strong> {{ $order->created_at?->format('d/m/Y H:i') }} |
                <strong>Total:</strong> R$ {{ number_format($order->total_price, 2, ',', '.') }}
            </p>

            <table>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Quantidade</th>
                        <th>Unitário</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td>{{ $item->product->name_wine ?? 'Produto removido' }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                            <td>R$ {{ number_format($item->subtotal, 2, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

        @endforeach
    </div>

@endforeach

</body>
</html>
