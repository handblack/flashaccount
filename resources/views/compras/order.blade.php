@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endsection

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-6">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('porder.index') }}" title="Recargar">
                            <i class="fas fa-redo" aria-hidden="true"></i>
                        </a>
                    </div>
 
                    <a href="#" class="btn btn-sm btn-success" data-toggle="modal" data-target="#ModalCreate" >
                        <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Nueva OC</span>
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
                            Orden de Compra
                            &nbsp;
                            <i class="nav-icon fas fa-dolly fa-fw"></i>

                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('container')
    <div class="card">
        <div class="card-body  p-0">
            <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Numero</th>
                        <th>CodigoSN</th>
                        <th>Socio de Negocio</th>
                        <th class="text-right pr-2">Importe</th>
                        <th>Almacen</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr>
                            <td width="110">{{ $item->dateorder }}</td>
                            <td>
                                <a href="{{ route('corder.show',$item->token) }}">
                                    {{ $item->serial }}-{{ $item->documentno }} 
                                </a>
                                {{ $item->docstatus }}
                            </td>
                            <td width="115">{{ $item->bpartner->bpartnercode }}</td>
                            <td width="110">{{ $item->bpartner->bpartnername }}</td>
                            <td class="text-right pr-2 border-left border-right">
                                {{ number_format($item->amount, 2) }} {{ $item->currency->currencyiso }}
                            </td>
                            <td>{{ $item->warehouse->shortname }}</td>

                            <td class="text-right">
                                @if($grant->isdelete == 'Y')
                                    <a href="{{ route('corder.edit', [$item->token]) }}"> 
                                        <i class="fas fa-edit"></i>
                                        Modificar
                                    </a>
                                @else
                                    <i class="fas fa-trash-alt fa-fw"></i>
                                @endif
                                |
                                @if($grant->isdelete == 'Y')
                                    <a class="delete-record" 
                                        data-url="{{ route('corder.destroy', $item->token) }}"
                                        data-id="{{ $item->id }}">
                                        <i class="fas fa-trash-alt fa-fw"></i>
                                    </a>
                                @else
                                    <i class="fas fa-trash-alt fa-fw"></i>
                                @endif

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay Orden de Compra</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12 pt-2">
            {{ $result->links('layouts.paginate') }}
        </div>
    </div>

    {{-- MODALES --}}
    <!-- NUEVO -->
    <div class="modal fade" id="ModalCreate" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form action="{{ route('porder.store') }}" method="POST" id="form-create">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Crear nueva Orden de Compra</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body" style="background-color:#dcdcdc74;">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="mb-0">Serie</label>
                                <select name="sequence_id" class="form-control" required>
                                    <option value="" selected disabled>-- SELECCIONA --</option>
                                    @foreach (auth()->user()->sequence('OVE') as $item)
                                        <option value="{{ $item->id }}">{{ $item->serial . ' - ' . $item->doctype->doctypename }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-10">
                                <label class="mb-0">Socio de Negocio</label>
                                <select name="bpartner_id" class="form-control select2-bpartner" required></select>
                            </div>
                            <div class="col-md-2">
                                <label class="mb-0">Moneda</label>
                                <select name="currency_id" class="form-control" required>
                                    @foreach (auth()->user()->currency() as $item)
                                        <option value="{{ $item->id }}">{{ $item->currencyname }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="col-md-6">
                                <label class="mb-0">Almacen</label>
                                <select class="form-control" name="warehouse_id" required>
                                    <option value="" disabled selected>-- SELECCIONA --</option>
                                    @foreach (auth()->user()->warehouse() as $item)
                                        <option value="{{ $item->id }}">{{ $item->warehousename }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-3">
                                <label class="mb-0">Fecha Emision</label>
                                <input type="date" name="datetrx" value="{{ date("Y-m-d") }}" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <label class="mb-0">Tipo de Cambio</label>
                                <input type="text" name="rate" class="form-control text-right text-monospace" value="1.000" maxlength="5" required>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Iniciar</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <!-- ANULAR -->
    <div class="modal fade" id="ModalCancelDocument" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Anular Orden de Venta</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p class="lead">Estas seguro en Anular la Orden de Venta?</p>
                    <p>Este proceso libera stock retenido del sistema.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary">Anular</button>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('script')
<script src="{{ asset('plugins/select2/js/select2.min.js') }}"></script>
<script>
$(function(){
    // PaymentModal
    let fai = $('#form-create');
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
                    t:'P',
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