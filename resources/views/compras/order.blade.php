@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('breadcrumb')
<section class="content-header pb-1">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit fa-fw"></i> Ordenes de Compras</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Ventas</li>
                    <li class="breadcrumb-item">Ordenes de Compra</li>
                </ol>
            </div>
        </div>
    </div>
</section>

<section class="content-header pt-1 pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-8 col-sm-6">

                <div class="btn-group">
                    <a class="btn btn-sm btn-secondary" href="#" onclick="location.reload();" title="Recargar">
                        <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Actualizar</span>
                    </a>
                </div>

                <div class="btn-group" width="50">
                    <div class="input-group input-group-sm">
                        <input class="form-control" type="text" name="query" value="" autocomplete="off" placeholder="Nro Orden Venta" style="max-width: 100px;">
                        <span class="input-group-append">
                            <button type="submit" class="btn btn-secondary">
                                <i class="fas fa-search" aria-hidden="true"></i>
                                <span class="d-none d-sm-inline-block">Buscar</span>
                            </button>
                        </span>
                    </div>
                </div>

                <a href="#" class="btn btn-secondary btn-sm">
                    <i class="fas fa-filter fa-fw"></i>
                    <span class="d-none d-sm-inline-block">Filtrar</span>
                </a>

                <div class="btn-group">
                    <div class="btn-group">
                        <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"> 
                            <i class="fas fa-th-large fa-fw"></i>
                              Accion 
                            <span class="sr-only">Toggle Dropdown</span>
                        </button>
                        <div class="dropdown-menu" role="menu">
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('porder_download_open_amount') }}"><i class="fas fa-download fa-fw"></i> OC - Importes (Abiertos/Pendientes)</a>
                            <a class="dropdown-item" href="{{ route('porder_download_open_quantity') }}"><i class="fas fa-download fa-fw"></i> OC - Cantidades (Abiertos/Pendientes)</a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="col-4 col-md-6">
                <div class="float-right">

                    

                    <div class="btn-group">
                        <a class="btn btn-sm btn-success" href="#" data-toggle="modal" data-target="#ModalCreate"
                        title="Marcar como página de inicio">
                            <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Nueva Orden</span>
                        </a>
                    </div>
                                        
                </div>
            </div>

        </div>
    </div>
</section>
     
@endsection

