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
                <th>Producto</th>
                <th>QtyOrder</th>
                <th>QtyRecived</th>
            </tr>
        </thead>
        <tbody>
            @forelse($result as $line)
                @if($line->quantity <> $line->quantityopen)
                    <tr>
                        <td>{{ $line->id }}</td>
                        <td>
                            @if($line->order)
                                {{ $line->order->serial }}-{{ $line->order->documentno }}
                            @endif
                        </td>
                        <td>{{ $line->product->productcode }}</td>
                        <td>{{ $line->product->productname }}</td>
                        <td class="text-right">{{ $line->quantity }}</td>
                        <td>{{ $line->quantityopen }}</td>
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