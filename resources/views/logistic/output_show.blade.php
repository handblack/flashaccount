@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-4">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('loutput.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-default" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
                    <a href="{{ route('loutput.show','pdf') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-download fa-fw"></i> PDF
                    </a>
                   
                </div>
                <div class="col-sm-8">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Logistica / Salida de Mercaderia
                            &nbsp;
                            <i class="fas fa-warehouse fa-fw"></i>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('container')
    {{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}
    <table class="table table-sm">
        <tbody>
            @foreach ($row->lines as $item)
                <tr>
                    <td>{{ $item->product->productcode }}</td>
                    <td>{{ $item->product->productname }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->product->um->shortname }}</td>
                    <td>{{ $item->package }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection