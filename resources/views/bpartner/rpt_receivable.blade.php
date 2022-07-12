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
                <h1><i class="fas fa-print fa-fw"></i> Cuentas por Cobrar</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Socio de Negocio</li>
                    <li class="breadcrumb-item">Cuentas por Cobrar</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">

                <div class="btn-group">
                    <a class="btn btn-sm btn-secondary" href="{{ route('bpartner_rpt_receivable') }}" title="Recargar">
                        <i class="fas fa-redo" aria-hidden="true"></i>
                    </a>
                </div>

                <div class="btn-group">
                    <form action="{{ route('bpartner_rpt_receivable_form') }}" method="POST" id="form-payment">
                        @csrf
                        <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                                <span class="input-group-text">Fecha CORTE</span>
                            </div>
                            <input type="date" name="dateend" value="{{ date("Y-m-d"); }}" class="form-control" placeholder="Recipient's username" aria-label="Recipient's username" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-play fa-fw"></i>
                                    <span class="d-none d-md-inline-block"> Ejecutar</span>
                                </button>                            
                            </div>
                        </div>
                    </form>
                </div>
                <div class="btn-group">
                    <a href="#" class="btn btn-secondary btn-sm"  data-toggle="modal" data-target="#ModalFilter">
                    <i class="fas fa-filter fa-fw"></i>
                    </a>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="float-sm-right">
                    <h1 class="h4 mb-0 d-none d-md-inline-block">
                        Reporte Cuentas por Cobrar
                        &nbsp;
                        <i class="fas fa-print fa-fw"></i>

                    </h1>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

 
@section('container')
<div class="bd-callout bd-callout-info">
    <h4>Cuentas por Cobrar</h4>
    Realiza la busqueda con documentos con saldos a la fecha de corte.
</div>
{{-- MODALES --}}
<div class="modal fade" id="ModalFilter"role="dialog" aria-labelledby="exampleModalLongTitle"
aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <form action="{{ route('bpartner_rpt_receivable_form') }}" method="POST" id="form-payment">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title" id="exampleModalLongTitle">Criterio de Busqueda</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="background-color:#dcdcdc9c;">
                    <div class="row">
                        <div class="col-md-9">
                            <label class="mb-0">Socio de Negocio</label>
                            <select name="bpartner_id" class="form-control select2-bpartner" required></select>
                        </div>
                        <div class="col-md-3">
                            <label class="mb-0">Fecha de Corte</label>
                            <input type="date" name="dateend" class="form-control" value="{{ date("Y-m-d") }}">
                        </div>
                    </div>

  
                    
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-fw"></i> Buscar</button>
            
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