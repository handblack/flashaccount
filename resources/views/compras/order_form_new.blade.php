@extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit fa-fw"></i> Ordenes de Compras</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Ventas</li>
                    <li class="breadcrumb-item">Ordenes de Compras</li>
                </ol>
            </div>
        </div>
    </div>
</section>

    <section class="content-header">
        <div class="container-fluid">
            <div class="d-flex justify-content-between">
                <div>
                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('corder.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-default" onclick="location.reload();">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">&nbsp;Actualizar</span>
                        </a>
                    </div>
                </div>
                <div>
                    <!--
                    <div class="btn-group">
                        <a href="#" class="btn btn-success btn-sm btn-add-product" onclick="edit_form_header();">
                            <i class="fas fa-plus-square fa-fw"></i>
                            <span class="d-none d-lg-inline-block">Agregar</span>   
                        </a>    
                    </div>
                    -->
                    <a href="#" class="btn btn-success btn-sm btn-add-product" data-toggle="modal" data-target="#ModalAddItem">
                        <i class="fas fa-plus-square fa-fw"></i>
                        <span class="d-none d-lg-inline-block">Agregar</span>    
                    </a>
                    <div class="btn-group">

                        <form action="{{ route('porder.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="mode" value="create">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save fa-fw"></i>
                                &nbsp;Procesar
                            </button>
                        </form>
                    </div>
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
        <div class="card-body pt-2 pb-2" id="doc-header">
            <div class="row">
                <div class="col-12 col-md-6">
                    {{ $row->bpartner->bpartnername }}
                </div>
                <div class="col-6 col-md-3">
                    <dl class="mb-0">
                        <dt>Fecha</dt>
                        <dd>{{ $row->datetrx }}</dd>
                    </dl>
                </div>
                <div class="col-6 col-md-3">
                    <dl class="mb-0">
                        <dt>Fecha</dt>
                        <dd>{{ $row->datetrx }}</dd>
                    </dl>
                </div>
                
            </div>
        </div>
        <div class="card-body border-bottom" id="doc-header-form" style="display: none;">
            <div class="row">
                <div class="col-md-6">
                    <label class="mb-0">Cliente</label>
                    <select name="bpartner_id" id="" class="form-control select2-bpartner">
                        <option value="{{ $row->bpartner_id }}">{{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="mb-0">Moneda</label>
                    <select name="currency_id" id="" class="form-control">
                        @foreach (auth()->user()->currency() as $item)
                            <option value="{{ $item->id }}">{{ $item->currencyiso }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="mb-0">Almacen</label>
                    <select name="warehouse_id" id="" class="form-control">
                        @foreach (auth()->user()->warehouse() as $item)
                            <option value="{{ $item->id }}">{{ $item->warehousename }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                    
                <div class="col-md-2">
                    <label class="mb-0">Emision</label>
                    <input type="date" name="dateinvoiced" value="{{ date("Y-m-d") }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="mb-0">Vence</label>
                    <input type="date" name="datedue" value="{{ date("Y-m-d") }}" class="form-control">
                </div>
                <div class="col-md-2">
                    <label class="mb-0">Contable</label>
                    <input type="date" name="dateacct" value="{{ date("Y-m-d") }}" class="form-control">
                </div>
                <div class="col-md-4">
                    <label class="mb-0">Serie</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <select name="sequence_id" class="form-control">
                                <option>F001</option>
                            </select>
                        </div>
                        <input type="text" class="form-control" placeholder="<NUEVO>" aria-describedby="basic-addon1">
                    </div>
                    
                </div> 
            </div>
            <div class="row mt-2">
                <div class="co-md-12">
                    <button class="btn btn-secondary btn-sm">Cancelar</button>
                    <button class="btn btn-primary btn-sm">Grabar</button>
                </div>
            </div>
        </div>
        <div class="card-body table-responsive p-0">
            <table class="table table-hover text-nowrap table-sm table-borderless mb-0" id="table-products">
                <thead style="font-size:0.8rem;">
                    <tr>
                        <th class="border-left console">PRODUCTO/SERVICIO</th>
                        <th width="70" class="d-none d-sm-table-cell console">CODIGO</th>
                        <th width="80" class="text-right border-left console">CANTIDAD</th>
                        <th width="80" class="  console">UM</th>
                        <th class="text-right border-left console">PRECIO</th>
                        <th class="text-right border-left console d-none d-sm-table-cell">SUB-TOTAL</th>
                        <th class="text-right border-left console d-none d-sm-table-cell">IGV</th>
                        <th class="text-right border-left console">TOTAL</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="d-none"></tr>  
                    @foreach ($row->lines as $item)
                        @include('ventas.order_form_list_item',['item' => $item])
                    @endforeach
                </tbody>
                <tfoot>
                    <tr class="border-top">
                        <th>{{ count($row->lines) }} - Item(s)</th>
                        <th class="d-none d-sm-table-cell">&nbsp;</td>
                        <th class="text-right">{{ $row->lines->sum('quantity') }}</th>
                        <th></th>
                        <th></th>
                        <th class="text-right d-none d-sm-table-cell">{{ number_format($row->lines->sum('amountbase'),env('DECIMAL_AMOUNT',2)) }}</th>
                        <th class="text-right d-none d-sm-table-cell">{{ number_format($row->lines->sum('amounttax'),env('DECIMAL_AMOUNT',2)) }}</th>
                        <th class="text-right">{{ number_format($row->lines->sum('amountgrand'),env('DECIMAL_AMOUNT',2)) }}</th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

<!-- MODAL -->
<div class="modal" id="ModalAddItem"  role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    @include('compras.order_form_additem')
</div>
@endsection



@section('script')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('plugins/jquery-number/jquery.number.min.js') }}"></script>
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

    // Muestra el elemento de ADDITEMS
    $('#typeproduct').change(function(){
        if($(this).val() == 'P'){
            $('#productcode').show();
            //$('#product_id').attr('required', true);
            $('#servicename').hide();
            $('#servicename2').attr('required', false);
            $('#um_id').prop( "disabled", true);
        }else{
            $('#productcode').hide();
            //$('#product_id').attr('required', false);
            $('#servicename').show();
            $('#servicename2').attr('required', true);
            $('#um_id').prop( "disabled", false);
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
                    t:'C',
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

    
    $('#quantity,#priceunit,#afecto').on('change keyup', function() {
        item_calculate();
    }); 

    $('#servicename').hide();
});

function edit_item(t){
    let id = $(t).data('id');
    let url = $(t).data('url');
    $.get(url,function(data){
        $('#mode').val('item-edit');
        $('#line_id').val(data.item.id);       
        $("#typeproduct").val(data.item.typeproduct).change();
        $('#package').val(data.item.package);
        $('#quantity').val(data.item.quantity);
        $('#priceunit').val(data.item.priceunit);
        if(data.item.typeproduct == 'P'){
            if ($('#product_id').find("option[value='" + data.item.product_id + "']").length) {
                $('#product_id').val(data.item.product_id).trigger('change');
            } else { 
                var newOption = new Option(data.item.productcode + ' - ' + data.item.description, data.item.product_id, true, true);
                $('#product_id').append(newOption).trigger('change');
            } 
        }else{
            $('#servicename2').val(data.item.description)
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
        $.post(url,{_method:'delete'})
        .done(function(data){
            if(data.status == 100){
                $('#tr-'+data.id).remove();
                toastr.success('Elemento eliminado');
            }else{
                toastr.error(data.message);
            }
        });
    }
    
}

function edit_form_header(){
    $('#doc-header').hide();
    $('#doc-header-form').show();
}

function item_calculate(){
    let fig = 18;
    let qt = $('#quantity').val();
    let tp = $('#afecto').val();
    let pu = $('#priceunit').val();
    let itst = 0;
    let itig = 0;
    let pu_ = 0;
    if(tp == 'C'){
        pu_ = pu / ((fig /100) + 1 );
        //itst = pu_ * qt;
        console.log('con igv ' + pu_);
    }else{
        pu_ = pu;
    }
    itst = pu_ * qt;
    itig = (itst * fig) /100 ;
    console.log(qt);
    console.log(pu);
    console.log(tp);
    $('.it-subtotal').val($.number(itst,{{ env('DECIMAL_AMOUNT',2) }},'.', ','));
    $('.it-igv').val($.number(itig,{{ env('DECIMAL_AMOUNT',2) }},'.', ','));
    $('.it-total').val($.number(itst + itig,{{ env('DECIMAL_AMOUNT',2) }},'.', ','));
}

</script>
@endsection
