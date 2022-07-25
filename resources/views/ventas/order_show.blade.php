@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1><i class="fas fa-edit fa-fw"></i> Ordenes de Ventas</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Ventas</li>
                        <li class="breadcrumb-item">Ordenes de Ventas</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content-header  pt-1 pb-1">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('corder.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-default" onclick="location.reload();">
                            <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Actualizar</span>
                        </a>
                    </div>
                    
                    <div class="btn-group">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"> 
                                <i class="fas fa-map-signs fa-fw"></i>
                                  Accion 
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalCreateInvoice"><i class="far fa-file-alt fa-fw"></i> Emitir Comprobante de Venta</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalCreateOutput"><i class="far fa-file-alt fa-fw"></i> Crear Salida de Mercaderia</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalCreateOrder"><i class="far fa-copy fa-fw"></i> Copiar a nueva Orden de Venta</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i class="far fa-window-close fa-fw"></i> Cerrar documento</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('corder.show','pdf') }}"><i class="fas fa-download fa-fw"></i> Descargar PDF</a>
                                <!-- 
                                <a class="dropdown-item" href="#"><i class="fas fa-print fa-fw"></i> Imprimir</a> 
                                <a class="dropdown-item" href="#"><i class="fas fa-envelope fa-fw"></i> Enviar por Email</a>
                                -->
                            </div>
                        </div>
                    </div>
                    <!--
                    <div class="btn-group">
                        <a class="btn btn-sm btn-success" href="{{ route('corder.create') }}"
                            title="Marcar como página de inicio">
                            <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Nuevo OV</span>
                        </a>
                    </div>
                    -->
                </div>

                <div class="col-sm-6">
                    

                </div>

            </div>
        </div>
    </section>
@endsection

