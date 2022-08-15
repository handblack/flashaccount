@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-random fa-fw"></i> Transferencia</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Logistica</li>
                    <li class="breadcrumb-item">Transferencia</li>
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
                        <a class="btn btn-sm btn-secondary" href="{{ route('ltransfer.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-default" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
                    <a href="{{ route('ltransfer.show','pdf') }}" class="btn btn-default btn-sm">
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
<div class="invoice p-3 mb-3">
    <div class="row invoice-info">
        <div class="col-md-4 invoice-col">
            <label class="mb-0 mt-1">Almacen Origen</label>
            <p class="text-muted">
                {{ $row->warehouse->warehousename }}
            </p>
        </div>
        <div class="col-md-4 invoice-col">
            <label class="mb-0 mt-1">Almacen Destino</label>
            <p class="text-muted">
                {{ $row->warehouse->address->address }}
            </p>
        </div>
        <div class="col-md-2 invoice-col">
            <label class="mb-0 mt-1">#CONTROL</label>
            <p class="text-muted">
                {{ $row->serial.'-'.$row->documentno }}
            </p>
        </div>
        <div class="col-md-2 invoice-col">
            <label class="mb-0 mt-1">FECHA</label>
            <p class="text-muted">
                {{ $row->datetrx }}
            </p>
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