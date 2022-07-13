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
                <h1><i class="fas fa-print fa-fw"></i> Kardex de Productos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Logistica</li>
                    <li class="breadcrumb-item">Kardex de Productos</li>
                </ol>
            </div>
        </div>
    </div>
</section>

    <section class="content-header p-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('lkardex.index') }}" title="Recargar">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
 

                </div>
                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Logistica / Kardex
                            &nbsp;
                            <i class="fas fa-warehouse fa-fw"></i>

                        </h1>
                    </div>
                </div>
            </div> 
        </div>
    </section>
@endsection

@section('container')
<form action="{{ route('lkardex.form') }}" method="POST">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
    <div class="card">
        <div class="card-header">Criterio de busqueda</div>
        <div class="card-body">
            <div class="row">

                <div class="col-6 col-md-3 mt-2">
                    <label class="mb-0">Inicio</label>
                    <input type="date" name="dateinit" class="form-control" value="{{ date("Y-m-d") }}">
                </div>
                <div class="col-6 col-md-3 mt-2">
                    <label class="mb-0">Final</label>
                    <input type="date" name="dateend" class="form-control" value="{{ date("Y-m-d") }}">
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 mt-2">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="customCheckbox1" value="option1">
                        <label for="customCheckbox1" class="custom-control-label" style="padding-top:3px;"> Almacene(s)</label>
                    </div>                 
                    <select class="form-control select2-warehouse" name="warehouse[]" multiple="multiple">
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-md-12 mt-2">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" id="customCheckbox2" value="option1">
                        <label for="customCheckbox2" class="custom-control-label" style="padding-top:3px;"> Producto(s)</label>
                    </div>                 
                    <select class="form-control select2-product" name="product[]" multiple="multiple">
                    </select>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">CONSULTAR</button>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-12">

            <div class="bd-callout bd-callout-info bg-white">
                <h4>Criterio</h4>
                En los campos de Almacenes/Productos si no selecciona un o los elementos, considerara todos los elementos
                <br><strong>Tener en cuenta que al seleccionar todos los elementos, pueda ser que demore un poco mas de previsto.</strong>
            </div>
        </div>
    </div>

</form>
@endsection

@section('script')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script>
$(function(){
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
        minimumInputLength: 2,
        theme:'bootstrap4'
    });
    $('.select2-product').select2({
        ajax: {
            url: '{{ route('api.product') }}',
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