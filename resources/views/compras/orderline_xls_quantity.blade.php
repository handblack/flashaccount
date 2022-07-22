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
                <th>Proveedor</th>
                <th>Codigo</th>
                <th>Producto</th>
                <th>Qty-Ordenado</th>
                <th>Qty-Recibido</th>
                <th>Qty-Pendiente</th>
            </tr>
        </thead>
        <tbody>
            @forelse($result as $line)
                @if($line->quantity <> $line->quantityopen)
                    <tr>
                        <td>{{ $line->order->serial }}-{{ $line->order->documentno }}</td>
                        <td>{{ $line->order->bpartner->bpartnername }}</td>
                        <td>{{ $line->product->productcode }}</td>
                        <td>{{ $line->product->productname }}</td>
                        <td class="text-right">{{ $line->quantity }}</td>
                        <td>{{ $line->quantityopen }}</td>
                        <td>{{ $line->quantity - $line->quantityopen }}</td>
                    </tr>
                @endif
            @empty
                <tr>
                    <td colspan="3">No hay informacion disponible</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>