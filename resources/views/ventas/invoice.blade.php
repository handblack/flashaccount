@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('cinvoice.index') }}" title="Recargar">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>

                    <a class="btn btn-sm btn-success" href="#" data-toggle="modal" data-target="#ModalCreate">
                        <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Nuevo Comprobante</span>
                    </a>
                    

                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Ventas / Comprobante
                            &nbsp;
                            <i class="fas fa-cash-register"></i>

                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>


    
@endsection

@section('container')
    <div class="card mb-0">
        <div class="card-header pt-2 pb-2">
            <div class="row">
                <div class="col-md-3">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                        <input type="text" name="dateinit" value="" class="form-control float-right" id="dateinit">
                    </div>
                </div>
                 
                
               
                <div class="col-md-4">
                    <div class="input-group input-group-sm">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-user-tie"></i></span>
                        </div>
                        <input type="text" name="op_q" value="" class="form-control" placeholder="Empresa/RUC/Codigo">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>

                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
                <thead>
                    <tr>
                        <th>PERIODO</th>
                        <th>FECHA</th>
                        <th>DOCUMENTO</th>
                        <th>SOCIO NEGOCIO</th>
                        <th>ALMACEN</th>
                        <th class="text-right">IMPORTE</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr>
                            <td width="100">{{ $item->period }}</td>
                            <td width="100">{{ $item->dateinvoiced }}</td>
                            <td width="110">{{ $item->serial }}-{{ $item->documentno }}</td>
                            <td>{{ $item->bpartner->bpartnercode .' - ' . $item->bpartner->bpartnername }}</td>
                            <td>{{ $item->warehouse->shortname }}</td>
                            <td class="text-right">
                                {{ number_format($item->amountgrand,env('DECIMAL_AMOUNT',2)) }}
                                <small>{{ $item->currency->currencyiso }}</small>
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
                        <div class="card-tools float-sm-right">
                            <div class="btn-group">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-calendar-alt fa-fw"></i> Emision
                                        </span>
                                    </div>
                                    <input type="date" name="dateinvoiced" value="{{ date("Y-m-d") }}" class="form-control" required style="width:110px;">
                                </div>
                            </div>
                            <div class="btn-group">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-calendar-day fa-fw"></i> Vence
                                        </span>
                                    </div>
                                    <input type="date" name="datedue" value="{{ date("Y-m-d") }}" class="form-control" required style="width:110px;">
                                </div>
                            </div>
                            
                        </div>
                        
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
                        <div class="row mt-2">                                                    
                            <div class="col-md-4">
                                <label class="mb-0">Serie</label>
                                <div class="input-group mb-3">
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
                            <div class="col-md-3">
                                <label class="mb-0">Tipo de Pago</label>
                                <select name="typepayment" class="form-control console" required>
                                    <option value="" selected disabled>----</option>
                                    <option value="C">CONTADO</option>
                                    <option value="R">CREDITO</option>
                                </select>
                            </div>                           
                            <div class="col-md-3">
                                <label class="mb-0">Moneda</label>
                                <select name="currency_id" class="form-control console" required>
                                    <option value="" selected disabled>---</option>
                                    @foreach (auth()->user()->currency() as $item)
                                        <option value="{{ $item->id }}">{{ $item->currencyiso }}</option>
                                    @endforeach
                                </select>
                            </div>                           
                            <div class="col-md-2">
                                <label class="mb-0">Tipo Cambio</label>
                                <input type="text" name="rate" class="form-control text-right console" value="1.000" maxlength="5">
                            </div>                           
                        </div>
                        
                    </div>
                    <div class="modal-footer p-1">
                        <div class="row w-100">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button type="reset" class="btn btn-default"><i class="fas fa-window-close fa-fw"></i> Limpiar</button>                                 
                                </div>
                            </div>
                            <div class="col-md-6">
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
