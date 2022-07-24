<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    <table>
        <thead>
            <tr>
                <th>O.Compra</th>
                <th>Codigo</th>
                <th>Proveedor</th>
                <th>Divisa</th>
                <th>Importe</th>
                <th>Facturas</th>
                <th>Guias</th>
            </tr>
        </thead>
        <tbody>
            @forelse($result as $order)                
                <tr>
                    <td>{{ $order->serial }}-{{ $order->documentno }}</td>
                    <td>{{ $order->bpartner->bpartnercode }}</td>
                    <td>{{ $order->bpartner->bpartnername }}</td>
                    <td>{{ $order->currency->currencyiso }}</td>
                    <td class="text-right">{{ $order->amountgrand }}</td>
                    <td>
                        <ul>
                            @foreach($order->invoices as $line)
                                <li>{{ $line->serial }}_{{ $line->documentno }}_{{ $line->amountgrand }};</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>
                        @foreach($order->inputs as $line)
                        {{ $line->serial }}-{{ $line->documentno }};
                        @endforeach                    
                    </td>
                </tr>                
            @empty
                <tr>
                    <td colspan="3">No hay informacion disponible</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>