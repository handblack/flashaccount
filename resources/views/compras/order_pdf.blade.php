<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="{{ asset('assets/pdf.css') }}">
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
    <tbody>
        @foreach ($row->lines as $item)
            <tr>
                <td>{{ ($item->typeproduct == 'P') ? $item->product->productcode : '' }}</td>
                <td>{{ $item->description }}</td>
                <td class="text-right">{{ number_format($item->quantity,env('DECIMAL_QUANTITY',5)) }}</td>
                <td>{{ $item->um->shortname }}</td>
                <td>{{ number_format($item->amountgrand,env('DECIMAL_AMOUNT',2)) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <td>{{ number_format($item->sum('quantity'),env('DECIMAL_QUANTITY',5)) }}</td>
            <td></td>
            <td>{{ number_format($item->sum('amountgrand'),env('DECIMAL_AMOUNT',2)) }}</td>
        </tr>
    </tfoot>
</table>

</body>
</html>