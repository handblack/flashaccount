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
                    <div class="row">
                        <div class="col-md-12">
                            <div class="float-sm-right">
                                <h1 class="h4 mb-0 d-none d-md-inline-block">
                                    Orden de Venta
                                    &nbsp;
                                    <i class="fas fa-edit fa-fw"></i>
                                </h1>
                                
                            </div>
                        </div>
                    </div>
                    <div class="row">

                        <div class="col-md-12">
                            <div class="float-sm-right">
                                <div class="btn-group">
                                    <select name="" id="" class="form-control">
                                        <option value="">F001</option>                                
                                    </select>
                                </div>
                                <div class="btn-group">                            
                                    <input type="text" class="form-control">
                                </div>
                                <div class="btn-group">                            
                                    <input type="date" class="form-control">
                                </div>
                            </div>
                        </div>
                    
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

                <div class="col-md-8 col-sm-12">
                    <label class="mb-0">Socio de Negocio</label>
                    <select class="form-control select2-bpartner">
                    </select>
                
                </div>
                <div class="col-md-3 col-sm-6">
                    <label class="mb-0">Codigo</label>
                    <input type="text" class="form-control" id="name" name="name"
                        placeholder="Identificador del Equipo" value="{{ $row->name }}" required>
                </div>
                <div class="col-md-1 col-sm-6">
                    <label class="mb-0">Moneda</label>
                    <select name="currency_id" class="form-control">
                        @foreach ($currency as $item)
                            <option value="{{ $item->id }}">{{ $item->currencyname }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>
        <div class="card-body pt-1 pb-1 bg-light ">
            <div class="row">
                <div class="col-md-6">
                    
                </div>
                <div class="col-md-6">
                    <div class="float-sm-right mt-1">

                        <div class="btn-group">
                            <a href="#" class="btn btn-success btn-sm" data-toggle="modal" data-target="#ModalAddItem">
                                <i class="fas fa-plus-square fa-fw"></i>
                                Agregar Item
                            </a>    
                        </div>
                        <div class="btn-group">
                            <a href="#" class="btn btn-primary btn-sm">
                                <i class="fas fa-save fa-fw"></i>
                                Procesar
                            </a>
                        </div>    
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0 border-top">
            <table class="table table-hover text-nowrap table-sm table-borderless mb-0" id="table-order-items">
                <thead>
                    <tr class="border-bottom bg-secondary">
                        <th width="100">Codigo</th>
                        <th class="border-left">Producto/Servicio</th>
                        <th width="80" class="text-right border-left">Cantidad</th>
                        <th width="80" class="text-right border-left">UM</th>
                        <th class="border-left">Precio</th>
                        <th class="border-left">SubTotal</th>
                        <th class="border-left">IGV</th>
                        <th class="border-left">TOTAL</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="d-none"></tr>     
                    @forelse ($lines as $item)
                        @include('ventas.order_form_list_item',['item'=>$item])                        
                    @empty
                        <!-- No hay ITEMS -->
                    @endforelse
                </tbody>                
            </table>
        </div>
        <div class="card-body border-top" id="order-items-totales">
            @include('ventas.order_form_list_total',['lines'=>$lines])
        </div>
    </div>
    {{-- MODALES --}}
    @include('ventas.order_form_additem')
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
                if(data.status == '100'){
                    
                    $("#ModalAddItem").modal('hide');
                    console.log(data.tr_item);
                    //$('#table-order-items tbody tr:last').after(data.tr_item);
                    //$('#table-order-items tbody tr').last().before(data.tr_item);   
                    //$('#table-order-items tbody').last().before(data.tr_item);   
                    $('#table-order-items tbody tr').last().after(data.tr_item);   
                    $('#order-items-totales').html(data.tr_total);
                    //$('#table-order-items tbody').last(data.tr_item);   
                    //$('#table-order-items tbody tr').last(data.tr_item);   
                    //$('#table-order-items tbody tr:last').after('<tr><td>aaa</td></tr>');
                    toastr.success(data.message);
                    $(this).trigger("reset");
                }else{
                    toastr.error(data.message);
                }
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
    
    // SocioNegocio
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
    // Productos
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

    @if(!$lines)
        $("#ModalAddItem").modal('show');
    @endif
    $('#servicename').hide();
});

function delete_item(t){     
    if (confirm('Estas seguro en eliminar?')) {
        let id = $(t).data('id');
        let url = $(t).data('url');
        console.log(id);
        console.log(url);
        $.post(url,{_method:'delete'})
        .done(function(data){
            if(data.status == 100){
                $('#tr-'+id).remove();
                toastr.success('Elemento eliminado');
            }else{
                toastr.error(data.message);
            }
        });
    }
    
}
</script>
@endsection

