@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('breadcrumb')
<section class="content-header pb-0">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit fa-fw"></i> Asignación</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Caja y Bancos</li>
                    <li class="breadcrumb-item">Asignación</li>
                </ol>
            </div>
        </div>
    </div>
</section>
    <section class="content-header pt-1">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('ballocate.index') }}" title="Recargar">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Actualizar</span>
                        </a>
                    </div>

                    <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalCreate"
                        title="Marcar como página de inicio">
                        <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Nueva Asignacion</span>
                    </a>
                    <div class="btn-group">
                        <div class="input-group input-group-sm">
                            <input class="form-control" type="text" name="query" value="" autocomplete="off"
                                placeholder="Buscar">
                            <span class="input-group-append">
                                <button type="submit" class="btn btn-secondary">
                                    <i class="fas fa-search" aria-hidden="true"></i>
                                </button>
                            </span>
                        </div>
                    </div>

                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Bancos / Aplicacion de Saldos
                            &nbsp;
                            <i class="fas fa-random fa-fw"></i>

                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection



@section('container')
    <div class="card">
        <div class="card-header pt-2 pb-2">
            <form action="" method="GET" style="margin:0px;padding:0px;">
                <input type="hidden" name="cia_codcia" id="cia_codcia">
                <input type="hidden" name="cco_codcco" id="cco_codcco">
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                            </div>
                            <input type="text" name="dateinit" value="" class="form-control float-right" id="reservation">
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
            </form>
        </div>
        
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-sm table-borderless">    
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Codigo</th>
                        <th class="d-none d-sm-table-cell">Cliente</th>
                        <th class="text-right">Importe</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr>
                            <td width="100">{{ $item->datetrx }}</td>
                            <td width="100">{{ $item->bpartner->bpartnercode }}</td>
                            <td class="d-none d-sm-table-cell">{{ $item->bpartner->bpartnername }}</td>
                            <td class="text-right">{{ number_format($item->amount,env('DECIMAL_AMOUNT',2)) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay informacion</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    {{-- MODALES --}}
    <div class="modal fade" id="ModalCreate"role="dialog" aria-labelledby="exampleModalLongTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('ballocate.store') }}" method="POST" id="form-payment">
                @csrf
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLongTitle">Reconciliacion de Saldos</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body pt-1" style="background-color:#dcdcdc74;">
                        <div class="row">
                            <div class="col-md-12 mt-2">
                                <label class="mb-0">Socio de Negocio</label>
                                <select name="bpartner_id" class="form-control select2-bpartner" required></select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-7 col-md-3 mt-2">
                                <label class="mb-0">Fecha TRX</label>
                                <input type="date" name="datetrx" value="{{ date("Y-m-d") }}" class="form-control" required>
                            </div>
                            <div class="col-5 col-md-3 mt-2">
                                <label class="mb-0">Tipo de Cambio</label>
                                <input type="text" name="rate" class="form-control text-right text-monospace" value="1.000" maxlength="5" required>
                            </div>
                            <div class="col-md-6 mt-2">
                                <label class="mb-0">Glosa</label>
                                <input type="text" name="glosa" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Continuar</button>
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
    let fai = $('#form-payment');
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
