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
                <h1><i class="fas fa-cash-register fa-fw"></i> Comprobantes de Ventas</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Ventas</li>
                    <li class="breadcrumb-item">Comprobantes de Ventas</li>
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
                    <form action="{{ route('cinvoice.index') }}" method="GET">
                        @csrf
                        <div class="input-group input-group-sm">
                            <input class="form-control" type="text" name="q" value="" autocomplete="off" placeholder="Nro Orden Venta" style="max-width: 130px;">
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                    <span class="d-none d-sm-inline-block">Buscar</span>
                                </button>
                            </span>
                        </div>
                    </form>
                </div>
                
                <a href="#" class="btn btn-secondary btn-sm" onclick="$('.filtro').toggle();">
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
                            <a class="dropdown-item" href="{{ route('corder_download_open_amount') }}"><i class="fas fa-download fa-fw"></i> Descargar XLS - OV Importes (Abiertos/Pendientes)</a>
                            <a class="dropdown-item" href="{{ route('corder_download_open_quantity') }}"><i class="fas fa-download fa-fw"></i> Descargar XLS - Cantidades (Abiertos/Pendientes)</a>
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
                            <span class="d-none d-sm-inline-block">Nueva CPE</span>
                        </a>
                    </div>
                                        
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('container')
    <div class="card mb-0">
        <div class="card-header filtro" style="display:none;"></div>
        
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th class="d-none d-sm-inline-block">Periodo</th>
                        <th>Numero</th>
                        <th class="d-none d-sm-table-cell">Codigo</th>
                        <th class="d-none d-sm-table-cell">Socio de Negocio</th>
                        <th class="d-none d-sm-inline-block">Almacen</th>
                        <th class="text-right">Importe</th>
                        <th class="text-right">Abierto</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr>
                            <td width="100">{{ $item->dateinvoiced }}</td>
                            <td width="60" class="d-none d-sm-inline-block" >{{ $item->period }}</td>
                            <td width="110">
                                <a href="{{ route('cinvoice.show',$item->token) }}">
                                    {{ $item->serial }}-{{ $item->documentno }}
                                </a>
                            </td>
                            <td class="d-none d-sm-table-cell">{{ $item->bpartner->bpartnercode }}</td>
                            <td class="d-none d-sm-table-cell">{{ $item->bpartner->bpartnername }}</td>
                            <td class="d-none d-sm-inline-block">{{ $item->warehouse->shortname }}</td>
                            <td class="text-right">
                                {{ number_format($item->amountgrand,env('DECIMAL_AMOUNT',2)) }}
                                <small>{{ $item->currency->currencyiso }}</small>
                            </td>
                            <td class="text-right">
                                {{ number_format($item->amountopen,env('DECIMAL_AMOUNT',2)) }}
                            </td>
                            <td class="text-right">
                                <a href="{{ route('cinvoice.show',$item->token) }}"><i class="far fa-file-alt fa-fw"></i> Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 pt-2 pb-2">
            {{ $result->links('layouts.paginate') }}
        </div>
    </div>
    {{-- MODALES --}}
    <!-- NUEVO -->
    <div class="modal fade" id="ModalCreate" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('cinvoice.store') }}" method="POST" id="form-logistic-input">
                @csrf
                <input type="hidden" name="mode" value="temp">
                <div class="modal-content">
                    <div class="modal-header pt-2 pb-2">
                        <h5 class="modal-title" id="exampleModalLabel">Nuevo Comprobante de Venta</h5>
                        
                    </div>
                    <div class="modal-body" style="background-color:#dcdcdc74;">
                        <div class="row">
                            <div class="col-md-8">
                                <label class="mb-0">Cliente</label>
                                <select name="bpartner_id" class="form-control select2-bpartner" required></select>
                            </div>                           
                            <div class="col-md-4">
                                <label class="mb-0">Almacen (Referencia)</label>
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
                                            @foreach ($sequence as $item)
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
                                    <option value="" selected disabled>---</option>
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
                                    <option value="" selected disabled>----</option>
                                    <option value="C">CONTADO</option>
                                    <option value="R">CREDITO</option>
                                </select>
                            </div>  
                            <div class="col-md-4 col-6 mt-2">
                                <label class="mb-0">Emision</label>
                                <input type="date" name="dateinvoiced" value="{{ date("Y-m-d") }}" class="form-control" required>
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
@endsection

@section('script')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script>
$(function(){
    // PaymentModal
    let fai = $('#form-logistic-input');
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
