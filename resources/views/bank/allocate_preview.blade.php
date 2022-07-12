@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('ballocate.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="#" class="btn btn-sm btn-success" onclick="document.getElementById('form-preview').submit(); return false;">
                            <i class="fas fa-save fa-fw"></i> Finalizar
                        </a>
                    </div>
                    

                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Banco / Ingresos 
                            &nbsp;<i class="fab fa-cc-visa fa-fw"></i>

                        </h1>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('container')
<form action="{{ $url }}" method="POST" id="form-preview">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="mode" value="{{ $mode }}">

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
</form>
@endsection