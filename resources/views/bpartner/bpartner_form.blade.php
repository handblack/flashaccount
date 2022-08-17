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
                    <h1><i class="far fa-address-card fa-fw"></i> Ficha</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item">Socio de Negocio</li>
                        <li class="breadcrumb-item">Maestro</li>
                        <li class="breadcrumb-item">Ficha</li>
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
                        <a class="btn btn-sm btn-secondary" href="{{ route('bpartner.index') }}" title="Recargar">
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
    <form class="form-horizontal" action="{{ $url }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <input type="hidden" name="_method" value="{{ $mode == 'edit' ? 'PUT' : '' }}">
        <input type="hidden" name="token" value="{{ $row->token }}">
        <div class="card">
            <div class="card-header">
                <div class="card-title">
                    <ul class="nav nav-tabs card-header-tabs">
                        <li class="nav-item">
                            <span class="nav-link active">
                                <i class="far fa-address-card fa-fw"></i>
                                <span class="d-none d-sm-inline-block">
                                    Socio de Negocio <!-- [<strong>{{ $mode == 'new' ? 'NUEVO' : 'MODIFICANDO' }}]</strong> -->
                                </span>
                            </span>
                        </li>
                        @if ($mode == 'edit')
                            <li class="nav-item">
                                <span class="nav-link">
                                    <a href="{{ route('bpartneraddress.index') }}">
                                        <i class="fas fa-map-marked fa-fw"></i>
                                        <span class="d-none d-sm-inline-block">
                                            Direcciones
                                        </span>
                                    </a>
                                </span>
                            </li>
                            <li class="nav-item">
                                <span class="nav-link">
                                    <a href="{{ route('bpartnercontact.index') }}">
                                        <i class="far fa-address-book fa-fw"></i>
                                        <span class="d-none d-sm-inline-block">
                                            Contactos
                                        </span>
                                    </a>
                                </span>
                            </li>
                        @endif
                    </ul>
                </div>
                <div class="card-tools">
                    <ul class="nav">
                        <li>
                            <div class="card-tools pull-right">

                                <a href="#" class="btn btn-outline-dark btn-sm" data-toggle="modal"
                                    data-target="#ModalApiSunat">
                                    <i class="fab fa-searchengin fa-fw"></i>
                                    &nbsp;<strong>SUNAT</strong>
                                </a>
                                <a href="#" class="btn btn-outline-dark btn-sm" data-toggle="modal"
                                    data-target="#ModalApiReniec">
                                    <i class="fab fa-searchengin fa-fw"></i>
                                    &nbsp;<strong>RENIEC</strong>
                                </a>

                            </div>
                        </li>
                    </ul>

                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3 mt-2">
                        <label class="mb-0">Tipo de Registro</label>
                        <div class="input-group mb-0">
                            <select name="typeperson" id="typeperson" class="form-control console" required=""
                                style="width:80px;" {{ $mode == 'edit' ? 'disabled' : '' }}>
                                @if ($mode == 'new')
                                    <option value="" selected="" disabled="">----</option>
                                @endif
                                <option value="C" {{ $row->typeperson == 'C' ? 'selected' : '' }}>CLIENTE</option>
                                <option value="P" {{ $row->typeperson == 'P' ? 'selected' : '' }}>PROVEEDOR</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label class="mb-0">Tipo de Persona</label>
                        <div class="input-group mb-0">
                            <select name="legalperson" id="legalperson" class="form-control console" required=""
                                style="width:80px;">
                                @if ($mode == 'new')
                                    <option value="" selected="" disabled="">----</option>
                                @endif
                                <option value="J" {{ $row->legalperson == 'J' ? 'selected' : '' }}>PERSONA JURIDICA
                                </option>
                                <option value="N" {{ $row->legalperson == 'N' ? 'selected' : '' }}>PERSONA NATURAL
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3 mt-2">
                        <label class="mb-0">Tipo y Nro de Doc @if ($mode == 'new')
                                <small class="badge badge-secondary"><i class="far fa-clock"></i> <span
                                        class="font-weight-normal" id="contador">0</span></small>
                            @endif </label>
                        <div class="input-group mb-0">
                            <div class="input-group-prepend pr-1">
                                <select name="doctype_id" id="doctypeid" class="form-control console" required=""
                                    style="width:80px;">
                                    @if ($mode == 'new')
                                        <option value="" selected="" disabled="">----</option>
                                    @endif
                                    @foreach ($doctype as $item)
                                        <option value="{{ $item->id }}"
                                            {{ $item->id == $row->doctype_id ? 'selected' : '' }}>{{ $item->shortname }}
                                            - {{ $item->doctypename }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" name="documentno" id="documentno" value="{{ $row->documentno }}"
                                class="form-control console" placeholder="" aria-describedby="basic-addon1"
                                maxlength="11" required>
                        </div>

                    </div>
                    <div class="col-md-3 pt-2">
                        <label class="mb-0">Codigo SN</label>
                        @if ($mode == 'new')
                            <input type="text" name="bpartnercode" id="bpartnercode" class="form-control"
                                value="{{ $row->bpartnercode }}" placeholder="Codigo" maxlength="12" minlength="12"
                                {{ $mode == 'edit' ? 'disabled' : '' }}>
                        @else
                            <span class="form-control"
                                style="background-color: #e9ecef;opacity: 1;">{{ $row->bpartnercode }}</span>
                        @endif
                    </div>
                </div>
                <div class="row" id="jur">
                    <div class="col-md-12 pt-2">
                        <label class="mb-0">Razon Social / Denominacion</label>
                        <input type="text" name="bpartnername" id="bpartnername" class="form-control"
                            value="{{ $row->bpartnername }}" placeholder="Descripcion" maxlength="150">
                    </div>
                </div>
                <div class="row" id="nat">
                    <div class="col-md-4 pt-2">
                        <label class="mb-0">Apellido Parterno</label>
                        <input type="text" name="lastname" class="form-control" value="{{ $row->lastname }}"
                            placeholder="" maxlength="60">
                    </div>
                    <div class="col-md-4 pt-2">
                        <label class="mb-0">Apellido Materno</label>
                        <input type="text" name="firstname" class="form-control" value="{{ $row->firstname }}"
                            placeholder="" maxlength="60">
                    </div>
                    <div class="col-md-4 pt-2">
                        <label class="mb-0">Pre-Nombres</label>
                        <input type="text" name="prename" class="form-control" value="{{ $row->prename }}"
                            placeholder="" maxlength="60">
                    </div>
                </div>
                <!-- Parametros -->
                <legend  class="text-info mt-3 mb-0"><i class="fas fa-cogs fa-fw"></i> Ventas - Emision de CPE</legend>
                <div class="row">
                    <div class="col-md-6">
                        <label class="mb-0">Lista de Precios</label>
                        <select class="form-control" name="pricelist_id" required>
                            @if($mode=='new')
                                <option value="">-- SELECCIONE --</option>
                            @endif
                            @foreach ($pl as $item)
                                <option value="{{ $item->id }}" {{ ($item->id == $row->pricelist_id) ? 'selected' : '' }}>{{ $item->pricelistname }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="mb-0">Comprobante a emitir</label>
                        <select class="form-control" name="sales_doctype_id" required>
                            @if($mode=='new')
                                <option value="">-- SELECCIONE --</option>
                            @endif
                            @foreach ($cp as $item)
                                <option value="{{ $item->id }}" {{ ($item->id == $row->sales_doctype_id) ? 'selected' : '' }}>{{ $item->doctypename }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="mb-0">Afectacion PU</label>
                        <select class="form-control" name="istaxpriceunit" required> 
                            <option value="Y" {{ ($row->istaxpriceunit == 'Y') ? 'selected' : '' }}>Precio Unitario CON IGV</option>
                            <option value="N" {{ ($row->istaxpriceunit == 'N') ? 'selected' : '' }}>Precio Unitario SIN IGV</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mt-2">
                        <label class="mb-0">Envio de FEX</label>
                        <select class="form-control select2-email" name="fex_email[]" multiple="multiple">
                            @foreach ($row->contacts as $contact )
                                @foreach ($contact->email as $email)
                                    @if($row->contacs)
                                        <option value="{{ $email }}" {{ (in_array($email,$row->fex_email) ? 'selected' : '' ) }}>{{ $email }}</option>
                                    @endif
                                @endforeach
                            @endforeach                           
                        </select>
                    </div>
                </div>


                @if ($mode == 'new')
                    <legend  class="text-info mt-3 mb-0"><i class="fas fa-map-marked-alt fa-fw"></i> Direccion (Fiscal y Entrega)</legend>
                    <input type="hidden" name="ubigeo" id="ubigeo" value="">
                    <div class="row">
                        <div class="col-md-12 mt-2">
                            <label class="mb-0">Direccion</label>
                            <div class="input-group mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-map-marked-alt fa-fw"></i>
                                    </span>
                                </div>
                                <input type="text" name="address" id="address" class="form-control" placeholder="Direccion Fiscal" aria-label="Direccion" aria-describedby="basic-addon1" maxlength="200">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-9 mt-2">
                            <label class="mb-0">Referencia</label>                            
                            <div class="input-group mb-0">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">
                                        <i class="fas fa-map-signs fa-fw"></i>
                                    </span>
                                </div>
                                <input type="text" name="reference" id="reference" placeholder="Referencia" class="form-control" maxlength="100">
                            </div>
                        </div>
                        <div class="col-md-3 mt-2">
                            <label class="mb-0">
                                <a href="http://codigopostal.gob.pe/pages/invitado/consulta.jsf" target="_blank">
                                Codigo Postal
                                <i class="fas fa-external-link-alt fa-fw"></i>
                                </a>
                            </label>
                            <input type="text" name="firstname" class="form-control" value="{{ $row->firstname }}"
                                placeholder="" maxlength="60">
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
                @else
                    <legend  class="text-info mt-3 mb-0"><i class="fas fa-map-marked-alt fa-fw"></i> Direccion Fiscal</legend>
                    <div class="row">
                        <div class="col-md-6 mt-2">
                            <label class="mb-0">Direccion Fiscal</label>
                            <div class="input-group">
                                <div class="input-group-prepend d-flex d-sm-none d-xl-flex">
                                    <span class="input-group-text">
                                        <i class="fas fa-map-marker-alt fa-fw"></i>
                                    </span>
                                </div>
                                <select name="address_fiscal_id" class="form-control" required>
                                    <option value="">-- SELECCIONA --</option>
                                    @foreach($row->addresses as $item)
                                        <option value="{{ $item->id }}" {{ ($item->id == $row->address_fiscal_id) ? 'selected' : '' }}>{{ $item->address }} - {{ $item->city->cityname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mt-2">
                            <label class="mb-0">Direccion Entrega</label>
                            <div class="input-group">
                                <div class="input-group-prepend d-flex d-sm-none d-xl-flex">
                                    <span class="input-group-text">
                                        <i class="fas fa-truck fa-fw"></i>
                                    </span>
                                </div>
                                <select name="address_delivery_id" class="form-control" required>
                                    <option value="">-- SELECCIONA --</option>
                                    @foreach($row->addresses as $item)
                                        <option value="{{ $item->id }}" {{ ($item->id == $row->address_delivery_id) ? 'selected' : ''  }}>{{ $item->address }} - {{ $item->city->cityname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <div class="card-footer pt-1">
                <div class="row">
                    <div class="col-md-6  mt-2">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="basic-addon1">Estado</span>
                            </div>
                            <select name="isactive" id="isactive" class="form-control">
                                <option value="Y" @if ($row->isactive == 'Y') selected @endif>ACTIVO</option>
                                <option value="N" @if ($row->isactive == 'N') selected @endif>DESACTIVADO
                                </option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6 mt-2">
                        <div class="float-right">
                            <a href="{{ route('bpartner.index') }}" class="btn btn-secondary"> <i
                                    class="fas fa-times"></i> Cancelar</a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i>
                                {{ $mode == 'new' ? 'Crear' : 'Modificar' }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- ------------------------------------------------
        MODAL
    -->
    <!-- SUNAT -->
    <div class="modal fade rounded-2" id="ModalApiSunat" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document" style="max-width: 400px">
            <div class="modal-content" id="api-ruc-modal-content">
                <div class="modal-body bg-light">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-0">
                                <div class="input-group-prepend mr-1">
                                    <select name="" id="xxtp" class="form-control console ">
                                        <option value="C">CLIENTE</option>
                                        <option value="P">PROVEEDOR</option>
                                    </select>
                                </div>
                                <input type="text" class="form-control api_sunat_ruc console" placeholder="RUC"
                                    aria-label="" aria-describedby="basic-addon2" maxlength="11">
                                <div class="input-group-append">
                                    <a href="#" class="btn btn-primary api_sunat_ruc_submit">
                                        <i class="fas fa-search fa-fw"></i>
                                        Sunat
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- RENIEC -->
    <div class="modal fade rounded-2" id="ModalApiReniec" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered " role="document" style="max-width: 400px">
            <div class="modal-content" id="api-ruc-modal-content">
                <div class="modal-body bg-light">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="input-group mb-0">
                                <div class="input-group-prepend mr-1">
                                    <select name="" id="xxtp" class="form-control console ">
                                        <option value="C">CLIENTE</option>
                                        <option value="P">PROVEEDOR</option>
                                    </select>
                                </div>
                                <input type="text" class="form-control api_sunat_ruc console" placeholder="DNI"
                                    aria-label="" aria-describedby="basic-addon2" maxlength="8">
                                <div class="input-group-append">
                                    <a href="#" class="btn btn-primary api_sunat_ruc_submit">
                                        <i class="fas fa-search fa-fw"></i>
                                        Reniec
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-number/jquery.number.min.js') }}"></script>
<script>
    $(function() {
        $("#documentno").on('keyup', function(event) {
            var currentString = $("#documentno").val()
            $('#contador').html(currentString.length);
            let code = '000000000000' + $("#documentno").val();
            @if ($mode == 'new')
                $('#bpartnercode').val($('#typeperson').val() + code.substr(code.length - 11));
            @endif
        });
        $('#legalperson').on('change', function() {
            let lp = $('#legalperson').val()
            if (lp == 'J') {
                $('#jur').show();
                $('#nat').hide();
            } else {
                $('#jur').hide();
                $('#nat').show();
            }
        });

        $('#typeperson').change(function() {
            $('#documentno').trigger("keyup");
        });

        $('#legalperson').trigger("change");

        $('.api_sunat_ruc_submit').click(function() {
            let lRUC = $('.api_sunat_ruc').val();
            if (lRUC.trim() == '') {
                toastr.error('Debes ingresar el nro de RUC')
            } else {
                $('.api_sunat_ruc').prop("disabled", true);
                $('.api_sunat_ruc_submit').prop("disabled", true);
                $('#api-ruc-modal-content').append(
                    '<div class="overlay"><i class="fas fa-2x fa-sync fa-spin"></i></div>');
                $.getJSON('{{ route('bpartner_api_sunat') }}', {
                        ruc: lRUC
                    })
                    .done(function(data) {
                        if (data.status == 100) {
                            toastr.success('RUC Correcto');
                            $('#bpartnername').val(data.ficha.n1_alias);
                            $('#typeperson').val($('#xxtp').val());
                            $('#legalperson').val('J');
                            $('#doctypeid').val(1);
                            $('#documentno').val(data.ficha.n1_ruc);
                            //$('#ubigeo').val(data.ficha.n2_ubigeo);
                            $('#address').val(data.ficha.n1_direccion);
                            // trigger -------------------------
                            $('#legalperson').trigger('change');
                            $('#documentno').trigger('keyup');
                            $('#ModalApiSunat').modal('toggle');
                            console.log(data.ficha);
                        } else {
                            toastr.error(data.message);
                        }
                        $(".overlay").remove();
                    })
                    .fail(function() {
                        $(".overlay").remove();
                        toastr.error('Se genero un error al hacer la consulta, intente nuevamente');
                        console.log('fail');
                    });
                $('.api_sunat_ruc').prop("disabled", false);
                $('.api_sunat_ruc_submit').prop("disabled", false);
            }
        });

        $('.select2-email').select2();

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
