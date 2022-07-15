@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit fa-fw"></i> Ingreso</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Logistica</li>
                    <li class="breadcrumb-item">Ingresos</li>
                </ol>
            </div>
        </div>
    </div>
</section>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-4">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('linput.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-default" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
                    <a href="{{ route('linput.show','pdf') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-download fa-fw"></i> PDF
                    </a>
                   
                </div>
                <div class="col-sm-8">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Logistica / Ingreso de Mercaderia
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
<div class="invoice p-3 mb-3">
    <div class="row invoice-info">
        {{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}
    </div>
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped table-sm table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="d-none d-sm-inline-block">Codigo</th>
                        <th class="text-right">Cantidad</th>
                        <th class="d-none d-sm-inline-block">UM</th>
                        <th class="text-right">Precio</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
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
        </div>
    </div>
    Referencia 
    <br>
    @if($row->order_id)
        {{ $row->order->serial }}-
        {{ $row->order->documentno }}
    @endif
</div>
@endsection