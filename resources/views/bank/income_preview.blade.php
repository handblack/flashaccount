@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('bincome.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
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
<form action="{{ $url }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="PUT">
    <input type="hidden" name="mode" value="{{ $mode }}">
    <button type="submit">Crear</button>
    <div class="row console">
        <div class="col-md-6">
            {{ $row->bpartner->bpartnername }}
            <table>
                <thead>
                    <tr>
                        <td>CONCEPTOS</td>
                        <td>FECHA</td>
                        <td class="text-right">ABONOS</td>
                        <td class="text-right">CARGOS</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $row->payment->amount  }}</td>
                    </tr>
                    @foreach ($row->line as $item)                   
                    <tr>
                        <td>{{ $item->invoice_id }}</td>
                        <td></td>
                        <td>{{ $item->amount }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td>{{ $item->descripction }}</td>
                        <td>{{ $item->datetrx }}</td>
                        <td class="text-right">0.00</td>
                        <td class="text-right">0.00</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-md-6"></div>
    </div> 
</form>

@endsection