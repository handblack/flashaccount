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
                <h1><i class="fas fa-edit fa-fw"></i> Transferencias</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Logistica</li>
                    <li class="breadcrumb-item">Transferencias</li>
                </ol>
            </div>
        </div>
    </div>
</section>
    <section class="content-header pt-1 pb-1">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-5">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('ltransfer.index') }}" title="Recargar">
                            <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-sm-inline-block">Actualizar</span>
                        </a>
                    </div>

                    <a class="btn btn-sm btn-success" href="#" data-toggle="modal" data-target="#ModalCreate">
                        <i class="fas fa-plus fa-fw" aria-hidden="true"></i>
                        <span class="d-none d-sm-inline-block">Nueva Transferencia</span>
                    </a>
                    

                </div>
                <div class="col-sm-7">
                     
                </div>
            </div>
        </div>
    </section>


    
@endsection

@section('container')
    <div class="card mb-0">
        <div class="card-body p-0">
            <table class="table table-hover text-nowrap table-sm table-borderless mb-0">
                <thead>
                    <tr>
                        <th width="100">FECHA</th>
                        <th>DOCUMENTO</th>
                        <th>ALMACEN</th>
                        <th>GLOSA</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($result as $item)
                        <tr>
                            <td width="100">{{ $item->datetrx }}</td>
                            <td width="110">{{ $item->serial }}-{{ $item->documentno }}</td>                            
                            <td>{{ $item->warehouse->shortname }} <i class="fas fa-random fa-fw"></i>  {{ $item->warehouseto->shortname }}</td>
                            <td>{{ $item->glosa }}</td>
                            <td class="text-right">
                                <a href="{{ route('ltransfer.show',$item->token) }}"><i class="far fa-file-alt fa-fw"></i> Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10">No hay registros</td>
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
            <form action="{{ route('ltransfer.store') }}" method="POST" id="form-logistic-input">
                @csrf
                <input type="hidden" name="mode" value="temp">
                <div class="modal-content">
                    <div class="modal-header pt-2 pb-2">
                        <h5 class="modal-title" id="exampleModalLabel">TRANSFERENCIA</h5>
                        <div class="card-tools float-sm-right">
                            <div class="btn-group">
                                <select name="sequence_id" class="form-control form-control-sm" required>
                                    <option value="" selected disabled>-- SELECCION --</option>
                                    @foreach (auth()->user()->sequence('LTR') as $item)
                                        <option value="{{ $item->id }}">{{ $item->serial .'-'.$item->doctype->doctypename }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="btn-group">
                                <div class="input-group input-group-sm">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i class="fas fa-calendar-alt fa-fw"></i> Emision
                                        </span>
                                    </div>
                                    <input type="date" name="datetrx" value="{{ date("Y-m-d") }}" class="form-control" required style="width:120px;">
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                    <div class="modal-body" style="background-color:#dcdcdc74;">
                        <div class="row">
                            <div class="col-md-6">
                                <label class="mb-0">Almacen Origen</label>
                                <select name="warehouse_id" class="form-control" required>
                                    <option value="" selected disabled>-- SELECCION --</option>
                                    @foreach (auth()->user()->warehouse() as $item)
                                        <option value="{{ $item->id }}">{{ $item->warehousename }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="mb-0">Almacen Destino</label>
                                <select name="warehouse_to_id" class="form-control" required>
                                    <option value="" selected disabled>-- SELECCION --</option>
                                    @foreach (auth()->user()->warehouse() as $item)
                                        <option value="{{ $item->id }}">{{ $item->warehousename }}</option>
                                    @endforeach
                                </select>
                            </div>                          
                        </div>
                        
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="mb-0">Motivo</label>
                                <select name="reason_id" class="form-control" required>
                                    @foreach ($reason as $item)
                                        <option value="{{ $item->id }}">{{ $item->reasonname }}</option>
                                    @endforeach
                                </select>
                            </div>                           
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="mb-0">Glosa</label>
                                <input type="text" name="glosa" class="form-control">
                            </div>                           
                        </div>
                    </div>
                    <div class="modal-footer p-1">
                        <div class="row w-100">
                            <div class="col-md-6">
                                <div class="btn-group">
                                    <button type="reset" class="btn btn-default"><i class="fas fa-window-close fa-fw"></i> Limpiar</button>                                 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="float-right">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                                    <button type="submit" class="btn btn-primary"><i class="fas fa-check fa-fw"></i> Iniciar</button>
                                </div>
                            </div>
                        </div>
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
    // PaymentModal
    let fai = $('#form-logistic-input');
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
