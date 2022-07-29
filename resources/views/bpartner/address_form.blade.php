@extends('layouts.app')

@section('header')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('breadcrumb')
    <section class="content-header pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">
                    <h1><i class="fas fa-map-marked fa-fw"></i> Direcciones</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Socio de Negocio</li>
                        <li class="breadcrumb-item">Maestro</li>
                        <li class="breadcrumb-item">Direcciones</li>
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
                        <a class="btn btn-sm btn-secondary" href="{{ route('bpartner.edit',[$header->token]) }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Actualizar</span>
                        </a>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Socio de Negocio
                            &nbsp;<i class="nav-icon fas fa-user-tie ml-3"></i>

                        </h1>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
 

@section('container')
<form class="" action="{{ ($mode == 'edit') ? route('bpartneraddress.update',$row->token) : route('bpartneraddress.store') }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <input type="hidden" name="_method" value="{{ ($mode == 'edit') ? 'PUT' : '' }}">
    <input type="hidden" name="master" value="{{ $row->token }}">
    <div class="card shadow">
        <div class="card-header card-header2">
            <h3 class="card-title"><i class="fas fa-map-marked-alt fa-fw"></i> Direcciones [<strong>{{ ($mode=='new') ? 'NUEVO' : 'MODIFICAR' }}</strong>]</h3>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">                    
                    <input type="text" value="{{ $header->bpartnercode }} - {{ $header->bpartnername }}" class="form-control" disabled>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-2">
                    <label class="mb-0">Direccion</label>
                    <input type="text" name="address" id="address" value="{{ old('address',$row->address) }}" class="form-control" required maxlength="200">
                </div>
                
            </div>
            <div class="row">
                <div class="col-md-9 mt-2">
                    <label class="mb-0">Referencia</label>
                    <input type="text" name="reference" id="reference" class="form-control" maxlength="100">
                </div>
                <div class="col-md-3 mt-2">
                    <label class="mb-0"><a href="http://codigopostal.gob.pe/pages/invitado/consulta.jsf" target="_blank">Codigo Postal <i class="fas fa-external-link-alt fa-fw"></i></a></label>
                    <input type="text" name="zipcode" id="zipcode" value="{{ $row->zipcode }}" class="form-control" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-3 mt-2">
                    <label class="mb-0">Pais/Country</label>
                    <select name="bpartner_country_id" class="form-control select2-country" required>
                        @if($row->bpartner_country_id)
                            <option value="{{ $row->bpartner_country_id }}">{{ $row->country->countryname }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-3 mt-2">
                    <label class="mb-0">Departamento/State</label>
                    <select name="bpartner_state_id" class="form-control select2-state" required>
                        @if($row->bpartner_state_id)
                            <option value="{{ $row->bpartner_state_id }}">{{ $row->state->statename }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-3 mt-2">
                    <label class="mb-0">Provincia/County</label>
                    <select name="bpartner_county_id" class="form-control select2-county" required>
                        @if($row->bpartner_county_id)
                            <option value="{{ $row->bpartner_county_id }}">{{ $row->county->countyname }}</option>
                        @endif
                    </select>
                </div>
                <div class="col-md-3 mt-2">
                    <label class="mb-0">Distrito/City</label>
                    <select name="bpartner_city_id" class="form-control select2-city" required>
                        @if($row->bpartner_city_id)
                            <option value="{{ $row->bpartner_city_id }}">{{ $row->city->cityname }}</option>
                        @endif
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <div class="row">
                <div class="col text-center"></div>
                <div class="col text-right">
                    <a href="{{ route('bpartneraddress.index') }}" class="btn btn-sm btn-secondary">
                        <i class="fas fa-undo fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Cancelar</span>
                    </a>
                    <button class="btn btn-sm btn-primary" type="submit">
                        <i class="fas fa-save fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Guardar</span>
                    </button>
                </div>
            </div>
        </div>

    </div>
</form>
@endsection


@section('script')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-number/jquery.number.min.js') }}"></script>
<script>
 $(function(){
    //Servicio de AJAX
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.select2-country').select2({
        ajax: {
            url: '{{ route('api.bpartnercountry') }}',
            type:'post',
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                    q: params.term, // search term
                    // id: $('.select2-country').val(),
                    page: params.page
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        theme:'bootstrap4'
    });
    $('.select2-country').on('select2:select', function (e) {
        $('.select2-state').val(null).trigger('change');
        $('.select2-county').val(null).trigger('change');
        $('.select2-city').val(null).trigger('change');
    });


    $('.select2-state').select2({
        ajax: {
            url: '{{ route('api.bpartnerstate') }}',
            type:'post',
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                    q: params.term, // search term
                    id: $('.select2-country').val(),
                    page: params.page
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        theme:'bootstrap4'
    });
    $('.select2-state').on('select2:select', function (e) {
        //$('.select2-state').val(null).trigger('change');
        $('.select2-county').val(null).trigger('change');
        $('.select2-city').val(null).trigger('change');
    });

    $('.select2-county').select2({
        ajax: {
            url: '{{ route('api.bpartnercounty') }}',
            type:'post',
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                    q: params.term, // search term
                    id: $('.select2-state').val(),
                    page: params.page
                };
            },
            cache: true
        },
        minimumInputLength: 0,
        theme:'bootstrap4'
    });
    $('.select2-county').on('select2:select', function (e) {
        //$('.select2-state').val(null).trigger('change');
        //$('.select2-county').val(null).trigger('change');
        $('.select2-city').val(null).trigger('change');
    });

    $('.select2-city').select2({
        ajax: {
            url: '{{ route('api.bpartnercity') }}',
            type:'post',
            dataType: 'json',
            delay: 150,
            data: function (params) {
                return {
                    q: params.term, // search term
                    id: $('.select2-county').val(),
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
