@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
@endsection

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('team.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-secondary" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Orden de Venta
                            &nbsp;
                            <i class="fas fa-edit fa-fw"></i>
                        </h1>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('container')
    <div class="card">
        <div class="card-header bg-light">
            <div class="row">

                <div class="col-md-8">
                    <label class="mb-0">Socio de Negocio</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Identificador del Equipo" value="{{ $row->name }}" required>
                </div>
                <div class="col-md-3">
                    <label class="mb-0">Codigo</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Identificador del Equipo" value="{{ $row->name }}" required>
                </div>
                <div class="col-md-1">
                    <label class="mb-0">Moneda</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Identificador del Equipo" value="{{ $row->name }}" required>
                </div>

            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-8">
                    <label class="mb-0">Producto Servicio</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Identificador del Equipo" value="{{ $row->name }}" required>
                </div>
                <a href="#"  data-toggle="modal" data-target="#exampleModal">
                    aaa
                </a>
            </div>
        </div>
        <div class="card-body border-top">
            <table class="table">
                <tr>
                    <td>DP</td>
                    <td>PRO</td>
                    <td>1</td>
                    <td>12.30</td>
                    <td>
                        <i class="far fa-edit"></i> |
                        <i class="far fa-trash-alt"></i>
                    </td>
                </tr>
            </table>
        </div>

    </div>
    {{-- MODALES --}}
    {{-- init / FormModalAddItems --}}
    <div class="modal" id="exampleModal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('corderline.store') }}" id="form-add-item" method="POST">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                <div class="modal-content">
                    <div class="modal-header">
                        <select name="typeproduct" id="typeproduct">
                            <option value="P">Producto</option>
                            <option value="S">Servicio</option>
                        </select>
                        <select name="" id="">
                            <option value="1">Operacion Grabada</option>
                            <option value="2">Operacion Inafecta</option>
                            <option value="3">Operacion Exonerada</option>
                        </select> 

                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div>
                            <input type="text" name="productcode" id="productcode" class="select2-product">
                            <select name="productname" id="productname" class="form-control select2-product"></select>
                        </div>
                        <div>
                            <textarea name="" name="servicename" id="servicename" cols="30" rows="3"></textarea>
                        </div>
                        <p>Modal body text goes here.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- fin / FormModalAddItems --}}
@endsection

@section('script')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script>

$(function(){
    let fai = $('#form-add-item');
    fai.submit(function (e) {
        e.preventDefault();
        $.ajax({
            type:fai.attr('method'),
            url: fai.attr('action'),
            data: fai.serialize(),
            success: function(data){
                console.log('add correcto');
            },
            error: function(data){
                console.log('error genero');
            },

        });
    });
    // Muestra el elemento de ADDITEMS
    $('#typeproduct').change(function(){
        if($(this).val() == 'P'){
            $('#productcode').show();
            $('#servicename').hide();
        }else{
            $('#productcode').hide();
            $('#servicename').show();
        }        
    })
    $('#servicename').hide();
    // Productos
    $('.select2-product').select2({
        ajax: {
            url: '{{ route('product_ajax') }}',
            dataType: 'json',
            type: "POST",
            // Additional AJAX parameters go here; see the end of this chapter for the full code of this example
        }
    });
});
</script>
@endsection