@section('container')
    <div class="invoice p-3 mb-3">
        <div class="row invoice-info">          
            <div class="col-12 col-md-6 invoice-col">
                <strong>Cliente:</strong>
                <p class="text-muted">
                    {{ $row->bpartner->bpartnername }}
                    <br>{{ $row->bpartner->bpartnercode }}
                </p>
            </div>
            <div class="col-6 col-md-3">
                <dl class="row mb-2">
                    <dt class="col-sm-5">Orden Ventas</dt>
                    <dd class="col-sm-7">{{ $row->serial }}-{{ $row->documentno }}</dd>
                    <dt class="col-sm-5">Fecha</dt>
                    <dd class="col-sm-7">{{ \Carbon\Carbon::parse($row->dateorder)->format('d/m/Y')}}</dd>
                    <dt class="col-sm-5">Almacen</dt>
                    <dd class="col-sm-7">{{ $row->warehouse->warehousename }}</dd>
                </dl>
            </div>
            <div class="col-6 col-md-3">
                <dl class="row mb-2">
                    <dt class="col-sm-5">Solicitado</dt>
                    <dd class="col-sm-7">{{ number_format($row->lines->sum('quantity'),env('DECIMAL_QUANTITY',5)) }}</dd>
                    <dt class="col-sm-5">Recibido</dt>
                    <dd class="col-sm-7">{{ number_format($row->lines->sum('quantityopen'),env('DECIMAL_QUANTITY',5)) }}</dd>
                    <dt class="col-sm-5">Suspendido</dt>
                    <dd class="col-sm-7">{{ number_format($row->lines->sum('quantitysuspended'),env('DECIMAL_QUANTITY',5)) }}</dd>
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
                            <th class="d-none d-sm-inline-block">UM</th>
                            <th class="text-right">Precio</th>
                            <th class="text-right">Total</th>
                            <th width="100" class="text-right"><small>Entregado</small></th>
                            <th width="100" class="text-right"><small>Suspendido</small></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($row->lines as $item)
                            <tr>
                                <td>{{ $item->description }}</td>
                                <td class="d-none d-sm-inline-block">{{ ($item->product_id) ? $item->product->productcode : '' }}</td>
                                <td class="text-right">{{ $item->quantity }}</td>
                                <td class="d-none d-sm-inline-block">{{ $item->um->shortname }}</td>
                                <td class="text-right">{{ number_format($item->priceunit,env('DECIMAL_AMOUNT',2)) }}</td>
                                <td class="text-right">{{ number_format($item->amountgrand,env('DECIMAL_AMOUNT',2)) }}</td>
                                <td class="text-right border-left" width="100">
                                    {{ number_format($item->quantityopen,env('DECIMAL_QUANTITY',5)) }}
                                </td>
                                <td class="text-right" width="100">
                                    {{ number_format($item->quantitysuspended,env('DECIMAL_QUANTITY',5)) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="border-top">
                            <th>{{ count($row->lines) }} - Item(s)</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="text-right">TOTAL: </th>
                            <th class="text-right">{{ $row->currency->prefix }} {{ number_format($row->amountgrand,2) }}</th>
                            <th></th>
                            <th></th>

                            <!--
                            <th class="text-right">{{ number_format($row->lines->sum('quantityopen'),env('DECIMAL_QUANTITY',5)) }}</th>
                            <th class="text-right">{{ number_format($row->lines->sum('quantitysuspended'),env('DECIMAL_QUANTITY',5)) }}</th>
                            -->
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <strong>Documentos Vinculados</strong>
                    <ul>
                        @foreach ($row->invoices as $item)
                            <li>{{ $item->doctype->doctypename }} {{ $item->serial }}-{{ $item->documentno }} - {{ $item->currency->prefix }} {{ number_format($item->amountgrand,env('DECIMAL_AMOUNT',2)) }}</li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-md-6">
                    <strong>Salidas de Almacen</strong>
                    <ul class="mb-0">
                        @foreach ($row->outputs as $item)
                          <li>{{ $item->sequence->doctype->doctypename }} #{{ $item->serial }}-{{ $item->documentno }}  <i class="fas fa-calendar-alt fa-fw"></i> {{ \Carbon\Carbon::parse($item->datetrx)->format('d/m/Y')}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>


<!-- Modal -->
<!-- CREAR/DUPLICAR ORDEN DE VENTA -->
<div class="modal fade" id="ModalCreateOrder" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('corder_copy_to_order') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="order_id" value="{{ $row->id }}">
                <input type="hidden" name="token" value="{{ $row->token }}">
                <input type="hidden" name="mode" value="temp">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Nueva Orden de Venta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light pt-1">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label class="mb-0">Cliente</label>
                            <select name="bpartner_id" class="form-control select2-bpartner">
                                <option value="{{ $row->bpartner_id }}">{{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}</option>
                            </select>                            
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mt-2">
                            <label class="mb-0">Fecha</label>
                            <input type="date" name="dateorder" class="form-control" value="{{ date("Y-m-d") }}">
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="mb-0">Serie</label>
                            <select name="sequence_id" id="" class="form-control" required>
                                <option value="" selected disabled>-- SELECCIONE --</option>
                                @foreach(auth()->user()->sequence('OVE') as $item)
                                    <option value="{{ $item->id }}">{{ $item->serial }} - {{ $item->doctype->doctypename }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0">Almacen Ingreso</label>
                            <select name="warehouse_id" id="" class="form-control select2-warehouse" required></select>
                        </div>
                    </div>
                     
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div>  


<div class="modal fade" id="ModalCreateInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('corder_copy_to_invoice') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="order_id" value="{{ $row->id }}">
                <input type="hidden" name="token" value="{{ $row->token }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Emitir Comprobante</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select name="sequence_id" id="" class="form-control" required>
                        <option value="" selected disabled>-- SELECCIONE --</option>
                        @foreach ($sequence_invoice as $item)
                            <option value="{{ $item->id }}">{{ $item->serial }} - {{ $item->doctype->doctypename }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div>    


<div class="modal fade" id="ModalCreateOutput"   role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('corder_copy_to_output') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="order_id" value="{{ $row->id }}">
                <input type="hidden" name="token" value="{{ $row->token }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Parte SALIDA</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="row">
                        <div class="col-8 col-md-10 mt-2">
                            <label class="mb-0">Proveedor</label>
                            <span class="input-group-text">{{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}</span>
                        </div>
                        <div class="col-4 col-md-2 mt-2">
                            <label class="mb-0">Orden Venta</label>
                            <span class="input-group-text">{{ $row->serial }} - {{ $row->documentno }}</span>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-6 col-md-3 mt-2">
                            <label class="mb-0">Fecha</label>
                            <input type="date" name="datetrx" class="form-control" value="{{ date("Y-m-d") }}"> 
                        </div>
                        <div class="col-6 col-md-3 mt-2">
                            <label class="mb-0">Serie</label>
                            <select name="sequence_id" id="" class="form-control" required>
                                <option value="" selected disabled>-- SELECCIONE --</option>
                                @foreach ($sequence_output as $item)
                                    <option value="{{ $item->id }}">{{ $item->serial }} - {{ $item->doctype->doctypename }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0">Almacen Salida</label>
                            <select name="warehouse_id" id="" class="form-control select2-warehouse" required></select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label class="mb-0">Motivo</label>
                            <select name="reason_id" id="" class="form-control" required>
                                @foreach ($reason as $item)
                                    <option value="{{ $item->id }}">{{ $item->reasonname }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Continuar</button>
                </div>
            </form>
        </div>
    </div>
</div> 
@endsection



@section('script')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-number/jquery.number.min.js') }}"></script>
<script>
$(function(){
    // bpartner ----------------------------------------------------------------
    $('.select2-bpartner').select2({
        ajax: {
            url: '{{ route('api.bpartner') }}',
            type: 'post',
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                    q: params.term, // search term
                    t:'C',
                    page: params.page
                };
            },
            cache: true
        },
        minimumInputLength: 3,
        theme:'bootstrap4'
    });
    // warehouse ----------------------------------------------------------------
    $('.select2-warehouse').select2({
        ajax: {
            url: '{{ route('api.warehouse') }}',
            type: 'post',
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        theme:'bootstrap4'
    });
    // Sumando totales --------------------------------------------------------------
    
});
</script>
@endsection