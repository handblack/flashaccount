@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-clipboard-check fa-fw"></i> Inventario - {{ ($row->movetype == 'I') ? 'INGRESO' : 'SALIDA' }}</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Logistica</li>
                    <li class="breadcrumb-item">Inventario</li>
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
                        <a class="btn btn-sm btn-secondary" href="{{ route('linventory.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-default" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
                    <a href="{{ route('linventory.show','pdf') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-download fa-fw"></i> PDF
                    </a>
                   
                </div>
                <div class="col-sm-8">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Logistica / Inventario
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
        <div class="col-md-8 invoice-col">
            <dl>
                <dt>ALMACEN</dt>
                <dd>{{ $row->warehouse->warehousename }}</dd>
            </dl>            
        </div>
        <div class="col-md-2">
            <dl>
                <dt>FECHA</dt>
                <dd>{{ $row->datetrx }}</dd>
            </dl>
        </div>
        <div class="col-md-2">
            <dl>
                <dt>#CONTROL</dt>
                <dd>{{ $row->serial.'-'.$row->documentno }}</dd>
            </dl>
        </div>
    </div>
    <div class="row">        
        <table class="table table-sm">
            <thead>
                <tr>
                    <th width="80">CODIGO</th>
                    <th>PRODUCTO</th>
                    <th class="text-right" width="100">CANTIDAD</th>
                    <th width="40"></th>
                    <th class="text-right" width="100">PACK</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($row->lines as $item)
                    <tr>
                        <td>{{ $item->product->productcode }}</td>
                        <td>{{ $item->product->productname }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td>{{ $item->product->um->shortname }}</td>
                        <td class="text-right">{{ $item->package }}</td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="border-top">
                    <th colspan="2">{{ count($row->lines) }} - items</th>
                    <th class="text-right">{{ $row->lines->sum('quantity') }}</th>
                    <th></th>
                    <th class="text-right">{{ $row->lines->sum('package') }}</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection