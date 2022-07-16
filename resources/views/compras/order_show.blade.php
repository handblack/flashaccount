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
                    <h1><i class="fas fa-edit fa-fw"></i> Orden de Compra</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Compras</li>
                        <li class="breadcrumb-item">Ordenes de Compras</li>
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
                        <a class="btn btn-sm btn-secondary" href="{{ route('porder.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-default" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
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
                                <!--  <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalCreateInvoice"><i class="far fa-copy fa-fw"></i> Copiar a Comprobante</a> -->
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalCreateInvoice"><i class="far fa-copy fa-fw"></i> Registrar Factura de Proveedor</a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#ModalCreateInput"><i class="far fa-copy fa-fw"></i> Copiar a Ingreso de Mercaderia</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#"><i class="far fa-window-close fa-fw"></i> Cerrar documento</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="{{ route('porder.show','pdf') }}"><i class="fas fa-download fa-fw"></i> Descargar PDF</a>
                                <!-- 
                                <a class="dropdown-item" href="#"><i class="fas fa-print fa-fw"></i> Imprimir</a> 
                                <a class="dropdown-item" href="#"><i class="fas fa-envelope fa-fw"></i> Enviar por Email</a>
                                -->
                            </div>
                        </div>
                    </div>
                    <div class="btn-group">
                        <a class="btn btn-sm btn-success" href="{{ route('porder.create') }}"
                            title="Marcar como página de inicio">
                            <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Nuevo OV</span>
                        </a>
                    </div>

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
            <!--
            <div class="col-sm-4 invoice-col">
                {{ auth()->user()->get_param('system.entity.bpartnername','EMPRESA_PRUEBA') }}
                <br>{{ auth()->user()->get_param('system.entity.ruc','10123456780') }}                
            </div>
            -->
            <div class="col-md-8 invoice-col">
                {{ $row->bpartner->bpartnername }}
                <br>{{ $row->bpartner->bpartnercode }}
            </div>

            <div class="col-12 col-md-4">
                <dl class="row">
                    <dt class="col-xs-6">Orden de Venta</dt>
                    <dd class="col-xs-6">{{ $row->serial }}-{{ $row->documentno }}</dd>
                    <dt class="col-sm-6">Fecha</dt>
                    <dd class="col-sm-6">{{ $row->dateorder }}</dd>
                    <dt class="col-sm-6">Almacen</dt>
                    <dd class="col-sm-6">{{ $row->warehouse->warehousename }}</dd>
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
                            <th class="text-right">Abierto</th>
                            <th class="text-right">Suspendido</th>
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
                                <td class="text-right border-left"></td>
                                <td class="text-right"></td>
                                <td class="text-right"></td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th class="text-right" colspan="5">TOTAL: </th>
                            <td class="text-right">{{ $row->currency->prefix }} {{ number_format($row->amountgrand,2) }}</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

         
        
        <div class="row">
            <div class="col-md-6">
                <h5><strong>Documentos Vinculados</strong></h5>
            </div>
            <div class="col-md-6">
                <h5><strong>Documentos Almacen</strong></h5>
                <table cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                    @foreach ($input as $item)
                        <tr>
                            <td class="align-top">{{ $item->datetrx }}:<strong>{{ $item->serial }}-{{ $item->documentno }}</strong></td>
                            <td>&nbsp;&nbsp;</td>
                            <td>
                                @if($item->lines)
                                <table cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                                    @foreach($item->lines as $line)
                                    <tr>
                                        <td>{{ $line->product->productcode }}&nbsp;</td>
                                        <td>{{ $line->product->productname }}&nbsp;</td>
                                        <td class="text-right">{{ $line->quantity }}</td>
                                    </tr>
                                    @endforeach
                                </table>
                                @endif
                            </td>
                        </tr>                
                    @endforeach
                </table>
            </div>
        </div>
        

         
    </div>


<!-- Modal -->
<div class="modal fade" id="ModalCreateInput" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('porder_copy_to_input') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="order_id" value="{{ $row->id }}">
                <input type="hidden" name="token" value="{{ $row->token }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Parte INGRESO</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light">
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label class="mb-0">Serie</label>
                            <select name="sequence_id" id="" class="form-control" required>
                                <option value="" selected disabled>-- SELECCIONE --</option>
                                @foreach ($sequence_input as $item)
                                    <option value="{{ $item->id }}">{{ $item->serial }} - {{ $item->doctype->doctypename }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0">Almacen Ingreso</label>
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

{{-- FACTURA DE COMPRA  --}}
<div class="modal fade" id="ModalCreateInvoice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <form action="{{ route('porder_copy_to_invoice') }}" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <input type="hidden" name="order_id" value="{{ $row->id }}">
                <input type="hidden" name="token" value="{{ $row->token }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Registrar Factura de Proveedor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body bg-light pt-0">
                    <div class="row">
                        <div class="col-12 col-md-4 mt-2">
                            <label class="mb-0">Tipo Documento</label>
                            <select name="sequence_id" id="" class="form-control" required>
                                <option value="" selected disabled>-- SELECCIONE --</option>
                                @foreach ($doctype as $item)
                                    <option value="{{ $item->id }}">{{ $item->doctypename }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-4 col-md-3 mt-2">
                            <label class="mb-0">Serie</label>
                            <input type="text" name="serial" class="form-control" maxlength="" required>
                        </div>
            
                        <div class="col-8 col-md-5 mt-2">
                            <label class="mb-0">Numero</label>
                            <input type="text" name="serial" class="form-control" maxlength="" required>
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
<script>
$(function(){
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
});
</script>
@endsection