@section('container')
    <div class="card">
        <form action="">
            <div class="card-header pt-2 pb-2">
            </div>
        </form>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Numero</th>
                        <th class="d-none d-sm-table-cell">CodigoSN</th>
                        <th class="d-none d-sm-table-cell">Socio de Negocio</th>
                        <th class="text-right pr-2">Importe</th>
                        <th class="d-none d-sm-table-cell">Almacen</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr>
                            <td class="{{ ($item->docstatus == 'C') ? 'tachado2' : '' }}" width="110">{{ $item->dateorder }}</td>
                            <td class="{{ ($item->docstatus == 'C') ? 'tachado2' : '' }}">
                                <a href="{{ route('porder.show',$item->token) }}">
                                    {{ $item->serial }}-{{ $item->documentno }} 
                                </a>
                                 
                            </td>
                            <td class="d-none d-sm-table-cell" width="115">{{ $item->bpartner->bpartnercode }}</td>
                            <td class="d-none d-sm-table-cell" width="110">{{ $item->bpartner->bpartnername }}</td>
                            <td class="text-right pr-2 border-left border-right">
                                {{ number_format($item->amountgrand, 2) }} {{ $item->currency->currencyiso }}
                            </td>
                            <td class="d-none d-sm-table-cell">{{ $item->warehouse->shortname }}</td>

                            <td class="text-right">
                                @if($grant->isedit == 'Y')
                                    <a href="{{ route('porder.edit', [$item->token]) }}"> 
                                        <i class="fas fa-edit"></i>
                                        <span class="d-none d-sm-inline-block">Modificar</span>
                                    </a>
                                @else
                                    <i class="fas fa-trash-alt fa-fw"></i>
                                @endif
                                |
                                @if($grant->isdelete == 'Y')
                                    <a class="delete-record" 
                                        data-url="{{ route('porder.destroy', $item->token) }}"
                                        data-id="{{ $item->id }}">
                                        <i class="fas fa-trash-alt fa-fw"></i>
                                    </a>
                                @else
                                    <i class="fas fa-trash-alt fa-fw"></i>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay Orden de Compra</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 pt-2">
            {{ $result->links('layouts.paginate') }}
        </div>
    </div>

    {{-- MODALES --}}
    <!-- NUEVO -->
    <div class="modal fade" id="ModalCreate" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('porder.store') }}" method="POST" id="form-create">
                @csrf
                <input type="hidden" name="mode" value="temp">
                <div class="modal-content">
                    <div class="modal-header pt-2 pb-2">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo Orden de Compra</h5>
                    </div>
                    <div class="modal-body pt-0" style="background-color:#dcdcdc74;">
                        <div class="row">
                            <div class="col-md-8 mt-2">
                                <label class="mb-0">Proveedor</label>
                                <select name="bpartner_id" class="form-control select2-bpartner" required></select>
                            </div>                           
                            <div class="col-md-4 mt-2">
                                <label class="mb-0">Almacen Ingreso</label>
                                <select name="warehouse_id" class="form-control console" required>
                                    <option value="" selected disabled>-- SELECCION --</option>
                                    @foreach (auth()->user()->warehouse() as $item)
                                        <option value="{{ $item->id }}">{{ $item->warehousename }}</option>
                                    @endforeach
                                </select>
                            </div>                           
                        </div>
                        <div class="row">                                                    
                            <div class="col-md-4 mt-2">
                                <label class="mb-0">Serie</label>
                                <div class="input-group">
                                    <div class="input-group-prepend pr-1">
                                        <select name="sequence_id" class="form-control console" required style="width:80px;">
                                            <option value="" selected disabled>----</option>
                                            @foreach (auth()->user()->sequence('OCO') as $item)
                                                <option value="{{ $item->id }}">{{ $item->serial .'-'.$item->doctype->doctypename }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" class="form-control console" placeholder="<automatico>" aria-describedby="basic-addon1">
                                </div>
                            </div>                           
                               

                            <div class="col-8 col-md-4 mt-2">
                                <label class="mb-0">Moneda</label>
                                <select name="currency_id" class="form-control console" required>
                                    @foreach (auth()->user()->currency() as $item)
                                        <option value="{{ $item->id }}">{{ $item->currencyiso }} - {{ $item->currencyname }}</option>
                                    @endforeach
                                </select>
                            </div>                           
                            <div class="col-4 col-md-3 mt-2">
                                <label class="mb-0">Tipo Cambio</label>
                                <input type="text" name="rate" class="form-control text-right console" value="1.000" maxlength="5">
                            </div>                           
                        </div>
                        <div class="row">
                            <div class="col-md-4 mt-2">
                                <label class="mb-0">Tipo de Pago</label>
                                <select name="typepayment" class="form-control console" required>
                                    <option value="C">CONTADO</option>
                                    <option value="R">CREDITO</option>
                                </select>
                            </div>  
                            <div class="col-md-4 col-6 mt-2">
                                <label class="mb-0">Emision</label>
                                <input type="date" name="dateorder" value="{{ date("Y-m-d") }}" class="form-control" required>
                            </div>  
                            <div class="col-md-4 col-6 mt-2">
                                <label class="mb-0">Vencimiento</label>
                                <input type="date" name="datedue" value="{{ date("Y-m-d") }}" class="form-control">
                            </div>  
                        </div>
                    </div>
                    <div class="modal-footer p-1">
                        <div class="float-right">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Iniciar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- ANULAR -->
    <div class="modal fade" id="ModalCancelDocument" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anular Orden de Compra</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="lead">Estas seguro en Anular la Orden de Venta?</p>
                    <p>Este proceso libera stock retenido del sistema.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Anular</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script>
$(function(){
    // PaymentModal
    let fai = $('#form-create');
    fai.submit(function (e) {
        e.preventDefault();
        $.ajax({
            type:fai.attr('method'),
            url: fai.attr('action'),
            data: fai.serialize(),
            success: function(data){
                if(data.status == '100'){    
                    window.location.href = data.url;              
                }else{
                    toastr.error(data.message);
                }
            },
            error: function(data){
                console.log('error genero');
            },

        });
    });
    // SocioNegocio ----------------------------------------------------------------
    $('.select2-bpartner').select2({
        ajax: {
            url: '{{ route('api.bpartner') }}',
            type: 'post',
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                    q: params.term, // search term
                    t:'P',
                    page: params.page
                };
            },
            cache: true
        },
        minimumInputLength: 2,
        theme:'bootstrap4'
    });
});
</script>
@endsection