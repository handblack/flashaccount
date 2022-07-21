<!DOCTYPE html>
<html>
<head>
    <title>Document</title>
    <link rel="stylesheet" href="{{ public_path('assets/pdf.css') }}">
</head>
<body>
<strong>ORDEN DE COMPRA</strong>
<table width="100%">
    <tr class="border-top">
        <td width="60%">
            <strong>Proveedor</strong>
            <br>{{ $row->bpartner->bpartnername }}
            <br>{{ $row->bpartner->bpartnercode }}
        </td>
        <td width="40%">
            <table cellpadding="0" cellspacing="0">
                <tr>
                    <td>Orden Compra</td>
                    <td>{{ $row->serial }}-{{ $row->documentno }}</td>
                </tr>
                <tr>
                    <td>Fecha</td>
                    <td>{{ $row->dateorder }}</td>
                </tr>
                <tr>
                    <td>Almacen</td>
                    <td>{{ $row->warehouse->warehousename }}</td>
                </tr>
            </table>
        </td>

    </tr>
</table>
<table width="100%">
    <thead>
        <tr class="border-top border-bottom">
            <th class="text-left">Codigo</th>
            <th class="text-left">Producto/Descripcion</th>
            <th class="text-right">Cantidad</th>
            <th class="text-right"></th>
            <th class="text-right">PU</th>
            <th class="text-right">Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($row->lines as $item)
            <tr>
                <td>{{ ($item->typeproduct == 'P') ? $item->product->productcode : '' }}</td>
                <td>{{ $item->description }}</td>
                <td class="text-right">{{ number_format($item->quantity,env('DECIMAL_QUANTITY',5)) }}</td>
                <td>{{ $item->um->shortname }}</td>
                <td class="text-right">{{ number_format($item->priceunittax,env('DECIMAL_QUANTITY',5)) }}</td>
                <td class="text-right">{{ number_format($item->amountgrand,env('DECIMAL_AMOUNT',2)) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td></td>
            <th class="text-right">{{ number_format($item->sum('quantity'),env('DECIMAL_QUANTITY',5)) }}</th>
            <td></td>
            <td></td>
            <th class="text-right">
                {{ $row->currency->prefix }}
                {{ number_format($row->lines->sum('amountgrand'),env('DECIMAL_AMOUNT',2)) }}
            </th>
        </tr>
    </tfoot>
</table>

</body>
</html>