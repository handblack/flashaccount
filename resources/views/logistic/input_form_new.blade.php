@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="far fa-file-alt fa-fw"></i> Ingreso</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Logistica</li>
                    <li class="breadcrumb-item">Ingresos</li>
                </ol>
            </div>
        </div>
    </div>
</section>
<section class="content-header pt-1 pb-2">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-4">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('linput.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-default" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Actualizar</span>
                        </a>
                    </div>
                   
                </div>
                <div class="col-sm-8">
                     
                </div>
            </div>
        </div>
    </section>
@endsection

@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection


@section('container')
    <div class="card">
        <div class="card-header">
            <div class="card-title">
                <ul class="nav nav-tabs card-header-tabs ">
                    <li class="nav-item">
                        <span class="nav-link active">
                            <i class="far fa-edit fa-fw"></i>
                            <span class="d-none d-sm-inline-block">
                                Parte INGRESO
                            </span>
                        </span>
                    </li>
                </ul>
            </div>
            <div class="card-tools">
                <form action="{{ route('linput.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="mode" value="create">
                    <ul class="nav">
                        <li>                        
                            <div class="card-tools pull-right">
                                <a href="#" class="btn btn-success btn-sm btn-add-product" data-toggle="modal" data-target="#ModalAddItem">
                                    <i class="fas fa-plus-square fa-fw"></i>
                                    &nbsp;Agregar    
                                </a>
                                <button type="submit" class="btn btn-primary btn-sm">
                                    <i class="fas fa-save fa-fw"></i>
                                    &nbsp;Procesar
                                </button>
                            </div>
                        </li>
                    </ul>
                </form>
            </div>
        </div>
        <div class="card-body border-bottom">
            <div class="row">
                <div class="col-md-5">
                    <dl class="mb-0">
                        <dt>Proveedor</dt>
                        <dd>{{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}</dd>
                        <dd>
                            {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->address : '_FALTA_ESPECIFICAR_DIRECCION_' }}
                        </dd>
                        <dd>
                            {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->state->statename : '' }} - 
                            {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->county->countyname : '' }} - 
                            {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->city->cityname : '' }}
                        </dd>
                        <dd>
                            {{ ($row->bpartner->address_fiscal) ? $row->bpartner->address_fiscal->country->countryname : '' }}
                        </dd>
                        <dd>{{ $row->glosa }}</dd>
                    </dl>
                </div>
                
                <div class="col-4">
                    <dl class="mb-0">
                        <dt>Almacen INGRESO</dt>
                        <dd>{{ $row->warehouse->warehousename }}</dd>
                        <dd>{{ $row->warehouse->address->address }}</dd>                        
                        <dt>Motivo</dt>
                        <dd>{{ $row->reason->reasonname }}</dd>
                    </dl>
                </div>
                <div class="col-md-3">
                    <dl class="row">
                        <dt class="col-sm-4">OC</dt>
                        <dd class="col-sm-8">{{ ($row->order_id) ? $row->order->serial .'-'.$row->order->documentno : '_SIN_OC_' }}</dd>
                        <dt class="col-sm-4">Serie</dt>
                        <dd class="col-sm-8">{{ $row->sequence->serial }}</dd>
                        <dt class="col-sm-4">Fecha</dt>
                        <dd class="col-sm-8">{{ $row->datetrx }}</dd>
                    </dl>
                </div>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover text-nowrap table-sm table-borderless mb-0" id="table-products">
                <thead>
                    <tr>
                        <th width="100">Codigo</th>
                        <th>Producto</th>
                        <th width="100" class="text-right">Cantidad</th>
                        <th width="30">UM</th>
                        <th width="100" class="text-right">PACK</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="d-none"></tr>  
                    @foreach ($row->lines as $item)
                        @include('logistic.input_form_list_item',['item' => $item])
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-top">
                        <th coslpan="2">{{ count($row->lines) }} - Items</th>
                        <td class="text-right"></td>
                        <td></td>
                        <td class="text-right"></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

<!-- MODAL -->
<div class="modal" id="ModalAddItem"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    @include('logistic.input_form_additem')
</div>
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
                    $('#order-items-totales').html(data.tr_total);
                    if(data.modeline == 'edit'){
                        $('#tr-' + data.item.id).replaceWith(data.tr_item);   
                    }else{
                        $('#table-products tbody tr').last().after(data.tr_item);   
                    }
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
    $('.btn-add-product').click(function(){
        $('#mode').val('item-add');
        $('#package').val('');
        $('#quantity').val('');
        $('.select2-product').val('').trigger('change');
    });
    
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
                    t:'P',
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

    $('#servicename').hide();
});

function edit_item(t){
    let id = $(t).data('id');
    let url = $(t).data('url');
    $.get(url,function(data){
        $('#mode').val('item-edit');
        $('#line_id').val(data.item.id);       
        $('#package').val(data.item.package);
        $('#quantity').val(data.item.quantity);
        if ($('#product_id').find("option[value='" + data.item.product_id + "']").length) {
            $('#product_id').val(data.item.product_id).trigger('change');
        } else { 
            var newOption = new Option(data.product, data.item.product_id, true, true);
            $('#product_id').append(newOption).trigger('change');
        } 
    });    
    $('#ModalAddItem').modal('show');
}

function close_modal_item(){
    $('#ModalAddItem').modal('hide');
    $('#modeline').val('new');
}

function delete_item(t){     
    if (confirm('Estas seguro en eliminar?')) {
        let id = $(t).data('id');
        let url = $(t).data('url');
        console.log(id);
        console.log(url);
        $.post(url,{_method:'delete'})
        .done(function(data){
            console.log(data);
            if(data.status == 100){
                $('#tr-'+data.id).remove();
                console.log('#tr-'+id);
                toastr.success('Elemento eliminado');
                console.log('if');
            }else{
                console.log('else');
                toastr.error(data.message);
            }
        });
    }
    
}
</script>
@endsection
