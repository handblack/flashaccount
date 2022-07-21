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
                    <!--
                    <div class="btn-group">
                        <a class="btn btn-sm btn-success" href="{{ route('porder.create') }}"
                            title="Marcar como página de inicio">
                            <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Nuevo OC</span>
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
                            <th class="text-right">Recibido</th>
                            <th class="text-right">Suspend.</th>
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
                <table cellspacing="0" cellpadding="0" style="border-collapse: collapse;">
                    @foreach ($invoice as $item)
                        <tr>
                            <td>{{ $item->serial }}-{{ $item->documentno }}</td>
                        </tr>
                    @endforeach
                </table>
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
    <div class="modal-dialog modal-lg" role="document">
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
                        <div class="col-md-10 mt-2">
                            <label class="mb-0">Proveedor</label>
                            <span class="input-group-text">{{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}</span>
                        </div>
                        <div class="col-md-2 mt-2">
                            <label class="mb-0">Orden Compra</label>
                            <span class="input-group-text">{{ $row->serial }} - {{ $row->documentno }}</span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3 mt-2">
                            <label class="mb-0">Fecha</label>
                            <input type="date" name="datetrx" class="form-control" value="{{ date("Y-m-d") }}">
                        </div>
                        <div class="col-md-3 mt-2">
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
                        <div class="col-md-12 mt-2">
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
        <form action="{{ route('porder_copy_to_invoice') }}" method="POST" id="form-create">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <input type="hidden" name="order_id" value="{{ $row->id }}">
            <input type="hidden" name="token" value="{{ $row->token }}">
            <input type="hidden" name="mode" value="temp">
            <div class="modal-content">
                <div class="modal-header pt-2 pb-2">
                    <h5 class="modal-title" id="exampleModalLabel">Crear Comprobante de Gasto</h5>
              
                </div>
                <div class="modal-body pt-2" style="background-color:#dcdcdc74;">
                    <div class="row">
                        <div class="col-8 col-md-10">
                            <label class="mb-0">Socio de Negocio</label>
                            <span class="input-group-text"><span class="d-none d-lg-inline-block">{{ $row->bpartner->bpartnercode }} - </span>{{ $row->bpartner->bpartnername }}</span>

                        </div>
                        <div class="col-4 col-md-2">
                            <label class="mb-0">Orden Compra</label>
                            <input type="text" class="form-control" value="{{ $row->serial }} - {{ $row->documentno }}" disabled>
                        </div>
                        
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 mt-2">
                                    <label class="mb-0">Tipo Comprobante</label>
                                    <select name="doctype_id" class="form-control" required>
                                        <option value="" selected disabled>-- SELECCIONA --</option>
                                        @foreach ($doctype as $item)
                                            <option value="{{ $item->id }}">{{ $item->doctypename }}</option>
                                        @endforeach
                                    </select>
                                </div>
    
                                <div class="col-md-6 mt-2">
                                    <label class="mb-0">Documento</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <input type="text" name="serial" class="form-control console mr-1" style="width:65px;text-transform: uppercase;" maxlength="4" placeholder="####" aria-label="Username" aria-describedby="basic-addon1" required>
                                        </div>
                                        <input type="text" name="documentno" class="form-control console" maxlength="15" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-3 col-md-3 mt-2">
                                    <label class="mb-0">Moneda</label>
                                    <select name="currency_id" class="form-control" required>
                                        @foreach (auth()->user()->currency() as $item)
                                            <option value="{{ $item->id }}">{{ $item->currencyiso }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-5 col-md-3 mt-2">
                                    <label class="mb-0">Emision</label>
                                    <input type="date" name="dateinvoiced" value="{{ date("Y-m-d") }}" class="form-control">
                                </div>
                                <div class="col-4 col-md-3 mt-2 d-none d-sm-inline-block">
                                    <label class="mb-0">Contabilidad</label>
                                    <input type="date" name="dateacct" value="{{ date("Y-m-d") }}" class="form-control">
                                </div>
                                <div class="col-4 col-md-3 mt-2">
                                    <label class="mb-0">Tipo Cambio</label>
                                    <input type="number" name="rate" value="1.000" step="0.001" class="form-control text-right">
                                </div>
                            </div>
                            

                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-12 mt-2">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text console" id="basic-addon1">BASE&nbsp;</span>
                                        </div>
                                        <input type="text" name="amountbase" class="form-control text-right amount console" value="{{ number_format($row->amountbase,env('DECIMAL_AMOUNT',2)) }}" placeholder="0.00" aria-label="0.00" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text console" id="basic-addon1">EXO&nbsp;&nbsp;</span>
                                        </div>
                                        <input type="text" name="amountexo" class="form-control text-right amount console" value="{{ number_format($row->amountexo,env('DECIMAL_AMOUNT',2)) }}" placeholder="0.00" aria-label="0.00" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text console" id="basic-addon1">IGV&nbsp;&nbsp;</span>
                                        </div>
                                        <input type="text" name="amounttax" class="form-control text-right amount console" value="{{ number_format($row->amounttax,env('DECIMAL_AMOUNT',2)) }}" placeholder="0.00" aria-label="0.00" aria-describedby="basic-addon1">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="input-group input-group-sm">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text console" id="basic-addon1">TOTAL</span>
                                        </div>
                                        <input type="text" name="amountgrand" id="amountgrand" class="form-control text-right console font-weight-bold" value="{{ number_format($row->amountgrand,env('DECIMAL_AMOUNT',2)) }}" aria-label="0.00" aria-describedby="basic-addon1" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">                                                           
                        <div class="col-md-12 mt-2">
                            <label class="mb-0">Glosa</label>
                            <input type="text" name="glosa" class="form-control" value="FACTURA DE COMPRA">
                        </div>
                        
                    </div>
                    

                </div>
                <div class="modal-footer p-1">
                    <div class="row w-100">
                        <div class="col-md-6 mt-2">
                            
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">RETENCION</span>
                                    </div>
                                    <select name="typeproduct" id="typeproduct" class="form-control">
                                        @foreach ($retencion as $item)
                                            <option value="{{ $item->id }}">{{ $item->identity }}</option>
                                        @endforeach
                                    </select>
                                </div>                                    
                            
                        </div>
                        <div class="col-md-6 mt-2">
                            <div class="float-right">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Iniciar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>


   
@endsection

@section('script')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-number/jquery.number.min.js') }}"></script>
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
    // Sumando totales --------------------------------------------------------------
    $(".amount").change(function() {
        var total = 0;
        $( ".amount" ).each( function(){
            total += parseFloat( $( this ).val() ) || 0;
        });
        $('#amountgrand').val($.number(total,2,'.', ','));
    });
});
</script>
@endsection

