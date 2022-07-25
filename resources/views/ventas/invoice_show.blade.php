 @extends('layouts.app')

@section('breadcrumb')
<section class="content-header pb-2">
    <div class="container-fluid">
        <div class="row mb-0">
            <div class="col-sm-6">
                <h1><i class="fas fa-edit fa-fw"></i> Comprobante de Venta</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item">Ventas</li>
                    <li class="breadcrumb-item">Comprobante de Venta</li>
                </ol>
            </div>
        </div>
    </div>
</section>

    <section class="content-header pt-1 pb-1">
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
                            <span class="d-none d-lg-inline-block">Actualizar</span>
                        </a>
                    </div>

                    <div class="btn-group">
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle dropdown-icon" data-toggle="dropdown"> 
                                <i class="fas fa-th-large fa-fw"></i>
                                  Accion 
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <div class="dropdown-menu" role="menu">
                                <a class="dropdown-item" href="#">Anular Comprobante</a>
                                <a class="dropdown-item" href="#">Elminar Comprobante</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#modal-create-credit"><i class="fas fa-copy fa-fw"></i> Emitir Nota de Credito</a>
                                <a class="dropdown-item" href="#" data-toggle="modal"
                                    data-target="#modal-create-debit"><i class="fas fa-copy fa-fw"></i> Emitir Nota de Debito</a>
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
    <div class="invoice p-3 mb-3">
        <div class="row invoice-info">
            <div class="col-12 col-md-6 invoice-col">
                <strong>Cliente:</strong>
                <p class="text-muted">
                    {{ $row->bpartner->bpartnername }}
                    <br>{{ $row->bpartner->bpartnercode }}
                </p>
            </div>
            <div class="col-6 col-md-3">
                <dl class="row mb-2">
                    <dt class="col-sm-5">Serie</dt>
                    <dd class="col-sm-7">{{ $row->serial }}-{{ $row->documentno }}</dd>
                    <dt class="col-sm-5">Moneda</dt>
                    <dd class="col-sm-7">{{ $row->currency->currencyiso }}</dd>
                    <dt class="col-sm-5">Condicion</dt>
                    <dd class="col-sm-7">CONTADO/CREDITO</dd>
                </dl>
            </div>
            <div class="col-6 col-md-3">
                <dl class="row mb-2">
                    <dt class="col-sm-5">Orden Ventas</dt>
                    <dd class="col-sm-7">{{ $row->order->serial }}-{{ $row->order->documentno }}</dd>
                    <dt class="col-sm-5">Emision</dt>
                    <dd class="col-sm-7">{{ \Carbon\Carbon::parse($row->dateinvoice)->format('d/m/Y') }}</dd>
                    <dt class="col-sm-5">Vencimiento</dt>
                    <dd class="col-sm-7">{{ \Carbon\Carbon::parse($row->dateinvoice)->format('d/m/Y') }}</dd>
                </dl>
            </div>
        </div>

        <div class="row">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-sm table-borderless mb-0">
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th class="d-none d-sm-inline-block">Codigo</th>
                            <th class="text-right">Cantidad</th>
                            <th class="d-none d-sm-inline-block">UM</th>
                            <th class="text-right">Precio</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($row->lines as $item)
                            <tr>
                                <td>{{ $item->description }}</td>
                                <td class="d-none d-sm-inline-block">{{ ($item->product_id) ? $item->product->productcode : '' }}</td>
                                <td class="text-right">{{ $item->quantity }}</td>
                                <td class="d-none d-sm-inline-block">{{ $item->um->shortname }}</td>
                                <td class="text-right">{{ number_format($item->priceunit,env('DECIMAL_AMOUNT',2)) }}</td>
                                <td class="text-right">{{ number_format($item->amountgrand,env('DECIMAL_AMOUNT',2)) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row border-top">
            <div class="col-6 col-md-8"></div>
            <div class="col-6 col-md-4">
                <div class="table-responsive">
                    <table class="table-sm" width="100%">
                        <tbody>
                            <tr>
                                <th>Total:</th>
                                <td class="text-right">{{ $row->currency->prefix }} {{ number_format($row->amountgrand,2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
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