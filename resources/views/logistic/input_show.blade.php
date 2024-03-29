@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="far fa-file-alt fa-fw"></i> Ingreso</h1>
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
<section class="content-header pt-1 pb-1">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-4">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('linput.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-default" onclick="location.reload();">
                            <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Actualizar</span>
                        </a>
                    </div>
                    <a href="{{ route('linput.show','pdf') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-download fa-fw"></i> PDF
                    </a>
                   
                </div>
                <div class="col-sm-8">
                   
                </div>
            </div>
        </div>
    </section>
@endsection

@section('container')
<div class="invoice p-3 mb-3">
    <div class="row invoice-info">
                
            <div class="col-12 col-md-5 invoice-col">
                <dl class="mb-0">
                    <dt>Proveedor</dt>
                    <dd>{{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}</dd>
                    <dd>
                        {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->address : '_FALTA_ESPECIFICAR_DIRECCION_' }}
                    </dd>
                    <dd>
                        {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->state->statename : '' }} - 
                        {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->county->countyname : '' }} - 
                        {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->city->cityname : '' }}
                    </dd>
                    <dd>
                        {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->country->countryname : '' }}
                    </dd>
                    <dd>{{ $row->glosa }}</dd>
                </dl>
            </div>
            <div class="col-md-4">
                <dl class="mb-0">
                    <dt>Almacen INGRESO</dt>
                    <dd>{{ $row->warehouse->warehousename }}</dd>
                    <dd>{{ $row->warehouse->address->address }}</dd>                        
                    <dt>Motivo</dt>
                    <dd>{{ $row->reason->reasonname }}</dd>
                </dl>
            </div>
            <div class="col-6 col-md-3">
                <dl class="row mb-2">
                    <dt class="col-sm-5">#Ingreso</dt>
                    <dd class="col-sm-7">{{ $row->serial }}-{{ $row->documentno }}</dd>
                    <dt class="col-sm-5">Orden Compra</dt>
                    <dd class="col-sm-7">
                        @if($row->order_id)
                            {{ $row->order->serial }}-{{ $row->order->documentno }}
                        @endif
                    </dd>
                    <dt class="col-sm-5">Fecha</dt>
                    <dd class="col-sm-7">{{ \Carbon\Carbon::parse($row->dateorder)->format('d/m/Y')}}</dd>
                </dl>
            </div>
            
    </div>
    <div class="row">
        <div class="col-12 table-responsive">
            <table class="table table-striped table-sm table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th class="d-none d-sm-inline-block">Codigo</th>
                        <th class="text-right">Cantidad</th>
                        <th>UM</th>
                        <th class="text-right">Pack</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($row->lines as $item)
                    <tr>
                        <td>{{ $item->product->productname }}</td>
                        <td class="d-none d-sm-inline-block">{{ $item->product->productcode }}</td>
                        <td class="text-right" width="100">{{ $item->quantity }}</td>
                        <td>{{ $item->product->um->shortname }}</td>
                        <td class="text-right" width="60">{{ (int)$item->package }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>    
</div>
@endsection