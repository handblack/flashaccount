<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title></title>
    <style>
        body{
            font-size: 12px;
        }
        .page-break {
            page-break-after: always;
        }
    </style>
</head>

<body>

    <table class="table table-bordered">
        <thead>
            <tr>
                <td><b>Fecha</b></td>
                <td><b>Codigo</b></td>
                <td><b>Socio</b></td>
                <td><b>Documento</b></td>
                <td><b>Importe</b></td>
                <td><b>Abierto</b></td>
            </tr>
        </thead>
        <tbody>
            @forelse ($result as $item)
                <tr>
                    <td>{{ $item->datetrx }}</td>
                    <td>{{ $item->bpartner->bpartnercode }}</td>
                    <td>{{ $item->bpartner->bpartnername }}</td>
                    <td>
                        {{ $item->cinvoice->sequence->doctype->doctypecode }}-{{ $item->cinvoice->serial }}-{{ $item->cinvoice->documentno }} 
                    </td>
                    <td class="text-right">
                        {{ number_format($item->amount,env('DECIMAL_AMOUNT',2)) }}
                        <small>{{ $item->cinvoice->currency->currencyiso }}</small>
                    </td>
                    <td class="text-right">
                        {{ number_format($item->amountopen,env('DECIMAL_AMOUNT',2)) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay informacion</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
