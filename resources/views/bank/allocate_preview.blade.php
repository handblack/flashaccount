@extends('layouts.app')

@section('container')
{{ $row->bpartner->bpartnername }}
<br>{{ $row->bpartner->bpartnercode }}

<table>
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Contexto</th>
            <th>Debe</th>
            <th>Haber</th>
        </tr>
    </thead>
    <tbody>
        @foreach($payment as $item)
            <tr>
                <td></td>
                <td>Asignacion Abierta</td>
                <td>{{ number_format($item->amount,env('DECIMAL_AMOUNT',2)) }}</td>
                <td></td>
            </tr>
        @endforeach
        @foreach($lines as $item)
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ number_format($item->amount,env('DECIMAL_AMOUNT',2)) }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <th></th>
            <th></th>
            <th>{{ number_format($payment->sum('amount'),env('DECIMAL_AMOUNT',2)) }}</th>
            <th>{{ number_format($lines->sum('amount'),env('DECIMAL_AMOUNT',2)) }}</th>
        </tr>
    </tfoot>
</table>

@endsection