@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endsection

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="far fa-file-alt fa-fw"></i> Reporte de Movimiento</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Sistema</li>
                    <li class="breadcrumb-item">Almacenes</li>
                </ol>
            </div>
        </div>
    </div>
</section>

    <section class="content-header pt-1 pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('bpartner_rpt_move') }}" title="Recargar">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Actualizar</span>
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

<div class="bd-callout bd-callout-info bg-white mt-0">
    <h4>Reporte de Movimientos</h4>
    Este proceso hace la consulta por Socio de Negocio ordenados en orden cronologico por fechas, y arrastra el saldo acumulado.
    <br>Esta funcionalidad aplica por independiente a <strong>clientes / proveedore</strong>
</div>

<div class="card">
    <form action="{{ route('bpartner_rpt_move_form') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <label class="mb-0">Socio de Negocio</label>
                    <select name="bpartner_id" class="form-control select2-bpartner" required></select>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Inicio</label>
                    <input type="date" class="form-control" name="dateinit" value="{{ date("Y-m-d") }}">
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Final</label>
                    <input type="date" class="form-control" name="dateend" value="{{ date("Y-m-d") }}">
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="float-right">
                <a href="#" class="btn btn-default"><i class="fas fa-times fa-fw"></i> Cancelar</a>        
                <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-fw"></i> Buscar</button>
            </div>
        </div>
    </form>
</div>
    



    {{-- MODALES --}}
    <div class="modal fade" id="ModalCreate"role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('bpartner_rpt_move_form') }}" method="POST" id="form-payment">
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
                            <div class="col-md-12">
                                <label class="mb-0">Socio de Negocio</label>
                                <select name="bpartner_id" class="form-control select2-bpartner" required></select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="mb-0">Rango de Fecha</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                                    </div>
                                    <input type="text" name="dateinit" value="" class="form-control float-right"
                                        id="dateinit" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Cuenta Banco / Caja</label>
                                <select class="form-control" name="bankaccount_id">
                                    <option value="" disabled selected>-- TODAS LAS CUENTAS --</option>
                                </select>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer bg-light">
                        <button type="reset" class="btn btn-default"><i class="far fa-window-restore fa-fw"></i>
                            Limpiar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i
                                class="fas fa-times fa-fw"></i> Cancelar</button>
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
        $(function() {

            // SocioNegocio ----------------------------------------------------------------
            $('.select2-bpartner').select2({
                ajax: {
                    url: '{{ route('api.bpartner') }}',
                    type: 'post',
                    dataType: 'json',
                    delay: 150,
                    data: function(params) {
                        return {
                            q: params.term, // search term
                            page: params.page
                        };
                    },
                    cache: true
                },
                minimumInputLength: 2,
                theme: 'bootstrap4'
            });

            $('#dateinit').daterangepicker({
                timePicker: false,
                timePickerIncrement: 30,
                locale: {
                    format: 'DD/MM/YYYY'
                },
                ranges: {
                    'Hoy': [moment(), moment()],
                    'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Ultimos 7 Dias': [moment().subtract(6, 'days'), moment()],
                    'Ultimos 30 Dias': [moment().subtract(29, 'days'), moment()],
                    'Ese mes': [moment().startOf('month'), moment().endOf('month')],
                    'Ultimo mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')]
                },
                startDate: moment('{{ $op_dateinit }}'),
                endDate: moment('{{ $op_dateend }}'),
            });
        });
    </script>
@endsection
