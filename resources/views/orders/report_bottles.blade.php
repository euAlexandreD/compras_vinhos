<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Relatório de Garrafas Pedidas</title>

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

        td.number {
            text-align: right;
        }

        tfoot td {
            font-weight: bold;
            background: #f3e6e8;
        }
    </style>
</head>
<body>

    <h1>Relatório de Garrafas Pedidas</h1>

    @if($startDate || $endDate)
        <p>
            <strong>Período:</strong>
            {{ $startDate ? date('d/m/Y', strtotime($startDate)) : 'Início' }}
            até
            {{ $endDate ? date('d/m/Y', strtotime($endDate)) : 'Hoje' }}
        </p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Vinho</th>
                <th>Tipo</th>
                <th>Quantidade</th>
                <th>Valor total</th>
            </tr>
        </thead>

        <tbody>
            @forelse($items as $item)
                <tr>
                    <td>{{ $item->product->name_wine ?? 'Produto removido' }}</td>
                    <td>{{ $item->product->type ?? '-' }}</td>
                    <td class="number">{{ $item->total_quantity }}</td>
                    <td class="number">R$ {{ number_format($item->total_value, 2, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">Nenhuma garrafa pedida no período selecionado.</td>
                </tr>
            @endforelse
        </tbody>

        <tfoot>
            <tr>
                <td colspan="2">Total geral</td>
                <td class="number">{{ $totalBottles }}</td>
                <td class="number">R$ {{ number_format($totalValue, 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

</body>
</html>
