<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
</head>
<body>
    ORDEN DE VENTA
<table width="100%">
    <tr>
        <td>
            {{ $row->bpartner->bpartnername }}
            <br>{{ $row->bpartner->bpartnercode }}
        </td>
    </tr>
</table>
<table width="100%">
    @foreach ($row->orderline as $item)
        <tr>
            <td>{{ ($item->typeproduct == 'P') ? $item->product->productcode : '' }}</td>
            <td>{{ $item->description }}</td>
            <td>{{ number_format($item->quantity,env('DECIMAL_QUANTITY',5)) }}</td>
            <td>{{ $item->um->shortname }}</td>
            <td>{{ number_format($item->amountgrand,env('DECIMAL_AMOUNT',2)) }}</td>
        </tr>
        
    @endforeach
</table>

</body>
</html>