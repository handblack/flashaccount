@extends('layouts.app')

@section('breadcrumb')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-0">
                <div class="col-sm-4">

                    <div class="btn-group">
                        <a class="btn btn-sm btn-secondary" href="{{ route('cinvoice.index') }}" title="Recargar">
                            <i class="fas fa-list fa-fw" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline-block">Todos</span>
                        </a>
                        <a href="#" class="btn btn-sm btn-default" onclick="location.reload();">
                            <i class="fas fa-redo fa-fw" aria-hidden="true"></i>
                        </a>
                    </div>

                    <div class="btn-group">
                        <div class="btn-group">
                            <button type="button" class="btn btn-secondary btn-sm dropdown-toggle dropdown-icon"
                                data-toggle="dropdown">
                                Opciones&nbsp;&nbsp;
                                <span class="sr-only">Toggle Dropdown</span>

                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="#">Anular Comprobante</a>
                                <a class="dropdown-item" href="#">Elminar Comprobante</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#modal-create-credit"><i class="fas fa-copy fa-fw"></i> Copiar Nota de Credito (devolucion)</a>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('cinvoice.show', 'pdf') }}" class="btn btn-default btn-sm">
                        <i class="fas fa-download fa-fw"></i> PDF
                    </a>

                </div>
                <div class="col-sm-8">
                    <div class="float-sm-right">
                        <h1 class="h4 mb-0 d-none d-md-inline-block">
                            Ventas / Comprobante de Venta
                            &nbsp;
                            <i class="fas fa-cash-register fa-fw"></i>
                        </h1>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('container')
    <div class="card">
        {{ $row->bpartner->bpartnercode }} - {{ $row->bpartner->bpartnername }}
        <table class="table table-sm">
            <tbody>
                @foreach ($row->lines as $item)
                    <tr>
                        <td>{{ $item->typeproduct == 'P' ? $item->product->productcode : '' }}</td>
                        <td>{{ $item->description }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->um->shortname }}</td>
                        <td>{{ $item->package }}</td>
                        <td>{{ number_format($item->amountgrand, env('DECIMAL_AMOUNT', 2)) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>


    <!-- Modal -->
    <div class="modal fade" id="modal-create-credit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="{{ route('ccredit.store') }}" method="POST" id="form-create-credit">
                @csrf
                <input type="hidden" name="mode" value="temp">
                <input type="hidden" name="invoice_id" value="{{ $row->id }}">
                <input type="hidden" name="bpartner_id" value="{{ $row->bpartner_id }}">
                <input type="hidden" name="ref_datetrx" value="{{ $row->dateinvoiced }}">
                <input type="hidden" name="ref_sequence_id" value="{{ $row->sequence_id }}">
                <input type="hidden" name="ref_doctype_id" value="{{ $row->doctype_id }}">
                <input type="hidden" name="ref_serial" value="{{ $row->serial }}">
                <input type="hidden" name="ref_documentno" value="{{ $row->documentno }}">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title" id="exampleModalLabel">Emitir Nota de Credito</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <label class="mb-0">Documento de Referencia</label>
                                <span class="form-control disable bg-light"><strong>{{ $row->serial }}-{{ $row->documentno }}</strong> / {{ $row->doctype->doctypename }}</span>
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-8">
                                <label class="mb-0">Serie (Nota de Credito)</label>
                                <div class="input-group mb-0">
                                    <div class="input-group-prepend pr-1">
                                        <select name="sequence_id" class="form-control console" required="" style="width:80px;">
                                            <option value="" selected="" disabled="">----</option>
                                            @foreach (auth()->user()->sequence('NCR') as $item)
                                                <option value="{{ $item->id }}">{{ $item->serial }} / {{ $item->doctype->doctypename }} &nbsp;&nbsp;</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <input type="text" name="documentno" class="form-control console" placeholder="<automatico>" aria-describedby="basic-addon1">
                                </div>
                                
                            </div>
                            <div class="col-md-4">
                                <label class="mb-0">Fecha Emision</label>
                                <input type="date" name="datecredit" value="{{ date("Y-m-d") }}" class="form-control">
                            </div>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-12">
                                <label class="mb-0">Motivo (Catalogo 09)</label>
                                <select name="warehouse_id" class="form-control console" required="">
                                    <option value="" selected="" disabled="">-- SELECCION --</option>    
                                    @foreach (auth()->user()->parameter(7) as $item)
                                        <option value="{{ $item->id }}">{{ $item->value }} - {{ $item->identity }}</option>
                                    @endforeach                          
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer bg-light">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times fa-fw"></i> Cancelar</button>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-copy fa-fw"></i> Copiar a Nota de Credito</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
     
@endsection

@section('script')
<script>
$(function(){

    let fai = $('#form-create-credit');
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
});
</script>
@endsection